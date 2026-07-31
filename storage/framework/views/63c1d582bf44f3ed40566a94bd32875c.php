<?php $__env->startSection('title', ($role->exists ? 'Edit' : 'Tambah') . ' Peran (Role) — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black"><?php echo e($role->exists ? 'Edit Peran' : 'Tambah Peran Baru'); ?></h1>
    <a href="<?php echo e(route('admin.roles.index')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
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

<form action="<?php echo e($role->exists ? route('admin.roles.update', $role) : route('admin.roles.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php if($role->exists): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div class="bg-white border border-brand-line rounded-2xl overflow-hidden max-w-3xl">
        <div class="p-6 md:p-8 border-b border-brand-line">
            <h2 class="text-brand-navy font-black text-[18px] flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Informasi Peran (Role)
            </h2>
            <p class="text-sm text-gray-500 mt-1">Tentukan nama peran dan hak akses (permissions) yang dimiliki.</p>
        </div>

        <div class="p-6 md:p-8 space-y-6">
            <div>
                <label class="block text-sm font-bold text-brand-navy mb-2">Nama Peran</label>
                <input type="text" name="name" value="<?php echo e(old('name', $role->name)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2.5 focus:ring-brand-blue focus:border-brand-blue bg-gray-50/50 transition-colors" required <?php echo e($role->name === 'admin' ? 'readonly' : ''); ?> placeholder="Contoh: manager, supervisor">
                <?php if($role->name === 'admin'): ?>
                    <p class="text-[11px] text-gray-500 mt-1">Nama peran admin tidak dapat diubah karena merupakan peran sistem utama.</p>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-sm font-bold text-brand-navy mb-3">Hak Akses (Permissions)</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 bg-gray-50/50 p-4 rounded-xl border border-brand-line">
                    <?php $__empty_1 = true; $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-white rounded border border-transparent hover:border-gray-200 transition-colors">
                            <input type="checkbox" name="permissions[]" value="<?php echo e($permission->name); ?>" 
                                <?php echo e((is_array(old('permissions')) && in_array($permission->name, old('permissions'))) || ($role->exists && $role->hasPermissionTo($permission->name)) ? 'checked' : ''); ?>

                                class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue w-4 h-4">
                            <span class="text-sm font-medium text-gray-700 select-none"><?php echo e($permission->name); ?></span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-gray-500 col-span-3">Belum ada permission di database.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="px-6 md:px-8 py-5 border-t border-brand-line bg-gray-50 flex justify-end">
            <button type="submit" class="h-11 px-8 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700 transition-colors shadow-sm">
                <?php echo e($role->exists ? 'Simpan Perubahan' : 'Buat Peran Baru'); ?>

            </button>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\admin\roles\form.blade.php ENDPATH**/ ?>