<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomPageController extends Controller
{
    public function index()
    {
        $pages = CustomPage::latest()->paginate(10);
        return view('admin.custom_pages.index', compact('pages'));
    }

    public function create()
    {
        $categories = CustomPage::whereNotNull('category')->distinct()->pluck('category');
        $subcategories = CustomPage::whereNotNull('subcategory')->distinct()->pluck('subcategory');
        return view('admin.custom_pages.create', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'nullable|string',
            'route' => 'nullable|string|max:255',
            'status' => 'boolean',
        ]);

        $customPage = CustomPage::create($validated);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = \Illuminate\Support\Str::slug(($validated['category'] ?? '') . '_' . $validated['page_name'], '_') . '_' . $customPage->id . '.' . $extension;
            $filePath = $file->storeAs('pages', $filename, 'public');
            $customPage->update(['file_path' => $filePath]);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = \Illuminate\Support\Str::slug(($validated['category'] ?? '') . '_' . $validated['page_name'], '_') . '_' . $customPage->id . '_image.' . $extension;
            $imagePath = $image->storeAs('pages', $imageName, 'public');
            $customPage->update(['image_path' => $imagePath]);
        }

        return redirect()->route('admin.custom-pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(CustomPage $custom_page)
    {
        $categories = CustomPage::whereNotNull('category')->distinct()->pluck('category');
        $subcategories = CustomPage::whereNotNull('subcategory')->distinct()->pluck('subcategory');
        return view('admin.custom_pages.edit', compact('custom_page', 'categories', 'subcategories'));
    }

    public function update(Request $request, CustomPage $custom_page)
    {
        $validated = $request->validate([
            'page_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'nullable|string',
            'route' => 'nullable|string|max:255',
            'status' => 'boolean',
        ]);

        $oldFilePath = $custom_page->file_path;
        $oldImagePath = $custom_page->image_path;

        unset($validated['file']);
        unset($validated['image']);

        $custom_page->update($validated);

        if ($request->hasFile('file')) {
            if ($oldFilePath) {
                Storage::disk('public')->delete($oldFilePath);
            }
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = \Illuminate\Support\Str::slug(($validated['category'] ?? '') . '_' . $validated['page_name'], '_') . '_' . $custom_page->id . '.' . $extension;
            $filePath = $file->storeAs('pages', $filename, 'public');
            $custom_page->update(['file_path' => $filePath]);
        }

        if ($request->hasFile('image')) {
            if ($oldImagePath) {
                Storage::disk('public')->delete($oldImagePath);
            }
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = \Illuminate\Support\Str::slug(($validated['category'] ?? '') . '_' . $validated['page_name'], '_') . '_' . $custom_page->id . '_image.' . $extension;
            $imagePath = $image->storeAs('pages', $imageName, 'public');
            $custom_page->update(['image_path' => $imagePath]);
        }

        return redirect()->route('admin.custom-pages.index')->with('success', 'Page updated successfully.');
    }

    public function settings(CustomPage $custom_page)
    {
        $galleries = \App\Models\Gallery::latest()->get();
        return view('admin.custom_pages.settings', compact('custom_page', 'galleries'));
    }

    public function updateSettings(Request $request, CustomPage $custom_page)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'gallery_image_path' => 'nullable|string',
        ]);

        $custom_page->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        // Handle Image Upload
        if ($request->hasFile('image')) {
            if ($custom_page->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($custom_page->image_path);
            }
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = \Illuminate\Support\Str::slug($custom_page->page_name, '_') . '_' . $custom_page->id . '_image.' . $extension;
            $imagePath = $image->storeAs('pages', $imageName, 'public');
            $custom_page->update(['image_path' => $imagePath]);
        } 
        // Handle selection from Gallery
        elseif ($request->gallery_image_path) {
            // Path comes as asset('storage/path/to/image.jpg')
            $path = str_replace(asset('storage/'), '', $request->gallery_image_path);
            $custom_page->update(['image_path' => $path]);
        }

        // Handle File Attachment
        if ($request->hasFile('file')) {
            if ($custom_page->file_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($custom_page->file_path);
            }
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = \Illuminate\Support\Str::slug($custom_page->page_name, '_') . '_' . $custom_page->id . '.' . $extension;
            $filePath = $file->storeAs('pages', $filename, 'public');
            $custom_page->update(['file_path' => $filePath]);
        }

        return back()->with('success', 'Page content updated successfully.');
    }

    public function destroy(CustomPage $custom_page)
    {
        if ($custom_page->file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($custom_page->file_path);
        }
        if ($custom_page->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($custom_page->image_path);
        }
        $custom_page->delete();

        return redirect()->route('admin.custom-pages.index')->with('success', 'Page deleted successfully.');
    }
}
