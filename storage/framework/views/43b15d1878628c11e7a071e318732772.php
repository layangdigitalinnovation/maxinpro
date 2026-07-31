<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kehilangan Akses 2FA — MaxinPro</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="<?php echo e(asset('favicon.png')); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans bg-brand-soft min-h-screen flex items-center justify-center px-6">
    <div class="w-full max-w-sm">
        <div class="text-center mb-6">
            <a href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset('images/logo-cropped.png')); ?>" alt="MaxinPro" class="h-10 mx-auto"></a>
        </div>
        <div class="bg-white border border-brand-line rounded-2xl p-7 shadow-card">
            <h1 class="text-brand-navy text-[18px] font-black mb-2">Kehilangan Akses ke Authenticator?</h1>
            <p class="text-brand-muted text-[12.5px] font-semibold mb-5">
                Kalau HP dan kode pemulihan Anda sama-sama hilang, masukkan email akun Anda —
                kami kirimkan tautan untuk menonaktifkan verifikasi dua langkah sehingga Anda bisa masuk kembali.
            </p>

            <?php if(session('status')): ?>
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-[12.5px] font-bold px-4 py-3"><?php echo e(session('status')); ?></div>
            <?php endif; ?>

            <form action="<?php echo e(route('two-factor.emergency-reset.request')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Email</label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus class="w-full h-[46px] border border-brand-line rounded-[9px] px-3.5 text-[13.5px] mb-2">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-[11.5px] font-bold mb-3"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <button type="submit" class="w-full h-[46px] rounded-[10px] bg-gradient-to-r from-[#0069ff] to-[#004de7] text-white font-extrabold text-[14px] mt-2">
                    Kirim Tautan Reset
                </button>
            </form>

            <p class="mt-4 text-[11px] text-brand-muted leading-relaxed">
                ⚠ Tautan ini akan menonaktifkan 2FA sepenuhnya. Segera aktifkan kembali setelah berhasil masuk.
                Pemilik akun asli akan langsung menerima email konfirmasi begitu 2FA dinonaktifkan.
            </p>
        </div>
        <p class="text-center mt-5 text-[12px] font-semibold text-brand-muted"><a href="<?php echo e(route('two-factor.challenge')); ?>">&larr; Kembali</a></p>
    </div>
</body>
</html>
<?php /**PATH D:\Layang\maxinpro.com\resources\views\auth\two-factor-emergency-reset.blade.php ENDPATH**/ ?>