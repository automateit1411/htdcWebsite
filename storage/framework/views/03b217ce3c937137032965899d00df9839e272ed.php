<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
        <!-- Header -->
        <div class="bg-[#0d3a37] p-6 text-center">
            <h1 class="text-2xl md:text-3xl font-bold text-white uppercase tracking-wider">Daily Attendance Report</h1>
            <p class="text-green-200 mt-2">Academic Session: <?php echo e(date('Y')); ?>-<?php echo e(date('Y')+1); ?></p>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <?php if($attendances->count() > 0): ?>
            <table class="w-full border-collapse text-sm">
                <thead>
                    <!-- First Header Row -->
                    <tr class="bg-gray-100 text-[#0d3a37] uppercase">
                        <th rowspan="2" class="border border-gray-300 px-4 py-3 min-w-[120px]">Date</th>
                        <th colspan="3" class="border border-gray-300 px-4 py-3 bg-blue-50">HSC</th>
                        <th colspan="3" class="border border-gray-300 px-4 py-3 bg-purple-50">Honours</th>
                        <th colspan="3" class="border border-gray-300 px-4 py-3 bg-amber-50">Degree</th>
                    </tr>
                    <!-- Second Header Row -->
                    <tr class="bg-gray-50 text-gray-700 font-semibold">
                        <!-- HSC -->
                        <th class="border border-gray-300 px-2 py-2 bg-blue-50/50">Science</th>
                        <th class="border border-gray-300 px-2 py-2 bg-blue-50/50">Business</th>
                        <th class="border border-gray-300 px-2 py-2 bg-blue-50/50">Humanities</th>
                        <!-- Honours -->
                        <th class="border border-gray-300 px-2 py-2 bg-purple-50/50">BBA</th>
                        <th class="border border-gray-300 px-2 py-2 bg-purple-50/50">BSA</th>
                        <th class="border border-gray-300 px-2 py-2 bg-purple-50/50">BSS</th>
                        <!-- Degree -->
                        <th class="border border-gray-300 px-2 py-2 bg-amber-50/50">Accounting</th>
                        <th class="border border-gray-300 px-2 py-2 bg-amber-50/50">Management</th>
                        <th class="border border-gray-300 px-2 py-2 bg-amber-50/50">Economics</th>
                    </tr>
                </thead>
                <tbody class="text-center divide-y divide-gray-200">
                    <?php
                        $groupOrder = [
                            'HSC' => ['Science', 'Business', 'Humanities'],
                            'Honours' => ['BBA', 'BSA', 'BSS'],
                            'Degree' => ['Accounting', 'Management', 'Economics'],
                        ];
                    ?>
                    <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $records): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50 transition-colors <?php echo e($loop->iteration % 2 == 0 ? 'bg-gray-50/30' : ''); ?>">
                        <td class="border border-gray-300 px-4 py-3 font-medium text-gray-900"><?php echo e($date); ?></td>
                        <?php $__currentLoopData = $groupOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program => $groups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $record = $records->first(function ($r) use ($program, $groupName) {
                                        return $r->programGroup->program === $program && $r->programGroup->group_name === $groupName;
                                    });
                                ?>
                                <td class="border border-gray-300 px-2 py-3 font-bold <?php echo e($record && $record->percentage >= 80 ? 'text-green-600' : 'text-red-600'); ?>">
                                    <?php if($record): ?>
                                        <?php echo e(number_format($record->percentage, 0)); ?>%
                                    <?php else: ?>
                                        <span class="text-gray-400">-</span>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No attendance data</h3>
                <p class="mt-1 text-sm text-gray-500">No attendance records have been added yet.</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Footer Info -->
        <div class="p-6 bg-gray-50 border-t border-gray-200">
            <div class="flex flex-wrap gap-4 text-xs font-semibold uppercase tracking-wider">
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-green-600 rounded-full mr-2"></span>
                    <span>High ( >= 80%)</span>
                </div>
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-red-600 rounded-full mr-2"></span>
                    <span>Low ( < 80%)</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Project Conver\laravelPr\resources\views/attendance/index.blade.php ENDPATH**/ ?>