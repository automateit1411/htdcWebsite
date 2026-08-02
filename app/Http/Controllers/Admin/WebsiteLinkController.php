<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteLink;
use Illuminate\Http\Request;

class WebsiteLinkController extends Controller
{
    public function index()
    {
        $links = WebsiteLink::ordered()->paginate(15);
        return view('admin.website-links.index', compact('links'));
    }

    public function create()
    {
        return view('admin.website-links.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        WebsiteLink::create([
            'name' => $request->name,
            'url' => $request->url,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.website-links.index')->with('success', 'Link created successfully.');
    }

    public function edit(WebsiteLink $websiteLink)
    {
        return view('admin.website-links.edit', ['link' => $websiteLink]);
    }

    public function update(Request $request, WebsiteLink $websiteLink)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $websiteLink->update([
            'name' => $request->name,
            'url' => $request->url,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.website-links.index')->with('success', 'Link updated successfully.');
    }

    public function destroy(WebsiteLink $websiteLink)
    {
        $websiteLink->delete();
        return redirect()->route('admin.website-links.index')->with('success', 'Link deleted successfully.');
    }

    public function toggleStatus(WebsiteLink $websiteLink)
    {
        $websiteLink->update(['is_active' => !$websiteLink->is_active]);
        return back()->with('success', 'Link status updated.');
    }
}
