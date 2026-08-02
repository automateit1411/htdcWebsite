@extends('layouts.app')

@section('content')
    <div class="p-4 max-w-5xl mx-auto">
        <a href="{{ url('/staff-information') }}"
            class="inline-flex items-center gap-1 text-sm text-[#0d3a37] hover:text-green-700 mb-4 font-medium">&larr; Back to Staff
            List</a>

        <div x-data="{
                employeeCode: '{{ $employeeCode }}',
                staff: null,
                loading: true,
                error: null,
                init() {
                    fetch('/proxy/employees/staff')
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to fetch staff data');
                            return response.json();
                        })
                        .then(data => {
                            let found = data.find(item => item.employeeCode === this.employeeCode);
                            if (!found && !isNaN(this.employeeCode)) {
                                found = data[parseInt(this.employeeCode)];
                            }
                            if (!found) {
                                this.error = 'Staff not found.';
                            } else {
                                this.staff = found;
                            }
                        })
                        .catch(err => this.error = err.message || 'Unable to load staff details')
                        .finally(() => this.loading = false);
                }
            }" x-init="init()">

            <template x-if="loading">
                <div class="flex items-center justify-center py-20">
                    <div class="text-gray-500 text-sm">Loading staff details...</div>
                </div>
            </template>

            <template x-if="error">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-red-600 font-medium" x-text="error"></div>
            </template>

            <template x-if="staff">
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-[#0d3a37] to-[#1a6b5a] p-6">
                        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
                            <img :src="staff.profileScan || 'https://via.placeholder.com/180'" alt="Profile"
                                class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg flex-shrink-0" />
                            <div class="text-center sm:text-left text-white">
                                <h1 class="text-2xl font-bold" x-text="staff.name || 'No name'"></h1>
                                <p class="text-sm text-green-200 mt-0.5" x-text="staff.banglaName || ''"></p>
                                <div class="flex flex-wrap justify-center sm:justify-start gap-2 mt-3">
                                    <span x-show="staff.designation_name"
                                        class="inline-block bg-white/20 text-white text-xs font-medium px-3 py-1 rounded-full"
                                        x-text="staff.designation_name"></span>
                                    <span x-show="staff.department_name"
                                        class="inline-block bg-white/20 text-white text-xs font-medium px-3 py-1 rounded-full"
                                        x-text="staff.department_name"></span>
                                </div>
                                <div class="flex flex-wrap justify-center sm:justify-start gap-4 mt-3 text-sm text-green-100">
                                    <span x-show="staff.mobile" class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        <span x-text="staff.mobile"></span>
                                    </span>
                                    <span x-show="staff.email" class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        <span x-text="staff.email"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Message --}}
                    <div class="p-6">
                        <template x-if="staff.employeeMessage">
                            <div>
                                <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-xl p-5 relative">
                                    <svg class="absolute top-3 left-3 w-8 h-8 text-gray-200" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                    </svg>
                                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line pl-6 italic text-justify" x-text="staff.employeeMessage"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

        </div>
    </div>
@endsection