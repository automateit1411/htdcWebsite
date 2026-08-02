@extends('layouts.app')

@section('content')
@php
    $setting = \App\Models\Setting::first();
@endphp

<div class="space-y-6">
    <!-- Founder Profile Section -->
    <section class="bg-white p-6 rounded shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <!-- Founder Image -->
            <div class="md:col-span-1 flex justify-center">
                @if($setting && $setting->founder_image)
                    <img src="{{ asset('storage/' . $setting->founder_image) }}" 
                         alt="{{ $setting->founder_name ?? 'Founder' }}" 
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $setting?->founder_name ?? 'Founder Name' }}</h1>
                <p class="text-lg text-[#3dab8c] font-semibold mb-4">{{ $setting?->founder_title ?? 'Founder' }}</p>
                
                <div class="prose max-w-none">
                    <h2 class="text-xl font-semibold text-gray-700 mb-3">Message from Founder</h2>
                    <blockquote class="border-l-4 border-[#3dab8c] pl-4 py-2 bg-gray-50 italic text-gray-700 rounded-r-lg">
                        "{{ $setting?->founder_message ?? 'Visionary leader who established this institution with a mission to provide quality education in a non-political environment.' }}"
                    </blockquote>
                </div>

                <div class="mt-6 space-y-3">
                    <h3 class="text-lg font-semibold text-gray-700">About Our Founder</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Our founder envisioned an educational institution that would serve as a beacon of knowledge and character development. 
                        With unwavering commitment to academic excellence and moral values, the founder established Hazera-Taju Degree College 
                        to provide quality education to students from all backgrounds.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Information Section -->
    <section class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Our Legacy</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] text-white p-4 rounded-lg">
                <h3 class="font-bold text-lg mb-2">Quality Education</h3>
                <p class="text-sm opacity-90">Providing modern education with traditional values since inception</p>
            </div>
            <div class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] text-white p-4 rounded-lg">
                <h3 class="font-bold text-lg mb-2">Non-Political</h3>
                <p class="text-sm opacity-90">Maintaining a peaceful, apolitical learning environment</p>
            </div>
            <div class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] text-white p-4 rounded-lg">
                <h3 class="font-bold text-lg mb-2">Student Success</h3>
                <p class="text-sm opacity-90">Committed to developing future leaders and responsible citizens</p>
            </div>
        </div>
    </section>
</div>
@endsection
