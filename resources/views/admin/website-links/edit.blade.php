@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('admin.edit_website_link') }}</h1>
        <a href="{{ route('admin.website-links.index') }}" class="text-gray-500 hover:text-gray-700">{{ __('admin.back_to_list') }}</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.website-links.update', $link->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('admin.link_name') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name', $link->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm" required>
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="url" class="block text-sm font-medium text-gray-700">{{ __('admin.url') }}</label>
                <input type="url" name="url" id="url" value="{{ old('url', $link->url) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm" required>
                @error('url') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="sort_order" class="block text-sm font-medium text-gray-700">{{ __('admin.sort_order') }}</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $link->sort_order) }}" min="0" class="mt-1 block w-32 border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm">
            </div>

            <div class="mb-6 flex items-center">
                <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-[#3dab8c] focus:ring-[#3dab8c] border-gray-300 rounded" {{ $link->is_active ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 block text-sm text-gray-900">{{ __('admin.active_on_website') }}</label>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.website-links.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                    {{ __('admin.cancel') }}
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] hover:from-green-600 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3dab8c]">
                    {{ __('admin.update_link') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
