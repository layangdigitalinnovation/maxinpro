<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Panel MaxinPro'); ?></title>
    
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="<?php echo e(asset('favicon.png')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans bg-brand-soft min-h-screen">
    <?php $user = auth()->user(); ?>

    <div class="flex min-h-screen relative overflow-hidden min-[900px]:overflow-visible">
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-brand-navy/60 backdrop-blur-sm z-40 hidden opacity-0 transition-opacity duration-300 min-[900px]:hidden"></div>
        
        <aside id="sidebar" class="fixed inset-y-0 left-0 -translate-x-full min-[900px]:translate-x-0 transition-transform duration-300 z-50 w-64 bg-gradient-to-b from-brand-navy to-brand-ink text-white flex flex-col border-r border-brand-ink shadow-2xl min-[900px]:static min-[900px]:shadow-xl shrink-0">
            <div class="h-16 min-[900px]:h-[84px] flex items-center justify-between min-[900px]:justify-center px-6 border-b border-white/5 relative">
                <a href="<?php echo e(route('home')); ?>" class="transition-transform duration-300 hover:scale-105">
                    <img src="<?php echo e(asset('images/logo-cropped.png')); ?>" alt="MaxinPro" class="h-5 min-[900px]:h-6 object-contain grayscale invert contrast-200 mix-blend-screen opacity-90 hover:opacity-100">
                </a>
                <button id="close-sidebar-btn" class="min-[900px]:hidden text-white/50 hover:text-white p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1.5 text-[13px] font-bold overflow-y-auto custom-scrollbar">
                <?php if($user->isAdmin()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">Dashboard</a>
                    <a href="<?php echo e(route('admin.listings.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.listings.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">Listing</a>
                    <a href="<?php echo e(route('admin.projects.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.projects.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">Project</a>
                    <a href="<?php echo e(route('admin.leads.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.leads.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">Leads (Titip Properti)</a>
                    <a href="<?php echo e(route('admin.agents.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.agents.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">Agen</a>
                    <a href="<?php echo e(route('admin.areas.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.areas.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">Area</a>
                    <a href="<?php echo e(route('admin.developers.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.developers.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">Developer</a>
                    <a href="<?php echo e(route('admin.property-types.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.property-types.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">Tipe Properti</a>
                    <a href="<?php echo e(route('admin.articles.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.articles.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">Artikel</a>
                    <a href="<?php echo e(route('admin.testimonials.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.testimonials.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">Testimoni</a>
                    <a href="<?php echo e(route('admin.partner-banks.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.partner-banks.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">Bank Rekanan</a>
                    <a href="<?php echo e(route('admin.audit-logs.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.audit-logs.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">Audit Log</a>
                <?php elseif($user->isAgent()): ?>
                    <a href="<?php echo e(route('agent.dashboard')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('agent.dashboard') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">Dashboard</a>
                    <a href="<?php echo e(route('agent.listings.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('agent.listings.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">Listing Saya</a>
                <?php endif; ?>
            </nav>
            <div class="px-6 py-5 border-t border-white/5 bg-black/10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-brand-blue to-purple-500 flex items-center justify-center text-white font-black text-xs shadow-md">
                        <?php echo e(substr($user->name, 0, 1)); ?>

                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] font-bold truncate text-white"><?php echo e($user->name); ?></p>
                        <p class="text-[10px] font-medium text-white/50 uppercase tracking-wider"><?php echo e($user->role); ?></p>
                    </div>
                </div>
                <div class="space-y-2">
                    <a href="<?php echo e(route('account.password.edit')); ?>" class="block text-[12px] font-medium text-white/60 hover:text-white transition-colors">Ganti Kata Sandi</a>
                    <a href="<?php echo e(route('account.two-factor.show')); ?>" class="block text-[12px] font-medium text-white/60 hover:text-white transition-colors">Verifikasi Dua Langkah</a>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="pt-2">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full text-left text-[12px] font-bold text-red-400 hover:text-red-300 transition-colors">Keluar dari Sistem</button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
            <!-- Mobile Header -->
            <header class="min-[900px]:hidden bg-white h-16 shrink-0 flex items-center justify-between px-4 border-b border-brand-line shadow-sm sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    <button id="open-sidebar-btn" class="w-10 h-10 rounded-lg bg-brand-soft text-brand-navy flex items-center justify-center hover:bg-brand-line transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <img src="<?php echo e(asset('images/logo-cropped.png')); ?>" alt="MaxinPro" class="h-5 object-contain">
                </div>
                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-brand-blue to-purple-500 flex items-center justify-center text-white font-black text-xs shadow-md">
                    <?php echo e(substr($user->name, 0, 1)); ?>

                </div>
            </header>

            <main class="flex-1 bg-brand-soft shrink-0">
            <div class="max-w-5xl mx-auto px-6 min-[900px]:px-10 py-8">
                <?php if(session('success')): ?>
                    <div class="mb-5 rounded-lg bg-green-50 border border-green-200 text-green-800 text-[12.5px] font-bold px-4 py-3">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
            </main>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const openBtn = document.getElementById('open-sidebar-btn');
            const closeBtn = document.getElementById('close-sidebar-btn');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                // Small delay to allow display:block to apply before opacity transition
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                    overlay.classList.add('opacity-100');
                }, 10);
                document.body.style.overflow = 'hidden'; // Prevent body scroll
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.remove('opacity-100');
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300); // Wait for transition
                document.body.style.overflow = ''; // Restore scroll
            }

            if (openBtn) {
                openBtn.addEventListener('click', openSidebar);
            }
            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebar);
            }
            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }
        });
    </script>
</body>
</html>
<?php /**PATH D:\Layang\maxinpro.com\resources\views/backend/layout.blade.php ENDPATH**/ ?>