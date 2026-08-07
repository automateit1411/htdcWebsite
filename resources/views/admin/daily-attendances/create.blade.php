@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('admin.add_attendance') }}</h1>
        <a href="{{ route('admin.daily-attendances.index') }}" class="text-gray-500 hover:text-gray-700">{{ __('admin.back_to_list') }}</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.daily-attendances.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">{{ __('admin.date') }}</label>
                    <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm" required>
                </div>

                <div>
                    <label for="program_group_id" class="block text-sm font-medium text-gray-700">{{ __('admin.program_group') }}</label>
                    <select name="program_group_id" id="program_group_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm" required>
                        <option value="">{{ __('admin.select_group') }}</option>
                        @foreach($programGroups as $group)
                            <option value="{{ $group->id }}" {{ old('program_group_id') == $group->id ? 'selected' : '' }}>
                                {{ $group->program }} - {{ $group->group_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="total_students" class="block text-sm font-medium text-gray-700">{{ __('admin.total_students') }}</label>
                    <input type="number" name="total_students" id="total_students" value="{{ old('total_students') }}" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm" required>
                </div>

                <div>
                    <label for="present_students" class="block text-sm font-medium text-gray-700">{{ __('admin.present_students') }}</label>
                    <input type="number" name="present_students" id="present_students" value="{{ old('present_students') }}" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm" required>
                </div>
            </div>

            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
                    <strong>{{ __('admin.note') }}</strong> Percentage will be calculated automatically (Present / Total × 100). Absent students will be calculated as (Total - Present).
                </p>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.daily-attendances.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                    {{ __('admin.cancel') }}
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] hover:from-green-600 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3dab8c]">
                    {{ __('admin.save_attendance') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
