@extends('backend.layout')
@section('title', 'Dashboard Agen — MaxinPro')

@section('content')
<h1 class="text-brand-navy text-[22px] font-black mb-6">Halo, {{ $agent->name }} 👋</h1>

<div class="grid grid-cols-3 gap-4 mb-8">
    @foreach ([
        ['label' => 'Listing Aktif', 'value' => $stats['listings_active']],
        ['label' => 'Total Listing', 'value' => $stats['listings_total']],
        ['label' => 'Listing Terjual', 'value' => $stats['listings_sold']],
    ] as $s)
        <div class="bg-white border border-brand-line rounded-2xl p-5">
            <div class="text-brand-navy text-[24px] font-black">{{ number_format($s['value']) }}</div>
            <div class="text-brand-muted text-[12px] font-bold mt-1">{{ $s['label'] }}</div>
        </div>
    @endforeach
</div>

<a href="{{ route('agent.listings.create') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-brand-blue text-white text-[13px] font-extrabold">+ Tambah Listing Baru</a>
@endsection
