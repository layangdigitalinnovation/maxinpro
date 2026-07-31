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
    <style>
        /* Custom Toggle Switch */
        .custom-toggle { position: relative; display: inline-block; width: 44px; height: 24px; flex-shrink: 0; }
        .custom-toggle input { opacity: 0; width: 0; height: 0; }
        .custom-toggle .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ef4444; transition: .3s; border-radius: 24px; }
        .custom-toggle .slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 2px; bottom: 2px; background-color: white; transition: .3s; border-radius: 50%; box-shadow: 0 1px 3px rgba(0,0,0,0.3); }
        .custom-toggle input:checked + .slider { background-color: #22c55e; }
        .custom-toggle input:focus + .slider { box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.4); }
        .custom-toggle input:checked + .slider:before { transform: translateX(20px); }

        /* Custom Sleek Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #60a5fa; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3b82f6; }
    </style>
</head>
<body class="font-sans bg-brand-soft h-screen overflow-hidden">
    <?php $user = auth()->user(); ?>

    <div class="flex h-screen relative overflow-hidden">
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
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span class="text-[13px] font-medium">Dashboard</span>
                        </div>
                    </a>
                    <div>
                        <div class="px-3 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider mt-4">Manajemen Akses</div>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.users.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span class="text-[13px] font-medium">Pengguna</span>
                            </div>
                        </a>
                        <a href="<?php echo e(route('admin.roles.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.roles.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <span class="text-[13px] font-medium">Roles (Peran)</span>
                            </div>
                        </a>
                        <a href="<?php echo e(route('admin.permissions.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.permissions.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                <span class="text-[13px] font-medium">Permissions</span>
                            </div>
                        </a>
                    </div>
                    <div class="px-3 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider mt-4">Properti & Listing</div>
                    <a href="<?php echo e(route('admin.listings.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.listings.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span class="text-[13px] font-medium">Listing</span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('admin.projects.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.projects.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span class="text-[13px] font-medium">Project</span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('admin.leads.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.leads.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <span class="text-[13px] font-medium">Leads (Titip Properti)</span>
                        </div>
                    </a>

                    <div class="px-3 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider mt-4">Data Induk</div>
                    <a href="<?php echo e(route('admin.agents.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.agents.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span class="text-[13px] font-medium">Agen</span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('admin.areas.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.areas.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-[13px] font-medium">Area</span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('admin.developers.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.developers.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span class="text-[13px] font-medium">Developer</span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('admin.property-types.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.property-types.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span class="text-[13px] font-medium">Tipe Properti</span>
                        </div>
                    </a>

                    <div class="px-3 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider mt-4">Manajemen Konten</div>
                    <a href="<?php echo e(route('admin.articles.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.articles.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            <span class="text-[13px] font-medium">Artikel</span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('admin.testimonials.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.testimonials.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            <span class="text-[13px] font-medium">Testimoni</span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('admin.partner-banks.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.partner-banks.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            <span class="text-[13px] font-medium">Bank Rekanan</span>
                        </div>
                    </a>

                    <div class="px-3 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider mt-4">Sistem</div>
                    <a href="<?php echo e(route('admin.audit-logs.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.audit-logs.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            <span class="text-[13px] font-medium">Audit Log</span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('admin.settings.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.settings.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-[13px] font-medium">Pengaturan</span>
                        </div>
                    </a>
                <?php elseif($user->isAgent()): ?>
                    <a href="<?php echo e(route('agent.dashboard')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('agent.dashboard') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span class="text-[13px] font-medium">Dashboard</span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('agent.listings.index')); ?>" class="block px-3 py-2.5 rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('agent.listings.*') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-white/60 hover:text-white hover:bg-white/5'); ?>">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span class="text-[13px] font-medium">Listing Saya</span>
                        </div>
                    </a>
                <?php endif; ?>
            </nav>
            <div class="px-6 py-5 border-t border-white/5 bg-black/10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-brand-blue to-purple-500 flex items-center justify-center text-white font-black text-xs shadow-md">
                        <?php echo e(substr($user->name, 0, 1)); ?>

                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] font-bold truncate text-white"><?php echo e($user->name); ?></p>
                        <p class="text-[10px] font-medium text-white/50 uppercase tracking-wider"><?php echo e($user->roles->first()?->name ?? 'User'); ?></p>
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

        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto custom-scrollbar scroll-smooth">
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
<?php /**PATH D:\Layang\maxinpro.com\resources\views\backend\layout.blade.php ENDPATH**/ ?>