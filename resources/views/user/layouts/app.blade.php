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
<body class="font-sans antialiased bg-red-50 text-slate-900 scroll-smooth">
    
    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-[#800000] text-white shadow-lg transition-all duration-300 border-b border-red-900" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-2 text-2xl font-bold text-white hover:text-red-200 transition-colors">
                        <img src="{{ asset('img/kukm_wonogiri.png') }}" class="w-8 h-8" alt="Logo">
                        Pojok UMKM
                    </a>
                    
                    <div class="hidden md:flex ml-10 space-x-8 items-center">
                        <a href="/" class="{{ request()->is('/') ? 'text-white font-bold' : 'text-red-200 hover:text-white font-medium transition-colors' }}">Beranda</a>
                        <a href="/katalog" class="{{ request()->is('katalog*') ? 'text-white font-bold' : 'text-red-200 hover:text-white font-medium transition-colors' }}">Katalog Produk</a>
                        <a href="/direktori" class="{{ request()->is('direktori*') ? 'text-white font-bold' : 'text-red-200 hover:text-white font-medium transition-colors' }}">Direktori UMKM</a>
                        <a href="/informasi" class="{{ request()->is('informasi*') ? 'text-white font-bold' : 'text-red-200 hover:text-white font-medium transition-colors' }}">Informasi</a>
                        <a href="/konsultasi" class="{{ request()->is('konsultasi*') ? 'text-white font-bold' : 'text-red-200 hover:text-white font-medium transition-colors' }}">Konsultasi</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-red-100 hover:text-white font-medium px-3 py-2">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-100 hover:text-white font-medium px-3 py-2">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-red-100 hover:text-white font-medium px-3 py-2 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="hidden md:inline-block bg-white text-[#800000] px-5 py-2.5 rounded-full font-bold hover:bg-red-50 transition-colors shadow-lg active:scale-95">Daftar UMKM</a>
                    @endauth
                    
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden text-white hover:text-red-200 focus:outline-none ml-2">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden bg-[#700000] border-t border-red-900">
            <div class="px-4 pt-2 pb-4 space-y-1 shadow-inner">
                <a href="/" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('/') ? 'bg-red-900 text-white' : 'text-red-100 hover:bg-red-800 hover:text-white' }}">Beranda</a>
                <a href="/katalog" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('katalog*') ? 'bg-red-900 text-white' : 'text-red-100 hover:bg-red-800 hover:text-white' }}">Katalog Produk</a>
                <a href="/direktori" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('direktori*') ? 'bg-red-900 text-white' : 'text-red-100 hover:bg-red-800 hover:text-white' }}">Direktori UMKM</a>
                <a href="/informasi" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('informasi*') ? 'bg-red-900 text-white' : 'text-red-100 hover:bg-red-800 hover:text-white' }}">Informasi</a>
                <a href="/konsultasi" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('konsultasi*') ? 'bg-red-900 text-white' : 'text-red-100 hover:bg-red-800 hover:text-white' }}">Konsultasi</a>
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
