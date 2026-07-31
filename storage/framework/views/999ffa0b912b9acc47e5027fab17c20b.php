<?php $__env->startSection('title', 'Kelola Project — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col lg:flex-row justify-between lg:items-center gap-4 mb-6">
    
    <h1 class="text-brand-navy text-[22px] font-black shrink-0">Kelola Project</h1>
    <div class="flex flex-wrap gap-2 w-full lg:w-auto items-center justify-start lg:justify-end">
        <form method="GET" class="relative w-full sm:w-48 xl:w-64 shrink-0">
            <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari..." class="h-11 pl-10 pr-4 rounded-lg border border-brand-line focus:ring-brand-blue focus:border-brand-blue text-sm w-full">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
        <button onclick="window.location.reload()" class="whitespace-nowrap h-11 px-3 sm:px-4 inline-flex items-center gap-1.5 rounded-lg bg-white border border-brand-line text-brand-navy text-[13px] font-extrabold hover:bg-gray-50" title="Refresh urutan tabel">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            Refresh
        </button>
        <a href="<?php echo e(route('admin.projects.order')); ?>" class="whitespace-nowrap h-11 px-4 inline-flex items-center rounded-lg bg-indigo-100 text-indigo-700 text-[13px] font-extrabold hover:bg-indigo-200">
            Atur Urutan
        </a>
        <a href="<?php echo e(route('admin.projects.trashed')); ?>" class="whitespace-nowrap h-11 px-4 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
            Sampah
        </a>
        <a href="<?php echo e(route('admin.projects.create')); ?>" class="whitespace-nowrap h-11 px-4 sm:px-5 inline-flex items-center rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            + Tambah Project
        </a>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 font-bold">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="bg-white border border-brand-line rounded-2xl overflow-hidden">
    <div class="overflow-x-auto"><table class="w-full min-w-[800px] text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-brand-line">
                <th class="p-4 font-bold text-sm text-brand-navy">Project</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Developer & Area</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Harga Mulai</th>
                <th class="p-4 font-bold text-sm text-brand-navy">Status</th>
                <th class="p-4 font-bold text-sm text-brand-navy text-center">Publish</th>
                <th class="p-4 font-bold text-sm text-brand-navy text-center">Urutan</th>
                <th class="p-4 font-bold text-sm text-brand-navy w-32">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-brand-line">
            <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="p-4">
                        <div class="font-bold text-sm text-brand-navy"><?php echo e($project->name); ?></div>
                        <div class="text-xs text-gray-500 mt-1">
                            <?php echo e($project->is_featured ? '⭐ Featured' : ''); ?>

                        </div>
                    </td>
                    <td class="p-4 text-sm text-brand-navy">
                        <span class="font-bold"><?php echo e($project->developer->name ?? '-'); ?></span><br>
                        <span class="text-xs text-gray-500"><?php echo e($project->area->name ?? '-'); ?></span>
                    </td>
                    <td class="p-4 font-bold text-sm text-brand-navy whitespace-nowrap">
                        Rp <?php echo e(number_format($project->price_from, 0, ',', '.')); ?>

                    </td>
                    <td class="p-4 text-sm">
                        <span class="px-2 py-1 rounded text-xs font-bold bg-gray-100 text-gray-700">
                            <?php echo e($project->status); ?>

                        </span>
                    </td>
                    <td class="p-4 text-sm text-center">
                        <label class="custom-toggle">
                            <input type="checkbox" class="publish-toggle-input" 
                                <?php echo e($project->is_published ? 'checked' : ''); ?>

                                data-id="<?php echo e($project->id); ?>"
                                data-url="<?php echo e(route('admin.projects.update-publish-ajax', $project)); ?>"
                            >
                            <span class="slider"></span>
                        </label>
                    </td>
                    <td class="p-4 text-sm text-center">
                        <div class="inline-flex items-center gap-2">
                            <input type="number" min="0"
                                class="w-16 h-8 text-center border border-brand-line rounded-lg focus:ring-brand-blue text-sm sort-order-input" 
                                value="<?php echo e($project->sort_order); ?>" 
                                data-id="<?php echo e($project->id); ?>"
                                data-url="<?php echo e(route('admin.projects.update-order-ajax', $project)); ?>"
                            >
                            <span class="text-green-500 opacity-0 transition-opacity duration-300 save-indicator-<?php echo e($project->id); ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                        </div>
                    </td>
                    <td class="p-4 text-sm flex gap-3">
                        <a href="<?php echo e(route('admin.projects.edit', $project)); ?>" class="text-blue-600 hover:underline font-bold">Edit</a>
                        <form action="<?php echo e(route('admin.projects.destroy', $project)); ?>" method="POST" onsubmit="return confirm('Pindahkan project ini ke sampah?');">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500 text-sm">Belum ada project yang ditambahkan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table></div>
</div>

<div class="mt-6">
    <?php echo e($projects->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.sort-order-input');
    
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            const url = this.dataset.url;
            const id = this.dataset.id;
            const value = this.value;
            const indicator = document.querySelector(`.save-indicator-${id}`);
            
            fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ sort_order: value })
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    indicator.classList.remove('opacity-0');
                    setTimeout(() => {
                        indicator.classList.add('opacity-0');
                    }, 2000);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    const publishInputs = document.querySelectorAll('.publish-toggle-input');
    publishInputs.forEach(input => {
        input.addEventListener('change', function() {
            const url = this.dataset.url;
            const value = this.checked;
            
            fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ is_published: value })
            })
            .then(response => response.json())
            .then(data => {
                if(data.status !== 'success') {
                    // Revert if failed
                    this.checked = !value;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !value; // Revert if failed
            });
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\admin\projects\index.blade.php ENDPATH**/ ?>