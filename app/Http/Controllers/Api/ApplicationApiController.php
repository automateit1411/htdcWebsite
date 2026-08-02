<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationApiController extends Controller
{
    /**
     * Get a list of all student applications.
     */
    public function index(Request $request)
    {
        $query = Application::query();

        // Filter by status: Default to 0 (unprocessed) if not provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 0);
        }

        if ($request->has('program')) {
            $query->where('program', $request->program);
        }

        if ($request->has('limit')) {
            $applications = $query->latest()->limit($request->limit)->get();
        } else {
            $applications = $query->latest()->get();
        }

        // Manually ensure full URL for sPicture
        $applications->transform(function ($app) {
            if ($app->sPicture && !filter_var($app->sPicture, FILTER_VALIDATE_URL)) {
                $app->sPicture = asset($app->sPicture);
            }
            return $app;
        });

        return response()->json($applications);
    }

    /**
     * Get detailed information for a specific application.
     */
    public function show($id)
    {
        // Allow lookup by ID or PIN code, but only if unprocessed (status = 0)
        $application = Application::where(function ($query) use ($id) {
                $query->where('id', $id)
                      ->orWhere('pinCode', $id);
            })
            ->where('status', 0)
            ->first();

        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        if ($application->sPicture && !filter_var($application->sPicture, FILTER_VALIDATE_URL)) {
            $application->sPicture = asset($application->sPicture);
        }

        return response()->json($application);
    }

    /**
     * Update the status of a specific application.
     */
    public function updateStatus(Request $request, $id)
    {
        $application = Application::find($id);

        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        // If 'status' is provided in the request, use it. Otherwise, default to 1 as requested.
        $status = $request->input('status', 1);

        $application->update([
            'status' => $status
        ]);

        return response()->json([
            'message' => 'Status updated successfully',
            'application' => $application
        ]);
    }
}
