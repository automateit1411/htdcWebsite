@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ search: '' }">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('admin.daily_attendance_management') }}</h1>

        <div class="flex gap-2">
            <a href="{{ route('admin.daily-attendances.bulk-create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none whitespace-nowrap">
                {{ __('admin.bulk_add') }}
            </a>
            <a href="{{ route('admin.daily-attendances.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#3dab8c] hover:bg-[#0d3a37] focus:outline-none whitespace-nowrap">
                {{ __('admin.add_single') }}
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.date') }}</label>
                <input type="date" name="date" value="{{ request('date') }}" class="border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.program') }}</label>
                <select name="program" class="border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm">
                    <option value="">{{ __('admin.all_programs') }}</option>
                    <option value="HSC" {{ request('program') == 'HSC' ? 'selected' : '' }}>HSC</option>
                    <option value="Honours" {{ request('program') == 'Honours' ? 'selected' : '' }}>Honours</option>
                    <option value="Degree" {{ request('program') == 'Degree' ? 'selected' : '' }}>Degree</option>
                </select>
            </div>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#3dab8c] hover:bg-[#0d3a37]">
                {{ __('admin.filter') }}
            </button>
            @if(request('date') || request('program'))
                <a href="{{ route('admin.daily-attendances.index') }}" class="text-sm text-gray-500 hover:text-gray-700">{{ __('admin.clear') }}</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.date') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.program') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.group') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.total') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.present') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.absent') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.percentage') }}</th>
                        <th class="relative px-6 py-3">
                            <span class="sr-only">{{ __('admin.actions') }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($attendances as $attendance)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $attendance->date->format('d-M-Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $attendance->programGroup->program }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $attendance->programGroup->group_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $attendance->total_students }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $attendance->present_students }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $attendance->absent_students }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $percentage = $attendance->percentage;
                                $color = $percentage >= 80 ? 'green' : ($percentage >= 60 ? 'yellow' : 'red');
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
                                {{ number_format($percentage, 1) }}%
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.daily-attendances.edit', $attendance->id) }}" class="text-[#3dab8c] hover:text-[#0d3a37] mr-3 font-semibold">{{ __('admin.edit') }}</a>
                            <form action="{{ route('admin.daily-attendances.destroy', $attendance->id) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('admin.confirm_delete') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">{{ __('admin.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-sm text-gray-500">
                            {{ __('admin.no_attendance_records') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection
