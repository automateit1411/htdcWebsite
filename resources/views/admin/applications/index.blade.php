@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ search: '', selected: [], selectAll: false }">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full md:w-auto">
            <h1 class="text-2xl font-bold text-gray-800">Student Applications</h1>
            <form method="GET" action="{{ route('admin.applications.index') }}" class="flex gap-2" id="filter-form">
                <select name="program" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-[#3dab8c] focus:ring-[#3dab8c]" onchange="document.getElementById('filter-form').submit()">
                    <option value="">All Programs</option>
                    @foreach($options['programs'] as $p)
                        <option value="{{ $p['id'] }}" {{ request('program') == $p['id'] ? 'selected' : '' }}>{{ $p['name'] ?? $p['id'] }}</option>
                    @endforeach
                </select>
                <select name="session" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-[#3dab8c] focus:ring-[#3dab8c]" onchange="document.getElementById('filter-form').submit()">
                    <option value="">All Sessions</option>
                    @foreach($options['sessions'] as $s)
                        <option value="{{ $s['id'] ?? $s }}" {{ request('session') == ($s['id'] ?? $s) ? 'selected' : '' }}>{{ $s['session'] ?? ($s['name'] ?? $s) }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        
        <!-- Search and Action Field -->
        <div class="flex gap-2 w-full md:w-auto md:max-w-md lg:ml-auto">
            <template x-if="selected.length > 0">
                <button type="submit" form="bulk-delete-form" class="bg-red-600 text-white px-4 py-2 rounded-md shadow focus:outline-none hover:bg-red-700 font-semibold text-sm flex-shrink-0 transition-opacity" onclick="return confirm('Are you sure you want to delete the selected applications? This cannot be undone.')">
                    Delete (<span x-text="selected.length"></span>)
                </button>
            </template>
            <div class="relative flex-1">
                <input type="text" x-model="search" placeholder="Search by name or mobile..." class="w-full pl-10 pr-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-[#3dab8c] focus:ring focus:ring-[#3dab8c] focus:ring-opacity-50 text-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <form id="bulk-delete-form" method="POST" action="{{ route('admin.applications.bulk-delete') }}" class="hidden">
        @csrf
    </form>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="h-[calc(100vh-250px)] overflow-y-auto pr-1 overflow-x-auto relative custom-scrollbar">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0 z-10 shadow-sm">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left">
                            <input type="checkbox" x-model="selectAll" @change="selected = selectAll ? {{ json_encode($applications->pluck('id')) }} : []" class="rounded text-[#3dab8c] focus:ring-[#3dab8c] cursor-pointer">
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pincode</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Session</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobile</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($applications as $application)
                    <tr class="hover:bg-gray-50 transition-colors" x-show="search === '' || '{{ strtolower(str_replace(["'", "\\"], ["\'", "\\\\"], $application->sNameEnglish . ' ' . $application->sMobileNo . ' ' . $application->pinCode)) }}'.includes(search.toLowerCase())">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <input type="checkbox" name="ids[]" value="{{ $application->id }}" x-model="selected" form="bulk-delete-form" class="rounded text-[#3dab8c] focus:ring-[#3dab8c] cursor-pointer">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ $application->sPicture ?? 'https://ui-avatars.com/api/?name='.urlencode($application->sNameEnglish).'&background=3dab8c&color=fff' }}" alt="{{ $application->sNameEnglish }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded bg-gray-100 text-gray-800">{{ $application->pinCode ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $application->sNameEnglish }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $options['programs']->get($application->program)['name'] ?? $application->program }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $options['sessions']->get($application->session)['session'] ?? ($options['sessions']->get($application->session)['name'] ?? $application->session) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $application->sMobileNo }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($application->status == 0)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Proceed Done</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $application->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('admin.applications.destroy', $application->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this application?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $applications->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
