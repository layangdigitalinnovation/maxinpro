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
<!-- Hero Section (Full width on mobile, boxed on desktop) -->
<section class="max-w-[1280px] mx-auto min-[900px]:px-8 pt-6">
    <div class="relative w-full aspect-[4/3] sm:aspect-[2.2/1] min-[900px]:rounded-[32px] overflow-hidden bg-brand-navy shadow-2xl group">
        <img src="{{ $project->cover_image ? asset('storage/'.$project->cover_image) : asset('images/placeholder-property.jpg') }}" alt="{{ $project->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        
        <!-- Subtle Overlay Gradient -->
        <div class="absolute inset-0 bg-gradient-to-t from-brand-navy/80 via-brand-navy/20 to-transparent"></div>
        
        <!-- Developer Badge overlay (bottom left) -->
        <div class="absolute bottom-6 left-6 min-[900px]:bottom-10 min-[900px]:left-10 flex items-center gap-3">
            <div class="px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-white text-[12px] font-extrabold uppercase tracking-wider shadow-lg">
                By {{ $project->developer->name }}
            </div>
        </div>
    </div>
</section>

<!-- Content & Sticky Sidebar -->
<section class="max-w-[1280px] mx-auto px-8 py-12 lg:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_400px] gap-12 lg:gap-16 items-start">
        
        <!-- Main Info -->
        <div class="space-y-8">
            <!-- Title and Location -->
            <div>
                <h1 class="text-brand-navy text-[32px] md:text-[42px] font-black leading-tight tracking-tight mb-4">
                    {{ $project->name }}
                </h1>
                <div class="flex items-center gap-2 text-brand-muted text-[15px] font-semibold">
                    <div class="w-8 h-8 rounded-full bg-brand-blue/10 text-brand-blue flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <span>{{ $project->area->name }}, {{ $project->area->city }}</span>
                </div>
            </div>
            
            <hr class="border-brand-line/60">

            <!-- Description -->
            <div>
                <h2 class="text-brand-navy text-[20px] font-black mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-brand-blue"></span> Tentang Project
                </h2>
                <div class="text-[#4a5568] text-[15px] leading-[1.8] font-medium whitespace-pre-line">
                    {{ $project->description }}
                </div>
            </div>
        </div>

        <!-- Sticky Pricing Sidebar -->
        <aside class="sticky top-24 z-10">
            <div class="bg-white rounded-[24px] p-8 shadow-soft border border-brand-line/50 relative overflow-hidden group">
                <!-- Decorative element -->
                <div class="absolute -right-12 -top-12 w-32 h-32 bg-brand-blue/5 rounded-full blur-3xl pointer-events-none group-hover:bg-brand-blue/10 transition-colors duration-500"></div>

                <div class="relative z-10">
                    <!-- Pricing -->
                    <div class="mb-6">
                        <span class="inline-block px-3 py-1 bg-green-50 text-green-600 font-extrabold text-[12px] uppercase tracking-wider rounded-lg mb-3">Tersedia {{ $project->units_available }} Unit</span>
                        <div class="text-brand-muted text-[13px] font-bold mb-1">Harga Mulai Dari</div>
                        <div class="text-brand-navy text-[28px] md:text-[32px] font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-brand-navy to-brand-blue">
                            {{ $project->formatted_price_from }}
                        </div>
                    </div>

                    <hr class="border-brand-line/60 mb-6">

                    <!-- CTA -->
                    <div class="space-y-4">
                        <strong class="block text-[15px] text-brand-navy font-black">Tertarik dengan project ini?</strong>
                        <p class="text-[13px] text-brand-muted font-medium mb-2 leading-relaxed">Konsultasikan kebutuhan Anda bersama agen profesional MaxinPro secara gratis.</p>
                        
                        <a href="https://wa.me/6281112345678?text={{ urlencode('Halo, saya tertarik dengan project: ' . $project->name) }}" target="_blank" rel="noopener"
                           class="w-full h-[52px] rounded-xl bg-gradient-to-r from-[#0069ff] to-[#004de7] hover:from-brand-blue2 hover:to-purple-700 text-white font-extrabold text-[14px] shadow-soft-hover transition-all active:scale-[0.98] flex items-center justify-center gap-3 relative overflow-hidden group/btn">
                            <!-- WhatsApp Icon -->
                            <svg class="w-5 h-5 relative z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                            <span class="relative z-10">Chat Sekarang</span>
                        </a>
                    </div>
                </div>
            </div>
        </aside>
        
    </div>
</section>

<!-- Footer Spacer -->
<div class="h-10"></div>
@endsection
