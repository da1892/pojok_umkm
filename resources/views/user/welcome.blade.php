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

<!-- 4 Cards Section (Geser ke bawah, berada di bawah Hero dengan jarak lega) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 mt-8 sm:mt-10 md:mt-14 mb-20 reveal delay-200">
    <div class="bg-white rounded-3xl p-8 sm:p-10 md:p-12 lg:p-14 shadow-sm border border-slate-200/80">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-7 md:gap-8 lg:gap-8 xl:gap-9">
            
            <!-- Card 1: Profil UMKM -->
            <a href="/direktori" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/90 shadow-sm hover:shadow-lg hover:border-red-200 transition-all duration-300 transform hover:-translate-y-1 group flex flex-col justify-start">
                <div class="w-12 h-12 rounded-full bg-red-50 text-[#991b1b] flex items-center justify-center mb-5 group-hover:scale-105 group-hover:bg-[#991b1b] group-hover:text-white transition-all shadow-xs">
                    <!-- Ribbon / Medal Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 12l-2 8 5.5-2.5 5.5 2.5-2-8" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2 group-hover:text-[#991b1b] transition-colors">Profil UMKM</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">Kenali profil ribuan UMKM tangguh di seluruh pelosok Wonogiri.</p>
            </a>

            <!-- Card 2: Produk UMKM -->
            <a href="/katalog" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/90 shadow-sm hover:shadow-lg hover:border-red-200 transition-all duration-300 transform hover:-translate-y-1 group flex flex-col justify-start">
                <div class="w-12 h-12 rounded-full bg-red-50 text-[#991b1b] flex items-center justify-center mb-5 group-hover:scale-105 group-hover:bg-[#991b1b] group-hover:text-white transition-all shadow-xs">
                    <!-- Shopping Bag Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25c-.669 0-1.189-.578-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2 group-hover:text-[#991b1b] transition-colors">Produk UMKM</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">Katalog kurasi produk lokal mulai dari kuliner hingga kriya bersertifikat.</p>
            </a>

            <!-- Card 3: Berita & Kegiatan -->
            <a href="/informasi" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/90 shadow-sm hover:shadow-lg hover:border-red-200 transition-all duration-300 transform hover:-translate-y-1 group flex flex-col justify-start">
                <div class="w-12 h-12 rounded-full bg-red-50 text-[#991b1b] flex items-center justify-center mb-5 group-hover:scale-105 group-hover:bg-[#991b1b] group-hover:text-white transition-all shadow-xs">
                    <!-- Calendar Event Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2 group-hover:text-[#991b1b] transition-colors">Berita & Kegiatan</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">Informasi bazar, pameran, pelatihan, dan program pemberdayaan terkini.</p>
            </a>

            <!-- Card 4: Informasi & Panduan -->
            <a href="/konsultasi" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/90 shadow-sm hover:shadow-lg hover:border-red-200 transition-all duration-300 transform hover:-translate-y-1 group flex flex-col justify-start">
                <div class="w-12 h-12 rounded-full bg-red-50 text-[#991b1b] flex items-center justify-center mb-5 group-hover:scale-105 group-hover:bg-[#991b1b] group-hover:text-white transition-all shadow-xs">
                    <!-- Info Circle Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2 group-hover:text-[#991b1b] transition-colors">Informasi & Panduan</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">Panduan lengkap sertifikasi halal, PIRT, legalitas NIB gratis.</p>
            </a>

        </div>
    </div>
</div>

<!-- Eksplor Kategori Produk -->
<div id="kategori" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-14 reveal delay-300">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Eksplor Kategori Produk</h2>
            <p class="text-slate-500 text-sm mt-1">Pilihan ragam produk komoditas lokal Wonogiri berkualitas.</p>
        </div>
        <a href="/katalog" class="hidden sm:inline-flex items-center gap-1.5 text-sm font-semibold text-[#991b1b] hover:underline">
            Lihat Semua Kategori &rarr;
        </a>
    </div>
    
    <div class="flex flex-wrap gap-2.5">
        <a href="/katalog?kategori=makanan" class="px-5 py-2.5 bg-[#991b1b] text-white rounded-full text-xs sm:text-sm font-semibold shadow-sm hover:bg-[#801414] transition-colors">Makanan & Minuman</a>
        <a href="/katalog?kategori=kerajinan" class="px-5 py-2.5 bg-white text-slate-700 border border-slate-200 rounded-full text-xs sm:text-sm font-medium hover:bg-red-50 hover:text-[#991b1b] hover:border-red-200 transition-colors shadow-sm">Kerajinan & Kriya</a>
        <a href="/katalog?kategori=batik" class="px-5 py-2.5 bg-white text-slate-700 border border-slate-200 rounded-full text-xs sm:text-sm font-medium hover:bg-red-50 hover:text-[#991b1b] hover:border-red-200 transition-colors shadow-sm">Batik & Fashion</a>
        <a href="/katalog?kategori=pertanian" class="px-5 py-2.5 bg-white text-slate-700 border border-slate-200 rounded-full text-xs sm:text-sm font-medium hover:bg-red-50 hover:text-[#991b1b] hover:border-red-200 transition-colors shadow-sm">Olahan Hasil Tani</a>
        <a href="/katalog?kategori=kreatif" class="px-5 py-2.5 bg-white text-slate-700 border border-slate-200 rounded-full text-xs sm:text-sm font-medium hover:bg-red-50 hover:text-[#991b1b] hover:border-red-200 transition-colors shadow-sm">Ekonomi Kreatif</a>
    </div>
</div>

<!-- Produk Unggulan Terbaru -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24 reveal delay-400">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Produk Unggulan Terbaru</h2>
            <p class="text-slate-500 text-sm mt-1">Produk-produk pilihan asli Wonogiri yang telah terkurasi kualitasnya.</p>
        </div>
        <a href="/katalog" class="hidden md:flex items-center gap-1.5 text-[#991b1b] font-bold text-sm hover:underline">
            Katalog Selengkapnya &rarr;
        </a>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @for ($i = 1; $i <= 6; $i++)
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-slate-100 group hover:-translate-y-1 transition-all duration-300">
            <div class="h-52 bg-slate-100 relative overflow-hidden flex items-center justify-center text-slate-400">
                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <div class="absolute top-3 left-3">
                    <span class="bg-white/90 backdrop-blur-sm text-[#991b1b] text-xs font-bold px-3 py-1 rounded-full shadow-xs border border-red-100">Kuliner Wonogiri</span>
                </div>
            </div>
            <div class="p-5">
                <h3 class="text-base font-bold text-slate-800 mb-1 group-hover:text-[#991b1b] transition-colors">Produk UMKM Pilihan #{{ $i }}</h3>
                <p class="text-xs text-slate-500 mb-4">oleh <span class="font-medium text-slate-700">UMKM Maju Bersama</span></p>
                <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                    <span class="text-xs text-slate-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Purwantoro
                    </span>
                    <a href="/katalog" class="text-[#991b1b] font-bold text-xs hover:underline">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endfor
    </div>
    
    <div class="mt-8 text-center md:hidden">
        <a href="/katalog" class="inline-block bg-white text-[#991b1b] border border-[#991b1b] px-6 py-2.5 rounded-lg text-sm font-bold shadow-xs hover:bg-red-50 transition-colors">Lihat Semua Produk</a>
    </div>
</div>

<!-- Statistik Banner -->
<div class="bg-[#8b1818] text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-red-800/60">
            <div class="p-3">
                <div class="text-4xl sm:text-5xl font-extrabold text-[#facc15] mb-1.5">1.250+</div>
                <div class="text-red-100 text-sm sm:text-base font-medium">UMKM Bergabung</div>
            </div>
            <div class="p-3">
                <div class="text-4xl sm:text-5xl font-extrabold text-[#facc15] mb-1.5">3.400+</div>
                <div class="text-red-100 text-sm sm:text-base font-medium">Produk Terdaftar</div>
            </div>
            <div class="p-3">
                <div class="text-4xl sm:text-5xl font-extrabold text-[#facc15] mb-1.5">890+</div>
                <div class="text-red-100 text-sm sm:text-base font-medium">Konsultasi Sukses</div>
            </div>
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
