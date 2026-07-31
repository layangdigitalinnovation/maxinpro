<?php $__env->startSection('title', 'Data Pengguna — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Data Pengguna</h1>
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <form method="GET" class="relative w-full sm:w-64">
            <!-- Preserve existing filters -->
            <?php $__currentLoopData = request()->except(['q', 'page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari..." class="h-11 pl-10 pr-4 rounded-lg border border-brand-line focus:ring-brand-blue focus:border-brand-blue text-sm w-full">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
        <div class="flex gap-3 w-full sm:w-auto">
            <a href="<?php echo e(route('admin.users.create')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
                + Tambah Pengguna
            </a>
        </div>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 text-sm font-bold">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 text-sm font-bold">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<div class="bg-white border border-brand-line rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[800px] text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-brand-line">
                    <th class="p-4 font-bold text-sm text-brand-navy">Nama Lengkap</th>
                    <th class="p-4 font-bold text-sm text-brand-navy">Email</th>
                    <th class="p-4 font-bold text-sm text-brand-navy">Peran</th>
                    <th class="p-4 font-bold text-sm text-brand-navy">Status Verifikasi</th>
                    <th class="p-4 font-bold text-sm text-brand-navy w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-line">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-sm font-bold text-brand-navy"><?php echo e($u->name); ?></td>
                        <td class="p-4 text-sm text-gray-700"><?php echo e($u->email); ?></td>
                        <td class="p-4 text-sm">
                            <?php $roleName = $u->roles->first()?->name ?? 'Belum ada peran'; ?>
                            <span class="px-2 py-1 rounded text-xs font-bold <?php echo e($roleName === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700'); ?>">
                                <?php echo e(strtoupper($roleName)); ?>

                            </span>
                        </td>
                        <td class="p-4 text-sm">
                            <?php if($u->email_verified_at): ?>
                                <span class="text-green-600 font-bold">Terverifikasi</span>
                            <?php else: ?>
                                <span class="text-gray-500 font-bold">Belum</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 text-sm flex gap-3">
                            <a href="<?php echo e(route('admin.users.edit', $u)); ?>" class="text-blue-600 hover:underline font-bold">Edit</a>
                            <?php if($u->id !== auth()->id()): ?>
                            <form action="<?php echo e(route('admin.users.destroy', $u)); ?>" method="POST" onsubmit="return confirm('Hapus pengguna ini?');" class="inline-block">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-500 text-sm">Belum ada pengguna.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php if(method_exists($users, 'links')): ?>
<div class="mt-6"><?php echo e($users->links()); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\admin\users\index.blade.php ENDPATH**/ ?>