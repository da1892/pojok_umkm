@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen pb-20">

    <!-- Hero Header with Integrated Search Bar (Bright, Clean & Official Wonogiri Theme) -->
    <div class="bg-gradient-to-br from-[#800000] via-[#8e0e0e] to-[#6b0000] text-white pt-10 pb-16 sm:pb-20 relative overflow-hidden">
        <!-- Background decorative ambient circles -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-red-500 rounded-full mix-blend-overlay filter blur-3xl opacity-40 pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-amber-400 rounded-full mix-blend-overlay filter blur-3xl opacity-25 pointer-events-none"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <!-- Official Government Badge -->
            <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-md border border-white/25 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide uppercase mb-4 text-red-100 shadow-xs">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
                Pusat Edukasi &amp; Panduan Pengguna Resmi
            </div>

            <!-- Headline -->
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-3 sm:mb-4 text-white drop-shadow-sm">
                Panduan Penggunaan Portal Pojok UMKM
            </h1>

            <p class="text-red-100 text-xs sm:text-base md:text-lg max-w-3xl mx-auto mb-6 sm:mb-8 font-normal leading-relaxed">
                Panduan praktis dan panduan detail pengisian formulir resmi bagi pelaku UMKM di Kabupaten Wonogiri: dari pendaftaran profil usaha, kurasi katalog produk, hingga pengajuan konsultasi online bersama Dinas Perdagangan dan KUKM.
            </p>

            <!-- Search Bar & Instant Quick Filters -->
            <div class="max-w-2xl mx-auto">
                <div class="relative flex items-center shadow-lg rounded-2xl">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <input type="text"
                           id="guide-search-input"
                           placeholder="Cari panduan (misal: aturan pengisian, contoh nama brand, foto 2MB, harga tanpa titik, tiket konsultasi)..."
                           class="w-full pl-11 pr-24 py-3.5 sm:py-4 rounded-2xl bg-white text-slate-800 placeholder-slate-400 text-xs sm:text-sm font-medium focus:outline-none focus:ring-4 focus:ring-amber-400/40 border-0 shadow-inner"
                           onkeyup="handleLiveSearch(this.value)">
                    <button type="button"
                            id="btn-clear-search"
                            onclick="clearLiveSearch()"
                            class="hidden absolute right-3 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition-all">
                        Reset
                    </button>
                </div>

                <!-- Quick Filter Chips -->
                <div class="flex flex-wrap items-center justify-center gap-1.5 sm:gap-2 mt-4 text-[11px] sm:text-xs">
                    <span class="text-red-200 font-semibold mr-1 hidden sm:inline">Pintas:</span>
                    <button type="button" onclick="filterByTopic('all')" class="quick-chip active px-3 py-1 rounded-full bg-amber-400 text-[#800000] font-bold shadow-xs hover:bg-amber-300 transition-all">Semua</button>
                    <button type="button" onclick="filterByTopic('registrasi')" class="quick-chip px-3 py-1 rounded-full bg-white/15 text-white hover:bg-white/25 border border-white/20 transition-all">1. Profil Usaha</button>
                    <button type="button" onclick="filterByTopic('katalog')" class="quick-chip px-3 py-1 rounded-full bg-white/15 text-white hover:bg-white/25 border border-white/20 transition-all">2. Katalog Produk</button>
                    <button type="button" onclick="filterByTopic('konsultasi')" class="quick-chip px-3 py-1 rounded-full bg-white/15 text-white hover:bg-white/25 border border-white/20 transition-all">3. Tiket Konsultasi</button>
                    <button type="button" onclick="filterByTopic('faq')" class="quick-chip px-3 py-1 rounded-full bg-white/15 text-white hover:bg-white/25 border border-white/20 transition-all">FAQ</button>
                    <button type="button" onclick="filterByTopic('legalitas')" class="quick-chip px-3 py-1 rounded-full bg-white/15 text-white hover:bg-white/25 border border-white/20 transition-all">Izin &amp; NIB</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 sm:-mt-8 relative z-20">

        <!-- Master Tabs Nav: Switch between Portal Guide & Legalitas Usaha -->
        <div class="bg-white rounded-2xl p-2 shadow-sm border border-slate-200/90 mb-8 flex flex-col sm:flex-row gap-2">
            <button type="button"
                    id="tab-btn-portal"
                    onclick="switchMasterTab('portal')"
                    class="flex-1 flex items-center justify-center gap-2.5 py-3 px-4 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 bg-[#800000] text-white shadow-xs">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                </svg>
                <span>Panduan Fitur &amp; Detail Pengisian Formulir (3 Modul)</span>
            </button>
            <button type="button"
                    id="tab-btn-legalitas"
                    onclick="switchMasterTab('legalitas')"
                    class="flex-1 flex items-center justify-center gap-2.5 py-3 px-4 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 text-slate-600 hover:text-[#800000] hover:bg-slate-50">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Panduan Legalitas &amp; Perizinan (NIB, Halal, P-IRT, Merek)</span>
            </button>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 1: PANDUAN PENGGUNAAN & PENGISIAN FORMULIR PORTAL UMKM     -->
        <!-- ============================================================== -->
        <div id="section-portal-guide" class="space-y-10">

            <!-- 3 Modul Quick Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Card 1 -->
                <div onclick="scrollToSection('modul-registrasi')" class="p-6 rounded-3xl bg-white border border-slate-200/90 hover:border-amber-400 hover:shadow-md transition-all cursor-pointer group flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="w-10 h-10 rounded-2xl bg-amber-500 text-white font-black text-base flex items-center justify-center shadow-xs">1</span>
                            <span class="text-[10px] font-bold text-amber-800 bg-amber-100 px-2.5 py-1 rounded-full uppercase tracking-wider">Formulir Usaha</span>
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-base sm:text-lg group-hover:text-amber-800 transition-colors mb-2">
                            Panduan Profil Usaha
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Standar nama brand tanpa singkatan, kategori usaha, alamat 25 kecamatan, nomor WhatsApp 08 aktif, dan input legalitas.
                        </p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-slate-100 text-xs font-bold text-amber-700 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Buka Detail Pengisian Profil &rarr;
                    </div>
                </div>

                <!-- Card 2 -->
                <div onclick="scrollToSection('modul-katalog')" class="p-6 rounded-3xl bg-white border border-slate-200/90 hover:border-emerald-500 hover:shadow-md transition-all cursor-pointer group flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="w-10 h-10 rounded-2xl bg-emerald-600 text-white font-black text-base flex items-center justify-center shadow-xs">2</span>
                            <span class="text-[10px] font-bold text-emerald-800 bg-emerald-100 px-2.5 py-1 rounded-full uppercase tracking-wider">Formulir Produk</span>
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-base sm:text-lg group-hover:text-emerald-800 transition-colors mb-2">
                            Panduan Katalog Produk
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Format nama produk spesifik, foto produk maks 2MB, template 4 poin deskripsi, dan harga angka murni tanpa titik.
                        </p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-slate-100 text-xs font-bold text-emerald-700 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Buka Detail Pengisian Katalog &rarr;
                    </div>
                </div>

                <!-- Card 3 -->
                <div onclick="scrollToSection('modul-konsultasi')" class="p-6 rounded-3xl bg-white border border-slate-200/90 hover:border-blue-500 hover:shadow-md transition-all cursor-pointer group flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="w-10 h-10 rounded-2xl bg-blue-600 text-white font-black text-base flex items-center justify-center shadow-xs">3</span>
                            <span class="text-[10px] font-bold text-blue-800 bg-blue-100 px-2.5 py-1 rounded-full uppercase tracking-wider">Formulir Tiket</span>
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-base sm:text-lg group-hover:text-blue-800 transition-colors mb-2">
                            Panduan Tiket Konsultasi
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Pemilihan topik pendampingan, penulisan subjek kendala terarah, kronologi masalah, lampiran berkas, dan status tiket dinas.
                        </p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-slate-100 text-xs font-bold text-blue-700 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Buka Detail Pengisian Tiket &rarr;
                    </div>
                </div>
            </div>

            <!-- Empty Search Notice -->
            <div id="no-result-notice-portal" class="hidden text-center py-12 bg-white rounded-3xl border border-slate-200 shadow-sm">
                <div class="w-14 h-14 rounded-full bg-red-50 text-[#991b1b] flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">Panduan Tidak Ditemukan</h3>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mt-1 mb-4">Tidak ada langkah panduan yang cocok dengan kata kunci pencarian Anda. Silakan coba kata kunci lain.</p>
                <button type="button" onclick="clearLiveSearch()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">Tampilkan Semua Panduan</button>
            </div>

            <!-- ============================================================== -->
            <!-- MODUL 1: PANDUAN PENGISIAN PROFIL USAHA                        -->
            <!-- ============================================================== -->
            <div id="modul-registrasi" class="guide-block bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-10 scroll-mt-24"
                 data-keywords="modul 1 profil usaha omah kriuk wonogiri aturan pengisian contoh penulisan nama brand kategori usaha alamat 25 kecamatan nomor whatsapp 08 legalitas nib pirt halal kurasi admin kesalahan umum">
                
                <!-- Module Header -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-slate-100 mb-8">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center font-black text-xl shadow-xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.765z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-black uppercase tracking-wider text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-md">Modul 1 &bull; Formulir Profil Usaha</span>
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Panduan Detail Pengisian Profil Usaha UMKM</h2>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('register') }}" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs transition-colors shadow-xs inline-flex items-center gap-1.5">
                            <span>Formulir Pendaftaran</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                </div>

                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-6">
                    Halaman profil usaha adalah identitas resmi bisnis Anda di portal Pojok UMKM Kabupaten Wonogiri. Pengisian formulir yang rapi dan akurat akan mempercepat proses kurasi oleh tim Dinas KUKM serta memudahkan pembeli menemukan gerai Anda.
                </p>

                <!-- 2-Column Comparison Layout: Aturan Pengisian vs Contoh Penulisan yang Benar -->
                <div class="space-y-4 mb-8">

                    <!-- Field 1: Nama Usaha / Brand -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                        <div class="bg-slate-100/80 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-amber-500 text-white font-black text-xs flex items-center justify-center">1</span>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Kolom: Nama Usaha / Merek Dagang (Brand)</h3>
                            </div>
                            <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded">Wajib Diisi</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            <!-- Left: Aturan Pengisian -->
                            <div class="p-4 sm:p-5 bg-white">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Aturan Pengisian:
                                </div>
                                <ul class="text-xs text-slate-700 space-y-1.5 list-disc list-inside leading-relaxed">
                                    <li>Wajib menggunakan <strong>nama merek dagang asli</strong> yang jelas dan mudah diingat konsumen.</li>
                                    <li>Hindari penggunaan singkatan membingungkan (akronim tanpa arti) atau penulisan huruf kapital seluruhnya (ALL CAPS).</li>
                                    <li>Dapat menyertakan nama ciri khas produk atau nama daerah asal di Wonogiri.</li>
                                </ul>
                            </div>
                            <!-- Right: Contoh Penulisan yang Benar -->
                            <div class="p-4 sm:p-5 bg-emerald-50/40">
                                <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Contoh Penulisan yang Benar:
                                </div>
                                <div class="space-y-2 text-xs">
                                    <div class="p-2.5 rounded-xl bg-white border border-emerald-300 shadow-2xs font-medium text-emerald-900">
                                        &check; <span class="font-bold">"Omah Kriuk Wonogiri"</span> <span class="text-slate-500 text-[11px]">(Jelas, ada identitas produk &amp; asal daerah)</span>
                                    </div>
                                    <div class="p-2.5 rounded-xl bg-white border border-emerald-300 shadow-2xs font-medium text-emerald-900">
                                        &check; <span class="font-bold">"Batik Tulis Canting Tirtomoyo"</span> <span class="text-slate-500 text-[11px]">(Menonjolkan kerajinan lokal khas kecamatan)</span>
                                    </div>
                                    <div class="p-2 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-[11px]">
                                        &cross; <span class="line-through font-semibold">"OKW"</span> atau <span class="line-through font-semibold">"TOKO SAYA WONOGIRI"</span> (Terlalu ambigu / generik)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field 2: Kategori Usaha -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                        <div class="bg-slate-100/80 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-amber-500 text-white font-black text-xs flex items-center justify-center">2</span>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Kolom: Kategori Usaha</h3>
                            </div>
                            <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded">Wajib Dipilih</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            <!-- Left: Aturan Pengisian -->
                            <div class="p-4 sm:p-5 bg-white">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Aturan Pengisian:
                                </div>
                                <ul class="text-xs text-slate-700 space-y-1.5 list-disc list-inside leading-relaxed">
                                    <li>Pilih 1 sektor usaha yang menjadi fokus utama penjualan Anda dari dropdown sistem.</li>
                                    <li>Kategori menentukan filter pencarian pembeli dan penugasan kurator pembina di dinas.</li>
                                </ul>
                            </div>
                            <!-- Right: Contoh Penulisan yang Benar -->
                            <div class="p-4 sm:p-5 bg-emerald-50/40">
                                <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Panduan Pemilihan Sektor yang Tepat:
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                    <div class="p-2 rounded-lg bg-white border border-slate-200">
                                        <div class="font-bold text-slate-800">Kuliner / Makanan Olahan</div>
                                        <div class="text-[11px] text-slate-500">Mete, keripik tempe benguk, abon, rengginang, kopi.</div>
                                    </div>
                                    <div class="p-2 rounded-lg bg-white border border-slate-200">
                                        <div class="font-bold text-slate-800">Fashion / Batik</div>
                                        <div class="text-[11px] text-slate-500">Batik tulis, kain lurik, ecoprint, pakaian jadi.</div>
                                    </div>
                                    <div class="p-2 rounded-lg bg-white border border-slate-200">
                                        <div class="font-bold text-slate-800">Kriya / Kerajinan</div>
                                        <div class="text-[11px] text-slate-500">Wayang kulit, anyaman tas pandan, ukir kayu.</div>
                                    </div>
                                    <div class="p-2 rounded-lg bg-white border border-slate-200">
                                        <div class="font-bold text-slate-800">Agribisnis / Jasa</div>
                                        <div class="text-[11px] text-slate-500">Bibit tanaman, olahan jamu herbal, jasa katering.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field 3: Alamat Lengkap & Kecamatan -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                        <div class="bg-slate-100/80 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-amber-500 text-white font-black text-xs flex items-center justify-center">3</span>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Kolom: Alamat Lengkap &amp; Pilihan Kecamatan</h3>
                            </div>
                            <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded">Wajib Diisi</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            <!-- Left: Aturan Pengisian -->
                            <div class="p-4 sm:p-5 bg-white">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Aturan Pengisian:
                                </div>
                                <ul class="text-xs text-slate-700 space-y-1.5 list-disc list-inside leading-relaxed">
                                    <li>Tuliskan nama jalan/dusun, nomor RT/RW, dan desa/kelurahan tempat lokasi produksi atau toko fisik Anda.</li>
                                    <li>Wajib memilih 1 dari <strong>25 Kecamatan</strong> di Kabupaten Wonogiri agar titik gerai Anda tampil akurat di fitur <em>Peta &amp; Direktori UMKM</em>.</li>
                                </ul>
                            </div>
                            <!-- Right: Contoh Penulisan yang Benar -->
                            <div class="p-4 sm:p-5 bg-emerald-50/40">
                                <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Contoh Penulisan yang Benar:
                                </div>
                                <div class="space-y-2 text-xs">
                                    <div class="p-2.5 rounded-xl bg-white border border-emerald-300 shadow-2xs text-slate-800">
                                        <div class="text-[11px] text-slate-500 mb-0.5">Alamat Lengkap:</div>
                                        <div class="font-bold text-emerald-950">"Jalan RM. Said No. 12, RT 02 / RW 04, Dusun Gudang, Desa Kaliancar"</div>
                                        <div class="text-[11px] text-slate-500 mt-1">Pilihan Dropdown Kecamatan: <strong class="text-emerald-700">Selogiri</strong></div>
                                    </div>
                                    <div class="p-2 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-[11px]">
                                        &cross; <span class="line-through font-semibold">"Wonogiri"</span> (Hanya menulis nama kabupaten tanpa detail jalan/desa)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field 4: Nomor WhatsApp Aktif -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                        <div class="bg-slate-100/80 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-amber-500 text-white font-black text-xs flex items-center justify-center">4</span>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Kolom: Nomor WhatsApp Aktif (Direct Order)</h3>
                            </div>
                            <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded">Wajib Diisi</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            <!-- Left: Aturan Pengisian -->
                            <div class="p-4 sm:p-5 bg-white">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Aturan Pengisian:
                                </div>
                                <ul class="text-xs text-slate-700 space-y-1.5 list-disc list-inside leading-relaxed">
                                    <li>Wajib diawali angka <strong>08</strong> tanpa tanda spasi, tanda hubung (-), atau kode negara (+62).</li>
                                    <li>Nomor ini digunakan langsung oleh tombol <em>"Pesan via WhatsApp"</em> di katalog produk. Jika format salah, tombol WhatsApp tidak bisa diklik oleh pembeli!</li>
                                </ul>
                            </div>
                            <!-- Right: Contoh Penulisan yang Benar -->
                            <div class="p-4 sm:p-5 bg-emerald-50/40">
                                <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Contoh Penulisan yang Benar:
                                </div>
                                <div class="space-y-2 text-xs">
                                    <div class="p-2.5 rounded-xl bg-white border border-emerald-300 shadow-2xs font-mono font-bold text-emerald-900">
                                        &check; 081234567890 <span class="font-sans font-normal text-slate-500 text-[11px]">(Angka bersambung tanpa spasi)</span>
                                    </div>
                                    <div class="p-2 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-[11px]">
                                        &cross; <span class="line-through font-mono font-semibold">0812-3456-7890</span> atau <span class="line-through font-mono font-semibold">+62 812 3456 7890</span> (Salah format)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field 5: Legalitas Usaha (Opsional / Nilai Tambah) -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                        <div class="bg-slate-100/80 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-amber-500 text-white font-black text-xs flex items-center justify-center">5</span>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Kolom: Legalitas Usaha (NIB, P-IRT, &amp; Halal)</h3>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">Opsional / Nilai Tambah</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            <!-- Left: Aturan Pengisian -->
                            <div class="p-4 sm:p-5 bg-white">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Aturan Pengisian:
                                </div>
                                <ul class="text-xs text-slate-700 space-y-1.5 list-disc list-inside leading-relaxed">
                                    <li>Bagi usaha pemula yang belum memiliki legalitas, kolom ini dapat dikosongkan terlebih dahulu (tidak menghambat pendaftaran).</li>
                                    <li>Jika sudah memiliki, masukkan nomor registrasi resmi: NIB (13 digit OSS), nomor P-IRT Dinkes, atau nomor Sertifikat Halal BPJPH.</li>
                                </ul>
                            </div>
                            <!-- Right: Contoh Penulisan yang Benar -->
                            <div class="p-4 sm:p-5 bg-emerald-50/40">
                                <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Contoh Format Penulisan:
                                </div>
                                <div class="space-y-1.5 text-xs">
                                    <div class="p-2 rounded-lg bg-white border border-slate-200">
                                        <span class="text-slate-500">Nomor NIB:</span> <strong class="font-mono text-emerald-900">0123456789012</strong> (13 digit angka)
                                    </div>
                                    <div class="p-2 rounded-lg bg-white border border-slate-200">
                                        <span class="text-slate-500">Izin P-IRT:</span> <strong class="font-mono text-emerald-900">P-IRT 2063312010123-28</strong>
                                    </div>
                                    <div class="p-2 rounded-lg bg-white border border-slate-200">
                                        <span class="text-slate-500">Sertifikat Halal:</span> <strong class="font-mono text-emerald-900">ID33110001234561023</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Callout Boxes for Modul 1: Tips Kurasi & Kesalahan Umum -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Callout Tips (Hijau/Biru) -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-950 flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="text-xs leading-relaxed">
                            <strong class="font-bold text-emerald-900 block text-sm mb-1">Tips Lolos Kurasi Admin Dinas:</strong>
                            Tuliskan deskripsi cerita usaha Anda secara singkat namun autentik (misal: tradisi resep turun-temurun, pemanfaatan bahan tani lokal Wonogiri). Profil yang memiliki nomor WhatsApp aktif dan deskripsi lengkap diprioritaskan disetujui dalam 1 hari kerja!
                        </div>
                    </div>

                    <!-- Callout Warning (Kuning/Oranye) -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-amber-50 border border-amber-300 text-amber-950 flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        </div>
                        <div class="text-xs leading-relaxed">
                            <strong class="font-bold text-amber-900 block text-sm mb-1">Kesalahan Umum yang Sering Terjadi:</strong>
                            Memasukkan nomor telepon rumah/kantor kabel yang tidak terhubung ke aplikasi WhatsApp. Akibatnya, tombol direct order tidak dapat dibuka oleh pembeli. Pastikan nomor diawali <strong>08</strong> dan selalu aktif.
                        </div>
                    </div>
                </div>

            </div>

            <!-- ============================================================== -->
            <!-- MODUL 2: PANDUAN PENGISIAN KATALOG PRODUK                     -->
            <!-- ============================================================== -->
            <div id="modul-katalog" class="guide-block bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-10 scroll-mt-24"
                 data-keywords="modul 2 katalog produk keripik tempe benguk pedas manis 200gr foto produk 2mb harga satuan tanpa titik template deskripsi komposisi tautan marketplace shopee tokopedia kurasi produk unggulan kesalahan umum">
                
                <!-- Module Header -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-slate-100 mb-8">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-black text-xl shadow-xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-black uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-md">Modul 2 &bull; Formulir Katalog Produk</span>
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Panduan Detail Pengisian Katalog Produk</h2>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('katalog') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold text-xs transition-colors shadow-2xs inline-flex items-center gap-1.5">
                            <span>Lihat Etalase Katalog</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                </div>

                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-6">
                    Katalog produk adalah etalase digital yang dilihat langsung oleh calon konsumen dan wisatawan. Ikuti format perbandingan di bawah ini agar produk Anda memenuhi standar kurasi resmi:
                </p>

                <!-- 2-Column Comparison Layout: Aturan Pengisian vs Contoh Penulisan yang Benar -->
                <div class="space-y-4 mb-8">

                    <!-- Field 1: Nama Produk & Varian -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                        <div class="bg-slate-100/80 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-black text-xs flex items-center justify-center">1</span>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Kolom: Nama Produk &amp; Varian Rasa/Ukuran</h3>
                            </div>
                            <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded">Wajib Diisi</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            <!-- Left: Aturan Pengisian -->
                            <div class="p-4 sm:p-5 bg-white">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Aturan Pengisian:
                                </div>
                                <ul class="text-xs text-slate-700 space-y-1.5 list-disc list-inside leading-relaxed">
                                    <li>Tuliskan <strong>jenis produk, varian rasa, dan ukuran kemasan</strong> secara spesifik dalam satu baris judul.</li>
                                    <li>Hindari judul yang terlalu singkat (hanya 1 kata) atau kata-kata promosi hiperbolis berlebihan seperti "termurah sedunia".</li>
                                </ul>
                            </div>
                            <!-- Right: Contoh Penulisan yang Benar -->
                            <div class="p-4 sm:p-5 bg-emerald-50/40">
                                <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Contoh Penulisan yang Benar:
                                </div>
                                <div class="space-y-2 text-xs">
                                    <div class="p-2.5 rounded-xl bg-white border border-emerald-300 shadow-2xs font-bold text-emerald-950">
                                        &check; "Keripik Tempe Benguk Pedas Manis - 200gr"
                                    </div>
                                    <div class="p-2.5 rounded-xl bg-white border border-emerald-300 shadow-2xs font-bold text-emerald-950">
                                        &check; "Kacang Mete Matang Oven Rasa Bawang - 250gr"
                                    </div>
                                    <div class="p-2 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-[11px]">
                                        &cross; <span class="line-through font-semibold">"Keripik"</span> atau <span class="line-through font-semibold">"Keripik Tempe Benguk Enak Termurah Wonogiri Grosir"</span> (Salah)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field 2: Ketentuan Foto Produk (Badge: Maks 2MB) -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                        <div class="bg-slate-100/80 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-black text-xs flex items-center justify-center">2</span>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Kolom: Foto Produk Utama</h3>
                            </div>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-900 bg-amber-200/80 px-2 py-0.5 rounded-md">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                                Ukuran Maksimal 2MB
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            <!-- Left: Aturan Pengisian -->
                            <div class="p-4 sm:p-5 bg-white">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Aturan &amp; Ketentuan Teknis:
                                </div>
                                <ul class="text-xs text-slate-700 space-y-1.5 list-disc list-inside leading-relaxed">
                                    <li>Format wajib: <strong>JPG, JPEG, atau PNG</strong>.</li>
                                    <li>Batas ukuran file: <strong>Maksimal 2 Megabytes (2.048 KB)</strong> per foto.</li>
                                    <li>Pencahayaan terang alami, produk fokus di tengah, dan <strong>tanpa teks promosi / watermark berlebihan</strong> yang menutupi bentuk fisik kemasan.</li>
                                </ul>
                            </div>
                            <!-- Right: Contoh Penulisan yang Benar -->
                            <div class="p-4 sm:p-5 bg-emerald-50/40">
                                <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Standar Visual yang Disarankan:
                                </div>
                                <div class="space-y-1.5 text-xs">
                                    <div class="p-2.5 rounded-xl bg-white border border-emerald-300 shadow-2xs text-slate-800">
                                        <div class="font-bold text-emerald-950">&check; Foto Kemasan Standing Pouch / Toples Bersih</div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">Rasio kotak 1:1, latar belakang meja kayu polos atau putih netral.</div>
                                    </div>
                                    <div class="p-2 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-[11px]">
                                        &cross; Foto buram di lantai redup, file >2MB, atau ditutupi stiker diskon besar.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field 3: Deskripsi Produk (Template 4 Poin Pokok) -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                        <div class="bg-slate-100/80 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-black text-xs flex items-center justify-center">3</span>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Kolom: Deskripsi Produk (Template Poin)</h3>
                            </div>
                            <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded">Wajib Diisi</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            <!-- Left: Aturan Pengisian -->
                            <div class="p-4 sm:p-5 bg-white">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Template 4 Poin yang Wajib Ditulis:
                                </div>
                                <ol class="text-xs text-slate-700 space-y-1.5 list-decimal list-inside leading-relaxed">
                                    <li><strong>Komposisi Utama:</strong> Bahan baku yang digunakan.</li>
                                    <li><strong>Keunggulan Rasa/Tekstur:</strong> Karakteristik unik produk.</li>
                                    <li><strong>Masa Simpan / Expired:</strong> Daya tahan simpan produk.</li>
                                    <li><strong>Berat Bersih &amp; Izin:</strong> Netto (gram/kg) dan izin legalitas.</li>
                                </ol>
                            </div>
                            <!-- Right: Contoh Penulisan yang Benar -->
                            <div class="p-4 sm:p-5 bg-emerald-50/40">
                                <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Contoh Template Siap Salin:
                                </div>
                                <div class="p-3 rounded-xl bg-white border border-emerald-300 shadow-2xs text-[11px] text-slate-700 space-y-1 leading-relaxed">
                                    <div>&bull; <strong>Komposisi:</strong> Tempe benguk pilihan Wonogiri, minyak nabati, bawang putih, cabai, gula jawa, garam.</div>
                                    <div>&bull; <strong>Keunggulan:</strong> Tekstur gurih renyah tanpa bahan pengawet kimia buatan.</div>
                                    <div>&bull; <strong>Masa Simpan:</strong> 6 bulan dalam kemasan kedap udara tertutup rapat.</div>
                                    <div>&bull; <strong>Berat Bersih:</strong> 200 gram | P-IRT No. 2063312010123-28.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field 4: Input Harga Satuan (Wajib Angka Murni) -->
                    <div class="border-2 border-emerald-300 rounded-2xl overflow-hidden shadow-2xs">
                        <div class="bg-emerald-100/70 px-5 py-3 border-b border-emerald-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-black text-xs flex items-center justify-center">4</span>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Kolom: Harga Satuan (Angka Murni Tanpa Titik/Koma)</h3>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-wider text-rose-800 bg-rose-100 px-2.5 py-0.5 rounded">Paling Penting!</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            <!-- Left: Aturan Pengisian -->
                            <div class="p-4 sm:p-5 bg-white">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Aturan Pengisian:
                                </div>
                                <ul class="text-xs text-slate-700 space-y-1.5 list-disc list-inside leading-relaxed">
                                    <li>Wajib diisi <strong>angka murni saja</strong>.</li>
                                    <li><strong>Dilarang</strong> menambahkan tanda titik (.), tanda koma (,), spasi, simbol "Rp", atau akhiran ",-".</li>
                                    <li>Sistem secara otomatis mengubah tampilan angka menjadi format mata uang resmi di halaman katalog.</li>
                                </ul>
                            </div>
                            <!-- Right: Contoh Penulisan yang Benar -->
                            <div class="p-4 sm:p-5 bg-emerald-50/40">
                                <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Perbandingan Input:
                                </div>
                                <div class="space-y-2 text-xs">
                                    <div class="p-2.5 rounded-xl bg-white border border-emerald-300 shadow-2xs font-mono font-bold text-emerald-900">
                                        &check; 15000 <span class="font-sans font-normal text-slate-500 text-[11px]">&rarr; Tampil di website: <strong class="text-emerald-700">Rp 15.000</strong></span>
                                    </div>
                                    <div class="p-2 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-[11px]">
                                        &cross; <span class="line-through font-mono font-bold">"Rp 15.000,-"</span> atau <span class="line-through font-mono font-bold">"15.000"</span> (Salah, sistem membaca Rp 15)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field 5: Tautan Pembelian (Opsional) -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                        <div class="bg-slate-100/80 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-black text-xs flex items-center justify-center">5</span>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Kolom: Tautan Pembelian Marketplace (Shopee / Tokopedia / Instagram)</h3>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">Opsional</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            <!-- Left: Aturan Pengisian -->
                            <div class="p-4 sm:p-5 bg-white">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Aturan Pengisian:
                                </div>
                                <ul class="text-xs text-slate-700 space-y-1.5 list-disc list-inside leading-relaxed">
                                    <li>Salin dan tempelkan link lengkap yang diawali dengan protokol <strong>https://</strong> dari toko online Anda.</li>
                                    <li>Mendukung Shopee, Tokopedia, TikTok Shop, Bukalapak, atau tautan postingan Instagram.</li>
                                </ul>
                            </div>
                            <!-- Right: Contoh Penulisan yang Benar -->
                            <div class="p-4 sm:p-5 bg-emerald-50/40">
                                <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Contoh Link Lengkap yang Benar:
                                </div>
                                <div class="space-y-1.5 text-xs">
                                    <div class="p-2 rounded-lg bg-white border border-slate-200 font-mono text-emerald-900 break-all">
                                        &check; https://shopee.co.id/omahkriukwonogiri
                                    </div>
                                    <div class="p-2 rounded-lg bg-white border border-slate-200 font-mono text-emerald-900 break-all">
                                        &check; https://www.tokopedia.com/omahkriuk
                                    </div>
                                    <div class="p-1.5 rounded bg-rose-50 border border-rose-200 text-rose-800 text-[11px]">
                                        &cross; <span class="line-through">shopee.co.id/omahkriuk</span> (Tanpa https:// tautan tidak bisa dibuka)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Callout Boxes for Modul 2: Tips Kurasi & Kesalahan Umum -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Callout Tips (Hijau/Biru) -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-950 flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="text-xs leading-relaxed">
                            <strong class="font-bold text-emerald-900 block text-sm mb-1">Tips Lolos Kurasi Produk Unggulan:</strong>
                            Gunakan foto produk dengan latar belakang bersih, kemasan tersegel rapi standar higienis, dan sertakan nomor P-IRT / Halal pada deskripsi. Produk yang memenuhi standar ini akan diberi tanda <strong>"Produk Unggulan"</strong> oleh dinas dan tampil di halaman depan portal!
                        </div>
                    </div>

                    <!-- Callout Warning (Kuning/Oranye) -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-amber-50 border border-amber-300 text-amber-950 flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        </div>
                        <div class="text-xs leading-relaxed">
                            <strong class="font-bold text-amber-900 block text-sm mb-1">Kesalahan Umum yang Sering Terjadi:</strong>
                            Menulis harga dengan format titik seperti <code>25.000</code> atau <code>Rp 25.000</code>. Hal ini menyebabkan sistem membaca angka nominal secara salah. Cukup ketik angka bersih: <code>25000</code>.
                        </div>
                    </div>
                </div>

            </div>

            <!-- ============================================================== -->
            <!-- MODUL 3: PANDUAN PENGISIAN TIKET KONSULTASI ONLINE             -->
            <!-- ============================================================== -->
            <div id="modul-konsultasi" class="guide-block bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-10 scroll-mt-24"
                 data-keywords="modul 3 tiket konsultasi online perizinan legalitas nib pirt halal kemasan branding pemasaran digital subjek kendala sambal botol lampiran foto 2mb status tiket open in progress resolved cek tiket tips kurasi kesalahan umum">
                
                <!-- Module Header -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-slate-100 mb-8">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-black text-xl shadow-xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-black uppercase tracking-wider text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-md">Modul 3 &bull; Formulir Tiket Konsultasi</span>
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Panduan Detail Pengajuan Tiket Konsultasi Online</h2>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('konsultasi') }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs transition-colors shadow-xs inline-flex items-center gap-1.5">
                            <span>Buka Formulir Tiket</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                        <a href="{{ route('konsultasi.cek') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold text-xs transition-colors shadow-2xs">
                            Cek Tiket Anda
                        </a>
                    </div>
                </div>

                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-6">
                    Layanan konsultasi online menghubungkan Anda langsung dengan fasilitator resmi Dinas Perdagangan dan KUKM Kabupaten Wonogiri untuk membantu kendala perizinan usaha, desain kemasan, hingga akses permodalan KUR.
                </p>

                <!-- 2-Column Comparison Layout: Aturan Pengisian vs Contoh Penulisan yang Benar -->
                <div class="space-y-4 mb-8">

                    <!-- Field 1: Pemilihan Topik Konsultasi -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                        <div class="bg-slate-100/80 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-blue-600 text-white font-black text-xs flex items-center justify-center">1</span>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Kolom: Pemilihan Topik / Kategori Konsultasi</h3>
                            </div>
                            <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded">Wajib Dipilih</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            <!-- Left: Aturan Pengisian -->
                            <div class="p-4 sm:p-5 bg-white">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Aturan Kapan Memilih Setiap Topik:
                                </div>
                                <ul class="text-xs text-slate-700 space-y-1.5 list-disc list-inside leading-relaxed">
                                    <li><strong>Perizinan &amp; Legalitas:</strong> Pilih jika butuh bantuan NIB OSS, izin edar P-IRT Dinkes, atau sertifikasi Halal SEHATI.</li>
                                    <li><strong>Pengembangan Kemasan &amp; Branding:</strong> Pilih jika butuh review desain label BPOM, kemasan higienis, atau hak merek HAKI.</li>
                                    <li><strong>Pemasaran Digital:</strong> Pilih jika butuh bimbingan jualan online, foto produk katalog, atau marketplace.</li>
                                </ul>
                            </div>
                            <!-- Right: Contoh Penulisan yang Benar -->
                            <div class="p-4 sm:p-5 bg-emerald-50/40">
                                <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Contoh Kasus &amp; Pilihan Tepat:
                                </div>
                                <div class="space-y-1.5 text-xs">
                                    <div class="p-2.5 rounded-xl bg-white border border-emerald-300 shadow-2xs">
                                        <div class="font-bold text-emerald-950">Kasus: Belum punya izin edar untuk sambal botol</div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">Pilih Kategori: <strong class="text-blue-700">"Perizinan &amp; Legalitas (NIB/PIRT/Halal)"</strong></div>
                                    </div>
                                    <div class="p-2.5 rounded-xl bg-white border border-emerald-300 shadow-2xs">
                                        <div class="font-bold text-emerald-950">Kasus: Ingin logo &amp; nama brand tidak ditiru kompetitor</div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">Pilih Kategori: <strong class="text-blue-700">"Pengembangan Kemasan &amp; Branding (Hak Merek)"</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field 2: Judul / Subjek Kendala -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                        <div class="bg-slate-100/80 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-blue-600 text-white font-black text-xs flex items-center justify-center">2</span>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Kolom: Judul / Subjek Kendala</h3>
                            </div>
                            <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded">Wajib Diisi</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            <!-- Left: Aturan Pengisian -->
                            <div class="p-4 sm:p-5 bg-white">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Aturan Pengisian:
                                </div>
                                <ul class="text-xs text-slate-700 space-y-1.5 list-disc list-inside leading-relaxed">
                                    <li>Tuliskan judul permasalahan secara singkat, padat, dan langsung menyebutkan inti pokok kendala.</li>
                                    <li>Hindari judul yang terlalu singkat hanya 1 kata seperti "Tolong", "Halo", atau "Tanya".</li>
                                </ul>
                            </div>
                            <!-- Right: Contoh Penulisan yang Benar -->
                            <div class="p-4 sm:p-5 bg-emerald-50/40">
                                <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Contoh Judul yang Tepat:
                                </div>
                                <div class="space-y-2 text-xs">
                                    <div class="p-2.5 rounded-xl bg-white border border-emerald-300 shadow-2xs font-bold text-emerald-950">
                                        &check; "Pendampingan pengurusan izin PIRT untuk produk sambal botol"
                                    </div>
                                    <div class="p-2.5 rounded-xl bg-white border border-emerald-300 shadow-2xs font-bold text-emerald-950">
                                        &check; "Konsultasi pendaftaran sertifikasi Halal gratis SEHATI kue basah"
                                    </div>
                                    <div class="p-2 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-[11px]">
                                        &cross; <span class="line-through font-semibold">"Tolong saya min"</span> atau <span class="line-through font-semibold">"Tanya izin"</span> (Terlalu singkat)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field 3: Detail Permasalahan & Kontak WhatsApp -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                        <div class="bg-slate-100/80 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-blue-600 text-white font-black text-xs flex items-center justify-center">3</span>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Kolom: Detail Permasalahan &amp; Nomor Kontak</h3>
                            </div>
                            <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded">Wajib Diisi</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            <!-- Left: Aturan Pengisian -->
                            <div class="p-4 sm:p-5 bg-white">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Aturan Pengisian:
                                </div>
                                <ul class="text-xs text-slate-700 space-y-1.5 list-disc list-inside leading-relaxed">
                                    <li>Ceritakan kendala secara runtut: produk yang dibuat, tahapan yang sudah dilakukan, dan kendala spesifik yang dihadapi.</li>
                                    <li>Wajib mencantumkan nomor telepon / WhatsApp yang bisa dihubungi petugas Dinas jika diperlukan komunikasi lebih lanjut.</li>
                                </ul>
                            </div>
                            <!-- Right: Contoh Penulisan yang Benar -->
                            <div class="p-4 sm:p-5 bg-emerald-50/40">
                                <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                    Contoh Uraian Kendala yang Lengkap:
                                </div>
                                <div class="p-3 rounded-xl bg-white border border-emerald-300 shadow-2xs text-[11px] text-slate-700 leading-relaxed italic">
                                    "Halo Tim Dinas KUKM, kami UMKM Sambal Tradisional dari Kecamatan Giriwoyo. Kami berencana mengurus izin SPP-IRT untuk kemasan botol kaca 150ml. Kami sudah memiliki NIB, namun belum memahami ketentuan pencantuman informasi gizi dan tanggal kedaluwarsa pada label kemasan. Mohon bimbingan review desain label kami. Kontak WhatsApp: 081234567890 (Ibu Siti)."
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field 4: Lampiran Pendukung & Status Tiket -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                        <div class="bg-slate-100/80 px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-blue-600 text-white font-black text-xs flex items-center justify-center">4</span>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Kolom: Lampiran Berkas &amp; Pemantauan Status Tiket</h3>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">Maks 2MB</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            <!-- Left: Aturan Pengisian -->
                            <div class="p-4 sm:p-5 bg-white">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    Berkas yang Dapat Dilampirkan:
                                </div>
                                <ul class="text-xs text-slate-700 space-y-1.5 list-disc list-inside leading-relaxed">
                                    <li>Foto kemasan produk saat ini (JPG/PNG).</li>
                                    <li>Tangkapan layar (screenshot) pesan error pada sistem OSS atau SiHalal.</li>
                                    <li>Dokumen pendukung (PDF, maksimal 2MB per berkas).</li>
                                </ul>
                            </div>
                            <!-- Right: Status Tiket Dinas -->
                            <div class="p-4 sm:p-5 bg-emerald-50/40">
                                <div class="text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    3 Indikator Status Tiket Dinas:
                                </div>
                                <div class="space-y-1.5 text-xs">
                                    <div class="p-2 rounded-lg bg-white border border-amber-300 flex items-center justify-between">
                                        <div class="flex items-center gap-1.5 font-bold text-amber-800">
                                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                            1. Open (Menunggu)
                                        </div>
                                        <span class="text-[10px] text-slate-500">Tiket masuk antrean</span>
                                    </div>
                                    <div class="p-2 rounded-lg bg-white border border-blue-300 flex items-center justify-between">
                                        <div class="flex items-center gap-1.5 font-bold text-blue-800">
                                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                            2. In Progress (Diproses)
                                        </div>
                                        <span class="text-[10px] text-slate-500">Petugas sedang menelaah</span>
                                    </div>
                                    <div class="p-2 rounded-lg bg-white border border-emerald-300 flex items-center justify-between">
                                        <div class="flex items-center gap-1.5 font-bold text-emerald-800">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            3. Resolved (Selesai)
                                        </div>
                                        <span class="text-[10px] text-slate-500">Solusi telah diberikan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Callout Boxes for Modul 3: Tips Kurasi & Kesalahan Umum -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Callout Tips (Hijau/Biru) -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-blue-50 border border-blue-200 text-blue-950 flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="text-xs leading-relaxed">
                            <strong class="font-bold text-blue-900 block text-sm mb-1">Tips Lolos &amp; Respon Cepat Petugas:</strong>
                            Simpan nomor tiket unik Anda (contoh: <code>#TKT-2026-XXXX</code>). Anda dapat memantau jawaban petugas dan mengirim balasan secara mandiri kapan pun di menu <a href="{{ route('konsultasi.cek') }}" class="underline font-bold text-blue-800">Cek Tiket Konsultasi</a> cukup dengan memasukkan Nomor Tiket dan Nomor WhatsApp tanpa perlu login!
                        </div>
                    </div>

                    <!-- Callout Warning (Kuning/Oranye) -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-amber-50 border border-amber-300 text-amber-950 flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        </div>
                        <div class="text-xs leading-relaxed">
                            <strong class="font-bold text-amber-900 block text-sm mb-1">Kesalahan Umum yang Sering Terjadi:</strong>
                            Mengirimkan tiket baru berulang kali untuk masalah yang sama persis. Hal ini membuat antrean tiket menumpuk. Cukup gunakan kolom balasan pada nomor tiket yang sudah aktif agar riwayat bimbingan Anda tetap tersambung dengan petugas yang sama.
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- ============================================================== -->
        <!-- TAB 2: PANDUAN LEGALITAS USAHA (NIB, HALAL, PIRT, MEREK)       -->
        <!-- ============================================================== -->
        <div id="section-legalitas-guide" class="hidden space-y-8">
            
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/90">
                <div class="mb-6 pb-4 border-b border-slate-100 text-center sm:text-left">
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                        Alur 5 Langkah Legalitas &amp; Standarisasi UMKM Wonogiri
                    </h2>
                    <p class="text-slate-500 text-xs sm:text-sm mt-0.5">
                        Tahapan perizinan resmi bagi pelaku usaha Wonogiri: dari izin dasar OSS, sertifikasi halal gratis, standarisasi kemasan BPOM, izin edar SPP-IRT, hingga perlindungan merek dagang DJKI.
                    </p>
                </div>

                <!-- 5 Steps Quick Nav Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div onclick="scrollToSection('guide-nib')" class="p-5 rounded-2xl bg-amber-50/70 border border-slate-200/80 hover:border-amber-400 hover:shadow-md transition-all cursor-pointer group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-7 h-7 rounded-full bg-amber-500 text-white font-bold text-xs flex items-center justify-center">1</span>
                            <span class="text-[10px] font-bold text-amber-800 bg-amber-100 px-2.5 py-0.5 rounded-md uppercase">Dasar</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm group-hover:text-amber-800 transition-colors">NIB (Nomor Induk Berusaha)</h4>
                        <p class="text-xs text-slate-600 mt-1">Izin usaha resmi instan secara daring via sistem OSS RBA Kementerian Investasi.</p>
                    </div>

                    <div onclick="scrollToSection('guide-halal')" class="p-5 rounded-2xl bg-emerald-50/70 border border-slate-200/80 hover:border-emerald-400 hover:shadow-md transition-all cursor-pointer group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-7 h-7 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center">2</span>
                            <span class="text-[10px] font-bold text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded-md uppercase">Halal</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm group-hover:text-emerald-800 transition-colors">Sertifikasi Halal SEHATI</h4>
                        <p class="text-xs text-slate-600 mt-1">Fasilitasi Sertifikasi Halal gratis BPJPH skema Self-Declare bagi usaha mikro.</p>
                    </div>

                    <div onclick="scrollToSection('guide-kemasan')" class="p-5 rounded-2xl bg-rose-50/70 border border-slate-200/80 hover:border-rose-400 hover:shadow-md transition-all cursor-pointer group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-7 h-7 rounded-full bg-rose-600 text-white font-bold text-xs flex items-center justify-center">3</span>
                            <span class="text-[10px] font-bold text-rose-800 bg-rose-100 px-2.5 py-0.5 rounded-md uppercase">Kemasan</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm group-hover:text-rose-800 transition-colors">Standar Kemasan &amp; Label</h4>
                        <p class="text-xs text-slate-600 mt-1">7 unsur wajib label kemasan makanan higienis sesuai Peraturan BPOM.</p>
                    </div>

                    <div onclick="scrollToSection('guide-pirt')" class="p-5 rounded-2xl bg-blue-50/70 border border-slate-200/80 hover:border-blue-400 hover:shadow-md transition-all cursor-pointer group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-7 h-7 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center">4</span>
                            <span class="text-[10px] font-bold text-blue-800 bg-blue-100 px-2.5 py-0.5 rounded-md uppercase">Izin Edar</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm group-hover:text-blue-800 transition-colors">SPP-IRT Dinas Kesehatan</h4>
                        <p class="text-xs text-slate-600 mt-1">Izin edar pangan olahan kering industri rumah tangga bebas retribusi pemda.</p>
                    </div>

                    <div onclick="scrollToSection('guide-merek')" class="p-5 rounded-2xl bg-purple-50/70 border border-slate-200/80 hover:border-purple-400 hover:shadow-md transition-all cursor-pointer group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-7 h-7 rounded-full bg-purple-600 text-white font-bold text-xs flex items-center justify-center">5</span>
                            <span class="text-[10px] font-bold text-purple-800 bg-purple-100 px-2.5 py-0.5 rounded-md uppercase">HAKI</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm group-hover:text-purple-800 transition-colors">Hak Merek Dagang (DJKI)</h4>
                        <p class="text-xs text-slate-600 mt-1">Perlindungan nama brand dan logo usaha dengan tarif subsidi binaan dinas.</p>
                    </div>
                </div>
            </div>

            <!-- DETAIL 1: NIB -->
            <div id="guide-nib" class="guide-block bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-10 scroll-mt-24"
                 data-keywords="nib nomor induk berusaha oss rba perizinan legalitas usaha ktp syarat daftar izin dasar investasi">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center font-black text-xl shadow-xs">🏢</div>
                        <div>
                            <span class="text-[11px] font-extrabold tracking-wider uppercase text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-md">Langkah 1 &bull; Legalitas Dasar</span>
                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Panduan Pembuatan NIB (Nomor Induk Berusaha) via OSS</h3>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 self-start sm:self-auto">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        100% Gratis &amp; Terbit Instan
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">
                    Nomor Induk Berusaha (NIB) merupakan bukti legalitas identitas tunggal bagi seluruh pelaku usaha yang diterbitkan melalui OSS BKPM. NIB berlaku sebagai Tanda Daftar Perusahaan (TDP) dan syarat mutlak pengajuan KUR perbankan.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 bg-slate-50 p-5 rounded-2xl border border-slate-100 text-xs text-slate-700 mb-6">
                    <div>
                        <strong class="font-bold text-slate-900 block mb-2">Syarat Dokumen:</strong>
                        <ul class="space-y-1.5 list-disc list-inside">
                            <li>NIK KTP Elektronik pemilik usaha.</li>
                            <li>Nomor WhatsApp dan Alamat Email aktif.</li>
                            <li>Data usaha: Nama Usaha, Lokasi, dan KBLI usaha.</li>
                        </ul>
                    </div>
                    <div>
                        <strong class="font-bold text-slate-900 block mb-2">Tahapan Online:</strong>
                        <ol class="space-y-1.5 list-decimal list-inside">
                            <li>Buka <a href="https://oss.go.id" target="_blank" rel="noopener noreferrer" class="text-[#991b1b] font-bold underline">oss.go.id</a> &rarr; Daftar Hak Akses UMK.</li>
                            <li>Verifikasi kode OTP via WhatsApp/Email.</li>
                            <li>Lengkapi data bisnis lalu klik <strong>Terbitkan NIB</strong>.</li>
                        </ol>
                    </div>
                </div>
                <div class="flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-slate-100 text-xs">
                    <span class="text-slate-500">Masa berlaku: Seumur hidup sepanjang usaha aktif.</span>
                    <a href="https://oss.go.id" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition-colors">Kunjungi Portal OSS &nearr;</a>
                </div>
            </div>

            <!-- DETAIL 2: HALAL -->
            <div id="guide-halal" class="guide-block bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-10 scroll-mt-24"
                 data-keywords="halal sertifikasi sertifikat sehati bpjph kemenag sihala self declare makanan minuman">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-black text-xl shadow-xs">🥩</div>
                        <div>
                            <span class="text-[11px] font-extrabold tracking-wider uppercase text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-md">Langkah 2 &bull; Kepercayaan Konsumen</span>
                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Sertifikasi Halal Gratis (Program SEHATI BPJPH)</h3>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 self-start sm:self-auto">
                        Biaya Ditanggung Pemerintah 100%
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">
                    Program SEHATI (Sertifikasi Halal Gratis) diperuntukkan bagi UMKM makanan &amp; minuman dengan metode Self-Declare. Seluruh proses didampingi oleh Pendamping Proses Produk Halal (PPH) Wonogiri.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 bg-slate-50 p-5 rounded-2xl border border-slate-100 text-xs text-slate-700 mb-6">
                    <div>
                        <strong class="font-bold text-slate-900 block mb-2">Syarat Pengajuan:</strong>
                        <ul class="space-y-1.5 list-disc list-inside">
                            <li>Memiliki NIB berbasis risiko rendah.</li>
                            <li>Bahan baku dipastikan halal &amp; proses higienis.</li>
                            <li>Memiliki 1 orang Penyelia Halal (bisa pemilik sendiri).</li>
                        </ul>
                    </div>
                    <div>
                        <strong class="font-bold text-slate-900 block mb-2">Alur Pendaftaran:</strong>
                        <ol class="space-y-1.5 list-decimal list-inside">
                            <li>Daftar akun di aplikasi <a href="https://ptsp.halal.go.id" target="_blank" rel="noopener noreferrer" class="text-[#991b1b] font-bold underline">ptsp.halal.go.id</a>.</li>
                            <li>Pilih jenis permohonan Self-Declare (SEHATI).</li>
                            <li>Verifikasi lapangan oleh Pendamping PPH Wonogiri.</li>
                        </ol>
                    </div>
                </div>
                <div class="flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-slate-100 text-xs">
                    <span class="text-slate-500">Masa berlaku: Seumur hidup selama komposisi bahan tidak berubah.</span>
                    <a href="https://ptsp.halal.go.id" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition-colors">Portal SiHalal Kemenag &nearr;</a>
                </div>
            </div>

            <!-- DETAIL 3: STANDAR KEMASAN -->
            <div id="guide-kemasan" class="guide-block bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-10 scroll-mt-24"
                 data-keywords="kemasan label bpom netto komposisi kedaluwarsa desain packaging kurasi toko modern">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-rose-600 text-white flex items-center justify-center font-black text-xl shadow-xs">📦</div>
                        <div>
                            <span class="text-[11px] font-extrabold tracking-wider uppercase text-rose-700 bg-rose-50 px-2.5 py-0.5 rounded-md">Langkah 3 &bull; Desain &amp; Kemasan</span>
                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Standar Label Kemasan Produk Sesuai Regulasi BPOM</h3>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 self-start sm:self-auto">
                        Syarat Tembus Minimarket &amp; Swalayan
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                    Label kemasan wajib memuat 7 unsur pokok: Nama Produk, Komposisi Bahan, Berat Bersih (Netto), Nama &amp; Alamat Produsen Wonogiri, Nomor P-IRT/BPOM, Tanggal Kedaluwarsa, dan Kode Produksi.
                </p>
                <div class="bg-rose-50/60 border border-rose-200 p-4 rounded-2xl text-xs text-rose-900 leading-relaxed">
                    <strong>Fasilitasi Konsultasi:</strong> Dinas KUKM Wonogiri menyediakan layanan konsultasi desain kemasan gratis bagi pelaku usaha binaan agar siap bersaing di pasar modern.
                </div>
            </div>

            <!-- DETAIL 4: PIRT -->
            <div id="guide-pirt" class="guide-block bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-10 scroll-mt-24"
                 data-keywords="pirt sppirt spp-irt dinkes dinas kesehatan izin edar pangan kering rumah tangga pkp">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-black text-xl shadow-xs">🥫</div>
                        <div>
                            <span class="text-[11px] font-extrabold tracking-wider uppercase text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-md">Langkah 4 &bull; Keamanan Konsumsi</span>
                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Izin Edar P-IRT (Dinas Kesehatan Kabupaten Wonogiri)</h3>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 self-start sm:self-auto">
                        Bebas Retribusi Pemda
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                    SPP-IRT diperuntukkan bagi pangan olahan kering (kue kering, rengginang, keripik, mete oven, sambal kemasan botol) dengan masa simpan di atas 7 hari pada suhu ruang. Terintegrasi langsung melalui OSS ke <a href="https://sppirt.pom.go.id" target="_blank" rel="noopener noreferrer" class="text-[#991b1b] underline font-bold">sppirt.pom.go.id</a>.
                </p>
            </div>

            <!-- DETAIL 5: HAK MEREK -->
            <div id="guide-merek" class="guide-block bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-10 scroll-mt-24"
                 data-keywords="merek dagang haki djki paten logo nama brand hak cipta subsidi tarif khusus">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-purple-600 text-white flex items-center justify-center font-black text-xl shadow-xs">🏷️</div>
                        <div>
                            <span class="text-[11px] font-extrabold tracking-wider uppercase text-purple-700 bg-purple-50 px-2.5 py-0.5 rounded-md">Langkah 5 &bull; Perlindungan Hak Cipta</span>
                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Pendaftaran Hak Merek Dagang (DJKI Kemenkumham)</h3>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800 self-start sm:self-auto">
                        Tarif Khusus Surat Binaan Dinas
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                    Merek dagang melindungi identitas nama brand dan logo usaha Anda selama 10 tahun. Dengan surat rekomendasi UMKM binaan dari Dinas KUKM Wonogiri, biaya PNBP pendaftaran merek yang umumnya <strong>Rp 1.800.000</strong> disubsidi menjadi hanya <strong>Rp 500.000</strong> per kelas.
                </p>
                <div class="flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-slate-100 text-xs">
                    <span class="text-slate-500">Cek ketersediaan nama merek: <a href="https://pdki-indonesia.dgip.go.id" target="_blank" rel="noopener noreferrer" class="text-[#991b1b] font-bold underline">pdki-indonesia.dgip.go.id</a></span>
                    <a href="{{ route('konsultasi') }}?subject=Hak+Merek" class="px-4 py-2 rounded-xl bg-[#991b1b] text-white font-bold hover:bg-[#801414] transition-colors">Ajukan Surat Rekomendasi Merek</a>
                </div>
            </div>

        </div>

        <!-- ============================================================== -->
        <!-- FAQ SECTION (FREQUENTLY ASKED QUESTIONS)                       -->
        <!-- ============================================================== -->
        <div id="section-faq" class="mt-14 bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm scroll-mt-24"
             data-keywords="faq tanya jawab pertanyaan kendala lupa password biaya kurasi gratis foto gagal kompres">
            
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-wider text-[#991b1b] bg-red-50 px-3 py-1 rounded-full">Tanya Jawab Populer</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">Pertanyaan yang Sering Diajukan (FAQ)</h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Jawaban atas pertanyaan yang paling sering dihadapi oleh pelaku UMKM Wonogiri saat menggunakan portal ini.</p>
            </div>

            <div class="space-y-3.5 max-w-4xl mx-auto">
                
                <!-- FAQ 1 -->
                <div class="faq-item border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200">
                    <button type="button" onclick="toggleFaq(this)" class="w-full text-left p-5 flex items-center justify-between gap-4 bg-white hover:bg-slate-50/80 transition-colors">
                        <span class="text-xs sm:text-sm font-bold text-slate-900">Apakah pendaftaran akun dan promosi produk di portal Pojok UMKM dipungut biaya?</span>
                        <span class="faq-icon text-[#991b1b] font-black text-lg transition-transform duration-200">&plus;</span>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 pt-1 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/40">
                        <strong>100% Gratis tanpa biaya apa pun.</strong> Portal Pojok UMKM adalah sarana promosi dan fasilitas digital resmi yang disediakan oleh Pemerintah Kabupaten Wonogiri melalui Dinas Perdagangan dan KUKM. Tidak ada biaya registrasi, biaya langganan bulanan, maupun potongan komisi penjualan.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="faq-item border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200">
                    <button type="button" onclick="toggleFaq(this)" class="w-full text-left p-5 flex items-center justify-between gap-4 bg-white hover:bg-slate-50/80 transition-colors">
                        <span class="text-xs sm:text-sm font-bold text-slate-900">Berapa lama proses verifikasi akun profil usaha oleh tim kurasi dinas?</span>
                        <span class="faq-icon text-[#991b1b] font-black text-lg transition-transform duration-200">&plus;</span>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 pt-1 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/40">
                        Proses verifikasi profil usaha oleh kurator dinas rata-rata membutuhkan waktu <strong>1 hingga 2 hari kerja</strong>. Pastikan Anda mengisi nama pemilik, nomor WhatsApp, dan memilih kecamatan yang valid agar proses persetujuan berlangsung lebih cepat.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="faq-item border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200">
                    <button type="button" onclick="toggleFaq(this)" class="w-full text-left p-5 flex items-center justify-between gap-4 bg-white hover:bg-slate-50/80 transition-colors">
                        <span class="text-xs sm:text-sm font-bold text-slate-900">Mengapa foto produk saya gagal diunggah atau muncul peringatan galat?</span>
                        <span class="faq-icon text-[#991b1b] font-black text-lg transition-transform duration-200">&plus;</span>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 pt-1 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/40">
                        Kendala unggah foto umumnya disebabkan oleh: (1) Ukuran file melebihi batas maksimal <strong>2 Megabytes (2MB)</strong>, atau (2) Format file bukan JPG, JPEG, PNG, atau WEBP. Silakan kompres foto menggunakan aplikasi kompres foto di ponsel atau perkecil resolusi kamera Anda menjadi 1:1 atau 4:3 sebelum mengunggah.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="faq-item border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200">
                    <button type="button" onclick="toggleFaq(this)" class="w-full text-left p-5 flex items-center justify-between gap-4 bg-white hover:bg-slate-50/80 transition-colors">
                        <span class="text-xs sm:text-sm font-bold text-slate-900">Bagaimana jika saya lupa kata sandi akun UMKM saya?</span>
                        <span class="faq-icon text-[#991b1b] font-black text-lg transition-transform duration-200">&plus;</span>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 pt-1 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/40">
                        Anda dapat mengajukan permohonan pemulihan kata sandi kepada helpdesk dinas melalui formulir <a href="{{ route('konsultasi') }}" class="text-[#991b1b] font-bold underline">Konsultasi Online</a> atau mengirimkan pesan ke WhatsApp resmi helpdesk dinas dengan menyertakan alamat email dan nama usaha yang terdaftar untuk verifikasi data.
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="faq-item border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200">
                    <button type="button" onclick="toggleFaq(this)" class="w-full text-left p-5 flex items-center justify-between gap-4 bg-white hover:bg-slate-50/80 transition-colors">
                        <span class="text-xs sm:text-sm font-bold text-slate-900">Apakah pelaku usaha rumahan yang belum memiliki izin NIB boleh bergabung?</span>
                        <span class="faq-icon text-[#991b1b] font-black text-lg transition-transform duration-200">&plus;</span>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 pt-1 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/40">
                        <strong>Sangat boleh!</strong> Seluruh pelaku usaha berskala mikro dan rumahan di Wonogiri dapat langsung mendaftar. Tim fasilitator Pojok UMKM justru akan memandu dan mendampingi Anda membuat NIB OSS secara resmi dan gratis sampai terbit.
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="faq-item border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200">
                    <button type="button" onclick="toggleFaq(this)" class="w-full text-left p-5 flex items-center justify-between gap-4 bg-white hover:bg-slate-50/80 transition-colors">
                        <span class="text-xs sm:text-sm font-bold text-slate-900">Bagaimana sistem transaksi jual beli di portal Pojok UMKM?</span>
                        <span class="faq-icon text-[#991b1b] font-black text-lg transition-transform duration-200">&plus;</span>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 pt-1 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/40">
                        Portal ini menghubungkan pembeli langsung dengan penjual melalui tombol <strong>Hubungi via WhatsApp (Direct Order)</strong> atau melalui tautan marketplace resmi milik UMKM (Shopee/Tokopedia). Portal tidak menampung dana pembayaran, sehingga transaksi berlangsung aman dan langsung ke rekening pelaku UMKM.
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="faq-item border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200">
                    <button type="button" onclick="toggleFaq(this)" class="w-full text-left p-5 flex items-center justify-between gap-4 bg-white hover:bg-slate-50/80 transition-colors">
                        <span class="text-xs sm:text-sm font-bold text-slate-900">Bagaimana cara membalas jawaban petugas pada tiket konsultasi?</span>
                        <span class="faq-icon text-[#991b1b] font-black text-lg transition-transform duration-200">&plus;</span>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 pt-1 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/40">
                        Bagi pengguna yang login, Anda dapat melihat riwayat dan membalas di menu Konsultasi dashboard. Bagi pemohon publik, Anda dapat membuka halaman <a href="{{ route('konsultasi.cek') }}" class="text-[#991b1b] font-bold underline">Cek Tiket</a>, masukkan Nomor Tiket dan Nomor WhatsApp, lalu ketikkan tanggapan Anda pada kolom balasan yang tersedia di bagian bawah rincian percakapan.
                    </div>
                </div>

            </div>
        </div>

        <!-- ============================================================== -->
        <!-- CALL TO ACTION (CTA) SECTION                                   -->
        <!-- ============================================================== -->
        <div class="mt-14 bg-gradient-to-r from-[#800000] via-[#941515] to-[#700000] rounded-3xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
            <!-- Decorative circles -->
            <div class="absolute -right-16 -top-16 w-80 h-80 bg-red-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-80 h-80 bg-amber-400/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-400/20 text-amber-300 border border-amber-400/30 uppercase tracking-wider mb-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Bergabung Sekarang
                    </span>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-white leading-tight mb-3">
                        Siap Kembangkan Bisnis Anda Bersama Pojok UMKM Wonogiri?
                    </h2>
                    <p class="text-red-100 text-xs sm:text-sm leading-relaxed">
                        Perluas jangkauan pasar produk lokal Anda, dapatkan fasilitas kurasi produk unggulan, dan nikmati pendampingan legalitas gratis dari Pemerintah Kabupaten Wonogiri.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 shrink-0">
                    <a href="{{ route('register') }}" class="px-6 py-3.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-[#800000] font-black text-sm text-center shadow-lg transition-all transform hover:-translate-y-0.5 inline-flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.765z"/>
                        </svg>
                        <span>Daftar Akun UMKM Baru</span>
                    </a>
                    <a href="{{ route('login') }}" class="px-6 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-sm text-center border border-white/25 transition-all inline-flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                        </svg>
                        <span>Masuk ke Dashboard</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Interactive Scripts: Live Search, Filter Chips, Master Tab Switching, FAQ Accordion, and Smooth Scroll -->
@push('scripts')
<script>
    // Tab Switching Functionality
    function switchMasterTab(tabName) {
        const portalSection = document.getElementById('section-portal-guide');
        const legalitasSection = document.getElementById('section-legalitas-guide');
        const btnPortal = document.getElementById('tab-btn-portal');
        const btnLegalitas = document.getElementById('tab-btn-legalitas');

        if (tabName === 'legalitas') {
            portalSection.classList.add('hidden');
            legalitasSection.classList.remove('hidden');

            btnLegalitas.className = 'flex-1 flex items-center justify-center gap-2.5 py-3 px-4 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 bg-[#800000] text-white shadow-xs';
            btnPortal.className = 'flex-1 flex items-center justify-center gap-2.5 py-3 px-4 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 text-slate-600 hover:text-[#800000] hover:bg-slate-50';
        } else {
            legalitasSection.classList.add('hidden');
            portalSection.classList.remove('hidden');

            btnPortal.className = 'flex-1 flex items-center justify-center gap-2.5 py-3 px-4 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 bg-[#800000] text-white shadow-xs';
            btnLegalitas.className = 'flex-1 flex items-center justify-center gap-2.5 py-3 px-4 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 text-slate-600 hover:text-[#800000] hover:bg-slate-50';
        }
    }

    // Scroll to Target Section with Highlight Animation
    function scrollToSection(targetId) {
        // If target is in legalitas tab, switch to legalitas tab first
        if (targetId.startsWith('guide-')) {
            switchMasterTab('legalitas');
        } else if (targetId.startsWith('modul-')) {
            switchMasterTab('portal');
        }

        setTimeout(() => {
            const el = document.getElementById(targetId);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                el.classList.add('ring-4', 'ring-amber-400', 'ring-offset-4');
                setTimeout(() => {
                    el.classList.remove('ring-4', 'ring-amber-400', 'ring-offset-4');
                }, 2200);
            }
        }, 80);
    }

    // Live Search Functionality
    function handleLiveSearch(query) {
        const cleanQuery = (query || '').toLowerCase().trim();
        const clearBtn = document.getElementById('btn-clear-search');
        if (clearBtn) {
            if (cleanQuery.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
        }

        const guideBlocks = document.querySelectorAll('.guide-block');
        let portalMatches = 0;

        guideBlocks.forEach(block => {
            const keywords = (block.getAttribute('data-keywords') || '').toLowerCase();
            const textContent = block.innerText.toLowerCase();

            if (cleanQuery === '' || keywords.includes(cleanQuery) || textContent.includes(cleanQuery)) {
                block.style.display = 'block';
                portalMatches++;
            } else {
                block.style.display = 'none';
            }
        });

        const noResult = document.getElementById('no-result-notice-portal');
        if (noResult) {
            if (portalMatches === 0 && cleanQuery !== '') {
                noResult.classList.remove('hidden');
            } else {
                noResult.classList.add('hidden');
            }
        }
    }

    function clearLiveSearch() {
        const input = document.getElementById('guide-search-input');
        if (input) {
            input.value = '';
            handleLiveSearch('');
            input.focus();
        }
    }

    // Quick Filter by Topic Chips
    function filterByTopic(topic) {
        const chips = document.querySelectorAll('.quick-chip');
        chips.forEach(c => {
            c.className = 'quick-chip px-3 py-1 rounded-full bg-white/15 text-white hover:bg-white/25 border border-white/20 transition-all';
        });

        if (window.event && window.event.target) {
            window.event.target.className = 'quick-chip active px-3 py-1 rounded-full bg-amber-400 text-[#800000] font-bold shadow-xs hover:bg-amber-300 transition-all';
        }

        if (topic === 'all') {
            switchMasterTab('portal');
            clearLiveSearch();
        } else if (topic === 'registrasi') {
            switchMasterTab('portal');
            scrollToSection('modul-registrasi');
        } else if (topic === 'katalog') {
            switchMasterTab('portal');
            scrollToSection('modul-katalog');
        } else if (topic === 'konsultasi') {
            switchMasterTab('portal');
            scrollToSection('modul-konsultasi');
        } else if (topic === 'faq') {
            scrollToSection('section-faq');
        } else if (topic === 'legalitas') {
            switchMasterTab('legalitas');
            scrollToSection('section-legalitas-guide');
        }
    }

    // Accordion FAQ Toggle
    function toggleFaq(button) {
        const item = button.closest('.faq-item');
        const answer = item.querySelector('.faq-answer');
        const icon = item.querySelector('.faq-icon');

        if (answer.classList.contains('hidden')) {
            answer.classList.remove('hidden');
            icon.innerHTML = '&minus;';
            item.classList.add('border-[#800000]/40', 'shadow-xs');
        } else {
            answer.classList.add('hidden');
            icon.innerHTML = '&plus;';
            item.classList.remove('border-[#800000]/40', 'shadow-xs');
        }
    }

    // Support URL query param or hash on page load
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');
        if (tab === 'legalitas') {
            switchMasterTab('legalitas');
        }

        const hash = window.location.hash;
        if (hash) {
            const cleanId = hash.replace('#', '');
            scrollToSection(cleanId);
        }
    });
</script>
@endpush
@endsection
