@extends('layouts.app')

@section('title', $listing->title . ' — ' . $listing->area->name . ' | MaxinPro')
@section('meta_description', Str::limit(strip_tags($listing->description ?: ($listing->title . ' di ' . $listing->area->name . ', ' . $listing->area->city . '. ' . $listing->bedrooms . ' kamar tidur, ' . $listing->land_area . ' m² tanah. Harga ' . $listing->formatted_price . '.')), 155))
@section('og_type', 'product')
@section('og_image', $listing->cover_image ? asset('storage/' . $listing->cover_image) : asset('images/og-default.jpg'))

@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Accommodation',
    'name' => $listing->title,
    'description' => Str::limit(strip_tags($listing->description ?? ''), 300),
    'url' => route('listings.show', $listing),
    'image' => $listing->images->isNotEmpty()
        ? $listing->images->map(fn ($img) => asset('storage/' . $img->path))->prepend($listing->cover_image ? asset('storage/' . $listing->cover_image) : null)->filter()->values()->all()
        : ($listing->cover_image ? asset('storage/' . $listing->cover_image) : asset('images/placeholder-property.jpg')),
    'numberOfBedrooms' => $listing->bedrooms,
    'numberOfBathroomsTotal' => $listing->bathrooms,
    'floorSize' => ['@type' => 'QuantitativeValue', 'value' => $listing->building_area, 'unitCode' => 'MTK'],
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => $listing->address,
        'addressLocality' => $listing->area->name,
        'addressRegion' => $listing->area->city,
        'addressCountry' => 'ID',
    ],
    'offers' => [
        '@type' => 'Offer',
        'price' => $listing->price,
        'priceCurrency' => 'IDR',
        'availability' => $listing->status === 'active'
            ? 'https://schema.org/InStock'
            : 'https://schema.org/SoldOut',
        'url' => route('listings.show', $listing),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Listing', 'item' => route('listings.index')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $listing->title, 'item' => route('listings.show', $listing)],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
<div class="max-w-[1280px] mx-auto px-8 pt-6 flex items-center gap-1.5 text-[#6d7890] text-[12.5px] font-bold">
    <a href="{{ route('home') }}" class="text-[#6d7890]">Beranda</a><span>/</span>
    <a href="{{ route('listings.index') }}" class="text-[#6d7890]">Listing</a><span>/</span>
    <span class="text-brand-navy">{{ $listing->title }}</span>
</div>

<div class="max-w-[1280px] mx-auto px-8 mt-4 grid grid-cols-1 min-[900px]:grid-cols-[1.6fr_1fr] gap-8 items-start">
    <div>
        <div class="rounded-2xl overflow-hidden aspect-[1.8/1] bg-brand-soft mb-5 relative">
            <img src="{{ $listing->cover_image ? asset('storage/'.$listing->cover_image) : asset('images/placeholder-property.jpg') }}" alt="{{ $listing->title }}" class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity lightbox-trigger">
            @if($listing->youtube_url)
                <a href="{{ $listing->youtube_url }}" target="_blank" class="absolute bottom-4 right-4 bg-white hover:bg-gray-50 text-brand-navy font-extrabold text-[13px] py-2 px-4 rounded-lg shadow-md flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4 text-[#0069ff]" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    Video
                </a>
            @endif
        </div>

        @if ($listing->images->isNotEmpty())
            <div class="grid grid-cols-4 gap-3 mb-6">
                @foreach ($listing->images as $img)
                    <img src="{{ asset('storage/'.$img->path) }}" alt="" class="rounded-lg aspect-square object-cover cursor-pointer hover:opacity-90 transition-opacity lightbox-trigger">
                @endforeach
            </div>
        @endif

        <h1 class="text-brand-navy text-[24px] font-black mb-1">{{ $listing->title }}</h1>
        <p class="text-[#55617a] text-[13px] font-bold mb-4">{{ $listing->address }}, {{ $listing->area->name }}, {{ $listing->area->city }}</p>

        <div class="flex items-center gap-5 text-[#39445e] text-[13px] font-bold mb-6 flex-wrap">
            <span>🚗 {{ $listing->car_ports }} Carport</span>
            <span>🛏 {{ $listing->bedrooms }} Kamar Tidur</span>
            <span>🛁 {{ $listing->bathrooms }} Kamar Mandi</span>
            <span>{{ $listing->land_area }} m² Tanah</span>
            <span>{{ $listing->building_area }} m² Bangunan</span>
        </div>

        <h2 class="text-brand-navy text-[16px] font-extrabold mb-2">Deskripsi</h2>
        <div class="text-[#3a455e] text-[13.5px] leading-relaxed font-medium mb-6 editor-content">
            {!! $listing->description !!}
        </div>
    </div>

    <aside class="border border-brand-line rounded-2xl p-6 sticky top-[92px]">
        <div class="text-brand-navy text-[26px] font-black mb-4">{{ $listing->formatted_price }}</div>
        @auth
            <form action="{{ route('listings.toggle-save', $listing) }}" method="POST" class="mb-4">
                @csrf
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 h-11 rounded-[10px] border {{ $isSaved ? 'border-brand-blue text-brand-blue' : 'border-brand-line text-brand-navy' }} font-extrabold text-[13px]">
                    {{ $isSaved ? '♥ Tersimpan di Favorit' : '♡ Simpan ke Favorit' }}
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="w-full mb-4 inline-flex items-center justify-center gap-2 h-11 rounded-[10px] border border-brand-line text-brand-navy font-extrabold text-[13px]">
                ♡ Masuk untuk Menyimpan
            </a>
        @endauth
        @if ($listing->agent)
            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-brand-line">
                <div class="w-11 h-11 rounded-full bg-brand-soft grid place-items-center text-brand-blue font-black">{{ Str::substr($listing->agent->name, 0, 1) }}</div>
                <div>
                    <strong class="block text-brand-navy text-[13.5px] font-extrabold">{{ $listing->agent->name }}</strong>
                    <span class="text-[11.5px] font-bold text-[#7a8399]">Agen MaxinPro</span>
                </div>
            </div>
        @endif
        <a href="https://wa.me/{{ setting('whatsapp_number', '6281112345678') }}?text={{ urlencode('Hai, saya tertarik dengan informasi lokasi ' . $listing->title . '. Mohon informasi nya terkait unit tersebut: ' . route('listings.show', $listing)) }}" target="_blank" rel="noopener"
           class="w-full inline-flex items-center justify-center h-12 rounded-[10px] bg-gradient-to-r from-[#0069ff] to-[#004de7] text-white font-extrabold text-[13.5px]">
            Hubungi via WhatsApp
        </a>
    </aside>
</div>

@if ($related->isNotEmpty())
<section class="max-w-[1280px] mx-auto px-8 mt-14">
    <h2 class="text-brand-navy font-black text-[22px] mb-4">Properti Sejenis di Area Ini</h2>
    <div class="grid grid-cols-1 min-[700px]:grid-cols-3 gap-5">
        @foreach ($related as $item)
            <x-listing-card :listing="$item" :saved="in_array($item->id, $savedIds)" />
        @endforeach
    </div>
</section>
@endif
<div class="h-16"></div>

<!-- Lightbox Modal -->
<div id="lightbox-modal" class="fixed inset-0 hidden flex-col items-center justify-center opacity-0 transition-opacity duration-300" style="background-color: rgba(0, 0, 0, 0.75); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); z-index: 9999; padding: 16px;">
    <div class="relative flex items-center justify-center w-full h-full">
        <!-- Prev Button -->
        <button id="lightbox-prev" class="absolute left-0 min-[900px]:left-4 w-12 h-12 min-[900px]:w-14 min-[900px]:h-14 rounded-full bg-white/10 hover:bg-white/25 text-white flex items-center justify-center transition-colors z-20 shadow-lg">
            <svg class="w-6 h-6 min-[900px]:w-8 min-[900px]:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <!-- Image Container -->
        <div class="relative inline-block" style="max-width: 85vw;">
            <img id="lightbox-img" src="" class="w-auto h-auto object-contain rounded-xl shadow-2xl select-none" style="max-width: 100%; max-height: 80vh;">
            
            <!-- Close Button (Inside Top Right of Image) -->
            <button id="lightbox-close" class="absolute flex items-center justify-center rounded-full text-white shadow-lg z-20" style="top: 12px; right: 12px; width: 36px; height: 36px; background-color: #ef4444; border: 2px solid white; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.3);">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Next Button -->
        <button id="lightbox-next" class="absolute right-0 min-[900px]:right-4 w-12 h-12 min-[900px]:w-14 min-[900px]:h-14 rounded-full bg-white/10 hover:bg-white/25 text-white flex items-center justify-center transition-colors z-20 shadow-lg">
            <svg class="w-6 h-6 min-[900px]:w-8 min-[900px]:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const triggers = document.querySelectorAll('.lightbox-trigger');
        const modal = document.getElementById('lightbox-modal');
        const modalImg = document.getElementById('lightbox-img');
        const closeBtn = document.getElementById('lightbox-close');
        const prevBtn = document.getElementById('lightbox-prev');
        const nextBtn = document.getElementById('lightbox-next');

        if (!modal || triggers.length === 0) return;

        const images = Array.from(triggers).map(t => t.src);
        let currentIndex = 0;

        function openLightbox(index) {
            currentIndex = index;
            modalImg.src = images[currentIndex];
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
            });
            document.body.style.overflow = 'hidden';
            
            if (images.length <= 1) {
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'none';
            } else {
                prevBtn.style.display = 'flex';
                nextBtn.style.display = 'flex';
            }
        }

        function closeLightbox() {
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modalImg.src = '';
                document.body.style.overflow = '';
            }, 300);
        }

        function prevImage() {
            if (images.length <= 1) return;
            currentIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
            modalImg.src = images[currentIndex];
        }

        function nextImage() {
            if (images.length <= 1) return;
            currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
            modalImg.src = images[currentIndex];
        }

        triggers.forEach((trigger, idx) => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                openLightbox(idx);
            });
        });

        closeBtn.addEventListener('click', closeLightbox);
        prevBtn.addEventListener('click', (e) => { e.stopPropagation(); prevImage(); });
        nextBtn.addEventListener('click', (e) => { e.stopPropagation(); nextImage(); });
        
        modal.addEventListener('click', (e) => {
            if (e.target.closest('button') || e.target === modalImg) return;
            closeLightbox();
        });

        document.addEventListener('keydown', (e) => {
            if (modal.classList.contains('hidden')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === 'ArrowRight') nextImage();
        });
    });
</script>
@endpush

<style>
    .editor-content ul { list-style-type: disc; margin-left: 1.5rem; margin-bottom: 1rem; }
    .editor-content ol { list-style-type: decimal; margin-left: 1.5rem; margin-bottom: 1rem; }
    .editor-content p { margin-bottom: 0.75rem; }
    .editor-content h1, .editor-content h2, .editor-content h3, .editor-content h4 { font-weight: bold; margin-top: 1.5rem; margin-bottom: 0.75rem; color: #0f172a; }
    .editor-content h1 { font-size: 1.5em; }
    .editor-content h2 { font-size: 1.25em; }
    .editor-content h3 { font-size: 1.1em; }
    .editor-content a { color: #3b82f6; text-decoration: underline; }
    .editor-content blockquote { border-left: 4px solid #e2e8f0; padding-left: 1rem; color: #64748b; font-style: italic; margin-bottom: 1rem; }
    .editor-content strong { font-weight: 800; }
</style>
@endsection
