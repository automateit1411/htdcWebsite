@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="max-w-7xl mx-auto px-4">
        {{-- Page Header --}}
        <div class="mb-6 text-center">
            <h1 class="text-2xl md:text-3xl font-black text-gray-900 leading-tight">
                {{ $page->title ?? $page->page_name }}
            </h1>
            <div class="w-24 h-1.5 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] mx-auto mt-2 rounded-full"></div>
            @if($page->description)
                <p class="text-gray-600 mt-3 max-w-2xl mx-auto">{{ $page->description }}</p>
            @endif
        </div>

        {{-- Items Grid --}}
        @if($page->items->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($page->items as $item)
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden group hover:shadow-2xl hover:border-[#3dab8c] transition-all duration-300">
                        @if($item->image_path)
                            <div class="h-56 overflow-hidden relative">
                                <img src="{{ asset('storage/' . $item->image_path) }}" 
                                     alt="{{ $item->title }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                        @endif
                        <div class="p-5">
                            @if($item->title)
                                <h3 class="font-bold text-gray-800 text-lg group-hover:text-[#3dab8c] transition-colors">{{ $item->title }}</h3>
                            @endif
                            @if($item->description)
                                <p class="text-sm text-gray-500 mt-2 leading-relaxed">{{ $item->description }}</p>
                            @endif
                            @if($item->file_path)
                                <div class="mt-4">
                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                       class="inline-flex items-center gap-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white px-4 py-2 rounded-lg font-bold text-sm shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Download File
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-xl shadow-lg border border-gray-100">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-400 text-lg">No items available yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
