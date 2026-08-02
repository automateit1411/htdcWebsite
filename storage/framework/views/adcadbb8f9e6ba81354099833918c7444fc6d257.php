

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Slider Management</h1>
            <p class="text-gray-600 mt-1">Manage homepage slider images and settings</p>
        </div>
        <a href="<?php echo e(route('admin.sliders.create')); ?>" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] text-white font-medium rounded-lg hover:from-green-600 hover:to-green-800 transition-all shadow-md">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Slider
        </a>
    </div>

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="text-green-700"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Sliders Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Order</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Image</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">#<?php echo e($slider->order); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="<?php echo e(asset('storage/' . $slider->image->image)); ?>" 
                                     alt="Slider Image" 
                                     class="w-24 h-16 object-cover rounded-lg border-2 border-gray-200">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($slider->is_active): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="<?php echo e(route('admin.sliders.edit', $slider)); ?>" 
                                       class="text-blue-600 hover:text-blue-900 transition-colors">
                                        Edit
                                    </a>
                                    <form action="<?php echo e(route('admin.sliders.toggle-status', $slider)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="text-orange-600 hover:text-orange-900 transition-colors">
                                            <?php echo e($slider->is_active ? 'Deactivate' : 'Activate'); ?>

                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('admin.sliders.destroy', $slider)); ?>" method="POST" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this slider?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="mt-2">No sliders found. Create your first slider!</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project Conver\laravelPr\resources\views/admin/sliders/index.blade.php ENDPATH**/ ?>