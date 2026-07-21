<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email — MaxinPro</title>
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
        <div class="bg-white border border-brand-line rounded-2xl p-7 shadow-card text-center">
            <h1 class="text-brand-navy text-[18px] font-black mb-2">Verifikasi Email Anda</h1>
            <p class="text-brand-muted text-[12.5px] font-semibold mb-5">
                Kami sudah mengirimkan tautan verifikasi ke email Anda. Klik tautan tersebut untuk mengaktifkan fitur simpan properti favorit.
            </p>

            @if (session('status'))
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-[12.5px] font-bold px-4 py-3">{{ session('status') }}</div>
            @endif

            <form action="{{ route('verification.send') }}" method="POST" class="mb-3">
                @csrf
                <button type="submit" class="w-full h-[46px] rounded-[10px] bg-gradient-to-r from-[#0069ff] to-[#004de7] text-white font-extrabold text-[14px]">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-[12.5px] font-bold text-brand-muted">Keluar</button>
            </form>
        </div>
    </div>
</body>
</html>
