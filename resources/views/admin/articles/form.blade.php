@extends('backend.layout')
@section('title', ($article->exists ? 'Edit' : 'Tambah') . ' Artikel — MaxinPro')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">{{ $article->exists ? 'Edit Artikel' : 'Tambah Artikel Baru' }}</h1>
    <a href="{{ route('admin.articles.index') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
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

<form action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-brand-line rounded-2xl p-6 space-y-6">
    @csrf
    @if($article->exists)
        @method('PUT')
    @endif

    <div class="grid grid-cols-2 gap-6">
        <div class="col-span-2">
            <label class="block text-sm font-bold text-brand-navy mb-2">Judul Artikel</label>
            <input type="text" name="title" value="{{ old('title', $article->title) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Kategori (Opsional)</label>
            <input type="text" name="category" value="{{ old('category', $article->category) }}" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Cover Image</label>
            <input type="file" name="cover_image" accept="image/*" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
            <div class="text-xs text-gray-500 mt-1">Maksimal 2MB. Kosongkan jika tidak ingin mengubah (saat edit).</div>
            @if($article->cover_image)
                <img src="{{ Storage::url($article->cover_image) }}" alt="Cover" class="mt-2 h-20 object-cover rounded">
            @endif
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-bold text-brand-navy mb-2">Kutipan / Ringkasan (Opsional)</label>
            <textarea name="excerpt" rows="2" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">{{ old('excerpt', $article->excerpt) }}</textarea>
            <div class="text-xs text-gray-500 mt-1">Jika dikosongkan, ringkasan akan diambil otomatis dari konten (body).</div>
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-bold text-brand-navy mb-2">Isi Artikel (Body)</label>
            <textarea name="body" rows="12" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>{{ old('body', $article->body) }}</textarea>
        </div>
    </div>

    <div class="flex justify-end border-t border-brand-line pt-6">
        <button type="submit" class="h-11 px-6 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            Simpan Artikel
        </button>
    </div>
</form>
@endsection
