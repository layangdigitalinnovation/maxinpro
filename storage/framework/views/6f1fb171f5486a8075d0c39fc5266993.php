<?php $__env->startSection('title', 'Proyek Baru dari Developer Terpercaya — MaxinPro'); ?>
<?php $__env->startSection('meta_description', 'Daftar proyek baru dari developer terpercaya di Tangerang, Jakarta, dan sekitarnya. Lihat harga perdana, sisa unit, dan status launching terbaru.'); ?>
<?php $__env->startSection('canonical', request('page', 1) > 1
    ? route('projects.index') . '?page=' . (int) request('page')
    : route('projects.index')); ?>
<?php $__env->startSection('robots', request('page', 1) > 1 ? 'noindex, follow' : 'index, follow, max-image-preview:large'); ?>

<?php $__env->startSection('content'); ?>
<section class="max-w-[1280px] mx-auto px-8 pt-11">
    <h1 class="text-brand-navy text-[28px] min-[900px]:text-[30px] font-black mb-2.5">Proyek Baru</h1>
    <p class="text-[#5e6a84] text-[14.5px] font-semibold max-w-2xl leading-relaxed">
        Rekomendasi terbaik untuk Anda. Dapatkan informasi proyek terkini mengenai rumah minimalis, ruko strategis, hingga apartment modern dari developer terpercaya di Tangerang, Jakarta, dan sekitarnya.
    </p>
</section>

<section class="max-w-[1280px] mx-auto px-8 mt-6 flex items-center gap-2.5 flex-wrap">
    <?php $__currentLoopData = ['' => 'Semua', 'Launching' => 'Launching', 'Premium' => 'Premium', 'New Cluster' => 'New Cluster', 'Sold Out' => 'Sold Out']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('projects.index', $value ? ['status' => $value] : [])); ?>"
           class="h-[38px] px-[18px] rounded-full border inline-flex items-center text-[12.5px] font-extrabold
           <?php echo e(request('status', '') === $value ? 'bg-brand-blue text-white border-brand-blue' : 'border-brand-line text-brand-navy'); ?>">
            <?php echo e($label); ?>

        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</section>

<section class="max-w-[1280px] mx-auto px-8 mt-6 pb-14">
    <div class="grid grid-cols-1 min-[700px]:grid-cols-2 min-[1000px]:grid-cols-3 gap-5">
        <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if (isset($component)) { $__componentOriginaldbcceabf4a99a34f9999233ae1fef693 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldbcceabf4a99a34f9999233ae1fef693 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.project-card','data' => ['project' => $project]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('project-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['project' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($project)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldbcceabf4a99a34f9999233ae1fef693)): ?>
<?php $attributes = $__attributesOriginaldbcceabf4a99a34f9999233ae1fef693; ?>
<?php unset($__attributesOriginaldbcceabf4a99a34f9999233ae1fef693); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldbcceabf4a99a34f9999233ae1fef693)): ?>
<?php $component = $__componentOriginaldbcceabf4a99a34f9999233ae1fef693; ?>
<?php unset($__componentOriginaldbcceabf4a99a34f9999233ae1fef693); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-brand-muted text-sm col-span-full">Belum ada project pada status ini.</p>
        <?php endif; ?>
    </div>
    <div class="mt-8"><?php echo e($projects->links()); ?></div>
</section>

<section class="max-w-[1280px] mx-auto px-8 mb-16">
    <div class="rounded-2xl bg-gradient-to-r from-[#003ac0] to-[#001a68] text-white p-9 flex items-center justify-between gap-6 flex-wrap">
        <div>
            <h2 class="text-[21px] font-black mb-2">Punya project baru untuk dipasarkan?</h2>
            <p class="text-[13px] font-semibold opacity-90">Jadi developer partner MaxinPro dan jangkau ribuan calon pembeli aktif.</p>
        </div>
        <a href="https://wa.me/<?php echo e(setting('whatsapp_number', '6281112345678')); ?>" target="_blank" rel="noopener" class="h-12 px-6 rounded-[10px] bg-white text-brand-navy font-extrabold inline-flex items-center">Hubungi Tim Kami</a>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\projects\index.blade.php ENDPATH**/ ?>