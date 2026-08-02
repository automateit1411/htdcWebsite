@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Database Export</h1>
            <p class="text-sm text-gray-500 mt-1">Database: <span class="font-mono bg-gray-100 px-2 py-0.5 rounded">{{ $dbName }}</span></p>
        </div>
        <a href="{{ route('admin.database-export.download-all') }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-[#0d3a37] to-[#3dab8c] text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Download All Tables (ZIP)
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Table Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Columns</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rows</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($tableList as $index => $table)
                <tr class="hover:bg-green-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <span class="font-mono text-sm font-semibold text-[#0d3a37] bg-green-50 px-2.5 py-1 rounded-md">{{ $table['name'] }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $table['column_count'] }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ number_format($table['rows']) }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.database-export.download', $table['name']) }}" 
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#3dab8c] text-white text-sm font-medium rounded-lg hover:bg-[#0d3a37] transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            SQL
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">No tables found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Media Backup</h2>
            <a href="{{ route('admin.database-export.media.download-all') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-[#0d3a37] to-[#3dab8c] text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Download All Media (ZIP)
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Folder Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Files</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Size</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($mediaFolders as $index => $folder)
                    <tr class="hover:bg-green-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-sm font-semibold text-[#0d3a37] bg-green-50 px-2.5 py-1 rounded-md">{{ $folder['name'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $folder['file_count'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $folder['total_size_formatted'] }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.database-export.media.download', $folder['name']) }}" 
                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#3dab8c] text-white text-sm font-medium rounded-lg hover:bg-[#0d3a37] transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">No media folders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
