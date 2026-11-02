<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Pojok UMKM Kabupaten Wonogiri - Direktori dan Katalog UMKM Resmi">

    <title>{{ config('app.name', 'Pojok UMKM Wonogiri') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom animations & utilities */
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(90deg, #800000, #b30000);
        }
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-scale:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -10px rgba(128, 0, 0, 0.15);
        }

        /* Animasi Muncul Perlahan (Global) */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }
        .delay-500 { transition-delay: 500ms; }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900 scroll-smooth">
    
    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white text-slate-800 shadow-sm transition-all duration-300 border-b border-slate-100" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4 xl:gap-6">
                <!-- Brand / Logo (Left) -->
                <div class="flex items-center shrink-0">
                    <a href="/" class="flex items-center gap-2.5 sm:gap-3 group shrink-0">
                        <img src="{{ asset('img/kukm_wonogiri.png') }}" class="w-9 h-9 sm:w-10 sm:h-10 object-contain group-hover:scale-105 transition-transform" alt="Logo Wonogiri">
                        <div class="flex flex-col text-left">
                            <span class="text-lg sm:text-xl font-black text-[#991b1b] leading-tight tracking-tight">Pojok UMKM</span>
                            <span class="text-[10px] sm:text-xs text-slate-500 font-medium">Kabupaten Wonogiri</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links (Center Desktop - Balanced & Harmonious) -->
                <div class="hidden lg:flex items-center justify-center shrink-0">
                    <div class="flex items-center gap-1 xl:gap-2">
                        <a href="/" class="px-2.5 xl:px-3.5 py-1.5 rounded-xl text-xs xl:text-sm transition-all duration-200 {{ request()->is('/') ? 'bg-red-50 text-[#991b1b] font-bold shadow-2xs border border-red-100/70' : 'text-slate-600 hover:text-[#991b1b] hover:bg-slate-100/80 font-medium' }}">
                            Beranda
                        </a>
                        <a href="/katalog" class="px-2.5 xl:px-3.5 py-1.5 rounded-xl text-xs xl:text-sm transition-all duration-200 {{ request()->is('katalog*') ? 'bg-red-50 text-[#991b1b] font-bold shadow-2xs border border-red-100/70' : 'text-slate-600 hover:text-[#991b1b] hover:bg-slate-100/80 font-medium' }}">
                            Produk Unggulan
                        </a>
                        <a href="/direktori" class="px-2.5 xl:px-3.5 py-1.5 rounded-xl text-xs xl:text-sm transition-all duration-200 {{ request()->is('direktori*') ? 'bg-red-50 text-[#991b1b] font-bold shadow-2xs border border-red-100/70' : 'text-slate-600 hover:text-[#991b1b] hover:bg-slate-100/80 font-medium' }}">
                            Direktori UMKM
                        </a>
                        <a href="/panduan" class="px-2.5 xl:px-3.5 py-1.5 rounded-xl text-xs xl:text-sm transition-all duration-200 {{ request()->is('panduan*') ? 'bg-red-50 text-[#991b1b] font-bold shadow-2xs border border-red-100/70' : 'text-slate-600 hover:text-[#991b1b] hover:bg-slate-100/80 font-medium' }}">
                            Info & Panduan
                        </a>
                        <a href="/konsultasi" class="px-2.5 xl:px-3.5 py-1.5 rounded-xl text-xs xl:text-sm transition-all duration-200 {{ request()->is('konsultasi*') ? 'bg-red-50 text-[#991b1b] font-bold shadow-2xs border border-red-100/70' : 'text-slate-600 hover:text-[#991b1b] hover:bg-slate-100/80 font-medium' }}">
                            Konsultasi
                        </a>
                        <a href="/informasi" class="px-2.5 xl:px-3.5 py-1.5 rounded-xl text-xs xl:text-sm transition-all duration-200 {{ request()->is('informasi*') ? 'bg-red-50 text-[#991b1b] font-bold shadow-2xs border border-red-100/70' : 'text-slate-600 hover:text-[#991b1b] hover:bg-slate-100/80 font-medium' }}">
                            Informasi
                        </a>
                        <a href="{{ request()->is('/') ? '#statistik-agregat' : '/#statistik-agregat' }}" class="px-2.5 xl:px-3.5 py-1.5 rounded-xl text-xs xl:text-sm font-medium text-slate-600 hover:text-[#991b1b] hover:bg-slate-100/80 transition-all duration-200">
                            Statistik
                        </a>
                        <a href="#kontak" onclick="event.preventDefault(); document.getElementById('kontak')?.scrollIntoView({behavior: 'smooth'}); history.pushState(null, null, '#kontak');" class="px-2.5 xl:px-3.5 py-1.5 rounded-xl text-xs xl:text-sm font-medium text-slate-600 hover:text-[#991b1b] hover:bg-slate-100/80 transition-all duration-200 cursor-pointer">
                            Kontak
                        </a>
                    </div>
                </div>

                <!-- Auth Action Button & Mobile Toggle (Right) -->
                <div class="flex items-center justify-end shrink-0 space-x-3">
                    <div class="hidden sm:flex items-center space-x-3">
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-[#991b1b] px-3 py-2 transition-colors">Dashboard Admin</a>
                            @else
                                <a href="{{ route('toko.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#991b1b] px-3 py-2 transition-colors">UMKM</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-sm font-semibold transition-colors">Keluar</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="bg-[#991b1b] hover:bg-[#800000] text-white px-6 py-2 rounded-xl text-sm font-semibold shadow-xs hover:shadow transition-all hover:-translate-y-0.5">
                                Login
                            </a>
                        @endauth
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <div class="flex lg:hidden items-center gap-2">
                        @guest
                        <a href="{{ route('login') }}" class="bg-[#a31d1d] text-white px-3.5 py-1.5 rounded-lg text-xs font-semibold sm:hidden">
                            Login
                        </a>
                        @endguest
                        <button id="mobile-menu-btn" class="text-slate-700 hover:text-[#991b1b] focus:outline-none p-2 rounded-lg hover:bg-slate-100 transition-colors" aria-label="Buka Menu">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown (App-style Elegant Navigation) -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white/95 backdrop-blur-md border-t border-slate-100 shadow-xl transition-all duration-300">
            <div class="px-4 pt-3 pb-6 space-y-1.5">
                <a href="/" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->is('/') ? 'bg-red-50 text-[#991b1b] shadow-2xs border border-red-100' : 'text-slate-700 hover:bg-slate-50' }}">
                    <svg class="w-4 h-4 {{ request()->is('/') ? 'text-[#991b1b]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Beranda</span>
                </a>
                <a href="/katalog" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->is('katalog*') ? 'bg-red-50 text-[#991b1b] shadow-2xs border border-red-100' : 'text-slate-700 hover:bg-slate-50' }}">
                    <svg class="w-4 h-4 {{ request()->is('katalog*') ? 'text-[#991b1b]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span>Produk Unggulan</span>
                </a>
                <a href="/direktori" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->is('direktori*') ? 'bg-red-50 text-[#991b1b] shadow-2xs border border-red-100' : 'text-slate-700 hover:bg-slate-50' }}">
                    <svg class="w-4 h-4 {{ request()->is('direktori*') ? 'text-[#991b1b]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Direktori UMKM</span>
                </a>
                <a href="/panduan" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->is('panduan*') ? 'bg-red-50 text-[#991b1b] shadow-2xs border border-red-100' : 'text-slate-700 hover:bg-slate-50' }}">
                    <svg class="w-4 h-4 {{ request()->is('panduan*') ? 'text-[#991b1b]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    <span>Info & Panduan</span>
                </a>
                <a href="/konsultasi" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->is('konsultasi*') ? 'bg-red-50 text-[#991b1b] shadow-2xs border border-red-100' : 'text-slate-700 hover:bg-slate-50' }}">
                    <svg class="w-4 h-4 {{ request()->is('konsultasi*') ? 'text-[#991b1b]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <span>Konsultasi</span>
                </a>
                <a href="/informasi" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->is('informasi*') ? 'bg-red-50 text-[#991b1b] shadow-2xs border border-red-100' : 'text-slate-700 hover:bg-slate-50' }}">
                    <svg class="w-4 h-4 {{ request()->is('informasi*') ? 'text-[#991b1b]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2"/></svg>
                    <span>Informasi</span>
                </a>
                <a href="{{ request()->is('/') ? '#statistik-agregat' : '/#statistik-agregat' }}" onclick="document.getElementById('mobile-menu')?.classList.add('hidden');" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>Statistik</span>
                </a>
                <a href="#kontak" onclick="document.getElementById('mobile-menu')?.classList.add('hidden'); document.getElementById('kontak')?.scrollIntoView({behavior: 'smooth'}); history.pushState(null, null, '#kontak');" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all cursor-pointer">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Kontak</span>
                </a>
                @auth
                <div class="pt-3 border-t border-slate-100 flex flex-col gap-1.5">
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            <span>Dashboard Admin</span>
                        </a>
                    @else
                        <a href="{{ route('toko.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            <span>Kelola Toko UMKM</span>
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 text-left px-3.5 py-2 rounded-xl text-xs text-red-600 font-bold hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20 min-h-screen">
        @yield('content')
    </main>

    <!-- Footer matching Figma -->
    <footer id="kontak" class="bg-[#801414] text-white pt-14 pb-8 border-t border-red-900/30 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 mb-10">
                
                <!-- Col 1: Brand & Contact -->
                <div class="md:col-span-6 lg:col-span-4">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-[#eab308] text-white flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25c-.669 0-1.189-.578-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-base font-extrabold text-white leading-tight tracking-tight">Pojok UMKM Wonogiri</div>
                            <div class="text-[11px] text-red-100 font-medium leading-tight">Dinas Koperasi, Usaha Mikro Kecil Menengah & Perindustrian Perdagangan</div>
                        </div>
                    </div>
                    
                    <p class="text-xs text-red-100/90 leading-relaxed mb-4 max-w-md">
                        Layanan resmi fasilitasi, kurasi, promosi, dan konsultasi terpadu bagi pelaku usaha kecil, mikro, dan menengah di Kabupaten Wonogiri.
                    </p>

                    <div class="space-y-2 text-xs text-red-100/90">
                        <div class="flex items-start gap-2">
                            <svg class="w-3.5 h-3.5 text-[#facc15] shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            </svg>
                            <span>Jalan RM. Said No. 03, Joho, Wonogiri, Pancuran, Kaliancar, Kec. Selogiri, Kabupaten Wonogiri, Jawa Tengah 57652</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-[#facc15] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                            </svg>
                            <span>(0273) 321044 / +62 812-3456-7890</span>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Menu Pintas -->
                <div class="md:col-span-6 lg:col-span-2">
                    <h4 class="text-sm font-bold text-[#facc15] mb-4 tracking-wide">Menu Pintas</h4>
                    <ul class="space-y-2 text-xs text-red-100/90 font-medium">
                        <li><a href="/katalog" class="hover:text-[#facc15] transition-colors">Katalog Produk</a></li>
                        <li><a href="/direktori" class="hover:text-[#facc15] transition-colors">Direktori UMKM</a></li>
                        <li><a href="/konsultasi" class="hover:text-[#facc15] transition-colors">Konsultasi Online</a></li>
                        <li><a href="/informasi" class="hover:text-[#facc15] transition-colors">Agenda Pelatihan</a></li>
                        <li><a href="/konsultasi" class="hover:text-[#facc15] transition-colors">Sertifikasi Halal & PIRT</a></li>
                    </ul>
                </div>

                <!-- Col 3: Kecamatan Wonogiri & Socials -->
                <div class="md:col-span-6 lg:col-span-3">
                    <h4 class="text-sm font-bold text-[#facc15] mb-4 tracking-wide">Kecamatan Wonogiri</h4>
                    <p class="text-xs text-red-100/90 leading-relaxed mb-5">
                        Membina potensi UMKM di seluruh 25 Kecamatan Kabupaten Wonogiri secara merata dan berkelanjutan menuju go-digital.
                    </p>
                    
                    <!-- Social icons in circular dark red buttons -->
                    <div class="flex items-center gap-2.5">
                        <a href="#" class="w-8 h-8 rounded-full bg-[#5c0f0f] hover:bg-[#480a0a] text-white flex items-center justify-center transition-all shadow-xs" aria-label="Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-[#5c0f0f] hover:bg-[#480a0a] text-white flex items-center justify-center transition-all shadow-xs" aria-label="Instagram">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-[#5c0f0f] hover:bg-[#480a0a] text-white flex items-center justify-center transition-all shadow-xs" aria-label="Twitter">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-[#5c0f0f] hover:bg-[#480a0a] text-white flex items-center justify-center transition-all shadow-xs" aria-label="YouTube">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Col 4: Maps -->
                <div class="md:col-span-6 lg:col-span-3">
                    <h4 class="text-sm font-bold text-[#facc15] mb-4 tracking-wide">Lokasi Kami</h4>
                    <div class="rounded-xl overflow-hidden shadow-lg border border-red-900/50 hover:shadow-xl transition-shadow duration-300 w-full">
                        <iframe src="https://maps.google.com/maps?q=Dinas+Koperasi,+Usaha+Kecil+Dan+Menengah+Dan+Perindustrian+Dan+Perdagangan+Kabupaten+Wonogiri&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="180" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright bar matching Figma -->
            <div class="border-t border-white/10 pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-red-100/75 gap-3">
                <p>Dinas Perdagangan dan KUKM Kabupaten Wonogiri. All Rights Reserved.</p>
                <div class="text-[#facc15] font-semibold">
                    Wonogiri Sukses &bull; Maju Bersama UMKM
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navbar shadow on scroll
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 10) {
                nav.classList.add('shadow-md');
            } else {
                nav.classList.remove('shadow-md');
            }
        });

        // Mobile menu toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        
        if (btn && menu) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        }

        // Global Intersection Observer for animations
        document.addEventListener('DOMContentLoaded', function() {
            const reveals = document.querySelectorAll('.reveal');
            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target); 
                    }
                });
            }, { threshold: 0.1 });

            reveals.forEach(reveal => {
                revealObserver.observe(reveal);
            });

            // Auto-scroll to #kontak if hash is present in URL
            if (window.location.hash === '#kontak') {
                setTimeout(() => {
                    document.getElementById('kontak')?.scrollIntoView({ behavior: 'smooth' });
                }, 200);
            }
        });
    </script>
    @stack('scripts')
<!--  --></body>
</html>
