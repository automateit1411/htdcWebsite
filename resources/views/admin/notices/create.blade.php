@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('admin.create_notice') }}</h1>
        <a href="{{ route('admin.notices.index') }}" class="text-gray-500 hover:text-gray-700">{{ __('admin.back_to_list') }}</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.notices.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700">{{ __('admin.title') }}</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm" required>
            </div>

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700">{{ __('admin.content') }}</label>
                <textarea name="content" id="content" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm"></textarea>
            </div>

            <div class="mb-6">
                <label for="file" class="block text-sm font-medium text-gray-700">{{ __('admin.notice_file') }}</label>
                <input type="file" name="file" id="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#3dab8c]/10 file:text-[#0d3a37] hover:file:bg-[#3dab8c]/20">
                <p class="mt-1 text-xs text-gray-500">{{ __('admin.accepted_formats') }}</p>
            </div>

            <div class="mb-6 flex items-center">
                <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-[#3dab8c] focus:ring-[#3dab8c] border-gray-300 rounded" checked>
                <label for="is_active" class="ml-2 block text-sm text-gray-900">{{ __('admin.is_active') }}</label>
            </div>

            <!-- Status Information -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm font-medium text-blue-900 mb-2">{{ __('admin.notice_status') }}</p>
                <ul class="text-xs text-blue-800 space-y-1">
                    <li>• {{ __('admin.status_auto_calc') }}</li>
                    <li>• <strong>{{ __('admin.new') }}</strong>: Notices created within the last 7 days</li>
                    <li>• <strong>{{ __('admin.old') }}</strong>: Notices older than 7 days</li>
                    <li>• A "New" badge with animated GIF will appear on the website for new notices</li>
                </ul>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.notices.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                    {{ __('admin.cancel') }}
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] hover:from-green-600 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3dab8c]">
                    {{ __('admin.create_notice') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
