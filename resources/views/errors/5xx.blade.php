@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-8 px-4">
    <div class="bg-white rounded-2xl shadow-xl border border-red-100 max-w-lg w-full p-8 text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-red-500 to-[#0d3a37]"></div>
        
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-red-50 text-red-600 mb-6 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <h1 class="text-xl font-bold text-gray-800 mb-1">Server Error</h1>
        <h2 class="text-base font-medium text-red-600 mb-4 bn-font">সার্ভার ত্রুটি</h2>

        <p class="text-gray-600 text-sm mb-2 leading-relaxed">
            An unexpected error occurred on the server. Please try refreshing the page.
        </p>
        <p class="text-gray-500 text-xs mb-8 bn-font">
            সার্ভারে একটি অপ্রত্যাশিত ত্রুটি ঘটেছে। অনুগ্রহ করে পেজটি রিফ্রেশ করুন।
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button onclick="window.location.reload()" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white font-medium px-5 py-2.5 rounded-xl shadow hover:opacity-90 transition-all text-sm">
                Reload / রিফ্রেশ করুন
            </button>
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 bg-gray-100 text-gray-700 font-medium px-5 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-200 transition-all text-sm">
                Go to Home / মূল পাতা
            </a>
        </div>
    </div>
</div>
@endsection
