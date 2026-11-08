@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen pb-20">

    <!-- Hero Header with Integrated Search Bar -->
    <div class="bg-[#800000] text-white pt-10 pb-16 sm:pb-20 relative overflow-hidden">
        <!-- Background decorative ambient circles -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-red-600 rounded-full mix-blend-overlay filter blur-3xl opacity-50 pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-orange-500 rounded-full mix-blend-overlay filter blur-3xl opacity-30 pointer-events-none"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-md border border-white/25 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide uppercase mb-4 text-red-100">
                <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
                Pusat Edukasi & Panduan Resmi UMKM
            </div>

            <!-- Headline -->
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-3 sm:mb-4">
                Panduan Legalitas Usaha: NIB, Halal, Kemasan, PIRT & Hak Merek
            </h1>

            <p class="text-red-100 text-xs sm:text-base md:text-lg max-w-3xl mx-auto mb-6 sm:mb-8 font-normal leading-relaxed">
                Panduan resmi pengurusan izin usaha bagi pelaku UMKM di Kabupaten Wonogiri. Seluruh proses perizinan dasar, izin edar PIRT, hingga sertifikasi halal difasilitasi tanpa dipungut biaya.
            </p>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 sm:-mt-8 relative z-20">

        <!-- 5 Steps Success Roadmap for Beginners -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/90 mb-10">
            <div class="mb-6 pb-4 border-b border-slate-100 text-center sm:text-left">
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                    Alur 5 Langkah Legalitas & Standarisasi UMKM
                </h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Tahapan rekomendasi bagi pelaku usaha Wonogiri dari perizinan dasar, sertifikasi halal, standarisasi kemasan, izin edar PIRT, hingga perlindungan merek.</p>
            </div>

            <!-- Steps Grid: 3 Kotak di Atas & 2 Kotak di Bawah -->
            <div class="space-y-4 sm:space-y-5">
                
                <!-- Baris 1: 3 Kotak Panduan -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">
                    
                    <!-- Kotak 1: NIB -->
                    <div onclick="scrollToGuide('guide-nib')" class="p-5 rounded-2xl bg-amber-50/60 border border-slate-200/80 hover:border-amber-400 hover:shadow-md transition-all cursor-pointer group flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="w-8 h-8 rounded-full bg-amber-500 text-white font-black text-sm flex items-center justify-center shadow-xs">1</span>
                                <span class="text-[10px] font-bold text-amber-800 bg-amber-100 px-2 py-0.5 rounded-md uppercase">Legalitas</span>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm sm:text-base group-hover:text-amber-800 transition-colors mb-1.5">Legalitas NIB</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">Izin usaha resmi secara daring melalui sistem OSS Kementerian Investasi.</p>
                        </div>
                        <div class="mt-4 text-[11px] font-bold text-amber-700 flex items-center gap-1">
                            Lihat panduan &rarr;
                        </div>
                    </div>

                    <!-- Kotak 2: Halal -->
                    <div onclick="scrollToGuide('guide-halal')" class="p-5 rounded-2xl bg-emerald-50/60 border border-slate-200/80 hover:border-emerald-400 hover:shadow-md transition-all cursor-pointer group flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="w-8 h-8 rounded-full bg-emerald-600 text-white font-black text-sm flex items-center justify-center shadow-xs">2</span>
                                <span class="text-[10px] font-bold text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded-md uppercase">Kepercayaan</span>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm sm:text-base group-hover:text-emerald-800 transition-colors mb-1.5">Sertifikasi Halal</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">Fasilitasi Sertifikasi Halal gratis BPJPH (Program SEHATI) bagi usaha mikro.</p>
                        </div>
                        <div class="mt-4 text-[11px] font-bold text-emerald-700 flex items-center gap-1">
                            Lihat panduan &rarr;
                        </div>
                    </div>

                    <!-- Kotak 3: Standar Kemasan -->
                    <div onclick="scrollToGuide('guide-kemasan')" class="p-5 rounded-2xl bg-rose-50/60 border border-slate-200/80 hover:border-rose-400 hover:shadow-md transition-all cursor-pointer group flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="w-8 h-8 rounded-full bg-rose-600 text-white font-black text-sm flex items-center justify-center shadow-xs">3</span>
                                <span class="text-[10px] font-bold text-rose-800 bg-rose-100 px-2 py-0.5 rounded-md uppercase">Standarisasi</span>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm sm:text-base group-hover:text-rose-800 transition-colors mb-1.5">Standar Kemasan</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">Ketentuan label, informasi gizi, dan material kemasan higienis BPOM.</p>
                        </div>
                        <div class="mt-4 text-[11px] font-bold text-rose-700 flex items-center gap-1">
                            Lihat panduan &rarr;
                        </div>
                    </div>

                </div>

                <!-- Baris 2: 2 Kotak Panduan (Centered Seimbang) -->
                <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-5">
                    
                    <!-- Kotak 4: Izin Edar PIRT -->
                    <div onclick="scrollToGuide('guide-pirt')" class="w-full sm:w-[calc(50%-0.625rem)] md:w-[calc(33.333%-0.85rem)] p-5 rounded-2xl bg-blue-50/60 border border-slate-200/80 hover:border-blue-400 hover:shadow-md transition-all cursor-pointer group flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="w-8 h-8 rounded-full bg-blue-600 text-white font-black text-sm flex items-center justify-center shadow-xs">4</span>
                                <span class="text-[10px] font-bold text-blue-800 bg-blue-100 px-2 py-0.5 rounded-md uppercase">Izin Edar</span>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm sm:text-base group-hover:text-blue-800 transition-colors mb-1.5">Izin PIRT (Dinkes)</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">Izin edar resmi Dinas Kesehatan agar produk pangan legal beredar luas.</p>
                        </div>
                        <div class="mt-4 text-[11px] font-bold text-blue-700 flex items-center gap-1">
                            Lihat panduan &rarr;
                        </div>
                    </div>

                    <!-- Kotak 5: Hak Merek -->
                    <div onclick="scrollToGuide('guide-merek')" class="w-full sm:w-[calc(50%-0.625rem)] md:w-[calc(33.333%-0.85rem)] p-5 rounded-2xl bg-purple-50/60 border border-slate-200/80 hover:border-purple-400 hover:shadow-md transition-all cursor-pointer group flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="w-8 h-8 rounded-full bg-purple-600 text-white font-black text-sm flex items-center justify-center shadow-xs">5</span>
                                <span class="text-[10px] font-bold text-purple-800 bg-purple-100 px-2 py-0.5 rounded-md uppercase">Perlindungan</span>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm sm:text-base group-hover:text-purple-800 transition-colors mb-1.5">Hak Merek (HAKI)</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">Pendaftaran nama dan logo brand ke DJKI Kemenkumham dengan subsidi dinas.</p>
                        </div>
                        <div class="mt-4 text-[11px] font-bold text-purple-700 flex items-center gap-1">
                            Lihat panduan &rarr;
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Section Title & Search Counter -->
        <div id="panduan-koleksi" class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-2 scroll-mt-24">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Koleksi Panduan Lengkap</h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Pilih modul panduan di bawah untuk membaca syarat, tahapan, dan link resmi perizinan.</p>
            </div>
            <div id="search-result-count" class="text-xs font-semibold text-slate-500 bg-white border border-slate-200 px-3 py-1.5 rounded-xl self-start sm:self-auto shadow-2xs">
                Menampilkan <span id="count-number" class="text-[#991b1b] font-bold">5</span> Modul Panduan
            </div>
        </div>

        <!-- Empty Search Notice -->
        <div id="no-result-notice" class="hidden text-center py-16 bg-white rounded-3xl border border-slate-200 shadow-sm mb-10">
            <div class="w-16 h-16 rounded-full bg-red-50 text-[#991b1b] flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Panduan Tidak Ditemukan</h3>
            <p class="text-sm text-slate-500 max-w-md mx-auto mt-1 mb-5">Tidak ada panduan yang cocok dengan kata kunci pencarian Anda. Coba kata kunci lain atau ajukan konsultasi langsung.</p>
            <div class="flex justify-center gap-3">
                <button type="button" onclick="filterByKeyword('')" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">Tampilkan Semua Panduan</button>
                <a href="{{ route('konsultasi') }}" class="px-5 py-2.5 rounded-xl bg-[#991b1b] hover:bg-[#801414] text-white font-bold text-xs transition-colors">Ajukan Konsultasi Gratis</a>
            </div>
        </div>

        <!-- Guides List (Searchable Container) -->
        <div id="guides-container" class="space-y-8">

            <!-- GUIDE 1: LEGALITAS NIB OSS -->
            <div id="guide-nib" class="guide-card bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300"
                 data-keywords="nib nomor induk berusaha oss rba perizinan usaha legalitas ktp izin dasar usaha mikro pendaftaran syarat daftar akun legal hukum gratis">
                <div class="p-6 sm:p-8 lg:p-10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center font-black text-xl shadow-xs">
                                🏢
                            </div>
                            <div>
                                <span class="text-[11px] font-extrabold tracking-wider uppercase text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-md">Langkah 1 &bull; Legalitas Dasar</span>
                                <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Panduan Pembuatan NIB (Nomor Induk Berusaha) via OSS RBA</h3>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 self-start sm:self-auto">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            100% Gratis & Terbit Instan
                        </span>
                    </div>

                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6">
                        Nomor Induk Berusaha (NIB) merupakan identitas resmi setiap pelaku usaha di Indonesia yang diterbitkan melalui sistem OSS Kementerian Investasi/BKPM. Selain sebagai bukti legalitas dasar, NIB berfungsi sebagai Tanda Daftar Perusahaan (TDP) dan menjadi syarat utama untuk mengakses pembiayaan perbankan serta program bantuan pemerintah.
                    </p>

                    <!-- Requirements & Steps Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-100 mb-6">
                        <!-- Left: Requirements -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Syarat Dokumen yang Diperlukan:
                            </h4>
                            <ul class="space-y-2 text-xs sm:text-sm text-slate-600">
                                <li class="flex items-start gap-2"><span class="text-amber-500 font-bold">&bull;</span> NIK KTP Elektronik Pemilik Usaha.</li>
                                <li class="flex items-start gap-2"><span class="text-amber-500 font-bold">&bull;</span> Nomor WhatsApp aktif dan Alamat Email aktif.</li>
                                <li class="flex items-start gap-2"><span class="text-amber-500 font-bold">&bull;</span> NPWP Pribadi atau Usaha (Opsional, jika sudah memiliki).</li>
                                <li class="flex items-start gap-2"><span class="text-amber-500 font-bold">&bull;</span> Data usaha: Nama Usaha, Alamat Lokasi, Jumlah Modal, dan Perkiraan Tenaga Kerja.</li>
                            </ul>
                        </div>

                        <!-- Right: Steps -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                                5 Langkah Pendaftaran Online:
                            </h4>
                            <ol class="space-y-2 text-xs sm:text-sm text-slate-600 list-decimal list-inside">
                                <li>Buka situs resmi <strong><a href="https://oss.go.id" target="_blank" rel="noopener noreferrer" class="text-[#991b1b] underline font-bold">oss.go.id</a></strong> melalui browser HP / Laptop.</li>
                                <li>Klik menu <strong>Daftar Hak Akses</strong>, pilih <em>Usaha Mikro dan Kecil (UMK)</em>.</li>
                                <li>Isi NIK KTP, tanggal lahir, email, dan verifikasi PIN yang dikirim ke email/WhatsApp.</li>
                                <li>Masuk ke Dashboard OSS, pilih menu <strong>Permohonan Baru</strong> lalu lengkapi detail usaha Anda (KBLI).</li>
                                <li>Klik <strong>Simpan dan Terbitkan NIB</strong>. File PDF NIB ber-barcode langsung dapat Anda unduh dan cetak!</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Benefits & Actions -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pt-5 border-t border-slate-100">
                        <div class="text-xs text-slate-600 leading-relaxed max-w-xl">
                            <strong class="font-bold text-slate-800">Manfaat Utama:</strong> Syarat pengajuan KUR perbankan, kepesertaan pelatihan dan pameran daerah, serta kepastian perlindungan hukum usaha.
                        </div>
                        <div class="flex items-center gap-2.5 shrink-0 w-full sm:w-auto">
                            <a href="https://oss.go.id" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto text-center px-4 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-bold transition-colors">
                                Portal OSS.go.id &nearr;
                            </a>
                            <a href="{{ route('konsultasi') }}?subject=Perizinan+Usaha" class="w-full sm:w-auto text-center px-4 py-2.5 rounded-xl bg-[#991b1b] hover:bg-[#801414] text-white text-xs font-bold transition-colors shadow-2xs">
                                Butuh Bantuan? Ajukan Pendampingan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GUIDE 2: SERTIFIKASI HALAL SEHATI -->
            <div id="guide-halal" class="guide-card bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300"
                 data-keywords="halal sertifikasi sertifikat halal gratis sehati bpjph bpjph kemenag sihala ptsp makanan minuman olahan self declare pendamping pph bahan baku">
                <div class="p-6 sm:p-8 lg:p-10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-black text-xl shadow-xs">
                                🥩
                            </div>
                            <div>
                                <span class="text-[11px] font-extrabold tracking-wider uppercase text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-md">Langkah 2 &bull; Kepercayaan Konsumen</span>
                                <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Panduan Sertifikasi Halal Gratis (Program SEHATI / Self-Declare)</h3>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 self-start sm:self-auto">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            Biaya Ditanggung Pemerintah 100%
                        </span>
                    </div>

                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6">
                        Pemerintah melalui BPJPH Kementerian Agama membuka program <strong>Sertifikasi Halal Gratis (SEHATI)</strong> dengan skema <em>Self-Declare</em> (pernyataan pelaku usaha). Sangat cocok untuk produk olahan makanan & minuman UMKM yang menggunakan bahan-bahan alami dan non-kritis.
                    </p>

                    <!-- Requirements & Steps Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-100 mb-6">
                        <!-- Left: Requirements -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Kriteria Produk & Syarat Pengajuan:
                            </h4>
                            <ul class="space-y-2 text-xs sm:text-sm text-slate-600">
                                <li class="flex items-start gap-2"><span class="text-emerald-500 font-bold">&bull;</span> Wajib memiliki NIB (Nomor Induk Berusaha).</li>
                                <li class="flex items-start gap-2"><span class="text-emerald-500 font-bold">&bull;</span> Produk tidak berisiko (tidak menggunakan bahan berbahaya / daging sembelihan tanpa sertifikat).</li>
                                <li class="flex items-start gap-2"><span class="text-emerald-500 font-bold">&bull;</span> Proses produksi dipastikan bersih dan bebas najis.</li>
                                <li class="flex items-start gap-2"><span class="text-emerald-500 font-bold">&bull;</span> Memiliki 1 orang Penyelia Halal (bisa pemilik sendiri, keluarga, atau karyawan muslim).</li>
                            </ul>
                        </div>

                        <!-- Right: Steps -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                                Alur Pendaftaran SiHalal (ptsp.halal.go.id):
                            </h4>
                            <ol class="space-y-2 text-xs sm:text-sm text-slate-600 list-decimal list-inside">
                                <li>Daftar akun di aplikasi <strong><a href="https://ptsp.halal.go.id" target="_blank" rel="noopener noreferrer" class="text-[#991b1b] underline font-bold">ptsp.halal.go.id</a></strong> sebagai Pelaku Usaha.</li>
                                <li>Pilih jalur permohonan <strong>Self-Declare (SEHATI)</strong>.</li>
                                <li>Masukkan kode Pendamping Proses Produk Halal (PPH) Wonogiri atau pilih pendamping terdekat.</li>
                                <li>Input rincian bahan baku dan foto proses pembuatan produk.</li>
                                <li>Pendamping PPH memverifikasi dan sidang Komite Fatwa menerbitkan Sertifikat Halal resmi!</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Benefits & Actions -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pt-5 border-t border-slate-100">
                        <div class="text-xs text-slate-600 leading-relaxed max-w-xl">
                            <strong class="font-bold text-slate-800">Masa Berlaku:</strong> Sertifikat Halal kini berlaku <strong class="text-slate-800 font-bold">seumur hidup</strong> sepanjang komposisi bahan dan proses produksi tidak mengalami perubahan.
                        </div>
                        <div class="flex items-center gap-2.5 shrink-0 w-full sm:w-auto">
                            <a href="https://ptsp.halal.go.id" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto text-center px-4 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-bold transition-colors">
                                Portal SiHalal Kemenag &nearr;
                            </a>
                            <a href="{{ route('konsultasi') }}?subject=Sertifikasi+Halal+/+PIRT" class="w-full sm:w-auto text-center px-4 py-2.5 rounded-xl bg-[#991b1b] hover:bg-[#801414] text-white text-xs font-bold transition-colors shadow-2xs">
                                Dampingi Pengurusan Halal
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GUIDE 3: STANDAR KEMASAN & LABELING BPOM -->
            <div id="guide-kemasan" class="guide-card bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300"
                 data-keywords="kemasan label standar labeling bpom desain kemasan komposisi berat bersih netto kedaluwarsa kode produksi packaging kemasan menarik kurasi produk">
                <div class="p-6 sm:p-8 lg:p-10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-rose-600 text-white flex items-center justify-center font-black text-xl shadow-xs">
                                📦
                            </div>
                            <div>
                                <span class="text-[11px] font-extrabold tracking-wider uppercase text-rose-700 bg-rose-50 px-2.5 py-0.5 rounded-md">Langkah 3 &bull; Desain & Standar Kemasan</span>
                                <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Standar Label Kemasan Produk Sesuai Regulasi BPOM</h3>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 self-start sm:self-auto">
                            Syarat Kurasi Toko Modern
                        </span>
                    </div>

                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6">
                        Agar produk olahan pangan UMKM dapat diterima di minimarket, toko modern, dan pusat oleh-oleh, label kemasan wajib memuat informasi pokok sesuai ketentuan UU Pangan dan Peraturan BPOM No. 31 Tahun 2018. Label yang informatif dan higienis turut meningkatkan daya saing produk.
                    </p>

                    <!-- Requirements & Checklist Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-100 mb-6">
                        <!-- Left: 7 Elements -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                7 Unsur Wajib pada Label Kemasan:
                            </h4>
                            <ul class="space-y-1.5 text-xs sm:text-sm text-slate-600">
                                <li class="flex items-start gap-2"><span class="text-rose-600 font-bold">1.</span> <strong>Nama Produk</strong> (Jenis pangan dan nama dagang).</li>
                                <li class="flex items-start gap-2"><span class="text-rose-600 font-bold">2.</span> <strong>Daftar Bahan / Komposisi</strong> (Diurutkan dari persentase terbanyak).</li>
                                <li class="flex items-start gap-2"><span class="text-rose-600 font-bold">3.</span> <strong>Berat Bersih (Netto)</strong> (Contoh: Berat Bersih: 250 gram).</li>
                                <li class="flex items-start gap-2"><span class="text-rose-600 font-bold">4.</span> <strong>Nama & Alamat Produsen</strong> (Nama UMKM, Kab. Wonogiri, Kode Pos).</li>
                                <li class="flex items-start gap-2"><span class="text-rose-600 font-bold">5.</span> <strong>Nomor Izin Edar</strong> (P-IRT / BPOM RI MD).</li>
                                <li class="flex items-start gap-2"><span class="text-rose-600 font-bold">6.</span> <strong>Tanggal Kedaluwarsa</strong> (Baik Digunakan Sebelum: DD/MM/YYYY).</li>
                                <li class="flex items-start gap-2"><span class="text-rose-600 font-bold">7.</span> <strong>Kode Produksi</strong> (Untuk penelusuran batch mutu).</li>
                            </ul>
                        </div>

                        <!-- Right: Packaging Tips -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.5a9 9 0 11-7.5 0"/></svg>
                                Tips Kemasan Menarik & Tahan Lama:
                            </h4>
                            <ul class="space-y-2 text-xs sm:text-sm text-slate-600">
                                <li class="flex items-start gap-2"><span class="text-rose-600 font-bold">&bull;</span> Gunakan plastik <em>Food Grade</em> standing pouch aluminium foil untuk produk krispi agar renyah lebih dari 6 bulan.</li>
                                <li class="flex items-start gap-2"><span class="text-rose-600 font-bold">&bull;</span> Beri jendela transparan kecil agar calon pembeli bisa melihat kelezatan produk asli di dalamnya.</li>
                                <li class="flex items-start gap-2"><span class="text-rose-600 font-bold">&bull;</span> Desain logo yang kontras, tidak buram, dan mudah dibaca konsumen lanjut usia.</li>
                                <li class="flex items-start gap-2"><span class="text-rose-600 font-bold">&bull;</span> Sertakan barcode produk dan akun media sosial atau WhatsApp order resmi.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Benefits & Actions -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pt-5 border-t border-slate-100">
                        <div class="text-xs text-slate-600 leading-relaxed max-w-xl">
                            <strong class="font-bold text-slate-800">Fasilitasi:</strong> Pojok UMKM Wonogiri menyediakan layanan konsultasi kelayakan kemasan dan informasi izin edar bagi produk unggulan lokal.
                        </div>
                        <div class="flex items-center gap-2.5 shrink-0 w-full sm:w-auto">
                            <a href="{{ route('katalog') }}" class="w-full sm:w-auto text-center px-4 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-bold transition-colors">
                                Lihat Contoh Produk Katalog &nearr;
                            </a>
                            <a href="{{ route('konsultasi') }}?subject=Pemasaran+%26+Penjualan" class="w-full sm:w-auto text-center px-4 py-2.5 rounded-xl bg-[#991b1b] hover:bg-[#801414] text-white text-xs font-bold transition-colors shadow-2xs">
                                Konsultasi Desain Kemasan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GUIDE 4: IZIN EDAR PIRT (DINKES) -->
            <div id="guide-pirt" class="guide-card bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300"
                 data-keywords="pirt spp-irt sppirt dinas kesehatan izin edar pangan industri rumah tangga pkp penyuluhan keamanan pangan dinkes label kemasan tanggal kedaluwarsa izin makanan keripik roti kopi kue">
                <div class="p-6 sm:p-8 lg:p-10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-black text-xl shadow-xs">
                                🥫
                            </div>
                            <div>
                                <span class="text-[11px] font-extrabold tracking-wider uppercase text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-md">Langkah 4 &bull; Keamanan Konsumsi (Izin Edar)</span>
                                <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Panduan Pengurusan SPP-IRT (Izin Edar PIRT Dinas Kesehatan)</h3>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 self-start sm:self-auto">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            Bebas Retribusi Pemda
                        </span>
                    </div>

                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6">
                        Sertifikat Produksi Pangan Industri Rumah Tangga (SPP-IRT) diterbitkan oleh Dinas Kesehatan sebagai jaminan resmi bahwa produk olahan pangan yang diproduksi telah memenuhi standar higienitas dan keamanan pangan sebelum diedarkan luas ke konsumen.
                    </p>

                    <!-- Requirements & Steps Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-100 mb-6">
                        <!-- Left: Requirements -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Ketentuan Produk yang Boleh PIRT:
                            </h4>
                            <ul class="space-y-2 text-xs sm:text-sm text-slate-600">
                                <li class="flex items-start gap-2"><span class="text-blue-500 font-bold">&bull;</span> Pangan kering dengan kadar air rendah (kue kering, keripik, rengginang, mete, sambal kemasan, abon, dsb).</li>
                                <li class="flex items-start gap-2"><span class="text-blue-500 font-bold">&bull;</span> Daya tahan simpan suhu ruang minimal 7 hari.</li>
                                <li class="flex items-start gap-2"><span class="text-blue-500 font-bold">&bull;</span> <em>Catatan:</em> Produk susu, daging basah, atau frozen food beku berisiko tinggi wajib mendaftar izin edar BPOM MD (bukan PIRT).</li>
                            </ul>
                        </div>

                        <!-- Right: Steps -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                                Alur Penerbitan SPP-IRT Terintegrasi:
                            </h4>
                            <ol class="space-y-2 text-xs sm:text-sm text-slate-600 list-decimal list-inside">
                                <li>Masuk ke akun OSS Anda, ajukan perizinan berusaha UMK olahan pangan.</li>
                                <li>Sistem OSS otomatis mengarahkan ke aplikasi <strong>sppirt.pom.go.id</strong>.</li>
                                <li>Unggah rancangan label kemasan produk sesuai standar BPOM.</li>
                                <li>Nomor 15 digit SPP-IRT diterbitkan secara otomatis secara online.</li>
                                <li>Mengikuti Penyuluhan Keamanan Pangan (PKP) dan inspeksi fasilitas dapur oleh Dinas Kesehatan Wonogiri.</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Benefits & Actions -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pt-5 border-t border-slate-100">
                        <div class="text-xs text-slate-600 leading-relaxed max-w-xl">
                            <strong class="font-bold text-slate-800">Dukungan:</strong> Dinas Kesehatan dan Disperindagkop UKM Wonogiri menyelenggarakan Penyuluhan Keamanan Pangan (PKP) secara berkala bagi pelaku usaha.
                        </div>
                        <div class="flex items-center gap-2.5 shrink-0 w-full sm:w-auto">
                            <a href="https://sppirt.pom.go.id" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto text-center px-4 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-bold transition-colors">
                                Portal SPPIRT BPOM &nearr;
                            </a>
                            <a href="{{ route('konsultasi') }}?subject=Sertifikasi+Halal+/+PIRT" class="w-full sm:w-auto text-center px-4 py-2.5 rounded-xl bg-[#991b1b] hover:bg-[#801414] text-white text-xs font-bold transition-colors shadow-2xs">
                                Konsultasi SPP-IRT Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GUIDE 5: HAK MEREK DAGANG (HAKI - DJKI) -->
            <div id="guide-merek" class="guide-card bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300"
                 data-keywords="merek dagang haki hak kekayaan intelektual djki kemenkumham paten logo nama brand perlindungan hukum subsidi dinas">
                <div class="p-6 sm:p-8 lg:p-10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-purple-600 text-white flex items-center justify-center font-black text-xl shadow-xs">
                                🏷️
                            </div>
                            <div>
                                <span class="text-[11px] font-extrabold tracking-wider uppercase text-purple-700 bg-purple-50 px-2.5 py-0.5 rounded-md">Langkah 5 &bull; Perlindungan Hak Merek</span>
                                <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Panduan Pendaftaran Hak Merek Dagang (DJKI Kemenkumham)</h3>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800 self-start sm:self-auto">
                            Tarif Khusus UMKM Binaan
                        </span>
                    </div>

                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6">
                        Merek dagang memberikan hak eksklusif atas nama brand dan logo produk Anda di seluruh wilayah Indonesia selama <strong>10 tahun</strong> dan dapat diperpanjang. Mendaftarkan merek sejak dini penting untuk mencegah pihak lain menggunakan atau meniru identitas usaha yang telah Anda bangun.
                    </p>

                    <!-- Requirements & Steps Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/70 p-5 sm:p-6 rounded-2xl border border-slate-100 mb-6">
                        <!-- Left: Requirements -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Syarat Mendapatkan Tarif Subsidi UMKM:
                            </h4>
                            <ul class="space-y-2 text-xs sm:text-sm text-slate-600">
                                <li class="flex items-start gap-2"><span class="text-purple-500 font-bold">&bull;</span> Surat Rekomendasi UMKM Binaan dari Dinas KUKM Kabupaten Wonogiri.</li>
                                <li class="flex items-start gap-2"><span class="text-purple-500 font-bold">&bull;</span> NIB dan KTP Pemohon.</li>
                                <li class="flex items-start gap-2"><span class="text-purple-500 font-bold">&bull;</span> Gambar/Logo Merek dalam format JPG resolusi tinggi.</li>
                                <li class="flex items-start gap-2"><span class="text-purple-500 font-bold">&bull;</span> Tanda tangan digital pemohon di atas kertas putih.</li>
                            </ul>
                        </div>

                        <!-- Right: Steps -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                                Keuntungan Tarif Subsidi Disperindagkop:
                            </h4>
                            <div class="space-y-3 text-xs sm:text-sm text-slate-600">
                                <p>Biaya pendaftaran merek umum non-UMKM adalah <strong>Rp 1.800.000</strong> per kelas.</p>
                                <p class="bg-purple-100 text-purple-900 p-3 rounded-xl font-medium">
                                    Dengan surat binaan Dinas KUKM Wonogiri, tarif pendaftaran menjadi hanya <strong>Rp 500.000</strong> per kelas barang/jasa!
                                </p>
                                <p>Pengecekan kesamaan nama merek dapat dilakukan secara gratis melalui situs <strong><a href="https://pdki-indonesia.dgip.go.id" target="_blank" rel="noopener noreferrer" class="text-[#991b1b] underline font-bold">pdki-indonesia.dgip.go.id</a></strong>.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Benefits & Actions -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pt-5 border-t border-slate-100">
                        <div class="text-xs text-slate-600 leading-relaxed max-w-xl">
                            <strong class="font-bold text-slate-800">Perlindungan:</strong> Memberikan perlindungan hukum yang berkekuatan tetap apabila terjadi sengketa atau peniruan nama merek dagang.
                        </div>
                        <div class="flex items-center gap-2.5 shrink-0 w-full sm:w-auto">
                            <a href="https://merek.dgip.go.id" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto text-center px-4 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-bold transition-colors">
                                Portal DJKI Kemenkumham &nearr;
                            </a>
                            <a href="{{ route('konsultasi') }}?subject=Perizinan+Usaha" class="w-full sm:w-auto text-center px-4 py-2.5 rounded-xl bg-[#991b1b] hover:bg-[#801414] text-white text-xs font-bold transition-colors shadow-2xs">
                                Ajukan Surat Rekomendasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- FAQ Section for Beginners -->
        <div class="mt-14 bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/90 shadow-sm">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-wider text-[#991b1b] bg-red-50 px-3 py-1 rounded-full">Tanya Jawab Populer</span>
                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">Pertanyaan yang Sering Diajukan (FAQ)</h3>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Informasi praktis seputar pengurusan legalitas usaha bagi pelaku UMKM di Kabupaten Wonogiri.</p>
            </div>

            <div class="space-y-4 max-w-4xl mx-auto">
                
                <!-- FAQ 1 -->
                <div class="border border-slate-200 rounded-2xl p-5 hover:border-red-200 transition-colors">
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 mb-2 flex items-center justify-between">
                        <span>Apakah pengurusan NIB, PIRT, dan Sertifikasi Halal ini dipungut biaya?</span>
                        <span class="text-[#991b1b] font-bold text-xl">&plus;</span>
                    </h4>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        <strong>Tidak dipungut biaya (gratis).</strong> Pendaftaran NIB melalui sistem OSS bebas biaya, penerbitan SPP-IRT di Dinas Kesehatan Kabupaten Wonogiri tidak dikenakan retribusi daerah, dan sertifikasi halal program SEHATI dibiayai oleh pemerintah. Pelaku usaha diimbau untuk tidak menggunakan jasa perantara atau calo yang meminta imbalan.
                    </p>
                </div>

                <!-- FAQ 2 -->
                <div class="border border-slate-200 rounded-2xl p-5 hover:border-red-200 transition-colors">
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 mb-2 flex items-center justify-between">
                        <span>Apakah usaha berskala mikro dan rumahan wajib memiliki NIB?</span>
                        <span class="text-[#991b1b] font-bold text-xl">&plus;</span>
                    </h4>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Sangat disarankan. NIB merupakan identitas legalitas dasar untuk seluruh skala usaha, termasuk usaha mikro dan industri rumahan. Memiliki NIB memberikan kepastian hukum dan menjadi syarat utama untuk mengikuti berbagai program pembinaan, pameran daerah, serta fasilitas pembiayaan seperti KUR.
                    </p>
                </div>

                <!-- FAQ 3 -->
                <div class="border border-slate-200 rounded-2xl p-5 hover:border-red-200 transition-colors">
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 mb-2 flex items-center justify-between">
                        <span>Bagaimana jika pelaku usaha mengalami kendala saat melakukan pendaftaran daring?</span>
                        <span class="text-[#991b1b] font-bold text-xl">&plus;</span>
                    </h4>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Anda tidak perlu khawatir. Tim pendamping Pojok UMKM dan Dinas Perdagangan & KUKM Wonogiri menyediakan fasilitas <strong>Pendampingan Langsung</strong>. Anda cukup membawa KTP dan foto produk ke kantor dinas atau mengajukan bantuan melalui halaman <a href="{{ route('konsultasi') }}" class="text-[#991b1b] underline font-bold">Konsultasi Pojok UMKM</a>.
                    </p>
                </div>

                <!-- FAQ 4 -->
                <div class="border border-slate-200 rounded-2xl p-5 hover:border-red-200 transition-colors">
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 mb-2 flex items-center justify-between">
                        <span>Berapa lama estimasi waktu penerbitan dokumen perizinan?</span>
                        <span class="text-[#991b1b] font-bold text-xl">&plus;</span>
                    </h4>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        NIB dapat terbit langsung pada hari yang sama setelah seluruh formulir selesai diisi. SPP-IRT umumnya memerlukan waktu 1 hingga 3 hari kerja. Sementara Sertifikasi Halal jalur Self-Declare memerlukan waktu sekitar 14 hingga 25 hari kerja setelah proses verifikasi oleh Pendamping PPH dan penetapan fatwa resmi.
                    </p>
                </div>

            </div>
        </div>

        <!-- Bottom Assistance Callout -->
        <div class="mt-12 bg-gradient-to-r from-[#800000] to-[#a31d1d] rounded-3xl p-8 sm:p-12 text-white text-center sm:text-left flex flex-col sm:flex-row items-center justify-between gap-6 shadow-xl relative overflow-hidden">
            <div class="relative z-10 max-w-2xl">
                <span class="inline-block bg-white/20 px-3 py-1 rounded-full text-xs font-bold uppercase mb-3 text-red-100">Bantuan Langsung Dinas</span>
                <h3 class="text-2xl sm:text-3xl font-black mb-2">Memerlukan Bimbingan atau Informasi Tambahan?</h3>
                <p class="text-red-100 text-xs sm:text-sm leading-relaxed">
                    Petugas Pojok UMKM Wonogiri siap mendampingi Anda dalam memahami tahapan pengurusan izin usaha hingga dokumen legalitas resmi diterbitkan.
                </p>
            </div>
            <div class="relative z-10 flex flex-col sm:flex-row gap-3 shrink-0 w-full sm:w-auto">
                <a href="{{ route('konsultasi') }}" class="px-6 py-3.5 rounded-xl bg-white text-[#800000] font-black text-sm hover:bg-red-50 transition-all shadow-md text-center">
                    Ajukan Konsultasi Sekarang &rarr;
                </a>
            </div>
        </div>

    </div>
</div>

<!-- Interactive Category Filter Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cards = document.querySelectorAll(".guide-card");
        const countSpan = document.getElementById("count-number");
        const noResultNotice = document.getElementById("no-result-notice");
        const chips = document.querySelectorAll(".filter-chip");

        function filterGuides(query) {
            const cleanQuery = (query || "").toLowerCase().trim();
            let visibleCount = 0;

            cards.forEach(card => {
                const keywords = card.getAttribute("data-keywords") ? card.getAttribute("data-keywords").toLowerCase() : "";
                const cardId = card.id ? card.id.toLowerCase() : "";

                if (cleanQuery === "" || keywords.includes(cleanQuery) || cardId.includes(cleanQuery)) {
                    card.style.display = "block";
                    visibleCount++;
                } else {
                    card.style.display = "none";
                }
            });

            if (countSpan) {
                countSpan.textContent = visibleCount;
            }

            if (noResultNotice) {
                if (visibleCount === 0) {
                    noResultNotice.classList.remove("hidden");
                } else {
                    noResultNotice.classList.add("hidden");
                }
            }
        }

        window.filterByKeyword = function (keyword) {
            const cleanKey = (keyword || "").toLowerCase().trim();

            chips.forEach(c => {
                c.classList.remove("active", "bg-white", "text-[#800000]", "shadow-md");
                c.classList.add("bg-white/15", "text-white", "border", "border-white/25");
            });

            const activeBtn = Array.from(chips).find(c => {
                const onclickAttr = c.getAttribute("onclick") || "";
                return onclickAttr.includes(`'${cleanKey}'`);
            });

            if (activeBtn) {
                activeBtn.classList.add("active", "bg-white", "text-[#800000]", "shadow-md");
                activeBtn.classList.remove("bg-white/15", "text-white", "border", "border-white/25");
            }

            filterGuides(cleanKey);

            // Jika memilih modul spesifik, scroll ke area modul
            if (cleanKey !== "") {
                const container = document.getElementById("guides-container");
                if (container) {
                    const topPos = container.getBoundingClientRect().top + window.pageYOffset - 90;
                    window.scrollTo({ top: topPos, behavior: 'smooth' });
                }
            }
        };

        window.scrollToGuide = function (elementId) {
            const target = document.getElementById(elementId);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                target.classList.add('ring-4', 'ring-[#991b1b]', 'ring-offset-4');
                setTimeout(() => {
                    target.classList.remove('ring-4', 'ring-[#991b1b]', 'ring-offset-4');
                }, 2000);
            }
        };
    });
</script>
@endsection
