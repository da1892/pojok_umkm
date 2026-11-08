@extends('user.layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-5 sm:py-10">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        
        <!-- Hero Header with Integrated Live Search Bar -->
        <div class="bg-[#800000] rounded-2xl sm:rounded-3xl p-4 sm:p-8 md:p-10 text-white shadow-xl mb-5 sm:mb-8 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-red-600 rounded-full mix-blend-overlay filter blur-3xl opacity-50 pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 sm:gap-8">
                <div class="md:w-3/5">
                    <span class="inline-block bg-white text-[#800000] text-[9.5px] sm:text-xs font-bold px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full mb-1.5 sm:mb-3 uppercase tracking-wider">
                        Pusat Informasi & Kegiatan
                    </span>
                    <h1 class="text-xl sm:text-3xl md:text-4xl font-extrabold mb-1.5 sm:mb-3 leading-tight tracking-tight">
                        Berita & Kegiatan UMKM Wonogiri
                    </h1>
                    <p class="text-red-100 text-[11px] sm:text-sm md:text-base leading-relaxed max-w-xl">
                        Informasi terkini mengenai agenda pelatihan, fasilitasi perizinan, pameran produk, dan program pembinaan UMKM di Kabupaten Wonogiri.
                    </p>
                </div>
                
                <!-- Live Search Box (Otomatis Muncul saat Ketik Kata Kunci / Tanggal) -->
                <div class="w-full md:w-2/5">
                    <form id="news-search-form" action="{{ route('informasi') }}" method="GET" onsubmit="event.preventDefault(); triggerLiveNewsFilter();">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 pl-3 sm:pl-3.5 flex items-center pointer-events-none text-white/70">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            
                            <input type="text" 
                                   id="news-search-input"
                                   name="q" 
                                   value="{{ request('q') }}" 
                                   autocomplete="off"
                                   placeholder="Cari berita atau agenda kegiatan... (contoh: pelatihan, kurasi, pameran)" 
                                   class="w-full bg-white/20 backdrop-blur-xs border-2 border-white/40 search-input-padding pl-11 pr-16 sm:pr-20 py-2 sm:py-3 rounded-xl sm:rounded-2xl text-white placeholder-white/70 focus:outline-none focus:border-white focus:bg-white/25 focus:ring-4 focus:ring-white/20 text-xs sm:text-sm transition-all shadow-xs"
                                   style="padding-left: 2.75rem !important;">
                            
                            <!-- Spinner Loading saat Auto-Filter Memuat -->
                            <div id="news-search-spinner" class="hidden absolute inset-y-0 right-12 sm:right-14 pr-1 flex items-center pointer-events-none text-white">
                                <svg class="animate-spin w-3.5 h-3.5 sm:w-4 sm:h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                            </div>

                            <!-- Tombol Clear (X) saat Ada Teks -->
                            <button type="button" 
                                    id="news-clear-btn" 
                                    onclick="clearNewsSearch()" 
                                    class="{{ request('q') ? '' : 'hidden' }} absolute right-12 sm:right-14 inset-y-0 pr-1 flex items-center text-white/70 hover:text-white transition-colors cursor-pointer"
                                    title="Hapus pencarian">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>

                            <!-- Tombol Cari -->
                            <button type="submit" 
                                    class="absolute right-1.5 top-1/2 -translate-y-1/2 bg-white text-[#800000] hover:bg-red-50 text-[11px] sm:text-xs font-bold px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-lg sm:rounded-xl shadow-xs transition-all active:scale-95 cursor-pointer" 
                                    title="Cari">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Banner Info Hasil Pencarian Aktif (Dinamis & Halus) -->
        <div id="news-active-banner-container">
            @if(request('q'))
            <div class="mb-4 sm:mb-6 flex flex-wrap items-center justify-between gap-2.5 bg-red-50/80 p-3 sm:p-4 rounded-xl sm:rounded-2xl border border-red-200/80 shadow-2xs">
                <div class="flex items-center gap-2 text-xs sm:text-sm text-slate-800 flex-wrap">
                    <span class="text-slate-500">Hasil pencarian untuk:</span>
                    <span class="inline-flex items-center gap-1.5 bg-white text-[#800000] px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-lg sm:rounded-xl text-xs font-bold border border-red-200 shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        "{{ request('q') }}"
                    </span>
                    <span class="text-slate-500 font-semibold ml-1">({{ $newsList->total() }} berita ditemukan)</span>
                </div>
                <button type="button" 
                        onclick="clearNewsSearch()" 
                        class="text-[11px] sm:text-xs font-bold text-red-700 hover:text-red-900 inline-flex items-center gap-1 bg-white hover:bg-red-100 px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-lg sm:rounded-xl border border-red-200 transition-colors shadow-2xs cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span>Tampilkan Semua</span>
                </button>
            </div>
            @endif
        </div>

        <!-- News Grid Container (2 Kolom di Mobile, 3 Kolom di Layar Besar) -->
        <div id="news-grid-container">
            @if($newsList->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
                @foreach ($newsList as $item)
                @php
                    $itemImg = $item->image_path ? (str_starts_with($item->image_path, 'http') || str_starts_with($item->image_path, 'img/') ? asset($item->image_path) : asset('storage/' . $item->image_path)) : asset('img/news/bimtek.jpg');
                    $itemDateFormatted = $item->created_at ? $item->created_at->translatedFormat('d F Y') : '-';
                @endphp
                <div class="bg-white rounded-xl sm:rounded-2xl overflow-hidden shadow-2xs hover:shadow-lg border border-slate-200/90 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Gambar Berita -->
                        <div class="h-28 sm:h-52 w-full overflow-hidden bg-slate-100 relative">
                            <img src="{{ $itemImg }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @if($item->category)
                            <button type="button" 
                                    onclick="filterByNewsQuery('{{ $item->category }}')" 
                                    class="absolute top-1.5 left-1.5 sm:top-2.5 sm:left-2.5 px-2 py-0.5 rounded-md text-[8.5px] sm:text-[10px] font-bold bg-white/95 hover:bg-white backdrop-blur-xs text-[#800000] hover:text-red-900 shadow-xs transition-colors cursor-pointer truncate max-w-[110px] sm:max-w-[180px]" 
                                    title="Cari kategori {{ $item->category }}">
                                {{ $item->category }}
                            </button>
                            @endif
                        </div>

                        <!-- Konten Berita -->
                        <div class="p-2.5 sm:p-5">
                            @if($item->created_at)
                            <button type="button" 
                                    onclick="filterByNewsQuery('{{ $itemDateFormatted }}')" 
                                    class="text-[9.5px] sm:text-xs font-bold text-[#b91c1c] hover:underline mb-1 inline-flex items-center gap-1 transition-colors cursor-pointer" 
                                    title="Cari berita tanggal {{ $itemDateFormatted }}">
                                <svg class="w-3 h-3 text-[#b91c1c] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ $itemDateFormatted }}</span>
                            </button>
                            @else
                            <span class="text-[9.5px] sm:text-xs font-bold text-slate-400 mb-1 block">-</span>
                            @endif

                            <h3 class="text-xs sm:text-base font-bold text-slate-900 group-hover:text-[#800000] transition-colors leading-snug line-clamp-2 min-h-[2rem] sm:min-h-[2.8rem] mb-1">
                                <a href="{{ route('informasi.show', $item->id) }}">
                                    {{ $item->title }}
                                </a>
                            </h3>
                            <p class="text-[10px] sm:text-xs text-slate-500 leading-relaxed line-clamp-2 hidden sm:block">
                                {{ $item->excerpt ?: Str::limit(strip_tags($item->content), 95) }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer Kartu -->
                    <div class="px-2.5 pb-2.5 sm:px-5 sm:pb-4 pt-2 border-t border-slate-100 flex items-center justify-between text-[9.5px] sm:text-xs">
                        <span class="text-slate-400 font-medium truncate max-w-[65px] sm:max-w-none">Diskominfo Wonogiri</span>
                        <a href="{{ route('informasi.show', $item->id) }}" class="font-bold text-[#800000] hover:text-red-900 inline-flex items-center gap-0.5 group-hover:translate-x-0.5 transition-transform shrink-0">
                            <span>Baca</span>
                            <span class="hidden sm:inline">Lengkap</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="py-16 text-center bg-white rounded-2xl border border-slate-200 shadow-2xs">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2"></path></svg>
                </div>
                <h3 class="font-bold text-slate-700 text-base">Belum ada berita yang cocok</h3>
                <p class="text-xs text-slate-400 mt-1">Coba ubah kata kunci, atau klik tombol di bawah untuk lihat semua berita.</p>
                <div class="mt-4">
                    <button type="button" 
                            onclick="clearNewsSearch()" 
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#800000] text-white text-xs font-bold rounded-xl shadow-xs hover:bg-red-900 transition-colors cursor-pointer">
                        Lihat Semua Berita
                    </button>
                </div>
            </div>
            @endif
        </div>

        <!-- News Pagination Container (Responsif & Kompak) -->
        <div id="news-pagination-container" class="mt-8 mb-4">
            @if($newsList->hasPages())
            <div class="flex items-center justify-center gap-1.5 sm:gap-2 select-none">
                {{-- Previous --}}
                @if ($newsList->onFirstPage())
                    <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-slate-100 border border-slate-200 text-slate-300 flex items-center justify-center pointer-events-none opacity-40">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    </span>
                @else
                    <a href="{{ $newsList->previousPageUrl() }}" class="news-page-link w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 flex items-center justify-center transition-all shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    </a>
                @endif

                {{-- Page numbers --}}
                @foreach ($newsList->links()->elements[0] as $page => $url)
                    @if ($page == $newsList->currentPage())
                        <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg flex items-center justify-center text-xs sm:text-sm font-bold bg-[#800000] text-white shadow-xs cursor-default">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="news-page-link w-8 h-8 sm:w-9 sm:h-9 rounded-lg flex items-center justify-center text-xs sm:text-sm font-medium bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 shadow-2xs">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($newsList->hasMorePages())
                    <a href="{{ $newsList->nextPageUrl() }}" class="news-page-link w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 flex items-center justify-center transition-all shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                @else
                    <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-slate-100 border border-slate-200 text-slate-300 flex items-center justify-center pointer-events-none opacity-40">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </span>
                @endif
            </div>
            @endif
        </div>

    </div>
</div>

    </div>
</div>

<!-- Script Live Search Otomatis Saat Ketik Tanggal / Kata Kunci -->
<script>
    (function () {
        const searchInput = document.getElementById('news-search-input');
        const clearBtn = document.getElementById('news-clear-btn');
        const spinner = document.getElementById('news-search-spinner');
        const gridContainer = document.getElementById('news-grid-container');
        const paginationContainer = document.getElementById('news-pagination-container');
        const activeBannerContainer = document.getElementById('news-active-banner-container');

        let debounceTimer = null;
        let abortController = null;
        let lastQuery = searchInput ? searchInput.value.trim() : '';

        window.triggerLiveNewsFilter = function (customQuery = null) {
            if (!gridContainer) return;

            if (abortController) {
                abortController.abort();
            }
            abortController = new AbortController();

            const queryVal = (customQuery !== null) ? customQuery : (searchInput ? searchInput.value.trim() : '');
            
            if (searchInput && customQuery !== null) {
                searchInput.value = customQuery;
            }

            // Atur tombol clear
            if (clearBtn) {
                if (queryVal.length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }

            const params = new URLSearchParams();
            if (queryVal.length > 0) {
                params.set('q', queryVal);
            }

            const targetUrl = `{{ route('informasi') }}${params.toString() ? '?' + params.toString() : ''}`;

            // Efek visual saat memuat data
            gridContainer.classList.add('opacity-40', 'pointer-events-none', 'transition-opacity', 'duration-200');
            if (spinner) spinner.classList.remove('hidden');

            fetch(targetUrl, {
                signal: abortController.signal,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => {
                if (!res.ok) throw new Error('Gagal memuat berita');
                return res.text();
            })
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const newGrid = doc.getElementById('news-grid-container');
                const newPagination = doc.getElementById('news-pagination-container');
                const newBanner = doc.getElementById('news-active-banner-container');

                if (newGrid && gridContainer) {
                    gridContainer.innerHTML = newGrid.innerHTML;
                }
                if (newPagination && paginationContainer) {
                    paginationContainer.innerHTML = newPagination.innerHTML;
                }
                if (newBanner && activeBannerContainer) {
                    activeBannerContainer.innerHTML = newBanner.innerHTML;
                }

                history.replaceState(null, '', targetUrl);
                lastQuery = queryVal;
            })
            .catch(err => {
                if (err.name !== 'AbortError') {
                    console.error('Error saat live filter berita:', err);
                }
            })
            .finally(() => {
                if (gridContainer) gridContainer.classList.remove('opacity-40', 'pointer-events-none');
                if (spinner) spinner.classList.add('hidden');
            });
        };

        window.clearNewsSearch = function () {
            if (searchInput) searchInput.value = '';
            triggerLiveNewsFilter('');
        };

        window.filterByNewsQuery = function (text) {
            triggerLiveNewsFilter(text);
        };

        // Otomatis filter saat user mengetik kata kunci atau tanggal (debounce 280ms)
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                const val = this.value.trim();

                // Munculkan / sembunyikan tombol silang (X)
                if (clearBtn) {
                    if (val.length > 0) clearBtn.classList.remove('hidden');
                    else clearBtn.classList.add('hidden');
                }

                debounceTimer = setTimeout(() => {
                    if (val !== lastQuery) {
                        triggerLiveNewsFilter();
                    }
                }, 280);
            });
        }
        // Intercept klik pagination agar tidak refresh halaman
        if (paginationContainer) {
            paginationContainer.addEventListener('click', function (e) {
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
                    const newGrid = doc.getElementById('news-grid-container');
                    const newPagination = doc.getElementById('news-pagination-container');
                    const newBanner = doc.getElementById('news-active-banner-container');

                    if (newGrid && gridContainer) gridContainer.innerHTML = newGrid.innerHTML;
                    if (newPagination && paginationContainer) paginationContainer.innerHTML = newPagination.innerHTML;
                    if (newBanner && activeBannerContainer) activeBannerContainer.innerHTML = newBanner.innerHTML;

                    history.replaceState(null, '', href);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                })
                .catch(err => console.error('Pagination error:', err))
                .finally(() => {
                    if (gridContainer) gridContainer.classList.remove('opacity-40', 'pointer-events-none');
                    if (spinner) spinner.classList.add('hidden');
                });
            });
        }
    })();
</script>
@endsection
