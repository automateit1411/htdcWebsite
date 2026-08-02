<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ExternalApiService
{
    protected $baseUrl;
    protected $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('services.external_api.base_url');
        $this->secretKey = config('services.external_api.secret_key');
    }

    protected function apiHeaders()
    {
        return [
            'X-API-Key' => $this->secretKey,
            'Accept' => 'application/json',
        ];
    }

    public function getPrograms()
    {
        // For debugging purposes, we'll bypass the cache
        try {
            $url = rtrim($this->baseUrl, '/') . '/api/programs/admission/';
            Log::info("Fetching programs from: " . $url);
            $response = Http::timeout(5)->withHeaders($this->apiHeaders())->get($url);
            if ($response->successful()) {
                Log::info("Programs API Response: " . json_encode($response->json()));
                return $response->json();
            }
            Log::error("API returned non-successful status: " . $response->status());
        } catch (\Exception $e) {
            Log::error("API Connection Error (Programs) to " . $url . ": " . $e->getMessage());
        }
        return ['error' => 'connection_failed'];
    }

    public function getAdmissionSessions()
    {
        try {
            $url = rtrim($this->baseUrl, '/') . '/api/sessions/admission/';
            Log::info("Fetching admission sessions from: " . $url);
            $response = Http::timeout(5)->withHeaders($this->apiHeaders())->get($url);
            if ($response->successful()) {
                Log::info("Admission Sessions API Response: " . json_encode($response->json()));
                return $response->json();
            }
            Log::error("API returned non-successful status (Admission Sessions): " . $response->status());
        } catch (\Exception $e) {
            Log::error("API Connection Error (Admission Sessions) to " . $url . ": " . $e->getMessage());
        }
        return ['error' => 'connection_failed'];
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
        
        try {
            $url = rtrim($this->baseUrl, '/') . '/api/groups/program/' . $programId . '/';
            Log::info("Fetching groups for program {$programId} from: " . $url);
            $response = Http::timeout(5)->withHeaders($this->apiHeaders())->get($url);
            if ($response->successful()) {
                Log::info("Groups API Response (Program {$programId}): " . json_encode($response->json()));
                return $response->json();
            }
            Log::error("API returned non-successful status (Groups): " . $response->status());
        } catch (\Exception $e) {
            Log::error("API Connection Error (Groups) to " . $url . ": " . $e->getMessage());
        }
        return ['error' => 'connection_failed'];
    }

    public function getOccupations()
    {
        try {
            $url = rtrim($this->baseUrl, '/') . '/api/occupations/all/';
            Log::info("Fetching occupations from: " . $url);
            $response = Http::timeout(5)->withHeaders($this->apiHeaders())->get($url);
            if ($response->successful()) {
                Log::info("Occupations API Response: " . json_encode($response->json()));
                return $response->json();
            }
            Log::error("API returned non-successful status (Occupations): " . $response->status());
        } catch (\Exception $e) {
            Log::error("API Connection Error (Occupations) to " . $url . ": " . $e->getMessage());
        }
        return [];
    }

    public function getQualifications()
    {
        try {
            $url = rtrim($this->baseUrl, '/') . '/api/qualifications/all/';
            Log::info("Fetching qualifications from: " . $url);
            $response = Http::timeout(5)->withHeaders($this->apiHeaders())->get($url);
            if ($response->successful()) {
                Log::info("Qualifications API Response: " . json_encode($response->json()));
                return $response->json();
            }
            Log::error("API returned non-successful status (Qualifications): " . $response->status());
        } catch (\Exception $e) {
            Log::error("API Connection Error (Qualifications) to " . $url . ": " . $e->getMessage());
        }
        return [];
    }

    public function getDistricts()
    {
        try {
            $url = rtrim($this->baseUrl, '/') . '/api/districts/all/';
            Log::info("Fetching districts from: " . $url);
            $response = Http::timeout(5)->withHeaders($this->apiHeaders())->get($url);
            if ($response->successful()) {
                Log::info("Districts API Response: " . json_encode($response->json()));
                return $response->json();
            }
            Log::error("API returned non-successful status (Districts): " . $response->status());
        } catch (\Exception $e) {
            Log::error("API Connection Error (Districts) to " . $url . ": " . $e->getMessage());
        }
        return [];
    }

    public function getBoards()
    {
        try {
            $url = rtrim($this->baseUrl, '/') . '/api/boards/all/';
            Log::info("Fetching boards from: " . $url);
            $response = Http::timeout(5)->withHeaders($this->apiHeaders())->get($url);
            if ($response->successful()) {
                Log::info("Boards API Response: " . json_encode($response->json()));
                return $response->json();
            }
            Log::error("API returned non-successful status (Boards): " . $response->status());
        } catch (\Exception $e) {
            Log::error("API Connection Error (Boards) to " . $url . ": " . $e->getMessage());
        }
        return [];
    }

    public function getConstants()
    {
        try {
            $url = rtrim($this->baseUrl, '/') . '/api/constants/';
            Log::info("Fetching constants from: " . $url);
            $response = Http::timeout(5)->withHeaders($this->apiHeaders())->get($url);
            if ($response->successful()) {
                Log::info("Constants API Response: " . json_encode($response->json()));
                return $response->json();
            }
            Log::error("API returned non-successful status (Constants): " . $response->status());
        } catch (\Exception $e) {
            Log::error("API Connection Error (Constants) to " . $url . ": " . $e->getMessage());
        }
        return [];
    }

    public function getHscCourses($programId, $groupId)
    {
        try {
            $url = rtrim($this->baseUrl, '/') . "/api/hsc/courses/program/{$programId}/group/{$groupId}/";
            Log::info("Fetching HSC courses from: " . $url);
            $response = Http::timeout(5)->withHeaders($this->apiHeaders())->get($url);
            if ($response->successful()) {
                Log::info("HSC Courses API Response: " . json_encode($response->json()));
                return $response->json();
            }
            Log::error("API returned non-successful status (HSC Courses): " . $response->status());
        } catch (\Exception $e) {
            Log::error("API Connection Error (HSC Courses) to " . $url . ": " . $e->getMessage());
        }
        return [];
    }

    public function getEmployees($type = 'teacher')
    {
        try {
            $url = rtrim($this->baseUrl, '/') . "/employees/api/{$type}/";
            Log::info("Fetching employees ({$type}) from: " . $url);
            $response = Http::timeout(5)->withHeaders($this->apiHeaders())->get($url);
            if ($response->successful()) {
                Log::info("Employees API Response ({$type}): " . count($response->json()) . " items found.");
                return $response->json();
            }
            Log::error("API returned non-successful status (Employees {$type}): " . $response->status());
        } catch (\Exception $e) {
            Log::error("API Connection Error (Employees {$type}) to " . $url . ": " . $e->getMessage());
        }
        return [];
    }

    public function getDailyAttendance($date = null)
    {
        try {
            $date = $date ?? now()->toDateString();
            $url = rtrim($this->baseUrl, '/') . "/api/daily-attendance/?date=" . $date;
            Log::info("Fetching daily attendance from: " . $url);
            $response = Http::timeout(10)->withHeaders($this->apiHeaders())->get($url);
            if ($response->successful()) {
                Log::info("Daily Attendance API Response: " . json_encode($response->json()));
                return $response->json();
            }
            Log::error("API returned non-successful status (Daily Attendance): " . $response->status());
        } catch (\Exception $e) {
            Log::error("API Connection Error (Daily Attendance) to " . $url . ": " . $e->getMessage());
        }
        return ['error' => 'connection_failed'];
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
}
