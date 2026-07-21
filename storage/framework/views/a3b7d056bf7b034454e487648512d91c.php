<?php $__env->startSection('title', 'Artikel & Insight — MaxinPro'); ?>
<?php $__env->startSection('meta_description', 'Artikel, tips, dan insight seputar membeli rumah, investasi properti, dan pengajuan KPR di Indonesia dari tim MaxinPro.'); ?>

<?php $__env->startSection('content'); ?>
<section class="max-w-[1280px] mx-auto px-8 pt-11">
    <h1 class="text-brand-navy text-[26px] font-black mb-8">Artikel & Insight</h1>
    <div class="grid grid-cols-1 min-[700px]:grid-cols-2 min-[1000px]:grid-cols-3 gap-6">
        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('articles.show', $article)); ?>" class="block">
                <div class="relative aspect-[2.2/1] rounded-xl overflow-hidden mb-2.5 bg-brand-soft">
                    <img src="<?php echo e($article->cover_image ? asset('storage/'.$article->cover_image) : asset('images/placeholder-property.jpg')); ?>" alt="<?php echo e($article->title); ?>" class="w-full h-full object-cover">
                </div>
                <h3 class="text-brand-navy text-[14px] font-extrabold leading-snug mb-1"><?php echo e($article->title); ?></h3>
                <time datetime="<?php echo e($article->published_at?->toDateString()); ?>" class="text-[11px] font-bold text-[#7a8399]"><?php echo e($article->published_at?->translatedFormat('d M Y')); ?></time>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="mt-8"><?php echo e($articles->links()); ?></div>
</section>
<div class="h-16"></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/articles/index.blade.php ENDPATH**/ ?>