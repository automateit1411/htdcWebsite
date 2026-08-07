@extends('layouts.app')

@section('title', 'Results - Hazera-Taju Degree College')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-2xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-[#0d3a37] mb-2">{{ __('website.student_result_search') }}</h1>
            <p class="text-gray-600">{{ __('website.result_search_desc') }}</p>
            <div class="w-24 h-1 bg-green-500 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Result Search Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden" x-data="resultSearch()">
            <div class="bg-[#0d3a37] px-8 py-4">
                <h2 class="text-white font-semibold text-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    {{ __('website.search_criteria') }}
                </h2>
            </div>

            <form action="#" method="GET" class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Session -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 flex items-center">
                            {{ __('website.session') }} <span class="text-red-500 ml-1">*</span>
                        </label>
                        <select name="session" x-model="formData.session" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 outline-none">
                            <option value="">{{ __('website.select_session') }}</option>
                            @foreach($options['admissionSessions'] as $session)
                                <option value="{{ data_get($session, 'id') }}">{{ data_get($session, 'session') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Program -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 flex items-center">
                            {{ __('website.program') }} <span class="text-red-500 ml-1">*</span>
                        </label>
                        <select name="program" x-model="formData.program" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 outline-none">
                            <option value="">{{ __('website.select_program') }}</option>
                            @foreach($options['programs'] as $program)
                                <option value="{{ data_get($program, 'id') }}">{{ data_get($program, 'name') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Group -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 flex items-center">
                            {{ __('website.group') }} <span class="text-red-500 ml-1">*</span>
                        </label>
                        <select name="group" x-model="formData.group" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 outline-none">
                            <option value="">{{ __('website.select_group') }}</option>
                            @foreach($options['groups'] as $group)
                                <option value="{{ data_get($group, 'id') }}">{{ data_get($group, 'group') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Exam Name -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 flex items-center">
                            {{ __('website.exam_name') }} <span class="text-red-500 ml-1">*</span>
                        </label>
                        <select name="exam_name" x-model="formData.exam_name" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 outline-none">
                            <option value="">{{ __('website.select_exam') }}</option>
                            <option value="Half Yearly">{{ __('website.half_yearly') }}</option>
                            <option value="Annual">{{ __('website.annual') }}</option>
                            <option value="Pre-Test">{{ __('website.pre_test') }}</option>
                            <option value="Test">{{ __('website.test') }}</option>
                        </select>
                    </div>

                    <!-- Roll No -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 flex items-center">
                            {{ __('website.roll_number') }} <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" name="roll" x-model="formData.roll" required placeholder="{{ __('website.enter_roll_number') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 outline-none">
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 flex items-center">
                            {{ __('website.password') }} <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="password" name="password" x-model="formData.password" required placeholder="{{ __('website.enter_password_placeholder') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 outline-none">
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit" 
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-lg hover:shadow-green-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('website.get_result') }}
                    </button>
                    <button type="button" @click="resetForm()"
                        class="sm:w-32 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        {{ __('website.reset') }}
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Helpful Information -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-blue-50 p-4 rounded-xl flex items-start">
                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-blue-800">{{ __('website.result_forgot_password') }}</h4>
                    <p class="text-xs text-blue-600 mt-1">{{ __('website.result_forgot_password_desc') }}</p>
                </div>
            </div>
            <div class="bg-amber-50 p-4 rounded-xl flex items-start">
                <div class="bg-amber-100 p-2 rounded-lg mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-amber-800">{{ __('website.official_results') }}</h4>
                    <p class="text-xs text-amber-600 mt-1">{{ __('website.official_results_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function resultSearch() {
        return {
            formData: {
                session: '',
                program: '',
                group: '',
                exam_name: '',
                roll: '',
                password: ''
            },
            resetForm() {
                this.formData = {
                    session: '',
                    program: '',
                    group: '',
                    exam_name: '',
                    roll: '',
                    password: ''
                };
            }
        }
    }
</script>
@endsection
