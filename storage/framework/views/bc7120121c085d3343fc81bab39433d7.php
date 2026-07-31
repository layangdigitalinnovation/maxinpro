<?php $__env->startSection('title', 'MaxinPro — Temukan Properti Impianmu'); ?>
<?php $__env->startSection('meta_description', 'Cari rumah, apartemen, ruko, dan tanah dijual di BSD, Bintaro, Alam Sutera, Gading Serpong, dan Jakarta.'); ?>

<?php $__env->startSection('content'); ?>

<section class="relative bg-white pt-10 min-[900px]:pt-16 pb-32">
    <!-- Full Width Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="<?php echo e(asset('images/hero-skyline.png')); ?>" alt="" class="w-full h-full object-cover object-center">
        <!-- Subtle white gradient to ensure text readability -->
        <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/70 to-white/10 min-[900px]:from-white/90 min-[900px]:via-white/60 min-[900px]:to-transparent w-full min-[900px]:w-[60%]"></div>
    </div>
    
    <div class="relative max-w-[1100px] mx-auto px-4 z-10 flex flex-col min-[900px]:flex-row items-center">
        <div class="w-full min-[900px]:w-1/2 pt-10 min-[900px]:pt-24 pb-20">
            <h1 class="text-brand-navy font-black leading-[1.1] text-[40px] min-[900px]:text-[56px] mb-4">
                Temukan Properti<br><span class="text-brand-blue">Impianmu</span>
            </h1>
            <p class="text-[#3a455e] text-[15px] font-semibold mb-8 max-w-md">
                Jual, beli, sewa properti jadi lebih mudah<br>dan aman bersama MaxinPro.
            </p>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="<?php echo e(route('listings.index')); ?>" class="inline-flex justify-center items-center h-12 px-6 rounded-full bg-brand-blue text-white font-extrabold text-[14px] whitespace-nowrap w-full sm:w-auto shadow-lg shadow-brand-blue/30 hover:scale-105 transition-transform">
                    Jelajahi Listing →
                </a>
                <a href="<?php echo e(route('titip-properti.create')); ?>" class="inline-flex justify-center items-center h-12 px-6 rounded-full bg-white border border-brand-line text-brand-navy font-extrabold text-[14px] whitespace-nowrap w-full sm:w-auto shadow-sm hover:bg-gray-50 transition-colors">
                    Titip Properti <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </a>
            </div>
        </div>
    </div>
</section>


