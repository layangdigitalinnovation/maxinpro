<?php $__env->startSection('title', 'Tentang Kami — MaxinPro'); ?>
<?php $__env->startSection('meta_description', 'MaxinPro adalah partner properti terpercaya Anda di kawasan Jabodetabek, menyederhanakan proses jual, beli, dan KPR.'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="relative bg-[#06143b] text-white pt-24 pb-32 overflow-hidden">
    <!-- Abstract Glow Effects -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-blue/30 rounded-full blur-[100px] -mr-40 -mt-40 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-indigo-600/20 rounded-full blur-[100px] -ml-20 -mb-20 pointer-events-none"></div>
    
    <!-- Fine Grid Background Pattern (Subtle) -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgcGF0dGVybmtuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTTAgNDBoNDBWMEgwem0zOS0zOU0xIDFtMzggMG0tMzggMzgiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-50 pointer-events-none"></div>

    <div class="max-w-[1280px] mx-auto px-8 relative z-10 text-center">
        <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-blue-300 font-extrabold text-[12px] uppercase tracking-widest mb-6 backdrop-blur-sm border border-white/10">
            Tentang Kami
        </span>
        <h1 class="text-[36px] min-[900px]:text-[52px] font-black max-w-4xl mx-auto leading-[1.15] mb-6 tracking-tight">
            Partner Properti Terpercaya untuk <br class="hidden min-[900px]:block"> 
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-indigo-300">Setiap Keputusan Penting Anda</span>
        </h1>
        <p class="text-[16px] font-medium max-w-2xl mx-auto text-white/70 leading-relaxed">
            MaxinPro membantu ribuan keluarga dan investor menemukan, menjual, dan membiayai properti di kawasan Jabodetabek dengan proses yang 100% transparan dan aman.
        </p>
    </div>
</section>

<!-- Stats Section (Overlapping the hero) -->
<section class="max-w-[1280px] mx-auto px-8 relative z-20 -mt-16 mb-20">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        <?php $__currentLoopData = [
            ['label' => 'Properti Aktif', 'value' => '9+'],
            ['label' => 'Agen Profesional', 'value' => '3+'],
            ['label' => 'Project Baru', 'value' => '3+'],
            ['label' => 'Berdiri Sejak', 'value' => '2011'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-3xl p-8 text-center shadow-[0_8px_30px_rgba(0,0,0,0.06)] border border-brand-line/50 transition-transform duration-300 hover:-translate-y-1">
                <div class="text-[36px] min-[900px]:text-[48px] font-black text-transparent bg-clip-text bg-gradient-to-br from-brand-blue to-purple-600 mb-2 drop-shadow-sm tracking-tighter"><?php echo e($stat['value']); ?></div>
                <div class="text-[#5e6a84] text-[13px] font-extrabold uppercase tracking-wide"><?php echo e($stat['label']); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>

<!-- Story Section -->
<section class="max-w-[1000px] mx-auto px-8 mb-24">
    <div class="bg-white rounded-[32px] p-8 lg:p-14 shadow-soft border border-brand-line/50 relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -mr-10 -mt-10 pointer-events-none"></div>
        
        <div class="flex flex-col md:flex-row gap-10 md:gap-16 items-start">
            <!-- Left Header -->
            <div class="md:w-1/3 shrink-0 relative z-10">
                <h2 class="text-[28px] lg:text-[36px] font-black text-brand-navy leading-tight relative">
                    Cerita<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-blue to-brand-blue2">Perjalanan Kami</span>
                    <div class="absolute -left-6 top-2 w-1.5 h-16 bg-brand-blue rounded-full hidden md:block"></div>
                </h2>
            </div>
            
            <!-- Right Content -->
            <div class="md:w-2/3 relative z-10">
                <div class="prose prose-lg prose-blue text-[#4a5568] leading-[1.8] font-medium text-[15.5px]">
                    <p class="mb-5">
                        MaxinPro berdiri dengan satu keyakinan sederhana: <strong class="text-brand-navy">mencari, menjual, atau membiayai properti seharusnya tidak rumit.</strong>
                    </p>
                    <p class="mb-5">
                        Kami membangun platform yang menggabungkan kemudahan teknologi dengan sentuhan personal manusia. Di sini, Anda akan menemukan <em>listing</em> properti terkurasi yang berkualitas, didukung oleh jaringan agen berpengalaman, dan simulasi KPR yang terintegrasi penuh dalam satu tempat.
                    </p>
                    <p>
                        Saat ini, kami bekerja sama secara eksklusif dengan puluhan developer terpercaya untuk proyek-proyek perumahan & apartemen baru. Tidak hanya itu, ratusan agen profesional kami tersebar luas dan selalu siap sedia mendampingi Anda di setiap langkah proses jual, beli, hingga titip properti dengan standar transparansi tertinggi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="max-w-[1280px] mx-auto px-8 mb-24">
    <div class="text-center mb-12">
        <h2 class="text-brand-navy text-[28px] font-black">Nilai Perusahaan Kami</h2>
        <p class="text-brand-muted text-[15px] font-medium mt-2">Kompas yang menuntun setiap layanan dan inovasi kami.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-[1000px] mx-auto">
        <!-- Vision -->
        <div class="bg-gradient-to-br from-[#f8fafc] to-[#f1f5f9] rounded-[32px] p-10 shadow-inner border border-white relative overflow-hidden group">
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 bg-gradient-to-br from-blue-500/5 to-purple-500/5 transition-opacity duration-500"></div>
            
            <div class="relative z-10">
                <div class="w-16 h-16 rounded-2xl bg-white shadow-lg text-brand-blue flex items-center justify-center mb-8 border border-brand-line/50 transform group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <h3 class="text-brand-navy text-[22px] font-black mb-3">Visi</h3>
                <p class="text-[#4a5568] text-[15px] font-medium leading-relaxed">
                    Menjadi platform dan agensi properti paling modern, transparan, dan dipercaya oleh seluruh keluarga dan investor di Indonesia.
                </p>
            </div>
        </div>

        <!-- Mission -->
        <div class="bg-gradient-to-br from-[#f8fafc] to-[#f1f5f9] rounded-[32px] p-10 shadow-inner border border-white relative overflow-hidden group">
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 transition-opacity duration-500"></div>
            
            <div class="relative z-10">
                <div class="w-16 h-16 rounded-2xl bg-white shadow-lg text-emerald-500 flex items-center justify-center mb-8 border border-brand-line/50 transform group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-brand-navy text-[22px] font-black mb-4">Misi</h3>
                <ul class="space-y-3">
                    <?php $__currentLoopData = [
                        'Menyederhanakan birokrasi proses jual, beli, dan KPR properti melalui teknologi.',
                        'Menghadirkan agen profesional yang terverifikasi, etis, dan berorientasi pada pelanggan.',
                        'Membangun jaringan kemitraan kuat dengan developer dan institusi perbankan terpercaya.'
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></div>
                            <span class="text-[#4a5568] text-[14.5px] font-medium leading-relaxed"><?php echo e($mission); ?></span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/about/index.blade.php ENDPATH**/ ?>