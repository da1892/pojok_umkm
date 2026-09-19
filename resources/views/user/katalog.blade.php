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

        <!-- 9 Products for Page 1 (Sesuai Figma) -->
        @php
            $page1Products = [
                [
                    'name' => 'Tiwul',
                    'category' => 'Makanan',
                    'seller' => 'Rasa Lestari',
                    'location' => 'Kec. Ngadirojo',
                    'image' => asset('img/products/tiwul.jpg')
                ],
                [
                    'name' => 'Tas Rotan',
                    'category' => 'Kerajinan',
                    'seller' => 'Kriya Mandiri',
                    'location' => 'Kec. Wuryantoro',
                    'image' => asset('img/products/tas_rotan.jpg')
                ],
                [
                    'name' => 'Batik Tulis Premium',
                    'category' => 'Batik/Fashion',
                    'seller' => 'Batik Sekar Arum',
                    'location' => 'Kec. Wonogiri',
                    'image' => asset('img/products/batik_tulis.jpg')
                ],
                [
                    'name' => 'Keripik Singkong',
                    'category' => 'Makanan',
                    'seller' => 'UD Sari Rasa',
                    'location' => 'Kec. Selogiri',
                    'image' => asset('img/products/keripik_singkong.jpg')
                ],
                [
                    'name' => 'Piring Hias',
                    'category' => 'Kerajinan',
                    'seller' => 'Logam Jaya',
                    'location' => 'Kec. Purwantoro',
                    'image' => asset('img/products/piring_hias.jpg')
                ],
                [
                    'name' => 'Jahe Merah Instan',
                    'category' => 'Olahan Hasil Pertanian',
                    'seller' => 'Sido Muncul Wonogiri',
                    'location' => 'Kec. Bulukerto',
                    'image' => asset('img/products/jahe_merah.jpg')
                ],
                [
                    'name' => 'Kue Cucur',
                    'category' => 'Makanan',
                    'seller' => 'Karya Makmur',
                    'location' => 'Kec. Pracimantoro',
                    'image' => asset('img/products/kue_cucur.jpg')
                ],
                [
                    'name' => 'Guci Keramik',
                    'category' => 'Kerajinan',
                    'seller' => 'Arto Moro',
                    'location' => 'Kec. Baturetno',
                    'image' => asset('img/products/guci_keramik.jpg')
                ],
                [
                    'name' => 'Kemeja Batik',
                    'category' => 'Batik/Fashion',
                    'seller' => 'Griya Busana',
                    'location' => 'Kec. Wonogiri',
                    'image' => asset('img/products/kemeja_batik.jpg')
                ],
            ];

            // Filter pencarian dan kategori
            $searchQuery = strtolower(trim(request('q', '')));
            $categoryFilter = strtolower(trim(request('kategori', '')));
            $districtFilter = strtolower(trim(request('kecamatan', '')));

            $filteredProducts = array_filter($page1Products, function($item) use ($searchQuery, $categoryFilter, $districtFilter) {
                if ($searchQuery !== '') {
                    $haystack = strtolower($item['name'] . ' ' . $item['seller'] . ' ' . $item['location']);
                    if (strpos($haystack, $searchQuery) === false) {
                        return false;
                    }
                }

                if ($categoryFilter !== '') {
                    $itemCategory = strtolower($item['category']);
                    if ($categoryFilter === 'makanan' && strpos($itemCategory, 'makan') === false) return false;
                    if ($categoryFilter === 'kerajinan' && strpos($itemCategory, 'kerajinan') === false) return false;
                    if ($categoryFilter === 'batik' && strpos($itemCategory, 'batik') === false) return false;
                    if ($categoryFilter === 'pertanian' && strpos($itemCategory, 'pertanian') === false) return false;
                    if ($categoryFilter === 'kreatif' && strpos($itemCategory, 'kreatif') === false) return false;
                }

                if ($districtFilter !== '') {
                    $itemDistrict = strtolower($item['location']);
                    if (strpos($itemDistrict, $districtFilter) === false) {
                        return false;
                    }
                }

                return true;
            });

            $currentPage = (int) request('page', 1);
            if ($currentPage < 1) $currentPage = 1;
            if ($currentPage > 3) $currentPage = 3;
        @endphp

        <!-- Target Anchor for Smooth Scrolling -->
        <div id="katalog-anchor" class="scroll-mt-24"></div>

        <!-- Katalog Content Container -->
        <div id="katalog-grid-container" class="reveal delay-200">
            
            {{-- HALAMAN 1 (Berisi 9 Produk Sesuai Figma) --}}
            <div id="katalog-page-1" class="katalog-page-group {{ $currentPage == 1 ? '' : 'hidden' }}">
                @if (count($filteredProducts) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
                    @foreach ($filteredProducts as $product)
                    <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-2xs hover:shadow-md hover:border-red-100 transition-all duration-300 group flex flex-col justify-between">
                        <div>
                            <div class="h-52 sm:h-56 w-full overflow-hidden bg-slate-100 relative">
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-5 pb-0">
                                <span class="inline-block bg-red-50 text-[#991b1b] text-[11px] font-semibold px-2.5 py-0.5 rounded-md mb-2">
                                    {{ $product['category'] }}
                                </span>
                                <h3 class="text-base font-bold text-slate-900 group-hover:text-[#991b1b] transition-colors leading-snug">
                                    {{ $product['name'] }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-1">
                                    oleh {{ $product['seller'] }}
                                </p>
                            </div>
                        </div>
                        <div class="p-5 pt-4">
                            <div class="flex items-center justify-between pt-3 border-t border-slate-100 text-xs">
                                <div class="flex items-center gap-1.5 text-slate-500 font-medium">
                                    <svg class="w-3.5 h-3.5 text-[#991b1b] shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $product['location'] }}</span>
                                </div>
                                <a href="/katalog" class="text-[#991b1b] font-bold hover:underline">
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
                    <p class="text-slate-600 font-semibold text-base mb-1">Tidak ada produk yang cocok</p>
                    <p class="text-slate-400 text-xs sm:text-sm mb-4">Coba cari dengan kata kunci lain atau reset filter kategori.</p>
                    <a href="/katalog" class="inline-flex items-center px-4 py-2 rounded-lg bg-[#991b1b] text-white text-xs font-bold hover:bg-[#801414] transition-colors">
                        Reset Filter
                    </a>
                </div>
                @endif
            </div>

            {{-- HALAMAN 2 (Kosong / Tidak Ada Produk) --}}
            <div id="katalog-page-2" class="katalog-page-group {{ $currentPage == 2 ? '' : 'hidden' }}">
                <div class="py-20 text-center bg-white rounded-2xl border border-slate-200/90 shadow-2xs">
                    <div class="w-16 h-16 bg-red-50 text-[#991b1b] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1.5">Tidak Ada Produk di Halaman 2</h3>
                    <p class="text-xs sm:text-sm text-slate-400 mb-6 max-w-md mx-auto">Seluruh produk unggulan UMKM Wonogiri saat ini telah ditampilkan lengkap pada Halaman 1.</p>
                    <button type="button" class="btn-back-to-page1 inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#991b1b] text-white text-xs sm:text-sm font-bold hover:bg-[#801414] transition-colors shadow-2xs cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                        </svg>
                        <span>Kembali ke Halaman 1</span>
                    </button>
                </div>
            </div>

            {{-- HALAMAN 3 (Kosong / Tidak Ada Produk) --}}
            <div id="katalog-page-3" class="katalog-page-group {{ $currentPage == 3 ? '' : 'hidden' }}">
                <div class="py-20 text-center bg-white rounded-2xl border border-slate-200/90 shadow-2xs">
                    <div class="w-16 h-16 bg-red-50 text-[#991b1b] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1.5">Tidak Ada Produk di Halaman 3</h3>
                    <p class="text-xs sm:text-sm text-slate-400 mb-6 max-w-md mx-auto">Seluruh produk unggulan UMKM Wonogiri saat ini telah ditampilkan lengkap pada Halaman 1.</p>
                    <button type="button" class="btn-back-to-page1 inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#991b1b] text-white text-xs sm:text-sm font-bold hover:bg-[#801414] transition-colors shadow-2xs cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                        </svg>
                        <span>Kembali ke Halaman 1</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- Pagination matching Figma exactly (< [1] 2 3 >) -->
        <div class="flex items-center justify-center gap-2 mt-12 mb-8 reveal delay-300 select-none">
            {{-- Tombol Previous (<) --}}
            <a id="katalog-prev-btn" 
               href="{{ request()->fullUrlWithQuery(['page' => max(1, $currentPage - 1)]) }}" 
               class="w-9 h-9 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 flex items-center justify-center transition-all shadow-2xs {{ $currentPage <= 1 ? 'pointer-events-none opacity-40 bg-slate-100 text-slate-300' : '' }}" 
               title="Halaman Sebelumnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </a>

            {{-- Nomor Halaman (1, 2, 3) --}}
            @for ($p = 1; $p <= 3; $p++)
                <a href="{{ request()->fullUrlWithQuery(['page' => $p]) }}" 
                   data-page="{{ $p }}"
                   class="katalog-num-btn w-9 h-9 rounded-lg flex items-center justify-center transition-all text-xs sm:text-sm font-medium {{ $p == $currentPage ? 'bg-[#991b1b] text-white font-bold shadow-xs cursor-default' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 shadow-2xs' }}">
                    {{ $p }}
                </a>
            @endfor

            {{-- Tombol Next (>) --}}
            <a id="katalog-next-btn" 
               href="{{ request()->fullUrlWithQuery(['page' => min(3, $currentPage + 1)]) }}" 
               class="w-9 h-9 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 flex items-center justify-center transition-all shadow-2xs {{ $currentPage >= 3 ? 'pointer-events-none opacity-40 bg-slate-100 text-slate-300' : '' }}" 
               title="Halaman Selanjutnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
            </a>
        </div>

    </div>
</div>

<!-- Instant Smooth Client-Side Switch Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let activePage = {{ $currentPage }};
        const maxPage = 3;
        const prevBtn = document.getElementById('katalog-prev-btn');
        const nextBtn = document.getElementById('katalog-next-btn');
        const numBtns = document.querySelectorAll('.katalog-num-btn');
        const pageGroups = document.querySelectorAll('.katalog-page-group');

        function switchKatalogPage(pageNum) {
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
                    btn.className = 'katalog-num-btn w-9 h-9 rounded-lg flex items-center justify-center transition-all text-xs sm:text-sm font-bold bg-[#991b1b] text-white shadow-xs cursor-default';
                } else {
                    btn.className = 'katalog-num-btn w-9 h-9 rounded-lg flex items-center justify-center transition-all text-xs sm:text-sm font-medium bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 shadow-2xs';
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

            // 6. Scroll halus ke grid katalog
            const anchor = document.getElementById('katalog-anchor');
            if (anchor) {
                anchor.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // Klik nomor halaman
        numBtns.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const p = parseInt(this.getAttribute('data-page'));
                switchKatalogPage(p);
            });
        });

        // Tombol Kembali ke Halaman 1
        document.querySelectorAll('.btn-back-to-page1').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                switchKatalogPage(1);
            });
        });

        // Klik tombol Prev (<)
        if (prevBtn) {
            prevBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (activePage > 1) {
                    switchKatalogPage(activePage - 1);
                }
            });
        }

        // Klik tombol Next (>)
        if (nextBtn) {
            nextBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (activePage < maxPage) {
                    switchKatalogPage(activePage + 1);
                }
            });
        }
    });
</script>

@endsection
