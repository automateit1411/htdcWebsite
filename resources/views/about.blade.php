@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto space-y-1 py-2">

        {{-- Page Header --}}
        <div class="text-center mb-1 bg-white ">
            <h1
                class="text-1xl md:text-4xl font-bold mb-4 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] bg-clip-text text-transparent inline-block">
                {{ $page->title }}
            </h1>
            <div class="w-24 h-1 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] mx-auto rounded-full"></div>
        </div>

        {{-- About Content --}}
        <div class="bg-white rounded shadow-lg overflow-hidden p-2">
            <div class="flex flex-col lg:flex-row">

                {{-- Image --}}
                @if($page->image)
                    <div class="lg:w-2/5">
                        <img src="{{ $page->image }}" alt="{{ $page->title }}" class="w-full h-64 lg:h-full object-cover">
                    </div>
                @endif

                {{-- Content --}}
                <div class="{{ $page->image ? 'lg:w-3/5' : 'w-full' }} p-3 flex flex-col justify-center">
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection