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
    $hasActiveFilter = !empty($currentDistrict) || !empty($currentCategory) || !empty($currentSearch);
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
                           class="w-full pl-10 pr-4 py-2.5 text-xs md:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-[#800000] focus:ring-2 focus:ring-red-100 transition-all bg-slate-50/50 hover:bg-white">
                </div>

                <!-- Select Kecamatan (All 25 Wonogiri Districts) -->
                <div class="lg:col-span-3 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    </div>
                    <select name="district" 
                            class="w-full pl-9 pr-8 py-2.5 text-xs md:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-[#800000] focus:ring-2 focus:ring-red-100 transition-all bg-slate-50/50 hover:bg-white text-slate-700 appearance-none cursor-pointer">
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
                            class="w-full px-3.5 py-2.5 text-xs md:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-[#800000] focus:ring-2 focus:ring-red-100 transition-all bg-slate-50/50 hover:bg-white text-slate-700 appearance-none cursor-pointer">
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
                    <a href="{{ route('admin.products', array_filter(['district' => $currentDistrict, 'category' => $currentCategory])) }}" class="ml-1 text-red-400 hover:text-red-700">×</a>
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
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">UMKM & Wilayah (Kecamatan)</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                        <!-- Product Info & Image -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3.5">
                                <div class="relative w-14 h-14 rounded-xl overflow-hidden bg-slate-100 border border-slate-200/80 shrink-0 group-hover:shadow-xs transition-shadow">
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @if(count($product->all_images) > 1)
                                    <span class="absolute bottom-1 right-1 px-1 py-0.2 rounded text-[8px] font-bold bg-black/70 text-white backdrop-blur-2xs">
                                        +{{ count($product->all_images) - 1 }}
                                    </span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-800 text-sm leading-snug group-hover:text-[#800000] transition-colors truncate max-w-xs md:max-w-md">
                                        {{ $product->name }}
                                    </p>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-xs font-extrabold text-[#800000]">
                                            Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-400 truncate max-w-xs mt-0.5">
                                        {{ Str::limit($product->description, 50) }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <!-- UMKM and Clickable Region Badge -->
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800 text-sm">
                                {{ $product->umkmProfile->business_name ?? '-' }}
                            </div>
                            @if(!empty($product->umkmProfile->district))
                            <div class="mt-1">
                                <a href="{{ route('admin.products', ['district' => $product->umkmProfile->district]) }}" 
                                   class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-50 text-[#800000] hover:bg-[#800000] hover:text-white transition-all border border-red-200/60 shadow-2xs group/badge"
                                   title="Klik untuk melihat semua produk dari Kec. {{ $product->umkmProfile->district }}">
                                    <svg class="w-3 h-3 text-[#800000] group-hover/badge:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    <span>Kec. {{ $product->umkmProfile->district }}</span>
                                    @if(!empty($product->umkmProfile->village))
                                    <span class="text-red-400 group-hover/badge:text-white/80">• Ds. {{ $product->umkmProfile->village }}</span>
                                    @endif
                                </a>
                            </div>
                            @else
                            <div class="text-xs text-slate-400 mt-1 italic">
                                Wilayah belum disetel
                            </div>
                            @endif
                        </td>

                        <!-- Category -->
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.products', ['category' => $product->category]) }}" 
                               class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-red-50 text-slate-700 hover:text-[#800000] border border-slate-200/60 transition-colors"
                               title="Filter kategori {{ $product->category }}">
                                {{ $product->category }}
                            </a>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 text-center">
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
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $statusInfo['class'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $statusInfo['dot'] }}"></span>
                                {{ $statusInfo['label'] }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.product.edit', $product->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-slate-700 hover:text-[#800000] bg-slate-100 hover:bg-red-50 rounded-lg transition-colors border border-slate-200/60" title="Edit Produk">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold text-red-600 hover:text-white hover:bg-red-600 rounded-lg transition-colors border border-red-200" title="Hapus Produk">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
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
@endsection
