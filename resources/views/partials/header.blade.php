@php
    $navLinks = [
        ['label' => 'Beranda', 'route' => 'home'],
        ['label' => 'Listing', 'route' => 'listings.index'],
        ['label' => 'Titip Properti', 'route' => 'titip-properti.create'],
        ['label' => '(Project)', 'route' => 'projects.index'],
        ['label' => 'KPR', 'route' => 'kpr.index'],
        ['label' => 'About', 'route' => 'about.index'],
    ];
@endphp
<header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-brand-line">
    <div class="max-w-[1280px] mx-auto px-8 h-[76px] flex items-center justify-between gap-6 relative">
        <div class="flex-1 flex items-center">
            <a href="{{ route('home') }}" class="flex items-center shrink-0">
                <img src="{{ asset('images/logo-cropped.png') }}" alt="MaxinPro" class="h-[46px] w-auto mix-blend-multiply">
            </a>
        </div>

        <nav class="hidden min-[900px]:flex items-center justify-center gap-8">
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="text-[13px] font-extrabold pb-1.5 border-b-2 transition-colors {{ request()->routeIs($link['route']) ? 'text-brand-blue border-brand-blue' : 'text-brand-navy border-transparent hover:text-brand-blue' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="flex-1 flex items-center justify-end gap-3">
            <a href="https://wa.me/6281112345678" target="_blank" rel="noopener"
               class="hidden min-[900px]:inline-flex items-center gap-2 h-11 px-5 rounded-[10px] bg-brand-blue text-white text-[13px] font-extrabold shadow-[0_14px_26px_rgba(0,87,255,.24)]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Hubungi Kami
            </a>

            @auth
                <div class="hidden min-[900px]:flex items-center gap-3 text-[13px] font-bold text-brand-navy">
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}">Panel Admin</a>
                    @elseif (auth()->user()->isAgent())
                        <a href="{{ route('agent.dashboard') }}">Panel Agen</a>
                    @else
                        <a href="{{ route('account.saved-listings.index') }}">Favorit Saya</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-brand-muted hover:text-brand-navy">Keluar</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="hidden min-[900px]:inline-flex text-[13px] font-bold text-brand-navy">Masuk</a>
            @endauth

            <button id="mobile-nav-toggle" type="button" aria-label="Menu" class="min-[900px]:hidden w-10 h-10 grid place-items-center rounded-lg border border-brand-line">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    <div id="mobile-nav-panel" class="hidden min-[900px]:hidden border-t border-brand-line bg-white px-8 py-4">
        <div class="flex flex-col gap-3">
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}" class="text-[14px] font-bold {{ request()->routeIs($link['route']) ? 'text-brand-blue' : 'text-brand-navy' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
            <a href="https://wa.me/6281112345678" target="_blank" rel="noopener" class="mt-2 inline-flex items-center justify-center h-11 rounded-[10px] bg-gradient-to-r from-[#0069ff] to-[#004de7] text-white text-[13px] font-extrabold">
                Hubungi Kami
            </a>
        </div>
    </div>
</header>