<div class="relative max-w-[1100px] mx-auto px-4 -mt-32 min-[900px]:-mt-48 mb-10 z-20">
    <div class="bg-white rounded-[28px] shadow-[0_20px_40px_rgba(0,0,0,0.08)] p-4 min-[900px]:p-6">
        <!-- Tabs -->
        <div class="flex items-center gap-6 border-b border-brand-line pb-0 mb-5 px-2">
            <button type="button" data-target="beli" class="search-tab flex items-center gap-2 text-brand-blue font-black text-[15px] pb-3 border-b-2 border-brand-blue transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg> Beli
            </button>
            <button type="button" data-target="sewa" class="search-tab flex items-center gap-2 text-[#7a8399] hover:text-brand-navy font-bold text-[15px] pb-3 border-b-2 border-transparent transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg> Sewa
            </button>
            <button type="button" data-target="project" class="search-tab flex items-center gap-2 text-[#7a8399] hover:text-brand-navy font-bold text-[15px] pb-3 border-b-2 border-transparent transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg> Project
            </button>
        </div>

        <form id="search-form" action="<?php echo e(route('listings.index')); ?>" method="GET">
            <div class="grid grid-cols-1 min-[900px]:grid-cols-[2.5fr_1fr_1fr_1fr_auto] gap-3">
                <label class="h-14 border border-brand-line rounded-2xl bg-white flex items-center gap-3 px-4 focus-within:border-brand-blue focus-within:ring-1 focus-within:ring-brand-blue transition-all">
                    <span class="text-xl">🔍</span>
                    <input type="search" name="q" placeholder="Cari lokasi, nama properti, area atau keyword" class="w-full border-0 outline-none text-[14px] font-semibold text-brand-navy bg-transparent">
                </label>
                <div class="h-14 border border-brand-line rounded-2xl flex flex-col justify-center px-4 relative bg-white focus-within:border-brand-blue transition-all">
                    <label class="text-[10px] font-extrabold text-[#7a8399] pointer-events-none">Jenis Properti</label>
                    <select name="type[]" class="w-full h-full bg-transparent outline-none text-[13px] font-bold text-brand-navy appearance-none pt-1 pb-1 cursor-pointer">
                        <option value="">Semua</option>
                        <?php $__currentLoopData = $propertyTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($pt->id); ?>"><?php echo e($pt->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-[10px]">▼</div>
                </div>
                <div class="h-14 border border-brand-line rounded-2xl flex flex-col justify-center px-4 relative bg-white focus-within:border-brand-blue transition-all">
                    <label class="text-[10px] font-extrabold text-[#7a8399] pointer-events-none">Harga</label>
                    <select name="price_range" class="w-full h-full bg-transparent outline-none text-[13px] font-bold text-brand-navy appearance-none pt-1 pb-1 cursor-pointer">
                        <option value="">Min - Max</option>
                        <option value="-1000000000">< Rp 1 M</option>
                        <option value="1000000000-3000000000">Rp 1 M - Rp 3 M</option>
                        <option value="3000000000-5000000000">Rp 3 M - Rp 5 M</option>
                        <option value="5000000000-">> Rp 5 M</option>
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-[10px]">▼</div>
                </div>
                <div class="h-14 border border-brand-line rounded-2xl flex flex-col justify-center px-4 relative bg-white focus-within:border-brand-blue transition-all">
                    <label class="text-[10px] font-extrabold text-[#7a8399] pointer-events-none">Luas Tanah</label>
                    <select name="luas_tanah" class="w-full h-full bg-transparent outline-none text-[13px] font-bold text-brand-navy appearance-none pt-1 pb-1 cursor-pointer">
                        <option value="">Min - Max</option>
                        <option value="-60">< 60 m²</option>
                        <option value="60-90">60 - 90 m²</option>
                        <option value="90-150">90 - 150 m²</option>
                        <option value="150-250">150 - 250 m²</option>
                        <option value="250-">> 250 m²</option>
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-[10px]">▼</div>
                </div>
                <button type="submit" class="h-14 min-w-[140px] rounded-2xl bg-[#0057ff] hover:bg-[#004de7] text-white font-black text-[14px] flex items-center justify-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg> Cari Properti
                </button>
            </div>
            
            <div class="flex items-center gap-3 flex-wrap mt-5 px-2">
                <span class="text-[12.5px] font-bold text-[#7a8399]">Pencarian Populer :</span>
                <?php $__currentLoopData = $popularAreas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('listings.index', ['q' => $area->name])); ?>" class="text-[12px] font-extrabold px-3.5 h-8 inline-flex items-center rounded-full bg-[#f4f7fb] text-[#3a455e] hover:bg-brand-soft hover:text-brand-blue transition-colors"><?php echo e($area->name); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </form>
    </div>
</div>


<section class="max-w-[1100px] mx-auto px-4 mt-12 mb-16">
    <div class="grid grid-cols-2 min-[600px]:grid-cols-3 min-[900px]:grid-cols-6 gap-4">
        <a href="<?php echo e(route('listings.index')); ?>" class="border border-brand-line rounded-3xl p-5 text-center group hover:border-brand-blue hover:shadow-lg transition-all bg-white">
            <svg class="w-9 h-9 mx-auto mb-3 text-brand-blue group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <strong class="block text-[13.5px] font-extrabold text-brand-navy">Beli</strong>
        </a>
        <a href="<?php echo e(route('listings.index')); ?>" class="border border-brand-line rounded-3xl p-5 text-center group hover:border-brand-blue hover:shadow-lg transition-all bg-white">
            <svg class="w-9 h-9 mx-auto mb-3 text-brand-blue group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            <strong class="block text-[13.5px] font-extrabold text-brand-navy">Sewa</strong>
        </a>
        <a href="<?php echo e(route('projects.index')); ?>" class="border border-brand-line rounded-3xl p-5 text-center group hover:border-brand-blue hover:shadow-lg transition-all bg-white">
            <svg class="w-9 h-9 mx-auto mb-3 text-brand-blue group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21V8"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 16h10"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21h16"/><path stroke-linecap="round" stroke-linejoin="round" d="M22 6L2 14"/></svg>
            <strong class="block text-[13.5px] font-extrabold text-brand-navy">(Project)</strong>
        </a>
        <a href="<?php echo e(route('titip-properti.create')); ?>" class="border border-brand-line rounded-3xl p-5 text-center group hover:border-brand-blue hover:shadow-lg transition-all bg-white">
            <svg class="w-9 h-9 mx-auto mb-3 text-brand-blue group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <strong class="block text-[13.5px] font-extrabold text-brand-navy">Titip Properti</strong>
        </a>
        <a href="<?php echo e(route('kpr.index')); ?>" class="border border-brand-line rounded-3xl p-5 text-center group hover:border-brand-blue hover:shadow-lg transition-all bg-white">
            <svg class="w-9 h-9 mx-auto mb-3 text-brand-blue group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l6-6m-6 6h.01M15 8h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <strong class="block text-[13.5px] font-extrabold text-brand-navy">KPR</strong>
        </a>
        <a href="<?php echo e(route('about.index')); ?>" class="border border-brand-line rounded-3xl p-5 text-center group hover:border-brand-blue hover:shadow-lg transition-all bg-white">
            <svg class="w-9 h-9 mx-auto mb-3 text-brand-blue group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <strong class="block text-[13.5px] font-extrabold text-brand-navy">About</strong>
        </a>
    </div>
</section>


<section class="max-w-[1280px] mx-auto px-8 mb-16 relative">
    <div class="relative group">
        <button type="button" class="carousel-prev hidden group-hover:min-[700px]:grid absolute -left-6 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white border border-brand-line shadow-lg place-items-center text-brand-navy font-bold hover:scale-110 transition-transform">←</button>
        <button type="button" class="carousel-next hidden group-hover:min-[700px]:grid absolute -right-6 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white border border-brand-line shadow-lg place-items-center text-brand-navy font-bold hover:scale-110 transition-transform">→</button>

        <div class="carousel-container flex gap-4 overflow-x-auto snap-x scroll-smooth pb-4 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
        
        <!-- Promo 1 -->
        <a href="<?php echo e(route('kpr.index')); ?>" class="snap-start shrink-0 w-[85vw] min-[900px]:w-[calc(33.333%-11px)] hover:scale-[1.02] transition-transform">
            <img src="<?php echo e(asset('images/promo-kpr.png')); ?>" alt="Promo KPR Spesial" class="w-full h-auto rounded-2xl shadow-sm border border-brand-line/50">
        </a>

        <!-- Promo 2 -->
        <a href="<?php echo e(route('listings.index')); ?>" class="snap-start shrink-0 w-[85vw] min-[900px]:w-[calc(33.333%-11px)] hover:scale-[1.02] transition-transform">
            <img src="<?php echo e(asset('images/cashback.png')); ?>" alt="Cashback Hingga 50 Juta" class="w-full h-auto rounded-2xl shadow-sm border border-brand-line/50">
        </a>

        <!-- Promo 3 -->
        <a href="<?php echo e(route('titip-properti.create')); ?>" class="snap-start shrink-0 w-[85vw] min-[900px]:w-[calc(33.333%-11px)] hover:scale-[1.02] transition-transform">
            <img src="<?php echo e(asset('images/titip-properti.png')); ?>" alt="Titip Properti Jadi Lebih Mudah" class="w-full h-auto rounded-2xl shadow-sm border border-brand-line/50">
        </a>

    </div>
    </div>
</section>


<section class="max-w-[1280px] mx-auto px-8 mb-16 relative">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-brand-navy font-black text-[22px] min-[900px]:text-[24px]">Project Terbaru</h2>
        <a href="<?php echo e(route('projects.index')); ?>" class="text-[13px] font-extrabold text-brand-blue flex items-center gap-1 hover:underline">Lihat Semua →</a>
    </div>
    
    <div class="relative group">
        <button type="button" class="carousel-prev hidden min-[700px]:grid absolute -left-4 top-[40%] -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white border border-brand-line shadow-lg place-items-center text-brand-blue font-bold hover:scale-110 transition-transform">←</button>
        <button type="button" class="carousel-next hidden min-[700px]:grid absolute -right-4 top-[40%] -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white border border-brand-line shadow-lg place-items-center text-brand-blue font-bold hover:scale-110 transition-transform">→</button>

        <div class="carousel-container flex gap-5 overflow-x-auto snap-x snap-mandatory pb-4 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
            <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="snap-start shrink-0 w-[280px] min-[900px]:w-[300px]">
                    <?php if (isset($component)) { $__componentOriginaldbcceabf4a99a34f9999233ae1fef693 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldbcceabf4a99a34f9999233ae1fef693 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.project-card','data' => ['project' => $project,'compact' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('project-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['project' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($project),'compact' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldbcceabf4a99a34f9999233ae1fef693)): ?>
<?php $attributes = $__attributesOriginaldbcceabf4a99a34f9999233ae1fef693; ?>
<?php unset($__attributesOriginaldbcceabf4a99a34f9999233ae1fef693); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldbcceabf4a99a34f9999233ae1fef693)): ?>
<?php $component = $__componentOriginaldbcceabf4a99a34f9999233ae1fef693; ?>
<?php unset($__componentOriginaldbcceabf4a99a34f9999233ae1fef693); ?>
<?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-brand-muted text-sm">Belum ada project yang tersedia.</p>
            <?php endif; ?>
        </div>
    </div>
