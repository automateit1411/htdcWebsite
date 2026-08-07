@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('admin.edit') }}: {{ $custom_page2->page_name }}</h1>
        <a href="{{ route('admin.custom-page2.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium shadow-sm">&larr; {{ __('admin.back') }}</a>
    </div>

    <form action="{{ route('admin.custom-page2.update', $custom_page2->id) }}" method="POST" class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 space-y-6">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('admin.page_name') }} *</label>
                <input type="text" name="page_name" value="{{ old('page_name', $custom_page2->page_name) }}" required class="w-full px-5 py-3 border-2 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent outline-none text-lg">
                @error('page_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('admin.page_name_bn') }}</label>
                <input type="text" name="page_name_bn" value="{{ old('page_name_bn', $custom_page2->page_name_bn) }}" class="w-full px-5 py-3 border-2 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent outline-none text-lg bn-font">
                @error('page_name_bn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('admin.display_title') }}</label>
                <input type="text" name="title" value="{{ old('title', $custom_page2->title) }}" class="w-full px-5 py-3 border-2 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent outline-none text-lg">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('admin.display_title_bn') }}</label>
                <input type="text" name="title_bn" value="{{ old('title_bn', $custom_page2->title_bn) }}" class="w-full px-5 py-3 border-2 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent outline-none text-lg bn-font">
            </div>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('admin.description') }}</label>
            <textarea name="description" rows="4" class="w-full px-5 py-3 border-2 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent outline-none">{{ old('description', $custom_page2->description) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('admin.description') }} (বাংলা)</label>
            <textarea name="description_bn" rows="4" class="w-full px-5 py-3 border-2 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent outline-none bn-font">{{ old('description_bn', $custom_page2->description_bn) }}</textarea>
        </div>
        <div class="flex items-center gap-3">
            <input type="checkbox" name="status" value="1" {{ $custom_page2->status ? 'checked' : '' }} class="w-5 h-5 text-[#3dab8c] rounded">
            <label class="text-sm font-bold text-gray-700">{{ __('admin.active') }}</label>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('admin.custom_route_optional') }}</label>
            <input type="text" name="route" value="{{ old('route', $custom_page2->route) }}" class="w-full px-5 py-3 border-2 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent outline-none" placeholder="e.g. academic-calendar">
            <p class="text-xs text-gray-400 mt-1">Leave empty to use default /p2/slug</p>
        </div>
        <button type="submit" class="px-8 py-4 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white rounded-xl font-bold shadow-lg hover:shadow-2xl transition-all">{{ __('admin.update_page') }}</button>
    </form>
</div>
@endsection
