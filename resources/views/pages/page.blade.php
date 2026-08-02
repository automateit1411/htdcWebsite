@extends('layouts.app')

@section('content')
    <div class="py-1">
        <div class="max-w-7xl mx-auto px-1">
            {{-- Page Header --}}
            <div class="mb-4 text-center">
                <h1 class="text-2xl md:text-3xl font-black text-gray-900 leading-tight">
                    {{ $page->title ?? $page->page_name }}
                </h1>
                <div class="w-24 h-1.5 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] mx-auto mt-1 rounded-full"></div>
            </div>

            {{-- Page Content Card --}}
            @php
                $hasImage = isset($page->image_path) && $page->image_path;
                $description = isset($page->description) ? trim($page->description) : '';
                $hasDescription = !empty($description);
            @endphp

            @if($hasImage || $hasDescription)
                <div class="bg-white shadow-xl border border-gray-100 p-1 overflow-hidden">
                    {{-- Floating Image Section --}}
                    @if($hasImage)
                        <div
                            class="float-left mr-2 mb-1 w-full md:w-1/2 lg:w-2/5 max-w-[500px] relative group overflow-hidden shadow-lg">
                            <img src="{{ asset('storage/' . ltrim($page->image_path, '/')) }}"
                                alt="{{ $page->title ?? $page->page_name }}"
                                class="w-full h-auto object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-tr from-black/5 to-transparent"></div>
                        </div>
                    @endif

                    {{-- Description Section --}}
                    @if($hasDescription)
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed text-justify">
                            {!! nl2br(e($page->description)) !!}
                        </div>
                    @endif

                    {{-- File Attachment --}}
                    @if($page->file_path)
                        <div class="clear-both pt-6">
                            <a href="{{ asset('storage/' . ltrim($page->file_path, '/')) }}" target="_blank"
                               class="inline-flex items-center gap-3 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download Attachment
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <style>
        .prose p {
            margin-bottom: 1.5rem;
        }

        .prose {
            font-family: 'Inter', sans-serif;
        }
    </style>
@endsection
