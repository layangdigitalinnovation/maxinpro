<?php $__env->startSection('title', 'Dashboard Admin — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-end mb-8">
    <div>
        <h1 class="text-brand-navy text-[26px] font-black tracking-tight">Dashboard Overview</h1>
        <p class="text-brand-muted text-sm mt-1">Selamat datang kembali, pantau performa agen dan properti Anda hari ini.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <?php $__currentLoopData = [
        ['label' => 'Listing Aktif', 'value' => $stats['listings_active'], 'icon' => '🏠', 'color' => 'bg-blue-50 text-blue-600'],
        ['label' => 'Total Listing', 'value' => $stats['listings_total'], 'icon' => '🏢', 'color' => 'bg-indigo-50 text-indigo-600'],
        ['label' => 'Project Rilis', 'value' => $stats['projects_published'], 'icon' => '🏗️', 'color' => 'bg-purple-50 text-purple-600'],
        ['label' => 'Agen Aktif', 'value' => $stats['agents_active'], 'icon' => '🧑‍💼', 'color' => 'bg-emerald-50 text-emerald-600'],
        ['label' => 'Lead Baru', 'value' => $stats['leads_new'], 'icon' => '🔥', 'color' => 'bg-orange-50 text-orange-600'],
        ['label' => 'Total Lead', 'value' => $stats['leads_total'], 'icon' => '📊', 'color' => 'bg-rose-50 text-rose-600'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white border border-brand-line p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-brand-muted text-[13px] font-bold uppercase tracking-wider mb-2"><?php echo e($s['label']); ?></div>
                    <div class="text-brand-navy text-[32px] font-black leading-none"><?php echo e(number_format($s['value'])); ?></div>
                </div>
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl <?php echo e($s['color']); ?> shadow-sm">
                    <?php echo e($s['icon']); ?>

                </div>
            </div>
            <div class="absolute -bottom-4 -right-4 text-[80px] opacity-[0.03] transform group-hover:scale-110 transition-transform duration-500 pointer-events-none">
                <?php echo e($s['icon']); ?>

            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white border border-brand-line p-6 flex flex-col">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-brand-navy text-[18px] font-black">Lead Terbaru Masuk</h2>
            <a href="<?php echo e(route('admin.leads.index')); ?>" class="text-xs font-bold text-brand-blue hover:text-brand-blue2 bg-brand-soft px-3 py-1.5 rounded-lg transition-colors">Lihat Semua</a>
        </div>
        
        <?php if($recentLeads->count()): ?>
            <ul class="space-y-4 flex-1">
                <?php $__currentLoopData = $recentLeads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-full bg-brand-soft flex items-center justify-center text-brand-blue font-bold text-sm">
                            <?php echo e(substr($lead->name, 0, 1)); ?>

                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="block font-bold text-[14px] text-brand-navy truncate group-hover:text-brand-blue transition-colors"><?php echo e($lead->name); ?></span>
                            <span class="block text-[12px] text-brand-muted truncate"><?php echo e($lead->property_type ?? 'Properti'); ?> &bull; <?php echo e($lead->city ?? 'Tanpa Kota'); ?></span>
                        </div>
                        <div class="text-[11px] font-bold text-brand-muted bg-gray-50 px-2.5 py-1 rounded-md border border-gray-100 whitespace-nowrap">
                            <?php echo e($lead->created_at->diffForHumans()); ?>

                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <div class="flex-1 flex flex-col items-center justify-center py-8 text-center">
                <div class="text-4xl mb-3 opacity-50">📥</div>
                <p class="text-sm text-brand-muted font-medium">Belum ada lead properti yang masuk.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="bg-white border border-brand-line p-6">
        <h2 class="text-brand-navy text-[18px] font-black mb-6">Distribusi Status Lead</h2>
        <ul class="space-y-4">
            <?php $__currentLoopData = $leadsByStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="flex justify-between items-center bg-brand-soft/50 hover:bg-brand-soft p-4 rounded-xl border border-transparent hover:border-brand-line/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full <?php echo e($status === 'new' ? 'bg-orange-500' : ($status === 'contacted' ? 'bg-blue-500' : 'bg-emerald-500')); ?>"></div>
                        <span class="text-[14px] font-bold text-brand-navy capitalize"><?php echo e($status); ?></span>
                    </div>
                    <span class="font-black text-[18px] text-brand-navy bg-white shadow-sm px-3 py-1 rounded-lg border border-brand-line/50"><?php echo e(number_format($count)); ?></span>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>