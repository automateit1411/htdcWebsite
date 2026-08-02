@extends('layouts.app')

@section('content')
    @php
        $setting = \App\Models\Setting::first();
    @endphp

    <div class="space-y-6">
        <!-- BOU Header Section -->
        <section class="bg-white p-6 rounded shadow-lg">
            <div class="text-center mb-6">
                <div class="flex justify-center mb-4">
                    <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-4 rounded-full">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $setting?->bou_body ?? 'Board of Trustees' }}</h1>
                <div class="w-24 h-1 bg-[#3dab8c] mx-auto"></div>
            </div>

            <!-- BOU Description -->
            <div class="prose max-w-none">
                <div class="bg-gray-50 border-l-4 border-[#3dab8c] p-6 rounded-r-lg">
                    <p class="text-gray-700 leading-relaxed text-lg">
                        {{ $setting?->bou_description ?? 'The Board of Trustees is the governing body responsible for overseeing the administration and strategic direction of the institution. Composed of distinguished individuals with diverse expertise, the board ensures the college maintains its commitment to academic excellence, integrity, and service to society.' }}
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection