<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffVacantPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffVacantPostController extends Controller
{
    public function index()
    {
        $posts = StaffVacantPost::latest()->paginate(10);
        return view('admin.staff_vacant_posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.staff_vacant_posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg,doc,docx|max:5120',
        ]);

        $post = StaffVacantPost::create([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = 'staff_post_' . $post->id . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('staff_vacant_posts', $fileName, 'public');
            $post->update(['file_path' => $filePath]);
        }

        return redirect()->route('admin.staff-vacant-posts.index')->with('success', __('admin.staff_vacant_post_created'));
    }

    public function edit(StaffVacantPost $staffVacantPost)
    {
        return view('admin.staff_vacant_posts.edit', compact('staffVacantPost'));
    }

    public function update(Request $request, StaffVacantPost $staffVacantPost)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg,doc,docx|max:5120',
        ]);

        $staffVacantPost->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->hasFile('file')) {
            if ($staffVacantPost->file_path && Storage::disk('public')->exists($staffVacantPost->file_path)) {
                Storage::disk('public')->delete($staffVacantPost->file_path);
            }

            $file = $request->file('file');
            $fileName = 'staff_post_' . $staffVacantPost->id . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('staff_vacant_posts', $fileName, 'public');
            $staffVacantPost->update(['file_path' => $filePath]);
        }

        return redirect()->route('admin.staff-vacant-posts.index')->with('success', __('admin.staff_vacant_post_updated'));
    }

    public function destroy(StaffVacantPost $staffVacantPost)
    {
        if ($staffVacantPost->file_path && Storage::disk('public')->exists($staffVacantPost->file_path)) {
            Storage::disk('public')->delete($staffVacantPost->file_path);
        }
        
        $staffVacantPost->delete();
        return redirect()->route('admin.staff-vacant-posts.index')->with('success', __('admin.staff_vacant_post_deleted'));
    }
}
