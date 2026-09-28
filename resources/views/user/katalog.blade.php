@extends('layouts.app')

@section('content')

<!-- Hero Header Section with Dark Red Background & Wonogiri Overlay -->
<div class="relative w-full overflow-hidden text-white flex items-center justify-center text-center pt-28 pb-16 sm:pt-36 sm:pb-20"
     style="background: linear-gradient(rgba(120, 15, 15, 0.78), rgba(90, 10, 10, 0.88)), url('{{ asset('img/hero_wonogiri_3.jpg') }}') center 30% / cover no-repeat;">
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 reveal">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white mb-3.5 tracking-tight [text-shadow:_0_2px_10px_rgba(0,0,0,0.6)]">
            Produk Unggulan UMKM Wonogiri
        </h1>
        <p class="text-sm sm:text-base md:text-lg text-white/95 max-w-2xl mx-auto font-medium leading-relaxed [text-shadow:_0_1px_6px_rgba(0,0,0,0.6)]">
            Temukan aneka ragam produk lokal berkualitas tinggi hasil produksi langsung putra-putri Wonogiri.
        </p>
    </div>
</div>

<!-- Main Catalog Content on #FAF9F6 Background -->
<div style="background-color: #FAF9F6;" class="min-h-screen py-10 sm:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Search & Filter Card -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-4 shadow-xs border border-slate-200/80 mb-8 sm:mb-10 reveal delay-100">
            <form action="/katalog" method="GET" class="flex flex-col md:flex-row items-center gap-3 sm:gap-3.5">
                
                <!-- Search Input -->
                <div class="relative flex-1 w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk unggulan..." class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-[#991b1b] focus:ring-1 focus:ring-[#991b1b] text-slate-800 placeholder-slate-400">
                </div>

                <!-- Dropdown Kategori -->
                <div class="w-full md:w-56 shrink-0 relative">
                    <select name="kategori" class="w-full appearance-none pl-3.5 pr-8 py-2 text-xs sm:text-sm bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-[#991b1b] text-slate-700 font-medium cursor-pointer">
                        <option value="">Kategori: Semua</option>
                        <option value="makanan" {{ request('kategori') == 'makanan' ? 'selected' : '' }}>Makanan & Minuman</option>
                        <option value="kerajinan" {{ request('kategori') == 'kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                        <option value="batik" {{ request('kategori') == 'batik' ? 'selected' : '' }}>Batik/Fashion</option>
                        <option value="pertanian" {{ request('kategori') == 'pertanian' ? 'selected' : '' }}>Olahan Hasil Pertanian</option>
                        <option value="kreatif" {{ request('kategori') == 'kreatif' ? 'selected' : '' }}>Produk Kreatif</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </div>
                </div>

                <!-- Dropdown Kecamatan -->
                <div class="w-full md:w-56 shrink-0 relative">
                    <select name="kecamatan" class="w-full appearance-none pl-3.5 pr-8 py-2 text-xs sm:text-sm bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-[#991b1b] text-slate-700 font-medium cursor-pointer">
                        <option value="">Kecamatan: Semua</option>
                        <option value="wonogiri" {{ request('kecamatan') == 'wonogiri' ? 'selected' : '' }}>Kec. Wonogiri</option>
                        <option value="ngadirojo" {{ request('kecamatan') == 'ngadirojo' ? 'selected' : '' }}>Kec. Ngadirojo</option>
                        <option value="wuryantoro" {{ request('kecamatan') == 'wuryantoro' ? 'selected' : '' }}>Kec. Wuryantoro</option>
                        <option value="selogiri" {{ request('kecamatan') == 'selogiri' ? 'selected' : '' }}>Kec. Selogiri</option>
                        <option value="purwantoro" {{ request('kecamatan') == 'purwantoro' ? 'selected' : '' }}>Kec. Purwantoro</option>
                        <option value="bulukerto" {{ request('kecamatan') == 'bulukerto' ? 'selected' : '' }}>Kec. Bulukerto</option>
                        <option value="pracimantoro" {{ request('kecamatan') == 'pracimantoro' ? 'selected' : '' }}>Kec. Pracimantoro</option>
                        <option value="baturetno" {{ request('kecamatan') == 'baturetno' ? 'selected' : '' }}>Kec. Baturetno</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </div>
                </div>

                <!-- Tombol Terapkan -->
                <button type="submit" class="w-full md:w-auto px-6 py-2 bg-[#991b1b] hover:bg-[#801414] text-white text-xs sm:text-sm font-bold rounded-lg transition-colors shadow-2xs shrink-0">
                    Terapkan
                </button>
            </form>
        </div>

        @php
            $searchQuery = trim(request('q', ''));
            $categoryFilter = strtolower(trim(request('kategori', '')));
            $districtFilter = trim(request('kecamatan', ''));

            $query = \App\Models\User\Product::with('umkmProfile')->where('status', 'verified');

            if ($searchQuery !== '') {
                $query->where(function($q) use ($searchQuery) {
                    $q->where('name', 'like', "%{$searchQuery}%")
                      ->orWhereHas('umkmProfile', function($q2) use ($searchQuery) {
                          $q2->where('business_name', 'like', "%{$searchQuery}%")
                             ->orWhere('address', 'like', "%{$searchQuery}%");
                      });
                });
            }

            if ($categoryFilter !== '') {
                if ($categoryFilter === 'makanan') $query->where('category', 'like', '%makan%');
                elseif ($categoryFilter === 'kerajinan') $query->where('category', 'like', '%kerajin%');
                elseif ($categoryFilter === 'batik') $query->where('category', 'like', '%batik%');
                elseif ($categoryFilter === 'pertanian') $query->where('category', 'like', '%pertan%');
                elseif ($categoryFilter === 'kreatif') $query->where('category', 'like', '%kreatif%');
            }

            if ($districtFilter !== '') {
                $query->whereHas('umkmProfile', function($q) use ($districtFilter) {
                    $q->where('address', 'like', "%{$districtFilter}%");
                });
            }

            $products = $query->latest()->paginate(9)->withQueryString();
        @endphp

        <!-- Target Anchor for Smooth Scrolling -->
        <div id="katalog-anchor" class="scroll-mt-24"></div>

        <!-- Katalog Content Container -->
        <div id="katalog-grid-container" class="reveal delay-200">
            @if ($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
                @foreach ($products as $product)
                <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-2xs hover:shadow-md hover:border-red-100 transition-all duration-300 group flex flex-col justify-between">
                    <div>
                        <div class="h-52 sm:h-56 w-full overflow-hidden bg-slate-100 relative">
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-5 pb-0">
                            <span class="inline-block bg-red-50 text-[#991b1b] text-[11px] font-semibold px-2.5 py-0.5 rounded-md mb-2">
                                {{ $product->category }}
                            </span>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-[#991b1b] transition-colors leading-snug">
                                {{ $product->name }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-1">
                                oleh {{ $product->umkmProfile->business_name ?? 'UMKM Wonogiri' }}
                            </p>
                        </div>
                    </div>
                    <div class="p-5 pt-4">
                        <div class="flex items-center justify-between pt-3 border-t border-slate-100 text-xs">
                            <div class="flex items-center gap-1.5 text-slate-500 font-medium">
                                <svg class="w-3.5 h-3.5 text-[#991b1b] shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                                <span class="line-clamp-1 max-w-[120px]">{{ $product->umkmProfile->address ?? 'Wonogiri' }}</span>
                            </div>
                            <a href="{{ route('katalog.show', $product->id) }}" class="text-[#991b1b] font-bold hover:underline">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
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

        <!-- Pagination -->
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

<!-- Deleted Script -->

@endsection
