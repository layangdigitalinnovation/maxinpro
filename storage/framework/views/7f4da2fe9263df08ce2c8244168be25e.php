<?php $__env->startSection('title', 'Data Leads (Titip Properti) — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Data Leads</h1>
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <form method="GET" class="relative w-full sm:w-64">
            <!-- Preserve existing filters -->
            <?php $__currentLoopData = request()->except(['q', 'page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari..." class="h-11 pl-10 pr-4 rounded-lg border border-brand-line focus:ring-brand-blue focus:border-brand-blue text-sm w-full">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
        <div class="flex gap-3 w-full sm:w-auto"><a href="<?php echo e(route('admin.leads.export', request()->query())); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-green-600 text-white text-[13px] font-extrabold hover:bg-green-700">
        ↓ Export CSV
    </a></div>
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
                <th class="p-4 font-bold text-sm text-brand-navy">Nama & Kontak</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Detail Properti</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Harga Diharapkan</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Status</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Tanggal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-line">
            <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="p-4">
                        <div class="font-bold text-sm text-brand-navy"><?php echo e($lead->name); ?></div>
                        <div class="text-xs text-gray-500 mt-1">WA: <?php echo e($lead->phone); ?></div>
                        <div class="text-xs text-gray-500"><?php echo e($lead->city); ?></div>
                    </td>
                    <td class="p-4 text-sm text-brand-navy max-w-xs">
                        <span class="font-bold"><?php echo e($lead->propertyType->name ?? 'Properti'); ?></span><br>
                        <span class="text-xs text-gray-500 line-clamp-2" title="<?php echo e($lead->address); ?>"><?php echo e($lead->address); ?></span>
                        <?php if($lead->specification): ?>
                            <div class="text-xs text-gray-400 mt-1 line-clamp-1" title="<?php echo e($lead->specification); ?>"><?php echo e(Str::limit($lead->specification, 50)); ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 font-bold text-sm text-brand-navy">
                        <?php echo e($lead->expected_price ? 'Rp ' . number_format($lead->expected_price, 0, ',', '.') : '-'); ?>

                    </td>
                    <td class="p-4 text-sm">
                        <form action="<?php echo e(route('admin.leads.update', $lead)); ?>" method="POST" class="flex items-center gap-2">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <select name="status" class="border border-gray-300 rounded text-sm bg-gray-50 py-1.5 px-2 focus:ring-brand-blue" onchange="this.form.submit()">
                                <option value="new" <?php echo e($lead->status === 'new' ? 'selected' : ''); ?>>Baru</option>
                                <option value="contacted" <?php echo e($lead->status === 'contacted' ? 'selected' : ''); ?>>Dihubungi</option>
                                <option value="closed" <?php echo e($lead->status === 'closed' ? 'selected' : ''); ?>>Selesai</option>
                            </select>
                        </form>
                    </td>
                    <td class="p-4 text-sm text-gray-500">
                        <?php echo e($lead->created_at->format('d M Y, H:i')); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500 text-sm">Belum ada data leads.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table></div>
</div>

<div class="mt-6">
    <?php echo e($leads->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\admin\leads\index.blade.php ENDPATH**/ ?>