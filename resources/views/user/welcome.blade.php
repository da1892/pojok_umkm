@extends('layouts.app')

@section('content')

<!-- Hero Section with 3-Photo Animated Carousel Background -->
<div class="relative w-full overflow-hidden text-white flex items-center justify-center text-center pt-24 pb-28 sm:pt-28 sm:pb-32 md:pt-36 md:pb-36" id="hero-slider-section">
    
    <!-- Slide 1: Tugu Selamat Datang di Wonogiri -->
    <div class="hero-bg-slide absolute inset-0 transition-all duration-1000 ease-in-out opacity-100 scale-100 z-0"
         style="background: linear-gradient(rgba(80, 10, 10, 0.45), rgba(50, 8, 8, 0.65)), url('{{ asset('img/hero_wonogiri_1.jpg') }}') center center / cover no-repeat;">
    </div>

    <!-- Slide 2: Pasar Ngadirojo Wonogiri -->
    <div class="hero-bg-slide absolute inset-0 transition-all duration-1000 ease-in-out opacity-0 scale-105 z-0"
         style="background: linear-gradient(rgba(80, 10, 10, 0.45), rgba(50, 8, 8, 0.65)), url('{{ asset('img/hero_wonogiri_2.jpg') }}') center 25% / cover no-repeat;">
    </div>

    <!-- Slide 3: Pasar Kota Wonogiri -->
    <div class="hero-bg-slide absolute inset-0 transition-all duration-1000 ease-in-out opacity-0 scale-105 z-0"
         style="background: linear-gradient(rgba(80, 10, 10, 0.45), rgba(50, 8, 8, 0.65)), url('{{ asset('img/hero_wonogiri_3.jpg') }}') center 35% / cover no-repeat;">
    </div>

    <!-- Navigation Arrows -->
    <button type="button" onclick="prevHeroSlide()" class="absolute left-3 sm:left-6 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/30 hover:bg-black/50 text-white/90 hover:text-white flex items-center justify-center backdrop-blur-sm transition-all transform hover:scale-105" aria-label="Foto Sebelumnya">
        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
        </svg>
    </button>
    <button type="button" onclick="nextHeroSlide()" class="absolute right-3 sm:right-6 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/30 hover:bg-black/50 text-white/90 hover:text-white flex items-center justify-center backdrop-blur-sm transition-all transform hover:scale-105" aria-label="Foto Berikutnya">
        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
        </svg>
    </button>

    <!-- Content Overlay -->
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 reveal">
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4 tracking-tight leading-tight [text-shadow:_0_3px_12px_rgba(0,0,0,0.75)]">
            Pojok UMKM Kabupaten Wonogiri
        </h1>
        <p class="text-base sm:text-lg md:text-xl text-white/95 mb-10 max-w-2xl mx-auto leading-relaxed font-medium [text-shadow:_0_2px_8px_rgba(0,0,0,0.75)]">
            Wadah informasi resmi, kurasi, dan promosi produk unggulan UMKM Wonogiri sukses mendunia.
        </p>
        
        <!-- Action Buttons Matching Mockup -->
        <div class="flex flex-wrap items-center justify-center gap-4 mb-8">
            <a href="/katalog" class="inline-flex items-center gap-2.5 bg-[#eab308] hover:bg-[#facc15] text-[#78350f] font-bold text-sm sm:text-base px-6 sm:px-8 py-3.5 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-[#78350f]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
                Lihat Produk UMKM
            </a>
            <a href="{{ route('informasi') }}" class="inline-flex items-center justify-center border-2 border-white/80 hover:border-white hover:bg-white/10 text-white font-semibold text-sm sm:text-base px-6 sm:px-8 py-3.5 rounded-lg transition-all transform hover:-translate-y-0.5">
                Pelajari Program
            </a>
        </div>

        <!-- Slide Indicator Dots -->
        <div class="flex items-center justify-center gap-2.5 pt-1">
            <button type="button" onclick="setHeroSlide(0)" class="hero-dot w-8 h-2.5 rounded-full bg-white transition-all duration-300 shadow-sm" aria-label="Slide 1"></button>
            <button type="button" onclick="setHeroSlide(1)" class="hero-dot w-2.5 h-2.5 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-300 shadow-sm" aria-label="Slide 2"></button>
            <button type="button" onclick="setHeroSlide(2)" class="hero-dot w-2.5 h-2.5 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-300 shadow-sm" aria-label="Slide 3"></button>
        </div>
    </div>
</div>

