<?php $__env->startSection('title', 'Dashboard Agen — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<h1 class="text-brand-navy text-[22px] font-black mb-6">Halo, <?php echo e($agent->name); ?> 👋</h1>

<div class="grid grid-cols-3 gap-4 mb-8">
    <?php $__currentLoopData = [
        ['label' => 'Listing Aktif', 'value' => $stats['listings_active']],
        ['label' => 'Total Listing', 'value' => $stats['listings_total']],
        ['label' => 'Listing Terjual', 'value' => $stats['listings_sold']],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white border border-brand-line rounded-2xl p-5">
            <div class="text-brand-navy text-[24px] font-black"><?php echo e(number_format($s['value'])); ?></div>
            <div class="text-brand-muted text-[12px] font-bold mt-1"><?php echo e($s['label']); ?></div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<a href="<?php echo e(route('agent.listings.create')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-brand-blue text-white text-[13px] font-extrabold">+ Tambah Listing Baru</a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\agent\dashboard.blade.php ENDPATH**/ ?>