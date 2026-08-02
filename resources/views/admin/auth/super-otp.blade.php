<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification - HTDC</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .otp-input {
            width: 50px;
            height: 55px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            border: 2px solid #d1d5db;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }
        .otp-input:focus {
            border-color: #3dab8c;
            outline: none;
            box-shadow: 0 0 0 3px rgba(61, 171, 140, 0.2);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center font-sans" style="background: radial-gradient(#ffffff, #8aff9e66);">
    <div class="w-full max-w-md p-1">
        <div class="glass-panel rounded-2xl shadow-2xl overflow-hidden border border-green-100">
            <div class="bg-gradient-to-r from-[#0d3a37] to-[#124b47] p-6 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-10"></div>
                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-green-400 opacity-10"></div>
                <div class="relative z-10 flex flex-col items-center">
                    <div class="bg-white p-3 rounded-full shadow-lg mb-4">
                        <img src="{{ asset('images/logo.svg') }}" alt="HTDC Logo" class="h-16 w-16">
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-wide">OTP Verification</h2>
                    <p class="text-green-100 text-sm mt-1 opacity-80">Enter the 6-digit code sent to your email</p>
                </div>
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <ul class="text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                        <svg class="w-8 h-8 text-[#3dab8c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-gray-600 text-sm">OTP sent to <strong>info@htdc.edu.bd</strong></p>
                </div>

                <form method="POST" action="{{ route('super-admin.otp.verify') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="otp" class="block text-sm font-semibold text-gray-700 mb-3 text-center">Enter 6-Digit OTP</label>
                        <div class="flex justify-center gap-2">
                            <input type="text" name="otp" id="otp" maxlength="6" pattern="[0-9]*" inputmode="numeric" autocomplete="one-time-code"
                                class="block w-full text-center text-2xl font-bold tracking-[0.5em] border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition bg-gray-50 focus:bg-white py-4"
                                placeholder="000000" required autofocus>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-[#0d3a37] hover:bg-[#124b47] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3dab8c] shadow-lg hover:shadow-xl transition-all duration-200">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-green-200 group-hover:text-green-100 transition" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Verify & Login
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('super-admin.login') }}" class="text-sm text-[#3dab8c] hover:text-[#0d3a37] font-medium">
                        ← Back to Login
                    </a>
                </div>
            </div>

            <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center">
                <a href="{{ url('/') }}" class="text-xs font-medium text-gray-500 hover:text-[#0d3a37] transition inline-flex items-center justify-center">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Return to Main Website
                </a>
            </div>
        </div>
    </div>
</body>
</html>