<!-- 4 Cards Section (Mobile 2x2 grid, Desktop 4 columns) -->
<div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 relative z-20 mt-6 sm:mt-10 md:mt-14 mb-12 sm:mb-20 reveal delay-200">
    <div class="bg-white rounded-2xl sm:rounded-3xl p-3.5 sm:p-8 md:p-10 lg:p-12 shadow-sm border border-slate-200/80">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 md:gap-7 lg:gap-8">
            
            <!-- Card 1: Profil UMKM -->
            <a href="{{ route('direktori') }}" class="bg-white rounded-xl sm:rounded-2xl p-3.5 sm:p-6 border border-slate-200/90 shadow-xs hover:shadow-lg hover:border-red-200 transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-start">
                <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-full bg-red-50 text-[#991b1b] flex items-center justify-center mb-3 sm:mb-5 group-hover:scale-105 group-hover:bg-[#991b1b] group-hover:text-white transition-all shadow-xs">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 12l-2 8 5.5-2.5 5.5 2.5-2-8" />
                    </svg>
                </div>
                <h3 class="text-xs sm:text-base font-bold text-slate-900 mb-1 group-hover:text-[#991b1b] transition-colors leading-snug">Profil UMKM</h3>
                <p class="text-[10px] sm:text-sm text-slate-500 leading-snug line-clamp-2">Kenali profil ribuan UMKM tangguh di seluruh pelosok Wonogiri.</p>
            </a>

            <!-- Card 2: Produk UMKM -->
            <a href="{{ route('katalog') }}" class="bg-white rounded-xl sm:rounded-2xl p-3.5 sm:p-6 border border-slate-200/90 shadow-xs hover:shadow-lg hover:border-red-200 transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-start">
                <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-full bg-red-50 text-[#991b1b] flex items-center justify-center mb-3 sm:mb-5 group-hover:scale-105 group-hover:bg-[#991b1b] group-hover:text-white transition-all shadow-xs">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25c-.669 0-1.189-.578-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </div>
                <h3 class="text-xs sm:text-base font-bold text-slate-900 mb-1 group-hover:text-[#991b1b] transition-colors leading-snug">Produk UMKM</h3>
                <p class="text-[10px] sm:text-sm text-slate-500 leading-snug line-clamp-2">Katalog kurasi produk lokal mulai kuliner hingga kriya bersertifikat.</p>
            </a>

            <!-- Card 3: Berita & Kegiatan -->
            <a href="{{ route('informasi') }}" class="bg-white rounded-xl sm:rounded-2xl p-3.5 sm:p-6 border border-slate-200/90 shadow-xs hover:shadow-lg hover:border-red-200 transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-start">
                <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-full bg-red-50 text-[#991b1b] flex items-center justify-center mb-3 sm:mb-5 group-hover:scale-105 group-hover:bg-[#991b1b] group-hover:text-white transition-all shadow-xs">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/>
                    </svg>
                </div>
                <h3 class="text-xs sm:text-base font-bold text-slate-900 mb-1 group-hover:text-[#991b1b] transition-colors leading-snug">Berita & Kegiatan</h3>
                <p class="text-[10px] sm:text-sm text-slate-500 leading-snug line-clamp-2">Informasi bazar, pameran, pelatihan, dan pemberdayaan terkini.</p>
            </a>

            <!-- Card 4: Info & Panduan -->
            <a href="{{ route('panduan') }}" class="bg-white rounded-xl sm:rounded-2xl p-3.5 sm:p-6 border border-slate-200/90 shadow-xs hover:shadow-lg hover:border-red-200 transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-start">
                <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-full bg-red-50 text-[#991b1b] flex items-center justify-center mb-3 sm:mb-5 group-hover:scale-105 group-hover:bg-[#991b1b] group-hover:text-white transition-all shadow-xs">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25h.01M12 11.25v4.5"/>
                    </svg>
                </div>
                <h3 class="text-xs sm:text-base font-bold text-slate-900 mb-1 group-hover:text-[#991b1b] transition-colors leading-snug">Info & Panduan</h3>
                <p class="text-[10px] sm:text-sm text-slate-500 leading-snug line-clamp-2">Panduan lengkap sertifikasi halal, PIRT, legalitas NIB gratis.</p>
            </a>

        </div>
    </div>
</div>

<!-- Seksi Eksplor Kategori & Produk Unggulan dengan Nuansa Visual Modern -->
<section class="py-8 sm:py-12 bg-gradient-to-b from-slate-50/70 via-white to-slate-50/70 relative overflow-hidden border-t border-slate-100">
    <!-- Ambient Glow Accent -->
    <div class="absolute top-1/4 -right-20 w-80 h-80 bg-red-100/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 -left-20 w-80 h-80 bg-amber-100/40 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Eksplor Kategori Produk -->
        <div id="kategori" class="mb-10 sm:mb-14 reveal delay-200">
            <div class="flex items-center justify-between mb-4 sm:mb-5">
                <div>
                    <span class="text-[11px] sm:text-xs font-extrabold uppercase tracking-widest text-[#991b1b]">Katalog Pilihan</span>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Eksplor Kategori Produk</h2>
                </div>
                <span class="text-xs font-semibold text-slate-400 sm:hidden flex items-center gap-1">
                    Geser 
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </span>
            </div>

            <!-- Category Chips with Icons & Color Tints -->
            <div class="flex items-center gap-2.5 sm:gap-3.5 overflow-x-auto pt-1 pb-3 -mx-4 px-4 sm:mx-0 sm:px-0 sm:flex-wrap scroll-smooth" style="scrollbar-width: none; -ms-overflow-style: none;">
                <!-- Makanan & Minuman -->
                <a href="/katalog?kategori=makanan" class="group inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white hover:bg-gradient-to-r hover:from-amber-500 hover:to-orange-500 text-slate-700 hover:text-white border border-slate-200/90 hover:border-transparent text-xs sm:text-sm font-bold shadow-2xs hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 shrink-0">
                    <span class="w-7 h-7 rounded-xl bg-amber-100 text-amber-700 group-hover:bg-white/20 group-hover:text-white flex items-center justify-center transition-colors">
                        🍲
                    </span>
                    <span>Makanan & Minuman</span>
                </a>

                <!-- Kerajinan -->
                <a href="/katalog?kategori=kerajinan" class="group inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white hover:bg-gradient-to-r hover:from-emerald-600 hover:to-teal-600 text-slate-700 hover:text-white border border-slate-200/90 hover:border-transparent text-xs sm:text-sm font-bold shadow-2xs hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 shrink-0">
                    <span class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-700 group-hover:bg-white/20 group-hover:text-white flex items-center justify-center transition-colors">
                        🪵
                    </span>
                    <span>Kerajinan</span>
                </a>

                <!-- Batik & Fashion -->
                <a href="/katalog?kategori=batik" class="group inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-600 text-slate-700 hover:text-white border border-slate-200/90 hover:border-transparent text-xs sm:text-sm font-bold shadow-2xs hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 shrink-0">
                    <span class="w-7 h-7 rounded-xl bg-purple-100 text-purple-700 group-hover:bg-white/20 group-hover:text-white flex items-center justify-center transition-colors">
                        👘
                    </span>
                    <span>Batik/Fashion</span>
                </a>

                <!-- Olahan Pertanian -->
                <a href="/katalog?kategori=pertanian" class="group inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white hover:bg-gradient-to-r hover:from-lime-600 hover:to-green-600 text-slate-700 hover:text-white border border-slate-200/90 hover:border-transparent text-xs sm:text-sm font-bold shadow-2xs hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 shrink-0">
                    <span class="w-7 h-7 rounded-xl bg-lime-100 text-lime-800 group-hover:bg-white/20 group-hover:text-white flex items-center justify-center transition-colors">
                        🌾
                    </span>
                    <span>Olahan Hasil Pertanian</span>
                </a>

                <!-- Produk Kreatif -->
                <a href="/katalog?kategori=kreatif" class="group inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white hover:bg-gradient-to-r hover:from-rose-600 hover:to-red-600 text-slate-700 hover:text-white border border-slate-200/90 hover:border-transparent text-xs sm:text-sm font-bold shadow-2xs hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 shrink-0">
                    <span class="w-7 h-7 rounded-xl bg-rose-100 text-rose-700 group-hover:bg-white/20 group-hover:text-white flex items-center justify-center transition-colors">
                        🎨
                    </span>
                    <span>Produk Kreatif</span>
                </a>
            </div>
        </div>

        <!-- Produk Unggulan Terbaru -->
        @php
            if (!isset($featuredProducts)) {
                // Ambil HANYA produk yang diaktifkan sebagai Unggulan oleh Admin (1 UMKM 1 produk unggulan)
                $featuredProducts = \App\Models\User\Product::with('umkmProfile')
                    ->where('status', 'verified')
                    ->where('is_featured', true)
                    ->latest()
                    ->get()
                    ->unique('umkm_profile_id')
                    ->take(10);
            }
        @endphp

        <div class="mb-4 reveal delay-300">
            <!-- Header Section with Badge -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6 sm:mb-8">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200 shadow-2xs mb-2">
                        <svg class="w-3.5 h-3.5 text-amber-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span>Kurasi Resmi Dinas Perdagangan Wonogiri</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                        Produk Unggulan Terbaru
                    </h2>
                    <p class="text-slate-500 text-xs sm:text-sm mt-1 max-w-xl">
                        Koleksi komoditas dan karya khas pilihan asli Wonogiri dengan jaminan mutu dan legalitas resmi.
                    </p>
                </div>

                <a href="/katalog" class="inline-flex items-center gap-2 px-4 sm:px-5 py-2.5 sm:py-3 bg-gradient-to-r from-[#800000] to-[#a81c1c] text-white hover:from-[#660000] hover:to-[#8a1414] rounded-2xl text-xs sm:text-sm font-bold transition-all shadow-sm hover:shadow-xl hover:-translate-y-0.5 shrink-0 group">
                    <svg class="w-4 h-4 text-white/90" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M4 4h3.5v3.5H4V4zm6.25 0h3.5v3.5h-3.5V4zm6.25 0H20v3.5h-3.5V4zM4 10.25h3.5v3.5H4v-3.5zm6.25 0h3.5v3.5h-3.5v-3.5zm6.25 0H20v3.5h-3.5v-3.5zM4 16.5h3.5V20H4v-3.5zm6.25 0h3.5V20h-3.5v-3.5zm6.25 0H20V20h-3.5v-3.5z"/>
                    </svg>
                    <span>Katalog Selengkapnya</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>

            <!-- Product Cards Grid: Tampilan & Ukuran Card Identik dengan Berita & Kegiatan (5 Kolom) -->
            @if($featuredProducts->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3.5 sm:gap-4">
                @foreach ($featuredProducts as $product)
                <a href="{{ route('katalog.show', $product->id) }}" class="bg-white rounded-2xl overflow-hidden shadow-2xs hover:shadow-lg border border-slate-200/90 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Thumbnail Image Container (Sama persis ukuran Berita: h-28 sm:h-32) -->
                        <div class="h-28 sm:h-32 w-full overflow-hidden bg-slate-100 relative">
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" onerror="this.onerror=null; this.src='https://placehold.co/600x400/f1f5f9/94a3b8?text=Foto+Produk';" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                    <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif

                            <!-- Category Badge (Top-Left, persis Berita) -->
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md text-[9px] font-bold bg-white/95 backdrop-blur-xs text-[#800000] shadow-xs">
                                {{ $product->category ?? 'Produk UMKM' }}
                            </span>

                            <!-- Golden Featured Badge (Top-Right, kompak) -->
                            @if($product->is_featured)
                            <span class="absolute top-2 right-2 px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-xs flex items-center gap-1 border border-amber-300/40">
                                <svg class="w-2.5 h-2.5 text-yellow-200 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span>Unggulan</span>
                            </span>
                            @endif
                        </div>

                        <!-- Card Body (Persis Berita: padding p-3 sm:p-3.5) -->
                        <div class="p-3 sm:p-3.5">
                            <!-- Tanggal Ditambahkan / Info Agenda (Persis Berita) -->
                            <div class="text-[10px] font-bold text-[#b91c1c] mb-1 inline-flex items-center gap-1">
                                <svg class="w-3 h-3 text-[#b91c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>{{ $product->created_at ? $product->created_at->translatedFormat('d F Y') : 'Khas Wonogiri' }}</span>
                            </div>

                            <!-- Product Name (Persis Berita) -->
                            <h3 class="text-xs sm:text-[13px] font-bold text-slate-900 group-hover:text-[#800000] transition-colors leading-snug mb-1.5 line-clamp-2 min-h-[2.1rem]">
                                {{ $product->name }}
                            </h3>

                            <!-- Product Excerpt / Description (Persis Berita: line-clamp-2) -->
                            <p class="text-[11px] text-slate-500 leading-relaxed line-clamp-2 min-h-[1.8rem]">
                                {{ $product->description ? Str::limit(strip_tags($product->description), 85) : 'Koleksi produk unggulan berkualitas khas binaan Dinas Perdagangan Wonogiri.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Card Footer: Author & Detail -->
                    <div class="px-3 sm:px-3.5 py-2.5 border-t border-slate-100 flex items-center justify-between text-[10px]">
                        <span class="text-slate-400 font-medium truncate max-w-[110px]">
                            {{ $product->umkmProfile->business_name ?? 'Admin UMKM' }}
                        </span>

                        <span class="font-bold text-[#800000] group-hover:text-red-900 inline-flex items-center gap-0.5 group-hover:translate-x-0.5 transition-transform shrink-0">
                            <span>Detail</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-200/80 shadow-sm max-w-lg mx-auto">
                <div class="w-16 h-16 mx-auto mb-4 text-amber-500 bg-amber-50 rounded-2xl flex items-center justify-center border border-amber-200 shadow-xs">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">Belum Ada Produk Unggulan</h3>
                <p class="text-slate-500 text-sm max-w-sm mx-auto">Produk unggulan terkurasi akan ditampilkan di sini setelah dipilih oleh Admin.</p>
            </div>
            @endif
        </div>

    </div>
</section>

<!-- ==============================================================
     SEKSI DATA STATISTIK & AGREGAT UMKM WONOGIRI
     ============================================================== -->
<div class="py-12 sm:py-16 md:py-20 bg-gradient-to-b from-slate-50 via-white to-slate-50 border-y border-slate-200/90 relative overflow-hidden reveal delay-200" id="statistik-agregat">
    <!-- Ambient ambient circles -->
    <div class="absolute -top-32 -right-32 w-96 h-96 bg-red-100/60 rounded-full filter blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-amber-100/60 rounded-full filter blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-14">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-red-50 text-[#800000] border border-red-200/90 mb-3 shadow-2xs">
                <svg class="w-4 h-4 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <span>Statistik & Data Agregat Resmi</span>
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Pertumbuhan & Peta Potensi UMKM Wonogiri
            </h2>
            <p class="text-slate-600 text-xs sm:text-sm md:text-base mt-2.5 leading-relaxed">
                Transparansi data agregat pertumbuhan pelaku usaha lokal, sebaran wilayah kecamatan, diversifikasi produk, serta kepemilikan sertifikasi legalitas usaha di Kabupaten Wonogiri.
            </p>
        </div>

        <!-- 4 Key Aggregate Metrics -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-6 mb-10 sm:mb-12">
            <!-- Metric 1: Total UMKM -->
            <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total UMKM</span>
                    <span class="w-10 h-10 rounded-xl bg-red-50 text-[#800000] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </span>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                        {{ number_format($totalUmkm ?? 0, 0, ',', '.') }}
                    </div>
                    <p class="text-[11px] sm:text-xs text-slate-500 mt-1 flex items-center gap-1 font-medium">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        {{ number_format($totalVerifiedUmkm ?? $totalUmkm, 0, ',', '.') }} UMKM Disetujui
                    </p>
                </div>
            </div>

            <!-- Metric 2: Produk Terpublikasi -->
            <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Produk Lokal</span>
                    <span class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </span>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                        {{ number_format($totalProducts ?? 0, 0, ',', '.') }}
                    </div>
                    <p class="text-[11px] sm:text-xs text-slate-500 mt-1 flex items-center gap-1 font-medium">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Produk Terkurasi & Tayang
                    </p>
                </div>
            </div>

            <!-- Metric 3: Kecamatan Terjangkau -->
            <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Wilayah</span>
                    <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </span>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                        {{ $totalDistricts ?? 0 }} <span class="text-xs sm:text-base font-normal text-slate-400">/ 25</span>
                    </div>
                    <p class="text-[11px] sm:text-xs text-slate-500 mt-1 flex items-center gap-1 font-medium">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        Kecamatan se-Wonogiri
                    </p>
                </div>
            </div>

            <!-- Metric 4: Konsultasi Bisnis Selesai -->
            <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Konsultasi</span>
                    <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                        {{ number_format($totalConsultations ?? 0, 0, ',', '.') }}
                    </div>
                    <p class="text-[11px] sm:text-xs text-slate-500 mt-1 flex items-center gap-1 font-medium">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Pendampingan Selesai
                    </p>
                </div>
            </div>
        </div>

        <!-- 3 Deep Analytical Breakdown Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-7">
            
            <!-- Box 1: Agregat Kategori Produk -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3.5 mb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-red-50 text-[#800000] flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            </span>
                            <h3 class="font-bold text-slate-800 text-sm sm:text-base">Komposisi Kategori Produk</h3>
                        </div>
                        <a href="{{ route('katalog') }}" class="text-[11px] font-bold text-[#800000] hover:underline">Semua &rarr;</a>
                    </div>
                    <p class="text-xs text-slate-500 mb-4">Distribusi produk lokal terkurasi berdasarkan rumpun komoditas unggulan daerah.</p>

                    <div class="space-y-3.5">
                        @php
                            $catColors = [
                                'Makanan & Minuman' => ['bar' => 'bg-amber-500', 'badge' => 'bg-amber-50 text-amber-800'],
                                'Batik/Fashion' => ['bar' => 'bg-red-600', 'badge' => 'bg-red-50 text-red-800'],
                                'Kerajinan' => ['bar' => 'bg-indigo-600', 'badge' => 'bg-indigo-50 text-indigo-800'],
                                'Olahan Hasil Pertanian' => ['bar' => 'bg-emerald-600', 'badge' => 'bg-emerald-50 text-emerald-800'],
                                'Produk Kreatif' => ['bar' => 'bg-purple-600', 'badge' => 'bg-purple-50 text-purple-800'],
                            ];
                        @endphp
                        @forelse($categoryStats ?? [] as $cStat)
                            @php
                                $percent = ($totalProducts ?? 0) > 0 ? round(($cStat->count / $totalProducts) * 100) : 0;
                                $color = $catColors[$cStat->category] ?? ['bar' => 'bg-[#800000]', 'badge' => 'bg-slate-100 text-slate-800'];
                            @endphp
                            <div>
                                <div class="flex items-center justify-between text-xs mb-1">
                                    <span class="font-semibold text-slate-800 truncate max-w-[180px]">{{ $cStat->category }}</span>
                                    <span class="font-bold text-slate-700">{{ $cStat->count }} <span class="text-[10px] text-slate-400 font-normal">({{ $percent }}%)</span></span>
                                </div>
                                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full {{ $color['bar'] }} rounded-full transition-all duration-700" style="width: {{ $percent }}%;"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic py-2">Belum ada data kategori produk.</p>
                        @endforelse
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Total Diversifikasi:</span>
                    <span class="font-bold text-slate-800">{{ isset($categoryStats) ? $categoryStats->count() : 0 }} Kategori Aktif</span>
                </div>
            </div>

            <!-- Box 2: Agregat Legalitas & Sertifikasi -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3.5 mb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </span>
                            <h3 class="font-bold text-slate-800 text-sm sm:text-base">Legalitas & Sertifikasi Usaha</h3>
                        </div>
                        <a href="{{ route('panduan') }}" class="text-[11px] font-bold text-[#800000] hover:underline">Panduan &rarr;</a>
                    </div>
                    <p class="text-xs text-slate-500 mb-4">Tingkat kepemilikan izin resmi OSS dan sertifikasi mutu halal & PIRT pelaku usaha.</p>

                    <div class="space-y-4">
                        <!-- NIB -->
                        @php
                            $nibCount = $legalitasStats['nib'] ?? 0;
                            $nibPercent = ($totalUmkm ?? 0) > 0 ? round(($nibCount / $totalUmkm) * 100) : 0;
                        @endphp
                        <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100">
                            <div class="flex items-center justify-between mb-1 text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                    <span class="font-bold text-slate-800">Nomor Induk Berusaha (NIB)</span>
                                </div>
                                <span class="font-extrabold text-blue-700">{{ $nibCount }} <span class="text-[10px] text-slate-400 font-normal">UMKM ({{ $nibPercent }}%)</span></span>
                            </div>
                            <div class="w-full h-1.5 bg-slate-200/80 rounded-full overflow-hidden mt-1.5">
                                <div class="h-full bg-blue-600 rounded-full transition-all duration-700" style="width: {{ $nibPercent }}%;"></div>
                            </div>
                        </div>

                        <!-- Sertifikat Halal -->
                        @php
                            $halalCount = $legalitasStats['halal'] ?? 0;
                            $halalPercent = ($totalUmkm ?? 0) > 0 ? round(($halalCount / $totalUmkm) * 100) : 0;
                        @endphp
                        <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100">
                            <div class="flex items-center justify-between mb-1 text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                    <span class="font-bold text-slate-800">Sertifikasi Halal (BPJPH/MUI)</span>
                                </div>
                                <span class="font-extrabold text-emerald-700">{{ $halalCount }} <span class="text-[10px] text-slate-400 font-normal">UMKM ({{ $halalPercent }}%)</span></span>
                            </div>
                            <div class="w-full h-1.5 bg-slate-200/80 rounded-full overflow-hidden mt-1.5">
                                <div class="h-full bg-emerald-600 rounded-full transition-all duration-700" style="width: {{ $halalPercent }}%;"></div>
                            </div>
                        </div>

                        <!-- Izin Edar PIRT -->
                        @php
                            $pirtCount = $legalitasStats['pirt'] ?? 0;
                            $pirtPercent = ($totalUmkm ?? 0) > 0 ? round(($pirtCount / $totalUmkm) * 100) : 0;
                        @endphp
                        <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100">
                            <div class="flex items-center justify-between mb-1 text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-amber-600"></span>
                                    <span class="font-bold text-slate-800">Izin Edar PIRT (Dinkes/BPOM)</span>
                                </div>
                                <span class="font-extrabold text-amber-700">{{ $pirtCount }} <span class="text-[10px] text-slate-400 font-normal">UMKM ({{ $pirtPercent }}%)</span></span>
                            </div>
                            <div class="w-full h-1.5 bg-slate-200/80 rounded-full overflow-hidden mt-1.5">
                                <div class="h-full bg-amber-600 rounded-full transition-all duration-700" style="width: {{ $pirtPercent }}%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-100 text-center">
                    <a href="{{ route('konsultasi') }}" class="text-xs font-bold text-[#800000] hover:text-red-950 inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Fasilitasi Pengurusan Izin Usaha Gratis &rarr;
                    </a>
                </div>
            </div>

            <!-- Box 3: Agregat Sebaran Wilayah & Demografi Gender Pemilik -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3.5 mb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </span>
                            <h3 class="font-bold text-slate-800 text-sm sm:text-base">Demografi & Sebaran Wilayah</h3>
                        </div>
                        <a href="{{ route('direktori') }}" class="text-[11px] font-bold text-[#800000] hover:underline">Direktori &rarr;</a>
                    </div>

                    <!-- Gender Ratio -->
                    <div class="mb-5">
                        <div class="flex items-center justify-between text-xs mb-1.5">
                            <span class="font-bold text-slate-700">Demografi Gender Pemilik</span>
                            @php
                                $maleCount = $genderStats['male'] ?? 0;
                                $femaleCount = $genderStats['female'] ?? 0;
                                $totalGender = $maleCount + $femaleCount;
                                $malePercent = $totalGender > 0 ? round(($maleCount / $totalGender) * 100) : 50;
                                $femalePercent = $totalGender > 0 ? round(($femaleCount / $totalGender) * 100) : 50;
                            @endphp
                            <span class="text-[11px] text-slate-500">Rasio Partisipasi</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs mb-2">
                            <div class="p-2.5 rounded-xl bg-blue-50/70 border border-blue-100 flex items-center justify-between">
                                <span class="font-semibold text-blue-900 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Laki-laki
                                </span>
                                <span class="font-bold text-blue-800">{{ $maleCount }} <span class="text-[10px] text-blue-500">({{ $malePercent }}%)</span></span>
                            </div>
                            <div class="p-2.5 rounded-xl bg-pink-50/70 border border-pink-100 flex items-center justify-between">
                                <span class="font-semibold text-pink-900 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Perempuan
                                </span>
                                <span class="font-bold text-pink-800">{{ $femaleCount }} <span class="text-[10px] text-pink-500">({{ $femalePercent }}%)</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Sebaran Wilayah Kecamatan Teraktif -->
                    <div>
                        <div class="flex items-center justify-between text-xs mb-2 font-bold text-slate-700">
                            <span>Kecamatan Teraktif</span>
                            <span class="text-[10px] font-normal text-slate-400">Jumlah UMKM</span>
                        </div>
                        <div class="space-y-2">
                            @forelse($districtStats ?? [] as $dStat)
                                <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50 hover:bg-slate-100 transition-colors text-xs">
                                    <span class="font-semibold text-slate-800 flex items-center gap-1.5">
                                        <svg class="w-3 h-3 text-red-700" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" /></svg>
                                        Kec. {{ $dStat->district }}
                                    </span>
                                    <span class="font-bold text-[#800000] px-2 py-0.5 rounded-full bg-red-50 text-[11px]">{{ $dStat->count }} UMKM</span>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 italic">Belum ada sebaran kecamatan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Wilayah Terpetakan:</span>
                    <a href="#peta-sebaran-umkm" class="font-bold text-[#800000] hover:text-red-950 flex items-center gap-1 transition-colors">
                        <span>{{ $totalDistricts ?? 0 }} Kecamatan Terdata</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                </div>
            </div>

        </div>

        <!-- ============================================================== -->
        <!-- SEKSI PETA GEOSPASIAL & SEBARAN TITIK UMKM KABUPATEN WONOGIRI -->
        <!-- ============================================================== -->
        <div id="peta-sebaran-umkm" class="mt-12 sm:mt-16 pt-8 border-t border-slate-200/90 scroll-mt-24">
            
            <!-- Header Peta Persebaran -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Peta Persebaran Lokasi UMKM Kabupaten Wonogiri
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl leading-relaxed">
                        Visualisasi pemetaan persebaran pelaku UMKM di 25 kecamatan Kabupaten Wonogiri berdasarkan data alamat usaha dan pembagian zonasi wilayah.
                    </p>
                </div>

                <!-- Total Metrics Quick Bar -->
                <div class="flex items-center gap-2 sm:gap-3 shrink-0 w-full sm:w-auto justify-between sm:justify-start">
                    <div class="flex-1 sm:flex-initial px-3 sm:px-3.5 py-1.5 sm:py-2 rounded-xl bg-white border border-slate-200/90 shadow-2xs text-center min-w-[65px]">
                        <div class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400">Terpetakan</div>
                        <div class="text-sm sm:text-lg font-black text-[#800000]" id="map-total-count">{{ count($umkmMapList ?? []) }}</div>
                    </div>
                    <div class="flex-1 sm:flex-initial px-3 sm:px-3.5 py-1.5 sm:py-2 rounded-xl bg-white border border-slate-200/90 shadow-2xs text-center min-w-[65px]">
                        <div class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400">Kecamatan</div>
                        <div class="text-sm sm:text-lg font-black text-amber-600">25</div>
                    </div>
                    <button type="button" 
                            onclick="resetWonogiriMap()" 
                            class="px-3 sm:px-3.5 py-1.5 sm:py-2 rounded-xl bg-[#800000] hover:bg-red-900 text-white font-bold text-xs shadow-xs hover:shadow-md transition-all flex items-center justify-center gap-1.5 cursor-pointer shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                        <span class="hidden sm:inline">Fokus Wonogiri</span>
                        <span class="sm:hidden">Reset</span>
                    </button>
                </div>
            </div>

            <!-- Filter & Search Bar di Atas Peta -->
            <div id="map-filter-container" class="relative z-30 bg-white rounded-2xl p-3 sm:p-4 border border-slate-200/90 shadow-2xs mb-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2.5 sm:gap-3 items-center">
                    
                    <!-- Search Input (1/3 cols) -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" 
                               id="map-search-input" 
                               placeholder="Cari nama UMKM, produk, atau desa..." 
                               class="w-full search-input-padding pl-11 pr-4 py-2 sm:py-2.5 text-xs font-medium bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#800000] focus:ring-2 focus:ring-red-500/20 text-slate-900 placeholder:text-slate-400 transition-all shadow-2xs"
                               style="padding-left: 2.75rem !important;">
                    </div>

                    <!-- Dropdown Kecamatan (1/3 cols) Custom Modern -->
                    <div class="relative z-20" id="map-dist-container">
                        <input type="hidden" id="map-district-select" value="">
                        
                        <button type="button" 
                                id="map-dist-btn"
                                class="w-full flex items-center justify-between pl-3.5 pr-3 py-2 sm:py-2.5 text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl hover:bg-white focus:bg-white focus:outline-none focus:border-[#800000] focus:ring-2 focus:ring-red-500/20 text-slate-800 cursor-pointer transition-all shadow-2xs">
                            <span id="map-dist-label" class="truncate">Semua Kecamatan (25 Wilayah)</span>
                            <svg id="map-dist-arrow" class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0 ml-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>

                        <div id="map-dist-panel" class="hidden fixed sm:absolute inset-0 sm:inset-auto sm:top-full sm:left-0 sm:right-0 sm:mt-1.5 z-50 flex flex-col justify-end sm:justify-start">
                            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs sm:hidden transition-opacity" onclick="closeAllMapDropdowns()"></div>
                            <div class="relative bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl border border-slate-200 p-4 sm:p-2.5 max-h-[85vh] sm:max-h-96 flex flex-col z-10">
                                <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-3 sm:hidden"></div>
                                <div class="sm:hidden flex items-center justify-between pb-2.5 mb-2 border-b border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-[#800000]"></span>
                                        <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Pilih Kecamatan (Peta Wonogiri)</span>
                                    </div>
                                    <button type="button" onclick="closeAllMapDropdowns()" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                                <div class="relative mb-2">
                                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    </div>
                                    <input type="text" 
                                           id="map-dist-search" 
                                           placeholder="Ketik nama kecamatan..." 
                                           autocomplete="off"
                                           class="w-full pl-9 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#800000] text-slate-800"
                                           style="padding-left: 2.25rem !important;">
                                </div>
                                <div class="overflow-y-auto space-y-1 max-h-56 sm:max-h-64 pr-1 scrollbar-thin">
                                    <button type="button" 
                                            onclick="selectMapDistrict('', 'Semua Kecamatan (25 Wilayah)')"
                                            class="map-dist-opt w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all text-left bg-red-50 text-[#800000]"
                                            data-val=""
                                            data-name="semua kecamatan">
                                        <span>Semua Kecamatan (25 Wilayah)</span>
                                        <svg class="check-icon w-4 h-4 text-[#800000] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                    @php
                                        $allDistrictsList = [
                                            'Baturetno', 'Batuwarno', 'Bulukerto', 'Eromoko', 'Girimarto', 
                                            'Giritontro', 'Giriwoyo', 'Jatipurno', 'Jatiroto', 'Jatisrono', 
                                            'Karangtengah', 'Kismantoro', 'Manyaran', 'Ngadirojo', 'Nguntoronadi', 
                                            'Paranggupito', 'Pracimantoro', 'Puhpelem', 'Purwantoro', 'Selogiri', 
                                            'Sidoharjo', 'Slogohimo', 'Tirtomoyo', 'Wonogiri', 'Wuryantoro'
                                        ];
                                    @endphp
                                    @foreach($allDistrictsList as $dist)
                                        <button type="button" 
                                                onclick="selectMapDistrict('{{ $dist }}', 'Kecamatan {{ $dist }}')"
                                                class="map-dist-opt w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all text-left text-slate-700 hover:bg-slate-50"
                                                data-val="{{ $dist }}"
                                                data-name="kecamatan {{ strtolower($dist) }} {{ strtolower($dist) }}">
                                            <span>Kecamatan {{ $dist }}</span>
                                            <svg class="check-icon w-4 h-4 text-[#800000] shrink-0 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown Kategori (1/3 cols) Custom Modern -->
                    <div class="relative z-10" id="map-cat-container">
                        <input type="hidden" id="map-category-select" value="">
                        
                        <button type="button" 
                                id="map-cat-btn"
                                class="w-full flex items-center justify-between pl-3.5 pr-3 py-2 sm:py-2.5 text-xs font-semibold bg-slate-50 border border-slate-200 rounded-xl hover:bg-white focus:bg-white focus:outline-none focus:border-[#800000] focus:ring-2 focus:ring-red-500/20 text-slate-800 cursor-pointer transition-all shadow-2xs">
                            <span id="map-cat-label" class="truncate">Semua Kategori Produk</span>
                            <svg id="map-cat-arrow" class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0 ml-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>

                        <div id="map-cat-panel" class="hidden fixed sm:absolute inset-0 sm:inset-auto sm:top-full sm:left-0 sm:right-0 sm:mt-1.5 z-50 flex flex-col justify-end sm:justify-start">
                            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs sm:hidden transition-opacity" onclick="closeAllMapDropdowns()"></div>
                            <div class="relative bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl border border-slate-200 p-4 sm:p-2.5 max-h-[85vh] sm:max-h-96 flex flex-col z-10">
                                <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-3 sm:hidden"></div>
                                <div class="sm:hidden flex items-center justify-between pb-2.5 mb-2 border-b border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-[#800000]"></span>
                                        <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Pilih Kategori Produk</span>
                                    </div>
                                    <button type="button" onclick="closeAllMapDropdowns()" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                                <div class="overflow-y-auto space-y-1 max-h-56 sm:max-h-64 pr-1 scrollbar-thin">
                                    @php
                                        $mapCategories = [
                                            '' => 'Semua Kategori Produk',
                                            'makan' => 'Kuliner / Makanan & Minuman',
                                            'batik' => 'Batik & Fashion',
                                            'rajin' => 'Kerajinan Tangan',
                                            'pertan' => 'Olahan Hasil Pertanian',
                                            'kreatif' => 'Produk Kreatif & Lainnya'
                                        ];
                                    @endphp
                                    @foreach($mapCategories as $mVal => $mLbl)
                                        <button type="button" 
                                                onclick="selectMapCategory('{{ $mVal }}', '{{ $mLbl }}')"
                                                class="map-cat-opt w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all text-left {{ $mVal === '' ? 'bg-red-50 text-[#800000]' : 'text-slate-700 hover:bg-slate-50' }}"
                                                data-val="{{ $mVal }}">
                                            <span>{{ $mLbl }}</span>
                                            <svg class="check-icon w-4 h-4 text-[#800000] shrink-0 {{ $mVal === '' ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Layout Utama Peta: Kiri Peta (8 cols), Kanan Sidebar Drawer UMKM (4 cols) -->
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
                
                <!-- Map Container (8 cols) -->
                <div class="lg:col-span-8 bg-white rounded-2xl p-2 sm:p-2.5 border border-slate-200/90 shadow-sm relative overflow-hidden">
                    
                    <!-- The Leaflet Map Canvas (Responsive Height for mobile) -->
                    <div id="wonogiri-map" class="w-full h-[340px] sm:h-[480px] lg:h-[550px] rounded-xl overflow-hidden relative z-10 bg-slate-100">
                        <!-- Loading placeholder -->
                        <div id="map-loader" class="absolute inset-0 bg-slate-100/90 z-20 flex flex-col items-center justify-center gap-3">
                            <div class="w-9 h-9 border-3 border-red-200 border-t-[#800000] rounded-full animate-spin"></div>
                            <span class="text-xs font-bold text-slate-700">Memuat peta persebaran UMKM...</span>
                        </div>
                    </div>

                    <!-- Legenda Tematik Map (Sesuai Peta Wonogiri Asli - Responsive for Mobile) -->
                    <div class="mt-2.5 pt-2.5 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs text-slate-600 px-1 sm:px-2">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-bold text-slate-800 text-[10px] sm:text-[11px]">Zona Sebaran:</span>
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="flex items-center gap-1 text-[9px] sm:text-[10px]"><span class="w-2.5 h-2.5 rounded-xs bg-[#dc2626]"></span> Level 5-6 (Tinggi)</span>
                                <span class="flex items-center gap-1 text-[9px] sm:text-[10px]"><span class="w-2.5 h-2.5 rounded-xs bg-[#ea580c]"></span> Level 4</span>
                                <span class="flex items-center gap-1 text-[9px] sm:text-[10px]"><span class="w-2.5 h-2.5 rounded-xs bg-[#f97316]"></span> Level 3</span>
                                <span class="flex items-center gap-1 text-[9px] sm:text-[10px]"><span class="w-2.5 h-2.5 rounded-xs bg-[#eab308]"></span> Level 2</span>
                                <span class="flex items-center gap-1 text-[9px] sm:text-[10px]"><span class="w-2.5 h-2.5 rounded-xs bg-[#facc15]"></span> Level 1</span>
                                <span class="flex items-center gap-1 text-[9px] sm:text-[10px]"><span class="w-2.5 h-2.5 rounded-xs bg-[#7dd3fc]"></span> Waduk Gajah Mungkur</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 text-[10px] sm:text-[11px] font-bold text-slate-800 shrink-0">
                            <span class="w-3 h-3 rounded-full bg-[#800000] border-2 border-white shadow-xs inline-flex items-center justify-center text-[8px] text-white">●</span>
                            <span>Titik Pin UMKM</span>
                        </div>
                    </div>

                </div>

                <!-- Sidebar Drawer UMKM Terpilih (4 cols - Responsive Height on Mobile) -->
                <div class="lg:col-span-4 bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200/90 shadow-sm flex flex-col h-[380px] sm:h-[540px] lg:h-[615px]">
                    
                    <!-- Sidebar Header -->
                    <div class="border-b border-slate-100 pb-3 mb-3 flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm sm:text-base flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                Titik UMKM Terpilih
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-0.5" id="sidebar-filter-hint">
                                Klik kartu UMKM untuk melompat ke titik di peta.
                            </p>
                        </div>
                        <span id="sidebar-count-badge" class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-[#800000] border border-red-100 shrink-0">
                            {{ count($umkmMapList ?? []) }} Titik
                        </span>
                    </div>

                    <!-- Scrollable List of UMKM Cards -->
                    <div id="sidebar-umkm-list" class="flex-1 overflow-y-auto space-y-2.5 pr-1.5 scrollbar-thin">
                        <!-- Dinamis via JavaScript -->
                    </div>

                    <!-- Sidebar Footer CTA -->
                    <div class="pt-3 mt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500 text-[11px]">Belum terdaftar di peta?</span>
                        <a href="{{ route('toko.create') }}" class="font-bold text-[#800000] hover:underline flex items-center gap-1 text-[11px]">
                            Daftarkan Usaha Anda &rarr;
                        </a>
                    </div>

                </div>

            </div>

        </div>

        <!-- Banner Call-to-Action Kolaboratif di Bawah Statistik -->
        <div class="mt-10 sm:mt-12 rounded-2xl bg-gradient-to-r from-[#800000] via-[#991b1b] to-[#b91c1c] p-6 sm:p-8 text-white shadow-lg relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            
            <div class="relative z-10 text-center md:text-left">
                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/20 text-yellow-200 mb-2">Mari Bergabung</span>
                <h3 class="text-xl sm:text-2xl font-black text-white">Ingin Usaha Anda Masuk dalam Data Agregat & Katalog Resmi?</h3>
                <p class="text-xs sm:text-sm text-red-100 mt-1 max-w-xl">Daftarkan produk dan usaha Anda secara gratis untuk mendapatkan fasilitas promosi serta pendampingan legalitas dari Dinas Perdagangan dan KUKM Kabupaten Wonogiri.</p>
            </div>

            <div class="relative z-10 shrink-0">
                <a href="{{ route('toko.create') }}" class="inline-flex items-center gap-2 bg-[#eab308] hover:bg-yellow-500 text-[#78350f] font-extrabold text-xs sm:text-sm px-6 py-3.5 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    <span>Buka Toko / Daftarkan UMKM</span>
                    <svg class="w-4 h-4 text-[#78350f]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>

    </div>
</div>

<!-- Berita & Kegiatan Terkini Section (Continuous Seamless Stream - 2 Rows) -->
@if(isset($latestNews) && $latestNews->count() > 0)
@php
    $allNews = $latestNews->values();
    $totalCount = $allNews->count();

    $row1Items = collect();
    $row2Items = collect();

    if ($totalCount >= 2) {
        foreach ($allNews as $i => $item) {
            if ($i % 2 === 0) {
                $row1Items->push($item);
            } else {
                $row2Items->push($item);
            }
        }
        // Seimbangkan jumlah jika ganjil
        while ($row2Items->count() < $row1Items->count()) {
            $row2Items->push($allNews[$row2Items->count() % $totalCount]);
        }
    } else {
        $row1Items = $allNews;
        $row2Items = $allNews;
    }

    // Ulangi 4 kali agar track memanjang seamless dan loop tanpa terputus sama sekali
    $row1Repeated = collect();
    $row2Repeated = collect();
    for ($r = 0; $r < 4; $r++) {
        $row1Repeated = $row1Repeated->concat($row1Items);
        $row2Repeated = $row2Repeated->concat($row2Items);
    }
@endphp
<style>
    .news-scroll-row::-webkit-scrollbar {
        display: none;
    }
</style>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 sm:pt-10 pb-12 sm:pb-16 reveal delay-300" id="seksi-berita">
    
    <!-- Header with Controls -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-5 sm:mb-6 gap-3">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Berita & Kegiatan Terkini</h2>
            <p class="text-slate-500 text-xs sm:text-sm mt-1">Ikuti berbagai perkembangan program fasilitasi, bimbingan teknis, dan festival daya saing UMKM Wonogiri.</p>
        </div>

        <!-- Controls: Prev, Next & All News Link -->
        <div class="flex items-center gap-3">
            <!-- Prev & Next Manual Buttons -->
            <div class="flex items-center gap-1.5 bg-slate-100/80 p-1 rounded-xl border border-slate-200/60 shadow-2xs">
                <button type="button" onclick="scrollNews('prev')" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-white text-slate-700 hover:text-white hover:bg-[#800000] flex items-center justify-center shadow-xs transition-all cursor-pointer active:scale-95" aria-label="Geser ke Kiri" title="Geser ke Kiri">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" onclick="scrollNews('next')" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-white text-slate-700 hover:text-white hover:bg-[#800000] flex items-center justify-center shadow-xs transition-all cursor-pointer active:scale-95" aria-label="Geser ke Kanan" title="Geser ke Kanan">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

            <!-- All News Link -->
            <a href="{{ route('informasi') }}" class="inline-flex items-center gap-1.5 px-3.5 sm:px-4 py-2 bg-white border border-[#800000] text-[#800000] hover:bg-red-50 rounded-xl text-xs sm:text-sm font-bold shadow-2xs transition-all shrink-0">
                <span>Lihat Semua Berita</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>

    <!-- 2 Rows Continuous Stream Container -->
    <div class="relative overflow-hidden group" id="news-continuous-wrapper">
        <!-- Edge Gradient Shadows for luxury seamless fade -->
        <div class="pointer-events-none absolute left-0 top-0 bottom-0 w-8 sm:w-20 bg-gradient-to-r from-slate-50/90 to-transparent z-10"></div>
        <div class="pointer-events-none absolute right-0 top-0 bottom-0 w-8 sm:w-20 bg-gradient-to-l from-slate-50/90 to-transparent z-10"></div>

        <!-- BARIS ATAS (Row 1) -->
        <div id="news-track-row1" class="news-scroll-row flex items-stretch gap-3.5 sm:gap-4 overflow-x-auto select-none py-1.5 cursor-grab active:cursor-grabbing" style="scrollbar-width: none; -ms-overflow-style: none;">
            @foreach ($row1Repeated as $news)
            @php
                $newsImg = $news->image_path ? (str_starts_with($news->image_path, 'http') || str_starts_with($news->image_path, 'img/') ? asset($news->image_path) : asset('storage/' . $news->image_path)) : asset('img/news/bimtek.jpg');
                $newsDateFormatted = $news->created_at ? $news->created_at->translatedFormat('d F Y') : '-';
            @endphp
            <div class="news-card w-[220px] sm:w-[260px] shrink-0 bg-white rounded-2xl overflow-hidden shadow-2xs hover:shadow-lg border border-slate-200/90 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group/card">
                <div>
                    <a href="{{ route('informasi.show', $news->id) }}" class="block h-28 sm:h-32 w-full overflow-hidden bg-slate-100 relative">
                        <img src="{{ $newsImg }}" alt="{{ $news->title }}" loading="lazy" class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-500">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md text-[9px] font-bold bg-white/95 backdrop-blur-xs text-[#800000] shadow-xs">
                            {{ $news->category ?? 'Berita UMKM' }}
                        </span>
                    </a>
                    <div class="p-3 sm:p-3.5">
                        <a href="{{ route('informasi', ['q' => $newsDateFormatted]) }}" class="text-[10px] font-bold text-[#b91c1c] hover:underline mb-1 inline-flex items-center gap-1 transition-colors" title="Lihat semua agenda pada tanggal {{ $newsDateFormatted }}">
                            <svg class="w-3 h-3 text-[#b91c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ $newsDateFormatted }}</span>
                        </a>
                        <h3 class="text-xs sm:text-[13px] font-bold text-slate-900 group-hover/card:text-[#800000] transition-colors leading-snug mb-1.5 line-clamp-2 min-h-[2.1rem]">
                            <a href="{{ route('informasi.show', $news->id) }}">
                                {{ $news->title }}
                            </a>
                        </h3>
                        <p class="text-[11px] text-slate-500 leading-relaxed line-clamp-2 min-h-[1.8rem]">
                            {{ $news->excerpt ?: Str::limit(strip_tags($news->content), 85) }}
                        </p>
                    </div>
                </div>
                <div class="px-3 sm:px-3.5 py-2.5 border-t border-slate-100 flex items-center justify-between text-[10px]">
                    <span class="text-slate-400 font-medium truncate max-w-[110px]">Admin UMKM</span>
                    <a href="{{ route('informasi.show', $news->id) }}" class="font-bold text-[#800000] hover:text-red-900 inline-flex items-center gap-0.5 group-hover/card:translate-x-0.5 transition-transform shrink-0">
                        <span>Baca Lengkap</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- BARIS BAWAH (Row 2) -->
        <div id="news-track-row2" class="news-scroll-row flex items-stretch gap-3.5 sm:gap-4 overflow-x-auto select-none py-1.5 mt-3 sm:mt-4 cursor-grab active:cursor-grabbing" style="scrollbar-width: none; -ms-overflow-style: none;">
            @foreach ($row2Repeated as $news)
            @php
                $newsImg = $news->image_path ? (str_starts_with($news->image_path, 'http') || str_starts_with($news->image_path, 'img/') ? asset($news->image_path) : asset('storage/' . $news->image_path)) : asset('img/news/bimtek.jpg');
                $newsDateFormatted = $news->created_at ? $news->created_at->translatedFormat('d F Y') : '-';
            @endphp
            <div class="news-card w-[220px] sm:w-[260px] shrink-0 bg-white rounded-2xl overflow-hidden shadow-2xs hover:shadow-lg border border-slate-200/90 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group/card">
                <div>
                    <a href="{{ route('informasi.show', $news->id) }}" class="block h-28 sm:h-32 w-full overflow-hidden bg-slate-100 relative">
                        <img src="{{ $newsImg }}" alt="{{ $news->title }}" loading="lazy" class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-500">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md text-[9px] font-bold bg-white/95 backdrop-blur-xs text-[#800000] shadow-xs">
                            {{ $news->category ?? 'Berita UMKM' }}
                        </span>
                    </a>
                    <div class="p-3 sm:p-3.5">
                        <a href="{{ route('informasi', ['q' => $newsDateFormatted]) }}" class="text-[10px] font-bold text-[#b91c1c] hover:underline mb-1 inline-flex items-center gap-1 transition-colors" title="Lihat semua agenda pada tanggal {{ $newsDateFormatted }}">
                            <svg class="w-3 h-3 text-[#b91c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ $newsDateFormatted }}</span>
                        </a>
                        <h3 class="text-xs sm:text-[13px] font-bold text-slate-900 group-hover/card:text-[#800000] transition-colors leading-snug mb-1.5 line-clamp-2 min-h-[2.1rem]">
                            <a href="{{ route('informasi.show', $news->id) }}">
                                {{ $news->title }}
                            </a>
                        </h3>
                        <p class="text-[11px] text-slate-500 leading-relaxed line-clamp-2 min-h-[1.8rem]">
                            {{ $news->excerpt ?: Str::limit(strip_tags($news->content), 85) }}
                        </p>
                    </div>
                </div>
                <div class="px-3 sm:px-3.5 py-2.5 border-t border-slate-100 flex items-center justify-between text-[10px]">
                    <span class="text-slate-400 font-medium truncate max-w-[110px]">Admin UMKM</span>
                    <a href="{{ route('informasi.show', $news->id) }}" class="font-bold text-[#800000] hover:text-red-900 inline-flex items-center gap-0.5 group-hover/card:translate-x-0.5 transition-transform shrink-0">
                        <span>Baca Lengkap</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>

</div>
@endif

<!-- Hero Slider Script -->
<script>
    (function () {
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-bg-slide');
        const dots = document.querySelectorAll('.hero-dot');
        const totalSlides = slides.length;
        let slideTimer = null;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                if (i === index) {
                    slide.classList.remove('opacity-0', 'scale-105');
                    slide.classList.add('opacity-100', 'scale-100');
                } else {
                    slide.classList.remove('opacity-100', 'scale-100');
                    slide.classList.add('opacity-0', 'scale-105');
                }
            });

            dots.forEach((dot, i) => {
                if (i === index) {
                    dot.classList.remove('w-2.5', 'bg-white/50');
                    dot.classList.add('w-8', 'bg-white');
                } else {
                    dot.classList.remove('w-8', 'bg-white');
                    dot.classList.add('w-2.5', 'bg-white/50');
                }
            });
            currentSlide = index;
        }

        window.setHeroSlide = function (index) {
            showSlide(index);
            restartTimer();
        };

        window.nextHeroSlide = function () {
            let nextIndex = (currentSlide + 1) % totalSlides;
            showSlide(nextIndex);
            restartTimer();
        };

        window.prevHeroSlide = function () {
            let prevIndex = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(prevIndex);
            restartTimer();
        };

        function restartTimer() {
            if (slideTimer) clearInterval(slideTimer);
            slideTimer = setInterval(() => {
                let nextIndex = (currentSlide + 1) % totalSlides;
                showSlide(nextIndex);
            }, 5000);
        }

        // Start auto slide
        restartTimer();
    })();

    // ========================================================
    // Continuous Seamless Stream News Slider (2 Rows)
    // ========================================================
    (function () {
        const row1 = document.getElementById('news-track-row1');
        const row2 = document.getElementById('news-track-row2');
        const wrapper = document.getElementById('news-continuous-wrapper');

        if (!row1 || !row2) return;

        let isPaused = false;
        let isDragging = false;

        // Kecepatan gerakan halus (pixel per frame pada ~60fps)
        const speed1 = 0.75;
        const speed2 = 0.62; // Sedikit berbeda agar pergerakan baris atas & bawah dinamis

        let pos1 = 0;
        let pos2 = 180; // Offset awal baris kedua agar tidak sejajar kaku

        function getHalfWidth(row) {
            return row.scrollWidth / 2;
        }

        function normalizePosition(pos, half) {
            if (half <= 0) return pos;
            while (pos >= half) pos -= half;
            while (pos < 0) pos += half;
            return pos;
        }

        // Terapkan posisi awal
        row2.scrollLeft = pos2;

        let lastTime = performance.now();
        function loop(now) {
            const dt = Math.min((now - lastTime) / 16.67, 3);
            lastTime = now;

            if (!isPaused && !isDragging) {
                const half1 = getHalfWidth(row1);
                const half2 = getHalfWidth(row2);

                if (half1 > 0) {
                    pos1 += speed1 * dt;
                    pos1 = normalizePosition(pos1, half1);
                    row1.scrollLeft = Math.round(pos1);
                }

                if (half2 > 0) {
                    pos2 += speed2 * dt;
                    pos2 = normalizePosition(pos2, half2);
                    row2.scrollLeft = Math.round(pos2);
                }
            }

            requestAnimationFrame(loop);
        }
        requestAnimationFrame(loop);

        // Pause saat kursor diarahkan ke area berita
        if (wrapper) {
            wrapper.addEventListener('mouseenter', () => { isPaused = true; });
            wrapper.addEventListener('mouseleave', () => { 
                if (!isDragging) isPaused = false; 
            });
        }

        // Tombol Manual Prev & Next
        window.scrollNews = function(direction) {
            isPaused = true;
            const step = direction === 'next' ? 275 : -275;

            const half1 = getHalfWidth(row1);
            const half2 = getHalfWidth(row2);

            pos1 = normalizePosition(pos1 + step, half1);
            pos2 = normalizePosition(pos2 + step, half2);

            row1.scrollTo({ left: pos1, behavior: 'smooth' });
            row2.scrollTo({ left: pos2, behavior: 'smooth' });

            // Otomatis jalan lagi setelah jeda 3 detik
            setTimeout(() => {
                isPaused = false;
            }, 3000);
        };

        // Dukungan Drag / Geser dengan Mouse dan Layar Sentuh
        [row1, row2].forEach((row, idx) => {
            let isDown = false;
            let startX = 0;
            let startScroll = 0;
            let hasMoved = false;

            row.addEventListener('mousedown', (e) => {
                isDown = true;
                isDragging = true;
                isPaused = true;
                hasMoved = false;
                startX = e.pageX - row.offsetLeft;
                startScroll = row.scrollLeft;
            });

            window.addEventListener('mouseup', () => {
                if (isDown) {
                    isDown = false;
                    isDragging = false;
                    if (idx === 0) pos1 = row1.scrollLeft;
                    if (idx === 1) pos2 = row2.scrollLeft;
                    setTimeout(() => { isPaused = false; }, 2000);
                }
            });

            row.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                const x = e.pageX - row.offsetLeft;
                const walk = x - startX;
                if (Math.abs(walk) > 6) {
                    hasMoved = true;
                }
                const half = getHalfWidth(row);
                const newPos = normalizePosition(startScroll - walk, half);
                row.scrollLeft = newPos;
                if (idx === 0) pos1 = newPos;
                if (idx === 1) pos2 = newPos;
            });

            // Mencegah klik tautan tidak sengaja saat men-drag
            row.addEventListener('click', (e) => {
                if (hasMoved) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);

            // Sentuhan Layar di Ponsel (Touch Gestures)
            row.addEventListener('touchstart', (e) => {
                isPaused = true;
                startScroll = row.scrollLeft;
                if (e.touches.length > 0) {
                    startX = e.touches[0].pageX - row.offsetLeft;
                }
            }, { passive: true });

            row.addEventListener('touchmove', (e) => {
                if (e.touches.length > 0) {
                    const x = e.touches[0].pageX - row.offsetLeft;
                    const walk = x - startX;
                    const half = getHalfWidth(row);
                    const newPos = normalizePosition(startScroll - walk, half);
                    if (idx === 0) pos1 = newPos;
                    if (idx === 1) pos2 = newPos;
                }
            }, { passive: true });

            row.addEventListener('touchend', () => {
                if (idx === 0) pos1 = row1.scrollLeft;
                if (idx === 1) pos2 = row2.scrollLeft;
                setTimeout(() => { isPaused = false; }, 2500);
            }, { passive: true });
        });
    })();
</script>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
/* Leaflet custom map markers and popups */
.umkm-pin {
    background: transparent !important;
    border: none !important;
}
.umkm-pin-inner {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #991b1b, #800000);
    border: 2px solid #ffffff;
    border-radius: 50% 50% 50% 0;
    transform: rotate(-45deg);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.35);
    transition: transform 0.2s ease, background 0.2s ease;
    cursor: pointer;
}
.umkm-pin-inner:hover, .umkm-pin-inner.active {
    transform: rotate(-45deg) scale(1.22);
    background: linear-gradient(135deg, #b91c1c, #991b1b);
    border-color: #fef08a;
    box-shadow: 0 6px 14px rgba(185, 28, 28, 0.5);
}
.umkm-pin-icon {
    transform: rotate(45deg);
    color: #ffffff;
    width: 14px;
    height: 14px;
}
.leaflet-popup-content-wrapper {
    border-radius: 16px !important;
    padding: 0 !important;
    overflow: hidden;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
    border: 1px solid rgba(226, 232, 240, 0.9);
}
.leaflet-popup-content {
    margin: 0 !important;
    line-height: 1.35;
}
.leaflet-popup-tip {
    background: white;
}
.leaflet-container {
    font-family: inherit;
}
/* Kecamatan label on hover */
.kecamatan-tooltip {
    background: rgba(15, 23, 42, 0.92) !important;
    color: #ffffff !important;
    border: 1px solid rgba(255, 255, 255, 0.15) !important;
    border-radius: 8px !important;
    padding: 4px 8px !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
}
.kecamatan-tooltip::before {
    border-top-color: rgba(15, 23, 42, 0.92) !important;
}
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
(function() {
    // Data seluruh UMKM terverifikasi
    const rawUmkmList = @json($umkmMapList ?? []);
    const geoJsonPath = "{{ asset('wonogiri_kecamatan_thematic.geojson') }}";

    let wonogiriMap = null;
    let geoJsonLayer = null;
    let markersLayer = null;
    let markersMap = {}; // id -> marker instance
    let currentDistrictFilter = '';
    let currentCategoryFilter = '';
    let currentSearchQuery = '';

    const defaultCenter = [-7.915, 111.0];
    const defaultZoom = 10;
    const wonogiriBounds = [
        [-8.25, 110.70],
        [-7.70, 111.35]
    ];

    function initMap() {
        const mapContainer = document.getElementById('wonogiri-map');
        if (!mapContainer || wonogiriMap) return;

        // 1. Inisialisasi peta Leaflet
        wonogiriMap = L.map('wonogiri-map', {
            center: defaultCenter,
            zoom: defaultZoom,
            minZoom: 9,
            maxZoom: 18,
            scrollWheelZoom: true,
            zoomControl: true
        });

        // 2. Base tile OSM yang kontras dan bersih
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(wonogiriMap);

        markersLayer = L.layerGroup().addTo(wonogiriMap);

        // 3. Load GeoJSON batas 25 kecamatan tematik
        fetch(geoJsonPath)
            .then(res => {
                if (!res.ok) throw new Error('Gagal memuat batas wilayah');
                return res.json();
            })
            .then(geoData => {
                const loader = document.getElementById('map-loader');
                if (loader) loader.style.display = 'none';

                renderGeoJsonPolygons(geoData);
                renderUmkmMarkers(rawUmkmList);
                renderSidebarList(rawUmkmList);
            })
            .catch(err => {
                console.warn('GeoJSON fallback mode:', err);
                const loader = document.getElementById('map-loader');
                if (loader) loader.style.display = 'none';

                renderUmkmMarkers(rawUmkmList);
                renderSidebarList(rawUmkmList);
            });
    }

    function renderGeoJsonPolygons(geoData) {
        if (!wonogiriMap) return;

        geoJsonLayer = L.geoJSON(geoData, {
            style: function(feature) {
                const isWater = feature.properties.name === 'Waduk Gajah Mungkur';
                return {
                    fillColor: feature.properties.fillColor || (isWater ? '#7dd3fc' : '#ea580c'),
                    weight: isWater ? 1.5 : 1.2,
                    opacity: 0.9,
                    color: isWater ? '#0284c7' : '#991b1b',
                    dashArray: isWater ? '' : '3',
                    fillOpacity: isWater ? 0.65 : 0.40
                };
            },
            onEachFeature: function(feature, layer) {
                const name = feature.properties.name;
                const isWater = name === 'Waduk Gajah Mungkur';

                // Hitung berapa UMKM di kecamatan ini
                const count = rawUmkmList.filter(u => (u.district || '').toLowerCase() === name.toLowerCase()).length;
                const tooltipText = isWater 
                    ? `<strong>${name}</strong>` 
                    : `<strong>Kecamatan ${name}</strong><br><span style="color:#fde047;">${count} UMKM Terdeteksi</span>`;

                layer.bindTooltip(tooltipText, {
                    sticky: true,
                    className: 'kecamatan-tooltip'
                });

                layer.on({
                    mouseover: function(e) {
                        const l = e.target;
                        l.setStyle({
                            weight: 2.5,
                            color: '#800000',
                            fillOpacity: isWater ? 0.8 : 0.65
                        });
                        l.bringToFront();
                    },
                    mouseout: function(e) {
                        geoJsonLayer.resetStyle(e.target);
                    },
                    click: function(e) {
                        if (!isWater) {
                            const select = document.getElementById('map-district-select');
                            if (select) {
                                select.value = name;
                            }
                            const distLabel = document.getElementById('map-dist-label');
                            if (distLabel) {
                                distLabel.textContent = 'Kecamatan ' + name;
                            }
                            filterMapByDistrict(name);
                            wonogiriMap.fitBounds(e.target.getBounds(), { padding: [30, 30] });
                        }
                    }
                });
            }
        }).addTo(wonogiriMap);
    }

    function renderUmkmMarkers(items) {
        if (!markersLayer) return;
        markersLayer.clearLayers();
        markersMap = {};

        items.forEach(item => {
            if (!item.lat || !item.lng) return;

            const customIcon = L.divIcon({
                className: 'umkm-pin',
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -30],
                html: `
                    <div class="umkm-pin-inner" id="pin-${item.id}" title="${item.name}">
                        <svg class="umkm-pin-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                    </div>
                `
            });

            const marker = L.marker([item.lat, item.lng], { icon: customIcon });

            // Popup card interaktif
            const samplesHtml = item.product_samples && item.product_samples.length > 0
                ? `<div class="text-[11px] text-slate-600 pt-1.5 border-t border-slate-100"><span class="font-bold text-slate-800">Contoh Produk:</span> ${item.product_samples.slice(0, 2).join(', ')}</div>`
                : '';

            const popupContent = `
                <div class="p-0 overflow-hidden w-64 sm:w-72 font-sans text-left">
                    <div class="relative h-28 w-full bg-slate-200 overflow-hidden">
                        <img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent"></div>
                        <div class="absolute top-2 left-2 flex items-center gap-1 bg-white/95 backdrop-blur-xs px-2 py-0.5 rounded-full text-[10px] font-extrabold text-slate-900 shadow-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Kec. ${item.district}
                        </div>
                        <div class="absolute bottom-2 left-2.5 right-2.5 text-white">
                            <h4 class="font-extrabold text-sm leading-tight text-white line-clamp-1 drop-shadow-sm">${item.name}</h4>
                            <p class="text-[11px] text-yellow-300 drop-shadow-xs font-medium">Pemilik: ${item.owner}</p>
                        </div>
                    </div>
                    <div class="p-3 bg-white space-y-2">
                        <div class="text-[11px] text-slate-600 line-clamp-2 leading-relaxed flex items-start gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>${item.address}</span>
                        </div>
                        ${samplesHtml}
                        <div class="pt-2 flex items-center gap-1.5 border-t border-slate-100">
                            <a href="${item.detail_url}" class="flex-1 py-1.5 px-2 bg-[#800000] hover:bg-red-950 text-white text-[11px] font-bold rounded-lg text-center transition-all shadow-2xs">
                                Lihat Toko
                            </a>
                            <a href="${item.directions_url}" target="_blank" rel="noopener" class="py-1.5 px-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-bold rounded-lg transition-all flex items-center gap-1" title="Buka Rute Navigasi Google Maps">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>
                                Rute
                            </a>
                            ${item.whatsapp_url ? `
                            <a href="${item.whatsapp_url}" target="_blank" rel="noopener" class="py-1.5 px-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold rounded-lg transition-all" title="Chat WhatsApp">
                                WA
                            </a>` : ''}
                        </div>
                    </div>
                </div>
            `;

            marker.bindPopup(popupContent, { maxWidth: 300 });
            marker.addTo(markersLayer);
            markersMap[item.id] = marker;
        });
    }

    function renderSidebarList(items) {
        const container = document.getElementById('sidebar-umkm-list');
        const countBadge = document.getElementById('sidebar-count-badge');
        if (!container) return;

        if (countBadge) {
            countBadge.innerText = `${items.length} Titik`;
        }

        if (items.length === 0) {
            container.innerHTML = `
                <div class="h-full flex flex-col items-center justify-center p-6 text-center text-slate-400">
                    <svg class="w-12 h-12 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p class="text-xs font-bold text-slate-600">Tidak ada UMKM yang cocok</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Coba ubah kata kunci pencarian atau pilih kecamatan lain.</p>
                </div>
            `;
            return;
        }

        let html = '';
        items.forEach(item => {
            html += `
                <div onclick="focusUmkmOnMap(${item.id})" 
                     class="p-2.5 rounded-xl border border-slate-200/80 hover:border-[#800000] hover:bg-red-50/30 transition-all cursor-pointer bg-white group shadow-2xs">
                    <div class="flex items-start gap-2.5">
                        <img src="${item.image}" alt="${item.name}" class="w-11 h-11 rounded-lg object-cover shrink-0 border border-slate-100">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-1">
                                <h4 class="text-xs font-bold text-slate-800 truncate group-hover:text-[#800000] transition-colors">${item.name}</h4>
                                <span class="text-[9px] px-1.5 py-0.5 rounded-full font-bold bg-slate-100 text-slate-600 shrink-0">Kec. ${item.district}</span>
                            </div>
                            <p class="text-[11px] text-slate-500 truncate mt-0.5">Pemilik: ${item.owner}</p>
                            <p class="text-[10px] text-slate-400 truncate mt-0.5 flex items-center gap-1">
                                <svg class="w-2.5 h-2.5 text-red-700" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>
                                <span>${item.village ? 'Desa ' + item.village + ', ' : ''}Kec. ${item.district}</span>
                            </p>
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    function applyFilters() {
        let filtered = rawUmkmList.slice();

        // Filter Kecamatan
        if (currentDistrictFilter) {
            const dLower = currentDistrictFilter.toLowerCase();
            filtered = filtered.filter(u => (u.district || '').toLowerCase().includes(dLower) || (u.address || '').toLowerCase().includes(dLower));
        }

        // Filter Kategori
        if (currentCategoryFilter) {
            const cLower = currentCategoryFilter.toLowerCase();
            filtered = filtered.filter(u => (u.category || '').toLowerCase().includes(cLower));
        }

        // Filter Pencarian
        if (currentSearchQuery) {
            const q = currentSearchQuery.toLowerCase();
            filtered = filtered.filter(u => 
                (u.name || '').toLowerCase().includes(q) ||
                (u.owner || '').toLowerCase().includes(q) ||
                (u.district || '').toLowerCase().includes(q) ||
                (u.village || '').toLowerCase().includes(q) ||
                (u.address || '').toLowerCase().includes(q) ||
                (u.category || '').toLowerCase().includes(q) ||
                (u.product_samples || []).some(s => s.toLowerCase().includes(q))
            );
        }

        renderUmkmMarkers(filtered);
        renderSidebarList(filtered);
    }

    // Public controller functions on window
    window.filterMapByDistrict = function(district) {
        currentDistrictFilter = district;
        applyFilters();

        if (district && wonogiriMap) {
            let foundFeature = false;
            if (geoJsonLayer) {
                geoJsonLayer.eachLayer(layer => {
                    if (layer.feature && layer.feature.properties && layer.feature.properties.name.toLowerCase() === district.toLowerCase()) {
                        wonogiriMap.fitBounds(layer.getBounds(), { padding: [40, 40], maxZoom: 13 });
                        foundFeature = true;
                    }
                });
            }

            if (!foundFeature) {
                const matchingMarkers = Object.values(markersMap);
                if (matchingMarkers.length > 0) {
                    const group = L.featureGroup(matchingMarkers);
                    wonogiriMap.fitBounds(group.getBounds().pad(0.2));
                }
            }
        } else if (!district && wonogiriMap) {
            resetWonogiriMap();
        }
    };

    window.filterMapByCategory = function(category) {
        currentCategoryFilter = category;
        const catSelect = document.getElementById('map-category-select');
        if (catSelect && catSelect.value !== category) {
            catSelect.value = category;
        }
        applyFilters();
    };

    window.focusUmkmOnMap = function(id) {
        const marker = markersMap[id];
        if (marker && wonogiriMap) {
            wonogiriMap.flyTo(marker.getLatLng(), 14, {
                duration: 1.0,
                easeLinearity: 0.25
            });
            setTimeout(() => {
                marker.openPopup();
            }, 600);
        }
    };

    window.closeAllMapDropdowns = function() {
        const distPanel = document.getElementById('map-dist-panel');
        const catPanel = document.getElementById('map-cat-panel');
        const distArrow = document.getElementById('map-dist-arrow');
        const catArrow = document.getElementById('map-cat-arrow');
        const distBox = document.getElementById('map-dist-container');
        const catBox = document.getElementById('map-cat-container');
        const mapFilterCard = document.getElementById('map-filter-container');
        if (distPanel) distPanel.classList.add('hidden');
        if (catPanel) catPanel.classList.add('hidden');
        if (distArrow) distArrow.classList.remove('rotate-180');
        if (catArrow) catArrow.classList.remove('rotate-180');
        if (distBox) {
            distBox.classList.remove('z-40');
            distBox.classList.add('z-20');
        }
        if (catBox) {
            catBox.classList.remove('z-40');
            catBox.classList.add('z-10');
        }
        if (mapFilterCard) {
            mapFilterCard.classList.remove('z-40');
            mapFilterCard.classList.add('z-30');
        }
    };

    window.selectMapDistrict = function(dist, label) {
        const select = document.getElementById('map-district-select');
        const labelEl = document.getElementById('map-dist-label');
        if (select) select.value = dist;
        if (labelEl) labelEl.textContent = label;

        document.querySelectorAll('.map-dist-opt').forEach(btn => {
            const val = btn.getAttribute('data-val');
            const check = btn.querySelector('.check-icon');
            if (val === dist) {
                btn.classList.add('bg-red-50', 'text-[#800000]');
                btn.classList.remove('text-slate-700', 'hover:bg-slate-50');
                if (check) check.classList.remove('hidden');
            } else {
                btn.classList.remove('bg-red-50', 'text-[#800000]');
                btn.classList.add('text-slate-700', 'hover:bg-slate-50');
                if (check) check.classList.add('hidden');
            }
        });

        closeAllMapDropdowns();
        filterMapByDistrict(dist);
    };

    window.selectMapCategory = function(cat, label) {
        const select = document.getElementById('map-category-select');
        const labelEl = document.getElementById('map-cat-label');
        if (select) select.value = cat;
        if (labelEl) labelEl.textContent = label;

        document.querySelectorAll('.map-cat-opt').forEach(btn => {
            const val = btn.getAttribute('data-val');
            const check = btn.querySelector('.check-icon');
            if (val === cat) {
                btn.classList.add('bg-red-50', 'text-[#800000]');
                btn.classList.remove('text-slate-700', 'hover:bg-slate-50');
                if (check) check.classList.remove('hidden');
            } else {
                btn.classList.remove('bg-red-50', 'text-[#800000]');
                btn.classList.add('text-slate-700', 'hover:bg-slate-50');
                if (check) check.classList.add('hidden');
            }
        });

        closeAllMapDropdowns();
        filterMapByCategory(cat);
    };

    window.resetWonogiriMap = function() {
        currentDistrictFilter = '';
        currentCategoryFilter = '';
        currentSearchQuery = '';

        const select = document.getElementById('map-district-select');
        if (select) select.value = '';
        const distLabel = document.getElementById('map-dist-label');
        if (distLabel) distLabel.textContent = 'Semua Kecamatan (25 Wilayah)';

        const catSelect = document.getElementById('map-category-select');
        if (catSelect) catSelect.value = '';
        const catLabel = document.getElementById('map-cat-label');
        if (catLabel) catLabel.textContent = 'Semua Kategori Produk';

        const search = document.getElementById('map-search-input');
        if (search) search.value = '';

        applyFilters();

        if (wonogiriMap) {
            wonogiriMap.fitBounds(wonogiriBounds, { padding: [20, 20] });
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        initMap();

        const searchInput = document.getElementById('map-search-input');
        if (searchInput) {
            let debounceTimer = null;
            searchInput.addEventListener('input', function(e) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    currentSearchQuery = e.target.value.trim();
                    applyFilters();
                }, 200);
            });
        }

        // Dropdown toggle buttons
        const distBtn = document.getElementById('map-dist-btn');
        const catBtn = document.getElementById('map-cat-btn');
        const distPanel = document.getElementById('map-dist-panel');
        const catPanel = document.getElementById('map-cat-panel');
        const distArrow = document.getElementById('map-dist-arrow');
        const catArrow = document.getElementById('map-cat-arrow');
        const distSearch = document.getElementById('map-dist-search');

        const distBox = document.getElementById('map-dist-container');
        const catBox = document.getElementById('map-cat-container');
        const mapFilterCard = document.getElementById('map-filter-container');

        if (distBtn) {
            distBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isClosed = distPanel.classList.contains('hidden');
                closeAllMapDropdowns();
                if (isClosed) {
                    distPanel.classList.remove('hidden');
                    if (distArrow) distArrow.classList.add('rotate-180');
                    if (distBox) {
                        distBox.classList.remove('z-20');
                        distBox.classList.add('z-40');
                    }
                    if (mapFilterCard) {
                        mapFilterCard.classList.remove('z-30');
                        mapFilterCard.classList.add('z-40');
                    }
                    if (distSearch) {
                        setTimeout(() => distSearch.focus(), 100);
                    }
                }
            });
        }

        if (catBtn) {
            catBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isClosed = catPanel.classList.contains('hidden');
                closeAllMapDropdowns();
                if (isClosed) {
                    catPanel.classList.remove('hidden');
                    if (catArrow) catArrow.classList.add('rotate-180');
                    if (catBox) {
                        catBox.classList.remove('z-10');
                        catBox.classList.add('z-40');
                    }
                    if (mapFilterCard) {
                        mapFilterCard.classList.remove('z-30');
                        mapFilterCard.classList.add('z-40');
                    }
                }
            });
        }

        if (distSearch) {
            distSearch.addEventListener('input', function() {
                const q = this.value.toLowerCase().trim();
                document.querySelectorAll('.map-dist-opt').forEach(item => {
                    const name = (item.getAttribute('data-name') || '').toLowerCase();
                    if (name.includes(q)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        document.addEventListener('click', function(e) {
            const distCont = document.getElementById('map-dist-container');
            const catCont = document.getElementById('map-cat-container');
            if (distCont && !distCont.contains(e.target) && catCont && !catCont.contains(e.target)) {
                closeAllMapDropdowns();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAllMapDropdowns();
            }
        });
    });

    if (window.location.hash === '#peta-sebaran-umkm') {
        setTimeout(() => {
            document.getElementById('peta-sebaran-umkm')?.scrollIntoView({ behavior: 'smooth' });
            if (wonogiriMap) wonogiriMap.invalidateSize();
        }, 300);
    }
})();
</script>
@endpush

@endsection
