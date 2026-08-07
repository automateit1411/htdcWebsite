@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="bulkAttendance()">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('admin.bulk_add_attendance') }}</h1>
        <a href="{{ route('admin.daily-attendances.index') }}" class="text-gray-500 hover:text-gray-700">{{ __('admin.back_to_list') }}</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.daily-attendances.bulk-store') }}" method="POST">
            @csrf

            <div class="mb-6 flex flex-wrap gap-4 items-end">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">{{ __('admin.date') }}</label>
                    <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" class="mt-1 block max-w-xs border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm" required>
                </div>
                <div>
                    <button type="button" @click="fetchFromSoftware()" :disabled="loading" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none disabled:opacity-50">
                        <svg x-show="!loading" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <svg x-show="loading" class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="loading ? '{{ __('admin.fetching') }}' : '{{ __('admin.fetch_from_software') }}'"></span>
                    </button>
                </div>
            </div>

            <div x-show="errorMsg" class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-sm text-red-800" x-text="errorMsg"></p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('admin.program') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('admin.group') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('admin.total_students') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('admin.present_students') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('admin.percentage') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($programGroups as $index => $group)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $group->program }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $group->group_name }}</td>
                            <td class="px-4 py-3">
                                <input type="hidden" name="attendances[{{ $index }}][program_group_id]" value="{{ $group->id }}">
                                <input type="number" name="attendances[{{ $index }}][total_students]"
                                    x-model="rows[{{ $index }}].total"
                                    min="0" class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm">
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="attendances[{{ $index }}][present_students]"
                                    x-model="rows[{{ $index }}].present"
                                    min="0" class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm">
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-semibold"
                                    :class="getPercentage({{ $index }}) >= 80 ? 'text-green-600' : (getPercentage({{ $index }}) >= 60 ? 'text-yellow-600' : 'text-red-600')">
                                    <span x-text="getPercentage({{ $index }}) + '%'">0%</span>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
                    <strong>{{ __('admin.note') }}</strong> Enter the number of total and present students for each group. Percentage and absent count will be calculated automatically.
                </p>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.daily-attendances.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                    {{ __('admin.cancel') }}
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] hover:from-green-600 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3dab8c]">
                    {{ __('admin.save_all_attendance') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function bulkAttendance() {
    const rows = {
        @foreach($programGroups as $index => $group)
        {{ $index }}: { total: 0, present: 0 },
        @endforeach
    };
    return {
        rows,
        loading: false,
        errorMsg: '',
        getPercentage(index) {
            const total = parseInt(this.rows[index].total) || 0;
            const present = parseInt(this.rows[index].present) || 0;
            if (total === 0) return '0.0';
            return ((present / total) * 100).toFixed(1);
        },
        async fetchFromSoftware() {
            this.loading = true;
            this.errorMsg = '';
            const date = document.getElementById('date').value;
            
            try {
                const response = await fetch(`/api/daily-attendance?date=${date}`, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success && result.data) {
                    const attendanceData = result.data;
                    
                    @foreach($programGroups as $index => $group)
                    if (attendanceData[{{ $group->id }}]) {
                        this.rows[{{ $index }}].total = attendanceData[{{ $group->id }}].total_students || 0;
                        this.rows[{{ $index }}].present = attendanceData[{{ $group->id }}].present_students || 0;
                    }
                    @endforeach
                } else {
                    this.errorMsg = result.message || 'No data found from software';
                }
            } catch (error) {
                this.errorMsg = 'Failed to fetch data from software. Please check connection.';
                console.error('Fetch error:', error);
            } finally {
                this.loading = false;
            }
        }
    };
}
</script>
@endsection
