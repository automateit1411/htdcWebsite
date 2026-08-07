@extends('layouts.app')

@section('title', 'Principal - Hazera-Taju Degree College')

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
    <!-- Principal Profile Section -->
    <section class="bg-white p-6 rounded shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <!-- Principal Image -->
            <div class="md:col-span-1 flex justify-center">
                @if($setting && $setting->principal_image)
                    <img src="{{ asset('storage/' . $setting->principal_image) }}" 
                         alt="{{ $getLocalizedValue('principal_name', __('website.principal_title')) }}" 
                         class="w-64 h-64 object-cover rounded-full border-4 border-[#3dab8c] shadow-xl">
                @else
                    <div class="w-64 h-64 rounded-full bg-gray-200 flex items-center justify-center border-4 border-[#3dab8c]">
                        <svg class="w-32 h-32 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Principal Information -->
            <div class="md:col-span-2">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $getLocalizedValue('principal_name', __('website.principal_name')) }}</h1>
                <p class="text-lg text-[#3dab8c] font-semibold mb-4">{{ $getLocalizedValue('principal_title', __('website.principal_title')) }}</p>
                
                <div class="prose max-w-none">
                    <h2 class="text-xl font-semibold text-gray-700 mb-3">{{ __('website.message_from_principal') }}</h2>
                    <blockquote class="border-l-4 border-[#3dab8c] pl-4 py-2 bg-gray-50 italic text-gray-700 rounded-r-lg">
                        "{{ $getLocalizedValue('principal_message', __('website.principal_message_fallback')) }}"
                    </blockquote>
                </div>

                <div class="mt-6 space-y-3">
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('website.about_our_principal') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('website.about_principal_desc') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Academic Vision Section -->
    <section class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('website.academic_vision') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] text-white p-4 rounded-lg">
                <h3 class="font-bold text-lg mb-2">{{ __('website.excellence') }}</h3>
                <p class="text-sm opacity-90">{{ __('website.excellence_desc') }}</p>
            </div>
            <div class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] text-white p-4 rounded-lg">
                <h3 class="font-bold text-lg mb-2">{{ __('website.innovation') }}</h3>
                <p class="text-sm opacity-90">{{ __('website.innovation_desc') }}</p>
            </div>
            <div class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] text-white p-4 rounded-lg">
                <h3 class="font-bold text-lg mb-2">{{ __('website.leadership') }}</h3>
                <p class="text-sm opacity-90">{{ __('website.leadership_desc') }}</p>
            </div>
        </div>
    </section>
</div>
@endsection
