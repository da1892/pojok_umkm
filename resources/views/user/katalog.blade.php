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
            <form id="katalog-filter-form" action="/katalog" method="GET" class="flex flex-col md:flex-row items-center gap-3 sm:gap-3.5">
                
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
                           class="w-full pl-10 pr-10 py-2.5 text-xs sm:text-sm bg-white border-2 border-slate-300 rounded-xl focus:outline-none focus:border-[#991b1b] focus:ring-4 focus:ring-red-500/15 text-slate-900 placeholder:text-slate-400 shadow-xs transition-all">
                    
                    <!-- Subtle Spinner saat Auto-Filter Memuat -->
                    <div id="katalog-search-spinner" class="hidden absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-[#991b1b]">
                        <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Dropdown Kategori -->
                <div class="w-full md:w-56 shrink-0 relative">
                    <select id="katalog-category-select" name="kategori" class="w-full appearance-none pl-3.5 pr-8 py-2.5 text-xs sm:text-sm bg-white border-2 border-slate-300 rounded-xl focus:outline-none focus:border-[#991b1b] focus:ring-4 focus:ring-red-500/15 text-slate-900 font-medium cursor-pointer shadow-xs transition-all">
                        <option value="">Kategori: Semua</option>
                        <option value="makanan" {{ in_array(strtolower(request('kategori', '')), ['makanan', 'makanan & minuman']) ? 'selected' : '' }}>Makanan & Minuman</option>
                        <option value="kerajinan" {{ in_array(strtolower(request('kategori', '')), ['kerajinan', 'kerajinan tangan']) ? 'selected' : '' }}>Kerajinan</option>
                        <option value="batik" {{ in_array(strtolower(request('kategori', '')), ['batik', 'batik/fashion', 'fashion']) ? 'selected' : '' }}>Batik/Fashion</option>
                        <option value="pertanian" {{ in_array(strtolower(request('kategori', '')), ['pertanian', 'olahan hasil pertanian']) ? 'selected' : '' }}>Olahan Hasil Pertanian</option>
                        <option value="kreatif" {{ in_array(strtolower(request('kategori', '')), ['kreatif', 'produk kreatif']) ? 'selected' : '' }}>Produk Kreatif</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </div>
                </div>

                @php
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
                @endphp

                <!-- Dropdown Kecamatan (25 Kecamatan Resmi Wonogiri) -->
                <div class="w-full md:w-56 shrink-0 relative">
                    <select id="katalog-district-select" name="kecamatan" class="w-full appearance-none pl-3.5 pr-8 py-2.5 text-xs sm:text-sm bg-white border-2 border-slate-300 rounded-xl focus:outline-none focus:border-[#991b1b] focus:ring-4 focus:ring-red-500/15 text-slate-900 font-medium cursor-pointer shadow-xs transition-all">
                        <option value="">Kecamatan: Semua</option>
                        @foreach($kecamatanList as $kec)
                            @php
                                $kecVal = strtolower(trim($kec));
                                $isSelected = strtolower(trim(request('kecamatan', ''))) === $kecVal;
                            @endphp
                            <option value="{{ $kecVal }}" {{ $isSelected ? 'selected' : '' }}>
                                Kec. {{ $kec }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
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

                $products = $query->latest()->paginate(9)->withQueryString();
            }
        @endphp

        <!-- Target Anchor for Smooth Scrolling -->
        <div id="katalog-anchor" class="scroll-mt-24"></div>

        <!-- Katalog Content Container -->
        <div id="katalog-grid-container" class="reveal delay-200">
            @if ($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
                @foreach ($products as $product)
                <a href="{{ route('katalog.show', $product->id) }}" class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-sm hover:shadow-xl hover:-translate-y-1.5 hover:border-red-200 transition-all duration-300 group flex flex-col justify-between block cursor-pointer">
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
                            <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                @if(!empty($product->umkmProfile->image_path))
                                    <img src="{{ asset('storage/' . $product->umkmProfile->image_path) }}" alt="{{ $product->umkmProfile->business_name }}" class="w-4 h-4 rounded-full object-cover shrink-0 border border-slate-200">
                                @endif
                                <span class="truncate">oleh {{ $product->umkmProfile->business_name ?? 'UMKM Wonogiri' }}</span>
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
                            <span class="text-[#991b1b] font-bold group-hover:underline">
                                Lihat Detail
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

    // 2. Pilih salah satu kategori langsung otomatis terfilter
    if (catSelect) {
        catSelect.addEventListener('change', function() {
            clearTimeout(debounceTimer);
            triggerAutoFilter();
        });
    }

    // 3. Pilih salah satu kecamatan langsung otomatis terfilter
    if (distSelect) {
        distSelect.addEventListener('change', function() {
            clearTimeout(debounceTimer);
            triggerAutoFilter();
        });
    }

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
