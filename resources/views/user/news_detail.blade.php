@extends('user.layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-[#800000]">Beranda</a>
            <span>/</span>
            <a href="{{ route('informasi') }}" class="hover:text-[#800000]">Berita & Kegiatan</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold truncate max-w-xs">{{ $news->title }}</span>
        </div>

        <!-- Article Card -->
        <article class="bg-white rounded-3xl overflow-hidden shadow-xs border border-slate-200/80 p-6 sm:p-10 space-y-6">
            <div>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-[#800000] border border-red-100 mb-3">
                    {{ $news->category }}
                </span>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight mb-4">
                    {{ $news->title }}
                </h1>
                <div class="flex items-center gap-3 text-xs text-slate-500 pb-6 border-b border-slate-100">
                    <span class="font-semibold text-slate-700">Oleh: {{ $news->author->name ?? 'Admin Wonogiri' }}</span>
                    <span>&bull;</span>
                    <span>{{ $news->created_at ? $news->created_at->translatedFormat('d F Y, H:i') : '-' }} WIB</span>
                </div>
            </div>

            <!-- Auto-moving / Slideshow Foto Berita & Kegiatan Otomatis -->
            @php
                $imagesList = $news->all_images;
            @endphp

            @if(count($imagesList) > 0)
            <div class="space-y-4">
                <!-- Banner Utama Slide Foto Bergerak (Besar & Jelas) -->
                <div class="relative w-full h-[360px] sm:h-[440px] md:h-[480px] rounded-2xl overflow-hidden bg-slate-900 shadow-md group select-none">
                    <!-- Slides Container -->
                    <div id="carousel-slides" class="relative w-full h-full">
                        @foreach($imagesList as $idx => $img)
                        @php
                            $imgSrc = str_starts_with($img, 'http') || str_starts_with($img, 'img/') ? asset($img) : asset('storage/' . $img);
                        @endphp
                        <div class="news-slide absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out {{ $idx === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}">
                            <img src="{{ $imgSrc }}" alt="{{ $news->title }} - Foto {{ $idx + 1 }}" class="w-full h-full object-cover">
                            <!-- Gradient overlay -->
                            <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/70 via-black/20 to-transparent pointer-events-none"></div>
                        </div>
                        @endforeach
                    </div>

                    @if(count($imagesList) > 1)
                    <!-- Tombol Navigasi Kiri & Kanan -->
                    <button type="button" onclick="prevSlide()" class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/40 hover:bg-[#800000] text-white flex items-center justify-center backdrop-blur-xs transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button type="button" onclick="nextSlide()" class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/40 hover:bg-[#800000] text-white flex items-center justify-center backdrop-blur-xs transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>

                    <!-- Indicators Dots -->
                    <div class="absolute bottom-3 inset-x-0 z-20 flex items-center justify-center gap-1.5">
                        @foreach($imagesList as $idx => $img)
                        <button type="button" onclick="goToSlide({{ $idx }})" class="slide-dot h-2 rounded-full transition-all {{ $idx === 0 ? 'w-6 bg-white' : 'w-2 bg-white/50 hover:bg-white/80' }}"></button>
                        @endforeach
                    </div>

                    <!-- Auto-play badge info -->
                    <div class="absolute top-3 right-3 z-20 bg-black/60 backdrop-blur-xs text-white text-[10px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span id="slide-counter">1 / {{ count($imagesList) }} Foto Bergerak</span>
                    </div>
                    @endif
                </div>

                <!-- Thumbnail Navigasi Bawah (Jika lebih dari 1 foto) -->
                @if(count($imagesList) > 1)
                <div class="flex items-center gap-2 overflow-x-auto pb-1 hide-scrollbar">
                    @foreach($imagesList as $idx => $img)
                    @php
                        $thumbSrc = str_starts_with($img, 'http') || str_starts_with($img, 'img/') ? asset($img) : asset('storage/' . $img);
                    @endphp
                    <button type="button" onclick="goToSlide({{ $idx }})" class="thumb-btn shrink-0 w-20 h-14 rounded-xl overflow-hidden border-2 transition-all {{ $idx === 0 ? 'border-[#800000] ring-2 ring-[#800000]/30' : 'border-slate-200 opacity-60 hover:opacity-100' }}">
                        <img src="{{ $thumbSrc }}" alt="Thumbnail {{ $idx + 1 }}" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
            @endif

            @if($news->excerpt)
            <div class="p-4 bg-amber-50/70 border-l-4 border-[#800000] rounded-r-xl text-slate-700 text-sm italic font-medium">
                {{ $news->excerpt }}
            </div>
            @endif

            <div class="text-slate-700 text-sm sm:text-base leading-relaxed space-y-4 whitespace-pre-line pt-2">
                {{ $news->content }}
            </div>
        </article>

        <!-- Other News -->
        @if(isset($otherNews) && $otherNews->count() > 0)
        <div class="pt-6 space-y-4">
            <h3 class="text-xl font-bold text-slate-900">Berita & Kegiatan Lainnya</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                @foreach($otherNews as $item)
                @php
                    $otherImg = $item->image_path ? (str_starts_with($item->image_path, 'http') || str_starts_with($item->image_path, 'img/') ? asset($item->image_path) : asset('storage/' . $item->image_path)) : asset('img/news/bimtek.jpg');
                @endphp
                <a href="{{ route('informasi.show', $item->id) }}" class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-2xs hover:shadow-md transition-all p-4 group">
                    <div class="h-32 rounded-xl overflow-hidden mb-3 bg-slate-100">
                        <img src="{{ $otherImg }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <span class="text-[10px] font-bold text-red-600 block mb-1">{{ $item->category }}</span>
                    <h4 class="font-bold text-slate-800 text-xs line-clamp-2 group-hover:text-[#800000] leading-snug">
                        {{ $item->title }}
                    </h4>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

<!-- Carousel Auto-Moving Script (Bergerak Otomatis) -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slides = document.querySelectorAll('.news-slide');
        const dots = document.querySelectorAll('.slide-dot');
        const thumbs = document.querySelectorAll('.thumb-btn');
        const counter = document.getElementById('slide-counter');
        const total = slides.length;

        if (total <= 1) return;

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
                    thumb.classList.add('border-[#800000]', 'ring-2', 'ring-[#800000]/30', 'opacity-100');
                } else {
                    thumb.classList.remove('border-[#800000]', 'ring-2', 'ring-[#800000]/30', 'opacity-100');
                    thumb.classList.add('border-slate-200', 'opacity-60');
                }
            });

            if (counter) {
                counter.textContent = `${index + 1} / ${total} Foto Bergerak`;
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
            }, 3500); // Bergerak otomatis setiap 3.5 detik
        }

        function resetAutoPlay() {
            if (autoPlayTimer) clearInterval(autoPlayTimer);
            startAutoPlay();
        }

        // Jalankan slide otomatis saat halaman dimuat
        startAutoPlay();
    });
</script>
@endsection
