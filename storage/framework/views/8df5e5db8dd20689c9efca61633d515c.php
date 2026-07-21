<?php $__env->startSection('title', 'Atur Urutan Proyek Baru — Admin MaxinPro'); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-2">
    <h1 class="text-brand-navy text-[22px] font-black">Atur Urutan Proyek Baru</h1>
    <a href="<?php echo e(route('admin.projects.index')); ?>" class="text-[12.5px] font-extrabold">← Kembali</a>
</div>
<p class="text-brand-muted text-[12.5px] font-semibold mb-6 max-w-xl">
    Seret (drag) kartu untuk mengatur urutan tampil di beranda dan halaman Proyek Baru.
    Proyek paling atas akan muncul paling kiri/pertama. Perubahan tersimpan otomatis setiap kali urutan diubah.
</p>

<div id="save-indicator" class="hidden mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-[12.5px] font-bold px-4 py-3">
    Urutan berhasil disimpan.
</div>
<div id="save-error" class="hidden mb-4 rounded-lg bg-red-50 border border-red-200 text-red-800 text-[12.5px] font-bold px-4 py-3">
    Gagal menyimpan urutan. Muat ulang halaman dan coba lagi.
</div>

<ul id="project-order-list" class="bg-white border border-brand-line rounded-2xl divide-y divide-brand-line max-w-2xl">
    <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <li data-id="<?php echo e($project->id); ?>" class="flex items-center gap-4 p-4 cursor-grab active:cursor-grabbing bg-white">
            <span class="text-brand-muted text-lg select-none">⠿</span>
            <img src="<?php echo e($project->cover_image ? asset('storage/' . $project->cover_image) : asset('images/placeholder-property.jpg')); ?>"
                 alt="Cover <?php echo e($project->name); ?>" class="w-14 h-14 rounded-lg object-cover shrink-0">
            <div class="min-w-0 flex-1">
                <strong class="block text-brand-navy text-[13.5px] font-extrabold truncate"><?php echo e($project->name); ?></strong>
                <span class="text-[11.5px] font-semibold text-brand-muted"><?php echo e($project->developer->name); ?> · <?php echo e($project->status); ?></span>
            </div>
            <span class="order-number text-brand-navy text-[13px] font-black w-7 text-center shrink-0"><?php echo e($loop->iteration); ?></span>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <li class="p-6 text-center text-brand-muted text-[13px]">Belum ada project untuk diatur urutannya.</li>
    <?php endif; ?>
</ul>

<?php if($projects->isNotEmpty()): ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const list = document.getElementById('project-order-list');
    const okBox = document.getElementById('save-indicator');
    const errBox = document.getElementById('save-error');

    function renumber() {
        list.querySelectorAll('li[data-id]').forEach((li, i) => {
            const numEl = li.querySelector('.order-number');
            if (numEl) numEl.textContent = i + 1;
        });
    }

    Sortable.create(list, {
        animation: 150,
        handle: undefined, // whole row is draggable
        onEnd: async () => {
            renumber();
            okBox.classList.add('hidden');
            errBox.classList.add('hidden');

            const order = Array.from(list.querySelectorAll('li[data-id]')).map(li => li.dataset.id);

            try {
                const response = await fetch('<?php echo e(route('admin.projects.update-order')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ order }),
                });
                if (!response.ok) throw new Error('save failed');
                okBox.classList.remove('hidden');
            } catch (e) {
                errBox.classList.remove('hidden');
            }
        },
    });
});
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/admin/projects/order.blade.php ENDPATH**/ ?>