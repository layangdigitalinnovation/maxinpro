@extends('backend.layout')
@section('title', ($agent->exists ? 'Edit' : 'Tambah') . ' Agen — MaxinPro')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">{{ $agent->exists ? 'Edit Agen' : 'Tambah Agen Baru' }}</h1>
    <a href="{{ route('admin.agents.index') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
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

<form action="{{ $agent->exists ? route('admin.agents.update', $agent) : route('admin.agents.store') }}" method="POST" class="bg-white border border-brand-line rounded-2xl p-6 space-y-6">
    @csrf
    @if($agent->exists)
        @method('PUT')
    @endif

    <div class="grid grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Nama Agen</label>
            <input type="text" name="name" value="{{ old('name', $agent->name) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Email Login</label>
            @if($agent->exists)
                <input type="email" value="{{ $agent->email }}" class="w-full border border-gray-200 bg-gray-100 rounded-lg px-4 py-2 text-gray-500" disabled readonly>
                <div class="text-xs text-gray-400 mt-1">Email login tidak dapat diubah setelah agen dibuat.</div>
            @else
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
            @endif
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">No. Handphone</label>
            <input type="text" name="phone" value="{{ old('phone', $agent->phone) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">No. WhatsApp</label>
            <input type="text" name="whatsapp" value="{{ old('whatsapp', $agent->whatsapp) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" placeholder="Contoh: 628123456789">
        </div>

        @if($agent->exists)
            <div class="col-span-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $agent->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue">
                    <span class="text-sm font-bold text-brand-navy">Agen Aktif (Bisa login & tampil di web)</span>
                </label>
            </div>
        @endif
    </div>

    <div class="flex justify-end border-t border-brand-line pt-6">
        <button type="submit" class="h-11 px-6 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            Simpan Data Agen
        </button>
    </div>
</form>
@endsection
