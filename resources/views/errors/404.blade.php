@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-8 px-4">
    <div class="bg-white rounded-2xl shadow-xl border border-emerald-100 max-w-lg w-full p-8 text-center relative overflow-hidden">
        <!-- Accent Top Bar -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37]"></div>
        
        <!-- Error Badge -->
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-emerald-50 text-[#3dab8c] mb-6 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <div class="text-4xl font-black text-[#0d3a37] mb-1">404</div>
        <h1 class="text-xl font-bold text-gray-800 mb-1">Page Not Found</h1>

        <p class="text-gray-600 text-sm mb-2 leading-relaxed">
            The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center mt-6">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white font-medium px-6 py-2.5 rounded-xl shadow hover:opacity-90 transition-all text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Go to Home
            </a>
        </div>
    </div>
</div>
@endsection
