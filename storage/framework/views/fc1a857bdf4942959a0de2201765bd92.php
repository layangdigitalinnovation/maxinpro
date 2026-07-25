<?php $__env->startSection('title', 'Pengaturan Website — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Pengaturan Website</h1>
</div>

<?php if(session('success')): ?>
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 font-bold">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" class="bg-white border border-brand-line rounded-2xl p-6 space-y-6 max-w-2xl">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <h3 class="text-lg font-black text-brand-navy border-b border-brand-line pb-2">Pengaturan Kontak & Media Sosial</h3>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Nomor WhatsApp CS (Utama)</label>
        <p class="text-[12px] text-gray-500 mb-2">Semua tombol "Hubungi via WhatsApp" di website akan mengarah ke nomor ini. Gunakan format kode negara (contoh: 6281234567890).</p>
        <input type="text" name="whatsapp_number" value="<?php echo e($settings['whatsapp_number'] ?? ''); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" placeholder="6281112345678" required>
    </div>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Email Kontak</label>
        <input type="email" name="contact_email" value="<?php echo e($settings['contact_email'] ?? ''); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" placeholder="info@maxinpro.co.id" required>
    </div>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Tautan Instagram</label>
        <input type="url" name="instagram_url" value="<?php echo e($settings['instagram_url'] ?? ''); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" placeholder="https://instagram.com/...">
    </div>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Tautan Facebook</label>
        <input type="url" name="facebook_url" value="<?php echo e($settings['facebook_url'] ?? ''); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" placeholder="https://facebook.com/...">
    </div>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Alamat Kantor</label>
        <textarea name="office_address" rows="3" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue"><?php echo e($settings['office_address'] ?? ''); ?></textarea>
    </div>

    <div class="flex justify-end border-t border-brand-line pt-6">
        <button type="submit" class="h-11 px-6 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            Simpan Pengaturan
        </button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>