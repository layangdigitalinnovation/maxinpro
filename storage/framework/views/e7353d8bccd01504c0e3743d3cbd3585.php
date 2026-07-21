<?php $__env->startSection('title', 'Audit Logs — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Audit Logs</h1>
</div>

<div class="bg-white border border-brand-line rounded-2xl overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-brand-line">
                <th class="p-4 font-bold text-sm text-brand-navy">Waktu</th>
                <th class="p-4 font-bold text-sm text-brand-navy">User</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Aksi</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Modul/Data</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Detail</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-line">
            <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="p-4 text-xs text-gray-500"><?php echo e($log->created_at->format('d/m/Y H:i:s')); ?></td>
                    <td class="p-4 text-sm font-bold text-brand-navy"><?php echo e($log->user->name ?? 'System'); ?></td>
                    <td class="p-4 text-sm">
                        <span class="px-2 py-1 rounded text-xs font-bold bg-gray-100 text-gray-700">
                            <?php echo e(strtoupper($log->action)); ?>

                        </span>
                    </td>
                    <td class="p-4 text-sm"><?php echo e(class_basename($log->auditable_type)); ?> #<?php echo e($log->auditable_id); ?></td>
                    <td class="p-4 text-xs text-gray-500 max-w-xs truncate" title="<?php echo e(json_encode($log->payload)); ?>">
                        <?php echo e(json_encode($log->payload)); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500 text-sm">Belum ada log aktivitas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php if(method_exists($logs, 'links')): ?>
<div class="mt-6"><?php echo e($logs->links()); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/admin/audit-logs/index.blade.php ENDPATH**/ ?>