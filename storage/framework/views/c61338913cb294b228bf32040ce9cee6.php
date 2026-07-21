<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['project', 'compact' => false]));

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

foreach (array_filter((['project', 'compact' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<article class="bg-white border border-brand-line rounded-2xl overflow-hidden shadow-card <?php echo e($compact ? 'w-[270px] shrink-0' : ''); ?>">
    <div class="relative aspect-[1.8/1] bg-brand-soft">
        <img src="<?php echo e($project->cover_image ? asset('storage/'.$project->cover_image) : asset('images/hero-skyline.png')); ?>"
             alt="<?php echo e($project->name); ?>" class="w-full h-full object-cover" loading="lazy">
        <span class="absolute left-3 top-3 h-6 px-3 rounded-full bg-gradient-to-r from-[#0a7cff] to-[#0054ef] text-white inline-flex items-center text-[10.5px] font-black uppercase">
            <?php echo e($project->status); ?>

        </span>
    </div>
    <div class="p-4 pb-4.5">
        <div class="flex items-center justify-between mb-1.5">
            <?php if($project->propertyType): ?>
                <span class="text-brand-blue text-[10.5px] font-black uppercase tracking-wide"><?php echo e($project->propertyType->name); ?></span>
            <?php else: ?>
                <span></span>
            <?php endif; ?>
            <span class="text-[#9aa4b8] text-[10px] font-extrabold uppercase tracking-wide">by <?php echo e($project->developer->name); ?></span>
        </div>

        <h3 class="mb-1 text-brand-navy text-[16px] font-black leading-snug">
            <a href="<?php echo e(route('projects.show', $project)); ?>"><?php echo e($project->name); ?></a>
        </h3>
        <div class="text-[#55617a] text-[11.5px] font-bold mb-3"><?php echo e($project->area->name); ?>, <?php echo e($project->area->city); ?></div>

        <div class="flex items-center justify-between pt-3 border-t border-brand-line mb-3.5">
            <div>
                <div class="text-[#7a8399] text-[10.5px] font-bold">Mulai dari</div>
                <div class="text-brand-navy text-[15px] font-black"><?php echo e($project->formatted_price_from); ?></div>
            </div>
            <?php if($project->units_available): ?>
                <div class="text-[#39445e] text-[11.5px] font-bold text-right"><?php echo e($project->units_available); ?></div>
            <?php endif; ?>
        </div>

        <div class="flex items-center gap-2">
            <span class="flex-1 inline-flex items-center justify-center gap-1 h-9 rounded-lg border border-brand-line text-[11px] font-extrabold text-brand-navy truncate px-2">
                ✓ Official Partner
            </span>
            <a href="https://wa.me/6281112345678?text=<?php echo e(urlencode('Halo, saya tertarik dengan project: ' . $project->name)); ?>"
               target="_blank" rel="noopener"
               class="flex-1 inline-flex items-center justify-center h-9 rounded-lg bg-gradient-to-r from-[#0069ff] to-[#004de7] text-white text-[11.5px] font-extrabold">
                Hubungi
            </a>
        </div>
    </div>
</article>
<?php /**PATH D:\Layang\maxinpro.com\resources\views/components/project-card.blade.php ENDPATH**/ ?>