<?php $__env->startSection('title', 'Project Terhapus — Admin MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">Project Terhapus</h1>
    <a href="<?php echo e(route('admin.projects.index')); ?>" class="text-[12.5px] font-extrabold">← Kembali ke Project Aktif</a>
</div>

<div class="bg-white border border-brand-line rounded-2xl overflow-hidden">
    <table class="w-full text-[13px]">
        <thead class="bg-brand-soft text-brand-navy text-[11.5px] font-black uppercase">
            <tr>
                <th class="text-left px-4 py-3">Nama</th>
                <th class="text-left px-4 py-3">Developer</th>
                <th class="text-left px-4 py-3">Dihapus Pada</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-t border-brand-line">
                    <td class="px-4 py-3 font-bold text-brand-navy"><?php echo e($project->name); ?></td>
                    <td class="px-4 py-3"><?php echo e($project->developer->name); ?></td>
                    <td class="px-4 py-3"><?php echo e($project->deleted_at->translatedFormat('d M Y H:i')); ?></td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <form action="<?php echo e(route('admin.projects.restore', $project->id)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="text-[12px] font-extrabold text-green-700 mr-3">Pulihkan</button>
                        </form>
                        <form action="<?php echo e(route('admin.projects.force-delete', $project->id)); ?>" method="POST" class="inline"
                              onsubmit="return confirm('Hapus PERMANEN? Data dan foto tidak bisa dikembalikan.');">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-[12px] font-extrabold text-red-600">Hapus Permanen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4" class="px-4 py-6 text-center text-brand-muted">Tidak ada project yang dihapus.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="mt-6"><?php echo e($projects->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\admin\projects\trashed.blade.php ENDPATH**/ ?>