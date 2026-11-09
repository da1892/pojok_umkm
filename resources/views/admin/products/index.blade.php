@extends('layouts.admin')

@section('page_title', 'Kelola Produk')

@section('content')
@php
    $districtCountsMap = [];
    foreach ($districtsWithCounts as $item) {
        $districtCountsMap[strtolower(trim($item->district))] = (int)$item->total_products;
    }
    $currentDistrict = trim(preg_replace('/^(Kec\.|Kecamatan)\s+/i', '', (string)request('district')));
    $currentCategory = request('category');
    $currentSearch = request('search');
    $currentFeatured = request('featured');
    $currentUmkmId = request('umkm_id');
    $currentUmkmFilter = request('umkm_filter');
    $hasActiveFilter = !empty($currentDistrict) || !empty($currentCategory) || !empty($currentSearch) || !empty($currentFeatured) || !empty($currentUmkmId) || !empty($currentUmkmFilter);
@endphp

<div class="space-y-6">
    <!-- Header Section with stats -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-50 to-red-100/80 text-[#800000] flex items-center justify-center border border-red-200/60 shadow-xs shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="font-extrabold text-slate-800 text-lg md:text-xl">Daftar Produk UMKM Wonogiri</h3>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-red-100 text-[#800000]">
                        Admin
                    </span>
                </div>
                <p class="text-slate-500 text-xs md:text-sm mt-0.5">Kelola dan telusuri katalog produk terkurasi berdasarkan sebaran wilayah kecamatan.</p>
            </div>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <div class="flex items-center gap-2 bg-slate-50 px-3.5 py-2 rounded-xl border border-slate-200/80">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <div class="text-xs">
                    <span class="text-slate-400 font-medium">Total Produk:</span>
                    <span class="font-extrabold text-slate-800 ml-1">{{ $totalAllProducts }}</span>
                </div>
            </div>

            <a href="{{ route('admin.products', ['featured' => request('featured') == '1' ? '' : '1']) }}" 
               class="flex items-center gap-2 {{ request('featured') == '1' ? 'bg-amber-100 border-amber-300 ring-2 ring-amber-400' : 'bg-amber-50/70 hover:bg-amber-100/80 border-amber-200/80' }} px-3.5 py-2 rounded-xl border transition-all shadow-2xs group" 
               title="{{ request('featured') == '1' ? 'Klik untuk tampilkan semua' : 'Klik untuk filter hanya Produk Unggulan' }}">
                <svg class="w-4 h-4 text-amber-500 fill-current group-hover:scale-110 transition-transform" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <div class="text-xs">
                    <span class="text-amber-800 font-medium">Produk Unggulan:</span>
                    <span class="font-extrabold text-amber-900 ml-1">{{ $totalFeaturedProducts }}</span>
                </div>
            </a>

            <a href="{{ route('admin.products', ['umkm_filter' => request('umkm_filter') === 'no_featured' ? '' : 'no_featured']) }}" 
               class="flex items-center gap-2 {{ request('umkm_filter') === 'no_featured' ? 'bg-indigo-100 border-indigo-300 ring-2 ring-indigo-400' : 'bg-indigo-50/70 hover:bg-indigo-100/80 border-indigo-200/80' }} px-3.5 py-2 rounded-xl border transition-all shadow-2xs group" 
               title="{{ request('umkm_filter') === 'no_featured' ? 'Klik untuk tampilkan semua' : 'Tampilkan produk dari UMKM yang belum memiliki produk unggulan' }}">
                <span class="text-xs">🎯</span>
                <div class="text-xs">
                    <span class="text-indigo-800 font-medium">UMKM Tanpa Unggulan</span>
                </div>
            </a>

            <div class="flex items-center gap-2 bg-red-50/60 px-3.5 py-2 rounded-xl border border-red-100">
                <svg class="w-4 h-4 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                <div class="text-xs">
                    <span class="text-slate-500 font-medium">Sentra Terdata:</span>
                    <span class="font-extrabold text-[#800000] ml-1">{{ $districtsWithCounts->where('total_products', '>', 0)->count() }} Kec.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Regional & Search Filter Section -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-5 space-y-4">
        <!-- Integrated Search & Filter Form -->
        <form method="GET" action="{{ route('admin.products') }}">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
                <!-- Search Keyword -->
                <div class="lg:col-span-5 relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama produk, nama UMKM, desa..." 
                           class="w-full search-input-padding pl-11 pr-4 py-2.5 text-xs md:text-sm rounded-xl border-2 border-slate-300 focus:outline-none focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 transition-all bg-white text-slate-900 placeholder:text-slate-400 shadow-xs"
                           style="padding-left: 2.75rem !important;">
                </div>

                <!-- Select Kecamatan (All 25 Wonogiri Districts) -->
                <div class="lg:col-span-3 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    </div>
                    <select name="district" 
                            class="w-full pl-9 pr-8 py-2.5 text-xs md:text-sm rounded-xl border-2 border-slate-300 focus:outline-none focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 transition-all bg-white text-slate-900 appearance-none cursor-pointer shadow-xs"
                            style="padding-left: 2.75rem !important;">
                        <option value="">Semua Kecamatan (25 Wilayah)</option>
                        @foreach($allKecamatanList as $kec)
                            @php
                                $kCount = $districtCountsMap[strtolower(trim($kec))] ?? 0;
                                $isSelected = !empty($currentDistrict) && strtolower($currentDistrict) === strtolower(trim($kec));
                            @endphp
                            <option value="{{ $kec }}" {{ $isSelected ? 'selected' : '' }}>
                                Kec. {{ $kec }} {{ $kCount > 0 ? "({$kCount} Produk)" : '(0 Produk)' }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <!-- Select Category -->
                <div class="lg:col-span-2 relative">
                    <select name="category" 
                            class="w-full px-3.5 py-2.5 text-xs md:text-sm rounded-xl border-2 border-slate-300 focus:outline-none focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 transition-all bg-white text-slate-900 appearance-none cursor-pointer shadow-xs">
                        <option value="">Semua Kategori</option>
                        @foreach($allCategories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="lg:col-span-2 flex items-center gap-2">
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-[#800000] hover:bg-[#600000] text-white text-xs font-bold transition-all shadow-xs active:scale-98">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <span>Filter</span>
                    </button>
                    @if($hasActiveFilter)
                    <a href="{{ route('admin.products') }}" 
                       class="inline-flex items-center justify-center p-2.5 rounded-xl bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-500 border border-slate-200 transition-colors shrink-0" 
                       title="Reset Filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Active Filter Indicator Banner -->
        @if($hasActiveFilter)
        <div class="bg-red-50/70 border border-red-100 rounded-xl p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-2 flex-wrap text-xs">
                <span class="font-bold text-[#800000] flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Menampilkan filter:
                </span>

                @if(!empty($currentDistrict))
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white border border-red-200 font-bold text-[#800000] shadow-2xs">
                    📍 Kec. {{ $currentDistrict }}
                    <a href="{{ route('admin.products', array_filter(['search' => $currentSearch, 'category' => $currentCategory])) }}" class="ml-1 text-red-400 hover:text-red-700">×</a>
                </span>
                @endif

                @if(!empty($currentCategory))
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white border border-red-200 font-bold text-[#800000] shadow-2xs">
                    🏷️ {{ $currentCategory }}
                    <a href="{{ route('admin.products', array_filter(['district' => $currentDistrict, 'search' => $currentSearch])) }}" class="ml-1 text-red-400 hover:text-red-700">×</a>
                </span>
                @endif

                @if(!empty($currentSearch))
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white border border-red-200 font-bold text-[#800000] shadow-2xs">
                    🔍 "{{ $currentSearch }}"
                    <a href="{{ route('admin.products', array_filter(['district' => $currentDistrict, 'category' => $currentCategory, 'featured' => $currentFeatured])) }}" class="ml-1 text-red-400 hover:text-red-700">×</a>
                </span>
                @endif

                @if($currentFeatured == '1')
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 border border-amber-200 font-bold text-amber-900 shadow-2xs">
                    ⭐ Hanya Produk Unggulan
                    <a href="{{ route('admin.products', array_filter(['district' => $currentDistrict, 'category' => $currentCategory, 'search' => $currentSearch, 'umkm_id' => $currentUmkmId, 'umkm_filter' => $currentUmkmFilter])) }}" class="ml-1 text-amber-500 hover:text-amber-800">×</a>
                </span>
                @endif

                @if(!empty($currentUmkmId))
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-red-50 border border-red-200 font-bold text-[#800000] shadow-2xs">
                    🏢 Filter Khusus 1 UMKM
                    <a href="{{ route('admin.products', array_filter(['district' => $currentDistrict, 'category' => $currentCategory, 'search' => $currentSearch, 'featured' => $currentFeatured, 'umkm_filter' => $currentUmkmFilter])) }}" class="ml-1 text-red-500 hover:text-red-800">×</a>
                </span>
                @endif

                @if($currentUmkmFilter === 'no_featured')
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-indigo-50 border border-indigo-200 font-bold text-indigo-900 shadow-2xs">
                    🎯 UMKM Belum Ada Unggulan
                    <a href="{{ route('admin.products', array_filter(['district' => $currentDistrict, 'category' => $currentCategory, 'search' => $currentSearch, 'featured' => $currentFeatured, 'umkm_id' => $currentUmkmId])) }}" class="ml-1 text-indigo-500 hover:text-indigo-800">×</a>
                </span>
                @endif

                <span class="text-slate-500 font-medium ml-1">
                    (Ditemukan <strong>{{ $products->total() }}</strong> produk)
                </span>
            </div>

            <a href="{{ route('admin.products') }}" class="text-xs font-bold text-red-700 hover:underline shrink-0">
                Hapus Semua Filter
            </a>
        </div>
        @endif
    </div>

    <!-- Products Table Card -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="px-4 py-3.5">Produk</th>
                        <th class="px-4 py-3.5">UMKM & Wilayah</th>
                        <th class="px-3 py-3.5">Kategori</th>
                        <th class="px-3 py-3.5 text-center whitespace-nowrap">Status</th>
                        <th class="px-3 py-3.5 text-center whitespace-nowrap">Produk Unggulan</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                        <!-- Product Info & Image (Bisa diklik untuk Preview) -->
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div onclick="openProductQuickViewById({{ $product->id }})" class="relative w-12 h-12 rounded-xl overflow-hidden bg-slate-100 border border-slate-200/80 shrink-0 group-hover:shadow-xs transition-all cursor-pointer hover:ring-2 hover:ring-[#800000]/40">
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" onerror="this.onerror=null; this.src='https://placehold.co/400x400/f1f5f9/94a3b8?text=Foto';" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @if(count($product->all_images) > 1)
                                    <span class="absolute bottom-0.5 right-0.5 px-1 py-0.2 rounded text-[8px] font-bold bg-black/70 text-white backdrop-blur-2xs">
                                        +{{ count($product->all_images) - 1 }}
                                    </span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <button type="button" onclick="openProductQuickViewById({{ $product->id }})" class="font-bold text-slate-800 text-xs sm:text-sm leading-snug group-hover:text-[#800000] hover:underline transition-colors truncate max-w-[170px] sm:max-w-[200px] lg:max-w-[240px] text-left cursor-pointer" title="{{ $product->name }}">
                                            {{ $product->name }}
                                        </button>
                                        @if($product->is_featured)
                                        <span class="inline-flex items-center gap-0.5 px-1.5 py-0.2 rounded-full text-[9px] font-extrabold bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-2xs shrink-0" title="Produk Unggulan Beranda">
                                            <svg class="w-2.5 h-2.5 text-yellow-200 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            Unggulan
                                        </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="text-xs font-extrabold text-[#800000]">
                                            Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                                        </span>
                                        @if(($product->price ?? 0) <= 0)
                                        <span class="text-[9px] px-1 rounded font-bold bg-amber-50 text-amber-700 border border-amber-200" title="Harga produk belum diisi atau Rp 0">⚠️ Rp 0</span>
                                        @endif
                                    </div>
                                    @if($product->description)
                                    <p class="text-[11px] text-slate-400 truncate max-w-[170px] sm:max-w-[200px] lg:max-w-[240px] mt-0.5">
                                        {{ Str::limit($product->description, 40) }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- UMKM and Clickable Region Badge + Status Unggulan UMKM -->
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.products', ['umkm_id' => $product->umkm_profile_id]) }}" 
                               class="font-bold text-slate-800 text-xs sm:text-sm truncate max-w-[160px] hover:text-[#800000] hover:underline block" 
                               title="Klik untuk filter hanya produk dari {{ $product->umkmProfile->business_name ?? 'UMKM' }}">
                                {{ $product->umkmProfile->business_name ?? '-' }}
                            </a>
                            
                            <!-- Indikator 1 UMKM 1 Unggulan -->
                            @if($product->is_featured)
                                <div class="mt-1">
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-200">
                                        ⭐ Unggulan UMKM Ini
                                    </span>
                                </div>
                            @elseif(!empty($featuredByUmkm[$product->umkm_profile_id]))
                                <div class="mt-1">
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-medium bg-amber-50 text-amber-800 border border-amber-200/70" title="UMKM ini sudah punya produk unggulan: {{ $featuredByUmkm[$product->umkm_profile_id] }}">
                                        ⭐ Ada: {{ Str::limit($featuredByUmkm[$product->umkm_profile_id], 14) }}
                                    </span>
                                </div>
                            @else
                                <div class="mt-1">
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                        ⚪ Belum ada unggulan
                                    </span>
                                </div>
                            @endif

                            @if(!empty($product->umkmProfile->district))
                            <div class="mt-1">
                                <a href="{{ route('admin.products', ['district' => $product->umkmProfile->district]) }}" 
                                   class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-red-50 text-[#800000] hover:bg-[#800000] hover:text-white transition-all border border-red-200/60 shadow-2xs group/badge truncate max-w-[160px]"
                                   title="Kec. {{ $product->umkmProfile->district }} @if(!empty($product->umkmProfile->village)) • Ds. {{ $product->umkmProfile->village }} @endif">
                                    <svg class="w-2.5 h-2.5 text-[#800000] group-hover/badge:text-white transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    <span class="truncate">Kec. {{ $product->umkmProfile->district }}</span>
                                    @if(!empty($product->umkmProfile->village))
                                    <span class="text-red-400 group-hover/badge:text-white/80 shrink-0">• Ds. {{ $product->umkmProfile->village }}</span>
                                    @endif
                                </a>
                            </div>
                            @else
                            <div class="text-[11px] text-slate-400 mt-0.5 italic">
                                Wilayah belum disetel
                            </div>
                            @endif
                        </td>

                        <!-- Category -->
                        <td class="px-3 py-3 whitespace-nowrap">
                            <a href="{{ route('admin.products', ['category' => $product->category]) }}" 
                               class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 hover:bg-red-50 text-slate-700 hover:text-[#800000] border border-slate-200/60 transition-colors"
                               title="Filter kategori {{ $product->category }}">
                                {{ $product->category }}
                            </a>
                        </td>

                        <!-- Status -->
                        <td class="px-3 py-3 text-center whitespace-nowrap">
                            @php
                                $statusInfo = match(strtolower($product->status ?? 'active')) {
                                    'verified', 'active' => [
                                        'label' => 'Disetujui',
                                        'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'dot' => 'bg-emerald-500'
                                    ],
                                    'pending' => [
                                        'label' => 'Menunggu Persetujuan',
                                        'class' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'dot' => 'bg-amber-500 animate-pulse'
                                    ],
                                    'rejected' => [
                                        'label' => 'Ditolak',
                                        'class' => 'bg-red-50 text-red-700 border-red-200',
                                        'dot' => 'bg-red-500'
                                    ],
                                    default => [
                                        'label' => 'Disetujui',
                                        'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'dot' => 'bg-emerald-500'
                                    ]
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $statusInfo['class'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $statusInfo['dot'] }}"></span>
                                {{ $statusInfo['label'] }}
                            </span>
                            @if($product->status == 'pending')
                                <div class="mt-1.5 flex items-center justify-center">
                                    <form action="{{ route('admin.product.verify', $product->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-2xs transition-colors cursor-pointer" title="Setujui Produk Ini agar tayang ke publik">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Setujui
                                        </button>
                                    </form>
                                </div>
                            @endif
                            @if($product->status == 'rejected' && !empty($product->rejection_note))
                                <div class="text-[10px] text-red-600 font-medium mt-1 max-w-[140px] truncate mx-auto" title="Alasan: {{ $product->rejection_note }}">
                                    Catatan: {{ $product->rejection_note }}
                                </div>
                            @endif
                        </td>

                        <!-- Produk Unggulan Toggle -->
                        <td class="px-3 py-3 text-center whitespace-nowrap">
                            <form action="{{ route('admin.product.toggle-featured', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                @if($product->is_featured)
                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white shadow-xs border border-amber-300 transition-all active:scale-95 cursor-pointer" title="Klik untuk membatalkan status Produk Unggulan">
                                        <svg class="w-3 h-3 text-yellow-200 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span>⭐ Unggulan</span>
                                    </button>
                                @else
                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 hover:bg-amber-50 text-slate-600 hover:text-amber-800 border border-slate-200 hover:border-amber-300 transition-all active:scale-95 cursor-pointer" title="{{ !empty($featuredByUmkm[$product->umkm_profile_id]) ? 'Akan menggantikan produk unggulan UMKM ini: ' . $featuredByUmkm[$product->umkm_profile_id] : 'Klik untuk jadikan Produk Unggulan (Tampil di Beranda)' }}">
                                        <svg class="w-3 h-3 text-slate-400 group-hover:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        <span>+ Unggulan</span>
                                    </button>
                                    @if(!empty($featuredByUmkm[$product->umkm_profile_id]))
                                    <span class="text-[9px] text-amber-700 block mt-0.5" title="Akan menggantikan '{{ $featuredByUmkm[$product->umkm_profile_id] }}'">
                                        Ganti '{{ Str::limit($featuredByUmkm[$product->umkm_profile_id], 10) }}'
                                    </span>
                                    @endif
                                @endif
                            </form>
                        </td>

                        <!-- Actions (Visual Icon Only, sama persis seperti di Data UMKM) -->
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Lihat Detail / Pratinjau Produk -->
                                <button type="button" 
                                        onclick="openProductQuickViewById({{ $product->id }})" 
                                        data-tooltip="Lihat Detail Produk" 
                                        title="Lihat Detail Produk"
                                        class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white border border-blue-200/80 flex items-center justify-center transition-all duration-200 shadow-2xs cursor-pointer">
                                    <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>

                                <!-- Edit Produk -->
                                <a href="{{ route('admin.product.edit', $product->id) }}" 
                                   data-tooltip="Edit Produk" 
                                   title="Edit Produk"
                                   class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white border border-amber-200/80 flex items-center justify-center transition-all duration-200 shadow-2xs">
                                    <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>

                                <!-- Hapus Produk -->
                                <button type="button" 
                                        onclick="confirmDeleteProduct('{{ $product->id }}', '{{ addslashes($product->name) }}')" 
                                        data-tooltip="Hapus Produk" 
                                        title="Hapus Produk"
                                        class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white border border-red-200/80 flex items-center justify-center transition-all duration-200 shadow-2xs cursor-pointer">
                                    <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                <form id="delete-product-form-{{ $product->id }}" action="{{ route('admin.product.destroy', $product->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center">
                                <div class="w-14 h-14 rounded-2xl bg-red-50 text-[#800000] flex items-center justify-center mb-3">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                </div>
                                <span class="font-extrabold text-base text-slate-700">
                                    @if(!empty($currentDistrict))
                                        Tidak Ada Produk di Kecamatan {{ $currentDistrict }}
                                    @elseif($hasActiveFilter)
                                        Tidak Ada Produk Sesuai Kriteria Filter
                                    @else
                                        Belum Ada Produk Terdaftar
                                    @endif
                                </span>
                                <span class="text-xs text-slate-400 mt-1 max-w-sm">
                                    @if(!empty($currentDistrict))
                                        Belum ada UMKM yang menambahkan produk terverifikasi di wilayah Kecamatan {{ $currentDistrict }}.
                                    @else
                                        Produk dari UMKM yang telah diverifikasi akan muncul di sini.
                                    @endif
                                </span>
                                @if($hasActiveFilter)
                                <div class="mt-4">
                                    <a href="{{ route('admin.products') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#800000] hover:bg-[#600000] transition-colors shadow-xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        Tampilkan Semua Produk
                                    </a>
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="p-4 border-t border-slate-200/80 bg-slate-50/50">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Quick View Modal Produk -->
<div id="product-quick-view-modal" 
     class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4" 
     onclick="if(event.target === this) closeProductQuickView()">
    <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100 transform transition-all my-8 max-h-[92vh] flex flex-col">
        <!-- Modal Header -->
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/60 shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-red-100 text-[#800000] flex items-center justify-center font-black">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-800">Pratinjau Kemenarikan Produk</h3>
                    <p class="text-xs text-slate-500">Evaluasi visual, kelayakan harga, dan kurasi produk unggulan (1 UMKM = 1 Unggulan)</p>
                </div>
            </div>
            <button type="button" onclick="closeProductQuickView()" class="w-8 h-8 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors flex items-center justify-center cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Modal Body (Scrollable) -->
        <div class="overflow-y-auto p-5 sm:p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Left Column: Gallery & Kurasi Admin -->
                <div class="md:col-span-5 space-y-3">
                    <!-- Main Image Preview Box -->
                    <div class="w-full aspect-square rounded-xl bg-slate-100 border border-slate-200/80 overflow-hidden relative shadow-inner flex items-center justify-center">
                        <img id="qv-main-img" src="" alt="Foto Produk" class="w-full h-full object-cover">
                        <div id="qv-empty-img" class="hidden flex-col items-center justify-center text-slate-400 p-4 text-center">
                            <svg class="w-12 h-12 mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-xs font-semibold">Tidak ada foto produk</span>
                        </div>
                    </div>

                    <!-- Thumbnails Strip -->
                    <div id="qv-gallery-strip" class="flex items-center gap-2 overflow-x-auto pb-1 pt-0.5"></div>

                    <!-- Tips Kurasi Admin Box -->
                    <div class="bg-amber-50/70 border border-amber-200/80 rounded-xl p-3 text-[11px] text-amber-900 space-y-1.5">
                        <div class="font-extrabold flex items-center gap-1.5 text-amber-950">
                            <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14H8a4 4 0 01-.9-7.898 4 4 0 017.8 0A4 4 0 0112 14z"/></svg>
                            <span>Panduan Kurasi Produk Menarik:</span>
                        </div>
                        <ul class="list-disc pl-4 space-y-0.5 text-slate-700">
                            <li>Foto cerah, tajam, dan tidak buram/pecah.</li>
                            <li>Harga realistis (bukan Rp 0).</li>
                            <li>Deskripsi menjelaskan keunggulan dan rasa/bahan.</li>
                            <li>Legalitas UMKM lengkap (NIB/P-IRT/Halal).</li>
                        </ul>
                    </div>
                </div>

                <!-- Right Column: Detail & UMKM Context -->
                <div class="md:col-span-7 space-y-4">
                    <!-- Badges -->
                    <div class="flex flex-wrap items-center gap-2">
                        <span id="qv-category-badge" class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-slate-100 text-slate-700 border border-slate-200"></span>
                        <span id="qv-status-badge"></span>
                    </div>

                    <!-- Title & Price -->
                    <div>
                        <h2 id="qv-product-name" class="text-lg sm:text-xl font-black text-slate-900 leading-snug"></h2>
                        <div class="mt-1 flex items-baseline gap-2">
                            <span id="qv-price" class="text-xl sm:text-2xl font-black text-[#800000]"></span>
                        </div>
                        <!-- Rp 0 warning banner -->
                        <div id="qv-zero-price-warning" class="hidden mt-2 p-2.5 rounded-lg bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span><strong>Perhatian:</strong> Harga produk masih Rp 0. Disarankan untuk diedit atau konfirmasi ke UMKM terkait sebelum diunggulkan.</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="border-t border-slate-100 pt-3">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Deskripsi Produk</h4>
                        <div id="qv-description" class="text-xs sm:text-sm text-slate-700 leading-relaxed max-h-36 overflow-y-auto pr-2 whitespace-pre-line bg-slate-50/60 p-3 rounded-xl border border-slate-100"></div>
                    </div>

                    <!-- UMKM Profile Card -->
                    <div class="bg-slate-50 rounded-xl p-3.5 border border-slate-200/80 space-y-2.5">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Produsen / UMKM</span>
                                <h4 id="qv-umkm-name" class="font-extrabold text-slate-800 text-sm"></h4>
                                <div id="qv-umkm-owner" class="text-xs text-slate-500 font-medium"></div>
                                <div id="qv-umkm-location" class="text-xs text-slate-600 font-semibold flex items-center gap-1 mt-0.5"></div>
                            </div>
                            <a id="qv-umkm-wa" href="#" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white transition-colors shrink-0 shadow-2xs" title="Hubungi via WhatsApp">
                                <span>💬 Chat WA</span>
                            </a>
                        </div>

                        <!-- Legalities Row -->
                        <div class="flex items-center gap-1.5 pt-1 border-t border-slate-200/60">
                            <span class="text-[10px] text-slate-400 font-bold mr-1">Legalitas:</span>
                            <span id="qv-legal-nib">NIB</span>
                            <span id="qv-legal-pirt">P-IRT</span>
                            <span id="qv-legal-halal">Halal</span>
                        </div>
                    </div>

                    <!-- 1 UMKM 1 Unggulan Notice Banner -->
                    <div id="qv-umkm-featured-box">
                        <div id="qv-umkm-featured-text" class="leading-relaxed"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/80 flex flex-wrap items-center justify-between gap-2 shrink-0">
            <button type="button" onclick="closeProductQuickView()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-800 hover:bg-slate-200/60 transition-colors cursor-pointer">
                Tutup
            </button>
            <div class="flex items-center gap-2">
                <a id="qv-edit-btn" href="#" class="inline-flex items-center gap-1 px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-[#800000] bg-white hover:bg-red-50 border border-slate-200 transition-colors shadow-2xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span>Edit Produk</span>
                </a>
                <form id="qv-toggle-form" action="" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button id="qv-toggle-btn" type="submit">
                        <!-- Populated by JS -->
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@php
    $qvProducts = [];
    foreach ($products as $p) {
        $primaryImg = $p->image_path
            ? (Str::startsWith($p->image_path, ['http://', 'https://']) ? $p->image_path : asset('storage/' . $p->image_path))
            : null;
        
        $gallery = [];
        if ($primaryImg) {
            $gallery[] = $primaryImg;
        }
        if (is_array($p->all_images)) {
            foreach ($p->all_images as $extraImg) {
                if ($extraImg) {
                    $extraUrl = Str::startsWith($extraImg, ['http://', 'https://']) ? $extraImg : asset('storage/' . $extraImg);
                    if (!in_array($extraUrl, $gallery)) {
                        $gallery[] = $extraUrl;
                    }
                }
            }
        }

        $umkm = $p->umkmProfile;
        $cleanPhone = $umkm && $umkm->phone ? preg_replace('/[^0-9]/', '', $umkm->phone) : '';
        if ($cleanPhone && Str::startsWith($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        $umkmFeaturedName = $umkm ? ($featuredByUmkm[$umkm->id] ?? null) : null;

        $qvProducts[$p->id] = [
            'id' => $p->id,
            'name' => $p->name,
            'category' => $p->category ?? 'Produk UMKM',
            'price' => (float)$p->price,
            'formatted_price' => 'Rp ' . number_format((float)$p->price, 0, ',', '.'),
            'description' => $p->description ?: 'Belum ada deskripsi untuk produk ini.',
            'status' => $p->status,
            'is_featured' => (bool)$p->is_featured,
            'primary_image' => $primaryImg,
            'gallery' => $gallery,
            'edit_url' => route('admin.product.edit', $p->id),
            'toggle_url' => route('admin.product.toggle-featured', $p->id),
            'umkm' => [
                'id' => $umkm ? $umkm->id : null,
                'name' => $umkm ? $umkm->business_name : 'UMKM Tidak Diketahui',
                'owner' => $umkm ? $umkm->owner_name : '-',
                'district' => $umkm ? $umkm->district : '-',
                'village' => $umkm ? $umkm->village : '-',
                'phone' => $umkm ? $umkm->phone : null,
                'phone_wa' => $cleanPhone,
                'has_nib' => $umkm && !empty($umkm->nib),
                'has_pirt' => $umkm && !empty($umkm->pirt_number),
                'has_halal' => $umkm && !empty($umkm->halal_certificate_path),
                'featured_product_name' => $umkmFeaturedName,
            ]
        ];
    }
@endphp

<script>
    const qvProductsData = @json($qvProducts);

    function openProductQuickViewById(id) {
        const prod = qvProductsData[id];
        if (!prod) return;

        // Populate fields
        document.getElementById('qv-product-name').textContent = prod.name;
        document.getElementById('qv-category-badge').textContent = prod.category;
        document.getElementById('qv-price').textContent = prod.formatted_price;
        document.getElementById('qv-description').textContent = prod.description;

        // Zero price warning
        const zeroPriceNotice = document.getElementById('qv-zero-price-warning');
        if (prod.price <= 0) {
            zeroPriceNotice.classList.remove('hidden');
        } else {
            zeroPriceNotice.classList.add('hidden');
        }

        // Status badge
        const statusBadge = document.getElementById('qv-status-badge');
        if (prod.status === 'approved') {
            statusBadge.className = 'px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200';
            statusBadge.textContent = 'Disetujui';
        } else if (prod.status === 'pending') {
            statusBadge.className = 'px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200';
            statusBadge.textContent = 'Menunggu Verifikasi';
        } else {
            statusBadge.className = 'px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-50 text-red-700 border border-red-200';
            statusBadge.textContent = 'Ditolak';
        }

        // Gallery & main image
        const mainImg = document.getElementById('qv-main-img');
        const emptyImg = document.getElementById('qv-empty-img');
        const galleryContainer = document.getElementById('qv-gallery-strip');
        galleryContainer.innerHTML = '';

        if (prod.gallery && prod.gallery.length > 0) {
            mainImg.src = prod.gallery[0];
            mainImg.classList.remove('hidden');
            emptyImg.classList.add('hidden');

            prod.gallery.forEach((url, idx) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'w-12 h-12 rounded-lg overflow-hidden border-2 shrink-0 transition-all cursor-pointer ' + (idx === 0 ? 'border-[#800000] ring-2 ring-red-200' : 'border-slate-200 opacity-70 hover:opacity-100');
                btn.innerHTML = `<img src="${url}" class="w-full h-full object-cover">`;
                btn.onclick = () => {
                    mainImg.src = url;
                    galleryContainer.querySelectorAll('button').forEach(b => {
                        b.className = 'w-12 h-12 rounded-lg overflow-hidden border-2 shrink-0 transition-all cursor-pointer border-slate-200 opacity-70 hover:opacity-100';
                    });
                    btn.className = 'w-12 h-12 rounded-lg overflow-hidden border-2 shrink-0 transition-all cursor-pointer border-[#800000] ring-2 ring-red-200';
                };
                galleryContainer.appendChild(btn);
            });
            galleryContainer.classList.remove('hidden');
        } else {
            mainImg.classList.add('hidden');
            emptyImg.classList.remove('hidden');
            galleryContainer.classList.add('hidden');
        }

        // UMKM info
        document.getElementById('qv-umkm-name').textContent = prod.umkm.name;
        document.getElementById('qv-umkm-owner').textContent = 'Pemilik: ' + prod.umkm.owner;
        document.getElementById('qv-umkm-location').textContent = 'Kec. ' + prod.umkm.district + ', Ds. ' + prod.umkm.village;
        
        const waLink = document.getElementById('qv-umkm-wa');
        if (prod.umkm.phone_wa) {
            waLink.href = 'https://wa.me/' + prod.umkm.phone_wa;
            waLink.classList.remove('hidden');
        } else {
            waLink.classList.add('hidden');
        }

        // Legalities
        document.getElementById('qv-legal-nib').className = prod.umkm.has_nib ? 'px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800' : 'px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-400';
        document.getElementById('qv-legal-pirt').className = prod.umkm.has_pirt ? 'px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800' : 'px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-400';
        document.getElementById('qv-legal-halal').className = prod.umkm.has_halal ? 'px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800' : 'px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-400';

        // 1 UMKM 1 Unggulan notice
        const featuredNoticeBox = document.getElementById('qv-umkm-featured-box');
        const featuredNoticeText = document.getElementById('qv-umkm-featured-text');

        if (prod.is_featured) {
            featuredNoticeBox.className = 'p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-start gap-2';
            featuredNoticeText.innerHTML = '<span class="font-bold">⭐ Produk Unggulan Aktif:</span> Produk ini merupakan 1 wakil produk unggulan terpilih dari UMKM ini di beranda publik.';
        } else if (prod.umkm.featured_product_name) {
            featuredNoticeBox.className = 'p-3 rounded-xl bg-amber-50/80 border border-amber-300 text-amber-950 text-xs flex items-start gap-2';
            featuredNoticeText.innerHTML = `<span class="font-bold">⚠️ Perhatian 1 UMKM 1 Unggulan:</span> UMKM ini sudah memiliki produk unggulan lain yaitu <strong>"${prod.umkm.featured_product_name}"</strong>. Jika Anda menjadikan produk ini unggulan, produk lama tersebut akan digantikan secara otomatis.`;
        } else {
            featuredNoticeBox.className = 'p-3 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 text-xs flex items-start gap-2';
            featuredNoticeText.innerHTML = '<span class="font-bold">⚪ Belum Ada Unggulan:</span> UMKM ini belum memiliki produk unggulan aktif. Menjadikan produk ini unggulan akan menjadikannya wakil UMKM ini di beranda.';
        }

        // Action URLs
        document.getElementById('qv-edit-btn').href = prod.edit_url;

        const toggleForm = document.getElementById('qv-toggle-form');
        toggleForm.action = prod.toggle_url;

        const toggleBtn = document.getElementById('qv-toggle-btn');
        if (prod.is_featured) {
            toggleBtn.className = 'inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-amber-800 bg-amber-100 hover:bg-amber-200 border border-amber-300 transition-colors shadow-2xs cursor-pointer';
            toggleBtn.innerHTML = '<svg class="w-4 h-4 fill-amber-500 text-amber-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> Batalkan Unggulan';
        } else {
            toggleBtn.className = 'inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 shadow-2xs transition-colors cursor-pointer';
            toggleBtn.innerHTML = '<svg class="w-4 h-4 text-white fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> ' + (prod.umkm.featured_product_name ? 'Ganti & Jadikan Unggulan' : 'Jadikan Produk Unggulan');
        }

        // Show modal
        const modal = document.getElementById('product-quick-view-modal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeProductQuickView() {
        const modal = document.getElementById('product-quick-view-modal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeProductQuickView();
        }
    });
</script>
@endsection
