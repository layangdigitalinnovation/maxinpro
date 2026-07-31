<?php $__env->startSection('title', ($user->exists ? 'Edit' : 'Tambah') . ' Pengguna — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black"><?php echo e($user->exists ? 'Edit Pengguna' : 'Tambah Pengguna Baru'); ?></h1>
    <a href="<?php echo e(route('admin.users.index')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
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

<form action="<?php echo e($user->exists ? route('admin.users.update', $user) : route('admin.users.store')); ?>" method="POST" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php if($user->exists): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div class="bg-white border border-brand-line rounded-2xl overflow-hidden max-w-3xl">
        <div class="p-6 md:p-8 border-b border-brand-line">
            <h2 class="text-brand-navy font-black text-[18px] flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Informasi Pengguna
            </h2>
            <p class="text-sm text-gray-500 mt-1">Lengkapi data profil dan peran akses pengguna di bawah ini.</p>
        </div>

        <div class="p-6 md:p-8 space-y-6">
            <div>
                <label class="block text-sm font-bold text-brand-navy mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2.5 focus:ring-brand-blue focus:border-brand-blue bg-gray-50/50 transition-colors" required placeholder="Contoh: Budi Santoso">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-brand-navy mb-2">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2.5 focus:ring-brand-blue focus:border-brand-blue bg-gray-50/50 transition-colors" required placeholder="budi@example.com">
                </div>

                <div>
                    <label class="block text-sm font-bold text-brand-navy mb-2">Peran (Role)</label>
                    <select name="role" class="w-full border border-brand-line rounded-lg px-4 py-2.5 focus:ring-brand-blue focus:border-brand-blue bg-gray-50/50 transition-colors" required>
                        <option value="" disabled <?php echo e(!old('role') && !$user->exists ? 'selected' : ''); ?>>Pilih Peran...</option>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($r->name); ?>" <?php echo e(old('role', $user->roles->first()?->name ?? '') == $r->name ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst($r->name)); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="pt-2">
                <label class="block text-sm font-bold text-brand-navy mb-2">Kata Sandi</label>
                <div class="relative">
                    <input type="password" name="password" class="w-full border border-brand-line rounded-lg pl-4 pr-10 py-2.5 focus:ring-brand-blue focus:border-brand-blue bg-gray-50/50 transition-colors" <?php echo e($user->exists ? '' : 'required'); ?> placeholder="••••••••">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                </div>
                <p class="text-[12px] text-gray-500 mt-2">
                    <?php if($user->exists): ?>
                        Biarkan kosong jika tidak ingin mengubah kata sandi saat ini.
                    <?php else: ?>
                        Gunakan minimal 8 karakter dengan kombinasi huruf dan angka untuk keamanan.
                    <?php endif; ?>
                </p>
            </div>
        </div>
        
        <div class="px-6 md:px-8 py-5 border-t border-brand-line bg-gray-50 flex justify-end">
            <button type="submit" class="h-11 px-8 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700 transition-colors shadow-sm">
                <?php echo e($user->exists ? 'Simpan Perubahan' : 'Buat Pengguna Baru'); ?>

            </button>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\admin\users\form.blade.php ENDPATH**/ ?>