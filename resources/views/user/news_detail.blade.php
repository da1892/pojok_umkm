@extends('user.layouts.app')

@section('content')
<!-- Reading Progress Bar -->
<div id="reading-progress" class="fixed top-0 left-0 h-1 bg-[#800000] z-50 transition-all duration-150" style="width: 0%;"></div>

<div class="bg-slate-50/80 min-h-screen py-6 sm:py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- 2-Column Responsive Layout: 8 Cols Article + 4 Cols Sticky Sidebar -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- KOLOM UTAMA (Artikel & Galeri) -->
            <main class="lg:col-span-8 space-y-6">
                
                <article class="bg-white rounded-3xl overflow-hidden shadow-xs border border-slate-200/90 p-5 sm:p-8 md:p-10 space-y-7">
                    
                    <!-- Header Artikel -->
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            @if($news->category)
                            <a href="{{ route('informasi', ['kategori' => $news->category]) }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-[#800000] border border-red-200 hover:bg-red-100 transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#800000]"></span>
                                <span>{{ $news->category }}</span>
                            </a>
                            @endif

                            @php
                                $wordCount = str_word_count(strip_tags($news->content));
                                $readTime = max(1, (int)ceil($wordCount / 180));
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $readTime }} Menit Baca</span>
                            </span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 leading-snug sm:leading-tight tracking-tight mb-4">
                            {{ $news->title }}
                        </h1>

                        <!-- Author & Meta Info Row -->
                        <div class="flex flex-wrap items-center justify-between gap-4 py-3.5 border-y border-slate-100 text-xs text-slate-500">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-red-100 text-[#800000] flex items-center justify-center font-bold text-xs ring-2 ring-red-50 shadow-2xs">
                                    UMKM
                                </div>
                                <div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-bold text-slate-800">{{ $news->author->name ?? 'Admin Pojok UMKM' }}</span>
                                        <span class="bg-emerald-100 text-emerald-800 text-[9px] font-extrabold px-1.5 py-0.2 rounded-md">Resmi</span>
                                    </div>
                                    <span class="text-[11px] text-slate-400">Dinas KUKM & Perindag Wonogiri</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('informasi', ['q' => $news->created_at ? $news->created_at->translatedFormat('d F Y') : '']) }}" 
                                   class="inline-flex items-center gap-1.5 text-slate-600 hover:text-[#800000] transition-colors" title="Filter berita tanggal ini">
                                    <svg class="w-3.5 h-3.5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="font-medium">{{ $news->created_at ? $news->created_at->translatedFormat('l, d F Y') : '-' }}</span>
                                </a>
                                <span>&bull;</span>
                                <span class="text-slate-400 font-medium">{{ $news->created_at ? $news->created_at->format('H:i') : '' }} WIB</span>
                            </div>
                        </div>
                    </div>

                    <!-- Galeri & Carousel Foto Bergerak Interaktif -->
                    @php
                        $imagesList = $news->all_images;
                    @endphp

                    @if(count($imagesList) > 0)
                    <div class="space-y-3">
                        <div class="relative w-full h-[320px] sm:h-[420px] md:h-[460px] rounded-2xl overflow-hidden bg-slate-900 shadow-md group select-none">
                            <div id="carousel-slides" class="relative w-full h-full">
                                @foreach($imagesList as $idx => $img)
                                @php
                                    $imgSrc = str_starts_with($img, 'http') || str_starts_with($img, 'img/') ? asset($img) : asset('storage/' . $img);
                                @endphp
                                <div class="news-slide absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out {{ $idx === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}">
                                    <img src="{{ $imgSrc }}" alt="{{ $news->title }} - Foto {{ $idx + 1 }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-black/75 via-black/25 to-transparent pointer-events-none"></div>
                                </div>
                                @endforeach
                            </div>

                            @if(count($imagesList) > 1)
                            <!-- Tombol Geser Kiri / Kanan -->
                            <button type="button" onclick="prevSlide()" class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-black/45 hover:bg-[#800000] text-white flex items-center justify-center backdrop-blur-xs transition-all shadow-md active:scale-95" aria-label="Foto Sebelumnya">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button type="button" onclick="nextSlide()" class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-black/45 hover:bg-[#800000] text-white flex items-center justify-center backdrop-blur-xs transition-all shadow-md active:scale-95" aria-label="Foto Selanjutnya">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </button>

                            <!-- Indikator Dots -->
                            <div class="absolute bottom-3.5 inset-x-0 z-20 flex items-center justify-center gap-1.5">
                                @foreach($imagesList as $idx => $img)
                                <button type="button" onclick="goToSlide({{ $idx }})" class="slide-dot h-2 rounded-full transition-all {{ $idx === 0 ? 'w-6 bg-white' : 'w-2 bg-white/50 hover:bg-white/80' }}"></button>
                                @endforeach
                            </div>

                            <!-- Badge Auto-play Info -->
                            <div class="absolute top-3 right-3 z-20 bg-black/65 backdrop-blur-xs text-white text-[10px] font-bold px-3 py-1 rounded-full flex items-center gap-1.5 shadow-xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span id="slide-counter">1 / {{ count($imagesList) }} Foto Dokumentasi</span>
                            </div>
                            @endif
                        </div>

                        <!-- Thumbnail Strip (Jika lebih dari 1 foto) -->
                        @if(count($imagesList) > 1)
                        <div class="flex items-center gap-2.5 overflow-x-auto pb-1" style="scrollbar-width: none;">
                            @foreach($imagesList as $idx => $img)
                            @php
                                $thumbSrc = str_starts_with($img, 'http') || str_starts_with($img, 'img/') ? asset($img) : asset('storage/' . $img);
                            @endphp
                            <button type="button" onclick="goToSlide({{ $idx }})" class="thumb-btn shrink-0 w-20 h-14 rounded-xl overflow-hidden border-2 transition-all cursor-pointer {{ $idx === 0 ? 'border-[#800000] ring-2 ring-[#800000]/30 shadow-xs' : 'border-slate-200 opacity-60 hover:opacity-100' }}">
                                <img src="{{ $thumbSrc }}" alt="Thumbnail {{ $idx + 1 }}" class="w-full h-full object-cover">
                            </button>
                            @endforeach
                        </div>
                        @endif

                        <p class="text-[11px] text-slate-400 italic text-center">
                            Dokumentasi resmi liputan kegiatan {{ $news->title }} di Kabupaten Wonogiri.
                        </p>
                    </div>
                    @endif

                    <!-- Cuplikan / Lead Editorial (Excerpt) -->
                    @if($news->excerpt)
                    <div class="relative bg-gradient-to-r from-red-50/80 via-white to-red-50/20 border-l-4 border-[#800000] rounded-r-2xl p-4 sm:p-5 shadow-2xs">
                        <div class="flex items-start gap-3">
                            <span class="text-3xl font-serif text-[#800000] leading-none select-none">“</span>
                            <p class="text-slate-800 text-sm sm:text-base italic font-semibold leading-relaxed">
                                {{ $news->excerpt }}
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Isi Lengkap Berita (Body Typography Ramah Baca) -->
                    <div class="article-body text-slate-700 text-[15px] sm:text-base leading-relaxed sm:leading-loose space-y-4 pt-1">
                        @php
                            // Pecah paragraf agar rapi dan nyaman dibaca
                            $paragraphs = preg_split('/\r\n|\r|\n/', $news->content);
                        @endphp

                        @foreach($paragraphs as $p)
                            @if(trim($p) !== '')
                                <p class="text-slate-700 leading-relaxed sm:leading-loose">{{ trim($p) }}</p>
                            @endif
                        @endforeach
                    </div>

                    <!-- Tag & Topik Berita -->
                    <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center gap-1.5">
                        <span class="text-xs font-bold text-slate-500 mr-1">Topik:</span>
                        <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg font-medium">#WonogiriSukses</span>
                        <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg font-medium">#PojokUMKM</span>
                        @if($news->category)
                        <a href="{{ route('informasi', ['kategori' => $news->category]) }}" class="text-xs bg-red-50 text-[#800000] hover:bg-red-100 px-2.5 py-1 rounded-lg font-bold border border-red-100 transition-colors">
                            #{{ $news->category }}
                        </a>
                        @endif
                    </div>

                    <!-- Kotak Penerbit Resmi Pemkab Wonogiri -->
                    <div class="bg-slate-50 rounded-2xl p-4 sm:p-5 border border-slate-200/80 flex items-start sm:items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 text-[#800000] flex items-center justify-center shrink-0 shadow-2xs font-extrabold text-sm">
                            KUKM
                        </div>
                        <div class="flex-1 text-xs">
                            <h4 class="font-bold text-slate-800 text-sm mb-0.5">Dinas KUKM & Perindag Kabupaten Wonogiri</h4>
                            <p class="text-slate-500 leading-relaxed">
                                Kanal resmi sosialisasi program kerja, fasilitasi legalitas, pembinaan mutu, dan promosi produk unggulan UMKM Kabupaten Wonogiri.
                            </p>
                        </div>
                    </div>

                </article>

                <!-- Navigasi Berita Sebelumnya & Berita Selanjutnya -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    @if($prevNews)
                    <a href="{{ route('informasi.show', $prevNews->id) }}" class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-md hover:border-red-200 transition-all flex items-center gap-3.5 group">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 group-hover:bg-[#800000] group-hover:text-white flex items-center justify-center shrink-0 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </div>
                        <div class="min-w-0">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Berita Sebelumnya</span>
                            <h5 class="text-xs font-bold text-slate-800 group-hover:text-[#800000] truncate transition-colors">
                                {{ $prevNews->title }}
                            </h5>
                        </div>
                    </a>
                    @else
                    <div></div>
                    @endif

                    @if($nextNews)
                    <a href="{{ route('informasi.show', $nextNews->id) }}" class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-md hover:border-red-200 transition-all flex items-center justify-between gap-3.5 group text-right sm:text-right">
                        <div class="min-w-0 flex-1">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Berita Selanjutnya</span>
                            <h5 class="text-xs font-bold text-slate-800 group-hover:text-[#800000] truncate transition-colors">
                                {{ $nextNews->title }}
                            </h5>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 group-hover:bg-[#800000] group-hover:text-white flex items-center justify-center shrink-0 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>
                    @endif
                </div>

            </main>

            <!-- SIDEBAR SAMPING (Sticky & Interaktif) -->
            <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
                
                <!-- Widget 1: Ringkasan Publikasi -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs space-y-3.5">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5 pb-2 border-b border-slate-100">
                        <svg class="w-4 h-4 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Informasi Publikasi
                    </h4>
                    
                    <div class="space-y-2.5 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Kategori:</span>
                            <span class="font-bold text-[#800000] bg-red-50 px-2 py-0.5 rounded-md">{{ $news->category ?? 'Umum' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Tanggal Tayang:</span>
                            <span class="font-semibold text-slate-700">{{ $news->created_at ? $news->created_at->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Penyelenggara:</span>
                            <span class="font-semibold text-slate-700">Dinas KUKM Wonogiri</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Status Liputan:</span>
                            <span class="font-bold text-emerald-600 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Terverifikasi
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Widget: Berita & Agenda Terkini Lainnya -->
                @if(isset($recentNews) && $recentNews->count() > 0)
                <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs space-y-3.5">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#800000]"></span>
                            Agenda Terkini Lainnya
                        </h4>
                        <a href="{{ route('informasi') }}" class="text-[11px] font-bold text-[#800000] hover:underline">Semua</a>
                    </div>

                    <div class="space-y-3">
                        @foreach($recentNews as $rn)
                        @php
                            $rnImg = $rn->image_path ? (str_starts_with($rn->image_path, 'http') || str_starts_with($rn->image_path, 'img/') ? asset($rn->image_path) : asset('storage/' . $rn->image_path)) : asset('img/news/bimtek.jpg');
                        @endphp
                        <a href="{{ route('informasi.show', $rn->id) }}" class="flex items-center gap-3 group">
                            <div class="w-16 h-14 rounded-xl overflow-hidden bg-slate-100 shrink-0">
                                <img src="{{ $rnImg }}" alt="{{ $rn->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="text-[10px] font-bold text-[#b91c1c] block mb-0.5">
                                    {{ $rn->created_at ? $rn->created_at->translatedFormat('d F Y') : '-' }}
                                </span>
                                <h5 class="text-xs font-semibold text-slate-800 group-hover:text-[#800000] leading-snug line-clamp-2 transition-colors">
                                    {{ $rn->title }}
                                </h5>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </aside>

        </div>

        <!-- Bagian Bawah: Berita & Kegiatan Terkait Lainnya -->
        @if(isset($otherNews) && $otherNews->count() > 0)
        <div class="mt-14 pt-8 border-t border-slate-200/80 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2">
                <div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Berita & Kegiatan Terkait</h3>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Informasi dan dokumentasi pendampingan UMKM lainnya di Kabupaten Wonogiri.</p>
                </div>
                <a href="{{ route('informasi') }}" class="text-xs font-bold text-[#800000] hover:text-red-900 inline-flex items-center gap-1 shrink-0">
                    <span>Lihat Seluruh Berita</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($otherNews as $item)
                @php
                    $otherImg = $item->image_path ? (str_starts_with($item->image_path, 'http') || str_starts_with($item->image_path, 'img/') ? asset($item->image_path) : asset('storage/' . $item->image_path)) : asset('img/news/bimtek.jpg');
                @endphp
                <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-2xs hover:shadow-md transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between group">
                    <div>
                        <a href="{{ route('informasi.show', $item->id) }}" class="block h-32 w-full overflow-hidden bg-slate-100 relative">
                            <img src="{{ $otherImg }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @if($item->category)
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md text-[9px] font-bold bg-white/95 backdrop-blur-xs text-[#800000]">
                                {{ $item->category }}
                            </span>
                            @endif
                        </a>
                        <div class="p-3.5">
                            <span class="text-[10px] font-bold text-[#b91c1c] block mb-1">
                                {{ $item->created_at ? $item->created_at->translatedFormat('d F Y') : '-' }}
                            </span>
                            <h4 class="font-bold text-slate-800 text-xs line-clamp-2 group-hover:text-[#800000] leading-snug transition-colors">
                                <a href="{{ route('informasi.show', $item->id) }}">
                                    {{ $item->title }}
                                </a>
                            </h4>
                        </div>
                    </div>
                    <div class="px-3.5 pb-3 pt-0 border-t border-slate-50 flex items-center justify-between text-[10px]">
                        <span class="text-slate-400">Admin UMKM</span>
                        <a href="{{ route('informasi.show', $item->id) }}" class="font-bold text-[#800000] hover:text-red-900 inline-flex items-center gap-0.5">
                            <span>Baca</span> &rarr;
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

<!-- Carousel Script, Reading Progress, & Copy Link Tooltip -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Reading Progress Bar saat scroll
        window.addEventListener('scroll', function () {
            const docElem = document.documentElement;
            const docBody = document.body;
            const scrollTop = docElem.scrollTop || docBody.scrollTop;
            const scrollBottom = (docElem.scrollHeight || docBody.scrollHeight) - window.innerHeight;
            const scrollPercent = scrollBottom > 0 ? (scrollTop / scrollBottom) * 100 : 0;
            const bar = document.getElementById('reading-progress');
            if (bar) bar.style.width = scrollPercent + '%';
        });

        // 2. Carousel Slider Otomatis
        const slides = document.querySelectorAll('.news-slide');
        const dots = document.querySelectorAll('.slide-dot');
        const thumbs = document.querySelectorAll('.thumb-btn');
        const counter = document.getElementById('slide-counter');
        const total = slides.length;

        if (total > 1) {
            let currentIndex = 0;
            let autoPlayTimer = null;

            function updateSlide(index) {
                slides.forEach((slide, i) => {
                    if (i === index) {
                        slide.classList.remove('opacity-0', 'z-0');
                        slide.classList.add('opacity-100', 'z-10');
                    } else {
                        slide.classList.remove('opacity-100', 'z-10');
                        slide.classList.add('opacity-0', 'z-0');
                    }
                });

                dots.forEach((dot, i) => {
                    if (i === index) {
                        dot.classList.remove('w-2', 'bg-white/50');
                        dot.classList.add('w-6', 'bg-white');
                    } else {
                        dot.classList.remove('w-6', 'bg-white');
                        dot.classList.add('w-2', 'bg-white/50');
                    }
                });

                thumbs.forEach((thumb, i) => {
                    if (i === index) {
                        thumb.classList.remove('border-slate-200', 'opacity-60');
                        thumb.classList.add('border-[#800000]', 'ring-2', 'ring-[#800000]/30', 'shadow-xs', 'opacity-100');
                    } else {
                        thumb.classList.remove('border-[#800000]', 'ring-2', 'ring-[#800000]/30', 'shadow-xs', 'opacity-100');
                        thumb.classList.add('border-slate-200', 'opacity-60');
                    }
                });

                if (counter) {
                    counter.textContent = `${index + 1} / ${total} Foto Dokumentasi`;
                }

                currentIndex = index;
            }

            window.nextSlide = function () {
                let next = (currentIndex + 1) % total;
                updateSlide(next);
                resetAutoPlay();
            };

            window.prevSlide = function () {
                let prev = (currentIndex - 1 + total) % total;
                updateSlide(prev);
                resetAutoPlay();
            };

            window.goToSlide = function (index) {
                updateSlide(index);
                resetAutoPlay();
            };

            function startAutoPlay() {
                autoPlayTimer = setInterval(function () {
                    let next = (currentIndex + 1) % total;
                    updateSlide(next);
                }, 3800);
            }

            function resetAutoPlay() {
                if (autoPlayTimer) clearInterval(autoPlayTimer);
                startAutoPlay();
            }

            startAutoPlay();
        }
    });
</script>
@endsection
