@extends('layouts.app')

@section('title', 'Student Details - Hazera-Taju Degree College')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
        <!-- Header -->
        <div class="bg-[#0d3a37] p-6 text-center">
            <h1 class="text-2xl md:text-3xl font-bold text-white uppercase tracking-wider">{{ __('website.student_statistics') }}</h1>
            <p class="text-green-200 mt-2">{{ __('website.student_statistics_desc') }}</p>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            @if($hasError)
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('website.api_error') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('website.api_error_desc') }}</p>
                </div>
            @elseif(count($studentStats) > 0)
                @php
                    $grandTotal = 0;
                    $grandActive = 0;
                    $grandTc = 0;
                    $grandPassed = 0;
                @endphp
                @foreach($studentStats as $stat)
                    @foreach($stat['programs'] ?? [] as $program)
                        @php
                            $grandTotal += $program['total_students'] ?? 0;
                            $grandActive += $program['active'] ?? 0;
                            $grandTc += $program['tc'] ?? 0;
                            $grandPassed += $program['passed_out'] ?? 0;
                        @endphp
                    @endforeach
                @endforeach

                <!-- Summary Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-6 bg-gray-50 border-b">
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase">{{ __('website.total_students') }}</p>
                        <p class="text-2xl font-bold text-[#0d3a37] mt-1">{{ number_format($grandTotal) }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-green-200">
                        <p class="text-xs font-semibold text-green-600 uppercase">{{ __('website.active_students') }}</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ number_format($grandActive) }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-200">
                        <p class="text-xs font-semibold text-blue-600 uppercase">{{ __('website.tc_students') }}</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($grandTc) }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-amber-200">
                        <p class="text-xs font-semibold text-amber-600 uppercase">{{ __('website.passed_out_students') }}</p>
                        <p class="text-2xl font-bold text-amber-600 mt-1">{{ number_format($grandPassed) }}</p>
                    </div>
                </div>

                @foreach($studentStats as $stat)
                <div class="mb-6 last:mb-0">
                    <!-- Session Header -->
                    <div class="bg-[#0d3a37]/10 px-6 py-3 border-b">
                        <h2 class="text-lg font-bold text-[#0d3a37]">{{ __('website.session') }}: {{ $stat['session_name'] ?? '' }}</h2>
                    </div>

                    <table class="w-full border-collapse text-sm">
                        <thead>
                            <tr class="bg-gray-100 text-[#0d3a37] uppercase text-xs">
                                <th class="border border-gray-300 px-4 py-3 text-left min-w-[140px]">{{ __('website.program') }}</th>
                                <th class="border border-gray-300 px-4 py-3 text-left min-w-[140px]">{{ __('website.group') }}</th>
                                <th class="border border-gray-300 px-3 py-3 text-center bg-gray-50">{{ __('website.total') }}</th>
                                <th class="border border-gray-300 px-3 py-3 text-center bg-green-50">{{ __('website.active') }}</th>
                                <th class="border border-gray-300 px-3 py-3 text-center bg-blue-50">{{ __('website.tc') }}</th>
                                <th class="border border-gray-300 px-3 py-3 text-center bg-amber-50">{{ __('website.passed_out') }}</th>
                                <th class="border border-gray-300 px-3 py-3 text-center bg-red-50">{{ __('website.suspended') }}</th>
                                <th class="border border-gray-300 px-3 py-3 text-center bg-rose-50">{{ __('website.admission_cancelled') }}</th>
                                <th class="border border-gray-300 px-3 py-3 text-center bg-gray-100">{{ __('website.dropped') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($stat['programs'] ?? [] as $progIndex => $program)
                                @php $groups = $program['groups'] ?? []; @endphp
                                @foreach($groups as $groupIndex => $group)
                                <tr class="hover:bg-gray-50 transition-colors {{ $progIndex % 2 == 0 ? '' : 'bg-gray-50/30' }}">
                                    @if($groupIndex === 0)
                                    <td class="border border-gray-300 px-4 py-3 font-bold text-gray-900 bg-gray-50/50"
                                        rowspan="{{ count($groups) }}">
                                        {{ $program['program_name'] ?? '' }}
                                        <div class="text-[10px] font-normal text-gray-500 mt-0.5">
                                            Total: {{ number_format($program['total_students'] ?? 0) }}
                                        </div>
                                    </td>
                                    @endif
                                    <td class="border border-gray-300 px-4 py-3 font-medium text-gray-700">{{ $group['group_name'] ?? '' }}</td>
                                    <td class="border border-gray-300 px-3 py-3 text-center font-bold text-gray-900">{{ number_format($group['total'] ?? 0) }}</td>
                                    <td class="border border-gray-300 px-3 py-3 text-center font-bold text-green-600">{{ number_format($group['active'] ?? 0) }}</td>
                                    <td class="border border-gray-300 px-3 py-3 text-center font-bold text-blue-600">{{ number_format($group['tc'] ?? 0) }}</td>
                                    <td class="border border-gray-300 px-3 py-3 text-center font-bold text-amber-600">{{ number_format($group['passed_out'] ?? 0) }}</td>
                                    <td class="border border-gray-300 px-3 py-3 text-center font-bold text-red-600">{{ number_format($group['suspended'] ?? 0) }}</td>
                                    <td class="border border-gray-300 px-3 py-3 text-center font-bold text-rose-600">{{ number_format($group['admission_cancelled'] ?? 0) }}</td>
                                    <td class="border border-gray-300 px-3 py-3 text-center font-bold text-gray-500">{{ number_format($group['dropped'] ?? 0) }}</td>
                                </tr>
                                @endforeach
                            @endforeach
                            <!-- Program Total Row -->
                            @foreach($stat['programs'] ?? [] as $program)
                            <tr class="bg-[#0d3a37]/5 font-bold">
                                <td class="border border-gray-300 px-4 py-2 text-[#0d3a37]" colspan="2">{{ $program['program_name'] ?? '' }} {{ __('website.total') }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center">{{ number_format($program['total_students'] ?? 0) }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center text-green-600">{{ number_format($program['active'] ?? 0) }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center text-blue-600">{{ number_format($program['tc'] ?? 0) }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center text-amber-600">{{ number_format($program['passed_out'] ?? 0) }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center text-red-600">{{ number_format($program['suspended'] ?? 0) }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center text-rose-600">{{ number_format($program['admission_cancelled'] ?? 0) }}</td>
                                <td class="border border-gray-300 px-3 py-2 text-center text-gray-500">{{ number_format($program['dropped'] ?? 0) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
            @else
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('website.no_student_data') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('website.no_student_data_desc') }}</p>
                </div>
            @endif
        </div>

        <!-- Footer Legend -->
        <div class="p-6 bg-gray-50 border-t border-gray-200">
            <div class="flex flex-wrap gap-4 text-xs font-semibold uppercase tracking-wider">
                <div class="flex items-center"><span class="w-3 h-3 bg-green-600 rounded-full mr-2"></span>{{ __('website.active') }}</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-blue-600 rounded-full mr-2"></span>{{ __('website.tc') }}</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-amber-600 rounded-full mr-2"></span>{{ __('website.passed_out') }}</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-red-600 rounded-full mr-2"></span>{{ __('website.suspended') }}</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-rose-600 rounded-full mr-2"></span>{{ __('website.admission_cancelled') }}</div>
                <div class="flex items-center"><span class="w-3 h-3 bg-gray-500 rounded-full mr-2"></span>{{ __('website.dropped') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
