

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto">
    <!-- Search and Notices List -->
    <div x-data="{ search: '' }">
        <!-- Search Input -->
        <div class="mb-4 flex justify-between items-center bg-white p-3 rounded shadow border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-700 ml-2"><?php echo e(isset($pageTitle) ? $pageTitle : 'All Notices'); ?></h2>
            <div class="relative">
                <input type="text" x-model="search" placeholder="Search <?php echo e(isset($pageTitle) ? strtolower($pageTitle) : 'notices'); ?>..." class="pl-9 pr-4 py-1.5 border border-gray-300 rounded focus:ring-[#3dab8c] focus:border-[#3dab8c] w-64 md:w-80 shadow-sm transition-all text-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Notices List - Table Format -->
        <div class="bg-white rounded shadow text-sm border border-gray-100">
            <div class="h-[calc(100vh-220px)] overflow-y-auto pr-1 overflow-x-auto relative">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-[#3dab8c] to-[#0d3a37] sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Sl. No.</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Publish Date</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $notices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $notice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 transition-colors"
                                x-show="search === '' || '<?php echo e(strtolower(str_replace(["'", "\\"], ["\'", "\\\\"], $notice->title))); ?>'.includes(search.toLowerCase())">
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700"><?php echo e($index + 1); ?></td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium text-gray-900"><?php echo e($notice->title); ?></span>
                                        <?php if($notice->isNew()): ?>
                                            <img src="<?php echo e(asset('images/new.gif')); ?>" alt="New" class="h-4 w-auto">
                                        <?php endif; ?>
                                    </div>
                                </td>
                               
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-600">
                                    <svg class="inline-block w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <?php echo e($notice->created_at->format('M d, Y')); ?>

                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- View Button -->
                                        <button onclick="openModal(<?php echo e($notice->id); ?>)" 
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#3dab8c] text-white rounded hover:bg-green-700 transition text-xs">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </button>
                                        
                                        <!-- Download Button (if file exists) -->
                                        <?php if($notice->file_path): ?>
                                            <a href="<?php echo e(Storage::url($notice->file_path)); ?>" 
                                               target="_blank"
                                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#0d3a37] text-white rounded hover:bg-green-800 transition text-xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                PDF
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Notice Detail Modal (same as before) -->
                            <div id="modal-<?php echo e($notice->id); ?>" 
                                 class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4"
                                 @click="closeModal(<?php echo e($notice->id); ?>)">
                                <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto" @click.stop>
                                    <div class="p-6">
                                        <!-- Modal Header -->
                                        <div class="flex items-start justify-between mb-4 border-b pb-3 border-gray-100">
                                            <h2 class="text-xl font-bold text-gray-900"><?php echo e($notice->title); ?></h2>
                                            <button onclick="closeModal(<?php echo e($notice->id); ?>)" class="text-gray-500 hover:text-gray-700">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <!-- Modal Content -->
                                        <div class="prose max-w-none mb-6">
                                            <div class="text-gray-700">
                                                <?php echo $notice->content; ?>

                                            </div>
                                        </div>
                                        
                                        <!-- Modal Footer -->
                                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                            <p class="text-sm text-gray-500">
                                                Published: <?php echo e($notice->created_at->format('F d, Y')); ?>

                                            </p>
                                            <?php if($notice->file_path): ?>
                                                <a href="<?php echo e(Storage::url($notice->file_path)); ?>" 
                                                   target="_blank"
                                                   class="inline-flex items-center gap-2 px-4 py-2 bg-[#0d3a37] text-white rounded hover:bg-green-800 transition font-medium text-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    Download PDF
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-700 mb-1">No <?php echo e(isset($pageTitle) ? $pageTitle : 'Notices'); ?> Available</h3>
                                    <p class="text-sm text-gray-500">There are currently no items to display.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php if($notices->hasPages()): ?>
        <div class="mt-8">
            <?php echo e($notices->links()); ?>

        </div>
    <?php endif; ?>
</div>

<script>
    function openModal(noticeId) {
        document.getElementById(`modal-${noticeId}`).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeModal(noticeId) {
        document.getElementById(`modal-${noticeId}`).classList.add('hidden');
        document.body.style.overflow = '';
    }
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('[id^="modal-"]');
            modals.forEach(modal => {
                if (!modal.classList.contains('hidden')) {
                    const noticeId = modal.id.replace('modal-', '');
                    closeModal(noticeId);
                }
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project Conver\laravelPr\resources\views/notices.blade.php ENDPATH**/ ?>