@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Edit Teacher Application</h1>
        <a href="{{ route('admin.teacher-applications.index') }}" class="text-gray-500 hover:text-gray-700">Back to List</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <div class="mt-1 p-2 w-full bg-gray-50 border border-gray-300 rounded-md">{{ $teacherApplication->teacherName }}</div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1 p-2 w-full bg-gray-50 border border-gray-300 rounded-md">{{ $teacherApplication->email }}</div>
            </div>
             <div>
                <label class="block text-sm font-medium text-gray-700">Mobile</label>
                <div class="mt-1 p-2 w-full bg-gray-50 border border-gray-300 rounded-md">{{ $teacherApplication->mobile }}</div>
            </div>
             <div>
                <label class="block text-sm font-medium text-gray-700">Designation</label>
                <div class="mt-1 p-2 w-full bg-gray-50 border border-gray-300 rounded-md">{{ $teacherApplication->designation }}</div>
            </div>
        </div>

        <form action="{{ route('admin.teacher-applications.update', $teacherApplication->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#3dab8c] focus:border-[#3dab8c] sm:text-sm rounded-md">
                    <option value="0" {{ $teacherApplication->status == 0 ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ $teacherApplication->status == 1 ? 'selected' : '' }}>Approved</option>
                    <option value="2" {{ $teacherApplication->status == 2 ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#3dab8c] hover:bg-[#0d3a37] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3dab8c]">
                    Update Status
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