</section>


<section class="max-w-[1280px] mx-auto px-8 mb-16 relative">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-brand-navy font-black text-[22px] min-[900px]:text-[24px]">Properti Pilihan Untukmu</h2>
        <a href="<?php echo e(route('listings.index')); ?>" class="text-[13px] font-extrabold text-brand-blue flex items-center gap-1 hover:underline">Lihat Semua →</a>
    </div>
    
    <div class="relative group">
        <button type="button" class="carousel-prev hidden min-[700px]:grid absolute -left-4 top-[40%] -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white border border-brand-line shadow-lg place-items-center text-brand-blue font-bold hover:scale-110 transition-transform">←</button>
        <button type="button" class="carousel-next hidden min-[700px]:grid absolute -right-4 top-[40%] -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white border border-brand-line shadow-lg place-items-center text-brand-blue font-bold hover:scale-110 transition-transform">→</button>

        <div class="carousel-container flex gap-5 overflow-x-auto snap-x snap-mandatory pb-4 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
            <?php $__empty_1 = true; $__currentLoopData = $listings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="snap-start shrink-0 w-[280px] min-[900px]:w-[300px]">
                    <?php if (isset($component)) { $__componentOriginal31ec1dc5dadb4835ef50de3d88e519ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal31ec1dc5dadb4835ef50de3d88e519ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listing-card','data' => ['listing' => $listing,'saved' => in_array($listing->id, $savedIds)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('listing-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing),'saved' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(in_array($listing->id, $savedIds))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal31ec1dc5dadb4835ef50de3d88e519ce)): ?>
