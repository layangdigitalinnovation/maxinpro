<?php $__env->startSection('title', 'Data Peran (Role) — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Data Peran (Role)</h1>
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <a href="<?php echo e(route('admin.roles.create')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            + Tambah Peran
        </a>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 text-sm font-bold">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 text-sm font-bold">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<div class="bg-white border border-brand-line rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[600px] text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-brand-line">
                    <th class="p-4 font-bold text-sm text-brand-navy w-48">Nama Peran</th>
                    <th class="p-4 font-bold text-sm text-brand-navy">Permissions</th>
                    <th class="p-4 font-bold text-sm text-brand-navy w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-line">
                <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-sm font-bold text-brand-navy"><?php echo e($role->name); ?></td>
                        <td class="p-4 text-sm text-gray-700">
                            <div class="flex flex-wrap gap-1.5">
                                <?php $__empty_2 = true; $__currentLoopData = $role->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                        <?php echo e($permission->name); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <span class="text-gray-400 italic">Belum ada permission</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="p-4 text-sm flex gap-3">
                            <a href="<?php echo e(route('admin.roles.edit', $role)); ?>" class="text-blue-600 hover:underline font-bold">Edit</a>
                            <?php if($role->name !== 'admin'): ?>
                            <form action="<?php echo e(route('admin.roles.destroy', $role)); ?>" method="POST" onsubmit="return confirm('Hapus peran ini?');" class="inline-block">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" class="p-6 text-center text-gray-500 text-sm">Belum ada peran.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php if(method_exists($roles, 'links')): ?>
<div class="mt-6"><?php echo e($roles->links()); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\admin\roles\index.blade.php ENDPATH**/ ?>