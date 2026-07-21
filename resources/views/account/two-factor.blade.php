@extends('backend.layout')
@section('title', 'Verifikasi Dua Langkah — MaxinPro')

@section('content')
<h1 class="text-brand-navy text-[20px] font-black mb-6">Verifikasi Dua Langkah (2FA)</h1>

@if (session('recovery_codes'))
    <div class="mb-6 rounded-2xl border-2 border-amber-300 bg-amber-50 p-6 max-w-lg">
        <h2 class="text-amber-900 text-[14px] font-black mb-2">⚠ Simpan Kode Pemulihan Ini Sekarang</h2>
        <p class="text-amber-800 text-[12.5px] font-semibold mb-4">
            Kode ini hanya ditampilkan SEKALI. Simpan di tempat aman (password manager, kertas tersegel) —
            gunakan salah satu jika HP Anda hilang dan tidak bisa membuka aplikasi authenticator. Setiap kode hanya bisa dipakai satu kali.
        </p>
        <div class="grid grid-cols-2 gap-2 font-mono text-[13px] font-bold text-amber-900">
            @foreach (session('recovery_codes') as $code)
                <div class="bg-white rounded-lg px-3 py-2 border border-amber-200">{{ $code }}</div>
            @endforeach
        </div>
    </div>
@endif

@if ($user->hasTwoFactorEnabled())
    <div class="bg-white border border-brand-line rounded-2xl p-6 max-w-lg">
        <div class="flex items-center gap-2 mb-4">
            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
            <strong class="text-brand-navy text-[14px] font-black">2FA Aktif</strong>
        </div>
        <p class="text-brand-muted text-[12.5px] font-semibold mb-5">
            Akun Anda dilindungi verifikasi dua langkah sejak {{ $user->two_factor_confirmed_at->translatedFormat('d M Y H:i') }}.
        </p>

        <form action="{{ route('account.two-factor.disable') }}" method="POST" class="mb-3"
              onsubmit="return confirm('Yakin ingin menonaktifkan 2FA? Akun akan kembali hanya dilindungi kata sandi.');">
            @csrf @method('DELETE')
            <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Kata Sandi Saat Ini (untuk konfirmasi)</label>
            <input type="password" name="current_password" required class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[13.5px] mb-2">
            @error('current_password') <p class="text-red-600 text-[11.5px] font-bold mb-2">{{ $message }}</p> @enderror
            <button type="submit" class="h-11 px-6 rounded-lg border border-red-300 text-red-700 font-extrabold text-[13px]">Nonaktifkan 2FA</button>
        </form>
    </div>
@else
    <div class="bg-white border border-brand-line rounded-2xl p-6 max-w-lg">
        <p class="text-brand-muted text-[12.5px] font-semibold mb-5">
            Scan QR code ini dengan aplikasi authenticator (Google Authenticator, Authy, atau Microsoft Authenticator — semua gratis),
            lalu masukkan kode 6 digit yang muncul untuk mengaktifkan.
        </p>

        <div class="flex justify-center mb-4">
            <img src="{{ $user->twoFactorQrCodeUrl() }}" alt="QR code untuk setup aplikasi authenticator" class="rounded-lg border border-brand-line">
        </div>

        <p class="text-center text-[11px] text-brand-muted mb-5">
            Tidak bisa scan? Masukkan kode ini manual: <br>
            <code class="font-mono font-bold text-brand-navy">{{ $user->two_factor_secret }}</code>
        </p>

        <form action="{{ route('account.two-factor.enable') }}" method="POST">
            @csrf
            <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Kode dari Aplikasi Authenticator</label>
            <input type="text" name="code" inputmode="numeric" placeholder="123456" required
                   class="w-full h-11 border border-brand-line rounded-lg px-3.5 text-[16px] tracking-widest text-center mb-2">
            @error('code') <p class="text-red-600 text-[11.5px] font-bold mb-2">{{ $message }}</p> @enderror
            <button type="submit" class="w-full h-11 rounded-lg bg-brand-blue text-white font-extrabold text-[13.5px]">Aktifkan 2FA</button>
        </form>

        <form action="{{ route('account.two-factor.regenerate') }}" method="POST" class="mt-3">
            @csrf
            <input type="password" name="current_password" placeholder="Kata sandi saat ini" required
                   class="w-full h-10 border border-brand-line rounded-lg px-3.5 text-[12.5px] mb-2">
            <button type="submit" class="text-[11.5px] font-bold text-brand-muted">Buat ulang QR code baru</button>
        </form>
    </div>
@endif
@endsection
