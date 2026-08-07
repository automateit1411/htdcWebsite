<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of sliders
     */
    public function index()
    {
        $sliders = Slider::with('image')->orderBy('order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new slider
     */
    public function create()
    {
        $galleries = Gallery::all();
        return view('admin.sliders.create', compact('galleries'));
    }

    /**
     * Store a newly created slider
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image_id' => 'required|exists:galleries,id',
            'title' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? Slider::max('order') + 1;

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', __('admin.slider_created'));
    }

    /**
     * Show the form for editing the specified slider
     */
    public function edit(Slider $slider)
    {
        $galleries = Gallery::all();
        return view('admin.sliders.edit', compact('slider', 'galleries'));
    }

    /**
     * Update the specified slider
     */
    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'image_id' => 'required|exists:galleries,id',
            'title' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', __('admin.slider_updated'));
    }

    /**
     * Remove the specified slider
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.sliders.index')
            ->with('success', __('admin.slider_deleted'));
    }

    /**
     * Toggle slider active status
     */
    public function toggleStatus(Slider $slider)
    {
        $slider->update(['is_active' => !$slider->is_active]);
        
        return redirect()->back()
            ->with('success', __('admin.slider_status_updated'));
    }
}
