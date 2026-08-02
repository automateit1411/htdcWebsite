<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherVacantPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherVacantPostController extends Controller
{
    public function index()
    {
        $posts = TeacherVacantPost::latest()->paginate(10);
        return view('admin.teacher_vacant_posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.teacher_vacant_posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg,doc,docx|max:5120',
        ]);

        $post = TeacherVacantPost::create([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = 'teacher_post_' . $post->id . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('teacher_vacant_posts', $fileName, 'public');
            $post->update(['file_path' => $filePath]);
        }

        return redirect()->route('admin.teacher-vacant-posts.index')->with('success', 'Teacher vacant post created successfully.');
    }

    public function edit(TeacherVacantPost $teacherVacantPost)
    {
        return view('admin.teacher_vacant_posts.edit', compact('teacherVacantPost'));
    }

    public function update(Request $request, TeacherVacantPost $teacherVacantPost)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg,doc,docx|max:5120',
        ]);

        $teacherVacantPost->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->hasFile('file')) {
            if ($teacherVacantPost->file_path && Storage::disk('public')->exists($teacherVacantPost->file_path)) {
                Storage::disk('public')->delete($teacherVacantPost->file_path);
            }

            $file = $request->file('file');
            $fileName = 'teacher_post_' . $teacherVacantPost->id . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('teacher_vacant_posts', $fileName, 'public');
            $teacherVacantPost->update(['file_path' => $filePath]);
        }

        return redirect()->route('admin.teacher-vacant-posts.index')->with('success', 'Teacher vacant post updated successfully.');
    }

    public function destroy(TeacherVacantPost $teacherVacantPost)
    {
        if ($teacherVacantPost->file_path && Storage::disk('public')->exists($teacherVacantPost->file_path)) {
            Storage::disk('public')->delete($teacherVacantPost->file_path);
        }
        
        $teacherVacantPost->delete();
        return redirect()->route('admin.teacher-vacant-posts.index')->with('success', 'Teacher vacant post deleted successfully.');
    }
}
