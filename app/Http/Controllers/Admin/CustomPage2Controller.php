<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPage2;
use App\Models\CustomPage2Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CustomPage2Controller extends Controller
{
    public function index()
    {
        $pages = CustomPage2::latest()->paginate(15);
        return view('admin.custom-page2.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.custom-page2.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'route' => 'nullable|string|max:255',
            'status' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['page_name']);

        CustomPage2::create($validated);

        return redirect()->route('admin.custom-page2.index')->with('success', 'Page created successfully.');
    }

    public function edit(CustomPage2 $custom_page2)
    {
        return view('admin.custom-page2.edit', compact('custom_page2'));
    }

    public function update(Request $request, CustomPage2 $custom_page2)
    {
        $validated = $request->validate([
            'page_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'route' => 'nullable|string|max:255',
            'status' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['page_name']);

        $custom_page2->update($validated);

        return redirect()->route('admin.custom-page2.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(CustomPage2 $custom_page2)
    {
        foreach ($custom_page2->items as $item) {
            if ($item->image_path) Storage::disk('public')->delete($item->image_path);
            if ($item->file_path) Storage::disk('public')->delete($item->file_path);
        }
        $custom_page2->delete();

        return redirect()->route('admin.custom-page2.index')->with('success', 'Page deleted successfully.');
    }

    public function items(CustomPage2 $custom_page2)
    {
        $items = $custom_page2->items()->get();
        return view('admin.custom-page2.items', compact('custom_page2', 'items'));
    }

    public function storeItem(Request $request, CustomPage2 $custom_page2)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        ]);

        $maxOrder = $custom_page2->items()->max('order') ?? 0;
        $validated['custom_page_2_id'] = $custom_page2->id;
        $validated['order'] = $maxOrder + 1;

        $item = CustomPage2Item::create($validated);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'custom_page2_' . $custom_page2->id . '_item_' . $item->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('custom-page2', $filename, 'public');
            $item->update(['image_path' => $path]);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = 'custom_page2_' . $custom_page2->id . '_file_' . $item->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('custom-page2', $filename, 'public');
            $item->update(['file_path' => $path]);
        }

        return back()->with('success', 'Item added successfully.');
    }

    public function destroyItem(CustomPage2 $custom_page2, CustomPage2Item $item)
    {
        if ($item->image_path) Storage::disk('public')->delete($item->image_path);
        if ($item->file_path) Storage::disk('public')->delete($item->file_path);
        $item->delete();

        return back()->with('success', 'Item deleted successfully.');
    }
}
