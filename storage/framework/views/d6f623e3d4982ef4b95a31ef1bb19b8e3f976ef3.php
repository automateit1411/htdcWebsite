<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Hazera-Taju Degree College</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center font-sans"
    style="background: radial-gradient(#ffffff, #8aff9e66);">
    <div class="w-full max-w-md p-1">
        <div class="glass-panel rounded-2xl shadow-2xl overflow-hidden border border-green-100">
            <!-- Header section with Logo -->
            <div class="bg-gradient-to-r from-[#0d3a37] to-[#124b47] p-2 text-center relative overflow-hidden">
                <!-- Abstract BG Elements -->
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-10"></div>
                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-green-400 opacity-10"></div>

                <div class="relative z-10 flex flex-col items-center">
                    <div class="bg-white p-3 rounded-full shadow-lg mb-4">
                        <img src="<?php echo e(asset('images/logo.svg')); ?>" alt="Hazera-Taju Degree College Logo"
                            class="h-16 w-16">
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-wide">Administrator Area</h2>
                    <p class="text-green-100 text-sm mt-1 opacity-80">Sign in to manage the college portal</p>
                </div>
            </div>

            <div class="p-2">
                <?php if($errors->any()): ?>
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <ul class="text-sm text-red-700 list-disc list-inside">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('admin.authenticate')); ?>" class="space-y-6">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" name="email" id="email"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition bg-gray-50 focus:bg-white"
                                placeholder="admin@htdc.edu.bd" required autofocus value="<?php echo e(old('email')); ?>">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                            <a href="#"
                                class="text-xs font-medium text-[#0d3a37] hover:text-[#3dab8c] transition">Forgot
                                password?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3dab8c] focus:border-transparent transition bg-gray-50 focus:bg-white"
                                placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-[#3dab8c] focus:ring-[#3dab8c] border-gray-300 rounded cursor-pointer">
                        <label for="remember"
                            class="ml-2 block text-sm text-gray-700 cursor-pointer select-none">Remember me for 30
                            days</label>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-[#0d3a37] hover:bg-[#124b47] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3dab8c] shadow-lg hover:shadow-xl transition-all duration-200">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-green-200 group-hover:text-green-100 transition"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            Authenticate
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center">
                <a href="<?php echo e(url('/')); ?>"
                    class="text-xs font-medium text-gray-500 hover:text-[#0d3a37] transition inline-flex items-center justify-center">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Return to Main Website
                </a>
            </div>
        </div>
    </div>
</body>

</html><?php /**PATH D:\Project Conver\laravelPr\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>