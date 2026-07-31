<?php $__env->startSection('title', ($partnerBank->exists ? 'Edit' : 'Tambah') . ' Bank Rekanan — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black"><?php echo e($partnerBank->exists ? 'Edit Bank Rekanan' : 'Tambah Bank Rekanan'); ?></h1>
    <a href="<?php echo e(route('admin.partner-banks.index')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
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

<form action="<?php echo e($partnerBank->exists ? route('admin.partner-banks.update', $partnerBank) : route('admin.partner-banks.store')); ?>" method="POST" class="bg-white border border-brand-line rounded-2xl p-6 space-y-6 max-w-2xl">
    <?php echo csrf_field(); ?>
    <?php if($partnerBank->exists): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Nama Bank</label>
        <input type="text" name="name" value="<?php echo e(old('name', $partnerBank->name)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required placeholder="Contoh: BCA, Mandiri, BNI...">
    </div>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Urutan Tampil (Opsional)</label>
        <input type="number" name="sort_order" value="<?php echo e(old('sort_order', $partnerBank->sort_order ?? 0)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" min="0">
        <div class="text-xs text-gray-500 mt-1">Angka lebih kecil akan tampil lebih dulu.</div>
    </div>

    <div class="flex justify-end border-t border-brand-line pt-6">
        <button type="submit" class="h-11 px-6 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            Simpan Bank
        </button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\admin\partner-banks\form.blade.php ENDPATH**/ ?>