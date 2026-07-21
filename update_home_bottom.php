<?php
$file = 'D:\Layang\maxinpro.com\resources\views\home.blade.php';
$content = file_get_contents($file);

// Find the start of APP BANNER
$pos = strpos($content, '{{-- APP BANNER --}}');

if ($pos !== false) {
    $topPart = substr($content, 0, $pos);
    
    // Find where the scripts start so we can keep them
    $scriptsPos = strpos($content, '@push(\'scripts\')', $pos);
    $bottomPart = substr($content, $scriptsPos);
    
    $newHTML = <<<HTML
{{-- FITUR & LAYANAN KAMI --}}
<section class="max-w-[1280px] mx-auto px-8 mb-8 mt-12">
    <h2 class="text-brand-navy font-black text-[22px] min-[900px]:text-[24px] mb-6">Fitur & Layanan Kami</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Fitur 1 -->
        <div class="bg-white rounded-2xl border border-brand-line p-5 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <h3 class="text-[15px] font-extrabold text-brand-navy mb-1.5">Kalkulator KPR</h3>
            <p class="text-[12px] font-bold text-[#7a8399] leading-relaxed mb-4 max-w-[180px]">Hitung simulasi KPR dengan mudah</p>
            <a href="{{ route('kpr.index') }}" class="text-[12px] font-black text-brand-blue flex items-center gap-1 group-hover:underline">Coba Sekarang →</a>
            <div class="absolute right-3 bottom-3 w-16 h-16 opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all">
                <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="12" y="8" width="40" height="48" rx="6" fill="#1e293b"/>
                    <rect x="20" y="16" width="24" height="10" rx="2" fill="#94a3b8"/>
                    <circle cx="22" cy="34" r="3" fill="#f8fafc"/><circle cx="32" cy="34" r="3" fill="#f8fafc"/><circle cx="42" cy="34" r="3" fill="#f8fafc"/>
                    <circle cx="22" cy="42" r="3" fill="#f8fafc"/><circle cx="32" cy="42" r="3" fill="#f8fafc"/><circle cx="42" cy="42" r="3" fill="#f8fafc"/>
                    <circle cx="22" cy="50" r="3" fill="#f8fafc"/><circle cx="32" cy="50" r="3" fill="#f8fafc"/><circle cx="42" cy="50" r="3" fill="#3b82f6"/>
                </svg>
            </div>
        </div>
        <!-- Fitur 2 -->
        <div class="bg-white rounded-2xl border border-brand-line p-5 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <h3 class="text-[15px] font-extrabold text-brand-navy mb-1.5">Cek Harga Properti</h3>
            <p class="text-[12px] font-bold text-[#7a8399] leading-relaxed mb-4 max-w-[180px]">Lihat estimasi harga properti di area pilihanmu</p>
            <a href="#" class="text-[12px] font-black text-brand-blue flex items-center gap-1 group-hover:underline">Coba Sekarang →</a>
            <div class="absolute right-3 bottom-3 w-16 h-16 opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all">
                <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 52h40M16 48V32m10 16V20m10 28V28m10 20V12" stroke="#3b82f6" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16 32l10-12 10 8 10-16" stroke="#0ea5e9" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
        <!-- Fitur 3 -->
        <div class="bg-white rounded-2xl border border-brand-line p-5 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <h3 class="text-[15px] font-extrabold text-brand-navy mb-1.5">Jadwalkan Survey</h3>
            <p class="text-[12px] font-bold text-[#7a8399] leading-relaxed mb-4 max-w-[180px]">Booking jadwal survey lebih mudah online</p>
            <a href="#" class="text-[12px] font-black text-brand-blue flex items-center gap-1 group-hover:underline">Booking Sekarang →</a>
            <div class="absolute right-3 bottom-3 w-16 h-16 opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all">
                <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="14" y="16" width="36" height="36" rx="4" stroke="#94a3b8" stroke-width="4" stroke-linejoin="round"/>
                    <path d="M14 28h36M22 10v12M42 10v12" stroke="#94a3b8" stroke-width="4" stroke-linecap="round"/>
                    <circle cx="24" cy="40" r="4" fill="#3b82f6"/>
                </svg>
            </div>
        </div>
        <!-- Fitur 4 -->
        <div class="bg-white rounded-2xl border border-brand-line p-5 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <h3 class="text-[15px] font-extrabold text-brand-navy mb-1.5">AI Property Assistant</h3>
            <p class="text-[12px] font-bold text-[#7a8399] leading-relaxed mb-4 max-w-[180px]">Tanya apa saja tentang properti dengan AI</p>
            <a href="#" class="text-[12px] font-black text-brand-blue flex items-center gap-1 group-hover:underline">Chat Sekarang →</a>
            <div class="absolute right-2 bottom-2 w-16 h-16 opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all">
                <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="16" y="24" width="32" height="24" rx="8" fill="#f8fafc" stroke="#3b82f6" stroke-width="3"/>
                    <circle cx="32" cy="16" r="6" fill="#3b82f6"/>
                    <path d="M32 22v2" stroke="#3b82f6" stroke-width="3"/>
                    <circle cx="24" cy="32" r="3" fill="#1e293b"/><circle cx="40" cy="32" r="3" fill="#1e293b"/>
                    <path d="M26 40s2 3 6 3 6-3 6-3" stroke="#1e293b" stroke-width="2" stroke-linecap="round"/>
                    <path d="M16 32h-4M48 32h4" stroke="#3b82f6" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </div>
        </div>
    </div>
</section>

{{-- STATS BANNER --}}
<section class="max-w-[1280px] mx-auto px-8 mb-12">
    <div class="bg-gradient-to-r from-[#06143b] to-[#001347] rounded-3xl py-8 px-6 text-white grid grid-cols-2 md:grid-cols-4 gap-6 divide-x divide-white/20 shadow-xl border border-brand-line/10">
        <!-- Stat 1 -->
        <div class="flex flex-col items-center justify-center text-center px-4">
            <div class="flex items-center gap-3 mb-1">
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <div class="text-[26px] font-black leading-none">25.000+</div>
            </div>
            <div class="text-[13px] font-bold text-white/80">Properti Aktif</div>
        </div>
        <!-- Stat 2 -->
        <div class="flex flex-col items-center justify-center text-center px-4">
            <div class="flex items-center gap-3 mb-1">
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <div class="text-[26px] font-black leading-none">120+</div>
            </div>
            <div class="text-[13px] font-bold text-white/80">Agen Profesional</div>
        </div>
        <!-- Stat 3 -->
        <div class="flex flex-col items-center justify-center text-center px-4">
            <div class="flex items-center gap-3 mb-1">
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <div class="text-[26px] font-black leading-none">300+</div>
            </div>
            <div class="text-[13px] font-bold text-white/80">Project Baru</div>
        </div>
        <!-- Stat 4 -->
        <div class="flex flex-col items-center justify-center text-center px-4">
            <div class="flex items-center gap-3 mb-1">
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="text-[26px] font-black leading-none">12.000+</div>
            </div>
            <div class="text-[13px] font-bold text-white/80">Happy Customer</div>
        </div>
    </div>
</section>

{{-- ARTIKEL & INSIGHT --}}
<section class="max-w-[1280px] mx-auto px-8 mb-16 relative">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-brand-navy font-black text-[22px] min-[900px]:text-[24px]">Artikel & Insight</h2>
        <a href="{{ route('articles.index') }}" class="text-[13px] font-extrabold text-brand-blue flex items-center gap-1 hover:underline">Lihat Semua →</a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Artikel 1 -->
        <a href="#" class="bg-white border border-brand-line rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all group">
            <div class="aspect-[1.6/1] relative bg-brand-soft overflow-hidden">
                <img src="{{ asset('images/hero-skyline.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute left-3 top-3 h-6 px-3 bg-white/90 backdrop-blur rounded-full flex items-center text-[10px] font-black text-brand-blue uppercase shadow-sm">TIPS</div>
            </div>
            <div class="p-4">
                <h3 class="text-[15px] font-black text-brand-navy leading-snug mb-2 group-hover:text-brand-blue transition-colors">5 Tips Membeli Rumah Pertama untuk Keluarga</h3>
                <div class="text-[12px] font-bold text-[#7a8399]">17 Mei 2024</div>
            </div>
        </a>
        <!-- Artikel 2 -->
        <a href="#" class="bg-white border border-brand-line rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all group">
            <div class="aspect-[1.6/1] relative bg-brand-soft overflow-hidden">
                <img src="{{ asset('images/hero-skyline.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute left-3 top-3 h-6 px-3 bg-white/90 backdrop-blur rounded-full flex items-center text-[10px] font-black text-brand-blue uppercase shadow-sm">INVESTASI</div>
            </div>
            <div class="p-4">
                <h3 class="text-[15px] font-black text-brand-navy leading-snug mb-2 group-hover:text-brand-blue transition-colors">Investasi Properti di 2024 Masih Menguntungkan?</h3>
                <div class="text-[12px] font-bold text-[#7a8399]">15 Mei 2024</div>
            </div>
        </a>
        <!-- Artikel 3 -->
        <a href="#" class="bg-white border border-brand-line rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all group">
            <div class="aspect-[1.6/1] relative bg-brand-soft overflow-hidden">
                <img src="{{ asset('images/hero-skyline.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute left-3 top-3 h-6 px-3 bg-white/90 backdrop-blur rounded-full flex items-center text-[10px] font-black text-brand-blue uppercase shadow-sm">KPR</div>
            </div>
            <div class="p-4">
                <h3 class="text-[15px] font-black text-brand-navy leading-snug mb-2 group-hover:text-brand-blue transition-colors">Cara Mengajukan KPR yang Disetujui Bank</h3>
                <div class="text-[12px] font-bold text-[#7a8399]">12 Mei 2024</div>
            </div>
        </a>
        <!-- Artikel 4 -->
        <a href="#" class="bg-white border border-brand-line rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all group">
            <div class="aspect-[1.6/1] relative bg-brand-soft overflow-hidden">
                <img src="{{ asset('images/hero-skyline.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute left-3 top-3 h-6 px-3 bg-white/90 backdrop-blur rounded-full flex items-center text-[10px] font-black text-brand-blue uppercase shadow-sm">MARKET UPDATE</div>
            </div>
            <div class="p-4">
                <h3 class="text-[15px] font-black text-brand-navy leading-snug mb-2 group-hover:text-brand-blue transition-colors">Tren Harga Properti di Jabodetabek</h3>
                <div class="text-[12px] font-bold text-[#7a8399]">10 Mei 2024</div>
            </div>
        </a>
    </div>
</section>

{{-- TESTIMONI PELANGGAN --}}
<section class="max-w-[1280px] mx-auto px-8 mb-20 relative">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-brand-navy font-black text-[22px] min-[900px]:text-[24px]">Testimoni Pelanggan</h2>
        <a href="#" class="text-[13px] font-extrabold text-brand-blue flex items-center gap-1 hover:underline">Lihat Semua →</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Testi 1 -->
        <div class="bg-[#f8fafc] rounded-3xl p-6 relative overflow-hidden group hover:shadow-md transition-shadow border border-brand-line/50">
            <div class="absolute right-4 top-4 text-brand-line/40 font-serif text-8xl leading-none italic pointer-events-none group-hover:text-brand-blue/10 transition-colors">"</div>
            <div class="flex items-center gap-4 mb-4 relative z-10">
                <div class="w-14 h-14 rounded-full bg-brand-navy overflow-hidden shrink-0 border-2 border-white shadow-sm">
                    <img src="https://i.pravatar.cc/150?img=1" alt="Dewi Lestari" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="text-[15px] font-black text-brand-navy">Dewi Lestari</h4>
                    <p class="text-[11.5px] font-bold text-[#7a8399] mb-1">BSD City</p>
                    <div class="flex text-[#f59e0b] text-[12px]">★★★★★</div>
                </div>
            </div>
            <p class="text-[13px] font-bold text-[#55617a] leading-relaxed relative z-10">Proses cari rumah jadi lebih mudah dan cepat. Agen MaxinPro sangat membantu dan profesional!</p>
        </div>
        <!-- Testi 2 -->
        <div class="bg-[#f8fafc] rounded-3xl p-6 relative overflow-hidden group hover:shadow-md transition-shadow border border-brand-line/50">
            <div class="absolute right-4 top-4 text-brand-line/40 font-serif text-8xl leading-none italic pointer-events-none group-hover:text-brand-blue/10 transition-colors">"</div>
            <div class="flex items-center gap-4 mb-4 relative z-10">
                <div class="w-14 h-14 rounded-full bg-brand-navy overflow-hidden shrink-0 border-2 border-white shadow-sm">
                    <img src="https://i.pravatar.cc/150?img=11" alt="Andi Pratama" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="text-[15px] font-black text-brand-navy">Andi Pratama</h4>
                    <p class="text-[11.5px] font-bold text-[#7a8399] mb-1">Bintaro</p>
                    <div class="flex text-[#f59e0b] text-[12px]">★★★★★</div>
                </div>
            </div>
            <p class="text-[13px] font-bold text-[#55617a] leading-relaxed relative z-10">Dapat rumah sesuai kebutuhan dan budget. Terima kasih MaxinPro!</p>
        </div>
        <!-- Testi 3 -->
        <div class="bg-[#f8fafc] rounded-3xl p-6 relative overflow-hidden group hover:shadow-md transition-shadow border border-brand-line/50">
            <div class="absolute right-4 top-4 text-brand-line/40 font-serif text-8xl leading-none italic pointer-events-none group-hover:text-brand-blue/10 transition-colors">"</div>
            <div class="flex items-center gap-4 mb-4 relative z-10">
                <div class="w-14 h-14 rounded-full bg-brand-navy overflow-hidden shrink-0 border-2 border-white shadow-sm">
                    <img src="https://i.pravatar.cc/150?img=9" alt="Siti Rahma" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="text-[15px] font-black text-brand-navy">Siti Rahma</h4>
                    <p class="text-[11.5px] font-bold text-[#7a8399] mb-1">Alam Sutera</p>
                    <div class="flex text-[#f59e0b] text-[12px]">★★★★★</div>
                </div>
            </div>
            <p class="text-[13px] font-bold text-[#55617a] leading-relaxed relative z-10">Layanan titip properti sangat membantu. Rumah saya terjual dalam 2 minggu!</p>
        </div>
    </div>
</section>

{{-- APP BANNER --}}
<section class="max-w-[1280px] mx-auto px-8 mb-16 relative">
    <div class="rounded-3xl bg-brand-blue text-white p-10 flex flex-col min-[900px]:flex-row items-center justify-between gap-6 shadow-xl relative overflow-hidden min-h-[220px]">
        <!-- Vector graphic in background -->
        <div class="absolute top-0 right-0 bottom-0 w-1/2 bg-gradient-to-l from-[#004de7] to-transparent opacity-60"></div>
        
        <div class="relative z-10 max-w-md">
            <h2 class="text-[28px] font-black mb-2 leading-tight">Jelajahi Properti Kapan Saja,<br>di Mana Saja</h2>
            <p class="text-[14px] font-bold text-white/90 mb-0">Download aplikasi MaxinPro sekarang!</p>
        </div>
        
        <!-- App Store / Play Store Buttons -->
        <div class="relative z-10 flex flex-col sm:flex-row items-center gap-4">
            <div class="flex flex-col gap-3">
                <a href="#" class="h-[46px] w-[140px] bg-black rounded-lg text-white flex items-center px-3 hover:scale-105 transition-transform border border-white/20 shadow-md">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.523 15.3414c-.0522-3.1534 2.585-4.6908 2.705-4.7645-1.458-2.1287-3.72-2.4277-4.5422-2.464-1.921-.194-3.7533 1.134-4.733 1.134-.9795 0-2.493-1.1072-4.0754-1.0772-2.0733.0298-3.9877 1.2015-5.0487 3.056-2.1557 3.7317-.5523 9.2483 1.5436 12.2743 1.0267 1.4828 2.2476 3.1616 3.8427 3.099 1.5367-.0626 2.119-.9884 3.9664-.9884 1.8367 0 2.3787.9884 3.9782.957 1.6212-.0312 2.656-1.5126 3.6702-2.986.174-.2517.34-.516.494-.789-1.5727-.6402-2.7303-2.1866-2.7483-3.9612.012-1.8596 1.0664-3.411 2.5768-4.2238M14.931 5.9224c.854-1.0326 1.428-2.466 1.272-3.8964-1.228.05-2.709.816-3.593 1.879-.787.94-1.432 2.404-1.254 3.821 1.365.106 2.723-.742 3.575-1.8036"></path></svg>
                    <div>
                        <div class="text-[9px] font-bold leading-none mb-0.5">Download on the</div>
                        <div class="text-[14px] font-black leading-none">App Store</div>
                    </div>
                </a>
                <a href="#" class="h-[46px] w-[140px] bg-black rounded-lg text-white flex items-center px-3 hover:scale-105 transition-transform border border-white/20 shadow-md">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M4 2v20l14.285-10L4 2zm15.714 9.143L22 12l-2.286.857-1.428-.857 1.428-.857zM5 4.5l11.428 8-11.428 8V4.5z"></path></svg>
                    <div>
                        <div class="text-[9px] font-bold leading-none mb-0.5">GET IT ON</div>
                        <div class="text-[14px] font-black leading-none">Google Play</div>
                    </div>
                </a>
            </div>
            <div class="w-24 h-24 bg-white p-1.5 rounded-lg shadow-md shrink-0 hidden sm:block">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://maxinpro.com/app" alt="QR Code" class="w-full h-full">
            </div>
        </div>
        
        <!-- Mockup Phones -->
        <div class="absolute left-1/2 -translate-x-1/2 min-[900px]:translate-x-0 min-[900px]:left-[40%] bottom-0 min-[900px]:-bottom-12 w-[350px] pointer-events-none hidden md:block">
            <svg viewBox="0 0 400 300" fill="none" class="w-full h-auto translate-y-6">
                <!-- Phone 1 (Back/Left) -->
                <rect x="50" y="40" width="130" height="270" rx="20" fill="#0f172a" stroke="#334155" stroke-width="4"/>
                <rect x="56" y="46" width="118" height="258" rx="14" fill="#ffffff"/>
                <rect x="56" y="46" width="118" height="40" rx="14" fill="#0a7cff"/>
                <rect x="64" y="96" width="102" height="150" rx="8" fill="#f1f5f9"/>
                <circle cx="115" cy="52" r="3" fill="#0f172a"/>
                <!-- Phone 2 (Front/Right) -->
                <rect x="140" y="20" width="140" height="290" rx="22" fill="#0f172a" stroke="#475569" stroke-width="5" transform="rotate(5 140 20)"/>
                <rect x="146" y="26" width="128" height="278" rx="16" fill="#ffffff" transform="rotate(5 140 20)"/>
                <rect x="146" y="26" width="128" height="44" rx="16" fill="#0a7cff" transform="rotate(5 140 20)"/>
                <rect x="156" y="80" width="108" height="160" rx="8" fill="#f8fafc" transform="rotate(5 140 20)"/>
                <rect x="166" y="90" width="88" height="80" rx="4" fill="#e2e8f0" transform="rotate(5 140 20)"/>
                <rect x="166" y="180" width="60" height="8" rx="2" fill="#94a3b8" transform="rotate(5 140 20)"/>
                <rect x="166" y="196" width="40" height="6" rx="2" fill="#cbd5e1" transform="rotate(5 140 20)"/>
                <circle cx="210" cy="32" r="4" fill="#0f172a" transform="rotate(5 140 20)"/>
            </svg>
        </div>
    </div>
</section>

<div class="h-16"></div>

HTML;
    
    file_put_contents($file, $topPart . $newHTML . $bottomPart);
    echo "home.blade.php updated.\n";
} else {
    echo "Could not find APP BANNER\n";
}
