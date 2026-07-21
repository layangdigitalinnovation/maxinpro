<?php $__env->startSection('title', request('page', 1) > 1
    ? 'Listing Properti Dijual — Halaman ' . request('page') . ' | MaxinPro'
    : 'Listing Properti Dijual di Jabodetabek — MaxinPro'); ?>
<?php $__env->startSection('meta_description', 'Jelajahi listing properti dijual di Jabodetabek. Filter berdasarkan tipe, harga, dan jumlah kamar untuk menemukan rumah impian Anda bersama agen MaxinPro.'); ?>

<?php $__env->startSection('canonical', request('page', 1) > 1
    ? route('listings.index') . '?page=' . (int) request('page')
    : route('listings.index')); ?>
<?php $__env->startSection('robots', request('page', 1) > 1 ? 'noindex, follow' : 'index, follow, max-image-preview:large'); ?>

<?php $__env->startSection('content'); ?>
<section class="bg-brand-soft border-b border-brand-line py-6">
    <div class="max-w-[1280px] mx-auto px-8">
        <form action="<?php echo e(route('listings.index')); ?>" method="GET" class="grid grid-cols-1 min-[900px]:grid-cols-[2fr_1fr_1fr_auto] gap-3">
            <label class="h-12 border border-brand-line rounded-[10px] bg-white flex items-center gap-3 px-4">
                <span>🔍</span>
                <input type="search" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari lokasi, nama properti, atau keyword" class="w-full border-0 outline-none text-[14px] font-semibold">
            </label>
            <select name="sort" class="h-12 border border-brand-line rounded-[10px] px-4 text-[13px] font-bold text-brand-navy bg-white">
                <option value="terbaru" <?php if(request('sort', 'terbaru') === 'terbaru'): echo 'selected'; endif; ?>>Urutkan: Terbaru</option>
                <option value="harga_asc" <?php if(request('sort') === 'harga_asc'): echo 'selected'; endif; ?>>Harga Terendah</option>
                <option value="harga_desc" <?php if(request('sort') === 'harga_desc'): echo 'selected'; endif; ?>>Harga Tertinggi</option>
            </select>
            <select name="bedrooms" class="h-12 border border-brand-line rounded-[10px] px-4 text-[13px] font-bold text-brand-navy bg-white">
                <option value="">Kamar Tidur</option>
                <?php $__currentLoopData = [1,2,3,4]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($n); ?>" <?php if((int) request('bedrooms') === $n): echo 'selected'; endif; ?>><?php echo e($n); ?>+ KT</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="h-12 min-w-[120px] rounded-[10px] bg-gradient-to-r from-[#0069ff] to-[#004de7] text-white font-extrabold text-[13px]">Cari</button>
        </form>
    </div>
</section>

<div class="max-w-[1280px] mx-auto px-8 pt-6 flex items-center gap-1.5 text-[#6d7890] text-[12.5px] font-bold">
    <a href="<?php echo e(route('home')); ?>" class="text-[#6d7890]">Beranda</a><span>/</span><span class="text-brand-navy">Listing</span>
</div>

<div class="max-w-[1280px] mx-auto px-8 mt-4 grid grid-cols-1 min-[900px]:grid-cols-[240px_1fr] gap-8 items-start">
    <aside class="bg-white border border-brand-line rounded-2xl p-5 min-[900px]:sticky top-[92px] z-20">
        <strong class="block text-brand-navy text-[14px] font-black mb-4">Filter</strong>
        <form action="<?php echo e(route('listings.index')); ?>" method="GET">
            <input type="hidden" name="q" value="<?php echo e(request('q')); ?>">
            <div class="mb-4">
                <strong class="block text-brand-navy text-[12.5px] font-extrabold mb-2.5">Tipe Properti</strong>
                <?php $__currentLoopData = $propertyTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="flex items-center gap-2 mb-2 text-[13px] font-semibold text-[#39445e]">
                        <input type="checkbox" name="type[]" value="<?php echo e($type->id); ?>"
                               <?php if(collect(request('type', []))->contains($type->id)): echo 'checked'; endif; ?>>
                        <?php echo e($type->name); ?>

                    </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <button type="submit" class="w-full h-10 rounded-lg bg-brand-navy text-white text-[12.5px] font-extrabold">Terapkan Filter</button>
        </form>
    </aside>

    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-brand-navy text-[22px] font-black mb-0.5">Properti Dijual di Seluruh Indonesia</h1>
                <p class="text-[#5e6a84] text-[12.5px] font-semibold">Menampilkan <?php echo e($listings->count()); ?> dari <?php echo e($listings->total()); ?> properti</p>
            </div>
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
                <p class="text-brand-muted text-sm col-span-full">Tidak ada properti yang cocok dengan pencarian Anda.</p>
            <?php endif; ?>
        </div>

        <div class="mt-8">
            <?php echo e($listings->onEachSide(1)->links()); ?>

        </div>
    </div>
</div>
<div class="h-16"></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/listings/index.blade.php ENDPATH**/ ?>