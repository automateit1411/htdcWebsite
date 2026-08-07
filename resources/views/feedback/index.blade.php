@extends('layouts.app')

@section('title', 'Feedback - Hazera-Taju Degree College')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-[#0d3a37] mb-2">{{ __('website.student_feedback') }}</h1>
            <p class="text-gray-600 italic">"{{ __('website.student_feedback_desc') }}"</p>
            <div class="w-20 h-1 bg-green-500 mx-auto mt-4 rounded-full"></div>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            {{ session('error') }}
        </div>
        @endif

        <!-- Feedback Form Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-[#0d3a37] px-8 py-5 flex items-center justify-between">
                <h2 class="text-white font-semibold text-lg uppercase tracking-tight">{{ __('website.feedback_form') }}</h2>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
            </div>

            <form action="{{ route('feedback.send') }}" method="POST" class="p-8 space-y-5">
                @csrf
                
                <!-- Name -->
                <div class="space-y-1">
                    <label for="name" class="text-sm font-bold text-gray-700">{{ __('website.full_name') }}</label>
                    <input type="text" id="name" name="name" required placeholder="John Doe"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 outline-none @error('name') border-red-500 @enderror"
                        value="{{ old('name') }}">
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Mobile -->
                <div class="space-y-1">
                    <label for="mobile" class="text-sm font-bold text-gray-700">{{ __('website.mobile_number') }}</label>
                    <input type="tel" id="mobile" name="mobile" required placeholder="017XXXXXXXX"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 outline-none @error('mobile') border-red-500 @enderror"
                        value="{{ old('mobile') }}">
                    @error('mobile') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Subject -->
                <div class="space-y-1">
                    <label for="subject" class="text-sm font-bold text-gray-700">{{ __('website.subject') }}</label>
                    <input type="text" id="subject" name="subject" required placeholder="Regarding Academic Facilities..."
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 outline-none @error('subject') border-red-500 @enderror"
                        value="{{ old('subject') }}">
                    @error('subject') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Message -->
                <div class="space-y-1">
                    <label for="message" class="text-sm font-bold text-gray-700">{{ __('website.message') }}</label>
                    <textarea id="message" name="message" rows="5" required placeholder="Share your thoughts here..."
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 outline-none resize-none @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                    @error('message') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-[#3dab8c] hover:bg-[#2d8b72] text-white font-bold py-3.5 px-6 rounded-lg transition duration-300 shadow-lg hover:shadow-green-100 flex items-center justify-center group uppercase tracking-widest text-sm">
                        <span>{{ __('website.submit_feedback') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Privacy Note -->
        <p class="mt-6 text-center text-xs text-gray-400">
            {{ __('website.feedback_privacy') }}
        </p>
    </div>
</div>
@endsection
