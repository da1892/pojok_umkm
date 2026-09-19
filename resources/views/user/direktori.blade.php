@extends('layouts.app')

@section('content')

<!-- Hero Header Section with Dark Red Background & Wonogiri Overlay -->
<div class="relative w-full overflow-hidden text-white flex items-center justify-center text-center pt-28 pb-16 sm:pt-36 sm:pb-20"
     style="background: linear-gradient(rgba(120, 15, 15, 0.82), rgba(90, 10, 10, 0.90)), url('{{ asset('img/hero_wonogiri_3.jpg') }}') center 30% / cover no-repeat;">
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 reveal">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white mb-3.5 tracking-tight [text-shadow:_0_2px_10px_rgba(0,0,0,0.6)]">
            Direktori UMKM Wonogiri
        </h1>
        <p class="text-sm sm:text-base md:text-lg text-white/95 max-w-2xl mx-auto font-medium leading-relaxed [text-shadow:_0_1px_6px_rgba(0,0,0,0.6)]">
            Telusuri ratusan basis data pelaku usaha mikro, kecil, dan menengah terdaftar resmi di Kabupaten Wonogiri.
        </p>
    </div>
</div>

<!-- Main Directory Content on #FAF9F6 Background -->
<div style="background-color: #FAF9F6;" class="min-h-screen py-10 sm:py-14">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Search & Filter Bar Card matching Figma -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-4 shadow-xs border border-slate-200/80 mb-8 sm:mb-10 reveal delay-100">
            <form action="/direktori" method="GET" class="flex flex-col md:flex-row items-center gap-3 sm:gap-3.5">
                
                <!-- Search Input -->
                <div class="relative flex-1 w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}" 
                           placeholder="Cari berdasarkan nama UMKM, produk, atau alamat..." 
                           class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-[#991b1b] focus:ring-1 focus:ring-[#991b1b] text-slate-800 placeholder-slate-400">
                </div>

                <!-- Dropdown Kategori Usaha -->
                <div class="w-full md:w-56 shrink-0 relative">
                    <select name="kategori" class="w-full appearance-none pl-3.5 pr-8 py-2 text-xs sm:text-sm bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-[#991b1b] text-slate-700 font-medium cursor-pointer">
                        <option value="">Kategori Usaha</option>
                        <option value="makanan" {{ request('kategori') == 'makanan' ? 'selected' : '' }}>Makanan & Minuman</option>
                        <option value="batik" {{ request('kategori') == 'batik' ? 'selected' : '' }}>Batik/Fashion</option>
                        <option value="kerajinan" {{ request('kategori') == 'kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                        <option value="pertanian" {{ request('kategori') == 'pertanian' ? 'selected' : '' }}>Olahan Hasil Pertanian</option>
                        <option value="kreatif" {{ request('kategori') == 'kreatif' ? 'selected' : '' }}>Produk Kreatif</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </div>
                </div>

                <!-- Tombol Cari Direktori -->
                <button type="submit" class="w-full md:w-auto px-6 py-2 bg-[#991b1b] hover:bg-[#801414] text-white text-xs sm:text-sm font-bold rounded-lg transition-colors shadow-2xs shrink-0">
                    Cari Direktori
                </button>
            </form>
        </div>

        <!-- Directory Data Setup: 4 UMKM on Page 1 from Figma -->
        @php
            $page1Umkm = [
                [
                    'id' => 1,
                    'name' => 'UD Sari Rasa',
                    'category' => 'Makanan & Minuman',
                    'owner' => 'Ibu Hartini',
                    'products' => 'Keripik Singkong, Keripik Pisang',
                    'location' => 'Desa Kaliancar, Kec. Selogiri',
                    'phone' => '6281234567890',
                    'image' => asset('img/umkm/sari_rasa.jpg')
                ],
                [
                    'id' => 2,
                    'name' => 'Griya Batik Sekar Arum',
                    'category' => 'Batik/Fashion',
                    'owner' => 'Bapak Widodo',
                    'products' => 'Batik Tulis Wonogiren, Selendang',
                    'location' => 'Kel. Giritirto, Kec. Wonogiri',
                    'phone' => '6281234567891',
                    'image' => asset('img/umkm/batik_sekar_arum.jpg')
                ],
                [
                    'id' => 3,
                    'name' => 'Kriya Mandiri Sejahtera',
                    'category' => 'Kerajinan',
                    'owner' => 'Ibu Sri Wahyuni',
                    'products' => 'Kerajinan Rotan, Anyaman Bambu',
                    'location' => 'Desa Gumiwang, Kec. Wuryantoro',
                    'phone' => '6281234567892',
                    'image' => asset('img/umkm/kriya_mandiri.jpg')
                ],
                [
                    'id' => 4,
                    'name' => 'Maju Tani Agro',
                    'category' => 'Olahan Hasil Pertanian',
                    'owner' => 'Bapak Handoko',
                    'products' => 'Minyak Atsiri, Susu Jahe Merah',
                    'location' => 'Desa Conto, Kec. Bulukerto',
                    'phone' => '6281234567893',
                    'image' => asset('img/umkm/maju_tani.jpg')
                ]
            ];

            // Filter data
            $searchQuery = strtolower(trim(request('q', '')));
            $categoryFilter = strtolower(trim(request('kategori', '')));

            $filteredUmkm = array_filter($page1Umkm, function($item) use ($searchQuery, $categoryFilter) {
                if ($searchQuery !== '') {
                    $haystack = strtolower($item['name'] . ' ' . $item['owner'] . ' ' . $item['products'] . ' ' . $item['location']);
                    if (strpos($haystack, $searchQuery) === false) {
                        return false;
                    }
                }

                if ($categoryFilter !== '') {
                    $cat = strtolower($item['category']);
                    if ($categoryFilter === 'makanan' && strpos($cat, 'makan') === false) return false;
                    if ($categoryFilter === 'batik' && strpos($cat, 'batik') === false) return false;
                    if ($categoryFilter === 'kerajinan' && strpos($cat, 'kerajinan') === false) return false;
                    if ($categoryFilter === 'pertanian' && strpos($cat, 'pertanian') === false) return false;
                    if ($categoryFilter === 'kreatif' && strpos($cat, 'kreatif') === false) return false;
                }

                return true;
            });

            $currentPage = (int) request('page', 1);
            if ($currentPage < 1) $currentPage = 1;
            if ($currentPage > 2) $currentPage = 2;
        @endphp

        <!-- Target Anchor for Smooth Scrolling -->
        <div id="direktori-anchor" class="scroll-mt-24"></div>

        <!-- UMKM List Cards Container -->
        <div id="direktori-list-container" class="reveal delay-200">
            
            {{-- HALAMAN 1 (Berisi 4 Profil UMKM Sesuai Figma) --}}
            <div id="umkm-page-1" class="umkm-page-group {{ $currentPage == 1 ? '' : 'hidden' }}">
                @if (count($filteredUmkm) > 0)
                <div class="flex flex-col gap-4 sm:gap-4.5">
                    @foreach ($filteredUmkm as $item)
                    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-2xs hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-5">
                        
                        <!-- Left: Thumbnail & Details -->
                        <div class="flex items-center gap-3.5 sm:gap-4 flex-1 min-w-0">
                            <!-- Thumbnail Image -->
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden shrink-0 border border-slate-100 bg-slate-100 shadow-2xs">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                            </div>

                            <!-- Information -->
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                                        {{ $item['name'] }}
                                    </h3>
                                    <span class="inline-block px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-[#eff6ff] text-[#1d4ed8] border border-blue-100">
                                        {{ $item['category'] }}
                                    </span>
                                </div>
                                
                                <p class="text-xs text-slate-500 line-clamp-1">
                                    Pemilik: <span class="text-slate-700 font-medium">{{ $item['owner'] }}</span> <span class="text-slate-300 mx-1">|</span> Produk Utama: <span class="text-slate-700 font-medium">{{ $item['products'] }}</span>
                                </p>
                                
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1.5">
                                    <svg class="w-3.5 h-3.5 text-[#991b1b] shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="truncate">{{ $item['location'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Action Buttons -->
                        <div class="flex items-center gap-2 sm:gap-2.5 shrink-0 w-full sm:w-auto justify-end pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                            <a href="https://wa.me/{{ $item['phone'] }}?text=Halo%20{{ urlencode($item['name']) }},%20saya%20menemukan%20profil%20UMKM%20Anda%20di%20Pojok%20UMKM%20Wonogiri." 
                               target="_blank" 
                               class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 px-3.5 sm:px-4 py-2 bg-white border border-[#991b1b] text-[#991b1b] hover:bg-red-50 text-xs sm:text-sm font-semibold rounded-lg transition-colors shadow-2xs">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                                </svg>
                                <span>Hubungi UMKM</span>
                            </a>

                            <a href="/direktori" 
                               class="flex-1 sm:flex-initial inline-flex items-center justify-center px-4 sm:px-5 py-2 bg-[#991b1b] hover:bg-[#801414] text-white text-xs sm:text-sm font-bold rounded-lg transition-colors shadow-2xs">
                                Detail Profil
                            </a>
                        </div>

                    </div>
                    @endforeach
                </div>
                @else
                <div class="py-16 text-center bg-white rounded-2xl border border-slate-200">
                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    <p class="text-slate-600 font-semibold text-base mb-1">Tidak ada UMKM yang cocok</p>
                    <p class="text-slate-400 text-xs sm:text-sm mb-4">Coba cari dengan kata kunci lain atau pilih semua kategori usaha.</p>
                    <a href="/direktori" class="inline-flex items-center px-4 py-2 rounded-lg bg-[#991b1b] text-white text-xs font-bold hover:bg-[#801414] transition-colors">
                        Reset Filter
                    </a>
                </div>
                @endif
            </div>

            {{-- HALAMAN 2 (Kosong / Tidak Ada UMKM) --}}
            <div id="umkm-page-2" class="umkm-page-group {{ $currentPage == 2 ? '' : 'hidden' }}">
                <div class="py-20 text-center bg-white rounded-2xl border border-slate-200/90 shadow-2xs">
                    <div class="w-16 h-16 bg-red-50 text-[#991b1b] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1.5">Tidak Ada UMKM di Halaman 2</h3>
                    <p class="text-xs sm:text-sm text-slate-400 mb-6 max-w-md mx-auto">Seluruh profil pelaku usaha terdaftar saat ini telah ditampilkan lengkap pada Halaman 1.</p>
                    <button type="button" class="btn-back-to-umkm-page1 inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#991b1b] text-white text-xs sm:text-sm font-bold hover:bg-[#801414] transition-colors shadow-2xs cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                        </svg>
                        <span>Kembali ke Halaman 1</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- Pagination matching Figma exactly (< [1] 2 >) -->
        <div class="flex items-center justify-center gap-2 mt-12 mb-8 reveal delay-300 select-none">
            {{-- Tombol Previous (<) --}}
            <a id="direktori-prev-btn" 
               href="{{ request()->fullUrlWithQuery(['page' => max(1, $currentPage - 1)]) }}" 
               class="w-9 h-9 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 flex items-center justify-center transition-all shadow-2xs {{ $currentPage <= 1 ? 'pointer-events-none opacity-40 bg-slate-100 text-slate-300' : '' }}" 
               title="Halaman Sebelumnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </a>

            {{-- Nomor Halaman (1, 2) --}}
            @for ($p = 1; $p <= 2; $p++)
                <a href="{{ request()->fullUrlWithQuery(['page' => $p]) }}" 
                   data-page="{{ $p }}"
                   class="direktori-num-btn w-9 h-9 rounded-lg flex items-center justify-center transition-all text-xs sm:text-sm font-medium {{ $p == $currentPage ? 'bg-[#991b1b] text-white font-bold shadow-xs cursor-default' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 shadow-2xs' }}">
                    {{ $p }}
                </a>
            @endfor

            {{-- Tombol Next (>) --}}
            <a id="direktori-next-btn" 
               href="{{ request()->fullUrlWithQuery(['page' => min(2, $currentPage + 1)]) }}" 
               class="w-9 h-9 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 flex items-center justify-center transition-all shadow-2xs {{ $currentPage >= 2 ? 'pointer-events-none opacity-40 bg-slate-100 text-slate-300' : '' }}" 
               title="Halaman Selanjutnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
            </a>
        </div>

    </div>
</div>

<!-- Instant Smooth Client-Side Switch Script for Direktori -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let activePage = {{ $currentPage }};
        const maxPage = 2;
        const prevBtn = document.getElementById('direktori-prev-btn');
        const nextBtn = document.getElementById('direktori-next-btn');
        const numBtns = document.querySelectorAll('.direktori-num-btn');
        const pageGroups = document.querySelectorAll('.umkm-page-group');

        function switchDirektoriPage(pageNum) {
            if (pageNum < 1 || pageNum > maxPage) return;
            activePage = pageNum;

            // 1. Tampilkan grup halaman yang dipilih, sembunyikan yang lain
            pageGroups.forEach((group, index) => {
                if (index + 1 === activePage) {
                    group.classList.remove('hidden');
                } else {
                    group.classList.add('hidden');
                }
            });

            // 2. Update warna tombol nomor halaman
            numBtns.forEach(btn => {
                const p = parseInt(btn.getAttribute('data-page'));
                if (p === activePage) {
                    btn.className = 'direktori-num-btn w-9 h-9 rounded-lg flex items-center justify-center transition-all text-xs sm:text-sm font-bold bg-[#991b1b] text-white shadow-xs cursor-default';
                } else {
                    btn.className = 'direktori-num-btn w-9 h-9 rounded-lg flex items-center justify-center transition-all text-xs sm:text-sm font-medium bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 shadow-2xs';
                }
            });

            // 3. Update tombol panah Previous (<)
            if (prevBtn) {
                if (activePage <= 1) {
                    prevBtn.className = 'w-9 h-9 rounded-lg bg-slate-100 border border-slate-200 text-slate-300 flex items-center justify-center transition-all shadow-2xs pointer-events-none opacity-40';
                } else {
                    prevBtn.className = 'w-9 h-9 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 flex items-center justify-center transition-all shadow-2xs cursor-pointer';
                }
            }

            // 4. Update tombol panah Next (>)
            if (nextBtn) {
                if (activePage >= maxPage) {
                    nextBtn.className = 'w-9 h-9 rounded-lg bg-slate-100 border border-slate-200 text-slate-300 flex items-center justify-center transition-all shadow-2xs pointer-events-none opacity-40';
                } else {
                    nextBtn.className = 'w-9 h-9 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 flex items-center justify-center transition-all shadow-2xs cursor-pointer';
                }
            }

            // 5. Update URL di browser tanpa reload
            try {
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('page', activePage);
                window.history.pushState({ page: activePage }, '', currentUrl);
            } catch (e) {}

            // 6. Scroll halus ke daftar direktori
            const anchor = document.getElementById('direktori-anchor');
            if (anchor) {
                anchor.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // Klik nomor halaman
        numBtns.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const p = parseInt(this.getAttribute('data-page'));
                switchDirektoriPage(p);
            });
        });

        // Tombol Kembali ke Halaman 1
        document.querySelectorAll('.btn-back-to-umkm-page1').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                switchDirektoriPage(1);
            });
        });

        // Klik tombol Prev (<)
        if (prevBtn) {
            prevBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (activePage > 1) {
                    switchDirektoriPage(activePage - 1);
                }
            });
        }

        // Klik tombol Next (>)
        if (nextBtn) {
            nextBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (activePage < maxPage) {
                    switchDirektoriPage(activePage + 1);
                }
            });
        }
    });
</script>

@endsection