<?php $attributes = $__attributesOriginal31ec1dc5dadb4835ef50de3d88e519ce; ?>
<?php unset($__attributesOriginal31ec1dc5dadb4835ef50de3d88e519ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal31ec1dc5dadb4835ef50de3d88e519ce)): ?>
<?php $component = $__componentOriginal31ec1dc5dadb4835ef50de3d88e519ce; ?>
<?php unset($__componentOriginal31ec1dc5dadb4835ef50de3d88e519ce); ?>
<?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-brand-muted text-sm">Belum ada properti yang tersedia.</p>
            <?php endif; ?>
        </div>
    </div>
</section>


<section class="max-w-[1280px] mx-auto px-8 mb-16">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-brand-navy font-black text-[24px] min-[900px]:text-[26px]">Area Populer</h2>
        <a href="<?php echo e(route('listings.index')); ?>" class="text-[13px] font-extrabold text-brand-blue flex items-center gap-1 hover:underline">Lihat Semua →</a>
    </div>
    <div class="grid grid-cols-2 min-[700px]:grid-cols-3 min-[1000px]:grid-cols-6 gap-4">
        <?php $__currentLoopData = $popularAreas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('area-landing.show', $area)); ?>" class="relative rounded-[20px] overflow-hidden aspect-square group shadow-sm">
                <img src="<?php echo e($area->image_path ? asset('storage/'.$area->image_path) : asset('images/placeholder-property.jpg')); ?>" alt="<?php echo e($area->name); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-brand-navy/90 to-transparent opacity-80"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <strong class="block text-[14px] font-black mb-0.5"><?php echo e($area->name); ?></strong>
                    <span class="text-[11.5px] font-extrabold text-white/80"><?php echo e($area->property_count); ?>+ Properti</span>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>


