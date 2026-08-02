@extends('layouts.app')

@section('content')
@php
    $setting = \App\Models\Setting::first();
@endphp

<div class="space-y-6">
    <!-- Principal Profile Section -->
    <section class="bg-white p-6 rounded shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <!-- Principal Image -->
            <div class="md:col-span-1 flex justify-center">
                @if($setting && $setting->principal_image)
                    <img src="{{ asset('storage/' . $setting->principal_image) }}" 
                         alt="{{ $setting->principal_name ?? 'Principal' }}" 
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $setting?->principal_name ?? 'Principal Name' }}</h1>
                <p class="text-lg text-[#3dab8c] font-semibold mb-4">{{ $setting?->principal_title ?? 'Principal' }}</p>
                
                <div class="prose max-w-none">
                    <h2 class="text-xl font-semibold text-gray-700 mb-3">Message from Principal</h2>
                    <blockquote class="border-l-4 border-[#3dab8c] pl-4 py-2 bg-gray-50 italic text-gray-700 rounded-r-lg">
                        "{{ $setting?->principal_message ?? 'Dedicated to maintaining academic excellence and fostering innovation in our students.' }}"
                    </blockquote>
                </div>

                <div class="mt-6 space-y-3">
                    <h3 class="text-lg font-semibold text-gray-700">About Our Principal</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Our principal brings years of experience in educational leadership and is committed to upholding the vision of our founder. 
                        With a focus on modern teaching methodologies and student-centered learning, the principal continues to guide 
                        Hazera-Taju Degree College towards greater heights of academic achievement and institutional excellence.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Academic Vision Section -->
    <section class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Academic Vision</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] text-white p-4 rounded-lg">
                <h3 class="font-bold text-lg mb-2">Excellence</h3>
                <p class="text-sm opacity-90">Promoting highest standards in teaching and learning</p>
            </div>
            <div class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] text-white p-4 rounded-lg">
                <h3 class="font-bold text-lg mb-2">Innovation</h3>
                <p class="text-sm opacity-90">Embracing modern educational technologies and methods</p>
            </div>
            <div class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] text-white p-4 rounded-lg">
                <h3 class="font-bold text-lg mb-2">Leadership</h3>
                <p class="text-sm opacity-90">Developing future leaders through mentorship and guidance</p>
            </div>
        </div>
    </section>
</div>
@endsection
