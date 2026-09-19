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
            <a href="#kategori" class="inline-flex items-center justify-center border-2 border-white/80 hover:border-white hover:bg-white/10 text-white font-semibold text-sm sm:text-base px-6 sm:px-8 py-3.5 rounded-lg transition-all transform hover:-translate-y-0.5">
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
            <a href="/direktori" class="bg-white rounded-xl sm:rounded-2xl p-3.5 sm:p-6 border border-slate-200/90 shadow-xs hover:shadow-lg hover:border-red-200 transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-start">
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
            <a href="/katalog" class="bg-white rounded-xl sm:rounded-2xl p-3.5 sm:p-6 border border-slate-200/90 shadow-xs hover:shadow-lg hover:border-red-200 transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-start">
                <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-full bg-red-50 text-[#991b1b] flex items-center justify-center mb-3 sm:mb-5 group-hover:scale-105 group-hover:bg-[#991b1b] group-hover:text-white transition-all shadow-xs">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25c-.669 0-1.189-.578-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </div>
                <h3 class="text-xs sm:text-base font-bold text-slate-900 mb-1 group-hover:text-[#991b1b] transition-colors leading-snug">Produk UMKM</h3>
                <p class="text-[10px] sm:text-sm text-slate-500 leading-snug line-clamp-2">Katalog kurasi produk lokal mulai kuliner hingga kriya bersertifikat.</p>
            </a>

            <!-- Card 3: Berita & Kegiatan -->
            <a href="/informasi" class="bg-white rounded-xl sm:rounded-2xl p-3.5 sm:p-6 border border-slate-200/90 shadow-xs hover:shadow-lg hover:border-red-200 transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-start">
                <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-full bg-red-50 text-[#991b1b] flex items-center justify-center mb-3 sm:mb-5 group-hover:scale-105 group-hover:bg-[#991b1b] group-hover:text-white transition-all shadow-xs">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/>
                    </svg>
                </div>
                <h3 class="text-xs sm:text-base font-bold text-slate-900 mb-1 group-hover:text-[#991b1b] transition-colors leading-snug">Berita & Kegiatan</h3>
                <p class="text-[10px] sm:text-sm text-slate-500 leading-snug line-clamp-2">Informasi bazar, pameran, pelatihan, dan pemberdayaan terkini.</p>
            </a>

            <!-- Card 4: Informasi & Panduan -->
            <a href="/konsultasi" class="bg-white rounded-xl sm:rounded-2xl p-3.5 sm:p-6 border border-slate-200/90 shadow-xs hover:shadow-lg hover:border-red-200 transition-all duration-300 transform hover:-translate-y-0.5 group flex flex-col justify-start">
                <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-full bg-red-50 text-[#991b1b] flex items-center justify-center mb-3 sm:mb-5 group-hover:scale-105 group-hover:bg-[#991b1b] group-hover:text-white transition-all shadow-xs">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                    </svg>
                </div>
                <h3 class="text-xs sm:text-base font-bold text-slate-900 mb-1 group-hover:text-[#991b1b] transition-colors leading-snug">Info & Panduan</h3>
                <p class="text-[10px] sm:text-sm text-slate-500 leading-snug line-clamp-2">Panduan lengkap sertifikasi halal, PIRT, legalitas NIB gratis.</p>
            </a>

        </div>
    </div>
</div>

<!-- Eksplor Kategori Produk (Horizontal Swipeable on mobile) -->
<div id="kategori" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10 sm:mb-14 reveal delay-300">
    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 mb-3 sm:mb-4">Eksplor Kategori Produk</h2>
    <div class="flex items-center gap-2 sm:gap-3 overflow-x-auto pb-2 -mx-4 px-4 sm:mx-0 sm:px-0 sm:flex-wrap" style="scrollbar-width: none; -ms-overflow-style: none;">
        <a href="/katalog?kategori=makanan" class="px-4 sm:px-5 py-2 rounded-full bg-[#991b1b] text-white text-xs sm:text-sm font-semibold shadow-xs hover:bg-[#801414] transition-all whitespace-nowrap shrink-0">
            Makanan & Minuman
        </a>
        <a href="/katalog?kategori=kerajinan" class="px-4 sm:px-5 py-2 rounded-full bg-white text-slate-800 border border-slate-200 text-xs sm:text-sm font-medium hover:bg-slate-50 transition-all shadow-xs whitespace-nowrap shrink-0">
            Kerajinan
        </a>
        <a href="/katalog?kategori=batik" class="px-4 sm:px-5 py-2 rounded-full bg-white text-slate-800 border border-slate-200 text-xs sm:text-sm font-medium hover:bg-slate-50 transition-all shadow-xs whitespace-nowrap shrink-0">
            Batik/Fashion
        </a>
        <a href="/katalog?kategori=pertanian" class="px-4 sm:px-5 py-2 rounded-full bg-white text-slate-800 border border-slate-200 text-xs sm:text-sm font-medium hover:bg-slate-50 transition-all shadow-xs whitespace-nowrap shrink-0">
            Olahan Hasil Pertanian
        </a>
        <a href="/katalog?kategori=kreatif" class="px-4 sm:px-5 py-2 rounded-full bg-white text-slate-800 border border-slate-200 text-xs sm:text-sm font-medium hover:bg-slate-50 transition-all shadow-xs whitespace-nowrap shrink-0">
            Produk Kreatif
        </a>
    </div>
</div>

<!-- Produk Unggulan Terbaru -->
@php
    $featuredProducts = [
        [
            'name' => 'Tiwul',
            'category' => 'Makanan',
            'seller' => 'Rasa Lestari',
            'location' => 'Kec. Ngadirojo',
            'image' => asset('img/products/tiwul.jpg')
        ],
        [
            'name' => 'Tas Rotan',
            'category' => 'Kerajinan',
            'seller' => 'Kriya Mandiri',
            'location' => 'Kec. Wuryantoro',
            'image' => asset('img/products/tas_rotan.jpg')
        ],
        [
            'name' => 'Batik Tulis Premium',
            'category' => 'Batik/Fashion',
            'seller' => 'Batik Sekar Arum',
            'location' => 'Kec. Wonogiri',
            'image' => asset('img/products/batik_tulis.jpg')
        ],
        [
            'name' => 'Keripik Singkong',
            'category' => 'Makanan',
            'seller' => 'UD Sari Rasa',
            'location' => 'Kec. Selogiri',
            'image' => asset('img/products/keripik_singkong.jpg')
        ],
        [
            'name' => 'Piring Hias',
            'category' => 'Kerajinan',
            'seller' => 'Logam Jaya',
            'location' => 'Kec. Purwantoro',
            'image' => asset('img/products/piring_hias.jpg')
        ],
        [
            'name' => 'Jahe Merah',
            'category' => 'Olahan Hasil Pertanian',
            'seller' => 'Sido Muncul Wonogiri',
            'location' => 'Kec. Bulukerto',
            'image' => asset('img/products/jahe_merah.jpg')
        ],
    ];
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 sm:mb-14 reveal delay-400">
    <div class="flex flex-row items-center justify-between gap-4 mb-8 flex-wrap sm:flex-nowrap">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Produk Unggulan Terbaru</h2>
            <p class="text-slate-500 text-xs sm:text-sm mt-1">Produk-produk pilihan asli Wonogiri yang telah lulus kurasi kualitas Dinas Perdagangan.</p>
        </div>
        <a href="/katalog" class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 bg-white border border-[#991b1b] text-[#991b1b] hover:bg-red-50 rounded-lg text-xs sm:text-sm font-semibold transition-all shadow-2xs shrink-0 whitespace-nowrap self-start sm:self-center" style="width: fit-content; max-width: max-content;">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-[#991b1b] shrink-0" viewBox="0 0 24 24" fill="currentColor">
                <path d="M4 4h3.5v3.5H4V4zm6.25 0h3.5v3.5h-3.5V4zm6.25 0H20v3.5h-3.5V4zM4 10.25h3.5v3.5H4v-3.5zm6.25 0h3.5v3.5h-3.5v-3.5zm6.25 0H20v3.5h-3.5v-3.5zM4 16.5h3.5V20H4v-3.5zm6.25 0h3.5V20h-3.5v-3.5zm6.25 0H20V20h-3.5v-3.5z"/>
            </svg>
            <span>Katalog Selengkapnya</span>
        </a>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
        @foreach ($featuredProducts as $product)
        <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-xs hover:shadow-md hover:border-red-100 transition-all duration-300 group flex flex-col justify-between">
            <div>
                <div class="h-52 w-full overflow-hidden bg-slate-100 relative">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5 pb-0">
                    <span class="inline-block bg-red-50 text-[#991b1b] text-[11px] font-semibold px-2.5 py-0.5 rounded-md mb-2">
                        {{ $product['category'] }}
                    </span>
                    <h3 class="text-base font-bold text-slate-900 group-hover:text-[#991b1b] transition-colors leading-snug">
                        {{ $product['name'] }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        oleh {{ $product['seller'] }}
                    </p>
                </div>
            </div>
            <div class="p-5 pt-4">
                <div class="flex items-center justify-between pt-3 border-t border-slate-100 text-xs">
                    <div class="flex items-center gap-1.5 text-slate-500 font-medium">
                        <svg class="w-3.5 h-3.5 text-[#991b1b] shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $product['location'] }}</span>
                    </div>
                    <a href="/katalog" class="text-[#991b1b] font-bold hover:underline">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Statistik Banner (Always 3 columns) -->
<div class="bg-[#801414] text-white py-5 sm:py-8">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="grid grid-cols-3 gap-2 sm:gap-8 text-center items-center">
            <div class="flex flex-col items-center justify-center">
                <div class="text-xl sm:text-3xl md:text-4xl lg:text-[40px] font-black text-[#facc15] mb-1 sm:mb-2 leading-none tracking-tight">1.234+</div>
                <div class="text-white text-[10px] sm:text-xs md:text-sm font-semibold leading-tight">Jumlah UMKM Terdaftar</div>
            </div>
            <div class="flex flex-col items-center justify-center">
                <div class="text-xl sm:text-3xl md:text-4xl lg:text-[40px] font-black text-[#facc15] mb-1 sm:mb-2 leading-none tracking-tight">4.567+</div>
                <div class="text-white text-[10px] sm:text-xs md:text-sm font-semibold leading-tight">Produk Terpublikasi</div>
            </div>
            <div class="flex flex-col items-center justify-center">
                <div class="text-xl sm:text-3xl md:text-4xl lg:text-[40px] font-black text-[#facc15] mb-1 sm:mb-2 leading-none tracking-tight">890+</div>
                <div class="text-white text-[10px] sm:text-xs md:text-sm font-semibold leading-tight">Konsultasi Selesai</div>
            </div>
        </div>
    </div>
</div>

<!-- Berita & Kegiatan Terkini Section -->
@php
    $latestNews = [
        [
            'title' => 'Bimtek Pemasaran Digital UMKM Wonogiri Go-Glo...',
            'date' => '12 Oktober 2025',
            'excerpt' => 'Dinas Perdagangan dan KUKM Kabupaten Wonogiri terus mempercepat akselerasi digitalisasi...',
            'image' => asset('img/news/bimtek.jpg'),
            'link' => '/informasi'
        ],
        [
            'title' => 'Fasilitasi Sertifikasi Halal Gratis Tahap Ke-III',
            'date' => '28 September 2025',
            'excerpt' => 'Dinas Perdagangan dan KUKM Kabupaten Wonogiri terus mempercepat akselerasi digitalisasi...',
            'image' => asset('img/news/halal.jpg'),
            'link' => '/informasi'
        ],
        [
            'title' => 'Pameran Produk Unggulan di Alun-Alun Wonogiri',
            'date' => '15 September 2025',
            'excerpt' => 'Dinas Perdagangan dan KUKM Kabupaten Wonogiri terus mempercepat akselerasi digitalisasi...',
            'image' => asset('img/news/pameran.jpg'),
            'link' => '/informasi'
        ],
    ];
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 sm:pt-12 pb-16 sm:pb-20 reveal delay-300">
    <div class="mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Berita & Kegiatan Terkini</h2>
        <p class="text-slate-500 text-xs sm:text-sm mt-1">Ikuti berbagai perkembangan program fasilitasi dan peningkatan daya saing lokal.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
        @foreach ($latestNews as $news)
        <a href="{{ $news['link'] }}" class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-2xs hover:shadow-md hover:-translate-y-1 transition-all duration-300 group flex flex-col justify-between">
            <div>
                <div class="h-48 sm:h-52 w-full overflow-hidden bg-slate-100 relative">
                    <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <span class="text-xs font-bold text-[#b91c1c] mb-2 block">
                        {{ $news['date'] }}
                    </span>
                    <h3 class="text-base font-bold text-slate-900 group-hover:text-[#991b1b] transition-colors leading-snug mb-2 line-clamp-1">
                        {{ $news['title'] }}
                    </h3>
                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                        {{ $news['excerpt'] }}
                    </p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>

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
</script>

@endsection
