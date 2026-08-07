@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-[calc(100vh-250px)] p-1">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#0d3a37] to-[#124b47] p-1 text-center text-white relative">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg class="h-20 w-20" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                </div>

                <svg class="mx-auto h-12 w-12 mb-3 text-green-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                </svg>
                <h2 class="text-3xl font-extrabold tracking-tight relative z-10">{{ __('website.teachers_panel') }}</h2>
                <p class="text-sm mt-2 text-green-100 font-medium relative z-10">{{ __('website.sign_in_manage') }}</p>
            </div>

            <div class="p-2">
                <form action="#" method="POST" class="space-y-3">
                    <!-- CSRF Token Placeholder -->
                    @csrf

                    <!-- Teacher Code -->
                    <div>
                        <label for="teacher_code" class="block text-sm font-semibold text-gray-700 mb-1">{{ __('website.teacher_code') }}</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            <input type="text" name="teacher_code" id="teacher_code"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition"
                                placeholder="{{ __('website.enter_5_digit_code') }}" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">{{ __('website.password') }}</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition"
                                placeholder="{{ __('website.enter_password') }}" required>
                        </div>
                    </div>

                    <!-- Keep me logged in & Forgot password -->
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox"
                                class="h-4 w-4 text-[#3dab8c] focus:ring-[#3dab8c] border-gray-300 rounded cursor-pointer">
                            <label for="remember_me"
                                class="ml-2 block text-sm text-gray-700 cursor-pointer select-none">{{ __('website.remember_me') }}</label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-semibold text-[#0d3a37] hover:text-[#3dab8c] transition">{{ __('website.forgot_password') }}</a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-[#0d3a37] hover:bg-[#124b47] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3dab8c] box-shadow-xl transition-all duration-200">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-green-100 group-hover:text-green-300 transition"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            {{ __('website.secure_login') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="px-8 py-2 bg-gray-50 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-500 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('website.technical_support') }}
                </p>
            </div>
        </div>
    </div>
@endsection