@extends('layouts.app')

@section('title', 'Hazera-Taju Degree College - Home')

@section('content')
    @php
        // Fetch settings for about information
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

        <!-- Main Grid Layout: Section 1 (Left - Wider) | Section 2 (Right - Narrower) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- SECTION 1: Slider + About Content (Left Column - 2/3 width) -->
            <div class="lg:col-span-2 ">

                <!-- Slider Component -->
                @php
                    $sliders = \App\Models\Slider::with('image')->where('is_active', true)->orderBy('order')->get();
                    $fallbackImages = ['banner1.png', 'banner2.png', 'banner3.png', 'banner4.jpeg', 'banner5.jpeg'];
                @endphp

                @if($sliders->count() > 0)
                    @php
                        $slidesData = [];
                        foreach ($sliders as $index => $slider) {
                            $imageUrl = '';
                            if ($slider->image && $slider->image->image) {
                                $imageUrl = asset('storage/' . $slider->image->image);
                            } else {
                                $imageUrl = asset('images/' . $fallbackImages[$index % count($fallbackImages)]);
                            }
                            $title = addslashes($slider->title ?? $slider->image->title ?? 'Welcome to Hazera-Taju Degree College');
                            $subtitle = addslashes($slider->description ?? $slider->image->category ?? 'Excellence in Education');
                            $slidesData[] = [
                                'image' => $imageUrl,
                                'title' => $title,
                                'subtitle' => $subtitle
                            ];
                        }
                    @endphp

                    <section x-data="{ 
                                                                                                                            activeSlide: 0, 
                                                                                                                            slides: {{ json_encode($slidesData) }},
                                                                                                                            timer: null, 
                                                                                                                            init() { 
                                                                                                                                this.startTimer(); 
                                                                                                                            }, 
                                                                                                                            startTimer() { 
                                                                                                                                this.timer = setInterval(() => { this.next() }, 4000); 
                                                                                                                            }, 
                                                                                                                            stopTimer() {
                                                                                                                                clearInterval(this.timer);
                                                                                                                            },
                                                                                                                            next() { 
                                                                                                                                this.activeSlide = (this.activeSlide + 1) % this.slides.length; 
                                                                                                                            },
                                                                                                                            prev() {
                                                                                                                                this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
                                                                                                                            }
                                                                                                                        }"
                        x-cloak @mouseenter="stopTimer()" @mouseleave="startTimer()"
                        class="relative w-full overflow-hidden shadow-lg group h-[200px] sm:h-[200px] md:h-[200px] lg:h-[250px] ">

                        <!-- Slides Container -->
                        <div class="flex transition-transform duration-700 ease-out h-full"
                            :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">
                            <template x-for="(slide, index) in slides" :key="index">
                                <div class="flex-shrink-0 w-full h-full relative">
                                    <!-- Slide Image -->
                                    <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover object-center">

                                    <!-- Overlay Gradient -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent">
                                    </div>

                                    <!-- Title and Subtitle at Bottom -->
                                    <div class="absolute bottom-0 left-0 right-0  text-white  ">
                                        <h2 class="bg-[#00000059] text-md sm:text-xl p-1 md:text-xl font-bold text-center" x-text="slide.title"></h2>
                                        <p class="text-sm sm:text-base opacity-90 max-w-2xl text-center bg-[#0d3a37e0] hidden" x-text="slide.subtitle"></p>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Prev/Next Buttons -->
                        <template x-if="slides.length > 1">
                            <div>
                                <button aria-label="Previous" @click="prev()"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 text-white rounded-full p-3 hover:bg-black/50 transition opacity-0 group-hover:opacity-100 z-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button aria-label="Next" @click="next()"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 text-white rounded-full p-3 hover:bg-black/50 transition opacity-0 group-hover:opacity-100 z-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </template>

                        <!-- Dots Indicator -->
                        <template x-if="slides.length > 1">
                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10 hidden">
                                <template x-for="(slide, index) in slides" :key="index">
                                    <button @click="activeSlide = index"
                                        class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                                        :class="activeSlide === index ? 'bg-white w-8' : 'bg-white/50 hover:bg-white/80'">
                                    </button>
                                </template>
                            </div>
                        </template>
                    </section>
                @else
                    <!-- Fallback slider if no active sliders found -->
                    <section
                        class="w-full bg-gray-200  shadow-md h-[180px] sm:h-[180px] md:h-[180px] lg:h-[250px] flex items-center justify-center">
                        <div class="text-center p-6">
                            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="text-gray-600 text-lg font-medium">{{ __('website.no_slider') }}</p>
                            
                        </div>
                    </section>
                @endif
                
                <section>
                    <div class="bg-[#0d3a37] text-white text-md sm:text-xl p-1 md:text-xl font-bold text-center">{{ __('website.welcome_title') }}</div>
                </section>

                <!-- About Content with Link -->
                <section class="bg-white rounded-lg shadow-md p-2">
                    <div class="flex flex-col sm:flex-row gap-4 items-center">
                        <!-- Image -->
                        <div class="w-full sm:w-1/3 h-36">
                            @if($setting && $setting->about_image_id)
                                @php
                                    $aboutImage = \App\Models\Gallery::find($setting->about_image_id);
                                @endphp
                                <img src="{{ $aboutImage ? asset('storage/' . $aboutImage->image) : asset('images/Bannerbuilding.jpeg') }}"
                                    alt="About College" class=" shadow w-full   md:h-36 lg:h-36 h-36 sm:h-36 object-cover">
                            @else
                                <img src="{{ asset('images/Bannerbuilding.jpeg') }}" alt="College Building"
                                    class=" shadow w-full md:h-36 lg:h-36 h-36 sm:h-36 object-cover">
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="w-full sm:w-2/3  text-justify">
                            <h3 class="text-lg font-bold text-gray-800 mb-2 hidden">
                                {{ $getLocalizedValue('about_title', __('website.about_college')) }}
                            </h3>
                            <p class="text-gray-700 text-sm leading-relaxed mb-1">
                                {{ Str::limit(strip_tags($getLocalizedValue('about_description', __('website.about_fallback'))), 300) }}
                            </p>
                            <a href="{{ route('dynamic.page', 'about') }}"
                                class="inline-block bg-[#0d3a37] text-white px-4 py-1.5 rounded text-xs font-medium hover:bg-green-800 transition">
                                {{ __('website.see_more') }}
                            </a>
                        </div>
                    </div>
                </section>

            </div>

            <!-- SECTION 2: Founder, Principal Cards + Visitor Counter (Right Column - 1/3 width) -->
            <div class="space-y-4">

                <!-- Founder & Principal Cards -->
                <div class="space-y-1">
                    <!-- Founder Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <div class="p-1">
                            <div class="flex items-center gap-3 mb-3">
                                <!-- Rounded Image -->
                                @if($setting && $setting->founder_image)
                                    <img src="{{ asset('storage/' . $setting->founder_image) }}"
                                        alt="{{ $setting->founder_name ?? __('website.founder_title') }}"
                                        class="w-24 h-24 rounded-full object-cover border-3 border-[#3dab8c] shadow">
                                @else
                                    <img src="{{ asset('images/logo.svg') }}" alt="{{ __('website.founder_title') }}"
                                        class="w-24 h-24 rounded-full object-cover border-3 border-[#3dab8c] shadow">
                                @endif
                                <div>
                                    <h3 class="text-base font-bold text-gray-800">
                                        {{ $getLocalizedValue('founder_name', __('website.founder_name')) }}
                                    </h3>
                                    <p class="text-xs text-gray-600">{{ $getLocalizedValue('founder_title', __('website.founder_title')) }}</p>
                                </div>
                            </div>
                            <p class="text-gray-700 text-xs leading-relaxed mb-3">
                                {{ Str::words($getLocalizedValue('founder_message', __('website.founder_fallback')), 10, '...') }}
                            </p>
                            <a href="{{ route('founder') }}"
                                class="inline-block bg-[#0d3a37] text-white px-4 py-1.5 rounded text-xs font-medium hover:bg-green-800 transition">
                                {{ __('website.see_more') }}
                            </a>
                        </div>
                    </div>

                    <!-- Principal Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <div class="p-1">
                            <div class="flex items-center gap-3 mb-3">
                                <!-- Rounded Image -->
                                @if($setting && $setting->principal_image)
                                    <img src="{{ asset('storage/' . $setting->principal_image) }}"
                                        alt="{{ $setting->principal_name ?? __('website.principal_title') }}"
                                        class="w-24 h-24 rounded-full object-cover border-3 border-[#3dab8c] shadow">
                                @else
                                    <img src="{{ asset('images/logo.svg') }}" alt="{{ __('website.principal_title') }}"
                                        class="w-24 h-24 rounded-full object-cover border-3 border-[#3dab8c] shadow">
                                @endif
                                <div>
                                    <h3 class="text-base font-bold text-gray-800">
                                        {{ $getLocalizedValue('principal_name', __('website.principal_name')) }}
                                    </h3>
                                    <p class="text-xs text-gray-600">{{ $getLocalizedValue('principal_title', __('website.principal_title')) }}</p>
                                </div>
                            </div>
                            <p class="text-gray-700 text-xs leading-relaxed mb-3">
                                {{ Str::words($getLocalizedValue('principal_message', __('website.principal_fallback')), 10, '...') }}
                            </p>
                            <a href="{{ route('principal') }}"
                                class="inline-block bg-[#0d3a37] text-white px-4 py-1.5 rounded text-xs font-medium hover:bg-green-800 transition">
                                {{ __('website.see_more') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Visitors Counter Small Card -->
                <div class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <div>
                                <p class="text-xs opacity-90">{{ __('website.total_visitors') }}</p>
                                <p class="text-2xl font-bold">{{ number_format($totalVisitors) }}</p>
                            </div>
                        </div>
                        <div class="border-l border-white/30 pl-3">
                            <p class="text-xs opacity-90 mb-1">{{ __('website.today') }}</p>
                            <p class="text-xl font-bold">{{ number_format($todayVisitors) }}</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection