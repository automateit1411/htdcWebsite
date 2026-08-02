

<?php $__env->startSection('content'); ?>
<div class="space-y-6" x-data="{ search: '' }">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-800">teacher-vacant-posts</h1>
        
        <!-- Search Field -->
        <div class="relative flex-1 max-w-sm w-full">
            <input type="text" x-model="search" placeholder="Search teacher-vacant-posts by title..." class="w-full pl-10 pr-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-[#3dab8c] focus:ring focus:ring-[#3dab8c] focus:ring-opacity-50 text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <a href="<?php echo e(route('admin.teacher-vacant-posts.create')); ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#3dab8c] hover:bg-[#0d3a37] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3dab8c] whitespace-nowrap">
            Create teacherVacantPost
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="h-[calc(100vh-250px)] overflow-y-auto pr-1 overflow-x-auto relative custom-scrollbar">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0 z-10 shadow-sm">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Active</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacherVacantPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50 transition-colors" x-show="search === '' || '<?php echo e(strtolower(str_replace(["'", "\\"], ["\'", "\\\\"], $teacherVacantPost->title))); ?>'.includes(search.toLowerCase())">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($teacherVacantPost->title); ?></div>
                            <div class="text-sm text-gray-500"><?php echo e(Str::limit(strip_tags($teacherVacantPost->content), 50)); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($teacherVacantPost->is_active): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-green-100 text-green-800">Yes</span>
                            <?php else: ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-red-100 text-red-800">No</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($teacherVacantPost->isNew()): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-blue-100 text-blue-800">New</span>
                            <?php else: ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-gray-100 text-gray-800">Old</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php if($teacherVacantPost->file_path): ?>
                                <?php
                                    $extension = pathinfo($teacherVacantPost->file_path, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                                ?>
                                <a href="<?php echo e(asset('storage/' . $teacherVacantPost->file_path)); ?>" target="_blank" class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                                    <?php if($isImage): ?>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Image
                                    <?php else: ?>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        PDF
                                    <?php endif; ?>
                                </a>
                            <?php else: ?>
                                <span class="text-gray-400">No File</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($teacherVacantPost->created_at->format('M d, Y')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="<?php echo e(route('admin.teacher-vacant-posts.edit', $teacherVacantPost->id)); ?>" class="text-[#3dab8c] hover:text-[#0d3a37] mr-3 font-semibold">Edit</a>
                            <form action="<?php echo e(route('admin.teacher-vacant-posts.destroy', $teacherVacantPost->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($posts->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project Conver\laravelPr\resources\views/admin/teacher_vacant_posts/index.blade.php ENDPATH**/ ?>