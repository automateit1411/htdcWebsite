<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ExternalApiService
{
    protected $baseUrl;
    protected $secretKey;
    protected $cacheDuration;

    public function __construct()
    {
        $this->baseUrl = config('services.external_api.base_url');
        $this->secretKey = config('services.external_api.secret_key');
        $this->cacheDuration = 3600; // 1 hour cache
    }

    protected function apiHeaders()
    {
        return [
            'X-API-Key' => $this->secretKey,
            'Accept' => 'application/json',
        ];
    }

    /**
     * Make cached API request - reduces server load dramatically
     * 3000 students = 0 external API calls (all cached)
     */
    protected function cachedRequest($cacheKey, $url, $timeout = 5)
    {
        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($url, $timeout) {
            try {
                Log::info("Cache MISS - Fetching from API: " . $url);
                $response = Http::timeout($timeout)->withHeaders($this->apiHeaders())->get($url);
                if ($response->successful()) {
                    return $response->json();
                }
                Log::error("API returned non-successful status: " . $response->status());
            } catch (\Exception $e) {
                Log::error("API Connection Error to " . $url . ": " . $e->getMessage());
            }
            return null;
        });
    }

    /**
     * Clear all API caches (use when external data changes)
     */
    public function clearCache()
    {
        $keys = [
            'api_programs',
            'api_sessions',
            'api_occupations',
            'api_qualifications',
            'api_districts',
            'api_boards',
            'api_constants',
        ];
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    public function getPrograms()
    {
        $url = rtrim($this->baseUrl, '/') . '/api/programs/admission/';
        return $this->cachedRequest('api_programs', $url) ?? ['error' => 'connection_failed'];
    }

    public function getAdmissionSessions()
    {
        $url = rtrim($this->baseUrl, '/') . '/api/sessions/admission/';
        return $this->cachedRequest('api_sessions', $url) ?? ['error' => 'connection_failed'];
    }

    public function getAllSessions()
    {
        return [];
    }

    public function getGroups($programId = null)
    {
        if (!$programId) {
            return [];
        }
        
        $cacheKey = 'api_groups_' . $programId;
        $url = rtrim($this->baseUrl, '/') . '/api/groups/program/' . $programId . '/';
        return $this->cachedRequest($cacheKey, $url) ?? ['error' => 'connection_failed'];
    }

    public function getOccupations()
    {
        $url = rtrim($this->baseUrl, '/') . '/api/occupations/all/';
        return $this->cachedRequest('api_occupations', $url) ?? [];
    }

    public function getQualifications()
    {
        $url = rtrim($this->baseUrl, '/') . '/api/qualifications/all/';
        return $this->cachedRequest('api_qualifications', $url) ?? [];
    }

    public function getDistricts()
    {
        $url = rtrim($this->baseUrl, '/') . '/api/districts/all/';
        return $this->cachedRequest('api_districts', $url) ?? [];
    }

    public function getBoards()
    {
        $url = rtrim($this->baseUrl, '/') . '/api/boards/all/';
        return $this->cachedRequest('api_boards', $url) ?? [];
    }

    public function getConstants()
    {
        $url = rtrim($this->baseUrl, '/') . '/api/constants/';
        return $this->cachedRequest('api_constants', $url) ?? [];
    }

    public function getHscCourses($programId, $groupId)
    {
        $cacheKey = 'api_hsc_courses_' . $programId . '_' . $groupId;
        $url = rtrim($this->baseUrl, '/') . "/api/hsc/courses/program/{$programId}/group/{$groupId}/";
        return $this->cachedRequest($cacheKey, $url) ?? [];
    }

    public function getEmployees($type = 'teacher')
    {
        $cacheKey = 'api_employees_' . $type;
        $url = rtrim($this->baseUrl, '/') . "/employees/api/{$type}/";
        return $this->cachedRequest($cacheKey, $url, 10) ?? [];
    }

    public function getDailyAttendance($date = null)
    {
        $date = $date ?? now()->toDateString();
        $cacheKey = 'api_attendance_' . $date;
        $url = rtrim($this->baseUrl, '/') . "/api/daily-attendance/?date=" . $date;
        return $this->cachedRequest($cacheKey, $url, 10) ?? ['error' => 'connection_failed'];
    }

    public function storeDailyAttendance($data)
    {
        try {
            $url = rtrim($this->baseUrl, '/') . "/api/daily-attendance/";
            Log::info("Storing daily attendance to: " . $url);
            $response = Http::timeout(10)->withHeaders($this->apiHeaders())->post($url, $data);
            if ($response->successful()) {
                Log::info("Daily Attendance Store Response: " . json_encode($response->json()));
                return $response->json();
            }
            Log::error("API returned non-successful status (Store Daily Attendance): " . $response->status());
        } catch (\Exception $e) {
            Log::error("API Connection Error (Store Daily Attendance) to " . $url . ": " . $e->getMessage());
        }
        return ['error' => 'connection_failed'];
    }

    public function getStudentStatistics()
    {
        $url = rtrim($this->baseUrl, '/') . '/api/student-statistics/';
        return $this->cachedRequest('api_student_statistics', $url, 10) ?? ['error' => 'connection_failed'];
    }
}
