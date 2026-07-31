<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ---------- Core SEO ---------- --}}
    @php
        $seoTitle = trim($__env->yieldContent('title', 'MaxinPro — Temukan Properti Impianmu di Jabodetabek'));
        $seoDescription = trim($__env->yieldContent('meta_description', 'MaxinPro adalah platform properti terpercaya untuk jual, beli, titip properti, project baru, dan simulasi KPR di kawasan Jabodetabek.'));
        // Canonical defaults to the current path WITHOUT query strings, so filtered
        // and paginated variants don't compete with each other as duplicate content.
        $seoCanonical = trim($__env->yieldContent('canonical', url()->current()));
        $seoImage = trim($__env->yieldContent('og_image', asset('images/og-default.jpg')));
        $seoType = trim($__env->yieldContent('og_type', 'website'));
    @endphp

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <link rel="canonical" href="{{ $seoCanonical }}">
    <meta name="robots" content="@yield('robots', 'index, follow, max-image-preview:large, max-snippet:-1')">

    {{-- ---------- Open Graph (Facebook, WhatsApp, LinkedIn) ---------- --}}
    <meta property="og:site_name" content="MaxinPro">
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="{{ $seoType }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    {{-- ---------- Twitter / X ---------- --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    {{-- ---------- Structured data: Organization (site-wide) ---------- --}}
    <script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'RealEstateAgent',
    'name' => 'MaxinPro',
    'url' => url('/'),
    'logo' => asset('images/logo-cropped.png'),
    'image' => asset('images/logo-cropped.png'),
    'description' => 'Platform properti untuk jual, beli, titip properti, project baru, dan simulasi KPR di kawasan Jabodetabek.',
    'telephone' => '+62-811-1234-5678',
    'email' => 'halo@maxinpro.com',
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Tangerang Selatan',
        'addressRegion' => 'Banten',
        'addressCountry' => 'ID',
    ],
    'areaServed' => [
        'Jakarta',
        'Tangerang',
        'Tangerang Selatan',
        'Bekasi',
        'Depok',
        'Bogor'
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

    {{-- Page-specific structured data (breadcrumbs, listings, articles) --}}
    @stack('schema')

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body {
            overflow-x: hidden !important;
            max-width: 100vw;
        }
    </style>
</head>
<body class="font-sans">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[100] focus:bg-white focus:px-4 focus:py-2 focus:rounded-lg focus:font-bold">
        Lompat ke konten utama
    </a>

    @include('partials.header')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
