@extends('layouts.app')

@section('title', $article->title . ' — MaxinPro')
@section('meta_description', $article->excerpt ?: Str::limit(strip_tags($article->body), 155))
@section('og_type', 'article')
@section('og_image', $article->cover_image ? asset('storage/' . $article->cover_image) : asset('images/og-default.jpg'))

@push('schema')
<script type="application/ld+json">
{!! json_encode([
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
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Artikel', 'item' => route('articles.index')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $article->title, 'item' => route('articles.show', $article)],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
<article class="max-w-[760px] mx-auto px-8 pt-11">
    <span class="text-brand-blue text-[11px] font-black uppercase">{{ $article->category }}</span>
    <h1 class="text-brand-navy text-[26px] font-black mt-2 mb-2">{{ $article->title }}</h1>
    <p class="text-[#7a8399] text-[12px] font-bold mb-6"><time datetime="{{ $article->published_at?->toDateString() }}">{{ $article->published_at?->translatedFormat('d M Y') }}</time></p>
    <div class="rounded-2xl overflow-hidden aspect-[2/1] mb-7 bg-brand-soft">
        <img src="{{ $article->cover_image ? asset('storage/'.$article->cover_image) : asset('images/placeholder-property.jpg') }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
    </div>
    <div class="prose max-w-none text-[#3a455e] text-[14.5px] leading-relaxed font-medium">
        {!! nl2br(e($article->body)) !!}
    </div>
</article>
<div class="h-16"></div>
@endsection
