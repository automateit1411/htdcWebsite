<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display contact settings.
     */
    public function index()
    {
        $setting = Setting::first();
        if (!$setting) {
            // Create default setting if none exists
            $setting = Setting::create([
                'college_name' => 'Hazera-Taju Degree College',
                'location' => 'Chandgaon, Chittagong',
            ]);
        }
        $galleries = Gallery::all();
        return view('admin.settings.index', compact('setting', 'galleries'));
    }

    /**
     * Update contact settings.
     */
    public function update(Request $request)
    {
        $setting = Setting::first();
        
        $validated = $request->validate([
            'college_name' => 'required|string|max:255',
            'college_name_bn' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'location_bn' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:100',
            'cell_phone' => 'nullable|string|max:100',
            'ein' => 'nullable|string|max:50',
            'nu_code' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'address_bn' => 'nullable|string',
            'facebook_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'google_map_embed' => 'nullable|string',
            'is_active' => 'boolean',
            // About fields
            'about_title' => 'nullable|string|max:255',
            'about_title_bn' => 'nullable|string|max:255',
            'about_description' => 'nullable|string',
            'about_description_bn' => 'nullable|string',
            'about_image_id' => 'nullable|integer|exists:galleries,id',
            // Founder fields
            'founder_name' => 'nullable|string|max:255',
            'founder_name_bn' => 'nullable|string|max:255',
            'founder_title' => 'nullable|string|max:255',
            'founder_title_bn' => 'nullable|string|max:255',
            'founder_message' => 'nullable|string',
            'founder_message_bn' => 'nullable|string',
            'founder_image' => 'nullable|image|max:2048',
            // Principal fields
            'principal_name' => 'nullable|string|max:255',
            'principal_name_bn' => 'nullable|string|max:255',
            'principal_title' => 'nullable|string|max:255',
            'principal_title_bn' => 'nullable|string|max:255',
            'principal_message' => 'nullable|string',
            'principal_message_bn' => 'nullable|string',
            'principal_image' => 'nullable|image|max:2048',
            // BOU fields
            'bou_body' => 'nullable|string|max:255',
            'bou_body_bn' => 'nullable|string|max:255',
            'bou_description' => 'nullable|string',
            'bou_description_bn' => 'nullable|string',
            // Language
            'site_language' => 'required|string|in:en,bn',
        ]);
        
        // Handle about image - save gallery ID directly
        if (!$request->filled('about_image_id')) {
            $validated['about_image_id'] = null;
        }
        
        // Handle founder image upload
        if ($request->hasFile('founder_image')) {
            try {
                if ($setting && $setting->founder_image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($setting->founder_image);
                }
                $path = $request->file('founder_image')->store('images/founder', 'public');
                $validated['founder_image'] = $path;
            } catch (\Exception $e) {
                return back()->withErrors(['founder_image' => 'Failed to upload founder image. Please try again.'])
                    ->withInput();
            }
        }
        
        // Handle principal image upload
        if ($request->hasFile('principal_image')) {
            try {
                if ($setting && $setting->principal_image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($setting->principal_image);
                }
                $path = $request->file('principal_image')->store('images/principal', 'public');
                $validated['principal_image'] = $path;
            } catch (\Exception $e) {
                return back()->withErrors(['principal_image' => 'Failed to upload principal image. Please try again.'])
                    ->withInput();
            }
        }
        
        if ($setting) {
            $setting->update($validated);
        } else {
            $setting = Setting::create($validated);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', __('admin.contact_info_updated'));
    }
}
