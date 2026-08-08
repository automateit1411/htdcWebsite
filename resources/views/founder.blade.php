@extends('layouts.app')

@section('title', 'Founder - Hazera-Taju Degree College')

@section('content')
@php
    $setting = \App\Models\Setting::first();
    $locale = app()->getLocale();
    
    // Helper function to get locale-appropriate value
    $getLocalizedValue = function($field, $fallback = null) use ($setting, $locale) {
        if (!$setting) return $fallback;
        
        $localizedField = $field . '_bn';
        if ($locale === 'bn' && $setting->$localizedField) {
            return $setting->$localizedField;
        }
        return $setting->$field ?? $fallback;
    };
@endphp

<div class="space-y-6">
    <!-- Founder Profile Section -->
    <section class="bg-white p-6 rounded shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <!-- Founder Image -->
            <div class="md:col-span-1 flex justify-center">
                @if($setting && $setting->founder_image)
                    <img src="{{ asset('storage/' . $setting->founder_image) }}" 
                         alt="{{ $getLocalizedValue('founder_name', __('website.founder_title')) }}" 
                         class="w-64 h-64 object-cover rounded-full border-4 border-[#3dab8c] shadow-xl">
                @else
                    <div class="w-64 h-64 rounded-full bg-gray-200 flex items-center justify-center border-4 border-[#3dab8c]">
                        <svg class="w-32 h-32 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Founder Information -->
            <div class="md:col-span-2">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $getLocalizedValue('founder_name', __('website.founder_name')) }}</h1>
                <p class="text-lg text-[#3dab8c] font-semibold mb-4">{{ $getLocalizedValue('founder_title', __('website.founder_title')) }}</p>
                
                <div class="prose max-w-none">
                    <h2 class="text-xl font-semibold text-gray-700 mb-3">{{ __('website.message_from_founder') }}</h2>
                    <blockquote class="border-l-4 border-[#3dab8c] pl-4 py-2 bg-gray-50 italic text-gray-700 rounded-r-lg">
                        "{{ $getLocalizedValue('founder_message', __('website.founder_message_fallback')) }}"
                    </blockquote>
                </div>

                <div class="mt-6 space-y-3">
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('website.about_our_founder') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('website.about_founder_desc') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
