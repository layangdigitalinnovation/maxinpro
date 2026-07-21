@extends('layouts.app')

@php
    $heading = $propertyType
        ? "{$propertyType->name} Dijual di {$area->name}, {$area->city}"
        : "Properti Dijual di {$area->name}, {$area->city}";
@endphp

@section('title', $heading . ' — MaxinPro')
@section('meta_description', ($propertyType
    ? "Temukan {$propertyType->name} dijual di {$area->name}, {$area->city}. "
    : "Temukan rumah, apartemen, ruko, dan tanah dijual di {$area->name}, {$area->city}. ")
    . "{$listings->total()} listing aktif, harga transparan, agen profesional MaxinPro siap membantu.")
@section('canonical', $propertyType
    ? route('area-landing.show-type', [$area, $propertyType])
    : route('area-landing.show', $area))

@push('schema')
<script type="application/ld+json">
@json([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => array_filter([
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Listing', 'item' => route('listings.index')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $area->name, 'item' => route('area-landing.show', $area)],
        $propertyType ? ['@type' => 'ListItem', 'position' => 4, 'name' => $propertyType->name, 'item' => route('area-landing.show-type', [$area, $propertyType])] : null,
    ]),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
</script>
@endpush

@section('content')
<div class="max-w-[1280px] mx-auto px-8 pt-6 flex items-center gap-1.5 text-[#6d7890] text-[12.5px] font-bold flex-wrap">
    <a href="{{ route('home') }}" class="text-[#6d7890]">Beranda</a><span>/</span>
    <a href="{{ route('listings.index') }}" class="text-[#6d7890]">Listing</a><span>/</span>
    <span class="text-brand-navy">{{ $area->name }}</span>
    @if ($propertyType)<span>/</span><span class="text-brand-navy">{{ $propertyType->name }}</span>@endif
</div>

<section class="max-w-[1280px] mx-auto px-8 mt-4">
    <h1 class="text-brand-navy text-[26px] min-[900px]:text-[28px] font-black mb-2">{{ $heading }}</h1>
    <p class="text-[#5e6a84] text-[13.5px] font-semibold mb-6 max-w-2xl">
        {{ $listings->total() }} properti aktif ditemukan di {{ $area->name }}, {{ $area->city }}.
        Semua listing sudah diverifikasi tim MaxinPro dan didampingi agen profesional.
    </p>

    <div class="flex items-center gap-2 flex-wrap mb-7">
        <a href="{{ route('area-landing.show', $area) }}"
           class="h-9 px-4 rounded-full border text-[12px] font-extrabold inline-flex items-center {{ !$propertyType ? 'bg-brand-blue text-white border-brand-blue' : 'border-brand-line text-brand-navy' }}">
            Semua Tipe
        </a>
        @foreach ($propertyTypes as $type)
            <a href="{{ route('area-landing.show-type', [$area, $type]) }}"
               class="h-9 px-4 rounded-full border text-[12px] font-extrabold inline-flex items-center {{ $propertyType?->id === $type->id ? 'bg-brand-blue text-white border-brand-blue' : 'border-brand-line text-brand-navy' }}">
                {{ $type->name }}
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 min-[700px]:grid-cols-2 min-[1000px]:grid-cols-3 gap-5">
        @forelse ($listings as $listing)
            <x-listing-card :listing="$listing" :saved="in_array($listing->id, $savedIds)" />
        @empty
            <p class="text-brand-muted text-sm col-span-full">
                Belum ada listing {{ $propertyType?->name }} di {{ $area->name }} saat ini.
                <a href="{{ route('titip-properti.create') }}">Titipkan properti Anda di sini →</a>
            </p>
        @endforelse
    </div>

    <div class="mt-8">{{ $listings->links() }}</div>
</section>
<div class="h-16"></div>
@endsection
