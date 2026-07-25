@extends('layouts.app')

@section('title', request('page', 1) > 1
    ? 'Listing Properti Dijual — Halaman ' . request('page') . ' | MaxinPro'
    : 'Listing Properti Dijual di Jabodetabek — MaxinPro')
@section('meta_description', 'Jelajahi listing properti dijual di Jabodetabek. Filter berdasarkan tipe, harga, dan jumlah kamar untuk menemukan rumah impian Anda bersama agen MaxinPro.')
{{-- Canonical keeps the page number (so deep pages stay indexable) but drops
     filter/sort params, which would otherwise create near-duplicate URLs. --}}
@section('canonical', request('page', 1) > 1
    ? route('listings.index') . '?page=' . (int) request('page')
    : route('listings.index'))
@section('robots', request('page', 1) > 1 ? 'noindex, follow' : 'index, follow, max-image-preview:large')

@section('content')
<section class="bg-brand-soft border-b border-brand-line py-6">
    <div class="max-w-[1280px] mx-auto px-8">
        <form action="{{ route('listings.index') }}" method="GET" class="grid grid-cols-1 min-[900px]:grid-cols-[2fr_1fr_1fr_auto] gap-3">
            @if(request('price_range')) <input type="hidden" name="price_range" value="{{ request('price_range') }}"> @endif
            @if(request('luas_tanah')) <input type="hidden" name="luas_tanah" value="{{ request('luas_tanah') }}"> @endif
            @if(request('type'))
                @foreach((array)request('type') as $t)
                    <input type="hidden" name="type[]" value="{{ $t }}">
                @endforeach
            @endif
            <label class="h-12 border border-brand-line rounded-[10px] bg-white flex items-center gap-3 px-4">
                <span>🔍</span>
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari lokasi, nama properti, atau keyword" class="w-full border-0 outline-none text-[14px] font-semibold">
            </label>
            <select name="sort" class="h-12 border border-brand-line rounded-[10px] px-4 text-[13px] font-bold text-brand-navy bg-white">
                <option value="terbaru" @selected(request('sort', 'terbaru') === 'terbaru')>Urutkan: Terbaru</option>
                <option value="harga_asc" @selected(request('sort') === 'harga_asc')>Harga Terendah</option>
                <option value="harga_desc" @selected(request('sort') === 'harga_desc')>Harga Tertinggi</option>
            </select>
            <select name="bedrooms" class="h-12 border border-brand-line rounded-[10px] px-4 text-[13px] font-bold text-brand-navy bg-white">
                <option value="">Kamar Tidur</option>
                @foreach ([1,2,3,4] as $n)
                    <option value="{{ $n }}" @selected((int) request('bedrooms') === $n)>{{ $n }}+ KT</option>
                @endforeach
            </select>
            <button type="submit" class="h-12 min-w-[120px] rounded-[10px] bg-gradient-to-r from-[#0069ff] to-[#004de7] text-white font-extrabold text-[13px]">Cari</button>
        </form>
    </div>
</section>

<div class="max-w-[1280px] mx-auto px-8 pt-6 flex items-center gap-1.5 text-[#6d7890] text-[12.5px] font-bold">
    <a href="{{ route('home') }}" class="text-[#6d7890]">Beranda</a><span>/</span><span class="text-brand-navy">Listing</span>
</div>

<div class="max-w-[1280px] mx-auto px-8 mt-4 grid grid-cols-1 min-[900px]:grid-cols-[240px_1fr] gap-8 items-start">
    <aside class="bg-white border border-brand-line rounded-2xl p-5 min-[900px]:sticky top-[92px] z-20">
        <strong class="block text-brand-navy text-[14px] font-black mb-4">Filter</strong>
        <form action="{{ route('listings.index') }}" method="GET">
            <input type="hidden" name="q" value="{{ request('q') }}">
            @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
            @if(request('bedrooms')) <input type="hidden" name="bedrooms" value="{{ request('bedrooms') }}"> @endif
            @if(request('price_range')) <input type="hidden" name="price_range" value="{{ request('price_range') }}"> @endif
            @if(request('luas_tanah')) <input type="hidden" name="luas_tanah" value="{{ request('luas_tanah') }}"> @endif
            <div class="mb-4">
                <strong class="block text-brand-navy text-[12.5px] font-extrabold mb-2.5">Tipe Properti</strong>
                @foreach ($propertyTypes as $type)
                    <label class="flex items-center gap-2 mb-2 text-[13px] font-semibold text-[#39445e]">
                        <input type="checkbox" name="type[]" value="{{ $type->id }}"
                               @checked(collect(request('type', []))->contains($type->id))>
                        {{ $type->name }}
                    </label>
                @endforeach
            </div>
            <button type="submit" class="w-full h-10 rounded-lg bg-brand-navy text-white text-[12.5px] font-extrabold">Terapkan Filter</button>
        </form>
    </aside>

    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-brand-navy text-[22px] font-black mb-0.5">Properti Dijual di Seluruh Indonesia</h1>
                <p class="text-[#5e6a84] text-[12.5px] font-semibold">Menampilkan {{ $listings->count() }} dari {{ $listings->total() }} properti</p>
            </div>
        </div>

        <div class="grid grid-cols-1 min-[700px]:grid-cols-2 min-[1000px]:grid-cols-3 gap-5">
            @forelse ($listings as $listing)
                <x-listing-card :listing="$listing" :saved="in_array($listing->id, $savedIds)" />
            @empty
                <p class="text-brand-muted text-sm col-span-full">Tidak ada properti yang cocok dengan pencarian Anda.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $listings->onEachSide(1)->links() }}
        </div>
    </div>
</div>
<div class="h-16"></div>
@endsection
