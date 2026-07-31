@extends('backend.layout')
@section('title', ($role->exists ? 'Edit' : 'Tambah') . ' Peran (Role) — MaxinPro')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">{{ $role->exists ? 'Edit Peran' : 'Tambah Peran Baru' }}</h1>
    <a href="{{ route('admin.roles.index') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
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

<form action="{{ $role->exists ? route('admin.roles.update', $role) : route('admin.roles.store') }}" method="POST">
    @csrf
    @if($role->exists)
        @method('PUT')
    @endif

    <div class="bg-white border border-brand-line rounded-2xl overflow-hidden max-w-3xl">
        <div class="p-6 md:p-8 border-b border-brand-line">
            <h2 class="text-brand-navy font-black text-[18px] flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Informasi Peran (Role)
            </h2>
            <p class="text-sm text-gray-500 mt-1">Tentukan nama peran dan hak akses (permissions) yang dimiliki.</p>
        </div>

        <div class="p-6 md:p-8 space-y-6">
            <div>
                <label class="block text-sm font-bold text-brand-navy mb-2">Nama Peran</label>
                <input type="text" name="name" value="{{ old('name', $role->name) }}" class="w-full border border-brand-line rounded-lg px-4 py-2.5 focus:ring-brand-blue focus:border-brand-blue bg-gray-50/50 transition-colors" required {{ $role->name === 'admin' ? 'readonly' : '' }} placeholder="Contoh: manager, supervisor">
                @if($role->name === 'admin')
                    <p class="text-[11px] text-gray-500 mt-1">Nama peran admin tidak dapat diubah karena merupakan peran sistem utama.</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-bold text-brand-navy mb-3">Hak Akses (Permissions)</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 bg-gray-50/50 p-4 rounded-xl border border-brand-line">
                    @forelse($permissions as $permission)
                        <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-white rounded border border-transparent hover:border-gray-200 transition-colors">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                {{ (is_array(old('permissions')) && in_array($permission->name, old('permissions'))) || ($role->exists && $role->hasPermissionTo($permission->name)) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue w-4 h-4">
                            <span class="text-sm font-medium text-gray-700 select-none">{{ $permission->name }}</span>
                        </label>
                    @empty
                        <p class="text-sm text-gray-500 col-span-3">Belum ada permission di database.</p>
                    @endforelse
                </div>
            </div>
        </div>
        
        <div class="px-6 md:px-8 py-5 border-t border-brand-line bg-gray-50 flex justify-end">
            <button type="submit" class="h-11 px-8 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700 transition-colors shadow-sm">
                {{ $role->exists ? 'Simpan Perubahan' : 'Buat Peran Baru' }}
            </button>
        </div>
    </div>
</form>
@endsection
