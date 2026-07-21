@extends('backend.layout')
@section('title', 'Ganti Kata Sandi — MaxinPro')

@section('content')
<h1 class="text-brand-navy text-[20px] font-black mb-6">Ganti Kata Sandi</h1>

<form action="{{ route('account.password.update') }}" method="POST" class="bg-white border border-brand-line rounded-2xl p-6 max-w-md">
    @csrf
    @method('PUT')

    <div class="grid gap-4">
        <div>
            <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Kata Sandi Saat Ini *</label>
            <input type="password" name="current_password" required class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px]">
            @error('current_password') <p class="text-red-600 text-[11.5px] font-bold mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Kata Sandi Baru *</label>
            <input type="password" name="password" required minlength="8" class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px]">
            @error('password') <p class="text-red-600 text-[11.5px] font-bold mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Ulangi Kata Sandi Baru *</label>
            <input type="password" name="password_confirmation" required minlength="8" class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px]">
        </div>
    </div>

    <button type="submit" class="mt-6 h-11 px-6 rounded-lg bg-brand-blue text-white font-extrabold text-[13.5px]">Simpan Kata Sandi</button>
</form>
@endsection
