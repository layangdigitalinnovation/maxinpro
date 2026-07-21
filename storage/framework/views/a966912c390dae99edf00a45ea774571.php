<?php $__env->startSection('title', 'Kelola Listing — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    
    <h1 class="text-brand-navy text-[22px] font-black">Kelola Listing</h1>
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <form method="GET" class="relative w-full sm:w-64">
            <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari..." class="h-11 pl-10 pr-4 rounded-lg border border-brand-line focus:ring-brand-blue focus:border-brand-blue text-sm w-full">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
        <div class="flex gap-3 w-full sm:w-auto">
            
        <a href="<?php echo e(route('admin.listings.trashed')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
            Sampah
        </a>
        <a href="<?php echo e(route('admin.listings.create')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            + Tambah Listing
        </a>
    
        </div>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 font-bold">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="bg-white border border-brand-line rounded-2xl overflow-hidden">
    <div class="overflow-x-auto"><table class="w-full min-w-[800px] text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-brand-line">
                <th class="p-4 font-bold text-sm text-brand-navy">Listing</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Tipe & Area</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Harga</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Status</th>
                <th class="p-4 font-bold text-sm text-brand-navy w-32">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-line">
            <?php $__empty_1 = true; $__currentLoopData = $listings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="p-4">
                        <div class="font-bold text-sm text-brand-navy"><?php echo e($listing->title); ?></div>
                        <div class="text-xs text-gray-500 mt-1">Oleh: <?php echo e($listing->agent->name ?? 'Admin'); ?></div>
                    </td>
                    <td class="p-4 text-sm text-brand-navy">
                        <?php echo e($listing->propertyType->name ?? '-'); ?><br>
                        <span class="text-xs text-gray-500"><?php echo e($listing->area->name ?? '-'); ?></span>
                    </td>
                    <td class="p-4 font-bold text-sm text-brand-navy">
                        Rp <?php echo e(number_format($listing->price, 0, ',', '.')); ?>

                    </td>
                    <td class="p-4 text-sm">
                        <span class="px-2 py-1 rounded text-xs font-bold 
                            <?php echo e($listing->status === 'active' ? 'bg-green-100 text-green-700' : 
                               ($listing->status === 'sold' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')); ?>">
                            <?php echo e(ucfirst($listing->status)); ?>

                        </span>
                    </td>
                    <td class="p-4 text-sm flex gap-3">
                        <a href="<?php echo e(route('admin.listings.edit', $listing)); ?>" class="text-blue-600 hover:underline font-bold">Edit</a>
                        <form action="<?php echo e(route('admin.listings.destroy', $listing)); ?>" method="POST" onsubmit="return confirm('Pindahkan listing ini ke sampah?');">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500 text-sm">Belum ada listing yang ditambahkan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table></div>
</div>

<div class="mt-6">
    <?php echo e($listings->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/admin/listings/index.blade.php ENDPATH**/ ?>