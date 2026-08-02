<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-center min-h-[calc(100vh-250px)] p-4">
    <div class="w-full max-w-2xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-[#0d3a37]">Employee Login</h1>
            <p class="text-gray-600 mt-2">Select your account type to login</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Teacher Login Card -->
            <a href="<?php echo e(route('teacher.panel')); ?>" class="group">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="bg-gradient-to-r from-[#0d3a37] to-[#124b47] p-6 text-center text-white">
                        <svg class="mx-auto h-16 w-16 mb-4 text-green-200 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                        </svg>
                        <h2 class="text-2xl font-bold">Teacher's Panel</h2>
                        <p class="text-sm mt-2 text-green-100">Login with teacher credentials</p>
                    </div>
                    <div class="p-6 text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 text-[#3dab8c] mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <p class="text-gray-600 text-sm">Access teacher dashboard, attendance, and more</p>
                    </div>
                </div>
            </a>

            <!-- Staff Login Card -->
            <a href="<?php echo e(route('staff.panel')); ?>" class="group">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="bg-gradient-to-r from-[#0d3a37] to-[#124b47] p-6 text-center text-white">
                        <svg class="mx-auto h-16 w-16 mb-4 text-green-200 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h2 class="text-2xl font-bold">Staff's Panel</h2>
                        <p class="text-sm mt-2 text-green-100">Login with staff credentials</p>
                    </div>
                    <div class="p-6 text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 text-[#3dab8c] mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <p class="text-gray-600 text-sm">Access staff dashboard, tasks, and more</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="mt-8 text-center">
            <a href="/" class="text-[#3dab8c] hover:text-[#0d3a37] font-medium text-sm">
                ← Back to Home
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project Conver\laravelPr\resources\views/employee/login.blade.php ENDPATH**/ ?>