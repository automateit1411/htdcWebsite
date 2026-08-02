<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ExternalApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DailyAttendanceApiController extends Controller
{
    protected $externalApi;

    public function __construct(ExternalApiService $externalApi)
    {
        $this->externalApi = $externalApi;
    }

    public function index(Request $request)
    {
        try {
            $date = $request->get('date', now()->toDateString());
            
            $attendanceData = $this->externalApi->getDailyAttendance($date);
            
            return response()->json([
                'success' => true,
                'data' => $attendanceData,
                'date' => $date,
            ])
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type');
        } catch (\Exception $e) {
            Log::error("Daily Attendance API Error: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch daily attendance data',
                'error' => $e->getMessage(),
            ], 500)
            ->header('Access-Control-Allow-Origin', '*');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'program_group_id' => 'required|integer',
                'total_students' => 'required|integer|min:0',
                'present_students' => 'required|integer|min:0',
            ]);

            $data = [
                'date' => $request->date,
                'program_group_id' => $request->program_group_id,
                'total_students' => $request->total_students,
                'present_students' => $request->present_students,
            ];

            $result = $this->externalApi->storeDailyAttendance($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Attendance stored successfully',
                'data' => $result,
            ])
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type');
        } catch (\Exception $e) {
            Log::error("Daily Attendance Store Error: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to store attendance',
                'error' => $e->getMessage(),
            ], 500)
            ->header('Access-Control-Allow-Origin', '*');
        }
    }
}