<section class="max-w-[1280px] mx-auto px-8 mb-8 mt-12">
    <h2 class="text-brand-navy font-black text-[22px] min-[900px]:text-[24px] mb-6">Fitur & Layanan Kami</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Fitur 1 -->
        <div class="bg-white rounded-2xl border border-brand-line p-5 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
            <h3 class="text-[15px] font-extrabold text-brand-navy mb-1.5">Kalkulator KPR</h3>
            <p class="text-[12px] font-bold text-[#7a8399] leading-relaxed mb-4 max-w-[180px]">Hitung simulasi KPR dengan mudah</p>
            <a href="<?php echo e(route('kpr.index')); ?>" class="text-[12px] font-black text-brand-blue flex items-center gap-1 group-hover:underline">Coba Sekarang →</a>
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


<section class="max-w-[1280px] mx-auto px-8 mb-16 relative">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-brand-navy font-black text-[22px] min-[900px]:text-[24px]">Artikel & Insight</h2>
        <a href="<?php echo e(route('articles.index')); ?>" class="text-[13px] font-extrabold text-brand-blue flex items-center gap-1 hover:underline">Lihat Semua →</a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('articles.show', $article->slug)); ?>" class="bg-white border border-brand-line rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all group flex flex-col h-full">
                <div class="aspect-[1.6/1] relative bg-brand-soft overflow-hidden shrink-0">
                    <img src="<?php echo e($article->cover_image ? asset('storage/' . $article->cover_image) : asset('images/placeholder-property.jpg')); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="<?php echo e($article->title); ?>">
                    <div class="absolute left-3 top-3 h-6 px-3 bg-white/90 backdrop-blur rounded-full flex items-center text-[10px] font-black text-brand-blue uppercase shadow-sm"><?php echo e($article->category ?? 'Berita'); ?></div>
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="text-[15px] font-black text-brand-navy leading-snug mb-2 group-hover:text-brand-blue transition-colors line-clamp-2"><?php echo e($article->title); ?></h3>
                    <div class="text-[12px] font-bold text-[#7a8399] mt-auto"><?php echo e($article->published_at ? $article->published_at->translatedFormat('d M Y') : $article->created_at->translatedFormat('d M Y')); ?></div>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full bg-white border border-brand-line rounded-2xl p-8 text-center">
                <p class="text-brand-muted text-[14px] font-medium">Belum ada artikel yang diterbitkan.</p>
            </div>
        <?php endif; ?>
    </div>
