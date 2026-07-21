<?php $__env->startSection('title', ($area->exists ? 'Edit' : 'Tambah') . ' Area — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black"><?php echo e($area->exists ? 'Edit Area' : 'Tambah Area Baru'); ?></h1>
    <a href="<?php echo e(route('admin.areas.index')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
        Kembali
    </a>
</div>

<?php if($errors->any()): ?>
    <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 text-sm font-bold">
        Terdapat beberapa kesalahan:
        <ul class="list-disc pl-5 mt-2 font-normal">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?php echo e($area->exists ? route('admin.areas.update', $area) : route('admin.areas.store')); ?>" method="POST" class="bg-white border border-brand-line rounded-2xl p-6 space-y-6 max-w-2xl">
    <?php echo csrf_field(); ?>
    <?php if($area->exists): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Nama Area</label>
        <input type="text" name="name" value="<?php echo e(old('name', $area->name)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
    </div>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Kota</label>
        <input type="text" name="city" value="<?php echo e(old('city', $area->city)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
    </div>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Jumlah Properti (Opsional)</label>
        <input type="number" name="property_count" value="<?php echo e(old('property_count', $area->property_count)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" min="0">
    </div>

    <div>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_popular" value="1" <?php echo e(old('is_popular', $area->is_popular) ? 'checked' : ''); ?> class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue">
            <span class="text-sm font-bold text-brand-navy">Tandai sebagai Area Populer</span>
        </label>
    </div>

    <div class="flex justify-end border-t border-brand-line pt-6">
        <button type="submit" class="h-11 px-6 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            Simpan Area
        </button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/admin/areas/form.blade.php ENDPATH**/ ?>