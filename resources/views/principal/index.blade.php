@extends('layouts.app')

@section('content')
    <div class="p-4">
        <div x-data="{
                principals: [],
                loading: true,
                error: null,
                init() {
                    fetch('/proxy/employees/principal')
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to fetch principal data');
                            return response.json();
                        })
                        .then(data => this.principals = data)
                        .catch(err => this.error = err.message || 'Unable to load principals')
                        .finally(() => this.loading = false);
                }
            }" x-init="init()">

            {{-- Header --}}
            <div class="flex items-center gap-3 mb-4">
                <h1 class="text-xl font-bold text-gray-800">Principal Information</h1>
                <template x-if="!loading && principals.length > 0">
                    <span class="bg-[#0d3a37] text-white text-xs font-medium px-2.5 py-0.5 rounded-full"
                        x-text="'(' + principals.length + ')'"></span>
                </template>
            </div>

            <template x-if="loading">
                <div class="flex items-center justify-center py-20">
                    <div class="text-gray-500 text-sm">Loading principals...</div>
                </div>
            </template>

            <template x-if="error">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-red-600 font-medium" x-text="error"></div>
            </template>

            <template x-if="!loading && !error">
                <div>
                    <template x-if="principals.length > 0">
                        <div class="h-[calc(100vh-160px)] overflow-y-auto pr-1 scrollbar-thin">
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 pb-4">
                                <template x-for="(principal, index) in principals" :key="index">
                                    <a :href="`/principle-list/${principal.employeeCode || index}`"
                                        class="block bg-white rounded-xl border border-gray-100 p-4 transition hover:shadow-lg hover:border-[#3dab8c] group">
                                        <div class="flex justify-center mb-3">
                                            <img :src="principal.profileScan || 'https://via.placeholder.com/150'"
                                                alt="Principal Photo"
                                                class="h-20 w-20 rounded-full object-cover border-2 border-gray-100 group-hover:border-[#3dab8c] transition" />
                                        </div>
                                        <h2 class="text-sm font-bold text-gray-800 text-center leading-tight"
                                            x-text="principal.name || 'No name'"></h2>
                                        <p class="text-xs text-gray-400 text-center mt-0.5" x-text="principal.banglaName || ''"></p>
                                        <p class="text-xs text-[#3dab8c] text-center font-medium mt-1.5" x-text="principal.designation_name || 'N/A'"></p>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </template>

                    <template x-if="principals.length === 0">
                        <div class="text-center py-20">
                            <p class="text-gray-400 text-sm">No principals found.</p>
                        </div>
                    </template>
                </div>
            </template>

        </div>
    </div>
@endsection
