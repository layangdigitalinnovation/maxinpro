<?php $__env->startSection('title', $listing->title . ' — ' . $listing->area->name . ' | MaxinPro'); ?>
<?php $__env->startSection('meta_description', Str::limit(strip_tags($listing->description ?: ($listing->title . ' di ' . $listing->area->name . ', ' . $listing->area->city . '. ' . $listing->bedrooms . ' kamar tidur, ' . $listing->land_area . ' m² tanah. Harga ' . $listing->formatted_price . '.')), 155)); ?>
<?php $__env->startSection('og_type', 'product'); ?>
<?php $__env->startSection('og_image', $listing->cover_image ? asset('storage/' . $listing->cover_image) : asset('images/og-default.jpg')); ?>

<?php $__env->startPush('schema'); ?>
<script type="application/ld+json">
<?php echo json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Accommodation',
    'name' => $listing->title,
    'description' => Str::limit(strip_tags($listing->description ?? ''), 300),
    'url' => route('listings.show', $listing),
    'image' => $listing->images->isNotEmpty()
        ? $listing->images->map(fn ($img) => asset('storage/' . $img->path))->prepend($listing->cover_image ? asset('storage/' . $listing->cover_image) : null)->filter()->values()->all()
        : ($listing->cover_image ? asset('storage/' . $listing->cover_image) : asset('images/placeholder-property.jpg')),
    'numberOfBedrooms' => $listing->bedrooms,
    'numberOfBathroomsTotal' => $listing->bathrooms,
    'floorSize' => ['@type' => 'QuantitativeValue', 'value' => $listing->building_area, 'unitCode' => 'MTK'],
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => $listing->address,
        'addressLocality' => $listing->area->name,
        'addressRegion' => $listing->area->city,
        'addressCountry' => 'ID',
    ],
    'offers' => [
        '@type' => 'Offer',
        'price' => $listing->price,
        'priceCurrency' => 'IDR',
        'availability' => $listing->status === 'active'
            ? 'https://schema.org/InStock'
            : 'https://schema.org/SoldOut',
        'url' => route('listings.show', $listing),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>

</script>
<script type="application/ld+json">
<?php echo json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Listing', 'item' => route('listings.index')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $listing->title, 'item' => route('listings.show', $listing)],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>

</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1280px] mx-auto px-8 pt-6 flex items-center gap-1.5 text-[#6d7890] text-[12.5px] font-bold">
    <a href="<?php echo e(route('home')); ?>" class="text-[#6d7890]">Beranda</a><span>/</span>
    <a href="<?php echo e(route('listings.index')); ?>" class="text-[#6d7890]">Listing</a><span>/</span>
    <span class="text-brand-navy"><?php echo e($listing->title); ?></span>
</div>

<div class="max-w-[1280px] mx-auto px-8 mt-4 grid grid-cols-1 min-[900px]:grid-cols-[1.6fr_1fr] gap-8 items-start">
    <div>
        <div class="rounded-2xl overflow-hidden aspect-[1.8/1] bg-brand-soft mb-5 relative">
            <img src="<?php echo e($listing->cover_image ? asset('storage/'.$listing->cover_image) : asset('images/placeholder-property.jpg')); ?>" alt="<?php echo e($listing->title); ?>" class="w-full h-full object-cover">
            <?php if($listing->youtube_url): ?>
                <a href="<?php echo e($listing->youtube_url); ?>" target="_blank" class="absolute bottom-4 right-4 bg-white hover:bg-gray-50 text-brand-navy font-extrabold text-[13px] py-2 px-4 rounded-lg shadow-md flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4 text-[#0069ff]" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    Video
                </a>
            <?php endif; ?>
        </div>

        <?php if($listing->images->isNotEmpty()): ?>
            <div class="grid grid-cols-4 gap-3 mb-6">
                <?php $__currentLoopData = $listing->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <img src="<?php echo e(asset('storage/'.$img->path)); ?>" alt="" class="rounded-lg aspect-square object-cover">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <h1 class="text-brand-navy text-[24px] font-black mb-1"><?php echo e($listing->title); ?></h1>
        <p class="text-[#55617a] text-[13px] font-bold mb-4"><?php echo e($listing->address); ?>, <?php echo e($listing->area->name); ?>, <?php echo e($listing->area->city); ?></p>

        <div class="flex items-center gap-5 text-[#39445e] text-[13px] font-bold mb-6 flex-wrap">
            <span>🚗 <?php echo e($listing->car_ports); ?> Carport</span>
            <span>🛏 <?php echo e($listing->bedrooms); ?> Kamar Tidur</span>
            <span>🛁 <?php echo e($listing->bathrooms); ?> Kamar Mandi</span>
            <span><?php echo e($listing->land_area); ?> m² Tanah</span>
            <span><?php echo e($listing->building_area); ?> m² Bangunan</span>
        </div>

        <h2 class="text-brand-navy text-[16px] font-extrabold mb-2">Deskripsi</h2>
        <p class="text-[#3a455e] text-[13.5px] leading-relaxed font-medium mb-6"><?php echo e($listing->description); ?></p>
    </div>

    <aside class="border border-brand-line rounded-2xl p-6 sticky top-[92px]">
        <div class="text-brand-navy text-[26px] font-black mb-4"><?php echo e($listing->formatted_price); ?></div>
        <?php if(auth()->guard()->check()): ?>
            <form action="<?php echo e(route('listings.toggle-save', $listing)); ?>" method="POST" class="mb-4">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 h-11 rounded-[10px] border <?php echo e($isSaved ? 'border-brand-blue text-brand-blue' : 'border-brand-line text-brand-navy'); ?> font-extrabold text-[13px]">
                    <?php echo e($isSaved ? '♥ Tersimpan di Favorit' : '♡ Simpan ke Favorit'); ?>

                </button>
            </form>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="w-full mb-4 inline-flex items-center justify-center gap-2 h-11 rounded-[10px] border border-brand-line text-brand-navy font-extrabold text-[13px]">
                ♡ Masuk untuk Menyimpan
            </a>
        <?php endif; ?>
        <?php if($listing->agent): ?>
            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-brand-line">
                <div class="w-11 h-11 rounded-full bg-brand-soft grid place-items-center text-brand-blue font-black"><?php echo e(Str::substr($listing->agent->name, 0, 1)); ?></div>
                <div>
                    <strong class="block text-brand-navy text-[13.5px] font-extrabold"><?php echo e($listing->agent->name); ?></strong>
                    <span class="text-[11.5px] font-bold text-[#7a8399]">Agen MaxinPro</span>
                </div>
            </div>
        <?php endif; ?>
        <a href="https://wa.me/6281112345678?text=<?php echo e(urlencode('Halo, saya tertarik dengan properti: ' . $listing->title)); ?>" target="_blank" rel="noopener"
           class="w-full inline-flex items-center justify-center h-12 rounded-[10px] bg-gradient-to-r from-[#0069ff] to-[#004de7] text-white font-extrabold text-[13.5px]">
            Hubungi via WhatsApp
        </a>
    </aside>
</div>

<?php if($related->isNotEmpty()): ?>
<section class="max-w-[1280px] mx-auto px-8 mt-14">
    <h2 class="text-brand-navy font-black text-[22px] mb-4">Properti Sejenis di Area Ini</h2>
    <div class="grid grid-cols-1 min-[700px]:grid-cols-3 gap-5">
        <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginal31ec1dc5dadb4835ef50de3d88e519ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal31ec1dc5dadb4835ef50de3d88e519ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listing-card','data' => ['listing' => $item,'saved' => in_array($item->id, $savedIds)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('listing-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item),'saved' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(in_array($item->id, $savedIds))]); ?>
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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>
<?php endif; ?>
<div class="h-16"></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/listings/show.blade.php ENDPATH**/ ?>