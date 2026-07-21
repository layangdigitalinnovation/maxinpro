@extends('layouts.app')

@section('title', 'Artikel & Insight — MaxinPro')
@section('meta_description', 'Artikel, tips, dan insight seputar membeli rumah, investasi properti, dan pengajuan KPR di Indonesia dari tim MaxinPro.')

@section('content')
<section class="max-w-[1280px] mx-auto px-8 pt-11">
    <h1 class="text-brand-navy text-[26px] font-black mb-8">Artikel & Insight</h1>
    <div class="grid grid-cols-1 min-[700px]:grid-cols-2 min-[1000px]:grid-cols-3 gap-6">
        @foreach ($articles as $article)
            <a href="{{ route('articles.show', $article) }}" class="block">
                <div class="relative aspect-[2.2/1] rounded-xl overflow-hidden mb-2.5 bg-brand-soft">
                    <img src="{{ $article->cover_image ? asset('storage/'.$article->cover_image) : asset('images/placeholder-property.jpg') }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                </div>
                <h3 class="text-brand-navy text-[14px] font-extrabold leading-snug mb-1">{{ $article->title }}</h3>
                <time datetime="{{ $article->published_at?->toDateString() }}" class="text-[11px] font-bold text-[#7a8399]">{{ $article->published_at?->translatedFormat('d M Y') }}</time>
            </a>
        @endforeach
    </div>
    <div class="mt-8">{{ $articles->links() }}</div>
</section>
<div class="h-16"></div>
@endsection
