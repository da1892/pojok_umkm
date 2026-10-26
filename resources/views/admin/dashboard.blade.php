@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Total UMKM Terdaftar</p>
                    <h3 class="text-3xl font-bold text-slate-800 tracking-tight">{{ $totalUmkm }}</h3>
                </div>
                <div class="p-2.5 bg-red-50 text-[#800000] rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <p class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +24 UMKM baru minggu ini
            </p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Produk Terpublikasi</p>
                    <h3 class="text-3xl font-bold text-slate-800 tracking-tight">{{ $totalProducts }}</h3>
                </div>
                <div class="p-2.5 bg-red-50 text-[#800000] rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
            <p class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +56 produk baru terkurasi
            </p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Konsultasi Baru</p>
                    <h3 class="text-3xl font-bold text-slate-800 tracking-tight">24</h3>
                </div>
                <div class="p-2.5 bg-red-50 text-[#800000] rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
            </div>
            <p class="text-xs font-semibold text-amber-500">Perlu penanganan segera</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Konsultasi Selesai</p>
                    <h3 class="text-3xl font-bold text-slate-800 tracking-tight">890</h3>
                </div>
                <div class="p-2.5 bg-red-50 text-[#800000] rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-xs font-semibold text-emerald-600">Tingkat penyelesaian 94%</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Bar Chart -->
        <div class="bg-white rounded-xl p-6 lg:p-7 border border-slate-200/60 shadow-sm lg:col-span-2">
            <h3 class="text-[15px] font-bold text-slate-800 mb-6">Konsultasi Masuk per Bulan</h3>
            <div class="w-full h-[250px] relative">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- Donut Chart -->
        <div class="bg-white rounded-xl p-6 lg:p-7 border border-slate-200/60 shadow-sm">
            <h3 class="text-[15px] font-bold text-slate-800 mb-6">Kategori Produk</h3>
            <div class="w-full h-[250px] relative flex justify-center items-center">
                <canvas id="donutChart"></canvas>
            </div>
        </div>
    </div>

    @php
        $catLabels = isset($categoryStats) ? $categoryStats->pluck('category')->toArray() : ['Mamin', 'Kriya', 'Batik'];
        $catCounts = isset($categoryStats) ? $categoryStats->pluck('count')->map(fn($v) => (int)$v)->toArray() : [55, 25, 20];
        if (empty($catLabels)) {
            $catLabels = ['Mamin', 'Kriya', 'Batik'];
            $catCounts = [55, 25, 20];
        }

        $allKecamatanList = !empty($wilayahWonogiri) ? array_keys($wilayahWonogiri) : [
            'Baturetno', 'Batuwarno', 'Bulukerto', 'Eromoko', 'Girimarto', 'Giritontro', 'Giriwoyo',
            'Jatipurno', 'Jatiroto', 'Jatisrono', 'Karangtengah', 'Kismantoro', 'Manyaran',
            'Ngadirojo', 'Nguntoronadi', 'Paranggupito', 'Pracimantoro', 'Puhpelem', 'Purwantoro',
            'Selogiri', 'Sidoharjo', 'Slogohimo', 'Tirtomoyo', 'Wonogiri', 'Wuryantoro'
        ];
        sort($allKecamatanList);

        $districtsWithCounts = $districtStats ?? collect();
        $districtsStatsData = $districtsWithCounts->map(function($d) {
            return [
                'district' => $d->district,
                'total_products' => (int)$d->total_products,
                'total_umkms' => (int)$d->total_umkms
            ];
        })->values();

        $defaultCategories = [
            'Makanan & Minuman',
            'Batik/Fashion',
            'Kerajinan',
            'Olahan Hasil Pertanian',
            'Produk Kreatif',
        ];
        $allCategoriesList = $allCategoriesList ?? $defaultCategories;
    @endphp

    <!-- Section: Pencarian & Pengecekan Produk per Daerah (Searchable Dropdown) -->
    <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm p-6 lg:p-7 space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-red-50 text-[#800000] rounded-xl shadow-2xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-base font-bold text-slate-800">Produk Daerah</h3>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-[#800000] border border-red-200">Kab. Wonogiri</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">Ketik kata kunci desa/kecamatan atau pilih dari dropdown untuk mengetahui jumlah dan katalog produk di daerah tersebut</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.products') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 hover:bg-[#800000] hover:text-white transition-colors border border-slate-200">
                    Katalog Lengkap
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <style>
            #dropdownOptionsList::-webkit-scrollbar {
                width: 6px;
            }
            #dropdownOptionsList::-webkit-scrollbar-track {
                background: #f8fafc;
            }
            #dropdownOptionsList::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 9999px;
            }
            #dropdownOptionsList::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
        </style>

        <!-- Controls: Dropdown Pilih Wilayah (Kecamatan & Desa dari Master) -->
        <div class="space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Dropdown 1: Pilih Kecamatan (25 Kecamatan dari master_kecamatan.xlsx) -->
                <div class="relative" id="districtDropdownContainer">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span>Pilih Kecamatan (25 Kecamatan):</span>
                    </label>
                    <div class="relative">
                        <button type="button" id="districtDropdownBtn" class="w-full flex items-center justify-between px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-800 shadow-2xs hover:border-[#800000] focus:border-[#800000] focus:ring-1 focus:ring-[#800000] transition-all">
                            <div class="flex items-center gap-2.5 truncate">
                                <span class="p-1 rounded-lg bg-red-50 text-[#800000] shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                </span>
                                <span id="selectedDistrictLabel" class="truncate font-bold">Semua Kecamatan (Wonogiri)</span>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <span id="selectedDistrictBadge" class="px-2 py-0.5 rounded-full text-[11px] font-extrabold bg-red-100 text-[#800000]">25 Kec</span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </button>

                        <!-- Popover Dropdown Kecamatan -->
                        <div id="districtDropdownMenu" class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white rounded-xl shadow-2xl border border-slate-200 z-50 overflow-hidden" style="max-height: 380px; width: 100%;">
                            <div class="p-2.5 bg-slate-50 border-b border-slate-100 sticky top-0 z-10 shrink-0">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>
                                    <input type="text" id="insideDropdownSearch" autocomplete="off" placeholder="Cari nama kecamatan..." class="w-full pl-8 pr-3 py-1.5 text-xs rounded-lg border border-slate-200 focus:border-[#800000] focus:ring-1 focus:ring-[#800000] bg-white">
                                </div>
                            </div>
                                </div>
                            </div>
                            <div id="dropdownOptionsList" class="divide-y divide-slate-100" style="max-height: 280px; overflow-y: auto; overflow-x: hidden; scroll-behavior: smooth;">
                                <div data-district="" data-name="Semua Kecamatan Wonogiri seluruh kabupaten" class="dropdown-item p-2.5 text-xs text-slate-800 hover:bg-red-50 hover:text-[#800000] cursor-pointer font-bold transition-colors flex items-center justify-between bg-red-50/40">
                                    <div class="flex items-center gap-2">
                                        <span class="text-amber-500">★</span>
                                        <span>Semua Kecamatan (Wonogiri)</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-[#800000]">25 Kecamatan</span>
                                </div>
                                @foreach($allKecamatanList as $kec)
                                    @php
                                        $dStat = $districtsWithCounts->firstWhere('district', $kec);
                                        $pCount = $dStat ? $dStat->total_products : 0;
                                        $uCount = $dStat ? $dStat->total_umkms : 0;
                                        $desasInKec = isset($wilayahWonogiri[$kec]) && is_array($wilayahWonogiri[$kec]) ? $wilayahWonogiri[$kec] : [];
                                        $desaCount = count($desasInKec);
                                    @endphp
                                    <div data-district="{{ $kec }}" data-name="Kecamatan {{ $kec }}" class="dropdown-item p-2.5 text-xs text-slate-700 hover:bg-red-50 hover:text-[#800000] cursor-pointer font-medium transition-colors flex items-center justify-between">
                                        <div class="pr-2">
                                            <span class="font-semibold block text-slate-800">Kecamatan {{ $kec }}</span>
                                            <span class="text-[10px] text-slate-400 block mt-0.5">{{ $desaCount }} Desa / Kelurahan</span>
                                            @if($uCount > 0)
                                            <span class="text-[10px] text-emerald-600 font-bold block mt-0.5">{{ $uCount }} UMKM &bull; {{ $pCount }} Produk</span>
                                            @endif
                                        </div>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold shrink-0 {{ $pCount > 0 ? 'bg-red-100 text-[#800000]' : 'bg-slate-100 text-slate-400' }}">
                                            {{ $pCount }} Produk
                                        </span>
                                    </div>
                                @endforeach
                                <div id="dropdownNoResults" class="hidden p-4 text-center text-xs text-slate-400">
                                    Tidak ada kecamatan yang cocok.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dropdown 2: Pilih Desa / Kelurahan (294 Desa dari master_desa.xlsx) -->
                <div class="relative" id="villageDropdownContainer">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span id="villageLabelTitle">Pilih Desa / Kelurahan (294 Desa):</span>
                    </label>
                    <div class="relative">
                        <button type="button" id="villageDropdownBtn" class="w-full flex items-center justify-between px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-800 shadow-2xs hover:border-[#800000] focus:border-[#800000] focus:ring-1 focus:ring-[#800000] transition-all">
                            <div class="flex items-center gap-2.5 truncate">
                                <span class="p-1 rounded-lg bg-red-50 text-[#800000] shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                </span>
                                <span id="selectedVillageLabel" class="truncate font-bold">Semua Desa / Kelurahan</span>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <span id="selectedVillageBadge" class="px-2 py-0.5 rounded-full text-[11px] font-extrabold bg-slate-100 text-slate-600">Semua</span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </button>

                        <!-- Popover Dropdown Desa -->
                        <div id="villageDropdownMenu" class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white rounded-xl shadow-2xl border border-slate-200 z-50 overflow-hidden" style="max-height: 380px; width: 100%;">
                            <div class="p-2.5 bg-slate-50 border-b border-slate-100 sticky top-0 z-10 shrink-0">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>
                                    <input type="text" id="insideVillageSearch" autocomplete="off" placeholder="Ketik nama desa atau kelurahan..." class="w-full pl-8 pr-3 py-1.5 text-xs rounded-lg border border-slate-200 focus:border-[#800000] focus:ring-1 focus:ring-[#800000] bg-white">
                                </div>
                            </div>
                            <div id="villageOptionsList" class="divide-y divide-slate-100" style="max-height: 280px; overflow-y: auto; overflow-x: hidden; scroll-behavior: smooth;">
                                <!-- Diisi dinamis via JavaScript dari master desa -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notice Filter Wilayah Aktif -->
            <div id="activeFilterNotice" class="hidden flex items-center justify-between p-2.5 rounded-xl bg-amber-50 border border-amber-200 text-xs">
                <div class="flex items-center gap-2 text-amber-800">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span id="activeFilterDesc" class="font-semibold">Filter wilayah aktif.</span>
                </div>
                <button type="button" onclick="resetRegionFilter()" class="px-2.5 py-1 rounded-lg text-xs font-bold bg-white text-slate-700 hover:text-[#800000] hover:bg-red-50 border border-slate-300 transition-colors shadow-2xs">
                    ↺ Tampilkan Semua Wilayah
                </button>
            </div>
        </div>

        <!-- Result Summary Banner -->
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-[#800000] flex items-center justify-center font-bold shrink-0 border border-red-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h4 id="activeRegionTitle" class="text-sm font-bold text-slate-800">Semua Wilayah Wonogiri</h4>
                        <span id="activeRegionBadge" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Seluruh Kabupaten
                        </span>
                    </div>
                    <p id="activeRegionSubtitle" class="text-xs text-slate-500 mt-0.5">Menampilkan seluruh produk terverifikasi dari UMKM di Kabupaten Wonogiri</p>
                </div>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <div class="text-right">
                    <span id="activeProductCountBadge" class="text-lg font-black text-[#800000]">{{ $totalProducts }}</span>
                    <span class="text-xs text-slate-500 font-medium block -mt-1">Produk Aktif</span>
                </div>
                <div class="h-8 w-px bg-slate-200"></div>
                <div class="text-right">
                    <span id="activeUmkmCountBadge" class="text-lg font-bold text-slate-700">{{ $totalUmkm }}</span>
                    <span class="text-xs text-slate-500 font-medium block -mt-1">UMKM Terdaftar</span>
                </div>
                <a id="activeManageLink" href="{{ route('admin.products') }}" class="ml-2 inline-flex items-center gap-1 px-3 py-2 rounded-xl text-xs font-bold text-white bg-[#800000] hover:bg-[#600000] transition-colors shadow-2xs">
                    Kelola Produk
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- Grafik Kategori Produk Daerah (Berdasarkan Wilayah Terpilih) -->
        <div class="bg-white rounded-xl border border-slate-200/80 p-5 shadow-2xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#800000]"></span>
                        <h4 id="regionChartTitle" class="text-sm font-bold text-slate-800">
                            Grafik Sebaran Kategori Produk UMKM
                        </h4>
                    </div>
                    <p id="regionChartSubtitle" class="text-xs text-slate-500 mt-0.5">
                        Distribusi produk terverifikasi per kategori di seluruh wilayah Kabupaten Wonogiri
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" id="chartResetBtn" onclick="resetRegionFilter()" class="hidden px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors border border-slate-200">
                        ↺ Tampilkan Semua Wilayah
                    </button>
                </div>
            </div>

            <!-- Canvas Grafik -->
            <div id="regionChartWrapper" class="w-full h-[300px] relative">
                <canvas id="regionDistributionChart"></canvas>
            </div>

            <!-- Empty State bila daerah belum ada produk -->
            <div id="regionChartEmptyState" class="hidden p-8 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200 mt-2">
                <div class="w-12 h-12 rounded-2xl bg-white text-slate-400 mx-auto flex items-center justify-center mb-3 shadow-2xs border border-slate-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <h5 id="chartEmptyTitle" class="text-sm font-bold text-slate-700">Belum Ada Produk di Wilayah Ini</h5>
                <p id="chartEmptyDesc" class="text-xs text-slate-400 max-w-md mx-auto mt-1">Belum ada produk aktif yang diverifikasi pada daerah ini.</p>
                <button type="button" onclick="resetRegionFilter()" class="mt-4 px-3.5 py-1.5 rounded-lg text-xs font-bold bg-white text-slate-700 border border-slate-300 hover:border-[#800000] hover:text-[#800000] transition-colors shadow-2xs">
                    Tampilkan Semua Wilayah
                </button>
            </div>

            <!-- Ringkasan Statistik 4 Kolom di Bawah Grafik -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 mt-4 border-t border-slate-100">
                <div class="p-3 rounded-lg bg-slate-50/70 border border-slate-100">
                    <span id="statCategoryTopLabel" class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Kategori Terbanyak</span>
                    <span id="statCategoryTopValue" class="text-xs font-bold text-slate-800 block mt-0.5 truncate">Makanan & Minuman</span>
                    <span id="statCategoryTopDesc" class="text-[10px] text-[#800000] font-semibold">8 Produk</span>
                </div>
                <div class="p-3 rounded-lg bg-slate-50/70 border border-slate-100">
                    <span id="statCategoryActiveLabel" class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Kategori Aktif</span>
                    <span id="statCategoryActiveValue" class="text-xs font-bold text-slate-800 block mt-0.5">5 dari 5 Kategori</span>
                    <span id="statCategoryActiveDesc" class="text-[10px] text-emerald-600 font-semibold">Memiliki produk aktif</span>
                </div>
                <div class="p-3 rounded-lg bg-slate-50/70 border border-slate-100">
                    <span id="statProductTotalLabel" class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Produk</span>
                    <span id="statProductTotalValue" class="text-xs font-bold text-slate-800 block mt-0.5">{{ $totalProducts }} Produk</span>
                    <span id="statProductTotalDesc" class="text-[10px] text-slate-500 font-semibold">Terverifikasi aktif</span>
                </div>
                <div class="p-3 rounded-lg bg-slate-50/70 border border-slate-100">
                    <span id="statRegionScopeLabel" class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Wilayah Pantauan</span>
                    <span id="statRegionScopeValue" class="text-xs font-bold text-slate-800 block mt-0.5">Semua Wilayah</span>
                    <span id="statRegionScopeDesc" class="text-[10px] text-indigo-600 font-semibold">Kabupaten Wonogiri</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Table 1: Verifikasi Profil UMKM Baru -->
        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Verifikasi Profil UMKM Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar UMKM baru yang menunggu persetujuan admin.</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                    {{ $pendingUmkms->count() }} Menunggu
                </span>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50/80">
                            <th class="px-5 py-3.5">Nama UMKM</th>
                            <th class="px-5 py-3.5">Pemilik</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pendingUmkms as $umkm)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-3.5 font-bold text-[#800000]">
                                {{ $umkm->business_name }}
                                <div class="text-[11px] font-normal text-slate-500">
                                    Kec. {{ $umkm->district ?? '-' }} @if($umkm->village) &bull; Ds. {{ $umkm->village }} @endif
                                </div>
                            </td>
                            <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $umkm->owner_name }}</td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-[11px] font-semibold bg-amber-50 text-amber-600 border border-amber-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Menunggu
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" onclick="openDashModal('dash-umkm-modal-{{ $umkm->id }}')" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-semibold rounded-md transition-colors shadow-sm" title="Lihat detail lengkap UMKM">
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Detail
                                    </button>
                                    <form action="{{ route('admin.umkm.verify', $umkm->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 hover:text-emerald-700 rounded-md transition-colors" title="Setujui Langsung">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.umkm.reject', $umkm->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak pengajuan UMKM ini?');">
                                        @csrf
                                        <button type="submit" class="p-1.5 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-md transition-colors" title="Tolak Langsung">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-slate-500 text-xs">Tidak ada pengajuan UMKM baru</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Table 2: Verifikasi Produk Baru -->
        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Verifikasi Produk Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar produk baru yang menunggu validasi admin.</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                    {{ $pendingProducts->count() }} Menunggu
                </span>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50/80">
                            <th class="px-5 py-3.5">Nama Produk</th>
                            <th class="px-5 py-3.5">UMKM</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pendingProducts as $product)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg border border-slate-200 bg-slate-100 overflow-hidden shrink-0">
                                        @if($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-[10px]">Foto</div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 leading-tight">{{ $product->name }}</p>
                                        <p class="text-[11px] text-slate-500">{{ $product->category }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 font-medium">{{ $product->umkmProfile->business_name ?? 'Tidak diketahui' }}</td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" onclick="openDashModal('dash-product-modal-{{ $product->id }}')" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-semibold rounded-md transition-colors shadow-sm" title="Lihat foto & rincian produk">
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Detail
                                    </button>
                                    <form action="{{ route('admin.product.verify', $product->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 hover:text-emerald-700 rounded-md transition-colors" title="Setujui Langsung">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.product.reject', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak produk ini?');">
                                        @csrf
                                        <button type="submit" class="p-1.5 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-md transition-colors" title="Tolak Langsung">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-5 py-8 text-center text-slate-500 text-xs">Tidak ada produk baru</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL DETAIL VERIFIKASI PROFIL UMKM (DASHBOARD) -->
<!-- ============================================== -->
@foreach($pendingUmkms as $umkm)
<div id="dash-umkm-modal-{{ $umkm->id }}" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-200">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-2xl overflow-hidden transform scale-95 transition-transform duration-200 text-left" onclick="event.stopPropagation()">
        <!-- Header Modal -->
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/80 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-[#800000] flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 leading-tight">{{ $umkm->business_name }}</h3>
                    <p class="text-xs text-slate-500">Pemilik: <span class="font-semibold text-slate-700">{{ $umkm->owner_name }}</span></p>
                </div>
            </div>
            <button type="button" onclick="closeDashModal('dash-umkm-modal-{{ $umkm->id }}')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Body Modal -->
        <div class="p-6 max-h-[70vh] overflow-y-auto space-y-5 text-sm">
            <div class="flex items-center justify-between p-3 rounded-xl bg-amber-50 border border-amber-200/60 text-amber-800">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                    <span class="font-semibold text-xs uppercase tracking-wide">Status: Menunggu Persetujuan Admin</span>
                </div>
                <span class="text-xs text-slate-500">{{ $umkm->created_at ? $umkm->created_at->format('d M Y, H:i') : '-' }}</span>
            </div>

            <!-- Kontak & Lokasi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor WhatsApp</p>
                    <p class="font-semibold text-slate-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        {{ $umkm->phone ?? '-' }}
                    </p>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kecamatan & Desa</p>
                    <p class="font-semibold text-slate-800">
                        Kec. {{ $umkm->district ?? '-' }}
                        @if($umkm->village)
                            <span class="block text-xs font-normal text-slate-600">Desa/Kel. {{ $umkm->village }}</span>
                        @endif
                    </p>
                </div>
                <div class="sm:col-span-2 p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Lengkap</p>
                    <p class="font-bold text-slate-800 text-sm mb-1.5">{{ $umkm->full_address }}</p>
                    <div class="text-xs text-slate-600 flex flex-wrap gap-x-2 gap-y-1 bg-white p-2 rounded-lg border border-slate-200">
                        <span><strong class="text-slate-400">Provinsi:</strong> {{ $umkm->province ?? 'Jawa Tengah' }}</span>
                        <span class="text-slate-300">|</span>
                        <span><strong class="text-slate-400">Kabupaten:</strong> {{ $umkm->regency ?? 'Kabupaten Wonogiri' }}</span>
                        <span class="text-slate-300">|</span>
                        <span><strong class="text-slate-400">Kecamatan:</strong> Kec. {{ $umkm->district ?? '-' }}</span>
                        <span class="text-slate-300">|</span>
                        <span><strong class="text-slate-400">Desa:</strong> Desa {{ $umkm->village ?? '-' }}</span>
                        @if($umkm->postal_code)
                            <span class="text-slate-300">|</span>
                            <span><strong class="text-slate-400">Kode Pos:</strong> {{ $umkm->postal_code }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Deskripsi Usaha -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Deskripsi Singkat Usaha</p>
                <p class="text-slate-700 leading-relaxed">{{ $umkm->description ?: ($umkm->business_description ?: 'Tidak ada deskripsi singkat usaha.') }}</p>
            </div>

            <!-- Legalitas -->
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Legalitas & Sertifikasi</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="p-3 rounded-lg border border-slate-200 bg-white">
                        <span class="text-[10px] font-semibold text-slate-400 block">NIB</span>
                        <span class="font-bold text-slate-800 text-xs">{{ $umkm->nib ?: 'Tidak dilampirkan' }}</span>
                    </div>
                    <div class="p-3 rounded-lg border border-slate-200 bg-white">
                        <span class="text-[10px] font-semibold text-slate-400 block">PIRT</span>
                        <span class="font-bold text-slate-800 text-xs">{{ $umkm->pirt ?: 'Tidak dilampirkan' }}</span>
                    </div>
                    <div class="p-3 rounded-lg border border-slate-200 bg-white">
                        <span class="text-[10px] font-semibold text-slate-400 block">Sertifikasi Halal</span>
                        <span class="font-bold text-slate-800 text-xs">{{ $umkm->halal_cert ?: 'Tidak dilampirkan' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Modal with Actions -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/80 flex items-center justify-between gap-3">
            <button type="button" onclick="closeDashModal('dash-umkm-modal-{{ $umkm->id }}')" class="px-4 py-2 text-xs font-semibold rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-100 transition-colors shadow-sm">
                Tutup
            </button>
            <div class="flex items-center gap-2">
                <form action="{{ route('admin.umkm.reject', $umkm->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak pengajuan UMKM ini?');">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-bold rounded-lg bg-white border border-red-300 text-red-600 hover:bg-red-50 transition-colors shadow-sm">
                        Tolak Pengajuan
                    </button>
                </form>
                <form action="{{ route('admin.umkm.verify', $umkm->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-bold rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white transition-colors shadow-sm flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Setujui & Verifikasi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- ============================================== -->
<!-- MODAL DETAIL VERIFIKASI PRODUK (DASHBOARD) -->
<!-- ============================================== -->
@foreach($pendingProducts as $product)
<div id="dash-product-modal-{{ $product->id }}" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-200">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-2xl overflow-hidden transform scale-95 transition-transform duration-200 text-left" onclick="event.stopPropagation()">
        <!-- Header Modal -->
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/80 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 leading-tight">{{ $product->name }}</h3>
                    <p class="text-xs text-slate-500">Kategori: <span class="font-semibold text-slate-700">{{ $product->category }}</span></p>
                </div>
            </div>
            <button type="button" onclick="closeDashModal('dash-product-modal-{{ $product->id }}')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Body Modal -->
        <div class="p-6 max-h-[70vh] overflow-y-auto space-y-5 text-sm">
            <div class="flex items-center justify-between p-3 rounded-xl bg-amber-50 border border-amber-200/60 text-amber-800">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                    <span class="font-semibold text-xs uppercase tracking-wide">Status: Menunggu Validasi Produk</span>
                </div>
                <span class="text-xs text-slate-500">{{ $product->created_at ? $product->created_at->format('d M Y, H:i') : '-' }}</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Foto Produk -->
                <div>
                    <div class="w-full h-56 rounded-xl border border-slate-200 overflow-hidden bg-slate-100 shadow-inner flex items-center justify-center">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-slate-400 text-center">
                                <svg class="w-12 h-12 mx-auto mb-1 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-xs">Tidak ada foto</span>
                            </div>
                        @endif
                    </div>
                    @if(count($product->all_images) > 1)
                        <div class="grid grid-cols-5 gap-2 mt-2">
                            @foreach($product->all_images as $img)
                                <img src="{{ asset('storage/' . $img) }}" alt="Preview" class="h-12 w-full object-cover rounded-lg border border-slate-200">
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Informasi UMKM & Kategori -->
                <div class="space-y-3.5">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kategori Produk</p>
                        <p class="text-base font-bold text-slate-800">{{ $product->category }}</p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">UMKM Pemilik</p>
                        <p class="font-bold text-slate-800">{{ $product->umkmProfile->business_name ?? 'Tidak diketahui' }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">Pemilik: {{ $product->umkmProfile->owner_name ?? '-' }}</p>
                        @if(isset($product->umkmProfile->phone))
                            <p class="text-xs text-emerald-600 font-medium mt-1 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $product->umkmProfile->phone }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Deskripsi Produk -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Deskripsi Produk</p>
                <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $product->description ?: 'Tidak ada deskripsi produk.' }}</p>
            </div>
        </div>

        <!-- Footer Modal with Actions -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/80 flex items-center justify-between gap-3">
            <button type="button" onclick="closeDashModal('dash-product-modal-{{ $product->id }}')" class="px-4 py-2 text-xs font-semibold rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-100 transition-colors shadow-sm">
                Tutup
            </button>
            <div class="flex items-center gap-2">
                <form action="{{ route('admin.product.reject', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak produk ini?');">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-bold rounded-lg bg-white border border-red-300 text-red-600 hover:bg-red-50 transition-colors shadow-sm">
                        Tolak Produk
                    </button>
                </form>
                <form action="{{ route('admin.product.verify', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-bold rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white transition-colors shadow-sm flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Setujui Produk
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Shared Chart Defaults
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#64748b';
        
        // Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Konsultasi Masuk',
                    data: [15, 25, 30, 45, 60, 40, 75, 95, 70, 80, 50, 40],
                    backgroundColor: '#B91C1C', // tailwind red-700
                    borderRadius: 4,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 13 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [4, 4], color: '#f1f5f9', drawBorder: false },
                        ticks: { display: false }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });

        // Donut Chart
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        const catLabels = {!! json_encode($catLabels) !!};
        const catCounts = {!! json_encode($catCounts) !!};
        const catPalette = ['#800000', '#D97706', '#2563EB', '#059669', '#7C3AED', '#DB2777', '#0891B2'];

        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: catLabels,
                datasets: [{
                    data: catCounts,
                    backgroundColor: catPalette.slice(0, catLabels.length),
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 16,
                            font: { size: 11, weight: '500' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 13 },
                        callbacks: {
                            label: function(context) {
                                return ` ${context.label}: ${context.raw} Produk`;
                            }
                        }
                    }
                }
            }
        });

        // ==========================================
        // Logika Dropdown Produk Wilayah, Pintasan & Grafik
        // ==========================================
        const regionProducts = {!! json_encode($allVerifiedProducts ?? []) !!};
        const regionUmkms = {!! json_encode($allUmkms ?? []) !!};
        const wilayahData = {!! json_encode($wilayahWonogiri ?? []) !!};
        const districtStatsData = {!! json_encode($districtsStatsData ?? []) !!};
        const allKecamatanList = {!! json_encode($allKecamatanList ?? []) !!};
        const standardCategories = {!! json_encode($allCategoriesList ?? [
            'Makanan & Minuman',
            'Batik/Fashion',
            'Kerajinan',
            'Olahan Hasil Pertanian',
            'Produk Kreatif'
        ]) !!};
        const adminProductsUrl = "{{ route('admin.products') }}";

        const dropdownBtn = document.getElementById('districtDropdownBtn');
        const dropdownMenu = document.getElementById('districtDropdownMenu');
        const dropdownSearch = document.getElementById('insideDropdownSearch');
        const dropdownItems = document.querySelectorAll('.dropdown-item');
        const selectedLabel = document.getElementById('selectedDistrictLabel');
        const selectedBadge = document.getElementById('selectedDistrictBadge');

        const villageDropdownBtn = document.getElementById('villageDropdownBtn');
        const villageDropdownMenu = document.getElementById('villageDropdownMenu');
        const villageSearch = document.getElementById('insideVillageSearch');
        const villageOptionsList = document.getElementById('villageOptionsList');
        const selectedVillageLabel = document.getElementById('selectedVillageLabel');
        const selectedVillageBadge = document.getElementById('selectedVillageBadge');
        const villageLabelTitle = document.getElementById('villageLabelTitle');
        const activeFilterNotice = document.getElementById('activeFilterNotice');
        const activeFilterDesc = document.getElementById('activeFilterDesc');

        const activeTitle = document.getElementById('activeRegionTitle');
        const activeSubtitle = document.getElementById('activeRegionSubtitle');
        const activeBadge = document.getElementById('activeRegionBadge');
        const activeProductCount = document.getElementById('activeProductCountBadge');
        const activeUmkmCount = document.getElementById('activeUmkmCountBadge');
        const activeManageLink = document.getElementById('activeManageLink');

        let currentDistrict = '';
        let currentVillage = '';
        let regionChart = null;

        function normalizeCategory(cat) {
            if (!cat) return 'Lainnya';
            const lower = cat.toLowerCase().trim();
            if (lower.includes('makan') || lower.includes('minum')) return 'Makanan & Minuman';
            if (lower.includes('batik') || lower.includes('fashion')) return 'Batik/Fashion';
            if (lower.includes('kerajinan') || lower.includes('kriya')) return 'Kerajinan';
            if (lower.includes('tani') || lower.includes('pertanian')) return 'Olahan Hasil Pertanian';
            if (lower.includes('kreatif')) return 'Produk Kreatif';
            for (let sc of standardCategories) {
                if (sc.toLowerCase() === lower) return sc;
            }
            return cat;
        }

        function populateVillageDropdown(districtName) {
            if (!villageOptionsList) return;
            villageOptionsList.innerHTML = '';

            // Pilihan default "Semua Desa"
            const allDesaItem = document.createElement('div');
            allDesaItem.className = 'dropdown-village-item p-2.5 text-xs text-slate-800 hover:bg-red-50 hover:text-[#800000] cursor-pointer font-bold transition-colors flex items-center justify-between ' + (!currentVillage ? 'bg-red-50/50' : '');
            allDesaItem.setAttribute('data-village', '');
            allDesaItem.setAttribute('data-name', 'Semua Desa Kelurahan seluruh ' + (districtName || 'Wonogiri'));
            allDesaItem.innerHTML = `
                <div class="flex items-center gap-2">
                    <span class="text-amber-500">★</span>
                    <span>${districtName ? 'Semua Desa di Kec. ' + districtName : 'Semua Desa / Kelurahan'}</span>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">Semua</span>
            `;
            allDesaItem.addEventListener('click', function(e) {
                e.stopPropagation();
                currentVillage = '';
                if (villageDropdownMenu) villageDropdownMenu.classList.add('hidden');
                renderRegionUI();
            });
            villageOptionsList.appendChild(allDesaItem);

            // Daftar Desa dari Master
            let listToDisplay = [];
            if (districtName && wilayahData[districtName]) {
                const desas = wilayahData[districtName];
                desas.forEach(d => {
                    listToDisplay.push({ desa: d, kec: districtName });
                });
                if (villageLabelTitle) villageLabelTitle.textContent = `Pilih Desa / Kelurahan (${desas.length} Desa di ${districtName}):`;
            } else {
                let totalD = 0;
                for (let k in wilayahData) {
                    wilayahData[k].forEach(d => {
                        listToDisplay.push({ desa: d, kec: k });
                        totalD++;
                    });
                }
                if (villageLabelTitle) villageLabelTitle.textContent = `Pilih Desa / Kelurahan (${totalD} Desa di Wonogiri):`;
            }

            listToDisplay.forEach(item => {
                const pInDesa = regionProducts.filter(p => (p.village || '').toLowerCase() === item.desa.toLowerCase() && (!item.kec || (p.district || '').toLowerCase() === item.kec.toLowerCase())).length;
                const uInDesa = regionUmkms.filter(u => (u.village || '').toLowerCase() === item.desa.toLowerCase() && (!item.kec || (u.district || '').toLowerCase() === item.kec.toLowerCase())).length;

                const isSelected = currentVillage && currentVillage.toLowerCase() === item.desa.toLowerCase();
                const div = document.createElement('div');
                div.className = 'dropdown-village-item p-2.5 text-xs text-slate-700 hover:bg-red-50 hover:text-[#800000] cursor-pointer font-medium transition-colors flex items-center justify-between ' + (isSelected ? 'bg-red-50 font-bold text-[#800000]' : '');
                div.setAttribute('data-village', item.desa);
                div.setAttribute('data-district', item.kec);
                div.setAttribute('data-name', `Desa ${item.desa} Kecamatan ${item.kec}`);
                div.innerHTML = `
                    <div class="pr-2">
                        <span class="font-semibold block text-slate-800">Desa ${item.desa}</span>
                        <span class="text-[10px] text-slate-400">Kecamatan ${item.kec}</span>
                        ${uInDesa > 0 ? `<span class="text-[10px] text-emerald-600 font-bold block mt-0.5">${uInDesa} UMKM</span>` : ''}
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold shrink-0 ${pInDesa > 0 ? 'bg-red-100 text-[#800000]' : 'bg-slate-100 text-slate-400'}">
                        ${pInDesa} Produk
                    </span>
                `;
                div.addEventListener('click', function(e) {
                    e.stopPropagation();
                    currentVillage = item.desa;
                    if (!currentDistrict) {
                        currentDistrict = item.kec;
                    }
                    if (villageDropdownMenu) villageDropdownMenu.classList.add('hidden');
                    renderRegionUI();
                });
                villageOptionsList.appendChild(div);
            });
        }

        function renderRegionUI() {
            let filtered = regionProducts;
            if (currentDistrict) {
                filtered = filtered.filter(p => (p.district || '').toLowerCase() === currentDistrict.toLowerCase());
            }
            if (currentVillage) {
                filtered = filtered.filter(p => (p.village || '').toLowerCase() === currentVillage.toLowerCase());
            }

            let matchedUmkms = regionUmkms;
            if (currentDistrict) {
                matchedUmkms = matchedUmkms.filter(u => (u.district || '').toLowerCase() === currentDistrict.toLowerCase());
            }
            if (currentVillage) {
                matchedUmkms = matchedUmkms.filter(u => (u.village || '').toLowerCase() === currentVillage.toLowerCase());
            }

            // Update Label & Badge Kecamatan
            if (selectedLabel) {
                selectedLabel.textContent = currentDistrict ? `Kecamatan ${currentDistrict}` : 'Semua Kecamatan (Wonogiri)';
            }
            if (selectedBadge) {
                if (currentDistrict) {
                    const desasInKec = wilayahData[currentDistrict] ? wilayahData[currentDistrict].length : 0;
                    selectedBadge.textContent = `${desasInKec} Desa`;
                } else {
                    selectedBadge.textContent = '25 Kec';
                }
            }

            // Update Label & Badge Desa
            if (selectedVillageLabel) {
                selectedVillageLabel.textContent = currentVillage ? `Desa ${currentVillage}` : (currentDistrict ? `Semua Desa (${currentDistrict})` : 'Semua Desa / Kelurahan');
            }
            if (selectedVillageBadge) {
                selectedVillageBadge.textContent = currentVillage ? '1 Desa' : 'Semua';
                selectedVillageBadge.className = currentVillage ? 'px-2 py-0.5 rounded-full text-[11px] font-extrabold bg-red-100 text-[#800000]' : 'px-2 py-0.5 rounded-full text-[11px] font-extrabold bg-slate-100 text-slate-600';
            }

            // Display Title & Subtitle Banner
            let displayName = 'Semua Wilayah Wonogiri';
            let displaySub = 'Menampilkan seluruh data produk terverifikasi dari UMKM di Kabupaten Wonogiri (25 Kecamatan, 294 Desa)';
            let displayBadge = 'Seluruh Kabupaten (294 Desa)';
            let badgeClass = 'px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200';

            if (currentVillage && currentDistrict) {
                displayName = `Desa ${currentVillage}, Kec. ${currentDistrict}`;
                displaySub = `Menampilkan data produk terverifikasi & UMKM di Desa ${currentVillage}, Kecamatan ${currentDistrict}`;
                displayBadge = 'Desa Terpilih';
                badgeClass = 'px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200';
            } else if (currentDistrict) {
                const totalDesasInKec = wilayahData[currentDistrict] ? wilayahData[currentDistrict].length : 0;
                displayName = `Kecamatan ${currentDistrict}`;
                displaySub = `Menampilkan data produk terverifikasi dari ${totalDesasInKec} desa/kelurahan di Kecamatan ${currentDistrict}`;
                displayBadge = `Kecamatan Terpilih (${totalDesasInKec} Desa)`;
                badgeClass = 'px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200';
            }

            if (activeTitle) activeTitle.textContent = displayName;
            if (activeSubtitle) activeSubtitle.textContent = displaySub;
            if (activeBadge) {
                activeBadge.textContent = displayBadge;
                activeBadge.className = badgeClass;
            }

            if (activeProductCount) activeProductCount.textContent = filtered.length;
            if (activeUmkmCount) activeUmkmCount.textContent = matchedUmkms.length;

            // Link Kelola Produk
            if (activeManageLink) {
                let link = adminProductsUrl;
                let params = [];
                if (currentDistrict) params.push(`district=${encodeURIComponent(currentDistrict)}`);
                if (currentVillage) params.push(`village=${encodeURIComponent(currentVillage)}`);
                if (params.length > 0) link += '?' + params.join('&');
                activeManageLink.href = link;
            }

            // Notice Filter Aktif
            if (activeFilterNotice) {
                if (currentDistrict || currentVillage) {
                    activeFilterNotice.classList.remove('hidden');
                    if (activeFilterDesc) {
                        activeFilterDesc.textContent = `Filter Aktif: ${displayName} (${filtered.length} Produk, ${matchedUmkms.length} UMKM).`;
                    }
                } else {
                    activeFilterNotice.classList.add('hidden');
                }
            }

            // Update isi dropdown Desa sesuai kecamatan aktif
            populateVillageDropdown(currentDistrict);

            // Render Grafik
            renderRegionChart(filtered, matchedUmkms);
        }

        function renderRegionChart(filteredProducts, matchedUmkms) {
            const canvas = document.getElementById('regionDistributionChart');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            const emptyEl = document.getElementById('regionChartEmptyState');
            const chartWrapper = document.getElementById('regionChartWrapper');
            const chartTitle = document.getElementById('regionChartTitle');
            const chartSubtitle = document.getElementById('regionChartSubtitle');
            const chartResetBtn = document.getElementById('chartResetBtn');

            // Elements of the 4 stat cards below the chart
            const statCategoryTopValue = document.getElementById('statCategoryTopValue');
            const statCategoryTopDesc = document.getElementById('statCategoryTopDesc');
            const statCategoryActiveValue = document.getElementById('statCategoryActiveValue');
            const statCategoryActiveDesc = document.getElementById('statCategoryActiveDesc');
            const statProductTotalValue = document.getElementById('statProductTotalValue');
            const statProductTotalDesc = document.getElementById('statProductTotalDesc');
            const statRegionScopeValue = document.getElementById('statRegionScopeValue');
            const statRegionScopeDesc = document.getElementById('statRegionScopeDesc');

            const isFiltered = Boolean(currentDistrict || currentVillage);
            const filterDescName = currentVillage ? `Desa ${currentVillage}, Kec. ${currentDistrict}` : (currentDistrict ? `Kecamatan ${currentDistrict}` : 'Semua Wilayah');

            // Handle Empty State when filtered area has 0 products
            if (isFiltered && filteredProducts.length === 0) {
                if (chartResetBtn) chartResetBtn.classList.remove('hidden');
                if (chartTitle) chartTitle.textContent = `Grafik Kategori Produk - ${filterDescName}`;
                if (chartSubtitle) chartSubtitle.textContent = `Tidak ada produk terverifikasi di ${filterDescName}`;
                if (chartWrapper) chartWrapper.classList.add('hidden');
                if (emptyEl) {
                    emptyEl.classList.remove('hidden');
                    const emptyTitle = document.getElementById('chartEmptyTitle');
                    const emptyDesc = document.getElementById('chartEmptyDesc');
                    if (emptyTitle) emptyTitle.textContent = `Belum Ada Produk di ${filterDescName}`;
                    if (emptyDesc) {
                        if (matchedUmkms.length > 0) {
                            emptyDesc.textContent = `Terdapat ${matchedUmkms.length} UMKM terdaftar di ${filterDescName} yang belum memiliki produk terverifikasi.`;
                        } else {
                            emptyDesc.textContent = `Belum ada UMKM maupun produk terverifikasi di ${filterDescName}.`;
                        }
                    }
                }

                // Update cards for empty state
                if (statCategoryTopValue) statCategoryTopValue.textContent = '-';
                if (statCategoryTopDesc) statCategoryTopDesc.textContent = '0 Produk';
                if (statCategoryActiveValue) statCategoryActiveValue.textContent = '0 dari ' + standardCategories.length + ' Kategori';
                if (statCategoryActiveDesc) statCategoryActiveDesc.textContent = 'Belum ada produk aktif';
                if (statProductTotalValue) statProductTotalValue.textContent = '0 Produk';
                if (statProductTotalDesc) statProductTotalDesc.textContent = filterDescName;
                if (statRegionScopeValue) statRegionScopeValue.textContent = filterDescName;
                if (statRegionScopeDesc) statRegionScopeDesc.textContent = matchedUmkms.length + ' UMKM Terdaftar';

                if (regionChart) {
                    regionChart.destroy();
                    regionChart = null;
                }
                return;
            }

            // Normal state (with products or all regions)
            if (chartWrapper) chartWrapper.classList.remove('hidden');
            if (emptyEl) emptyEl.classList.add('hidden');

            if (!isFiltered) {
                if (chartResetBtn) chartResetBtn.classList.add('hidden');
                if (chartTitle) chartTitle.textContent = 'Grafik Sebaran Kategori Produk UMKM';
                if (chartSubtitle) chartSubtitle.textContent = 'Distribusi produk terverifikasi per kategori di seluruh wilayah Kabupaten Wonogiri (25 Kecamatan, 294 Desa)';
            } else {
                if (chartResetBtn) chartResetBtn.classList.remove('hidden');
                if (chartTitle) chartTitle.textContent = `Grafik Kategori Produk - ${filterDescName}`;
                if (chartSubtitle) chartSubtitle.textContent = `Distribusi ${filteredProducts.length} produk terverifikasi berdasarkan kategori di ${filterDescName}`;
            }

            // Prepare counts with exact standard categories
            const categoryCounts = {};
            standardCategories.forEach(c => {
                categoryCounts[c] = 0;
            });

            filteredProducts.forEach(p => {
                const normCat = normalizeCategory(p.category);
                if (categoryCounts.hasOwnProperty(normCat)) {
                    categoryCounts[normCat]++;
                } else {
                    categoryCounts[normCat] = (categoryCounts[normCat] || 0) + 1;
                }
            });

            const labels = Object.keys(categoryCounts);
            const productCounts = Object.values(categoryCounts);

            // Calculate card metrics
            let topCat = '-';
            let topCount = 0;
            let activeCatCount = 0;
            labels.forEach(l => {
                const cnt = categoryCounts[l];
                if (cnt > 0) activeCatCount++;
                if (cnt > topCount) {
                    topCount = cnt;
                    topCat = l;
                }
            });

            const totalFilteredProducts = filteredProducts.length;
            const topPct = totalFilteredProducts > 0 ? Math.round((topCount / totalFilteredProducts) * 100) : 0;

            if (statCategoryTopValue) statCategoryTopValue.textContent = topCat;
            if (statCategoryTopDesc) statCategoryTopDesc.textContent = `${topCount} Produk (${topPct}%)`;
            if (statCategoryActiveValue) statCategoryActiveValue.textContent = `${activeCatCount} dari ${labels.length} Kategori`;
            if (statCategoryActiveDesc) statCategoryActiveDesc.textContent = activeCatCount > 0 ? 'Memiliki produk aktif' : 'Belum ada produk';
            if (statProductTotalValue) statProductTotalValue.textContent = `${totalFilteredProducts} Produk`;
            if (statProductTotalDesc) statProductTotalDesc.textContent = isFiltered ? filterDescName : 'Seluruh Kabupaten (294 Desa)';
            if (statRegionScopeValue) statRegionScopeValue.textContent = isFiltered ? filterDescName : 'Semua Wilayah';
            if (statRegionScopeDesc) statRegionScopeDesc.textContent = isFiltered ? `${matchedUmkms.length} UMKM Terdaftar` : '25 Kecamatan &bull; 294 Desa';

            if (regionChart) {
                regionChart.destroy();
            }

            regionChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Jumlah Produk',
                            data: productCounts,
                            backgroundColor: '#800000',
                            hoverBackgroundColor: '#991b1b',
                            borderRadius: 8,
                            borderSkipped: false,
                            barPercentage: 0.45,
                            categoryPercentage: 0.7,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    onClick: function(e, elements) {
                        if (elements.length > 0) {
                            const index = elements[0].index;
                            const clickedCat = labels[index];
                            if (clickedCat) {
                                let targetUrl = `${adminProductsUrl}?category=${encodeURIComponent(clickedCat)}`;
                                if (currentDistrict) {
                                    targetUrl += `&district=${encodeURIComponent(currentDistrict)}`;
                                }
                                if (currentVillage) {
                                    targetUrl += `&village=${encodeURIComponent(currentVillage)}`;
                                }
                                window.location.href = targetUrl;
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            align: 'end',
                            labels: {
                                boxWidth: 12,
                                boxHeight: 12,
                                usePointStyle: true,
                                font: { size: 11, weight: 'bold' }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: { size: 13, weight: 'bold' },
                            bodyFont: { size: 12 },
                            callbacks: {
                                label: function(context) {
                                    return ` Jumlah Produk: ${context.raw} Produk (Klik untuk filter katalog)`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                stepSize: 1,
                                font: { size: 11 }
                            },
                            grid: {
                                color: '#f1f5f9',
                                borderDash: [3, 3]
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { size: 11, weight: '600' },
                                color: '#334155',
                                maxRotation: 0,
                                minRotation: 0,
                                callback: function(value) {
                                    const label = this.getLabelForValue(value);
                                    if (window.innerWidth < 640 && label.length > 14) {
                                        return label.substring(0, 12) + '...';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Dropdown Kecamatan toggle & events
        if (dropdownBtn && dropdownMenu) {
            dropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (villageDropdownMenu) villageDropdownMenu.classList.add('hidden');
                dropdownMenu.classList.toggle('hidden');
                if (!dropdownMenu.classList.contains('hidden') && dropdownSearch) {
                    dropdownSearch.value = '';
                    filterDropdownItems('');
                    setTimeout(() => dropdownSearch.focus(), 50);
                }
            });

            if (dropdownSearch) {
                dropdownSearch.addEventListener('click', e => e.stopPropagation());
                dropdownSearch.addEventListener('input', function() {
                    filterDropdownItems(this.value.trim().toLowerCase());
                });
            }

            function filterDropdownItems(query) {
                let visibleCount = 0;
                dropdownItems.forEach(item => {
                    const text = (item.getAttribute('data-name') || item.textContent).toLowerCase();
                    if (!query || text.includes(query)) {
                        item.style.display = 'flex';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });
                const noResults = document.getElementById('dropdownNoResults');
                if (noResults) {
                    if (visibleCount === 0) {
                        noResults.classList.remove('hidden');
                    } else {
                        noResults.classList.add('hidden');
                    }
                }
            }

            dropdownItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    currentDistrict = this.getAttribute('data-district') || '';
                    currentVillage = ''; // Reset desa saat ganti kecamatan
                    dropdownMenu.classList.add('hidden');
                    renderRegionUI();
                });
            });
        }

        // Dropdown Desa toggle & events
        if (villageDropdownBtn && villageDropdownMenu) {
            villageDropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (dropdownMenu) dropdownMenu.classList.add('hidden');
                villageDropdownMenu.classList.toggle('hidden');
                if (!villageDropdownMenu.classList.contains('hidden') && villageSearch) {
                    villageSearch.value = '';
                    const vItems = document.querySelectorAll('.dropdown-village-item');
                    vItems.forEach(item => item.style.display = 'flex');
                    setTimeout(() => villageSearch.focus(), 50);
                }
            });

            if (villageSearch) {
                villageSearch.addEventListener('click', e => e.stopPropagation());
                villageSearch.addEventListener('input', function() {
                    const q = this.value.trim().toLowerCase();
                    const vItems = document.querySelectorAll('.dropdown-village-item');
                    vItems.forEach(item => {
                        const text = (item.getAttribute('data-name') || item.textContent).toLowerCase();
                        if (!q || text.includes(q)) {
                            item.style.display = 'flex';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
        }

        // Klik di luar dropdown untuk menutup popover
        document.addEventListener('click', function(e) {
            if (dropdownBtn && dropdownMenu && !dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
            if (villageDropdownBtn && villageDropdownMenu && !villageDropdownBtn.contains(e.target) && !villageDropdownMenu.contains(e.target)) {
                villageDropdownMenu.classList.add('hidden');
            }
        });

        window.resetRegionFilter = function() {
            currentDistrict = '';
            currentVillage = '';
            renderRegionUI();
        };

        // Render awal saat halaman dimuat
        renderRegionUI();
    });

    function openDashModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                const inner = modal.querySelector('div');
                if (inner) {
                    inner.classList.remove('scale-95');
                    inner.classList.add('scale-100');
                }
            });
        }
    }

    function closeDashModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('opacity-0');
            const inner = modal.querySelector('div');
            if (inner) {
                inner.classList.remove('scale-100');
                inner.classList.add('scale-95');
            }
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }
    }

    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('backdrop-blur-sm') && e.target.id && e.target.id.startsWith('dash-')) {
            closeDashModal(e.target.id);
        }
    });

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="dash-"]:not(.hidden)').forEach(modal => {
                closeDashModal(modal.id);
            });
        }
    });
</script>
@endpush
