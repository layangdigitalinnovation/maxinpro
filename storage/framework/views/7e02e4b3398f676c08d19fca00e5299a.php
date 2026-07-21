<?php $__env->startSection('title', $article->title . ' — MaxinPro'); ?>
<?php $__env->startSection('meta_description', $article->excerpt ?: Str::limit(strip_tags($article->body), 155)); ?>
<?php $__env->startSection('og_type', 'article'); ?>
<?php $__env->startSection('og_image', $article->cover_image ? asset('storage/' . $article->cover_image) : asset('images/og-default.jpg')); ?>

<?php $__env->startPush('schema'); ?>
<script type="application/ld+json">
<?php echo json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BlogPosting',
    'headline' => Str::limit($article->title, 110),
    'description' => $article->excerpt ?: Str::limit(strip_tags($article->body), 200),
    'image' => $article->cover_image ? asset('storage/' . $article->cover_image) : asset('images/placeholder-property.jpg'),
    'datePublished' => $article->published_at?->toIso8601String(),
    'dateModified' => $article->updated_at?->toIso8601String(),
    'author' => ['@type' => 'Organization', 'name' => 'MaxinPro'],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'MaxinPro',
        'logo' => ['@type' => 'ImageObject', 'url' => asset('images/logo-cropped.png')],
    ],
    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => route('articles.show', $article)],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>

</script>
<script type="application/ld+json">
<?php echo json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Artikel', 'item' => route('articles.index')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $article->title, 'item' => route('articles.show', $article)],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>

</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<article class="max-w-[760px] mx-auto px-8 pt-11">
    <span class="text-brand-blue text-[11px] font-black uppercase"><?php echo e($article->category); ?></span>
    <h1 class="text-brand-navy text-[26px] font-black mt-2 mb-2"><?php echo e($article->title); ?></h1>
    <p class="text-[#7a8399] text-[12px] font-bold mb-6"><time datetime="<?php echo e($article->published_at?->toDateString()); ?>"><?php echo e($article->published_at?->translatedFormat('d M Y')); ?></time></p>
    <div class="rounded-2xl overflow-hidden aspect-[2/1] mb-7 bg-brand-soft">
        <img src="<?php echo e($article->cover_image ? asset('storage/'.$article->cover_image) : asset('images/placeholder-property.jpg')); ?>" alt="<?php echo e($article->title); ?>" class="w-full h-full object-cover">
    </div>
    <div class="prose max-w-none text-[#3a455e] text-[14.5px] leading-relaxed font-medium">
        <?php echo nl2br(e($article->body)); ?>

    </div>
</article>
<div class="h-16"></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/articles/show.blade.php ENDPATH**/ ?>