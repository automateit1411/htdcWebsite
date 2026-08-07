<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormDownloadController extends Controller
{
    public function index()
    {
        $forms = FormDownload::latest()->paginate(10);
        return view('admin.form_downloads.index', compact('forms'));
    }

    public function create()
    {
        return view('admin.form_downloads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg,doc,docx|max:5120',
        ]);

        $form = FormDownload::create([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = 'form_' . $form->id . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('form_downloads', $fileName, 'public');
            $form->update(['file_path' => $filePath]);
        }

        return redirect()->route('admin.form-downloads.index')->with('success', __('admin.form_download_created'));
    }

    public function edit(FormDownload $formDownload)
    {
        return view('admin.form_downloads.edit', compact('formDownload'));
    }

    public function update(Request $request, FormDownload $formDownload)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg,doc,docx|max:5120',
        ]);

        $formDownload->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->hasFile('file')) {
            if ($formDownload->file_path && Storage::disk('public')->exists($formDownload->file_path)) {
                Storage::disk('public')->delete($formDownload->file_path);
            }

            $file = $request->file('file');
            $fileName = 'form_' . $formDownload->id . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('form_downloads', $fileName, 'public');
            $formDownload->update(['file_path' => $filePath]);
        }

        return redirect()->route('admin.form-downloads.index')->with('success', __('admin.form_download_updated'));
    }

    public function destroy(FormDownload $formDownload)
    {
        if ($formDownload->file_path && Storage::disk('public')->exists($formDownload->file_path)) {
            Storage::disk('public')->delete($formDownload->file_path);
        }
        
        $formDownload->delete();
        return redirect()->route('admin.form-downloads.index')->with('success', __('admin.form_download_deleted'));
    }
}
