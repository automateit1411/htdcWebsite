<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherApplication;
use Illuminate\Http\Request;

class TeacherApplicationController extends Controller
{
    public function index()
    {
        $applications = TeacherApplication::latest()->paginate(10);
        return view('admin.teacher-applications.index', compact('applications'));
    }

    public function edit(TeacherApplication $teacherApplication)
    {
        return view('admin.teacher-applications.edit', compact('teacherApplication'));
    }

    public function update(Request $request, TeacherApplication $teacherApplication)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1,2',
        ]);

        $teacherApplication->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.teacher-applications.index')
            ->with('success', 'Application status updated successfully.');
    }

    public function destroy(TeacherApplication $teacherApplication)
    {
        $teacherApplication->delete();
        return redirect()->route('admin.teacher-applications.index')
            ->with('success', 'Application deleted successfully.');
    }
}
