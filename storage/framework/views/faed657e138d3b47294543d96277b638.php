<?php $__env->startSection('title', ($agent->exists ? 'Edit' : 'Tambah') . ' Agen — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black"><?php echo e($agent->exists ? 'Edit Agen' : 'Tambah Agen Baru'); ?></h1>
    <a href="<?php echo e(route('admin.agents.index')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
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

<form action="<?php echo e($agent->exists ? route('admin.agents.update', $agent) : route('admin.agents.store')); ?>" method="POST" class="bg-white border border-brand-line rounded-2xl p-6 space-y-6">
    <?php echo csrf_field(); ?>
    <?php if($agent->exists): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Nama Agen</label>
            <input type="text" name="name" value="<?php echo e(old('name', $agent->name)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Email Login</label>
            <?php if($agent->exists): ?>
                <input type="email" value="<?php echo e($agent->email); ?>" class="w-full border border-gray-200 bg-gray-100 rounded-lg px-4 py-2 text-gray-500" disabled readonly>
                <div class="text-xs text-gray-400 mt-1">Email login tidak dapat diubah setelah agen dibuat.</div>
            <?php else: ?>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
            <?php endif; ?>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">No. Handphone</label>
            <input type="text" name="phone" value="<?php echo e(old('phone', $agent->phone)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">No. WhatsApp</label>
            <input type="text" name="whatsapp" value="<?php echo e(old('whatsapp', $agent->whatsapp)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" placeholder="Contoh: 628123456789">
        </div>

        <?php if($agent->exists): ?>
            <div class="col-span-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', $agent->is_active) ? 'checked' : ''); ?> class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue">
                    <span class="text-sm font-bold text-brand-navy">Agen Aktif (Bisa login & tampil di web)</span>
                </label>
            </div>
        <?php endif; ?>
    </div>

    <div class="flex justify-end border-t border-brand-line pt-6">
        <button type="submit" class="h-11 px-6 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            Simpan Data Agen
        </button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/admin/agents/form.blade.php ENDPATH**/ ?>