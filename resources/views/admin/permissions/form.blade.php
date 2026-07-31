@extends('backend.layout')
@section('title', ($permission->exists ? 'Edit' : 'Tambah') . ' Permission — MaxinPro')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">{{ $permission->exists ? 'Edit Permission' : 'Tambah Permission Baru' }}</h1>
    <a href="{{ route('admin.permissions.index') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
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

<form action="{{ $permission->exists ? route('admin.permissions.update', $permission) : route('admin.permissions.store') }}" method="POST">
    @csrf
    @if($permission->exists)
        @method('PUT')
    @endif

    <div class="bg-white border border-brand-line rounded-2xl overflow-hidden max-w-xl">
        <div class="p-6 md:p-8 border-b border-brand-line">
            <h2 class="text-brand-navy font-black text-[18px] flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                Informasi Permission
            </h2>
            <p class="text-sm text-gray-500 mt-1">Permission digunakan untuk membatasi aksi tertentu (contoh: view_users, edit_projects).</p>
        </div>

        <div class="p-6 md:p-8">
            <div>
                <label class="block text-sm font-bold text-brand-navy mb-2">Nama Permission</label>
                <input type="text" name="name" value="{{ old('name', $permission->name) }}" class="w-full border border-brand-line rounded-lg px-4 py-2.5 focus:ring-brand-blue focus:border-brand-blue bg-gray-50/50 transition-colors" required placeholder="Contoh: create_post">
            </div>
        </div>
        
        <div class="px-6 md:px-8 py-5 border-t border-brand-line bg-gray-50 flex justify-end">
            <button type="submit" class="h-11 px-8 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700 transition-colors shadow-sm">
                {{ $permission->exists ? 'Simpan Perubahan' : 'Buat Permission Baru' }}
            </button>
        </div>
    </div>
</form>
@endsection
