<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Pojok UMKM Wonogiri')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#FAF9F6] text-slate-900 antialiased overflow-hidden selection:bg-[#800000] selection:text-white">
    <div class="flex h-screen w-full relative">
        <!-- Mobile Sidebar Backdrop -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/50 z-30 lg:hidden hidden transition-opacity opacity-0"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-[#800000] text-white flex flex-col transition-transform duration-300 z-40 fixed inset-y-0 left-0 lg:relative lg:translate-x-0 h-full shrink-0 shadow-xl -translate-x-full">
            <!-- Logo Area -->
            <div class="flex items-center justify-between px-6 py-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-lg p-1 shadow-sm flex items-center justify-center shrink-0">
                        <img src="{{ asset('images/logo-wonogiri.png') }}" alt="Logo Wonogiri" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="font-bold text-sm tracking-wide leading-tight">Pojok UMKM</h1>
                        <p class="text-[10px] text-white/70">Wonogiri Admin</p>
                    </div>
                </div>
                <button id="sidebarCloseBtn" class="lg:hidden text-white/70 hover:text-white p-1 rounded-md hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-[#600000] text-white font-medium border border-white/10' : 'text-white/70 hover:bg-white/5 hover:text-white' }} text-sm transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.products') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.products') ? 'bg-[#600000] text-white font-medium border border-white/10' : 'text-white/70 hover:bg-white/5 hover:text-white' }} text-sm transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.products') ? 'text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Kelola Produk
                </a>
                <a href="{{ route('admin.stores') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.stores') ? 'bg-[#600000] text-white font-medium border border-white/10' : 'text-white/70 hover:bg-white/5 hover:text-white' }} text-sm transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.stores') ? 'text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Data UMKM
                </a>
                <a href="{{ route('admin.consultations') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.consultations') ? 'bg-[#600000] text-white font-medium border border-white/10' : 'text-white/70 hover:bg-white/5 hover:text-white' }} text-sm transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.consultations') ? 'text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Kelola Konsultasi
                </a>
                <a href="{{ route('admin.verifications') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.verifications') ? 'bg-[#600000] text-white font-medium border border-white/10' : 'text-white/70 hover:bg-white/5 hover:text-white' }} text-sm transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.verifications') ? 'text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Verifikasi Data
                </a>
                
                <div class="pt-4 pb-1">
                    <p class="px-3 text-[10px] font-semibold text-white/40 uppercase tracking-wider">Lainnya</p>
                </div>
                
                <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.reports') ? 'bg-[#600000] text-white font-medium border border-white/10' : 'text-white/70 hover:bg-white/5 hover:text-white' }} text-sm transition-colors mt-6">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.reports') ? 'text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Laporan
                </a>
                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.settings') ? 'bg-[#600000] text-white font-medium border border-white/10' : 'text-white/70 hover:bg-white/5 hover:text-white' }} text-sm transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.settings') ? 'text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Pengaturan
                </a>
            </nav>

            <!-- User Profile (Bottom) -->
            <div class="p-4 border-t border-white/10 bg-black/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center overflow-hidden shrink-0 border border-white/20">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Yusuf Wijaya') }}&background=800000&color=fff" alt="User Avatar" class="w-full h-full object-cover">
                    </div>
                    <div class="overflow-hidden flex-1">
                        <p class="text-sm font-semibold truncate">{{ auth()->user()->name ?? 'Yusuf Wijaya' }}</p>
                        <p class="text-[10px] text-white/60 truncate">Admin</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                        @csrf
                        <button type="submit" class="p-1.5 text-white/50 hover:text-red-300 hover:bg-white/10 rounded-md transition-colors" title="Logout">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 bg-[#FAF9F6] lg:w-full">
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-slate-200/80 flex items-center justify-between px-4 lg:px-10 shrink-0 z-10 shadow-sm">
                <div class="flex items-center gap-3">
                    <button id="sidebarToggleBtn" class="lg:hidden p-2 text-slate-600 hover:text-[#800000] hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h2 class="text-lg lg:text-xl font-bold text-slate-800 tracking-tight truncate max-w-[200px] sm:max-w-xs md:max-w-md">@yield('page_title', 'Dashboard Pojok UMKM Wonogiri')</h2>
                </div>
                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-slate-400 hover:text-[#800000] hover:bg-red-50 rounded-full transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                    </button>
                    <div class="h-6 w-px bg-slate-200 mx-1"></div>
                    <div class="w-8 h-8 rounded-full bg-slate-200 border border-slate-300 overflow-hidden cursor-pointer hover:ring-2 hover:ring-[#800000]/30 transition-all">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Yusuf Wijaya') }}&background=800000&color=fff" alt="User Avatar" class="w-full h-full object-cover">
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-6 lg:p-8 relative">
                <!-- Background decoration -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-red-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
                
                <div class="relative z-10 max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarBackdrop.classList.remove('hidden');
                setTimeout(() => sidebarBackdrop.classList.remove('opacity-0'), 10);
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarBackdrop.classList.add('opacity-0');
                setTimeout(() => sidebarBackdrop.classList.add('hidden'), 300);
            }

            if(sidebarToggleBtn) sidebarToggleBtn.addEventListener('click', openSidebar);
            if(sidebarCloseBtn) sidebarCloseBtn.addEventListener('click', closeSidebar);
            if(sidebarBackdrop) sidebarBackdrop.addEventListener('click', closeSidebar);
        });
    </script>
    @stack('scripts')
</body>
</html>
