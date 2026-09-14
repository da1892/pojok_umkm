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
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900 scroll-smooth">
    
    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white text-slate-800 shadow-sm transition-all duration-300 border-b border-slate-100" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Brand / Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-3 group">
                        <img src="{{ asset('img/kukm_wonogiri.png') }}" class="w-10 h-10 object-contain group-hover:scale-105 transition-transform" alt="Logo Wonogiri">
                        <div class="flex flex-col text-left">
                            <span class="text-xl font-black text-[#991b1b] leading-tight tracking-tight">Pojok UMKM</span>
                            <span class="text-xs text-slate-500 font-medium">Kabupaten Wonogiri</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links (Center/Right Desktop) -->
                <div class="hidden lg:flex items-center space-x-7">
                    <a href="/" class="relative py-2 text-sm font-semibold {{ request()->is('/') ? 'text-[#991b1b] after:content-[\'\'] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#991b1b]' : 'text-slate-600 hover:text-[#991b1b] transition-colors' }}">
                        Beranda
                    </a>
                    <a href="/katalog" class="text-sm font-medium {{ request()->is('katalog*') ? 'text-[#991b1b] font-semibold' : 'text-slate-600 hover:text-[#991b1b] transition-colors' }}">
                        Produk Unggulan
                    </a>
                    <a href="/direktori" class="text-sm font-medium {{ request()->is('direktori*') ? 'text-[#991b1b] font-semibold' : 'text-slate-600 hover:text-[#991b1b] transition-colors' }}">
                        Direktori UMKM
                    </a>
                    <a href="/konsultasi" class="text-sm font-medium {{ request()->is('konsultasi*') ? 'text-[#991b1b] font-semibold' : 'text-slate-600 hover:text-[#991b1b] transition-colors' }}">
                        Konsultasi
                    </a>
                    <a href="/informasi" class="text-sm font-medium {{ request()->is('informasi*') ? 'text-[#991b1b] font-semibold' : 'text-slate-600 hover:text-[#991b1b] transition-colors' }}">
                        Informasi
                    </a>
                    <a href="#kontak" class="text-sm font-medium text-slate-600 hover:text-[#991b1b] transition-colors">
                        Kontak
                    </a>
                </div>

                <!-- Auth Action Button -->
                <div class="hidden sm:flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-[#991b1b] px-3 py-2 transition-colors">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-[#a31d1d] hover:bg-[#8b1818] text-white px-7 py-2 rounded-lg text-sm font-semibold shadow-sm transition-all hover:shadow hover:-translate-y-0.5">
                            Login
                        </a>
                    @endauth
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="flex lg:hidden items-center gap-2">
                    @guest
                    <a href="{{ route('login') }}" class="bg-[#a31d1d] text-white px-4 py-1.5 rounded-lg text-xs font-semibold sm:hidden">
                        Login
                    </a>
                    @endguest
                    <button id="mobile-menu-btn" class="text-slate-700 hover:text-[#991b1b] focus:outline-none p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-slate-100 shadow-xl">
            <div class="px-4 pt-3 pb-5 space-y-1.5">
                <a href="/" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->is('/') ? 'bg-red-50 text-[#991b1b]' : 'text-slate-700 hover:bg-slate-50' }}">Beranda</a>
                <a href="/katalog" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50">Produk Unggulan</a>
                <a href="/direktori" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50">Direktori UMKM</a>
                <a href="/konsultasi" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50">Konsultasi</a>
                <a href="/informasi" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50">Informasi</a>
                <a href="#kontak" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50">Kontak</a>
                @auth
                <div class="pt-2 border-t border-slate-100 flex flex-col gap-1">
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 font-medium">Keluar</button>
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

    <!-- Footer -->
    <footer class="bg-slate-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <a href="/" class="flex items-center gap-2 text-2xl font-bold text-white mb-4">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Pojok UMKM Wonogiri
                    </a>
                    <p class="text-slate-400 max-w-sm">Mewujudkan UMKM Kabupaten Wonogiri yang mandiri, inovatif, dan berdaya saing global melalui teknologi digital.</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2 text-slate-400">
                        <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Katalog Produk</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Konsultasi Bisnis</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <ul class="space-y-2 text-slate-400">
                        <li>Dinas Koperasi & UKM</li>
                        <li>Kabupaten Wonogiri</li>
                        <li>Email: info@umkmwonogiri.go.id</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-slate-500">
                <p>&copy; {{ date('Y') }} Pojok UMKM Kabupaten Wonogiri. Hak Cipta Dilindungi.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
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
        });
    </script>
</body>
</html>
