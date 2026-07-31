<?php $__env->startSection('title', ($permission->exists ? 'Edit' : 'Tambah') . ' Permission — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black"><?php echo e($permission->exists ? 'Edit Permission' : 'Tambah Permission Baru'); ?></h1>
    <a href="<?php echo e(route('admin.permissions.index')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
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

<form action="<?php echo e($permission->exists ? route('admin.permissions.update', $permission) : route('admin.permissions.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php if($permission->exists): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div class="bg-white border border-brand-line rounded-2xl overflow-hidden max-w-xl">
        <div class="p-6 md:p-8 border-b border-brand-line">
            <h2 class="text-brand-navy font-black text-[18px] flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                Informasi Permission
            </h2>
            <p class="text-sm text-gray-500 mt-1">Permission digunakan untuk membatasi aksi tertentu (contoh: view_users, edit_projects).</p>
        </div>

        <div class="p-6 md:p-8">
            <div>
                <label class="block text-sm font-bold text-brand-navy mb-2">Nama Permission</label>
                <input type="text" name="name" value="<?php echo e(old('name', $permission->name)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2.5 focus:ring-brand-blue focus:border-brand-blue bg-gray-50/50 transition-colors" required placeholder="Contoh: create_post">
            </div>
        </div>
        
        <div class="px-6 md:px-8 py-5 border-t border-brand-line bg-gray-50 flex justify-end">
            <button type="submit" class="h-11 px-8 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700 transition-colors shadow-sm">
                <?php echo e($permission->exists ? 'Simpan Perubahan' : 'Buat Permission Baru'); ?>

            </button>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\admin\permissions\form.blade.php ENDPATH**/ ?>