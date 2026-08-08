@extends('layouts.app')

@section('title', 'Contact - Hazera-Taju Degree College')

@section('content')
    <div class="max-w-7xl mx-auto py-1">
        <!-- Page Header -->
        <div class="text-center mb-1 bg-white shadow">
            <h1
                class="text-3xl md:text-4xl font-bold text-gray-900 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] bg-clip-text text-transparent inline-block">
                {{ __('website.contact_us') }}
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto">{{ __('website.get_in_touch') }}
                {{ $settings->college_name ?? 'Hazera-Taju Degree College' }}
            </p>
        </div>

        <!-- Overlapping Two Column Layout -->
        <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-2 items-start">
            <!-- Left Card: College Information -->
            <div
                class="bg-white  shadow-2xl overflow-hidden transform transition-all duration-500 hover:scale-[1.02] z-10 relative">
                <!-- Decorative Circle -->
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#3dab8c]/20 to-[#0d3a37]/20 rounded-bl-full">
                </div>

                <!-- Card Header -->
                <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-1 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-full opacity-10">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <circle cx="0" cy="0" r="20" fill="white" />
                            <circle cx="100" cy="100" r="30" fill="white" />
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <h2 class="text-2xl font-bold text-white text-center">
                            {{ $settings->college_name ?? 'Hazera-Taju Degree College' }}
                        </h2>
                        <p class="text-white/90 text-center  flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 6a1 1 0 110 2 1 1 0 010-2z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ $settings->location ?? 'Chandgaon, Chittagong' }}
                        </p>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-1 space-y-1">
                    @if($settings->telephone)
                        <div class="flex items-start gap-4 group">
                            <div
                                class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] rounded p-3 shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-md">{{ __('website.telephone') }}</h3>
                                <p class="text-gray-600 font-medium text-sm">{{ $settings->telephone }}</p>
                            </div>
                        </div>
                    @endif

                    @if($settings->cell_phone)
                        <div class="flex items-start gap-4 group">
                            <div
                                class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] rounded p-3 shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-md">{{ __('website.cell_phone') }}</h3>
                                <p class="text-gray-600 font-medium text-sm">{{ $settings->cell_phone }}</p>
                            </div>
                        </div>
                    @endif

                    @if($settings->ein)
                        <div class="flex items-start gap-4 group">
                            <div
                                class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] rounded p-3 shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-md">{{ __('website.eiin') }}</h3>
                                <p class="text-gray-600 font-medium text-sm">{{ $settings->ein }}</p>
                            </div>
                        </div>
                    @endif

                    @if($settings->nu_code)
                        <div class="flex items-start gap-4 group">
                            <div
                                class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] rounded p-3 shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-md">{{ __('website.nu_code') }}</h3>
                                <p class="text-gray-600 font-medium text-sm">{{ $settings->nu_code }}</p>
                            </div>
                        </div>
                    @endif

                    @if($settings->email)
                        <div class="flex items-start gap-4 group">
                            <div
                                class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] rounded p-3 shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-md">{{ __('website.email') }}</h3>
                                <a href="mailto:{{ $settings->email }}"
                                    class="text-[#3dab8c] hover:text-[#0d3a37] font-semibold transition-colors">
                                    {{ $settings->email }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($settings->website)
                        <div class="flex items-start gap-4 group">
                            <div
                                class="bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] rounded p-3 shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 text-md">{{ __('website.website') }}</h3>
                                <a href="{{ $settings->website }}" target="_blank"
                                    class="text-[#3dab8c] hover:text-[#0d3a37] font-semibold transition-colors inline-flex items-center gap-1">
                                    {{ str_replace(['https://', 'http://', 'www.'], '', $settings->website) }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Social Media -->
                    <div class="flex justify-end">
                        <div class="flex flex-wrap gap-4">
                            @if($settings->facebook_url)
                                <a href="{{ $settings->facebook_url }}" target="_blank"
                                    class="inline-flex items-center gap-3 px-3 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                    <span class="font-semibold">{{ __('website.facebook') }}</span>
                                </a>
                            @endif

                            @if($settings->youtube_url)
                                <a href="{{ $settings->youtube_url }}" target="_blank"
                                    class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl hover:from-red-700 hover:to-red-800 transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                    </svg>
                                    <span class="font-semibold">{{ __('website.youtube') }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Card: Google Maps Location -->
            <div
                class="bg-white  shadow-2xl overflow-hidden transform transition-all duration-500 hover:scale-[1.02] z-10 relative">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] p-1 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-full opacity-10">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <circle cx="100" cy="0" r="25" fill="white" />
                            <circle cx="0" cy="100" r="35" fill="white" />
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <h2 class="text-2xl font-bold text-white text-center">{{ __('website.our_location') }}</h2>
                        <p class="text-white/90 text-center  flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 6a1 1 0 110 2 1 1 0 010-2z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ __('website.find_us_maps') }}
                        </p>
                    </div>
                </div>

                <!-- Google Maps Embed -->
                @if($settings->google_map_embed)
                    <div class="relative w-full h-[350px]">
                        {!! clean_html($settings->google_map_embed) !!}

                        <!-- Overlay Gradient at Bottom -->
                        <div
                            class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white to-transparent pointer-events-none">
                        </div>
                    </div>
                @else
                    <div class="relative w-full h-[550px] bg-gray-100 flex items-center justify-center">
                        <p class="text-gray-500 text-lg">{{ __('website.maps_not_configured') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection