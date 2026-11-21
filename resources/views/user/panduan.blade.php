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
                Panduan praktis dan langkah resmi bagi pelaku UMKM di Kabupaten Wonogiri untuk mendaftar akun, mengelola katalog produk, hingga mengajukan konsultasi online secara mandiri bersama Dinas Perdagangan dan KUKM.
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
                           placeholder="Cari panduan (misal: daftar akun, foto produk, harga tanpa titik, tiket konsultasi, NIB)..."
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
                    <button type="button" onclick="filterByTopic('registrasi')" class="quick-chip px-3 py-1 rounded-full bg-white/15 text-white hover:bg-white/25 border border-white/20 transition-all">1. Registrasi Akun</button>
                    <button type="button" onclick="filterByTopic('katalog')" class="quick-chip px-3 py-1 rounded-full bg-white/15 text-white hover:bg-white/25 border border-white/20 transition-all">2. Kelola Produk</button>
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
                <span>Panduan Fitur Portal UMKM (3 Modul Utama)</span>
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
        <!-- TAB 1: PANDUAN PENGGUNAAN PORTAL POJOK UMKM (CORE FEATURE)    -->
        <!-- ============================================================== -->
        <div id="section-portal-guide" class="space-y-10">

            <!-- 3 Modul Quick Cards Header / Overview Stepper -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Card 1 -->
                <div onclick="scrollToSection('modul-registrasi')" class="p-6 rounded-3xl bg-white border border-slate-200/90 hover:border-amber-400 hover:shadow-md transition-all cursor-pointer group flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="w-10 h-10 rounded-2xl bg-amber-500 text-white font-black text-base flex items-center justify-center shadow-xs">1</span>
                            <span class="text-[10px] font-bold text-amber-800 bg-amber-100 px-2.5 py-1 rounded-full uppercase tracking-wider">Langkah Awal</span>
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-base sm:text-lg group-hover:text-amber-800 transition-colors mb-2">
                            Registrasi &amp; Profil Usaha
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Panduan daftar akun baru, melengkapi nama bisnis, memilih kecamatan di Wonogiri, nomor WhatsApp aktif, dan legalitas izin.
                        </p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-slate-100 text-xs font-bold text-amber-700 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Pelajari Modul Registrasi &rarr;
                    </div>
                </div>

                <!-- Card 2 -->
                <div onclick="scrollToSection('modul-katalog')" class="p-6 rounded-3xl bg-white border border-slate-200/90 hover:border-emerald-500 hover:shadow-md transition-all cursor-pointer group flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="w-10 h-10 rounded-2xl bg-emerald-600 text-white font-black text-base flex items-center justify-center shadow-xs">2</span>
                            <span class="text-[10px] font-bold text-emerald-800 bg-emerald-100 px-2.5 py-1 rounded-full uppercase tracking-wider">Etalase Produk</span>
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-base sm:text-lg group-hover:text-emerald-800 transition-colors mb-2">
                            Pengelolaan Katalog Produk
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Ketentuan upload foto maks 2MB, penulisan deskripsi menarik, format harga satuan tanpa titik, dan tautan marketplace.
                        </p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-slate-100 text-xs font-bold text-emerald-700 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Pelajari Modul Katalog &rarr;
                    </div>
                </div>

                <!-- Card 3 -->
                <div onclick="scrollToSection('modul-konsultasi')" class="p-6 rounded-3xl bg-white border border-slate-200/90 hover:border-blue-500 hover:shadow-md transition-all cursor-pointer group flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="w-10 h-10 rounded-2xl bg-blue-600 text-white font-black text-base flex items-center justify-center shadow-xs">3</span>
                            <span class="text-[10px] font-bold text-blue-800 bg-blue-100 px-2.5 py-1 rounded-full uppercase tracking-wider">Bantuan Dinas</span>
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-base sm:text-lg group-hover:text-blue-800 transition-colors mb-2">
                            Tiket Konsultasi Online
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Cara memilih topik bimbingan, menuliskan detail kendala, upload lampiran foto, serta melacak status tiket (Open, In Progress, Resolved).
                        </p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-slate-100 text-xs font-bold text-blue-700 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Pelajari Modul Konsultasi &rarr;
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
            <!-- MODUL 1: REGISTRASI & PENGISIAN PROFIL USAHA                   -->
            <!-- ============================================================== -->
            <div id="modul-registrasi" class="guide-block bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-10 scroll-mt-24"
                 data-keywords="registrasi daftar buat akun register profil usaha toko umkm kecamatan wonogiri nomor wa whatsapp legalitas nib pirt halal kurasi">
                
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-slate-100 mb-8">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center font-black text-xl shadow-xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.765z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-black uppercase tracking-wider text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-md">Modul Bagian A</span>
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Registrasi &amp; Pengisian Profil Usaha</h2>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('register') }}" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs transition-colors shadow-xs inline-flex items-center gap-1.5">
                            <span>Buka Halaman Daftar</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                </div>

                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-8">
                    Seluruh pelaku usaha mikro, kecil, dan menengah yang beroperasi di wilayah Kabupaten Wonogiri berhak mendaftar akun di portal Pojok UMKM secara <strong class="text-slate-900 font-bold">100% Gratis</strong>. Ikuti 5 tahapan pengisian di bawah ini agar profil usaha Anda segera terverifikasi oleh Dinas KUKM.
                </p>

                <!-- Steps Accordion / Cards List -->
                <div class="space-y-4">
                    
                    <!-- Step 1 -->
                    <div class="border border-slate-200/90 rounded-2xl p-5 sm:p-6 bg-slate-50/50 hover:bg-white hover:border-amber-300 transition-all">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-amber-500 text-white font-black text-sm flex items-center justify-center shrink-0 mt-0.5">1</span>
                            <div class="flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5">Daftar Akun Baru di Portal</h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                                    Klik tombol <strong>Daftar</strong> di navigasi atas atau kunjungi halaman <a href="{{ route('register') }}" class="text-[#991b1b] font-bold underline">/register</a>. Isi formulir dengan data pemilik usaha:
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs text-slate-700 bg-white p-3.5 rounded-xl border border-slate-200">
                                    <div class="flex items-center gap-2"><span class="text-amber-500 font-bold">&check;</span> <strong>Nama Lengkap:</strong> Sesuai identitas KTP pemilik.</div>
                                    <div class="flex items-center gap-2"><span class="text-amber-500 font-bold">&check;</span> <strong>Email Aktif:</strong> Untuk notifikasi sistem &amp; login.</div>
                                    <div class="flex items-center gap-2"><span class="text-amber-500 font-bold">&check;</span> <strong>Nomor WhatsApp:</strong> Awali angka 08 (misal 08123456789).</div>
                                    <div class="flex items-center gap-2"><span class="text-amber-500 font-bold">&check;</span> <strong>Password:</strong> Minimal 8 karakter kombinasi huruf &amp; angka.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="border border-slate-200/90 rounded-2xl p-5 sm:p-6 bg-slate-50/50 hover:bg-white hover:border-amber-300 transition-all">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-amber-500 text-white font-black text-sm flex items-center justify-center shrink-0 mt-0.5">2</span>
                            <div class="flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5">Lengkapi Identitas &amp; Deskripsi Bisnis</h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                                    Setelah login, masuk ke <strong>Pengaturan Toko / Profil UMKM</strong>. Masukkan nama merek atau nama usaha Anda secara jelas (contoh: <em>Kacang Mete Wonogiren Berkah</em>, <em>Batik Canting Tirtomoyo</em>), lalu tentukan kategori usaha yang paling sesuai:
                                </p>
                                <div class="flex flex-wrap gap-1.5 text-[11px] font-semibold text-slate-600">
                                    <span class="bg-amber-100/80 text-amber-800 px-2.5 py-1 rounded-lg">Makanan &amp; Minuman</span>
                                    <span class="bg-amber-100/80 text-amber-800 px-2.5 py-1 rounded-lg">Batik &amp; Fashion</span>
                                    <span class="bg-amber-100/80 text-amber-800 px-2.5 py-1 rounded-lg">Kerajinan Tangan</span>
                                    <span class="bg-amber-100/80 text-amber-800 px-2.5 py-1 rounded-lg">Pertanian &amp; Perkebunan</span>
                                    <span class="bg-amber-100/80 text-amber-800 px-2.5 py-1 rounded-lg">Jasa &amp; Perdagangan</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="border border-slate-200/90 rounded-2xl p-5 sm:p-6 bg-slate-50/50 hover:bg-white hover:border-amber-300 transition-all">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-amber-500 text-white font-black text-sm flex items-center justify-center shrink-0 mt-0.5">3</span>
                            <div class="flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5">Pilih Lokasi Kecamatan di Wonogiri (25 Kecamatan)</h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                                    Pilih salah satu dari <strong>25 Kecamatan</strong> di Kabupaten Wonogiri tempat usaha Anda beroperasi. Data ini sangat penting untuk menampilkan titik lokasi usaha Anda pada fitur <strong>Direktori &amp; Peta Interaktif UMKM Wonogiri</strong>.
                                </p>
                                <div class="bg-white p-3 rounded-xl border border-slate-200 text-xs text-slate-600 leading-relaxed">
                                    <strong class="text-slate-800">Cakupan Wilayah Binaan:</strong> Wonogiri Kota, Ngadirojo, Baturetno, Pracimantoro, Purwantoro, Tirtomoyo, Eromoko, Giriwoyo, Jatisrono, Manyaran, Slogohimo, Wuryantoro, Kismantoro, Bulukerto, Selogiri, Sidoharjo, Girimarto, Jatipurno, Karangtengah, Paranggupito, Puhpelem, Nguntoronadi, Batuwarno, Giritontro, dan Jatiroto.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="border border-slate-200/90 rounded-2xl p-5 sm:p-6 bg-slate-50/50 hover:bg-white hover:border-amber-300 transition-all">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-amber-500 text-white font-black text-sm flex items-center justify-center shrink-0 mt-0.5">4</span>
                            <div class="flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5">Konfigurasi Nomor WhatsApp Aktif (Direct Order)</h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                                    Masukkan nomor WhatsApp aktif usaha Anda. Portal Pojok UMKM dilengkapi fitur tombol <strong class="text-emerald-700 font-bold">Pesan via WhatsApp</strong> di setiap halaman produk. Ketika pembeli menekan tombol tersebut, sistem akan langsung membuka obrolan ke WhatsApp Anda berisi nama produk yang diminati secara otomatis tanpa potongan komisi!
                                </p>
                                <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs p-3 rounded-xl flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                    <span>Format rekomendasi: <strong>081234567890</strong> atau <strong>6281234567890</strong> (pastikan nomor memiliki akun WA aktif).</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="border border-slate-200/90 rounded-2xl p-5 sm:p-6 bg-slate-50/50 hover:bg-white hover:border-amber-300 transition-all">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-amber-500 text-white font-black text-sm flex items-center justify-center shrink-0 mt-0.5">5</span>
                            <div class="flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5">Pengisian Legalitas Usaha (NIB, P-IRT, &amp; Halal)</h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                                    Cantumkan nomor izin legalitas yang telah Anda miliki. Jika Anda belum memilikinya, kolom ini dapat dikosongkan terlebih dahulu dan tim pendamping dinas siap membantu Anda mengurusnya tanpa biaya:
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                                    <div class="bg-white p-3 rounded-xl border border-slate-200">
                                        <div class="font-bold text-slate-800 mb-0.5">Nomor NIB</div>
                                        <div class="text-slate-500 text-[11px]">13 digit nomor izin berusaha dari sistem OSS Kementerian Investasi.</div>
                                    </div>
                                    <div class="bg-white p-3 rounded-xl border border-slate-200">
                                        <div class="font-bold text-slate-800 mb-0.5">Izin P-IRT</div>
                                        <div class="text-slate-500 text-[11px]">15 digit nomor izin edar pangan dari Dinas Kesehatan Wonogiri.</div>
                                    </div>
                                    <div class="bg-white p-3 rounded-xl border border-slate-200">
                                        <div class="font-bold text-slate-800 mb-0.5">Sertifikat Halal</div>
                                        <div class="text-slate-500 text-[11px]">Nomor sertifikat halal BPJPH Kemenag (Program SEHATI gratis).</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============================================================== -->
            <!-- MODUL 2: PENGELOLAAN KATALOG PRODUK                           -->
            <!-- ============================================================== -->
            <div id="modul-katalog" class="guide-block bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-10 scroll-mt-24"
                 data-keywords="katalog kelola tambah produk unggulan foto gambar 2mb resolusi harga satuan tanpa titik deskripsi produk link marketplace shopee tokopedia stok">
                
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-slate-100 mb-8">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-black text-xl shadow-xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-black uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-md">Modul Bagian B</span>
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Pengelolaan Katalog Produk Unggulan</h2>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('katalog') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold text-xs transition-colors shadow-2xs inline-flex items-center gap-1.5">
                            <span>Lihat Katalog Publik</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                </div>

                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-8">
                    Katalog produk adalah etalase digital utama yang dilihat oleh ribuan masyarakat luas, pembeli luar daerah, dan calon investor. Pastikan produk Anda disajikan dengan informasi yang rapi, visual yang memikat, dan ketentuan teknis yang benar.
                </p>

                <!-- Steps List -->
                <div class="space-y-4">
                    
                    <!-- Step 1: Upload Foto -->
                    <div class="border border-slate-200/90 rounded-2xl p-5 sm:p-6 bg-slate-50/50 hover:bg-white hover:border-emerald-400 transition-all">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-emerald-600 text-white font-black text-sm flex items-center justify-center shrink-0 mt-0.5">1</span>
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                                    <h3 class="text-sm sm:text-base font-bold text-slate-900">Ketentuan Upload Foto Produk (Maks 2MB)</h3>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">Format: JPG, PNG, WEBP</span>
                                </div>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                                    Unggah foto asli dari produk Anda. Demi performa portal yang kencang dan hemat kuota bagi calon pembeli, perhatikan panduan berikut:
                                </p>
                                <ul class="space-y-1.5 text-xs text-slate-600 bg-white p-3.5 rounded-xl border border-slate-200">
                                    <li class="flex items-start gap-2"><span class="text-emerald-600 font-bold">&bull;</span> <strong>Ukuran Berkas:</strong> Maksimal <strong>2 Megabytes (2.048 KB)</strong>. Jika ukuran file HP terlalu besar, gunakan aplikasi kompres foto terlebih dahulu.</li>
                                    <li class="flex items-start gap-2"><span class="text-emerald-600 font-bold">&bull;</span> <strong>Rasio Aspek:</strong> Disarankan rasio 1:1 (persegi) atau 4:3 dengan pencahayaan terang alami tanpa efek filter gelap.</li>
                                    <li class="flex items-start gap-2"><span class="text-emerald-600 font-bold">&bull;</span> <strong>Fokus Gambar:</strong> Tampilkan kemasan produk secara utuh dan jelas sehingga label serta merek terlihat profesional.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Penulisan Deskripsi -->
                    <div class="border border-slate-200/90 rounded-2xl p-5 sm:p-6 bg-slate-50/50 hover:bg-white hover:border-emerald-400 transition-all">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-emerald-600 text-white font-black text-sm flex items-center justify-center shrink-0 mt-0.5">2</span>
                            <div class="flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5">Penulisan Judul &amp; Deskripsi Produk yang Memikat</h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                                    Gunakan judul yang ringkas dan memuat kata kunci pencarian calon pembeli. Deskripsi harus menjawab pertanyaan pokok konsumen:
                                </p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                                    <div class="bg-white p-3.5 rounded-xl border border-slate-200">
                                        <div class="font-bold text-emerald-800 mb-1 flex items-center gap-1.5">
                                            <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px]">&check;</span>
                                            Contoh Judul Efektif:
                                        </div>
                                        <p class="text-slate-700 italic">"Kue Kering Nastar Mete Wonogiri Premium 250g"</p>
                                        <p class="text-slate-700 italic">"Kain Batik Tulis Canting Motif Parang Wonogiren"</p>
                                    </div>
                                    <div class="bg-white p-3.5 rounded-xl border border-slate-200">
                                        <div class="font-bold text-emerald-800 mb-1 flex items-center gap-1.5">
                                            <span class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px]">&check;</span>
                                            Poin Wajib di Kolom Deskripsi:
                                        </div>
                                        <p class="text-slate-600">Sertakan komposisi bahan baku lokal, berat bersih (gram/kg), masa kedaluwarsa, saran penyimpanan, dan nomor izin P-IRT/Halal.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Format Harga Satuan (Crucial Instruction) -->
                    <div class="border-2 border-emerald-300 rounded-2xl p-5 sm:p-6 bg-emerald-50/40 hover:bg-emerald-50/70 transition-all">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-emerald-700 text-white font-black text-sm flex items-center justify-center shrink-0 mt-0.5">3</span>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Format Input Harga Satuan (PENTING: Angka Tanpa Titik/Koma)</h3>
                                    <span class="text-[10px] font-black uppercase tracking-wider bg-rose-100 text-rose-800 px-2 py-0.5 rounded">Perhatikan!</span>
                                </div>
                                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed mb-3">
                                    Pada kolom formulir <strong>Harga Satuan</strong>, masukkan nominal <strong class="text-slate-900">angka murni saja</strong>. Jangan menuliskan tanda titik (.), koma (,), simbol mata uang "Rp", atau spasi. Sistem akan otomatis memformat dan menampilkan harga dalam format mata uang resmi rupiah.
                                </p>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                    <div class="p-3 rounded-xl bg-white border border-emerald-300 shadow-2xs">
                                        <div class="flex items-center gap-1.5 text-emerald-700 font-bold mb-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                            CARA INPUT YANG BENAR:
                                        </div>
                                        <div class="font-mono text-sm bg-slate-100 p-2 rounded-lg text-slate-800 font-bold mb-1">25000</div>
                                        <div class="text-[11px] text-slate-500">Sistem otomatis menampilkan: <strong class="text-emerald-700">Rp 25.000</strong></div>
                                    </div>
                                    <div class="p-3 rounded-xl bg-white border border-rose-300 shadow-2xs">
                                        <div class="flex items-center gap-1.5 text-rose-700 font-bold mb-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                            CONTOH SALAH (JANGAN DILAKUKAN):
                                        </div>
                                        <div class="font-mono text-sm bg-rose-50 p-2 rounded-lg text-rose-800 font-bold mb-1 line-through">Rp 25.000 &bull; 25.000 &bull; 25,000</div>
                                        <div class="text-[11px] text-slate-500">Dapat menyebabkan error angka atau harga terbaca Rp 25 di sistem.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Tautan Marketplace -->
                    <div class="border border-slate-200/90 rounded-2xl p-5 sm:p-6 bg-slate-50/50 hover:bg-white hover:border-emerald-400 transition-all">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-emerald-600 text-white font-black text-sm flex items-center justify-center shrink-0 mt-0.5">4</span>
                            <div class="flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5">Penautan Link Marketplace &amp; Media Sosial Usaha</h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                                    Jika Anda telah memiliki toko online di Shopee, Tokopedia, Bukalapak, TikTok Shop, atau katalog Instagram, masukkan tautan URL lengkapnya pada kolom <strong>Tautan Marketplace</strong>.
                                </p>
                                <div class="bg-white p-3 rounded-xl border border-slate-200 text-xs text-slate-600 space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono text-emerald-700 font-bold bg-slate-100 px-2 py-0.5 rounded">https://shopee.co.id/tokoanda</span>
                                        <span class="text-slate-400">&bull; Langsung membuka aplikasi Shopee pembeli</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono text-emerald-700 font-bold bg-slate-100 px-2 py-0.5 rounded">https://tokopedia.com/tokoanda</span>
                                        <span class="text-slate-400">&bull; Checkout aman dengan fasilitas bebas ongkir</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Kurasi Produk Unggulan -->
                    <div class="border border-slate-200/90 rounded-2xl p-5 sm:p-6 bg-slate-50/50 hover:bg-white hover:border-emerald-400 transition-all">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-emerald-600 text-white font-black text-sm flex items-center justify-center shrink-0 mt-0.5">5</span>
                            <div class="flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5">Kurasi Menjadi "Produk Unggulan" Kabupaten Wonogiri</h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                    Produk yang memiliki kualitas kemasan standar BPOM, izin edar P-IRT/Halal lengkap, dan foto berkualitas tinggi akan dikurasi secara berkala oleh tim Dinas KUKM untuk disematkan badge emas <strong>Produk Unggulan</strong> dan ditampilkan di halaman muka Beranda utama portal!
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============================================================== -->
            <!-- MODUL 3: PENGAJUAN TIKET KONSULTASI ONLINE                     -->
            <!-- ============================================================== -->
            <div id="modul-konsultasi" class="guide-block bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-10 scroll-mt-24"
                 data-keywords="konsultasi online tiket perizinan kendala bantuan dinas open in progress resolved cek tiket reply solusi lampiran berkas">
                
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-slate-100 mb-8">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-black text-xl shadow-xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-black uppercase tracking-wider text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-md">Modul Bagian C</span>
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Pengajuan Tiket Konsultasi Online</h2>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('konsultasi') }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs transition-colors shadow-xs inline-flex items-center gap-1.5">
                            <span>Formulir Konsultasi</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                        <a href="{{ route('konsultasi.cek') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold text-xs transition-colors shadow-2xs">
                            Cek Tiket Anda
                        </a>
                    </div>
                </div>

                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-8">
                    Layanan Konsultasi Online menghubungkan Anda langsung dengan fasilitator dan praktisi dinas untuk menyelesaikan kendala legalitas, permodalan, kemasan, hingga pelatihan manajemen secara cepat dan tercatat transparan.
                </p>

                <!-- Steps List -->
                <div class="space-y-4">
                    
                    <!-- Step 1: Topik Konsultasi -->
                    <div class="border border-slate-200/90 rounded-2xl p-5 sm:p-6 bg-slate-50/50 hover:bg-white hover:border-blue-400 transition-all">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-blue-600 text-white font-black text-sm flex items-center justify-center shrink-0 mt-0.5">1</span>
                            <div class="flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5">Memilih Topik Bidang Konsultasi</h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                                    Buka formulir <a href="{{ route('konsultasi') }}" class="text-[#991b1b] font-bold underline">/konsultasi</a>, lalu tentukan topik permasalahan yang sesuai agar tiket langsung didisposisikan ke petugas ahli yang tepat:
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 text-xs">
                                    <div class="p-2.5 rounded-xl bg-white border border-slate-200">
                                        <div class="font-bold text-blue-900">&bull; Perizinan &amp; Legalitas</div>
                                        <div class="text-[11px] text-slate-500">NIB OSS, P-IRT Dinkes, Sertifikat Halal.</div>
                                    </div>
                                    <div class="p-2.5 rounded-xl bg-white border border-slate-200">
                                        <div class="font-bold text-blue-900">&bull; Kemasan &amp; Merek HAKI</div>
                                        <div class="text-[11px] text-slate-500">Desain label BPOM &amp; pendaftaran hak merek.</div>
                                    </div>
                                    <div class="p-2.5 rounded-xl bg-white border border-slate-200">
                                        <div class="font-bold text-blue-900">&bull; Pemasaran &amp; Digitalisasi</div>
                                        <div class="text-[11px] text-slate-500">Jualan online, media sosial &amp; marketplace.</div>
                                    </div>
                                    <div class="p-2.5 rounded-xl bg-white border border-slate-200">
                                        <div class="font-bold text-blue-900">&bull; Permodalan &amp; KUR</div>
                                        <div class="text-[11px] text-slate-500">Akses pembiayaan bank &amp; subsidi bunga.</div>
                                    </div>
                                    <div class="p-2.5 rounded-xl bg-white border border-slate-200">
                                        <div class="font-bold text-blue-900">&bull; Pelatihan &amp; Manajemen</div>
                                        <div class="text-[11px] text-slate-500">Workshop bimbingan teknis &amp; pembukuan.</div>
                                    </div>
                                    <div class="p-2.5 rounded-xl bg-white border border-slate-200">
                                        <div class="font-bold text-blue-900">&bull; Lainnya</div>
                                        <div class="text-[11px] text-slate-500">Pertanyaan umum seputar program dinas.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Detail Kendala & Lampiran -->
                    <div class="border border-slate-200/90 rounded-2xl p-5 sm:p-6 bg-slate-50/50 hover:bg-white hover:border-blue-400 transition-all">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-blue-600 text-white font-black text-sm flex items-center justify-center shrink-0 mt-0.5">2</span>
                            <div class="flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5">Menuliskan Detail Kendala &amp; Melampirkan Dokumen Pendukung</h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                                    Tuliskan kronologi kendala Anda secara runut pada kolom pesan. Jika ada berkas bukti (tangkapan layar error OSS, foto kemasan saat ini, atau draft sertifikat), lampirkan melalui tombol upload:
                                </p>
                                <div class="bg-blue-50/60 p-3.5 rounded-xl border border-blue-200 text-xs text-blue-900 space-y-1">
                                    <div>&bull; <strong>Format Lampiran:</strong> PDF, JPG, JPEG, atau PNG.</div>
                                    <div>&bull; <strong>Batas Maksimal File:</strong> 2MB per file agar pengiriman berjalan lancar tanpa kendala kuota.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Memahami Status Tiket (Crucial Spec) -->
                    <div class="border border-slate-200/90 rounded-2xl p-5 sm:p-6 bg-slate-50/50 hover:bg-white hover:border-blue-400 transition-all">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-blue-600 text-white font-black text-sm flex items-center justify-center shrink-0 mt-0.5">3</span>
                            <div class="flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-2">Memantau Alur Status Tiket Konsultasi</h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                                    Setiap pengajuan tiket memperoleh nomor referensi unik (contoh: <strong class="text-slate-800">#TKT-2026-0042</strong>). Status tiket memiliki 3 tahapan resmi:
                                </p>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                                    <!-- Status 1: Open -->
                                    <div class="p-4 rounded-xl bg-white border border-amber-300 shadow-2xs">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="w-3 h-3 rounded-full bg-amber-500 animate-pulse"></span>
                                            <span class="font-extrabold text-amber-800 uppercase tracking-wide text-[11px]">1. Open (Menunggu)</span>
                                        </div>
                                        <p class="text-slate-600 leading-relaxed">
                                            Tiket berhasil dibuat dan masuk antrean sistem dinas. Petugas sedang menjadwalkan telaah awal.
                                        </p>
                                    </div>

                                    <!-- Status 2: In Progress -->
                                    <div class="p-4 rounded-xl bg-white border border-blue-300 shadow-2xs">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                                            <span class="font-extrabold text-blue-800 uppercase tracking-wide text-[11px]">2. In Progress (Diproses)</span>
                                        </div>
                                        <p class="text-slate-600 leading-relaxed">
                                            Konsultan dinas sedang memproses jawaban, memberikan instruksi perbaikan, atau menghubungi pemohon.
                                        </p>
                                    </div>

                                    <!-- Status 3: Resolved -->
                                    <div class="p-4 rounded-xl bg-white border border-emerald-300 shadow-2xs">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                            <span class="font-extrabold text-emerald-800 uppercase tracking-wide text-[11px]">3. Resolved (Selesai)</span>
                                        </div>
                                        <p class="text-slate-600 leading-relaxed">
                                            Solusi tuntas telah diberikan. Pelaku usaha dapat mencetak rekomendasi atau menutup konsultasi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Cek Tiket Tanpa Login -->
                    <div class="border border-slate-200/90 rounded-2xl p-5 sm:p-6 bg-slate-50/50 hover:bg-white hover:border-blue-400 transition-all">
                        <div class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-blue-600 text-white font-black text-sm flex items-center justify-center shrink-0 mt-0.5">4</span>
                            <div class="flex-1">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-1.5">Cek Status &amp; Balas Jawaban Petugas Tanpa Perlu Login</h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-3">
                                    Bagi pelaku UMKM yang mengajukan konsultasi secara publik tanpa membuat akun, Anda dapat mengecek status dan membalas pesan petugas secara mandiri kapan saja melalui menu <strong>Cek Tiket Konsultasi</strong>:
                                </p>
                                <div class="bg-white p-3.5 rounded-xl border border-slate-200 text-xs text-slate-600 space-y-1.5">
                                    <div class="flex items-center gap-2">
                                        <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-[10px]">1</span>
                                        <span>Buka halaman <a href="{{ route('konsultasi.cek') }}" class="text-[#991b1b] font-bold underline">/konsultasi/cek</a> melalui browser HP atau laptop.</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-[10px]">2</span>
                                        <span>Masukkan <strong>Nomor Tiket</strong> dan <strong>Nomor WhatsApp</strong> yang Anda gunakan saat mendaftar.</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-[10px]">3</span>
                                        <span>Baca catatan rekomendasi resmi dari petugas dinas dan kirim balasan jika terdapat hal yang ingin ditanyakan lagi.</span>
                                    </div>
                                </div>
                            </div>
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

        if (event && event.target) {
            event.target.className = 'quick-chip active px-3 py-1 rounded-full bg-amber-400 text-[#800000] font-bold shadow-xs hover:bg-amber-300 transition-all';
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
