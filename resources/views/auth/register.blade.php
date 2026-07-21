<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — MaxinPro</title>
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
            <h1 class="text-brand-navy text-[18px] font-black mb-1">Buat Akun MaxinPro</h1>
            <p class="text-brand-muted text-[12px] font-semibold mb-5">Simpan properti favorit dan pantau status pengajuan Anda.</p>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full h-[46px] border border-brand-line rounded-[9px] px-3.5 text-[13.5px]">
                    @error('name') <p class="text-red-600 text-[11.5px] font-bold mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full h-[46px] border border-brand-line rounded-[9px] px-3.5 text-[13.5px]">
                    @error('email') <p class="text-red-600 text-[11.5px] font-bold mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Kata Sandi</label>
                    <input type="password" name="password" required minlength="8" class="w-full h-[46px] border border-brand-line rounded-[9px] px-3.5 text-[13.5px]">
                    @error('password') <p class="text-red-600 text-[11.5px] font-bold mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-5">
                    <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Ulangi Kata Sandi</label>
                    <input type="password" name="password_confirmation" required minlength="8" class="w-full h-[46px] border border-brand-line rounded-[9px] px-3.5 text-[13.5px]">
                </div>
                <button type="submit" class="w-full h-[46px] rounded-[10px] bg-gradient-to-r from-[#0069ff] to-[#004de7] text-white font-extrabold text-[14px]">Daftar</button>
            </form>
        </div>
        <p class="text-center mt-5 text-[12px] font-semibold text-brand-muted">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
        </p>
    </div>
</body>
</html>
