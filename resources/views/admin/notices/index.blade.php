@extends('layouts.admin')

@section('content')
    <div x-data="{ search: '' }">
        <!-- Header -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h1 class="text-2xl font-bold text-gray-800">{{ __('admin.all_notices') }}</h1>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <div class="relative">
                    <input type="text" x-model="search" placeholder="{{ __('admin.search') }}..." class="w-full pl-10 pr-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-[#3dab8c] focus:ring focus:ring-[#3dab8c] focus:ring-opacity-50 text-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <a href="{{ route('admin.notices.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#3dab8c] hover:bg-[#0d3a37] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3dab8c] whitespace-nowrap">
                    {{ __('admin.create_notice') }}
                </a>
            </div>
        </div>

        <!-- Notices Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.notice_title') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.is_active') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.created_at') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($notices as $notice)
                    <tr class="hover:bg-gray-50 transition-colors" x-show="search === '' || '{{ strtolower(str_replace(["'", "\\"], ["\'", "\\\\"], $notice->title)) }}'.includes(search.toLowerCase())">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $notice->id }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $notice->title }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit(strip_tags($notice->content), 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($notice->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ __('admin.active') }}</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ __('admin.inactive') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $notice->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.notices.edit', $notice->id) }}" class="text-[#3dab8c] hover:text-[#0d3a37] mr-3">{{ __('admin.edit') }}</a>
                            <form action="{{ route('admin.notices.destroy', $notice->id) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">{{ __('admin.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $notices->links() }}
        </div>
    </div>
@endsection
