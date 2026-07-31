<?php $__env->startSection('title', 'Sampah Listing — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Sampah Listing</h1>
    <a href="<?php echo e(route('admin.listings.index')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
        Kembali
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
                <th class="p-4 font-bold text-sm text-brand-navy">Listing</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Tipe & Area</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Harga</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Dihapus Pada</th>
                <th class="p-4 font-bold text-sm text-brand-navy w-48">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-line">
            <?php $__empty_1 = true; $__currentLoopData = $listings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 opacity-75">
                    <td class="p-4">
                        <div class="font-bold text-sm text-brand-navy line-through"><?php echo e($listing->title); ?></div>
                    </td>
                    <td class="p-4 text-sm text-brand-navy">
                        <?php echo e($listing->propertyType->name ?? '-'); ?><br>
                        <span class="text-xs text-gray-500"><?php echo e($listing->area->name ?? '-'); ?></span>
                    </td>
                    <td class="p-4 font-bold text-sm text-brand-navy">
                        Rp <?php echo e(number_format($listing->price, 0, ',', '.')); ?>

                    </td>
                    <td class="p-4 text-sm text-gray-500">
                        <?php echo e($listing->deleted_at->format('d M Y')); ?>

                    </td>
                    <td class="p-4 text-sm flex gap-3">
                        <form action="<?php echo e(route('admin.listings.restore', $listing->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="text-green-600 hover:underline font-bold">Pulihkan</button>
                        </form>
                        <form action="<?php echo e(route('admin.listings.force-delete', $listing->id)); ?>" method="POST" onsubmit="return confirm('Hapus PERMANEN listing ini? Data tidak bisa dikembalikan!');">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:underline font-bold">Hapus Permanen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500 text-sm">Tidak ada listing di tempat sampah.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php if(method_exists($listings, 'links')): ?>
<div class="mt-6"><?php echo e($listings->links()); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\admin\listings\trashed.blade.php ENDPATH**/ ?>