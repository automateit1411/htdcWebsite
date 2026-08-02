@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-2xl mx-auto">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700">Back back</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#3dab8c] focus:ring-[#3dab8c] sm:text-sm" value="{{ old('name', $user->name) }}" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#3dab8c] focus:ring-[#3dab8c] sm:text-sm" value="{{ old('email', $user->email) }}" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Mobile Number</label>
                    <input type="text" name="mobile" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#3dab8c] focus:ring-[#3dab8c] sm:text-sm" value="{{ old('mobile', $user->mobile) }}" required>
                    @error('mobile') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#3dab8c] focus:ring-[#3dab8c] sm:text-sm" required>
                        <option value="3" {{ old('role', $user->role) == 3 ? 'selected' : '' }}>Viewer (Read-only)</option>
                        <option value="2" {{ old('role', $user->role) == 2 ? 'selected' : '' }}>Editor (Add/Edit data)</option>
                        <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>Administrator (Full control)</option>
                    </select>
                    @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                @if(Auth::user()->isAdmin())
                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs text-info mb-2">Leave blank to keep the current password.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#3dab8c] focus:ring-[#3dab8c] sm:text-sm">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#3dab8c] focus:ring-[#3dab8c] sm:text-sm">
                        </div>
                    </div>
                </div>
                @endif

                <div class="pt-4">
                    <button type="submit" class="w-full bg-[#3dab8c] text-white px-4 py-2 rounded-md shadow hover:bg-[#349479] font-bold transition-colors">
                        Update System User
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
