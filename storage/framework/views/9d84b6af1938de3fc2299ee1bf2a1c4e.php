<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['listing', 'saved' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['listing', 'saved' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<article class="bg-white border border-brand-line rounded-card overflow-hidden shadow-card">
    <div class="relative aspect-[2.1/1] bg-brand-soft">
        <img src="<?php echo e($listing->cover_image ? asset('storage/'.$listing->cover_image) : asset('images/hero-skyline.png')); ?>"
             alt="<?php echo e($listing->title); ?>" class="w-full h-full object-cover" loading="lazy">
        <?php if($listing->badge): ?>
            <span class="absolute left-2.5 top-2.5 h-[22px] px-2.5 rounded-full bg-gradient-to-r from-[#0a7cff] to-[#0054ef] text-white inline-flex items-center text-[10px] font-black uppercase">
                <?php echo e($listing->badge); ?>

            </span>
        <?php endif; ?>
        <?php if(auth()->guard()->check()): ?>
            <form action="<?php echo e(route('listings.toggle-save', $listing)); ?>" method="POST" class="absolute top-2.5 right-2.5">
                <?php echo csrf_field(); ?>
                <button type="submit" aria-label="Simpan" class="w-7 h-7 rounded-full grid place-items-center shadow <?php echo e($saved ? 'bg-brand-blue text-white' : 'bg-white/90 text-brand-blue'); ?>">
                    <?php echo e($saved ? '♥' : '♡'); ?>

                </button>
            </form>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" aria-label="Masuk untuk menyimpan" class="absolute top-2.5 right-2.5 w-7 h-7 rounded-full grid place-items-center shadow bg-white/90 text-brand-blue">♡</a>
        <?php endif; ?>
    </div>
    <div class="p-3.5 pb-4">
        <h3 class="mb-1 text-brand-navy text-[14px] leading-tight font-extrabold">
            <a href="<?php echo e(route('listings.show', $listing)); ?>"><?php echo e($listing->title); ?></a>
        </h3>
        <div class="text-[#55617a] text-[11.5px] font-bold mb-2.5"><?php echo e($listing->area->name); ?>, <?php echo e($listing->area->city); ?></div>
        <div class="flex items-center gap-2.5 text-[#51607a] text-[11.5px] font-bold mb-2.5 flex-wrap">
            <span>🚗 <?php echo e($listing->car_ports); ?></span>
            <span>🛏 <?php echo e($listing->bedrooms); ?></span>
            <span>🛁 <?php echo e($listing->bathrooms); ?></span>
            <span><?php echo e($listing->land_area); ?> m²</span>
        </div>
        <div class="text-brand-navy text-[15px] font-black"><?php echo e($listing->formatted_price); ?></div>
    </div>
</article>
<?php /**PATH D:\Layang\maxinpro.com\resources\views/components/listing-card.blade.php ENDPATH**/ ?>