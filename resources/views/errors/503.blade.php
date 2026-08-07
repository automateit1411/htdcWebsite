@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-8 px-4">
    <div class="bg-white rounded-2xl shadow-xl border border-emerald-100 max-w-lg w-full p-8 text-center relative overflow-hidden">
        <!-- Accent Top Bar -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37]"></div>
        
        <!-- Error Badge -->
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-emerald-50 text-[#3dab8c] mb-6 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 4a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2V4zM4 7a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V7z"></path>
            </svg>
        </div>

        <div class="text-4xl font-black text-[#0d3a37] mb-1">503</div>
        <h1 class="text-xl font-bold text-gray-800 mb-1">{{ __('website.under_maintenance') }}</h1>
        <h2 class="text-base font-medium text-[#3dab8c] mb-4 bn-font">ওয়েবসাইট রক্ষণাবেক্ষণ চলছে</h2>

        <p class="text-gray-600 text-sm mb-2 leading-relaxed">
            {{ __('website.maintenance_desc') }}
        </p>
        <p class="text-gray-500 text-xs mb-8 bn-font">
            আমাদের ওয়েবসাইট টি বর্তমানে সংস্কার কাজের জন্য সাময়িকভাবে বন্ধ আছে। অতি শীঘ্রই আমরা পুনরায় ফিরছি।
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button onclick="window.location.reload()" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white font-medium px-6 py-2.5 rounded-xl shadow hover:opacity-90 transition-all text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                {{ __('website.check_again') }}
            </button>
        </div>
    </div>
</div>
@endsection
