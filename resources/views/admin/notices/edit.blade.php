@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Edit Notice</h1>
        <a href="{{ route('admin.notices.index') }}" class="text-gray-500 hover:text-gray-700">Back to List</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.notices.update', $notice->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ $notice->title }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm" required>
            </div>

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                <textarea name="content" id="content" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm">{{ $notice->content }}</textarea>
            </div>

            <div class="mb-6">
                <label for="file" class="block text-sm font-medium text-gray-700">Notice File (PDF or Image)</label>
                @if($notice->file_path)
                    <div class="mt-2 mb-2 p-3 bg-gray-50 rounded-md flex items-center justify-between">
                        <div class="flex items-center">
                            @php
                                $extension = pathinfo($notice->file_path, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                            @endphp
                            @if($isImage)
                                <svg class="w-8 h-8 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            @else
                                <svg class="w-8 h-8 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            @endif
                            <span class="text-sm text-gray-600">{{ basename($notice->file_path) }}</span>
                        </div>
                        <a href="{{ asset('storage/' . $notice->file_path) }}" target="_blank" class="text-xs text-[#3dab8c] hover:text-[#0d3a37] font-medium">View Current</a>
                    </div>
                @endif
                <input type="file" name="file" id="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#3dab8c]/10 file:text-[#0d3a37] hover:file:bg-[#3dab8c]/20">
                <p class="mt-1 text-xs text-gray-500">Accepted formats: PDF, PNG, JPG, JPEG (Max 5MB). Leave empty to keep current file.</p>
            </div>

            <div class="mb-6 flex items-center">
                <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-[#3dab8c] focus:ring-[#3dab8c] border-gray-300 rounded" {{ $notice->is_active ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 block text-sm text-gray-900">Is Active</label>
            </div>

            <!-- Status Information -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm font-medium text-blue-900 mb-2">Notice Status Information:</p>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <span class="text-xs text-gray-500 mr-2">Current Status:</span>
                        @if($notice->isNew())
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">New</span>
                        @else
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Old</span>
                        @endif
                    </div>
                    <div class="text-xs text-blue-800">
                        (Created: {{ $notice->created_at->format('M d, Y') }})
                    </div>
                </div>
                <p class="mt-2 text-xs text-blue-700">• Notices remain "New" for 7 days after creation.</p>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.notices.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] hover:from-green-600 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3dab8c]">
                    Update Notice
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
