@extends('user.layouts.app')

@section('content')

<!-- Compact Hero Header Section -->
<div class="relative w-full overflow-hidden text-white flex items-center justify-center text-center pt-24 pb-8 sm:pt-28 sm:pb-10"
     style="background: linear-gradient(rgba(120, 15, 15, 0.9), rgba(70, 10, 10, 0.95)), url('{{ asset('img/hero_wonogiri_3.jpg') }}') center 30% / cover no-repeat;">
    <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-white/10 backdrop-blur-md border border-white/20 text-red-100 mb-2">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            Direktori Resmi UMKM Wonogiri
        </span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white mb-1.5 tracking-tight [text-shadow:_0_2px_8px_rgba(0,0,0,0.5)]">
            Katalog Direktori Pelaku Usaha
        </h1>
        <p class="text-xs sm:text-sm text-white/90 max-w-xl mx-auto leading-relaxed [text-shadow:_0_1px_4px_rgba(0,0,0,0.5)] mb-3">
            Temukan produk unggulan dan profil pelaku UMKM terdaftar di 25 kecamatan Kabupaten Wonogiri.
        </p>

        <!-- Compact Metrics Pills -->
        <div class="inline-flex items-center gap-3 px-3.5 py-1 rounded-full bg-black/30 backdrop-blur-sm border border-white/15 text-[11px] text-white/95">
            <span><strong class="text-amber-300">{{ \App\Models\User\UmkmProfile::where('status', 'verified')->count() }}</strong> UMKM</span>
            <span class="text-white/40">&bull;</span>
            <span><strong class="text-amber-300">{{ \App\Models\User\Product::where('status', 'verified')->count() }}</strong> Produk</span>
            <span class="text-white/40">&bull;</span>
            <span><strong>25</strong> Kecamatan</span>
        </div>
    </div>
</div>

