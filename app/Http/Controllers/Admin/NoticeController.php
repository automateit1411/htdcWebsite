<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::latest()->paginate(10);
        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.notices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120', // 5MB limit
        ]);

        $notice = Notice::create([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = 'notice_' . $notice->id . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('notices', $fileName, 'public');
            $notice->update(['file_path' => $filePath]);
        }

        return redirect()->route('admin.notices.index')->with('success', __('admin.notice_created'));
    }

    public function edit(Notice $notice)
    {
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
        ]);

        $notice->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($notice->file_path && Storage::disk('public')->exists($notice->file_path)) {
                Storage::disk('public')->delete($notice->file_path);
            }

            $file = $request->file('file');
            $fileName = 'notice_' . $notice->id . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('notices', $fileName, 'public');
            $notice->update(['file_path' => $filePath]);
        }

        return redirect()->route('admin.notices.index')->with('success', __('admin.notice_updated'));
    }

    public function destroy(Notice $notice)
    {
        if ($notice->file_path && Storage::disk('public')->exists($notice->file_path)) {
            Storage::disk('public')->delete($notice->file_path);
        }
        
        $notice->delete();
        return redirect()->route('admin.notices.index')->with('success', __('admin.notice_deleted'));
    }
}
