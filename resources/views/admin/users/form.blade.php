@extends('backend.layout')
@section('title', ($user->exists ? 'Edit' : 'Tambah') . ' Pengguna — MaxinPro')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black">{{ $user->exists ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h1>
    <a href="{{ route('admin.users.index') }}" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
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

<form action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST" class="space-y-6">
    @csrf
    @if($user->exists)
        @method('PUT')
    @endif

    <div class="bg-white border border-brand-line rounded-2xl overflow-hidden max-w-3xl">
        <div class="p-6 md:p-8 border-b border-brand-line">
            <h2 class="text-brand-navy font-black text-[18px] flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Informasi Pengguna
            </h2>
            <p class="text-sm text-gray-500 mt-1">Lengkapi data profil dan peran akses pengguna di bawah ini.</p>
        </div>

        <div class="p-6 md:p-8 space-y-6">
            <div>
                <label class="block text-sm font-bold text-brand-navy mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-brand-line rounded-lg px-4 py-2.5 focus:ring-brand-blue focus:border-brand-blue bg-gray-50/50 transition-colors" required placeholder="Contoh: Budi Santoso">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-brand-navy mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-brand-line rounded-lg px-4 py-2.5 focus:ring-brand-blue focus:border-brand-blue bg-gray-50/50 transition-colors" required placeholder="budi@example.com">
                </div>

                <div>
                    <label class="block text-sm font-bold text-brand-navy mb-2">Peran (Role)</label>
                    <select name="role" class="w-full border border-brand-line rounded-lg px-4 py-2.5 focus:ring-brand-blue focus:border-brand-blue bg-gray-50/50 transition-colors" required>
                        <option value="" disabled {{ !old('role') && !$user->exists ? 'selected' : '' }}>Pilih Peran...</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->name }}" {{ old('role', $user->roles->first()?->name ?? '') == $r->name ? 'selected' : '' }}>
                                {{ ucfirst($r->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-2">
                <label class="block text-sm font-bold text-brand-navy mb-2">Kata Sandi</label>
                <div class="relative">
                    <input type="password" name="password" class="w-full border border-brand-line rounded-lg pl-4 pr-10 py-2.5 focus:ring-brand-blue focus:border-brand-blue bg-gray-50/50 transition-colors" {{ $user->exists ? '' : 'required' }} placeholder="••••••••">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                </div>
                <p class="text-[12px] text-gray-500 mt-2">
                    @if($user->exists)
                        Biarkan kosong jika tidak ingin mengubah kata sandi saat ini.
                    @else
                        Gunakan minimal 8 karakter dengan kombinasi huruf dan angka untuk keamanan.
                    @endif
                </p>
            </div>
        </div>
        
        <div class="px-6 md:px-8 py-5 border-t border-brand-line bg-gray-50 flex justify-end">
            <button type="submit" class="h-11 px-8 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700 transition-colors shadow-sm">
                {{ $user->exists ? 'Simpan Perubahan' : 'Buat Pengguna Baru' }}
            </button>
        </div>
    </div>
</form>
@endsection
