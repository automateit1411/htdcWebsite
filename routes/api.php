<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\ApplicationApiController;
use App\Http\Controllers\Api\DailyAttendanceApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('programs/admission', [DataController::class, 'getPrograms']);

Route::get('/sessions/admission', [DataController::class, 'getAdmissionSessions']);
Route::get('/sessions/all', [DataController::class, 'getAllSessions']);
Route::get('/groups', [DataController::class, 'getGroups']);
Route::get('/groups/program/{id}', [DataController::class, 'getGroupsByProgram']);
Route::get('/occupations/all', [DataController::class, 'getOccupations']);
Route::get('/qualifications/all', [DataController::class, 'getQualifications']);
Route::get('/districts/all', [DataController::class, 'getDistricts']);
Route::get('/boards/all', [DataController::class, 'getBoards']);
Route::get('/constants', [DataController::class, 'getConstants']);
Route::get('/hsc/courses/program/{program_id}/group/{group_id}', [DataController::class, 'getHscCourses']);

// Student Application APIs (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/applications', [ApplicationApiController::class, 'index']);
    Route::get('/applications/{id}', [ApplicationApiController::class, 'show']);
    Route::post('/applications/{id}/status', [ApplicationApiController::class, 'updateStatus']);
    Route::patch('/applications/{id}/status', [ApplicationApiController::class, 'updateStatus']);

    // Daily Attendance API
    Route::get('/daily-attendance', [DailyAttendanceApiController::class, 'index']);
    Route::post('/daily-attendance', [DailyAttendanceApiController::class, 'store']);
});

