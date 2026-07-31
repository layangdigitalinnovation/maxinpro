<?php
    $navLinks = [
        ['label' => 'Beranda', 'route' => 'home'],
        ['label' => 'Listing', 'route' => 'listings.index'],
        ['label' => 'Titip Properti', 'route' => 'titip-properti.create'],
        ['label' => '(Project)', 'route' => 'projects.index'],
        ['label' => 'KPR', 'route' => 'kpr.index'],
        ['label' => 'About', 'route' => 'about.index'],
    ];
?>
<header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-brand-line">
    <div class="max-w-[1280px] mx-auto px-8 h-[76px] flex items-center justify-between gap-6 relative">
        <div class="flex-1 flex items-center">
            <a href="<?php echo e(route('home')); ?>" class="flex items-center shrink-0">
                <img src="<?php echo e(asset('images/logo-cropped.png')); ?>" alt="MaxinPro" class="h-[46px] w-auto mix-blend-multiply">
            </a>
        </div>

        <nav class="hidden min-[900px]:flex items-center justify-center gap-8">
            <?php $__currentLoopData = $navLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route($link['route'])); ?>"
                   class="text-[13px] font-extrabold pb-1.5 border-b-2 transition-colors <?php echo e(request()->routeIs($link['route']) ? 'text-brand-blue border-brand-blue' : 'text-brand-navy border-transparent hover:text-brand-blue'); ?>">
                    <?php echo e($link['label']); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>

        <div class="flex-1 flex items-center justify-end gap-3">
            <a href="https://wa.me/<?php echo e(setting('whatsapp_number', '6281112345678')); ?>" target="_blank" rel="noopener"
               class="hidden min-[900px]:inline-flex items-center gap-2 h-11 px-5 rounded-[10px] bg-brand-blue text-white text-[13px] font-extrabold shadow-[0_14px_26px_rgba(0,87,255,.24)]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Hubungi Kami
            </a>

            <?php if(auth()->guard()->check()): ?>
                <div class="hidden min-[900px]:flex items-center gap-3 text-[13px] font-bold text-brand-navy">
                    <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>">Panel Admin</a>
                    <?php elseif(auth()->user()->isAgent()): ?>
                        <a href="<?php echo e(route('agent.dashboard')); ?>">Panel Agen</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('account.saved-listings.index')); ?>">Favorit Saya</a>
                    <?php endif; ?>
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-brand-muted hover:text-brand-navy">Keluar</button>
                    </form>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="hidden min-[900px]:inline-flex text-[13px] font-bold text-brand-navy">Masuk</a>
            <?php endif; ?>

            <button id="mobile-nav-toggle" type="button" aria-label="Menu" class="min-[900px]:hidden w-10 h-10 grid place-items-center rounded-lg border border-brand-line">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    <div id="mobile-nav-panel" class="hidden min-[900px]:hidden border-t border-brand-line bg-white px-8 py-4">
        <div class="flex flex-col gap-3">
            <?php $__currentLoopData = $navLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route($link['route'])); ?>" class="text-[14px] font-bold <?php echo e(request()->routeIs($link['route']) ? 'text-brand-blue' : 'text-brand-navy'); ?>">
                    <?php echo e($link['label']); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="h-px bg-brand-line my-2"></div>

            <?php if(auth()->guard()->check()): ?>
                <div class="flex flex-col gap-2">
                    <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="inline-flex items-center justify-center h-11 rounded-[10px] bg-brand-blue/10 text-brand-blue text-[13px] font-extrabold">Panel Admin</a>
                    <?php elseif(auth()->user()->isAgent()): ?>
                        <a href="<?php echo e(route('agent.dashboard')); ?>" class="inline-flex items-center justify-center h-11 rounded-[10px] bg-brand-blue/10 text-brand-blue text-[13px] font-extrabold">Panel Agen</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('account.saved-listings.index')); ?>" class="inline-flex items-center justify-center h-11 rounded-[10px] bg-brand-blue/10 text-brand-blue text-[13px] font-extrabold">Favorit Saya</a>
                    <?php endif; ?>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="flex flex-col">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="inline-flex items-center justify-center h-11 rounded-[10px] border border-brand-line text-brand-muted text-[13px] font-extrabold w-full">Keluar</button>
                    </form>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center justify-center h-11 rounded-[10px] border-2 border-brand-blue text-brand-blue text-[13px] font-extrabold">Masuk</a>
            <?php endif; ?>

            <a href="https://wa.me/<?php echo e(setting('whatsapp_number', '6281112345678')); ?>" target="_blank" rel="noopener" class="mt-2 inline-flex items-center justify-center h-11 rounded-[10px] bg-gradient-to-r from-[#0069ff] to-[#004de7] text-white text-[13px] font-extrabold">
                Hubungi Kami
            </a>
        </div>
    </div>
</header>
<?php /**PATH D:\Layang\maxinpro.com\resources\views\partials\header.blade.php ENDPATH**/ ?>