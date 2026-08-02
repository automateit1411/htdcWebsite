@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-[#0d3a37] mb-2">Useful Links</h1>
            <p class="text-gray-600 italic">"Quick access to important websites and resources."</p>
            <div class="w-20 h-1 bg-green-500 mx-auto mt-4 rounded-full"></div>
        </div>

        @if($links->count())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($links as $link)
            <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                class="group bg-white rounded-xl shadow-md border border-gray-100 p-5 hover:shadow-lg hover:border-green-300 transition-all duration-300 flex items-center gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-[#0d3a37] rounded-lg flex items-center justify-center group-hover:bg-[#3dab8c] transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-semibold text-[#0d3a37] group-hover:text-[#3dab8c] transition-colors truncate">{{ $link->name }}</h3>
                    <p class="text-sm text-gray-500 truncate mt-0.5">{{ $link->url }}</p>
                </div>
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-hover:text-[#3dab8c] transition-colors transform group-hover:translate-x-1 duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 bg-white rounded-xl shadow-md border border-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
            </svg>
            <p class="text-gray-500 text-lg">No links available at the moment.</p>
            <p class="text-gray-400 text-sm mt-1">Please check back later.</p>
        </div>
        @endif
    </div>
</div>
@endsection
