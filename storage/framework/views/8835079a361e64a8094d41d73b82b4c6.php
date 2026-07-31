<?php
    $heading = $propertyType
        ? "{$propertyType->name} Dijual di {$area->name}, {$area->city}"
        : "Properti Dijual di {$area->name}, {$area->city}";
?>

<?php $__env->startSection('title', $heading . ' — MaxinPro'); ?>
<?php $__env->startSection('meta_description', ($propertyType
    ? "Temukan {$propertyType->name} dijual di {$area->name}, {$area->city}. "
    : "Temukan rumah, apartemen, ruko, dan tanah dijual di {$area->name}, {$area->city}. ")
    . "{$listings->total()} listing aktif, harga transparan, agen profesional MaxinPro siap membantu."); ?>
<?php $__env->startSection('canonical', $propertyType
    ? route('area-landing.show-type', [$area, $propertyType])
    : route('area-landing.show', $area)); ?>

<?php $__env->startPush('schema'); ?>
<script type="application/ld+json">
<?php echo json_encode([
    '@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => array_filter([
        ['@type' => 'ListItem') ?>
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1280px] mx-auto px-8 pt-6 flex items-center gap-1.5 text-[#6d7890] text-[12.5px] font-bold flex-wrap">
    <a href="<?php echo e(route('home')); ?>" class="text-[#6d7890]">Beranda</a><span>/</span>
    <a href="<?php echo e(route('listings.index')); ?>" class="text-[#6d7890]">Listing</a><span>/</span>
    <span class="text-brand-navy"><?php echo e($area->name); ?></span>
    <?php if($propertyType): ?><span>/</span><span class="text-brand-navy"><?php echo e($propertyType->name); ?></span><?php endif; ?>
</div>

<section class="max-w-[1280px] mx-auto px-8 mt-4">
    <h1 class="text-brand-navy text-[26px] min-[900px]:text-[28px] font-black mb-2"><?php echo e($heading); ?></h1>
    <p class="text-[#5e6a84] text-[13.5px] font-semibold mb-6 max-w-2xl">
        <?php echo e($listings->total()); ?> properti aktif ditemukan di <?php echo e($area->name); ?>, <?php echo e($area->city); ?>.
        Semua listing sudah diverifikasi tim MaxinPro dan didampingi agen profesional.
    </p>

    <div class="flex items-center gap-2 flex-wrap mb-7">
        <a href="<?php echo e(route('area-landing.show', $area)); ?>"
           class="h-9 px-4 rounded-full border text-[12px] font-extrabold inline-flex items-center <?php echo e(!$propertyType ? 'bg-brand-blue text-white border-brand-blue' : 'border-brand-line text-brand-navy'); ?>">
            Semua Tipe
        </a>
        <?php $__currentLoopData = $propertyTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('area-landing.show-type', [$area, $type])); ?>"
               class="h-9 px-4 rounded-full border text-[12px] font-extrabold inline-flex items-center <?php echo e($propertyType?->id === $type->id ? 'bg-brand-blue text-white border-brand-blue' : 'border-brand-line text-brand-navy'); ?>">
                <?php echo e($type->name); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="grid grid-cols-1 min-[700px]:grid-cols-2 min-[1000px]:grid-cols-3 gap-5">
        <?php $__empty_1 = true; $__currentLoopData = $listings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if (isset($component)) { $__componentOriginal31ec1dc5dadb4835ef50de3d88e519ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal31ec1dc5dadb4835ef50de3d88e519ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listing-card','data' => ['listing' => $listing,'saved' => in_array($listing->id, $savedIds)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('listing-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing),'saved' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(in_array($listing->id, $savedIds))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal31ec1dc5dadb4835ef50de3d88e519ce)): ?>
<?php $attributes = $__attributesOriginal31ec1dc5dadb4835ef50de3d88e519ce; ?>
<?php unset($__attributesOriginal31ec1dc5dadb4835ef50de3d88e519ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal31ec1dc5dadb4835ef50de3d88e519ce)): ?>
<?php $component = $__componentOriginal31ec1dc5dadb4835ef50de3d88e519ce; ?>
<?php unset($__componentOriginal31ec1dc5dadb4835ef50de3d88e519ce); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-brand-muted text-sm col-span-full">
                Belum ada listing <?php echo e($propertyType?->name); ?> di <?php echo e($area->name); ?> saat ini.
                <a href="<?php echo e(route('titip-properti.create')); ?>">Titipkan properti Anda di sini →</a>
            </p>
        <?php endif; ?>
    </div>

    <div class="mt-8"><?php echo e($listings->links()); ?></div>
</section>
<div class="h-16"></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\area\show.blade.php ENDPATH**/ ?>