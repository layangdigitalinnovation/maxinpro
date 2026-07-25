@props(['project', 'compact' => false])
<article class="bg-white border border-brand-line rounded-2xl overflow-hidden shadow-card flex flex-col h-full {{ $compact ? 'w-[270px] shrink-0' : '' }} relative hover:shadow-lg transition-shadow">
    <a href="{{ route('projects.show', $project) }}" class="absolute inset-0 z-10"></a>
    <div class="relative bg-brand-soft shrink-0 w-full" style="padding-bottom: 56.25%;">
        <img src="{{ $project->cover_image ? asset('storage/'.$project->cover_image) : asset('images/hero-skyline.png') }}"
             alt="{{ $project->name }}" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
        <span class="absolute left-3 top-3 h-6 px-3 rounded-full bg-gradient-to-r from-[#0a7cff] to-[#0054ef] text-white inline-flex items-center text-[10.5px] font-black uppercase z-20">
            {{ $project->status }}
        </span>
        <span class="absolute right-3 top-3 h-6 px-2.5 rounded-full text-white inline-flex items-center text-[10px] font-black shadow-md z-20" style="background: linear-gradient(to right, #f97316, #ea580c);">
            ✓ Official Partner
        </span>
    </div>
    <div class="p-4 pb-4.5 flex flex-col flex-1">
        <div class="flex items-center justify-between mb-1.5">
            @if ($project->propertyType)
                <span class="text-brand-blue text-[10.5px] font-black uppercase tracking-wide">{{ $project->propertyType->name }}</span>
            @else
                <span></span>
            @endif
            <span class="text-[#9aa4b8] text-[10px] font-extrabold uppercase tracking-wide">by {{ $project->developer->name }}</span>
        </div>

        <h3 class="mb-1 text-brand-navy text-[16px] font-black leading-snug line-clamp-2" title="{{ $project->name }}">
            {{ $project->name }}
        </h3>
        <div class="text-[#55617a] text-[11.5px] font-bold mb-3">{{ $project->area->name }}, {{ $project->area->city }}</div>

        <div class="mt-auto">
            <div class="flex items-center justify-between pt-3 border-t border-brand-line">
                <div>
                    <div class="text-[#7a8399] text-[10.5px] font-bold">Mulai dari</div>
                    <div class="text-brand-navy text-[15px] font-black">{{ $project->formatted_price_from }}</div>
                </div>
                @if ($project->units_available)
                    <div class="text-[#39445e] text-[11.5px] font-bold text-right">{{ $project->units_available }}</div>
                @endif
            </div>
        </div>
    </div>
</article>
