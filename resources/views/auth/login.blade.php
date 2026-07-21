<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — MaxinPro</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-brand-soft min-h-screen flex items-center justify-center px-6">
    <div class="w-full max-w-sm">
        <div class="text-center mb-6">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo-cropped.png') }}" alt="MaxinPro" class="h-10 mx-auto">
            </a>
        </div>

        <div class="bg-white border border-brand-line rounded-2xl p-7 shadow-card">
            <h1 class="text-brand-navy text-[18px] font-black mb-5">Masuk ke Panel MaxinPro</h1>

            @if (session('status'))
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-[12.5px] font-bold px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1.5 text-brand-navy text-[12.5px] font-extrabold">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full h-[46px] border border-brand-line rounded-[9px] px-3.5 text-[13.5px]">
                    @error('email') <p class="text-red-600 text-[11.5px] font-bold mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-5">
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-brand-navy text-[12.5px] font-extrabold">Kata Sandi</label>
                        <a href="{{ route('password.request') }}" class="text-[11.5px] font-bold">Lupa kata sandi?</a>
                    </div>
                    <input type="password" name="password" required
                           class="w-full h-[46px] border border-brand-line rounded-[9px] px-3.5 text-[13.5px]">
                </div>
                <label class="flex items-center gap-2 mb-5 text-[12.5px] font-bold text-brand-navy">
                    <input type="checkbox" name="remember" value="1" class="w-4 h-4">
                    Ingat saya di perangkat ini
                </label>
                <button type="submit" class="w-full h-[46px] rounded-[10px] bg-gradient-to-r from-[#0069ff] to-[#004de7] text-white font-extrabold text-[14px]">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center mt-5 text-[12px] font-semibold text-brand-muted">
            <a href="{{ route('home') }}">&larr; Kembali ke website</a>
        </p>
    </div>
</body>
</html>
