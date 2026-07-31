@extends('layouts.app')

@section('title', 'Proyek Baru dari Developer Terpercaya — MaxinPro')
@section('meta_description', 'Daftar proyek baru dari developer terpercaya di Tangerang, Jakarta, dan sekitarnya. Lihat harga perdana, sisa unit, dan status launching terbaru.')
@section('canonical', request('page', 1) > 1
    ? route('projects.index') . '?page=' . (int) request('page')
    : route('projects.index'))
@section('robots', request('page', 1) > 1 ? 'noindex, follow' : 'index, follow, max-image-preview:large')

@section('content')
<section class="max-w-[1280px] mx-auto px-8 pt-11">
    <h1 class="text-brand-navy text-[28px] min-[900px]:text-[30px] font-black mb-2.5">Proyek Baru</h1>
    <p class="text-[#5e6a84] text-[14.5px] font-semibold max-w-2xl leading-relaxed">
        Rekomendasi terbaik untuk Anda. Dapatkan informasi proyek terkini mengenai rumah minimalis, ruko strategis, hingga apartment modern dari developer terpercaya di Tangerang, Jakarta, dan sekitarnya.
    </p>
</section>

<section class="max-w-[1280px] mx-auto px-8 mt-6 flex items-center gap-2.5 flex-wrap">
    @foreach (['' => 'Semua', 'Launching' => 'Launching', 'Premium' => 'Premium', 'New Cluster' => 'New Cluster', 'Sold Out' => 'Sold Out'] as $value => $label)
        <a href="{{ route('projects.index', $value ? ['status' => $value] : []) }}"
           class="h-[38px] px-[18px] rounded-full border inline-flex items-center text-[12.5px] font-extrabold
           {{ request('status', '') === $value ? 'bg-brand-blue text-white border-brand-blue' : 'border-brand-line text-brand-navy' }}">
            {{ $label }}
        </a>
    @endforeach
</section>

<section class="max-w-[1280px] mx-auto px-8 mt-6 pb-14">
    <div class="grid grid-cols-1 min-[700px]:grid-cols-2 min-[1000px]:grid-cols-3 gap-5">
        @forelse ($projects as $project)
            <x-project-card :project="$project" />
        @empty
            <p class="text-brand-muted text-sm col-span-full">Belum ada project pada status ini.</p>
        @endforelse
    </div>
    <div class="mt-8">{{ $projects->links() }}</div>
</section>

<section class="max-w-[1280px] mx-auto px-8 mb-16">
    <div class="rounded-2xl bg-gradient-to-r from-[#003ac0] to-[#001a68] text-white p-9 flex items-center justify-between gap-6 flex-wrap">
        <div>
            <h2 class="text-[21px] font-black mb-2">Punya project baru untuk dipasarkan?</h2>
            <p class="text-[13px] font-semibold opacity-90">Jadi developer partner MaxinPro dan jangkau ribuan calon pembeli aktif.</p>
        </div>
        <a href="https://wa.me/{{ setting('whatsapp_number', '6281112345678') }}" target="_blank" rel="noopener" class="h-12 px-6 rounded-[10px] bg-white text-brand-navy font-extrabold inline-flex items-center">Hubungi Tim Kami</a>
    </div>
</section>
@endsection
