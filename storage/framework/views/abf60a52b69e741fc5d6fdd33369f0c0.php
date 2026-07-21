<?php $__env->startSection('title', 'Bank Rekanan (KPR) — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Bank Rekanan KPR</h1>
    <a href="<?php echo e(route('admin.partner-banks.create')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
        + Tambah Bank
    </a>
</div>

<?php if(session('success')): ?>
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 font-bold">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="bg-white border border-brand-line rounded-2xl overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-brand-line">
                <th class="p-4 font-bold text-sm text-brand-navy">Urutan</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Nama Bank</th>
                <th class="p-4 font-bold text-sm text-brand-navy w-32">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-line">
            <?php $__empty_1 = true; $__currentLoopData = $partnerBanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="p-4 text-sm font-bold text-brand-navy"><?php echo e($bank->sort_order); ?></td>
                    <td class="p-4 text-sm font-bold text-brand-navy"><?php echo e($bank->name); ?></td>
                    <td class="p-4 text-sm flex gap-3">
                        <a href="<?php echo e(route('admin.partner-banks.edit', $bank)); ?>" class="text-blue-600 hover:underline font-bold">Edit</a>
                        <form action="<?php echo e(route('admin.partner-banks.destroy', $bank)); ?>" method="POST" onsubmit="return confirm('Hapus bank rekanan ini?');">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="3" class="p-6 text-center text-gray-500 text-sm">Belum ada bank rekanan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php if(method_exists($partnerBanks, 'links')): ?>
<div class="mt-6"><?php echo e($partnerBanks->links()); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/admin/partner-banks/index.blade.php ENDPATH**/ ?>