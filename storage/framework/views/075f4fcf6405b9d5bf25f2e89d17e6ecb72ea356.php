<?php $__env->startSection('content'); ?>
<div class="min-h-[60vh] flex items-center justify-center py-8 px-4">
    <div class="bg-white rounded-2xl shadow-xl border border-blue-100 max-w-lg w-full p-8 text-center relative overflow-hidden">
        <!-- Accent Top Bar -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-blue-500 to-[#0d3a37]"></div>
        
        <!-- Error Badge -->
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-blue-50 text-blue-600 mb-6 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <div class="text-4xl font-black text-gray-800 mb-1">419</div>
        <h1 class="text-xl font-bold text-gray-800 mb-1">Page Expired</h1>
        <h2 class="text-base font-medium text-blue-600 mb-4 bn-font">সেশনের মেয়াদ শেষ হয়েছে</h2>

        <p class="text-gray-600 text-sm mb-2 leading-relaxed">
            Your session has expired due to inactivity. Please refresh the page and try again.
        </p>
        <p class="text-gray-500 text-xs mb-8 bn-font">
            নিষ্ক্রিয়তার কারণে সেশনের মেয়াদ শেষ হয়ে গেছে। অনুগ্রহ করে পেজটি রিফ্রেশ করে পুনরায় চেষ্টা করুন।
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button onclick="window.location.reload()" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white font-medium px-5 py-2.5 rounded-xl shadow hover:opacity-90 transition-all text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Refresh / রিফ্রেশ করুন
            </button>
            <a href="<?php echo e(url('/')); ?>" class="inline-flex items-center justify-center gap-2 bg-gray-100 text-gray-700 font-medium px-5 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-200 transition-all text-sm">
                Go to Home / মূল পাতা
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project Conver\laravelPr\resources\views/errors/419.blade.php ENDPATH**/ ?>