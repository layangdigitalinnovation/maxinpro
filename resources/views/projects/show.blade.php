@extends('layouts.app')

@section('title', $project->name . ' — ' . $project->area->name . ' | MaxinPro')
@section('meta_description', Str::limit(strip_tags($project->description ?: ('Project ' . $project->name . ' oleh ' . $project->developer->name . ' di ' . $project->area->name . '. Harga mulai ' . $project->formatted_price_from . '.')), 155))
@section('og_type', 'product')
@section('og_image', $project->cover_image ? asset('storage/' . $project->cover_image) : asset('images/og-default.jpg'))

@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Residence',
    'name' => $project->name,
    'description' => Str::limit(strip_tags($project->description ?? ''), 300),
    'url' => route('projects.show', $project),
    'image' => $project->cover_image ? asset('storage/' . $project->cover_image) : asset('images/placeholder-property.jpg'),
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => $project->area->name,
        'addressRegion' => $project->area->city,
        'addressCountry' => 'ID',
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Beranda', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Project', 'item' => route('projects.index')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $project->name, 'item' => route('projects.show', $project)],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
<div class="max-w-[1280px] mx-auto px-8 pt-6 flex items-center gap-1.5 text-[#6d7890] text-[12.5px] font-bold">
    <a href="{{ route('home') }}" class="text-[#6d7890]">Beranda</a><span>/</span>
    <a href="{{ route('projects.index') }}" class="text-[#6d7890]">Project</a><span>/</span>
    <span class="text-brand-navy">{{ $project->name }}</span>
</div>

<div class="max-w-[1280px] mx-auto px-8 mt-4 grid grid-cols-1 min-[900px]:grid-cols-[1.6fr_1fr] gap-8 items-start">
    <div>
        <div class="rounded-2xl overflow-hidden aspect-[1.8/1] bg-brand-soft mb-5 relative">
            <img src="{{ $project->cover_image ? asset('storage/'.$project->cover_image) : asset('images/placeholder-property.jpg') }}" alt="{{ $project->name }}" class="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity lightbox-trigger">
            @if($project->youtube_url)
                <a href="{{ $project->youtube_url }}" target="_blank" class="absolute bottom-4 right-4 bg-white hover:bg-gray-50 text-brand-navy font-extrabold text-[13px] py-2 px-4 rounded-lg shadow-md flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4 text-[#0069ff]" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    Video
                </a>
            @endif
        </div>

        @if ($project->images->isNotEmpty())
            <div class="grid grid-cols-4 gap-3 mb-6">
                @foreach ($project->images as $img)
                    <img src="{{ asset('storage/'.$img->path) }}" alt="" class="rounded-lg aspect-square object-cover cursor-pointer hover:opacity-90 transition-opacity lightbox-trigger">
                @endforeach
            </div>
        @endif

        <h1 class="text-brand-navy text-[24px] font-black mb-1">{{ $project->name }}</h1>
        <p class="text-[#55617a] text-[13px] font-bold mb-4">{{ $project->area->name }}, {{ $project->area->city }}</p>

        <div class="flex items-center gap-5 text-[#39445e] text-[13px] font-bold mb-6 flex-wrap">
            <span>By {{ $project->developer->name }}</span>
            <span>{{ $project->status }}</span>
            @if($project->propertyType)
                <span>{{ $project->propertyType->name }}</span>
            @endif
        </div>

        <h2 class="text-brand-navy text-[16px] font-extrabold mb-2">Deskripsi</h2>
        <div class="text-[#3a455e] text-[13.5px] leading-relaxed font-medium mb-6 editor-content">
            {!! $project->description !!}
        </div>
    </div>

    <aside class="border border-brand-line rounded-2xl p-6 sticky top-[92px]">
        @if ($project->units_available)
            <span class="inline-block px-3 py-1 bg-green-50 text-green-600 font-extrabold text-[11px] uppercase tracking-wider rounded-lg mb-4">Tersedia Sisa {{ $project->units_available }} Unit</span>
        @endif
        
        <div class="text-[#7a8399] text-[12.5px] font-bold mb-1">Harga Mulai Dari</div>
        <div class="text-brand-navy text-[26px] font-black mb-4">{{ $project->formatted_price_from }}</div>
        
        <hr class="border-brand-line mb-4">

        <strong class="block text-[14px] text-brand-navy font-black mb-1">Tertarik dengan project ini?</strong>
        <p class="text-[12.5px] text-[#7a8399] font-bold mb-4 leading-relaxed">Konsultasikan kebutuhan Anda bersama agen profesional MaxinPro secara gratis.</p>

        <a href="https://wa.me/{{ setting('whatsapp_number', '6281112345678') }}?text={{ urlencode('Hai, saya tertarik dengan informasi lokasi ' . $project->name . '. Mohon informasi nya terkait unit tersebut: ' . route('projects.show', $project)) }}" target="_blank" rel="noopener"
           class="w-full inline-flex items-center justify-center gap-2 h-12 rounded-[10px] bg-gradient-to-r from-[#0069ff] to-[#004de7] text-white font-extrabold text-[13.5px] shadow-sm hover:scale-[1.02] transition-transform">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
            Chat Sekarang
        </a>
    </aside>
</div>

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
