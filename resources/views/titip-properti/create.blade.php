@extends('layouts.app')

@section('title', 'Titip Properti — MaxinPro')
@section('meta_description', 'Titipkan properti Anda ke MaxinPro dalam 3 langkah mudah. Tanpa biaya di muka, dipasarkan ke ribuan calon pembeli aktif, didampingi agen profesional.')

@push('scripts')
@if (config('services.recaptcha.site_key'))
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-brand-soft to-white pt-16 pb-12 overflow-hidden">
    <!-- Decorative Background Shapes -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-brand-blue/5 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-indigo-500/5 blur-3xl pointer-events-none"></div>

    <div class="max-w-[1280px] mx-auto px-8 relative text-center">
        <span class="inline-block px-4 py-1.5 rounded-full bg-brand-blue/10 text-brand-blue font-extrabold text-[12px] uppercase tracking-wider mb-4 shadow-sm border border-brand-blue/20">Layanan Titip Properti</span>
        <h1 class="text-brand-navy text-[32px] min-[900px]:text-[42px] font-black mb-4 tracking-tight leading-tight">3 Langkah Mudah Titip Properti <br class="hidden min-[900px]:block"><span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-blue to-purple-600">Bersama MaxinPro</span></h1>
        <p class="text-brand-muted text-[16px] font-medium max-w-2xl mx-auto mb-10 leading-relaxed">Proses cepat, aman, dan langsung terhubung dengan ratusan agen berpengalaman kami yang siap memasarkan properti Anda.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            @foreach ([
                ['title' => 'Isi Form Kebutuhan', 'desc' => 'Lengkapi data properti secara online.', 'icon' => '📝', 'color' => 'from-blue-400 to-blue-600'],
                ['title' => 'Verifikasi Data', 'desc' => 'Tim kami akan memvalidasi properti Anda.', 'icon' => '✅', 'color' => 'from-emerald-400 to-emerald-600'],
                ['title' => 'Properti Dipromosikan', 'desc' => 'Listing langsung tayang & dicari pembeli.', 'icon' => '📣', 'color' => 'from-purple-400 to-purple-600'],
            ] as $i => $step)
                <div class="bg-white rounded-2xl p-6 relative overflow-hidden group border border-brand-line/50 hover:border-transparent transition-all duration-300 shadow-soft hover:shadow-soft-hover hover:-translate-y-1">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-[18px] bg-gradient-to-tr {{ $step['color'] }} grid place-items-center text-3xl shadow-md text-white transform group-hover:scale-110 transition-transform duration-300">{{ $step['icon'] }}</div>
                    <strong class="block text-brand-navy text-[16px] font-black mb-1.5">{{ $step['title'] }}</strong>
                    <p class="text-brand-muted text-[13px] font-medium leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Main Form Section -->
