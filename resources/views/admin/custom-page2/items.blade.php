@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Items: <span class="text-[#3dab8c]">{{ $custom_page2->page_name }}</span></h1>
            <p class="text-gray-500 mt-1">/slug: {{ $custom_page2->slug }} | {{ $items->count() }} items</p>
        </div>
        <a href="{{ route('admin.custom-page2.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium shadow-sm">&larr; Back</a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-[#3dab8c] text-[#0d3a37] rounded-r-xl">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Add New Item --}}
    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-[#3dab8c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Add New Item
        </h2>
        <form action="{{ route('admin.custom-page2.store-item', $custom_page2->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Item Title</label>
                    <input type="text" name="title" class="w-full px-4 py-3 border-2 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent outline-none" placeholder="e.g. Year 2024 Calendar">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="2" class="w-full px-4 py-3 border-2 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent outline-none" placeholder="Optional description..."></textarea>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-3 border-2 border-dashed border-gray-200 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#3dab8c] file:text-white file:font-bold file:cursor-pointer">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">File (PDF/Doc)</label>
                    <input type="file" name="file" class="w-full px-4 py-3 border-2 border-dashed border-gray-200 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#0d3a37] file:text-white file:font-bold file:cursor-pointer">
                </div>
            </div>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white rounded-xl font-bold shadow-lg hover:shadow-2xl transition-all">Add Item</button>
        </form>
    </div>

    {{-- Existing Items --}}
    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Existing Items</h2>
        @if($items->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($items as $item)
                    <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden group hover:shadow-lg transition-all">
                        @if($item->image_path)
                            <div class="h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $item->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @else
                            <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800">{{ $item->title ?? 'Untitled' }}</h3>
                            @if($item->description)
                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $item->description }}</p>
                            @endif
                            <div class="flex items-center gap-2 mt-3">
                                @if($item->file_path)
                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="text-xs bg-blue-500 text-white px-3 py-1 rounded-lg font-bold hover:bg-blue-600 transition">File</a>
                                @endif
                                <form action="{{ route('admin.custom-page2.destroy-item', [$custom_page2->id, $item->id]) }}" method="POST" onsubmit="return confirm('Delete this item?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs bg-red-500 text-white px-3 py-1 rounded-lg font-bold hover:bg-red-600 transition">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 text-gray-400">
                <p>No items added yet. Use the form above to add images & files.</p>
            </div>
        @endif
    </div>
</div>
@endsection
