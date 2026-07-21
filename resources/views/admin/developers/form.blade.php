@extends('backend.layout')
@section('title', ($developer->exists ? 'Edit' : 'Tambah') . ' Developer — MaxinPro')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">{{ $developer->exists ? 'Edit Developer' : 'Tambah Developer' }}</h1>
    <a href="{{ route('admin.developers.index') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
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

<form action="{{ $developer->exists ? route('admin.developers.update', $developer) : route('admin.developers.store') }}" method="POST" class="bg-white border border-brand-line rounded-2xl p-6 space-y-6 max-w-2xl">
    @csrf
    @if($developer->exists)
        @method('PUT')
    @endif

    <div>
        <label class="block text-sm font-bold text-brand-navy mb-2">Nama Developer</label>
        <input type="text" name="name" value="{{ old('name', $developer->name) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
    </div>

    <div class="flex justify-end border-t border-brand-line pt-6">
        <button type="submit" class="h-11 px-6 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            Simpan Developer
        </button>
    </div>
</form>
@endsection