<section class="max-w-[1280px] mx-auto px-8 mt-12 mb-20 grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-10 items-start">
    <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-soft border border-brand-line/50 relative">
        <h2 class="text-brand-navy text-[22px] font-black mb-2">Formulir Data Properti</h2>
        <p class="text-brand-muted text-[14px] font-medium mb-8">Mohon isi data di bawah dengan lengkap. Tim MaxinPro akan segera menghubungi Anda dalam waktu 1x24 jam kerja.</p>

        @if (session('success'))
            <div class="mb-8 rounded-xl bg-green-50 border border-green-200 text-green-800 text-[13.5px] font-bold px-5 py-4 flex items-center gap-3">
                <span class="text-xl">🎉</span> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('titip-properti.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Group 1: Informasi Pribadi -->
                <div class="p-6 rounded-2xl bg-brand-soft/50 border border-brand-line/50 space-y-5">
                    <h3 class="text-[15px] font-black text-brand-navy flex items-center gap-2"><span class="w-6 h-6 rounded-full bg-white flex items-center justify-center shadow-sm text-brand-blue text-xs">1</span> Data Diri Pemilik</h3>
                    <div>
                        <label class="block mb-2 text-brand-navy text-[13px] font-extrabold">Nama Lengkap *</label>
                        <input required type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama sesuai identitas"
                               class="w-full h-[50px] border border-brand-line rounded-xl px-4 text-[14px] transition-all hover:border-brand-blue/50 focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10 outline-none">
                        @error('name') <p class="text-red-500 text-[12px] font-bold mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block mb-2 text-brand-navy text-[13px] font-extrabold">Nomor WhatsApp *</label>
                            <input required type="tel" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 081234567890"
                                   class="w-full h-[50px] border border-brand-line rounded-xl px-4 text-[14px] transition-all hover:border-brand-blue/50 focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10 outline-none">
                            @error('phone') <p class="text-red-500 text-[12px] font-bold mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block mb-2 text-brand-navy text-[13px] font-extrabold">Kota / Wilayah *</label>
                            <div class="relative">
                                <select required name="city" class="w-full h-[50px] border border-brand-line rounded-xl px-4 text-[14px] bg-white appearance-none cursor-pointer transition-all hover:border-brand-blue/50 focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10 outline-none">
                                    <option value="" disabled selected>Pilih area kota properti</option>
                                    @foreach (['Tangerang Selatan', 'Tangerang', 'Jakarta Selatan', 'Jakarta Barat', 'Bekasi', 'Depok'] as $city)
                                        <option value="{{ $city }}" @selected(old('city') === $city)>{{ $city }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-brand-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('city') <p class="text-red-500 text-[12px] font-bold mt-1.5">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Group 2: Informasi Properti -->
                <div class="p-6 rounded-2xl bg-brand-soft/50 border border-brand-line/50 space-y-5">
                    <h3 class="text-[15px] font-black text-brand-navy flex items-center gap-2"><span class="w-6 h-6 rounded-full bg-white flex items-center justify-center shadow-sm text-brand-blue text-xs">2</span> Detail Properti</h3>
                    <div>
                        <label class="block mb-2 text-brand-navy text-[13px] font-extrabold">Alamat Lengkap Properti *</label>
                        <input required type="text" name="address" value="{{ old('address') }}" placeholder="Nama jalan, blok, RT/RW, kelurahan"
                               class="w-full h-[50px] border border-brand-line rounded-xl px-4 text-[14px] transition-all hover:border-brand-blue/50 focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10 outline-none">
                        @error('address') <p class="text-red-500 text-[12px] font-bold mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block mb-2 text-brand-navy text-[13px] font-extrabold">Tipe Properti *</label>
                            <div class="relative">
                                <select required name="property_type_id" class="w-full h-[50px] border border-brand-line rounded-xl px-4 text-[14px] bg-white appearance-none cursor-pointer transition-all hover:border-brand-blue/50 focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10 outline-none">
                                    <option value="" disabled selected>Pilih jenis properti</option>
                                    @foreach ($propertyTypes as $type)
                                        <option value="{{ $type->id }}" @selected((string) old('property_type_id') === (string) $type->id)>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-brand-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('property_type_id') <p class="text-red-500 text-[12px] font-bold mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block mb-2 text-brand-navy text-[13px] font-extrabold">Harga Harapan (Rp) *</label>
                            <input required type="text" name="expected_price" value="{{ old('expected_price') }}" placeholder="Contoh: 2.500.000.000"
                                   class="w-full h-[50px] border border-brand-line rounded-xl px-4 text-[14px] transition-all hover:border-brand-blue/50 focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10 outline-none">
                            @error('expected_price') <p class="text-red-500 text-[12px] font-bold mt-1.5">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-brand-navy text-[13px] font-extrabold">Spesifikasi Tambahan (Opsional)</label>
                        <textarea name="specification" rows="4" placeholder="Contoh: 2 lantai, luas tanah 200m², luas bangunan 150m², 4 kamar tidur, hook, dekat stasiun..."
                                  class="w-full border border-brand-line rounded-xl px-4 py-3 text-[14px] transition-all hover:border-brand-blue/50 focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10 outline-none resize-y">{{ old('specification') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex items-start gap-3 bg-brand-soft/30 p-4 rounded-xl border border-brand-line/50">
                <div class="mt-0.5 text-brand-blue">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-brand-muted text-[12px] font-medium leading-relaxed flex-1">
                    Dengan mengeklik tombol <strong>Kirim Permintaan</strong>, Anda menyatakan bahwa Anda adalah pemilik sah atau wakil resmi dari properti ini, serta menyetujui Syarat dan Ketentuan MaxinPro.
                </p>
            </div>

            @if (config('services.recaptcha.site_key'))
                <div class="g-recaptcha mt-6" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                @error('g-recaptcha-response') <p class="text-red-500 text-[12px] font-bold mt-1.5">{{ $message }}</p> @enderror
            @endif

            <button type="submit" class="mt-8 w-full h-[56px] rounded-xl bg-gradient-to-r from-brand-blue to-purple-600 hover:from-brand-blue2 hover:to-purple-700 text-white font-extrabold text-[15px] shadow-soft-hover transition-all active:scale-[0.98]">
                Kirim Permintaan Titip Jual
            </button>
        </form>
    </div>

    <!-- Right Sidebar -->
    <aside class="space-y-6 sticky top-24">
        <!-- Benefit Card -->
        <div class="bg-white rounded-3xl p-7 shadow-soft border border-brand-line/50">
            <div class="w-12 h-12 bg-brand-soft rounded-xl flex items-center justify-center text-xl mb-5">💎</div>
            <strong class="block text-brand-navy text-[18px] font-black mb-5">Keuntungan Titip Properti di MaxinPro</strong>
            <ul class="space-y-4">
                @foreach ([
                    'Dipasarkan secara masif ke ribuan calon pembeli',
                    'Agen profesional & sertifikasi siap membantu',
                    'Transparan, tanpa biaya admin tersembunyi',
                    'Gratis sesi foto dan videografi properti*',
                ] as $benefit)
                    <li class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-brand-navy text-[13.5px] font-medium leading-relaxed">{{ $benefit }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- WhatsApp CTA Card -->
        <div class="rounded-3xl bg-gradient-to-br from-brand-navy via-brand-ink to-brand-navy text-white p-7 shadow-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none group-hover:bg-brand-blue/20 transition-all duration-500"></div>
            
            <div class="relative z-10">
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center text-xl mb-4 backdrop-blur-sm border border-white/10">💬</div>
                <strong class="block text-[18px] font-black mb-2">Butuh Bantuan Cepat?</strong>
                <p class="text-[13px] font-medium text-white/70 mb-6 leading-relaxed">
                    Konsultasikan properti Anda langsung dengan tim *support* kami melalui WhatsApp.
                </p>
                <a href="https://wa.me/6281112345678" target="_blank" rel="noopener" class="w-full inline-flex items-center justify-center gap-2.5 h-[48px] rounded-xl bg-white text-brand-navy hover:bg-brand-soft font-extrabold text-[14px] transition-colors shadow-lg">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                    Chat Sekarang
                </a>
            </div>
        </div>
    </aside>
</section>
@endsection
