<?php $__env->startSection('title', ($testimonial->exists ? 'Edit' : 'Tambah') . ' Testimoni — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black"><?php echo e($testimonial->exists ? 'Edit Testimoni' : 'Tambah Testimoni Baru'); ?></h1>
    <a href="<?php echo e(route('admin.testimonials.index')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
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

<form action="<?php echo e($testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store')); ?>" method="POST" enctype="multipart/form-data" class="bg-white border border-brand-line rounded-2xl p-6 space-y-6">
    <?php echo csrf_field(); ?>
    <?php if($testimonial->exists): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Nama Klien</label>
            <input type="text" name="name" value="<?php echo e(old('name', $testimonial->name)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Kota / Asal (Opsional)</label>
            <input type="text" name="city" value="<?php echo e(old('city', $testimonial->city)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Rating (1-5)</label>
            <input type="number" name="rating" value="<?php echo e(old('rating', $testimonial->rating ?? 5)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required min="1" max="5">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Foto Klien (Opsional)</label>
            <input type="file" name="photo" accept="image/*" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
            <div class="text-xs text-gray-500 mt-1">Maksimal 2MB.</div>
            <?php if($testimonial->photo): ?>
                <img src="<?php echo e(Storage::url($testimonial->photo)); ?>" alt="Photo" class="mt-2 h-16 w-16 object-cover rounded-full">
            <?php endif; ?>
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-bold text-brand-navy mb-2">Isi Testimoni / Kutipan</label>
            <textarea name="quote" rows="4" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required><?php echo e(old('quote', $testimonial->quote)); ?></textarea>
        </div>

        <div class="col-span-2">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', $testimonial->exists ? $testimonial->is_active : true) ? 'checked' : ''); ?> class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue">
                <span class="text-sm font-bold text-brand-navy">Aktif & Tampilkan di Website</span>
            </label>
        </div>
    </div>

    <div class="flex justify-end border-t border-brand-line pt-6">
        <button type="submit" class="h-11 px-6 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            Simpan Testimoni
        </button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\admin\testimonials\form.blade.php ENDPATH**/ ?>