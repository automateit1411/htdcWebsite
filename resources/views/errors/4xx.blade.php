@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-8 px-4">
    <div class="bg-white rounded-2xl shadow-xl border border-emerald-100 max-w-lg w-full p-8 text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37]"></div>
        
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-emerald-50 text-[#3dab8c] mb-6 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>

        <h1 class="text-xl font-bold text-gray-800 mb-1">Bad Request</h1>
        <h2 class="text-base font-medium text-[#3dab8c] mb-4 bn-font">অনুরোধটি সঠিক নয়</h2>

        <p class="text-gray-600 text-sm mb-2 leading-relaxed">
            There was a problem processing your request. Please go back to the home page.
        </p>
        <p class="text-gray-500 text-xs mb-8 bn-font">
            আপনার অনুরোধটি প্রক্রিয়া করতে সমস্যা হয়েছে। অনুগ্রহ করে মূল পাতায় ফিরে যান।
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white font-medium px-6 py-2.5 rounded-xl shadow hover:opacity-90 transition-all text-sm">
                Go to Home / মূল পাতায় ফিরে যান
            </a>
        </div>
    </div>
</div>
@endsection
