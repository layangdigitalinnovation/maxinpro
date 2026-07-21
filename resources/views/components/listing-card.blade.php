@props(['listing', 'saved' => false])
<article class="bg-white border border-brand-line rounded-card overflow-hidden shadow-card">
    <div class="relative aspect-[2.1/1] bg-brand-soft">
        <img src="{{ $listing->cover_image ? asset('storage/'.$listing->cover_image) : asset('images/hero-skyline.png') }}"
             alt="{{ $listing->title }}" class="w-full h-full object-cover" loading="lazy">
        @if ($listing->badge)
            <span class="absolute left-2.5 top-2.5 h-[22px] px-2.5 rounded-full bg-gradient-to-r from-[#0a7cff] to-[#0054ef] text-white inline-flex items-center text-[10px] font-black uppercase">
                {{ $listing->badge }}
            </span>
        @endif
        @auth
            <form action="{{ route('listings.toggle-save', $listing) }}" method="POST" class="absolute top-2.5 right-2.5">
                @csrf
                <button type="submit" aria-label="Simpan" class="w-7 h-7 rounded-full grid place-items-center shadow {{ $saved ? 'bg-brand-blue text-white' : 'bg-white/90 text-brand-blue' }}">
                    {{ $saved ? '♥' : '♡' }}
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" aria-label="Masuk untuk menyimpan" class="absolute top-2.5 right-2.5 w-7 h-7 rounded-full grid place-items-center shadow bg-white/90 text-brand-blue">♡</a>
        @endauth
    </div>
    <div class="p-3.5 pb-4">
        <h3 class="mb-1 text-brand-navy text-[14px] leading-tight font-extrabold">
            <a href="{{ route('listings.show', $listing) }}">{{ $listing->title }}</a>
        </h3>
        <div class="text-[#55617a] text-[11.5px] font-bold mb-2.5">{{ $listing->area->name }}, {{ $listing->area->city }}</div>
        <div class="flex items-center gap-2.5 text-[#51607a] text-[11.5px] font-bold mb-2.5 flex-wrap">
            <span>🚗 {{ $listing->car_ports }}</span>
            <span>🛏 {{ $listing->bedrooms }}</span>
            <span>🛁 {{ $listing->bathrooms }}</span>
            <span>{{ $listing->land_area }} m²</span>
        </div>
        <div class="text-brand-navy text-[15px] font-black">{{ $listing->formatted_price }}</div>
    </div>
</article>
