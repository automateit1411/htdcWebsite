@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-8 px-4">
    <div class="bg-white rounded-2xl shadow-xl border border-red-100 max-w-lg w-full p-8 text-center relative overflow-hidden">
        <!-- Accent Top Bar -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-red-500 to-[#0d3a37]"></div>
        
        <!-- Error Badge -->
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-red-50 text-red-600 mb-6 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>

        <div class="text-4xl font-black text-gray-800 mb-1">500</div>
        <h1 class="text-xl font-bold text-gray-800 mb-1">Internal Server Error</h1>
        <h2 class="text-base font-medium text-red-600 mb-4 bn-font">অভ্যন্তরীণ সার্ভার ত্রুটি</h2>

        <p class="text-gray-600 text-sm mb-2 leading-relaxed">
            Something went wrong on our end. Please try refreshing the page or try again later.
        </p>
        <p class="text-gray-500 text-xs mb-8 bn-font">
            সার্ভারে একটি সাময়িক সমস্যা হয়েছে। অনুগ্রহ করে পেজটি রিফ্রেশ করুন অথবা কিছু সময় পর আবার চেষ্টা করুন।
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button onclick="window.location.reload()" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white font-medium px-5 py-2.5 rounded-xl shadow hover:opacity-90 transition-all text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Reload / রিফ্রেশ করুন
            </button>
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 bg-gray-100 text-gray-700 font-medium px-5 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-200 transition-all text-sm">
                Go to Home / মূল পাতা
            </a>
        </div>
    </div>
</div>
@endsection
