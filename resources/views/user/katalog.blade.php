@extends('layouts.app')

@section('content')

<!-- Hero Header Section with Dark Red Background & Wonogiri Overlay -->
<div class="relative w-full overflow-hidden text-white flex items-center justify-center text-center pt-24 pb-12 sm:pt-36 sm:pb-20"
     style="background: linear-gradient(rgba(120, 15, 15, 0.78), rgba(90, 10, 10, 0.88)), url('{{ asset('img/hero_wonogiri_3.jpg') }}') center 30% / cover no-repeat;">
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 reveal">
        <h1 class="text-2xl sm:text-4xl md:text-5xl font-black text-white mb-2 sm:mb-3.5 tracking-tight [text-shadow:_0_2px_10px_rgba(0,0,0,0.6)]">
            Produk Unggulan UMKM Wonogiri
        </h1>
        <p class="text-xs sm:text-base md:text-lg text-white/95 max-w-2xl mx-auto font-medium leading-relaxed [text-shadow:_0_1px_6px_rgba(0,0,0,0.6)]">
            Temukan aneka ragam produk lokal berkualitas tinggi hasil produksi langsung putra-putri Wonogiri.
        </p>
    </div>
</div>

<!-- Main Catalog Content on #FAF9F6 Background -->
<div style="background-color: #FAF9F6;" class="min-h-screen py-6 sm:py-14">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">

        <!-- Search & Filter Card -->
        <div id="katalog-filter-container" class="relative z-30 bg-white rounded-2xl p-3 sm:p-4 shadow-xs border border-slate-200/80 mb-6 sm:mb-10">
            <form id="katalog-filter-form" action="/katalog" method="GET" class="flex flex-col md:flex-row items-center gap-2.5 sm:gap-3.5">
                
                <!-- Search Input -->
                <div class="relative flex-1 w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           id="katalog-search-input"
                           name="q" 
                           value="{{ request('q') }}" 
                           autocomplete="off"
                           placeholder="Cari produk unggulan..." 
                           class="w-full search-input-padding pl-11 pr-10 py-2.5 text-xs sm:text-sm bg-white border-2 border-slate-300 rounded-xl focus:outline-none focus:border-[#991b1b] focus:ring-4 focus:ring-red-500/15 text-slate-900 placeholder:text-slate-400 shadow-xs transition-all"
                           style="padding-left: 2.75rem !important; padding-right: 2.5rem !important;">
                    
                    <!-- Subtle Spinner saat Auto-Filter Memuat -->
                    <div id="katalog-search-spinner" class="hidden absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-[#991b1b]">
                        <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </div>
                </div>

                @php
                    $currentKategori = strtolower(trim(request('kategori', '')));
                    $kategoriOptions = [
                        '' => 'Kategori: Semua',
                        'makanan' => 'Makanan & Minuman',
                        'kerajinan' => 'Kerajinan',
                        'batik' => 'Batik/Fashion',
                        'pertanian' => 'Olahan Hasil Pertanian',
                        'kreatif' => 'Produk Kreatif',
                    ];
                    $currentKategoriLabel = $kategoriOptions[$currentKategori] ?? 'Kategori: Semua';

                    $wilayahJsonPath = public_path('wonogiri_wilayah.json');
                    $kecamatanList = file_exists($wilayahJsonPath)
                        ? array_keys(json_decode(file_get_contents($wilayahJsonPath), true))
                        : [
                            'Baturetno', 'Batuwarno', 'Bulukerto', 'Eromoko', 'Girimarto', 
                            'Giritontro', 'Giriwoyo', 'Jatipurno', 'Jatiroto', 'Jatisrono', 
                            'Karangtengah', 'Kismantoro', 'Manyaran', 'Ngadirojo', 'Nguntoronadi', 
                            'Paranggupito', 'Pracimantoro', 'Puhpelem', 'Purwantoro', 'Selogiri', 
                            'Sidoharjo', 'Slogohimo', 'Tirtomoyo', 'Wonogiri', 'Wuryantoro'
                        ];
                    sort($kecamatanList);

                    $currentKecamatan = strtolower(trim(request('kecamatan', '')));
                    $currentKecamatanLabel = 'Kecamatan: Semua';
                    if ($currentKecamatan !== '') {
                        foreach ($kecamatanList as $kec) {
                            if (strtolower(trim($kec)) === $currentKecamatan) {
                                $currentKecamatanLabel = 'Kec. ' . $kec;
                                break;
                            }
                        }
                    }
                @endphp

                <!-- Dropdown Kategori Modern Custom -->
                <div class="w-full md:w-56 shrink-0 relative z-20" id="cat-dropdown-container">
                    <input type="hidden" id="katalog-category-select" name="kategori" value="{{ $currentKategori }}">
                    
                    <button type="button" 
                            id="cat-dropdown-btn"
                            class="w-full flex items-center justify-between pl-3.5 pr-3 py-2.5 text-xs sm:text-sm bg-white border-2 border-slate-300 hover:border-[#991b1b]/60 rounded-xl focus:outline-none focus:border-[#991b1b] focus:ring-4 focus:ring-red-500/15 text-slate-900 font-medium cursor-pointer shadow-xs transition-all">
                        <span id="cat-dropdown-label" class="truncate">{{ $currentKategoriLabel }}</span>
                        <svg id="cat-dropdown-arrow" class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0 ml-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>

                    <!-- Dropdown Panel (Bottom Sheet on mobile, floating menu on desktop) -->
                    <div id="cat-dropdown-panel" class="hidden fixed sm:absolute inset-0 sm:inset-auto sm:top-full sm:left-0 sm:right-0 sm:mt-1.5 z-50 flex flex-col justify-end sm:justify-start">
                        <!-- Mobile Backdrop -->
                        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs sm:hidden transition-opacity" onclick="closeAllCustomDropdowns()"></div>
                        
                        <!-- Panel Content -->
                        <div class="relative bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl border border-slate-200 p-4 sm:p-2 max-h-[80vh] sm:max-h-80 overflow-y-auto z-10">
                            <!-- Mobile Header Handle -->
                            <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-3 sm:hidden"></div>
                            <div class="sm:hidden flex items-center justify-between pb-2.5 mb-2 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-[#800000]"></span>
                                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Pilih Kategori Produk</span>
                                </div>
                                <button type="button" onclick="closeAllCustomDropdowns()" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            <!-- Options List -->
                            <div class="space-y-1">
                                @foreach($kategoriOptions as $val => $lbl)
                                    @php $isActive = ($currentKategori === (string)$val); @endphp
                                    <button type="button" 
                                            onclick="selectKategori('{{ $val }}', '{{ $lbl }}')"
                                            class="cat-option-item w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all text-left {{ $isActive ? 'bg-red-50 text-[#800000]' : 'text-slate-700 hover:bg-slate-50' }}"
                                            data-val="{{ $val }}">
                                        <span>{{ $lbl }}</span>
                                        <svg class="check-icon w-4 h-4 text-[#800000] shrink-0 {{ $isActive ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dropdown Kecamatan Modern Custom (25 Kecamatan Resmi Wonogiri) -->
                <div class="w-full md:w-56 shrink-0 relative z-10" id="dist-dropdown-container">
                    <input type="hidden" id="katalog-district-select" name="kecamatan" value="{{ $currentKecamatan }}">
                    
                    <button type="button" 
                            id="dist-dropdown-btn"
                            class="w-full flex items-center justify-between pl-3.5 pr-3 py-2.5 text-xs sm:text-sm bg-white border-2 border-slate-300 hover:border-[#991b1b]/60 rounded-xl focus:outline-none focus:border-[#991b1b] focus:ring-4 focus:ring-red-500/15 text-slate-900 font-medium cursor-pointer shadow-xs transition-all">
                        <span id="dist-dropdown-label" class="truncate">{{ $currentKecamatanLabel }}</span>
                        <svg id="dist-dropdown-arrow" class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0 ml-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>

                    <!-- Dropdown Panel (Bottom Sheet on mobile, floating menu on desktop) -->
                    <div id="dist-dropdown-panel" class="hidden fixed sm:absolute inset-0 sm:inset-auto sm:top-full sm:left-0 sm:right-0 sm:mt-1.5 z-50 flex flex-col justify-end sm:justify-start">
                        <!-- Mobile Backdrop -->
                        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs sm:hidden transition-opacity" onclick="closeAllCustomDropdowns()"></div>
                        
                        <!-- Panel Content -->
                        <div class="relative bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl border border-slate-200 p-4 sm:p-2.5 max-h-[85vh] sm:max-h-96 flex flex-col z-10">
                            <!-- Mobile Header Handle -->
                            <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-3 sm:hidden"></div>
                            <div class="sm:hidden flex items-center justify-between pb-2.5 mb-2 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-[#800000]"></span>
                                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Pilih Kecamatan (25 Wilayah)</span>
                                </div>
                                <button type="button" onclick="closeAllCustomDropdowns()" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            <!-- Live Filter Input Inside Dropdown -->
                            <div class="relative mb-2">
                                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <input type="text" 
                                       id="dist-search-input" 
                                       placeholder="Ketik nama kecamatan..." 
                                       autocomplete="off"
                                       class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#991b1b] focus:ring-2 focus:ring-red-500/10 text-slate-800"
                                       style="padding-left: 2.25rem !important;">
                            </div>

                            <!-- Options List with Smooth Scrolling -->
                            <div id="dist-options-list" class="overflow-y-auto space-y-1 max-h-56 sm:max-h-64 pr-1 scrollbar-thin">
                                @php $isAllActive = ($currentKecamatan === ''); @endphp
                                <button type="button" 
                                        onclick="selectKecamatan('', 'Kecamatan: Semua')"
                                        class="dist-option-item w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all text-left {{ $isAllActive ? 'bg-red-50 text-[#800000]' : 'text-slate-700 hover:bg-slate-50' }}"
                                        data-val=""
                                        data-name="semua kecamatan">
                                    <span>Kecamatan: Semua</span>
                                    <svg class="check-icon w-4 h-4 text-[#800000] shrink-0 {{ $isAllActive ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </button>

                                @foreach($kecamatanList as $kec)
                                    @php 
                                        $kecVal = strtolower(trim($kec));
                                        $isActive = ($currentKecamatan === $kecVal); 
                                    @endphp
                                    <button type="button" 
                                            onclick="selectKecamatan('{{ $kecVal }}', 'Kec. {{ $kec }}')"
                                            class="dist-option-item w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all text-left {{ $isActive ? 'bg-red-50 text-[#800000]' : 'text-slate-700 hover:bg-slate-50' }}"
                                            data-val="{{ $kecVal }}"
                                            data-name="kec. {{ strtolower($kec) }} {{ strtolower($kec) }}">
                                        <span>Kec. {{ $kec }}</span>
                                        <svg class="check-icon w-4 h-4 text-[#800000] shrink-0 {{ $isActive ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @php
            if (!isset($products)) {
                $searchQuery = strtolower(trim(request('q', '')));
                $categoryFilter = strtolower(trim(request('kategori', '')));
                $districtFilter = strtolower(trim(request('kecamatan', '')));

                $query = \App\Models\User\Product::with('umkmProfile')->where('status', 'verified');

                if ($searchQuery !== '') {
                    $query->where(function($q) use ($searchQuery) {
                        $q->whereRaw('LOWER(name) LIKE ?', ['%' . $searchQuery . '%'])
                          ->orWhereHas('umkmProfile', function($q2) use ($searchQuery) {
                              $q2->whereRaw('LOWER(business_name) LIKE ?', ['%' . $searchQuery . '%'])
                                 ->orWhereRaw('LOWER(address) LIKE ?', ['%' . $searchQuery . '%']);
                          });
                    });
                }

                if ($categoryFilter !== '') {
                    if ($categoryFilter === 'makanan' || str_contains($categoryFilter, 'makan')) {
                        $query->whereRaw('LOWER(category) LIKE ?', ['%makan%']);
                    } elseif ($categoryFilter === 'kerajinan' || str_contains($categoryFilter, 'rajin')) {
                        $query->whereRaw('LOWER(category) LIKE ?', ['%rajin%']);
                    } elseif ($categoryFilter === 'batik' || str_contains($categoryFilter, 'batik') || str_contains($categoryFilter, 'fashion')) {
                        $query->where(function($cq) {
                            $cq->whereRaw('LOWER(category) LIKE ?', ['%batik%'])
                               ->orWhereRaw('LOWER(category) LIKE ?', ['%fashion%']);
                        });
                    } elseif ($categoryFilter === 'pertanian' || str_contains($categoryFilter, 'pertan')) {
                        $query->whereRaw('LOWER(category) LIKE ?', ['%pertan%']);
                    } elseif ($categoryFilter === 'kreatif' || str_contains($categoryFilter, 'kreatif')) {
                        $query->whereRaw('LOWER(category) LIKE ?', ['%kreatif%']);
                    } else {
                        $query->whereRaw('LOWER(category) LIKE ?', ['%' . $categoryFilter . '%']);
                    }
                }

                if ($districtFilter !== '') {
                    $query->whereHas('umkmProfile', function($q) use ($districtFilter) {
                        $q->where(function($subQ) use ($districtFilter) {
                            $subQ->whereRaw('LOWER(district) LIKE ?', ['%' . $districtFilter . '%'])
                                 ->orWhereRaw('LOWER(address) LIKE ?', ['%' . $districtFilter . '%']);
                        });
                    });
                }

                $products = $query->latest()->paginate(16)->withQueryString();
            }
        @endphp

        <!-- Target Anchor for Smooth Scrolling -->
        <div id="katalog-anchor" class="scroll-mt-24"></div>

        <!-- Katalog Content Container -->
        <div id="katalog-grid-container" class="relative z-10 reveal delay-200">
            @if ($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4 sm:gap-5">
                @foreach ($products as $product)
                <a href="{{ route('katalog.show', $product->id) }}" class="bg-white rounded-2xl overflow-hidden border-2 border-slate-200/90 hover:border-[#800000] shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group flex flex-col justify-between cursor-pointer relative">
                    <div>
                        <div class="h-36 sm:h-44 w-full overflow-hidden bg-slate-100 relative">
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" onerror="this.onerror=null; this.src='https://placehold.co/600x400/f1f5f9/94a3b8?text=Foto+Produk';" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                    <svg class="w-8 h-8 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <!-- Gradient Vignette Shadow -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                            <!-- Golden Featured Badge (Hanya badge Unggulan di pojok atas foto) -->
                            @if($product->is_featured)
                            <span class="absolute top-2.5 right-2.5 bg-gradient-to-r from-amber-500 via-amber-400 to-amber-600 text-slate-950 text-[10px] sm:text-xs font-black px-2.5 py-0.5 rounded-full shadow-md flex items-center gap-1 border border-yellow-200 ring-2 ring-amber-400/20 z-10">
                                <svg class="w-3 h-3 text-slate-950 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span>UNGGULAN</span>
                            </span>
                            @endif
                        </div>
                        <div class="p-3 sm:p-4 pb-0">
                            <!-- Category Badge (Rapi di atas judul produk, terpisah dari badge foto) -->
                            @if($product->category)
                            <div class="mb-1.5">
                                <span class="inline-block text-[10px] sm:text-[11px] font-extrabold uppercase tracking-wider text-[#800000] bg-red-50 border border-red-200/80 px-2.5 py-0.5 rounded-md">
                                    {{ $product->category }}
                                </span>
                            </div>
                            @endif

                            <h3 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#800000] transition-colors leading-snug line-clamp-2 min-h-[2rem] sm:min-h-[2.5rem]">
                                {{ $product->name }}
                            </h3>
                            <p class="text-[10px] sm:text-xs text-slate-500 mt-1 flex items-center gap-1">
                                @if(!empty($product->umkmProfile->image_path))
                                    <img src="{{ asset('storage/' . $product->umkmProfile->image_path) }}" alt="{{ $product->umkmProfile->business_name }}" class="w-3.5 h-3.5 rounded-full object-cover shrink-0 ring-1 ring-slate-200">
                                @else
                                    <span class="w-3.5 h-3.5 rounded-full bg-red-100 text-[#800000] flex items-center justify-center text-[8px] font-bold shrink-0">U</span>
                                @endif
                                <span class="truncate font-medium text-slate-600">oleh {{ $product->umkmProfile->business_name ?? 'UMKM Wonogiri' }}</span>
                                <svg class="w-3 h-3 text-blue-500 shrink-0" fill="currentColor" viewBox="0 0 20 20" title="UMKM Terverifikasi"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </p>

                            <!-- Status Badge Bersih (Tanpa Teks Harga) -->
                            <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between gap-1">
                                <span class="inline-flex items-center gap-1 text-[8px] sm:text-[10px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded-md border border-emerald-200/60 shrink-0">
                                    <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span> Siap Dipesan
                                </span>
                                <span class="text-[9px] sm:text-[10px] font-semibold text-slate-400 truncate">
                                    Khas Wonogiri
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-2.5 sm:p-3.5 pt-2 sm:pt-2">
                        <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-[10px] sm:text-xs">
                            <div class="flex items-center gap-1 text-slate-400 font-medium">
                                <svg class="w-3 h-3 text-[#800000] shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="line-clamp-1 max-w-[70px] sm:max-w-[110px] font-semibold text-slate-700 text-[9px] sm:text-[11px]">{{ $product->umkmProfile->district ?? $product->umkmProfile->address ?? 'Wonogiri' }}</span>
                            </div>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-red-50 text-[#800000] group-hover:bg-[#800000] group-hover:text-white text-[10px] sm:text-xs font-bold transition-all duration-300 shadow-2xs group-hover:shadow-md shrink-0">
                                <span>Detail</span>
                                <svg class="w-2.5 h-2.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="py-16 text-center bg-white rounded-2xl border border-slate-200">
                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
                <p class="text-slate-600 font-semibold text-base mb-1">Belum ada produk</p>
                <p class="text-slate-400 text-xs sm:text-sm mb-4">Belum ada produk yang tersedia saat ini atau kriteria pencarian tidak cocok.</p>
                <a href="/katalog" class="inline-flex items-center px-4 py-2 rounded-lg bg-[#991b1b] text-white text-xs font-bold hover:bg-[#801414] transition-colors">
                    Reset Filter
                </a>
            </div>
            @endif
        </div>

        <!-- Pagination Container for Smooth AJAX Replacement -->
        <div id="katalog-pagination-container">
            @if ($products->hasPages())
            <div class="flex items-center justify-center gap-2 mt-12 mb-8 reveal delay-300 select-none">
                {{-- Tombol Previous (<) --}}
                @if ($products->onFirstPage())
                    <span class="w-9 h-9 rounded-lg bg-slate-100 border border-slate-200 text-slate-300 flex items-center justify-center transition-all shadow-2xs pointer-events-none opacity-40">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    </span>
                @else
                    <a href="{{ $products->previousPageUrl() }}#katalog-anchor" class="w-9 h-9 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 flex items-center justify-center transition-all shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    </a>
                @endif

                {{-- Nomor Halaman --}}
                @foreach ($products->links()->elements[0] as $page => $url)
                    @if ($page == $products->currentPage())
                        <span class="w-9 h-9 rounded-lg flex items-center justify-center transition-all text-xs sm:text-sm font-bold bg-[#991b1b] text-white shadow-xs cursor-default">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}#katalog-anchor" class="w-9 h-9 rounded-lg flex items-center justify-center transition-all text-xs sm:text-sm font-medium bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 shadow-2xs">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Tombol Next (>) --}}
                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}#katalog-anchor" class="w-9 h-9 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 flex items-center justify-center transition-all shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                @else
                    <span class="w-9 h-9 rounded-lg bg-slate-100 border border-slate-200 text-slate-300 flex items-center justify-center transition-all shadow-2xs pointer-events-none opacity-40">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </span>
                @endif
            </div>
            @endif
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('katalog-filter-form');
    const searchInput = document.getElementById('katalog-search-input');
    const catSelect = document.getElementById('katalog-category-select');
    const distSelect = document.getElementById('katalog-district-select');
    const gridContainer = document.getElementById('katalog-grid-container');
    const paginationContainer = document.getElementById('katalog-pagination-container');
    const spinner = document.getElementById('katalog-search-spinner');

    let debounceTimer = null;
    let abortController = null;
    let lastExecutedQuery = (searchInput ? searchInput.value.trim() : '');

    function triggerAutoFilter() {
        if (!gridContainer) return;

        // Batalkan request sebelumnya jika user masih mengetik/mengubah
        if (abortController) {
            abortController.abort();
        }
        abortController = new AbortController();

        const qVal = searchInput ? searchInput.value.trim() : '';
        const catVal = catSelect ? catSelect.value : '';
        const distVal = distSelect ? distSelect.value : '';

        const params = new URLSearchParams();
        if (qVal.length >= 3) {
            params.set('q', qVal);
        }
        if (catVal) {
            params.set('kategori', catVal);
        }
        if (distVal) {
            params.set('kecamatan', distVal);
        }

        const queryString = params.toString();
        const targetUrl = `/katalog${queryString ? '?' + queryString : ''}`;

        // Tampilkan indikator visual saat memuat
        gridContainer.classList.add('opacity-40', 'pointer-events-none', 'transition-opacity', 'duration-200');
        if (spinner) spinner.classList.remove('hidden');

        fetch(targetUrl, {
            signal: abortController.signal,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => {
            if (!response.ok) throw new Error('Gagal memuat katalog');
            return response.text();
        })
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            const newGrid = doc.getElementById('katalog-grid-container');
            const newPagination = doc.getElementById('katalog-pagination-container');

            if (newGrid && gridContainer) {
                gridContainer.innerHTML = newGrid.innerHTML;
            }

            if (paginationContainer) {
                paginationContainer.innerHTML = newPagination ? newPagination.innerHTML : '';
            }

            // Update URL browser tanpa reload
            history.replaceState(null, '', targetUrl);
            lastExecutedQuery = qVal;
        })
        .catch(err => {
            if (err.name !== 'AbortError') {
                console.error('Error saat auto-filter katalog:', err);
            }
        })
        .finally(() => {
            if (gridContainer) gridContainer.classList.remove('opacity-40', 'pointer-events-none');
            if (spinner) spinner.classList.add('hidden');
        });
    }

    // 1. Live Filter saat menulis minimal 3 huruf (atau saat dihapus/dikosongkan untuk reset)
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const val = this.value.trim();

            if (val.length >= 3 || val.length === 0) {
                debounceTimer = setTimeout(() => {
                    if (val !== lastExecutedQuery || val.length === 0) {
                        triggerAutoFilter();
                    }
                }, 350);
            }
        });
    }

    // Dropdown Handlers
    const catBtn = document.getElementById('cat-dropdown-btn');
    const distBtn = document.getElementById('dist-dropdown-btn');
    const catPanel = document.getElementById('cat-dropdown-panel');
    const distPanel = document.getElementById('dist-dropdown-panel');
    const catArrow = document.getElementById('cat-dropdown-arrow');
    const distArrow = document.getElementById('dist-dropdown-arrow');
    const distSearch = document.getElementById('dist-search-input');
    const catBox = document.getElementById('cat-dropdown-container');
    const distBox = document.getElementById('dist-dropdown-container');
    const filterContainer = document.getElementById('katalog-filter-container');

    window.closeAllCustomDropdowns = function() {
        if (catPanel) catPanel.classList.add('hidden');
        if (distPanel) distPanel.classList.add('hidden');
        if (catArrow) catArrow.classList.remove('rotate-180');
        if (distArrow) distArrow.classList.remove('rotate-180');
        if (catBox) {
            catBox.classList.remove('z-40');
            catBox.classList.add('z-20');
        }
        if (distBox) {
            distBox.classList.remove('z-40');
            distBox.classList.add('z-10');
        }
        if (filterContainer) {
            filterContainer.classList.remove('z-40');
            filterContainer.classList.add('z-30');
        }
    };

    if (catBtn) {
        catBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isClosed = catPanel.classList.contains('hidden');
            closeAllCustomDropdowns();
            if (isClosed) {
                catPanel.classList.remove('hidden');
                if (catArrow) catArrow.classList.add('rotate-180');
                if (catBox) {
                    catBox.classList.remove('z-20');
                    catBox.classList.add('z-40');
                }
                if (filterContainer) {
                    filterContainer.classList.remove('z-30');
                    filterContainer.classList.add('z-40');
                }
            }
        });
    }

    if (distBtn) {
        distBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isClosed = distPanel.classList.contains('hidden');
            closeAllCustomDropdowns();
            if (isClosed) {
                distPanel.classList.remove('hidden');
                if (distArrow) distArrow.classList.add('rotate-180');
                if (distBox) {
                    distBox.classList.remove('z-10');
                    distBox.classList.add('z-40');
                }
                if (filterContainer) {
                    filterContainer.classList.remove('z-30');
                    filterContainer.classList.add('z-40');
                }
                if (distSearch) {
                    setTimeout(() => distSearch.focus(), 100);
                }
            }
        });
    }

    // Live search inside kecamatan dropdown
    if (distSearch) {
        distSearch.addEventListener('input', function() {
            const q = this.value.toLowerCase().trim();
            document.querySelectorAll('.dist-option-item').forEach(item => {
                const name = (item.getAttribute('data-name') || '').toLowerCase();
                if (name.includes(q)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Select Kategori
    window.selectKategori = function(val, label) {
        if (catSelect) catSelect.value = val;
        const labelEl = document.getElementById('cat-dropdown-label');
        if (labelEl) labelEl.textContent = label;

        document.querySelectorAll('.cat-option-item').forEach(item => {
            const itemVal = item.getAttribute('data-val');
            const check = item.querySelector('.check-icon');
            if (itemVal === val) {
                item.classList.add('bg-red-50', 'text-[#800000]');
                item.classList.remove('text-slate-700', 'hover:bg-slate-50');
                if (check) check.classList.remove('hidden');
            } else {
                item.classList.remove('bg-red-50', 'text-[#800000]');
                item.classList.add('text-slate-700', 'hover:bg-slate-50');
                if (check) check.classList.add('hidden');
            }
        });

        closeAllCustomDropdowns();
        clearTimeout(debounceTimer);
        triggerAutoFilter();
    };

    // Select Kecamatan
    window.selectKecamatan = function(val, label) {
        if (distSelect) distSelect.value = val;
        const labelEl = document.getElementById('dist-dropdown-label');
        if (labelEl) labelEl.textContent = label;

        document.querySelectorAll('.dist-option-item').forEach(item => {
            const itemVal = item.getAttribute('data-val');
            const check = item.querySelector('.check-icon');
            if (itemVal === val) {
                item.classList.add('bg-red-50', 'text-[#800000]');
                item.classList.remove('text-slate-700', 'hover:bg-slate-50');
                if (check) check.classList.remove('hidden');
            } else {
                item.classList.remove('bg-red-50', 'text-[#800000]');
                item.classList.add('text-slate-700', 'hover:bg-slate-50');
                if (check) check.classList.add('hidden');
            }
        });

        closeAllCustomDropdowns();
        clearTimeout(debounceTimer);
        triggerAutoFilter();
    };

    // Close when clicking outside or pressing Escape
    document.addEventListener('click', function(e) {
        const catBox = document.getElementById('cat-dropdown-container');
        const distBox = document.getElementById('dist-dropdown-container');
        if (catBox && !catBox.contains(e.target) && distBox && !distBox.contains(e.target)) {
            closeAllCustomDropdowns();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAllCustomDropdowns();
        }
    });

    // 4. Submit form (jika menekan Enter di kolom pencarian)
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            clearTimeout(debounceTimer);
            triggerAutoFilter();
        });
    }

    // 5. Intercept pagination agar navigasi halaman juga tetap mulus tanpa reload
    if (paginationContainer) {
        paginationContainer.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#')) return;

            e.preventDefault();
            gridContainer.classList.add('opacity-40', 'pointer-events-none', 'transition-opacity', 'duration-200');
            if (spinner) spinner.classList.remove('hidden');

            fetch(href, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newGrid = doc.getElementById('katalog-grid-container');
                const newPagination = doc.getElementById('katalog-pagination-container');

                if (newGrid && gridContainer) gridContainer.innerHTML = newGrid.innerHTML;
                if (paginationContainer) paginationContainer.innerHTML = newPagination ? newPagination.innerHTML : '';

                history.replaceState(null, '', href);

                const anchor = document.getElementById('katalog-anchor');
                if (anchor) anchor.scrollIntoView({ behavior: 'smooth' });
            })
            .catch(err => console.error('Pagination fetch error:', err))
            .finally(() => {
                if (gridContainer) gridContainer.classList.remove('opacity-40', 'pointer-events-none');
                if (spinner) spinner.classList.add('hidden');
            });
        });
    }
});
</script>

@endsection
