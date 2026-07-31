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
    <span class="inline-block px-3 py-1 bg-brand-blue/10 text-brand-blue text-[11px] font-black uppercase rounded-full mb-3"><?php echo e($article->category ?? 'Berita'); ?></span>
    <h1 class="text-brand-navy text-[28px] min-[900px]:text-[34px] leading-[1.25] font-black mt-2 mb-4"><?php echo e($article->title); ?></h1>
    
    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 rounded-full bg-brand-soft border border-brand-line flex items-center justify-center text-xl">
            ✍️
        </div>
        <div>
            <p class="text-[13px] font-black text-brand-navy">Tim Redaksi</p>
            <p class="text-[#7a8399] text-[12px] font-bold"><time datetime="<?php echo e($article->published_at?->toDateString()); ?>"><?php echo e($article->published_at?->translatedFormat('d M Y')); ?></time></p>
        </div>
    </div>

    <?php if($article->cover_image): ?>
    <div class="rounded-2xl overflow-hidden aspect-[2/1] mb-10 shadow-sm border border-brand-line/50">
        <img src="<?php echo e(asset('storage/'.$article->cover_image)); ?>" alt="<?php echo e($article->title); ?>" class="w-full h-full object-cover">
    </div>
    <?php endif; ?>

    <div class="prose max-w-none text-[#3a455e] text-[15.5px] leading-[1.8] font-medium pb-10 border-b border-brand-line">
        <?php echo $article->body; ?>

    </div>

    <!-- Share Section -->
    <div class="py-8 flex flex-col min-[600px]:flex-row items-center justify-between gap-4">
        <span class="text-[14px] font-bold text-brand-navy">Bagikan Artikel Ini:</span>
        <div class="flex items-center gap-3">
            <a href="https://wa.me/?text=<?php echo e(urlencode($article->title . ' - ' . route('articles.show', $article->slug))); ?>" target="_blank" rel="noopener" class="w-11 h-11 rounded-full flex items-center justify-center transition-colors shadow-sm share-wa" title="Share ke WhatsApp">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(route('articles.show', $article->slug))); ?>" target="_blank" rel="noopener" class="w-11 h-11 rounded-full flex items-center justify-center transition-colors shadow-sm share-fb" title="Share ke Facebook">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode(route('articles.show', $article->slug))); ?>&text=<?php echo e(urlencode($article->title)); ?>" target="_blank" rel="noopener" class="w-11 h-11 rounded-full flex items-center justify-center transition-colors shadow-sm share-x" title="Share ke X (Twitter)">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
            <button onclick="navigator.clipboard.writeText('<?php echo e(route('articles.show', $article->slug)); ?>'); alert('Link berhasil disalin!')" class="w-11 h-11 rounded-full border flex items-center justify-center transition-colors shadow-sm share-copy" title="Salin Link">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
            </button>
        </div>
    </div>
</article>
<div class="h-16"></div>

<?php $__env->startPush('styles'); ?>
<style>
/* Custom typography styles */
.prose h1, .prose h2, .prose h3, .prose h4 { color: #0f172a; font-weight: 900; margin-top: 1.5em; margin-bottom: 0.75em; line-height: 1.3; letter-spacing: -0.01em; }
.prose h2 { font-size: 1.6em; }
.prose h3 { font-size: 1.3em; }
.prose p { margin-bottom: 1.25em; line-height: 1.8; }
.prose ul { list-style-type: disc; padding-left: 1.5em; margin-bottom: 1.25em; }
.prose ol { list-style-type: decimal; padding-left: 1.5em; margin-bottom: 1.25em; }
.prose li { margin-bottom: 0.3em; }
.prose a { color: #3b82f6; text-decoration: underline; font-weight: 700; text-underline-offset: 4px; transition: color 0.2s; }
.prose a:hover { color: #2563eb; }
.prose strong { font-weight: 800; color: #0f172a; }
.prose blockquote { border-left: 4px solid #3b82f6; padding-left: 1.25em; font-style: italic; color: #64748b; margin: 1.5em 0; background: #f8fafc; padding: 1em 1.25em; border-radius: 0 12px 12px 0; }
.prose img { max-width: 100%; height: auto; border-radius: 16px; margin: 2em 0; box-shadow: 0 4px 20px -2px rgba(0,0,0,0.06); }

/* Share Buttons Custom CSS */
.share-wa { background-color: #f0fdf4; color: #16a34a; }
.share-wa:hover { background-color: #22c55e; color: #ffffff; }

.share-fb { background-color: #eff6ff; color: #2563eb; }
.share-fb:hover { background-color: #2563eb; color: #ffffff; }

.share-x { background-color: #f1f5f9; color: #334155; }
.share-x:hover { background-color: #1e293b; color: #ffffff; }

.share-copy { background-color: #f8fafc; border-color: #e2e8f0; color: #64748b; }
.share-copy:hover { background-color: #e2e8f0; color: #334155; }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/articles/show.blade.php ENDPATH**/ ?>