@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Gallery</h1>
        <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#3dab8c] hover:bg-[#0d3a37] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3dab8c]">
            Add Image
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($galleries as $gallery)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group">
            <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="object-cover w-full h-48">
            </div>
            <div class="p-4">
                <h3 class="text-lg font-medium text-gray-900 truncate">{{ $gallery->title ?: 'Untitled' }}</h3>
                <p class="text-sm text-gray-500">{{ $gallery->category }}</p>
                <div class="mt-4 flex justify-end">
                    <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $galleries->links() }}
    </div>
</div>
@endsection
