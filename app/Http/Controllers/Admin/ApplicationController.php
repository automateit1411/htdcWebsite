<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index(Request $request, \App\Services\ExternalApiService $apiService)
    {
        $query = Application::query();

        if ($request->filled('program')) {
            $query->where('program', $request->input('program'));
        }
        
        if ($request->filled('session')) {
            $query->where('session', $request->input('session'));
        }

        $applications = $query->latest()->paginate(25);
        
        $options = [
            'programs' => collect($apiService->getPrograms() ?: [])->keyBy('id'),
            'sessions' => collect($apiService->getAdmissionSessions() ?: [])->keyBy('id'),
        ];

        return view('admin.applications.index', compact('applications', 'options'));
    }

    public function show(Application $application)
    {
        return view('admin.applications.show', compact('application'));
    }

    public function destroy(Application $application)
    {
        if ($application->sPicture) {
            $path = str_replace('/storage/', 'public/', $application->sPicture);
            Storage::delete($path);
        }

        $application->delete();
        return redirect()->back()->with('success', 'Application deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:applications,id',
        ]);

        $applications = Application::whereIn('id', $request->ids)->get();
        foreach ($applications as $app) {
            if ($app->sPicture) {
                $path = str_replace('/storage/', 'public/', $app->sPicture);
                Storage::delete($path);
            }
        }

        Application::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', count($request->ids) . ' applications deleted successfully.');
    }
}
