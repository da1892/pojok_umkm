@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<div class="relative bg-[#800000] w-full pt-20 pb-40 flex items-center justify-center text-center overflow-hidden">
    <!-- Background Pattern/Overlay (Subtle) -->
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 reveal">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight">
            Pojok UMKM Kabupaten Wonogiri
        </h1>
        <p class="text-lg md:text-xl text-red-100 mb-10 max-w-2xl mx-auto leading-relaxed">
            Wadah informasi resmi, kurasi, dan promosi produk unggulan UMKM Wonogiri sukses mendunia.
        </p>
        <a href="/katalog" class="inline-flex items-center gap-2 bg-yellow-500 text-yellow-950 px-8 py-4 rounded-full font-bold text-lg hover:bg-yellow-400 transition-all shadow-lg hover:shadow-xl hover-scale">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            Lihat Produk UMKM
        </a>
    </div>
</div>

<!-- 4 Overlapping Cards -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 -mt-24 mb-16 reveal delay-200">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <a href="/direktori" class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all border border-slate-100 group">
            <div class="w-12 h-12 bg-red-50 text-[#800000] rounded-xl flex items-center justify-center mb-4 group-hover:bg-[#800000] group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h3 class="font-bold text-slate-900 mb-2">Profil UMKM</h3>
            <p class="text-sm text-slate-500">Kenali profil ribuan UMKM tangguh di seluruh pelosok Wonogiri.</p>
        </a>
        
        <!-- Card 2 -->
        <a href="/katalog" class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all border border-slate-100 group">
            <div class="w-12 h-12 bg-red-50 text-[#800000] rounded-xl flex items-center justify-center mb-4 group-hover:bg-[#800000] group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <h3 class="font-bold text-slate-900 mb-2">Produk UMKM</h3>
            <p class="text-sm text-slate-500">Katalog kurasi produk lokal mulai dari kuliner hingga kriya bersertifikat.</p>
        </a>
        
        <!-- Card 3 -->
        <a href="/informasi" class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all border border-slate-100 group">
            <div class="w-12 h-12 bg-red-50 text-[#800000] rounded-xl flex items-center justify-center mb-4 group-hover:bg-[#800000] group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="font-bold text-slate-900 mb-2">Berita & Kegiatan</h3>
            <p class="text-sm text-slate-500">Informasi bazar, pameran, pelatihan, dan program pemberdayaan terkini.</p>
        </a>
        
        <!-- Card 4 -->
        <a href="/konsultasi" class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all border border-slate-100 group">
            <div class="w-12 h-12 bg-red-50 text-[#800000] rounded-xl flex items-center justify-center mb-4 group-hover:bg-[#800000] group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="font-bold text-slate-900 mb-2">Informasi & Panduan</h3>
            <p class="text-sm text-slate-500">Panduan lengkap sertifikasi halal, PIRT, legalitas NIB gratis.</p>
        </a>
    </div>
</div>

<!-- Eksplor Kategori Produk -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 reveal delay-300">
    <h2 class="text-2xl font-bold text-slate-900 mb-6">Eksplor Kategori Produk</h2>
    <div class="flex flex-wrap gap-3">
        <a href="#" class="px-6 py-2.5 bg-[#800000] text-white rounded-full text-sm font-semibold shadow-md transition-colors">Makanan & Minuman</a>
        <a href="#" class="px-6 py-2.5 bg-white text-slate-700 border border-slate-200 rounded-full text-sm font-medium hover:bg-red-50 hover:text-[#800000] transition-colors shadow-sm">Kerajinan</a>
        <a href="#" class="px-6 py-2.5 bg-white text-slate-700 border border-slate-200 rounded-full text-sm font-medium hover:bg-red-50 hover:text-[#800000] transition-colors shadow-sm">Batik/Fashion</a>
        <a href="#" class="px-6 py-2.5 bg-white text-slate-700 border border-slate-200 rounded-full text-sm font-medium hover:bg-red-50 hover:text-[#800000] transition-colors shadow-sm">Olahan Hasil Pertanian</a>
        <a href="#" class="px-6 py-2.5 bg-white text-slate-700 border border-slate-200 rounded-full text-sm font-medium hover:bg-red-50 hover:text-[#800000] transition-colors shadow-sm">Produk Kreatif</a>
    </div>
</div>

<!-- Produk Unggulan Terbaru -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24 reveal delay-400">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-900 mb-2">Produk Unggulan Terbaru</h2>
            <p class="text-slate-500">Produk-produk pilihan asli Wonogiri yang telah lulus kurasi kualitas Dinas Perdagangan.</p>
        </div>
        <a href="/katalog" class="hidden md:flex items-center gap-2 text-[#800000] font-bold hover:underline">
            Katalog Selengkapnya
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @for ($i = 1; $i <= 6; $i++)
        <!-- Product Card Placeholder -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-slate-100 group hover:-translate-y-1 transition-all duration-300">
            <!-- Empty Image Box -->
            <div class="h-56 bg-slate-200 relative overflow-hidden flex items-center justify-center text-slate-400">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <div class="absolute top-4 left-4 z-20">
                    <span class="bg-slate-400 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">Kategori</span>
                </div>
            </div>
            <!-- Empty Text Details -->
            <div class="p-6">
                <h3 class="text-xl font-bold text-slate-400 mb-1">Nama Produk UMKM</h3>
                <p class="text-sm text-slate-400 mb-4">oleh <span class="font-medium">Nama Usaha</span></p>
                <div class="flex justify-between items-center mt-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center text-xs text-slate-400 gap-1">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Kecamatan
                    </div>
                    <button class="text-slate-400 font-bold text-sm cursor-not-allowed">Lihat Detail</button>
                </div>
            </div>
        </div>
        @endfor
    </div>
    
    <div class="mt-8 text-center md:hidden">
        <a href="/katalog" class="inline-block bg-white text-[#800000] border border-[#800000] px-6 py-3 rounded-full font-bold shadow hover:bg-red-50 transition-colors">Lihat Semua Produk</a>
    </div>
</div>

<!-- Statistik Banner -->
<div class="bg-[#800000] text-white py-16 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-red-700">
            <div class="p-4 reveal delay-100">
                <div class="text-5xl font-extrabold text-yellow-400 mb-2">1.250+</div>
                <div class="text-red-100 text-lg font-medium">UMKM Bergabung</div>
            </div>
            <div class="p-4 reveal delay-200">
                <div class="text-5xl font-extrabold text-yellow-400 mb-2">3.400+</div>
                <div class="text-red-100 text-lg font-medium">Produk Terdaftar</div>
            </div>
            <div class="p-4 reveal delay-300">
                <div class="text-5xl font-extrabold text-yellow-400 mb-2">890+</div>
                <div class="text-red-100 text-lg font-medium">Transaksi Sukses</div>
            </div>
        </div>
    </div>
</div>

@endsection
