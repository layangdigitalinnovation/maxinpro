<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Dua Langkah — MaxinPro</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-brand-soft min-h-screen flex items-center justify-center px-6">
    <div class="w-full max-w-sm">
        <div class="text-center mb-6">
            <a href="{{ route('home') }}"><img src="{{ asset('images/logo-cropped.png') }}" alt="MaxinPro" class="h-10 mx-auto"></a>
        </div>
        <div class="bg-white border border-brand-line rounded-2xl p-7 shadow-card">
            <h1 class="text-brand-navy text-[18px] font-black mb-2">Verifikasi Dua Langkah</h1>
            <p class="text-brand-muted text-[12.5px] font-semibold mb-5">
                Masukkan kode 6 digit dari aplikasi authenticator Anda, atau salah satu kode pemulihan jika HP tidak tersedia.
            </p>

            <form action="{{ route('two-factor.challenge.store') }}" method="POST">
                @csrf
                <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Kode Verifikasi</label>
                <input type="text" name="code" inputmode="numeric" autofocus autocomplete="one-time-code"
                       placeholder="123456 atau XXXX-XXXX"
                       class="w-full h-[48px] border border-brand-line rounded-[9px] px-3.5 text-[16px] tracking-widest text-center mb-2">
                @error('code') <p class="text-red-600 text-[11.5px] font-bold mb-3">{{ $message }}</p> @enderror
                <button type="submit" class="w-full h-[46px] rounded-[10px] bg-gradient-to-r from-[#0069ff] to-[#004de7] text-white font-extrabold text-[14px] mt-2">
                    Verifikasi & Masuk
                </button>
            </form>
        </div>
        <p class="text-center mt-5 text-[12px] font-semibold text-brand-muted"><a href="{{ route('login') }}">&larr; Kembali ke login</a></p>
        <p class="text-center mt-2 text-[11.5px] font-semibold text-brand-muted">
            <a href="{{ route('two-factor.emergency-reset.create') }}">Kehilangan akses ke authenticator & kode pemulihan?</a>
        </p>
    </div>
</body>
</html>
