<?php $__env->startSection('title', 'Data Permission — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Data Permission</h1>
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <a href="<?php echo e(route('admin.permissions.create')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            + Tambah Permission
        </a>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 text-sm font-bold">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="bg-white border border-brand-line rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[600px] text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-brand-line">
                    <th class="p-4 font-bold text-sm text-brand-navy">Nama Permission</th>
                    <th class="p-4 font-bold text-sm text-brand-navy w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-line">
                <?php $__empty_1 = true; $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-sm font-bold text-gray-700"><?php echo e($permission->name); ?></td>
                        <td class="p-4 text-sm flex gap-3">
                            <a href="<?php echo e(route('admin.permissions.edit', $permission)); ?>" class="text-blue-600 hover:underline font-bold">Edit</a>
                            <form action="<?php echo e(route('admin.permissions.destroy', $permission)); ?>" method="POST" onsubmit="return confirm('Hapus permission ini?');" class="inline-block">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="2" class="p-6 text-center text-gray-500 text-sm">Belum ada permission.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php if(method_exists($permissions, 'links')): ?>
<div class="mt-6"><?php echo e($permissions->links()); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\admin\permissions\index.blade.php ENDPATH**/ ?>