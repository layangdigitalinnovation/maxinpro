<?php $__env->startSection('title', 'Testimoni — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Testimoni</h1>
    <a href="<?php echo e(route('admin.testimonials.create')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
        + Tambah Testimoni
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
                <th class="p-4 font-bold text-sm text-brand-navy">Nama & Kota</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Rating</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Kutipan</th>
                <th class="p-4 font-bold text-sm text-brand-navy text-center">Status</th>
                <th class="p-4 font-bold text-sm text-brand-navy w-32">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-line">
            <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="p-4">
                        <div class="font-bold text-sm text-brand-navy"><?php echo e($testi->name); ?></div>
                        <div class="text-xs text-gray-500 mt-1"><?php echo e($testi->city ?? '-'); ?></div>
                    </td>
                    <td class="p-4 text-sm font-bold text-yellow-500">
                        <?php echo e(str_repeat('⭐', $testi->rating)); ?>

                    </td>
                    <td class="p-4 text-sm text-gray-500 line-clamp-2">"<?php echo e($testi->quote); ?>"</td>
                    <td class="p-4 text-center text-sm">
                        <span class="px-2 py-1 rounded text-xs font-bold <?php echo e($testi->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                            <?php echo e($testi->is_active ? 'Tampil' : 'Disembunyikan'); ?>

                        </span>
                    </td>
                    <td class="p-4 text-sm flex gap-3">
                        <a href="<?php echo e(route('admin.testimonials.edit', $testi)); ?>" class="text-blue-600 hover:underline font-bold">Edit</a>
                        <form action="<?php echo e(route('admin.testimonials.destroy', $testi)); ?>" method="POST" onsubmit="return confirm('Hapus testimoni ini?');">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500 text-sm">Belum ada testimoni.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php if(method_exists($testimonials, 'links')): ?>
<div class="mt-6"><?php echo e($testimonials->links()); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/admin/testimonials/index.blade.php ENDPATH**/ ?>