@extends('layouts.app')

@section('title', 'Gallery - Hazera-Taju Degree College')

@section('content')
    @php
        // Fetch gallery items directly from the model as requested (backend is untouched)
        $items = \App\Models\Gallery::latest()->get();
        $categories = $items->pluck('category')->filter(function ($value) {
            return !empty(trim($value));
        })->unique();
    @endphp

    <div class="max-w-7xl mx-auto space-y-3 py-2 px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-1 bg-white shadow">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900  tracking-tight">
                <span class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] bg-clip-text text-transparent">{{ __('website.gallery_title') }}</span>
            </h1>
            <p class="text-gray-500 max-w-2xl mx-auto text-lg">{{ __('website.gallery_desc') }}</p>
        </div>

        <!-- Gallery Context -->
        <div x-data="galleryApp()" class="space-y-2">
            <!-- Filter Buttons -->
            @if($items->count() > 0)
                <div class="flex flex-wrap justify-center gap-1 ">
                    <button @click="setFilter('all')"
                        :class="activeFilter === 'all' ? 'bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white shadow-lg shadow-[#3dab8c]/30' : 'bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900 border border-gray-200'"
                        class="px-3  rounded font-semibold transition-all duration-300 transform hover:scale-105 active:scale-95">
                        {{ __('website.all') }}
                    </button>
                    @foreach($categories as $category)
                        <button @click="setFilter('{{ $category }}')"
                            :class="activeFilter === '{{ $category }}' ? 'bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white shadow-lg shadow-[#3dab8c]/30' : 'bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900 border border-gray-200'"
                            class="px-3  rounded font-semibold transition-all duration-300 transform hover:scale-105 active:scale-95">
                            {{ $category }}
                        </button>
                    @endforeach
                </div>
            @endif

            <!-- Gallery Grid -->
            @if($items->count() === 0)
                <div class="bg-gray-50 rounded p-8 text-center border border-gray-100 shadow-inner">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ __('website.no_photos') }}</h3>
                    <p class="text-gray-500 text-lg">{{ __('website.no_photos_desc') }}</p>
                </div>
            @else
                <div class="h-[calc(100vh-200px)] overflow-y-auto pr-2">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 relative" x-ref="grid">
                        @foreach($items as $index => $item)
                            <!-- Alpine logic for filtering smoothly -->
                            <div x-show="activeFilter === 'all' || activeFilter === '{{ $item->category }}'"
                                x-transition:enter="transition-all ease-out duration-500"
                                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition-all ease-in duration-300"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                                style="display: none;"
                                class="group relative overflow-hidden rounded cursor-pointer shadow-md hover:shadow-2xl transition-all duration-500 bg-gray-100 aspect-[4/3] w-full"
                                @click="openLightbox({{ $index }})">

                                <!-- Image Container -->
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title ?? 'Gallery Image' }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">

                                <!-- Overlay Gradient -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                </div>

                                <!-- Icon Overlay (Center) -->
                                <div
                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 delay-75">
                                    <div
                                        class="bg-white/20 backdrop-blur-md rounded p-2 transform scale-50 group-hover:scale-100 transition-transform duration-500 ease-out">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Info Overlay (Bottom) -->
                                <div
                                    class="absolute bottom-0 left-0 right-0 p-5 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 delay-100">
                                    @if(isset($item->title) && !empty($item->title))
                                        <h3 class="text-white font-bold text-lg leading-tight mb-1">{{ $item->title }}</h3>
                                    @endif
                                    @if(isset($item->category) && !empty($item->category))
                                        <span
                                            class="inline-block px-3 py-1 bg-[#3dab8c]/80 backdrop-blur-sm text-xs font-semibold rounded text-white mt-2">
                                            {{ $item->category }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Lightbox Modal -->
            <div x-show="lightboxOpen"
                class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-md"
                style="display: none;" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" @keydown.window.escape="closeLightbox()"
                @keydown.window.arrow-right="nextImage()" @keydown.window.arrow-left="prevImage()">

                <!-- Close Area Backdrop -->
                <div class="absolute inset-0" @click="closeLightbox()"></div>

                <!-- Close Button -->
                <button @click="closeLightbox()"
                    class="absolute top-6 right-6 lg:top-8 lg:right-8 z-50 text-white/70 hover:text-white hover:bg-white/10 rounded p-2 transition-colors">
                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <!-- Previous Button -->
                <button @click="prevImage()"
                    class="absolute left-4 lg:left-8 z-50 text-white/70 hover:text-white hover:bg-white/10 rounded p-3 transition-colors"
                    x-show="images.length > 1">
                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <!-- Image Content Container -->
                <div class="relative z-10 w-full max-w-6xl mx-auto flex flex-col items-center justify-center p-4 h-full pointer-events-none"
                    x-transition:enter="transition ease-out duration-300 delay-100"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

                    <template x-if="currentImage">
                        <div class="relative max-h-[80vh] flex justify-center items-center pointer-events-auto">
                            <img :src="currentImage.src" :alt="currentImage.title"
                                class="max-w-full max-h-[80vh] object-contain rounded shadow-xl">
                        </div>
                    </template>

                    <template x-if="currentImage">
                        <div class="text-center mt-6 pointer-events-auto">
                            <h3 class="text-white text-2xl font-bold tracking-wide" x-text="currentImage.title"></h3>
                            <p class="text-white/70 mt-2 text-sm uppercase tracking-widest font-medium"
                                x-text="currentImage.category"></p>
                        </div>
                    </template>
                </div>

                <!-- Next Button -->
                <button @click="nextImage()"
                    class="absolute right-4 lg:right-8 z-50 text-white/70 hover:text-white hover:bg-white/10 rounded p-3 transition-colors"
                    x-show="images.length > 1">
                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('galleryApp', () => ({
                activeFilter: 'all',
                lightboxOpen: false,
                currentIndex: 0,
                images: [],

                init() {
                    // Load JSON encoded array directly from blade for JS compatibility
                    this.images = @json($items->map(function ($item) {
                        return [
                            'src' => asset('storage/' . $item->image),
                            'title' => $item->title ?? '',
                            'category' => $item->category ?? ''
                        ];
                    }));

                    // Setup items to show properly on init since we added style display none
                    this.$nextTick(() => {
                        const elements = this.$refs.grid?.children || [];
                        for (let i = 0; i < elements.length; i++) {
                            elements[i].style.display = '';
                        }
                    });

                    // Watch for modal change to toggle body overflow
                    this.$watch('lightboxOpen', value => {
                        if (value) {
                            document.body.classList.add('overflow-hidden');
                        } else {
                            document.body.classList.remove('overflow-hidden');
                        }
                    });
                },

                get currentImage() {
                    return this.images[this.currentIndex] || null;
                },

                setFilter(filter) {
                    this.activeFilter = filter;
                },

                openLightbox(index) {
                    this.currentIndex = index;
                    this.lightboxOpen = true;
                },

                closeLightbox() {
                    this.lightboxOpen = false;
                },

                nextImage() {
                    if (this.images.length > 0) {
                        this.currentIndex = (this.currentIndex + 1) % this.images.length;
                    }
                },

                prevImage() {
                    if (this.images.length > 0) {
                        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                    }
                }
            }));
        });
    </script>
@endsection