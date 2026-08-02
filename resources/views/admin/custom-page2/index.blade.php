@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Pages Control 2</h1>
            <p class="text-gray-500 mt-1">Manage pages with multiple images & files.</p>
        </div>
        <a href="{{ route('admin.custom-page2.create') }}" class="px-6 py-3 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white rounded-xl font-bold shadow-lg hover:shadow-2xl transition-all">
            + Create Page
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-[#3dab8c] text-[#0d3a37] rounded-r-xl">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-bold">ID</th>
                    <th class="px-6 py-4 text-left text-sm font-bold">Page Name</th>
                    <th class="px-6 py-4 text-left text-sm font-bold">Title</th>
                    <th class="px-6 py-4 text-left text-sm font-bold">Slug</th>
                    <th class="px-6 py-4 text-left text-sm font-bold">Items</th>
                    <th class="px-6 py-4 text-left text-sm font-bold">Status</th>
                    <th class="px-6 py-4 text-center text-sm font-bold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pages as $page)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $page->id }}</td>
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $page->page_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $page->title ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">/{{ $page->slug }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-[#3dab8c]/10 text-[#0d3a37] text-xs font-bold px-3 py-1 rounded-full">{{ $page->items()->count() }} items</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($page->status)
                            <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">Active</span>
                        @else
                            <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.custom-page2.items', $page->id) }}" class="px-3 py-1.5 bg-blue-500 text-white text-xs font-bold rounded-lg hover:bg-blue-600 transition">Items</a>
                            <a href="{{ route('admin.custom-page2.edit', $page->id) }}" class="px-3 py-1.5 bg-amber-500 text-white text-xs font-bold rounded-lg hover:bg-amber-600 transition">Edit</a>
                            <form action="{{ route('admin.custom-page2.destroy', $page->id) }}" method="POST" onsubmit="return confirm('Delete this page and all items?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1.5 bg-red-500 text-white text-xs font-bold rounded-lg hover:bg-red-600 transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">No pages found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $pages->links() }}</div>
</div>
@endsection
