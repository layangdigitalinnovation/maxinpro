@extends('layouts.app')

@section('title', $listing->title . ' — ' . $listing->area->name . ' | MaxinPro')
@section('meta_description', Str::limit(strip_tags($listing->description ?: ($listing->title . ' di ' . $listing->area->name . ', ' . $listing->area->city . '. ' . $listing->bedrooms . ' kamar tidur, ' . $listing->land_area . ' m² tanah. Harga ' . $listing->formatted_price . '.')), 155))
@section('og_type', 'product')
@section('og_image', $listing->cover_image ? asset('storage/' . $listing->cover_image) : asset('images/og-default.jpg'))

@push('schema')
<script type="application/ld+json">
{!! json_encode([
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
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Listing', 'item' => route('listings.index')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $listing->title, 'item' => route('listings.show', $listing)],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
<div class="max-w-[1280px] mx-auto px-8 pt-6 flex items-center gap-1.5 text-[#6d7890] text-[12.5px] font-bold">
    <a href="{{ route('home') }}" class="text-[#6d7890]">Beranda</a><span>/</span>
    <a href="{{ route('listings.index') }}" class="text-[#6d7890]">Listing</a><span>/</span>
    <span class="text-brand-navy">{{ $listing->title }}</span>
</div>

<div class="max-w-[1280px] mx-auto px-8 mt-4 grid grid-cols-1 min-[900px]:grid-cols-[1.6fr_1fr] gap-8 items-start">
    <div>
        <div class="rounded-2xl overflow-hidden aspect-[1.8/1] bg-brand-soft mb-5">
            <img src="{{ $listing->cover_image ? asset('storage/'.$listing->cover_image) : asset('images/placeholder-property.jpg') }}" alt="{{ $listing->title }}" class="w-full h-full object-cover">
        </div>

        @if ($listing->images->isNotEmpty())
            <div class="grid grid-cols-4 gap-3 mb-6">
                @foreach ($listing->images as $img)
                    <img src="{{ asset('storage/'.$img->path) }}" alt="" class="rounded-lg aspect-square object-cover">
                @endforeach
            </div>
        @endif

        <h1 class="text-brand-navy text-[24px] font-black mb-1">{{ $listing->title }}</h1>
        <p class="text-[#55617a] text-[13px] font-bold mb-4">{{ $listing->address }}, {{ $listing->area->name }}, {{ $listing->area->city }}</p>

        <div class="flex items-center gap-5 text-[#39445e] text-[13px] font-bold mb-6 flex-wrap">
            <span>🚗 {{ $listing->car_ports }} Carport</span>
            <span>🛏 {{ $listing->bedrooms }} Kamar Tidur</span>
            <span>🛁 {{ $listing->bathrooms }} Kamar Mandi</span>
            <span>{{ $listing->land_area }} m² Tanah</span>
            <span>{{ $listing->building_area }} m² Bangunan</span>
        </div>

        <h2 class="text-brand-navy text-[16px] font-extrabold mb-2">Deskripsi</h2>
        <p class="text-[#3a455e] text-[13.5px] leading-relaxed font-medium mb-6">{{ $listing->description }}</p>
    </div>

    <aside class="border border-brand-line rounded-2xl p-6 sticky top-[92px]">
        <div class="text-brand-navy text-[26px] font-black mb-4">{{ $listing->formatted_price }}</div>
        @auth
            <form action="{{ route('listings.toggle-save', $listing) }}" method="POST" class="mb-4">
                @csrf
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 h-11 rounded-[10px] border {{ $isSaved ? 'border-brand-blue text-brand-blue' : 'border-brand-line text-brand-navy' }} font-extrabold text-[13px]">
                    {{ $isSaved ? '♥ Tersimpan di Favorit' : '♡ Simpan ke Favorit' }}
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="w-full mb-4 inline-flex items-center justify-center gap-2 h-11 rounded-[10px] border border-brand-line text-brand-navy font-extrabold text-[13px]">
                ♡ Masuk untuk Menyimpan
            </a>
        @endauth
        @if ($listing->agent)
            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-brand-line">
                <div class="w-11 h-11 rounded-full bg-brand-soft grid place-items-center text-brand-blue font-black">{{ Str::substr($listing->agent->name, 0, 1) }}</div>
                <div>
                    <strong class="block text-brand-navy text-[13.5px] font-extrabold">{{ $listing->agent->name }}</strong>
                    <span class="text-[11.5px] font-bold text-[#7a8399]">Agen MaxinPro</span>
                </div>
            </div>
        @endif
        <a href="https://wa.me/6281112345678?text={{ urlencode('Halo, saya tertarik dengan properti: ' . $listing->title) }}" target="_blank" rel="noopener"
           class="w-full inline-flex items-center justify-center h-12 rounded-[10px] bg-gradient-to-r from-[#0069ff] to-[#004de7] text-white font-extrabold text-[13.5px]">
            Hubungi via WhatsApp
        </a>
    </aside>
</div>

@if ($related->isNotEmpty())
<section class="max-w-[1280px] mx-auto px-8 mt-14">
    <h2 class="text-brand-navy font-black text-[22px] mb-4">Properti Sejenis di Area Ini</h2>
    <div class="grid grid-cols-1 min-[700px]:grid-cols-3 gap-5">
        @foreach ($related as $item)
            <x-listing-card :listing="$item" :saved="in_array($item->id, $savedIds)" />
        @endforeach
    </div>
</section>
@endif
<div class="h-16"></div>
@endsection
