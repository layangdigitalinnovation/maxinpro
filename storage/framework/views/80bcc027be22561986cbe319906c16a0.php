<?php $__env->startSection('title', 'Kalkulator KPR — MaxinPro'); ?>
<?php $__env->startSection('meta_description', 'Hitung estimasi cicilan KPR bulanan secara gratis. Lihat syarat pengajuan lengkap dan daftar bank rekanan MaxinPro sebelum mengajukan kredit rumah.'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-brand-soft to-white pt-16 pb-12 overflow-hidden">
    <!-- Decorative Background Shapes -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-brand-blue/5 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-indigo-500/5 blur-3xl pointer-events-none"></div>

    <div class="max-w-[1280px] mx-auto px-8 relative text-center">
        <span class="inline-block px-4 py-1.5 rounded-full bg-brand-blue/10 text-brand-blue font-extrabold text-[12px] uppercase tracking-wider mb-4 shadow-sm border border-brand-blue/20">Kalkulator Finansial</span>
        <h1 class="text-brand-navy text-[32px] min-[900px]:text-[44px] font-black mb-4 tracking-tight leading-tight">
            Simulasikan Cicilan <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-blue to-purple-600">KPR Anda</span>
        </h1>
        <p class="text-brand-muted text-[16px] font-medium max-w-2xl mx-auto leading-relaxed">
            Hitung estimasi cicilan bulanan dengan mudah dan akurat sebelum mengajukan KPR melalui ratusan bank rekanan terpercaya MaxinPro.
        </p>
    </div>
</section>

<!-- Calculator Section -->
<section class="max-w-[1100px] mx-auto px-8 mt-6 mb-16 grid grid-cols-1 lg:grid-cols-[1.3fr_1fr] gap-8 items-start">
    
    <!-- Input Form -->
    <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-soft border border-brand-line/50 relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-soft rounded-bl-full -mr-10 -mt-10 opacity-50"></div>
        
        <h2 class="text-brand-navy text-[20px] font-black mb-8 relative z-10">Data Pembelian Properti</h2>
        
        <div class="grid gap-6 relative z-10">
            <div>
                <label class="block mb-2 text-brand-navy text-[13px] font-extrabold">Harga Properti (Rp)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-brand-muted font-bold">Rp</div>
                    <input id="kpr-price" type="number" min="0" value="2000000000" 
                           class="w-full h-[52px] border border-brand-line rounded-xl pl-12 pr-4 text-[15px] font-bold text-brand-navy transition-all hover:border-brand-blue/50 focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10 outline-none">
                </div>
            </div>
            
            <div>
                <div class="flex justify-between items-end mb-2">
                    <label class="block text-brand-navy text-[13px] font-extrabold">Uang Muka / DP</label>
                    <span id="kpr-dp-percent" class="text-brand-blue text-[12px] font-extrabold bg-brand-blue/10 px-2 py-0.5 rounded-md">20%</span>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-brand-muted font-bold">Rp</div>
                    <input id="kpr-dp" type="number" min="0" value="400000000" 
                           class="w-full h-[52px] border border-brand-line rounded-xl pl-12 pr-4 text-[15px] font-bold text-brand-navy transition-all hover:border-brand-blue/50 focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10 outline-none">
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-brand-navy text-[13px] font-extrabold">Jangka Waktu</label>
                    <div class="relative">
                        <input id="kpr-years" type="number" min="1" max="30" value="15" 
                               class="w-full h-[52px] border border-brand-line rounded-xl pl-4 pr-16 text-[15px] font-bold text-brand-navy transition-all hover:border-brand-blue/50 focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10 outline-none">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-brand-muted font-bold text-[13px]">Tahun</div>
                    </div>
                </div>
                <div>
                    <label class="block mb-2 text-brand-navy text-[13px] font-extrabold">Suku Bunga / Tahun</label>
                    <div class="relative">
                        <input id="kpr-rate" type="number" min="0" step="0.1" value="6.5" 
                               class="w-full h-[52px] border border-brand-line rounded-xl pl-4 pr-12 text-[15px] font-bold text-brand-navy transition-all hover:border-brand-blue/50 focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/10 outline-none">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-brand-muted font-bold text-[15px]">%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Result Card -->
    <div class="sticky top-24 rounded-3xl bg-gradient-to-br from-brand-navy via-[#002277] to-brand-navy text-white p-8 lg:p-10 shadow-2xl relative overflow-hidden group">
        <!-- Abstract Decoration (Like a premium credit card) -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none group-hover:bg-brand-blue/20 transition-all duration-700"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-purple-500/10 rounded-full blur-2xl -ml-10 -mb-10 pointer-events-none"></div>

        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-[14px] font-black tracking-wide text-white/90">HASIL SIMULASI</div>
            </div>
            
            <div class="mb-6 bg-white/5 p-4 rounded-2xl border border-white/10">
                <div class="text-[12px] font-bold text-white/70 uppercase tracking-wider mb-1">Jumlah Pinjaman Pokok</div>
                <div id="kpr-loan-amount" class="text-[24px] font-black tracking-tight text-white">Rp 1.600.000.000</div>
            </div>
            
            <div class="mb-8">
                <div class="text-[12px] font-bold text-brand-blue2 uppercase tracking-wider mb-2">Estimasi Angsuran / Bulan</div>
                <div id="kpr-monthly" class="text-[36px] min-[900px]:text-[42px] font-black tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-white to-blue-100 drop-shadow-sm">
                    Rp 0
                </div>
            </div>
            
            <a href="https://wa.me/<?php echo e(setting('whatsapp_number', '6281112345678')); ?>" target="_blank" rel="noopener" 
               class="w-full flex items-center justify-center gap-2 h-[56px] rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-400 hover:from-emerald-400 hover:to-emerald-300 text-brand-navy font-black text-[15px] shadow-[0_0_20px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] transition-all active:scale-[0.98]">
                Ajukan KPR Sekarang
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
            
            <p class="mt-5 text-[11px] font-medium text-white/50 leading-relaxed text-center">
                *Simulasi ini hanya perkiraan kasar. Perhitungan akhir sepenuhnya mengikuti suku bunga dan kebijakan bank terkait saat persetujuan.
            </p>
        </div>
    </div>
</section>

<!-- Bank Partners Section -->
<section class="max-w-[1280px] mx-auto px-8 mt-20">
    <div class="text-center mb-10">
        <span class="inline-block px-3 py-1 bg-brand-soft text-brand-blue font-extrabold text-[11px] uppercase tracking-wider rounded-lg mb-3">Mitra Kami</span>
        <h2 class="text-brand-navy text-[24px] font-black mb-2">Bank Rekanan MaxinPro</h2>
        <p class="text-brand-muted text-[14px] font-medium max-w-lg mx-auto">Kami bekerja sama dengan berbagai bank terkemuka di Indonesia untuk memastikan proses pengajuan KPR Anda mudah, cepat, dan tanpa biaya siluman.</p>
    </div>
    
    <div class="flex items-center justify-center gap-4 flex-wrap max-w-4xl mx-auto">
        <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="px-6 py-3 bg-white border border-brand-line/50 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 hover:border-brand-blue/30 transition-all cursor-default">
                <span class="text-brand-navy text-[14px] font-extrabold tracking-wide"><?php echo e($bank); ?></span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>

<!-- Requirements Section -->
<section class="max-w-[1000px] mx-auto px-8 mt-24 mb-20">
    <div class="text-center mb-10">
        <h2 class="text-brand-navy text-[24px] font-black mb-2">Syarat Pengajuan KPR</h2>
        <p class="text-brand-muted text-[14px] font-medium">Siapkan dokumen-dokumen berikut sebelum Anda mengajukan proses KPR.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Personal Docs -->
        <div class="bg-white rounded-3xl p-8 shadow-soft border border-brand-line/50 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4"></div>
            
            <div class="flex items-center gap-3 mb-6 relative z-10">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-brand-blue flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <strong class="text-brand-navy text-[16px] font-black">Data Pribadi</strong>
            </div>
            
            <ul class="space-y-4 relative z-10">
                <?php $__currentLoopData = $personalDocs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-blue-50 text-brand-blue flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-[#3a455e] text-[14px] font-medium leading-relaxed"><?php echo e($doc); ?></span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        
        <!-- Income Docs -->
        <div class="bg-white rounded-3xl p-8 shadow-soft border border-brand-line/50 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4"></div>
            
            <div class="flex items-center gap-3 mb-6 relative z-10">
                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <strong class="text-brand-navy text-[16px] font-black">Data Penghasilan</strong>
            </div>
            
            <ul class="space-y-4 relative z-10">
                <?php $__currentLoopData = $incomeDocs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-[#3a455e] text-[14px] font-medium leading-relaxed"><?php echo e($doc); ?></span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views\kpr\index.blade.php ENDPATH**/ ?>