</section>


<section class="max-w-[1280px] mx-auto px-8 mb-20 relative">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-brand-navy font-black text-[22px] min-[900px]:text-[24px]">Testimoni Pelanggan</h2>
        <a href="#" class="text-[13px] font-extrabold text-brand-blue flex items-center gap-1 hover:underline">Lihat Semua →</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-[#f8fafc] rounded-3xl p-6 relative overflow-hidden group hover:shadow-md transition-shadow border border-brand-line/50">
                <div class="absolute right-4 top-4 text-brand-line/40 font-serif text-8xl leading-none italic pointer-events-none group-hover:text-brand-blue/10 transition-colors">"</div>
                <div class="flex items-center gap-4 mb-4 relative z-10">
                    <div class="w-14 h-14 rounded-full bg-brand-navy overflow-hidden shrink-0 border-2 border-white shadow-sm">
                        <img src="<?php echo e($testi->photo_path ? asset('storage/' . $testi->photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($testi->name).'&background=random'); ?>" alt="<?php echo e($testi->name); ?>" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h4 class="text-[15px] font-black text-brand-navy"><?php echo e($testi->name); ?></h4>
                        <p class="text-[11.5px] font-bold text-[#7a8399] mb-1"><?php echo e($testi->city); ?></p>
                        <div class="flex text-[#f59e0b] text-[12px]">
                            <?php for($i = 0; $i < $testi->rating; $i++): ?>★<?php endfor; ?>
                        </div>
                    </div>
                </div>
                <p class="text-[13px] font-bold text-[#55617a] leading-relaxed relative z-10"><?php echo e($testi->quote); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full bg-[#f8fafc] rounded-3xl p-6 text-center border border-brand-line/50">
                <p class="text-brand-muted text-[14px] font-medium">Belum ada testimoni pelanggan.</p>
            </div>
        <?php endif; ?>
    </div>
</section>


<section class="max-w-[1280px] mx-auto px-8 mb-16 relative">
    <div class="rounded-3xl overflow-hidden shadow-xl w-full">
        <a href="#" class="block w-full h-full hover:opacity-95 transition-opacity">
            <img src="<?php echo e(asset('images/banner-maxinpro.png')); ?>" alt="Download Aplikasi MaxinPro" class="w-full h-auto object-cover">
        </a>
    </div>
</section>

<div class="h-16"></div>
<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.search-tab');
        const form = document.getElementById('search-form');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active styling from all tabs
                tabs.forEach(t => {
                    t.classList.remove('text-brand-blue', 'border-brand-blue', 'font-black');
                    t.classList.add('text-[#7a8399]', 'border-transparent', 'font-bold');
                });
                
                // Add active styling to clicked tab
                this.classList.remove('text-[#7a8399]', 'border-transparent', 'font-bold');
                this.classList.add('text-brand-blue', 'border-brand-blue', 'font-black');
                
                // Change form action based on selected tab
                if (this.dataset.target === 'project') {
                    form.action = "<?php echo e(route('projects.index')); ?>";
                } else {
                    form.action = "<?php echo e(route('listings.index')); ?>";
                }
            });
        });
    });

    // Carousels
    document.querySelectorAll('.carousel-container').forEach(container => {
        const wrapper = container.parentElement;
        const prevBtn = wrapper.querySelector('.carousel-prev');
        const nextBtn = wrapper.querySelector('.carousel-next');

        if(prevBtn && nextBtn) {
            const scrollAmount = 350;
            prevBtn.addEventListener('click', () => {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });
            nextBtn.addEventListener('click', () => {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\home.blade.php ENDPATH**/ ?>