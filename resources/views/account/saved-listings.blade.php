@extends('layouts.app')
@section('title', 'Properti Favorit Saya — MaxinPro')

@section('content')
<div class="max-w-[1280px] mx-auto px-8 pt-10">
    <h1 class="text-brand-navy text-[24px] font-black mb-6">Properti Favorit Saya</h1>

    @if (session('success'))
        <div class="mb-5 rounded-lg bg-green-50 border border-green-200 text-green-800 text-[12.5px] font-bold px-4 py-3">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 min-[700px]:grid-cols-2 min-[1000px]:grid-cols-3 gap-5">
        @forelse ($listings as $listing)
            <x-listing-card :listing="$listing" :saved="true" />
        @empty
            <p class="text-brand-muted text-sm col-span-full">Anda belum menyimpan properti apa pun. <a href="{{ route('listings.index') }}">Jelajahi listing →</a></p>
        @endforelse
    </div>
    <div class="mt-8">{{ $listings->links() }}</div>
</div>
<div class="h-16"></div>
@endsection
