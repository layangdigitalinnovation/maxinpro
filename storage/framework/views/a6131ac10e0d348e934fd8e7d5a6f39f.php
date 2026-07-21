<?php $__env->startSection('title', 'Ganti Kata Sandi — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<h1 class="text-brand-navy text-[20px] font-black mb-6">Ganti Kata Sandi</h1>

<form action="<?php echo e(route('account.password.update')); ?>" method="POST" class="bg-white border border-brand-line rounded-2xl p-6 max-w-md">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="grid gap-4">
        <div>
            <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Kata Sandi Saat Ini *</label>
            <input type="password" name="current_password" required class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px]">
            <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-[11.5px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Kata Sandi Baru *</label>
            <input type="password" name="password" required minlength="8" class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px]">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-[11.5px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Ulangi Kata Sandi Baru *</label>
            <input type="password" name="password_confirmation" required minlength="8" class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px]">
        </div>
    </div>

    <button type="submit" class="mt-6 h-11 px-6 rounded-lg bg-brand-blue text-white font-extrabold text-[13.5px]">Simpan Kata Sandi</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/account/password.blade.php ENDPATH**/ ?>