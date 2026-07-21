@extends('backend.layout')
@section('title', ($area->exists ? 'Edit' : 'Tambah') . ' Area — MaxinPro')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">{{ $area->exists ? 'Edit Area' : 'Tambah Area Baru' }}</h1>
    <a href="{{ route('admin.areas.index') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
        Kembali
    </a>
</div>

@if($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 text-sm font-bold">
        Terdapat beberapa kesalahan:
        <ul class="list-disc pl-5 mt-2 font-normal">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $area->exists ? route('admin.areas.update', $area) : route('admin.areas.store') }}" method="POST" class="bg-white border border-brand-line rounded-2xl p-6 space-y-6 max-w-2xl">
    @csrf
    @if($area->exists)
        @method('PUT')
    @endif

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Nama Area</label>
        <input type="text" name="name" value="{{ old('name', $area->name) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
    </div>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Kota</label>
        <input type="text" name="city" value="{{ old('city', $area->city) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
    </div>

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Jumlah Properti (Opsional)</label>
        <input type="number" name="property_count" value="{{ old('property_count', $area->property_count) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" min="0">
    </div>

    <div>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_popular" value="1" {{ old('is_popular', $area->is_popular) ? 'checked' : '' }} class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue">
            <span class="text-sm font-bold text-brand-navy">Tandai sebagai Area Populer</span>
        </label>
    </div>

    <div class="flex justify-end border-t border-brand-line pt-6">
        <button type="submit" class="h-11 px-6 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            Simpan Area
        </button>
    </div>
</form>
@endsection