<!-- Main Directory Content on Clean #FAF9F6 Background -->
<div style="background-color: #FAF9F6;" class="min-h-screen py-5 sm:py-7">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Compact Search & Filter Card -->
        <div class="bg-white rounded-xl p-2.5 sm:p-3 shadow-2xs border border-slate-200/80 mb-5">
            <form action="/direktori" method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 items-center">
                    <!-- Search Input (8 cols) -->
                    <div class="relative sm:col-span-8 w-full">
                        <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}" 
                               placeholder="Cari nama toko, pemilik, produk, atau alamat..." 
                               class="w-full pl-8 pr-3 py-1.5 text-xs bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-[#800000] focus:ring-1 focus:ring-[#800000] text-slate-800 placeholder-slate-400">
                    </div>

                    <!-- Dropdown Kecamatan & Tombol Cari (4 cols) -->
                    <div class="sm:col-span-4 flex items-center gap-1.5">
                        @php
                            $kecamatanList = [
                                'Baturetno', 'Batuwarno', 'Bulukerto', 'Eromoko', 'Girimarto', 
                                'Giritontro', 'Giriwoyo', 'Jatipurno', 'Jatiroto', 'Jatisrono', 
                                'Karangtengah', 'Kismantoro', 'Manyaran', 'Ngadirojo', 'Nguntoronadi', 
                                'Paranggupito', 'Pracimantoro', 'Puhpelem', 'Purwantoro', 'Selogiri', 
                                'Sidoharjo', 'Slogohimo', 'Tirtomoyo', 'Wonogiri', 'Wuryantoro'
                            ];
                        @endphp
                        <div class="relative flex-1">
                            <select name="kecamatan" class="w-full appearance-none pl-2.5 pr-7 py-1.5 text-xs bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-[#800000] text-slate-700 font-medium cursor-pointer">
                                <option value="">Semua Kecamatan</option>
                                @foreach($kecamatanList as $kec)
                                    <option value="{{ strtolower($kec) }}" {{ request('kecamatan') == strtolower($kec) ? 'selected' : '' }}>
                                        Kec. {{ $kec }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                            </div>
                        </div>

                        <button type="submit" class="px-3.5 py-1.5 bg-[#800000] hover:bg-red-900 text-white text-xs font-bold rounded-lg transition-all shadow-2xs shrink-0 flex items-center gap-1 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span>Filter</span>
                        </button>

                        @if(request()->filled('q') || request()->filled('kecamatan'))
                            <a href="/direktori" class="px-2 py-1.5 bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-700 rounded-lg transition-all text-xs font-bold border border-slate-200 shrink-0 flex items-center gap-1" title="Reset Filter">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                <span>Reset</span>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Toolbar Header with View Switcher -->
        <div id="direktori-anchor" class="scroll-mt-24 mb-3.5 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">Daftar Mitra UMKM</h2>
                <p class="text-xs text-slate-500">
                    Menampilkan <span class="font-bold text-slate-800">{{ $umkms->total() }}</span> UMKM aktif di Wonogiri
                    @if(request('kecamatan')) &bull; Kec. {{ ucfirst(request('kecamatan')) }} @endif
                </p>
            </div>

            <!-- View Toggle Buttons (Grid vs List) -->
            <div class="flex items-center gap-1 p-0.5 bg-white rounded-lg border border-slate-200/80 shadow-2xs">
                <button type="button" 
                        id="view-grid-btn" 
                        onclick="switchDirectoryView('grid')" 
                        class="px-2 py-1 rounded-md text-xs font-bold transition-all flex items-center gap-1 bg-[#800000] text-white shadow-xs cursor-pointer" 
                        title="Tampilan Grid">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Grid</span>
                </button>
                <button type="button" 
                        id="view-list-btn" 
                        onclick="switchDirectoryView('list')" 
                        class="px-2 py-1 rounded-md text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all flex items-center gap-1 cursor-pointer" 
                        title="Tampilan List">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <span>List</span>
                </button>
            </div>
        </div>

        @if ($umkms->count() > 0)

            <!-- 1. TAMPILAN GRID: 4 KOLOM KOMPAK, RAPI & ELEGAN -->
            <div id="directory-grid-view" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3.5 sm:gap-4">
                @foreach ($umkms as $item)
                    @php
                        $products = $item->products ?? collect();
                        $firstProduct = $products->whereNotNull('image_path')->first() ?? $products->first();
                        $productCount = $products->count();
                        $categoryName = $firstProduct ? $firstProduct->category : 'UMKM Wonogiri';
                    @endphp
                    <div class="bg-white rounded-xl overflow-hidden border border-slate-200/90 shadow-2xs hover:shadow-md hover:-translate-y-1 transition-all duration-200 flex flex-col group">
                        
                        <!-- Header Image Container (Compact 135px height) -->
                        <div class="relative w-full overflow-hidden bg-slate-100" style="height: 135px;">
                            @if($firstProduct && $firstProduct->image_path)
                                <img src="{{ asset('storage/' . $firstProduct->image_path) }}" 
                                     alt="{{ $item->business_name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-black/20"></div>
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-[#800000] via-[#991b1b] to-amber-700 flex flex-col items-center justify-center text-white relative">
                                    <div class="w-10 h-10 rounded-lg bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center font-black text-lg text-white shadow-inner mb-0.5">
                                        {{ strtoupper(substr($item->business_name, 0, 2)) }}
                                    </div>
                                    <span class="text-[9px] text-white/80 font-medium">UMKM Wonogiri</span>
                                </div>
                            @endif

                            <!-- Floating Badges Top Left & Right -->
                            <div class="absolute top-2 left-2">
                                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-white/95 backdrop-blur-md text-emerald-800 shadow-2xs border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Disetujui
                                </span>
                            </div>

                            <div class="absolute top-2 right-2">
                                <span class="px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-black/60 backdrop-blur-md text-white border border-white/20">
                                    {{ $productCount }} Produk
                                </span>
                            </div>

                            <!-- Bottom Left Category Pill overlay -->
                            <div class="absolute bottom-2 left-2">
                                <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-amber-400 text-slate-900 shadow-2xs line-clamp-1 max-w-[200px]">
                                    {{ $categoryName }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body Content (Compact) -->
                        <div class="p-3 flex-1 flex flex-col justify-between">
                            <div class="space-y-1.5">
                                <!-- Business Name -->
                                <h3 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#800000] transition-colors leading-snug line-clamp-1" title="{{ $item->business_name }}">
                                    <a href="{{ route('direktori.show', $item->id) }}">
                                        {{ $item->business_name }}
                                    </a>
                                </h3>

                                <!-- Owner and Location in One Compact Line -->
                                <div class="flex items-center justify-between text-[11px] text-slate-500 pb-1.5 border-b border-slate-100">
                                    <div class="flex items-center gap-1 font-medium text-slate-700 truncate max-w-[55%]">
                                        <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        <span class="truncate">{{ $item->owner_name }}</span>
                                    </div>
                                    <span class="font-bold text-[#800000] truncate text-right text-[10.5px]">
                                        Kec. {{ $item->district ?? 'Wonogiri' }}
                                    </span>
                                </div>

                                <!-- Address Subtext -->
                                <div class="flex items-start gap-1 text-[10.5px] text-slate-500">
                                    <svg class="w-3 h-3 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    <p class="truncate">{{ $item->address }}</p>
                                </div>

                                <!-- Description (2 lines clamp) -->
                                <p class="text-[10.5px] text-slate-500 leading-relaxed line-clamp-2">
                                    {{ $item->description ?? 'Pelaku usaha UMKM terdaftar resmi di Kabupaten Wonogiri dengan berbagai produk berkualitas.' }}
                                </p>

                                <!-- Mini Product Preview Thumbnails Strip -->
                                @if($products->count() > 0)
                                    <div class="pt-1.5 border-t border-slate-100 flex items-center justify-between">
                                        <span class="text-[9.5px] font-semibold text-slate-400 uppercase tracking-wider">Produk:</span>
                                        <div class="flex items-center gap-1">
                                            @foreach($products->take(3) as $prod)
                                                <div class="w-6 h-6 rounded-md overflow-hidden border border-slate-200 bg-slate-100 shrink-0" title="{{ $prod->name }}">
                                                    @if($prod->image_path)
                                                        <img src="{{ asset('storage/' . $prod->image_path) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full bg-slate-200 flex items-center justify-center text-[8px] text-slate-600 font-bold">{{ substr($prod->name, 0, 1) }}</div>
                                                    @endif
                                                </div>
                                            @endforeach
                                            @if($products->count() > 3)
                                                <span class="text-[8.5px] font-bold text-slate-500 bg-slate-100 px-1 py-0.5 rounded border border-slate-200">+{{ $products->count() - 3 }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Card Action Buttons (Compact) -->
                            <div class="mt-2.5 pt-2 border-t border-slate-100 flex items-center gap-1.5">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->phone) }}?text=Halo%20{{ urlencode($item->business_name) }},%20saya%20menemukan%20profil%20UMKM%20Anda%20di%20Pojok%20UMKM%20Wonogiri." 
                                   target="_blank" 
                                   class="inline-flex items-center justify-center gap-1 px-2 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 text-[11px] font-bold transition-all shadow-2xs"
                                   title="Hubungi via WhatsApp">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2z"/></svg>
                                    <span>WA</span>
                                </a>

                                <a href="{{ route('direktori.show', $item->id) }}" 
                                   class="flex-1 inline-flex items-center justify-center gap-1 px-2.5 py-1.5 bg-[#800000] hover:bg-red-900 text-white text-[11px] font-bold rounded-lg transition-all shadow-2xs hover:shadow-xs">
                                    <span>Detail Profil</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- 2. TAMPILAN LIST (HORIZONTAL KOMPAK & RAPI) -->
            <div id="directory-list-view" class="hidden flex-col gap-2.5">
                @foreach ($umkms as $item)
                    @php
                        $products = $item->products ?? collect();
                        $firstProduct = $products->whereNotNull('image_path')->first() ?? $products->first();
                        $productCount = $products->count();
                        $categoryName = $firstProduct ? $firstProduct->category : 'UMKM Wonogiri';
                    @endphp
                    <div class="bg-white rounded-xl p-3 border border-slate-200/90 shadow-2xs hover:shadow-sm transition-all duration-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 group">
                        
                        <!-- Left: Thumbnail & Details -->
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <!-- Monogram / Image Thumbnail (70px x 70px) -->
                            <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-lg overflow-hidden shrink-0 border border-slate-200/80 bg-slate-100 shadow-2xs relative" style="width: 70px; height: 70px;">
                                @if($firstProduct && $firstProduct->image_path)
                                    <img src="{{ asset('storage/' . $firstProduct->image_path) }}" 
                                         alt="{{ $item->business_name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#800000] to-red-800 flex items-center justify-center font-bold text-white text-sm">
                                        {{ strtoupper(substr($item->business_name, 0, 2)) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Text Details -->
                            <div class="min-w-0 flex-1 space-y-0.5">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#800000] transition-colors leading-snug">
                                        <a href="{{ route('direktori.show', $item->id) }}">
                                            {{ $item->business_name }}
                                        </a>
                                    </h3>
                                    <span class="inline-block px-1.5 py-0.2 rounded text-[9.5px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                        {{ $categoryName }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.2 rounded-full text-[9.5px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                                        Disetujui
                                    </span>
                                </div>
                                
                                <div class="flex flex-wrap items-center gap-x-2.5 gap-y-0.5 text-[11px] text-slate-500">
                                    <span class="font-medium text-slate-700 flex items-center gap-1">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        {{ $item->owner_name }}
                                    </span>
                                    <span>&bull;</span>
                                    <span class="font-bold text-[#800000]">Kec. {{ $item->district ?? 'Wonogiri' }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $productCount }} Produk</span>
                                </div>
                                
                                <p class="text-[11px] text-slate-500 line-clamp-1">
                                    {{ $item->address }}
                                </p>
                            </div>
                        </div>

                        <!-- Right: Action Buttons -->
                        <div class="flex items-center gap-1.5 shrink-0 w-full sm:w-auto justify-end pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->phone) }}?text=Halo%20{{ urlencode($item->business_name) }},%20saya%20menemukan%20profil%20UMKM%20Anda%20di%20Pojok%20UMKM%20Wonogiri." 
                               target="_blank" 
                               class="inline-flex items-center justify-center gap-1 px-2.5 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 text-xs font-bold rounded-lg transition-all shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2z"/></svg>
                                <span>WA</span>
                            </a>

                            <a href="{{ route('direktori.show', $item->id) }}" 
                               class="inline-flex items-center justify-center gap-1 px-3 py-1.5 bg-[#800000] hover:bg-red-900 text-white text-xs font-bold rounded-lg transition-all shadow-2xs hover:shadow-xs">
                                <span>Detail Profil</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

        @else
            <!-- Empty State -->
            <div class="py-12 text-center bg-white rounded-xl border border-slate-200/80 shadow-xs p-6 max-w-md mx-auto">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-[#800000] flex items-center justify-center mx-auto mb-3 border border-red-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <h3 class="text-slate-800 font-bold text-base mb-1">Tidak ada UMKM yang cocok</h3>
                <p class="text-slate-500 text-xs mb-4 leading-relaxed">
                    Tidak ditemukan data UMKM dengan filter ini. Silakan reset filter.
                </p>
                <a href="/direktori" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#800000] hover:bg-red-900 text-white text-xs font-bold transition-all shadow-xs">
                    Reset Filter
                </a>
            </div>
        @endif

        <!-- Pagination (Compact) -->
        @if ($umkms->hasPages())
        <div class="flex items-center justify-center gap-1.5 mt-7 mb-5 select-none">
            {{-- Tombol Previous (<) --}}
            @if ($umkms->onFirstPage())
                <span class="w-8 h-8 rounded-lg bg-slate-100 border border-slate-200 text-slate-300 flex items-center justify-center shadow-2xs pointer-events-none opacity-40">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                </span>
            @else
                <a href="{{ $umkms->previousPageUrl() }}#direktori-anchor" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 flex items-center justify-center transition-all shadow-2xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                </a>
            @endif

            {{-- Nomor Halaman --}}
            @foreach ($umkms->links()->elements[0] as $page => $url)
                @if ($page == $umkms->currentPage())
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-all text-xs font-bold bg-[#800000] text-white shadow-xs cursor-default">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}#direktori-anchor" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all text-xs font-medium bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 shadow-2xs">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Tombol Next (>) --}}
            @if ($umkms->hasMorePages())
                <a href="{{ $umkms->nextPageUrl() }}#direktori-anchor" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 flex items-center justify-center transition-all shadow-2xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
            @else
                <span class="w-8 h-8 rounded-lg bg-slate-100 border border-slate-200 text-slate-300 flex items-center justify-center shadow-2xs pointer-events-none opacity-40">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </span>
            @endif
        </div>
        @endif

    </div>
</div>

<script>
    function switchDirectoryView(mode) {
        const gridView = document.getElementById('directory-grid-view');
        const listView = document.getElementById('directory-list-view');
        const gridBtn = document.getElementById('view-grid-btn');
        const listBtn = document.getElementById('view-list-btn');

        if (!gridView || !listView) return;

        if (mode === 'list') {
            gridView.classList.add('hidden');
            listView.classList.remove('hidden');
            listView.classList.add('flex');

            listBtn.className = 'px-2 py-1 rounded-md text-xs font-bold transition-all flex items-center gap-1 bg-[#800000] text-white shadow-xs cursor-pointer';
            gridBtn.className = 'px-2 py-1 rounded-md text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all flex items-center gap-1 cursor-pointer';
            localStorage.setItem('umkm_directory_view', 'list');
        } else {
            listView.classList.add('hidden');
            listView.classList.remove('flex');
            gridView.classList.remove('hidden');

            gridBtn.className = 'px-2 py-1 rounded-md text-xs font-bold transition-all flex items-center gap-1 bg-[#800000] text-white shadow-xs cursor-pointer';
            listBtn.className = 'px-2 py-1 rounded-md text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all flex items-center gap-1 cursor-pointer';
            localStorage.setItem('umkm_directory_view', 'grid');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const savedView = localStorage.getItem('umkm_directory_view');
        if (savedView === 'list') {
            switchDirectoryView('list');
        }
    });
</script>

@endsection
