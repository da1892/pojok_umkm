@extends('user.layouts.app')

@section('content')
<div class="bg-[#FAF9F6] min-h-screen py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb & Back Button -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <nav class="flex items-center gap-2 text-sm text-slate-500 font-medium">
                <a href="/" class="hover:text-[#800000] transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('katalog') }}" class="hover:text-[#800000] transition-colors">Katalog</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold truncate max-w-xs">{{ $product->name }}</span>
            </nav>
            <a href="{{ url()->previous() ?: route('katalog') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-[#800000] bg-white px-3.5 py-2 rounded-xl border border-slate-200 shadow-xs hover:shadow transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>

        @php
            $images = $product->all_images;
            if (empty($images)) {
                $images = [];
            }
        @endphp

        <!-- Main Product Card -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200/80">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">
                
                <!-- Left Column: Gallery & Carousel (6 cols on lg) -->
                <div class="lg:col-span-6 p-6 sm:p-8 bg-slate-50/70 border-b lg:border-b-0 lg:border-r border-slate-100 flex flex-col justify-start">
                    
                    <!-- Main Carousel Viewport with Sliding Track -->
                    <div id="carousel-container" class="carousel-main-viewport group">
                        @if(count($images) > 0)
                            <!-- Sliding Track -->
                            <div id="carousel-track" class="carousel-track" onclick="openLightbox(window.currentSlideIndex || 0)">
                                @foreach($images as $idx => $img)
                                    <div class="carousel-slide-item" onclick="openLightbox({{ $idx }})">
                                        <img src="{{ asset('storage/' . $img) }}" 
                                             alt="{{ $product->name }} - Foto {{ $idx + 1 }}" 
                                             class="carousel-img">
                                    </div>
                                @endforeach
                            </div>

                            <!-- Auto-play Progress Bar at Bottom -->
                            @if(count($images) > 1)
                                <div class="carousel-progress-container pointer-events-none">
                                    <div id="carousel-progress" class="carousel-progress-bar"></div>
                                </div>
                            @endif

                            <!-- Category Badge (Floating Top Right) -->
                            <div class="absolute top-4 right-4 z-20 pointer-events-none">
                                <span class="bg-[#800000] text-white text-xs font-bold px-3.5 py-1.5 rounded-full shadow-md tracking-wide">
                                    {{ $product->category }}
                                </span>
                            </div>

                            <!-- Slide Counter (Floating Top Left) -->
                            <div class="absolute top-4 left-4 z-20 pointer-events-none">
                                <div class="px-3 py-1.5 rounded-full bg-slate-900/80 text-white text-xs font-semibold backdrop-blur-md shadow-md flex items-center gap-1.5">
                                    <span id="slide-indicator">1</span>
                                    <span class="text-white/60">/</span>
                                    <span>{{ count($images) }}</span>
                                </div>
                            </div>

                            <!-- Zoom Hint Button (Floating Bottom Right) -->
                            <button type="button" 
                                    id="btn-perbesar-foto"
                                    onclick="openLightbox()" 
                                    class="absolute bottom-4 right-4 z-20 px-3.5 py-2 rounded-xl bg-slate-900/85 hover:bg-[#800000] text-white text-xs font-bold flex items-center gap-2 backdrop-blur-md transition-all shadow-lg hover:scale-105 active:scale-95 cursor-pointer" 
                                    title="Klik untuk perbesar foto fullscreen">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path></svg>
                                <span>Perbesar Foto</span>
                            </button>
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-8 text-center">
                                <div class="w-16 h-16 rounded-2xl bg-slate-200/80 flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-500">Foto produk tidak tersedia</span>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnails Row (if multiple images) -->
                    @if(count($images) > 1)
                        <div class="mt-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                    Semua Foto Produk ({{ count($images) }})
                                </span>
                                <span class="text-[11px] text-slate-400">
                                    Klik foto untuk beralih
                                </span>
                            </div>
                            <div class="flex items-center gap-2.5 overflow-x-auto pb-2 pt-1 thumbnail-scrollbar">
                                @foreach($images as $idx => $img)
                                    <button type="button" 
                                            onclick="goToSlide({{ $idx }})" 
                                            class="thumb-item {{ $idx === 0 ? 'active' : '' }}" 
                                            data-index="{{ $idx }}"
                                            title="Lihat foto {{ $idx + 1 }}">
                                        <img src="{{ asset('storage/' . $img) }}" alt="Thumbnail {{ $idx + 1 }}">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Product Info & Seller (6 cols on lg) -->
                <div class="lg:col-span-6 p-6 sm:p-10 flex flex-col justify-between">
                    <div>
                        <!-- Category Tag -->
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold text-[#800000] bg-red-50 border border-red-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                {{ $product->category }}
                            </span>
                            <span class="text-xs text-slate-400">
                                &bull; Produk UMKM Wonogiri
                            </span>
                        </div>

                        <!-- Product Title -->
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 mb-6 leading-tight tracking-tight">
                            {{ $product->name }}
                        </h1>

                        <!-- Description Box -->
                        <div class="mb-8">
                            <div class="flex items-center gap-2 mb-2.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Deskripsi Produk</h3>
                            </div>
                            <div class="bg-slate-50/80 rounded-2xl p-5 border border-slate-100 text-slate-700 leading-relaxed text-sm sm:text-base whitespace-pre-line">
                                {{ $product->description ?: 'Tidak ada deskripsi rinci untuk produk ini.' }}
                            </div>
                        </div>
                    </div>

                    <!-- Seller / Store Info & WhatsApp Action -->
                    <div class="pt-6 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Informasi Penjual / UMKM</h4>
                            @if($product->umkmProfile)
                                <a href="{{ route('direktori.show', $product->umkmProfile->id) }}" class="text-xs font-bold text-[#800000] hover:underline flex items-center gap-1">
                                    Lihat Profil Lengkap &rarr;
                                </a>
                            @endif
                        </div>

                        <div class="bg-gradient-to-br from-slate-50 to-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs">
                            <div class="flex items-start gap-3.5 min-w-0">
                                @if(!empty($product->umkmProfile->image_path))
                                    <img src="{{ asset('storage/' . $product->umkmProfile->image_path) }}" 
                                         alt="{{ $product->umkmProfile->business_name ?? 'Foto UMKM' }}" 
                                         class="w-14 h-14 rounded-2xl object-cover shrink-0 shadow-md border-2 border-white ring-1 ring-slate-200">
                                @elseif(!empty($product->image_path))
                                    <img src="{{ asset('storage/' . $product->image_path) }}" 
                                         alt="{{ $product->umkmProfile->business_name ?? 'Foto UMKM' }}" 
                                         class="w-14 h-14 rounded-2xl object-cover shrink-0 shadow-md border-2 border-white ring-1 ring-slate-200">
                                @else
                                    <div class="w-14 h-14 rounded-2xl bg-[#800000] text-white flex items-center justify-center shrink-0 shadow-md shadow-[#800000]/20 font-bold text-xl">
                                        {{ strtoupper(substr($product->umkmProfile->business_name ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <h5 class="font-extrabold text-slate-900 text-base leading-tight truncate">
                                        {{ $product->umkmProfile->business_name ?? 'UMKM Wonogiri' }}
                                    </h5>
                                    @if(isset($product->umkmProfile->owner_name))
                                        <p class="text-xs text-slate-500 mt-1">
                                            Pemilik: <span class="font-semibold text-slate-700">{{ $product->umkmProfile->owner_name }}</span>
                                        </p>
                                    @endif
                                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="truncate">{{ $product->umkmProfile->address ?? ($product->umkmProfile->district ? 'Kec. ' . $product->umkmProfile->district : 'Kabupaten Wonogiri') }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="mt-4 pt-3.5 border-t border-slate-100 flex flex-wrap items-center gap-2.5">
                                @if(!empty($product->umkmProfile->phone))
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $product->umkmProfile->phone);
                                        if (str_starts_with($cleanPhone, '0')) {
                                            $cleanPhone = '62' . substr($cleanPhone, 1);
                                        }
                                        $waUrl = "https://wa.me/{$cleanPhone}?text=" . urlencode("Halo {$product->umkmProfile->business_name}, saya melihat produk '{$product->name}' di website Pojok UMKM Wonogiri dan berminat untuk bertanya/pesan.");
                                    @endphp
                                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#25D366] hover:bg-[#20ba5a] text-white text-xs font-bold rounded-xl shadow-xs hover:shadow transition-all">
                                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.299.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.087-.179.182-.077.357.101.174.449.741.964 1.201.662.591 1.221.774 1.394.861.174.086.275.072.376-.044.101-.116.433-.506.549-.679.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.203c.043.072.043.419-.101.824z"/></svg>
                                        <span>Hubungi Penjual</span>
                                    </a>
                                @endif
                                @if($product->umkmProfile)
                                    <a href="{{ route('direktori.show', $product->umkmProfile->id) }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-slate-300 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-50 transition-colors shadow-2xs">
                                        <span>Profil UMKM</span>
                                    </a>
                                    @if(!empty($product->umkmProfile->google_maps_directions_url))
                                        <a href="{{ $product->umkmProfile->google_maps_directions_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-xl transition-colors">
                                            <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <span>Lokasi Maps</span>
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
    </div>
</div>

<!-- ============================================== -->
<!-- LIGHTBOX MODAL (PERBESAR FOTO FULLSCREEN) -->
<!-- ============================================== -->
<div id="lightbox-modal" class="lightbox-backdrop" style="display: none;" onclick="closeLightboxOnBackdrop(event)">
    <!-- Close button -->
    <button type="button" onclick="closeLightbox()" class="lightbox-close-btn" aria-label="Tutup" title="Tutup (Esc)">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>

    <!-- Top Counter Badge -->
    <div class="lightbox-counter">
        Foto <span id="lightbox-index">1</span> dari {{ count($images) }}
    </div>

    <!-- Main Lightbox Image Viewport -->
    <div class="lightbox-content-box" onclick="event.stopPropagation()">
        <img id="lightbox-img" src="" alt="Perbesar Foto Produk">

        <!-- Navigation buttons -->
        @if(count($images) > 1)
            <button type="button" onclick="prevLightboxSlide()" class="lightbox-nav-btn lightbox-prev" aria-label="Foto Sebelumnya" title="Foto Sebelumnya">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button type="button" onclick="nextLightboxSlide()" class="lightbox-nav-btn lightbox-next" aria-label="Foto Selanjutnya" title="Foto Selanjutnya">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </button>
        @endif
    </div>
</div>

<!-- Scoped Styles for Guaranteed Sliding & Display Across All Environments -->
<style>
    .carousel-main-viewport {
        position: relative;
        width: 100%;
        height: 440px !important;
        min-height: 400px;
        border-radius: 1.25rem;
        overflow: hidden;
        background: #0f172a;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px -2px rgba(0,0,0,0.06);
    }
    @media (max-width: 640px) {
        .carousel-main-viewport {
            height: 320px !important;
            min-height: 280px;
        }
    }
    
    /* Horizontal Sliding Track */
    .carousel-track {
        display: flex;
        width: 100%;
        height: 100%;
        transition: transform 0.65s cubic-bezier(0.25, 1, 0.5, 1);
        will-change: transform;
        cursor: zoom-in;
    }
    .carousel-slide-item {
        flex: 0 0 100%;
        width: 100%;
        height: 100%;
        position: relative;
        cursor: zoom-in;
        user-select: none;
    }
    .carousel-slide-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        cursor: zoom-in;
    }

    /* Progress bar for auto-play */
    .carousel-progress-container {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: rgba(255, 255, 255, 0.25);
        z-index: 25;
        overflow: hidden;
    }
    .carousel-progress-bar {
        height: 100%;
        width: 0%;
        background: #800000;
        box-shadow: 0 0 8px rgba(128, 0, 0, 0.8);
    }

    /* Thumbnails */
    .thumb-item {
        position: relative;
        width: 76px;
        height: 76px;
        flex-shrink: 0;
        border-radius: 0.85rem;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        background: #f1f5f9;
        cursor: pointer;
        opacity: 0.6;
        transition: all 0.25s ease;
    }
    .thumb-item:hover {
        opacity: 0.95;
        border-color: #cbd5e1;
    }
    .thumb-item.active {
        opacity: 1;
        border-color: #800000;
        box-shadow: 0 0 0 2px rgba(128, 0, 0, 0.25);
        transform: scale(1.04);
    }
    .thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Lightbox Modal */
    .lightbox-backdrop {
        position: fixed !important;
        inset: 0 !important;
        z-index: 9999999 !important;
        background: rgba(0, 0, 0, 0.95) !important;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }
    .lightbox-close-btn {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 100;
        border: none;
        transition: background 0.2s;
    }
    .lightbox-close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    .lightbox-counter {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        color: #ffffff;
        font-size: 0.875rem;
        font-weight: 600;
        background: rgba(0, 0, 0, 0.5);
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        z-index: 100;
    }
    .lightbox-content-box {
        position: relative;
        max-width: 90vw;
        max-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .lightbox-content-box img {
        max-width: 88vw;
        max-height: 82vh;
        object-fit: contain;
        border-radius: 0.75rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }
    .lightbox-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: none;
        transition: background 0.2s, transform 0.2s;
        z-index: 100;
    }
    .lightbox-nav-btn:hover {
        background: rgba(255, 255, 255, 0.45);
        transform: translateY(-50%) scale(1.1);
    }
    .lightbox-prev { left: -60px; }
    .lightbox-next { right: -60px; }
    @media (max-width: 768px) {
        .lightbox-prev { left: 10px; }
        .lightbox-next { right: 10px; }
    }
</style>

<script>
    window.imagesList = @json(array_map(fn($img) => asset('storage/' . $img), $images));
    window.currentSlideIndex = 0;
    window.currentLightboxIndex = 0;
    const totalSlides = window.imagesList.length;
    let autoplayInterval = null;
    const SLIDE_DURATION = 3000; // 3 detik per foto

    const track = document.getElementById('carousel-track');
    const progressBar = document.getElementById('carousel-progress');
    const indicator = document.getElementById('slide-indicator');

    function animateProgressBar() {
        if (!progressBar || totalSlides <= 1) return;
        progressBar.style.transition = 'none';
        progressBar.style.width = '0%';
        void progressBar.offsetWidth; // Force reflow
        progressBar.style.transition = `width ${SLIDE_DURATION}ms linear`;
        progressBar.style.width = '100%';
    }

    function showSlide(index) {
        if (totalSlides === 0) return;
        window.currentSlideIndex = (index + totalSlides) % totalSlides;

        // Slide horizontal track with smooth physics
        if (track) {
            track.style.transform = `translateX(-${window.currentSlideIndex * 100}%)`;
        }

        // Update thumbnails
        const thumbs = document.querySelectorAll('.thumb-item');
        thumbs.forEach((thumb, idx) => {
            if (idx === window.currentSlideIndex) {
                thumb.classList.add('active');
                thumb.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            } else {
                thumb.classList.remove('active');
            }
        });

        // Update indicator
        if (indicator) {
            indicator.textContent = window.currentSlideIndex + 1;
        }

        // Restart progress bar animation
        animateProgressBar();
    }

    function nextSlide() {
        showSlide(window.currentSlideIndex + 1);
    }

    function prevSlide() {
        showSlide(window.currentSlideIndex - 1);
    }

    function goToSlide(index) {
        showSlide(index);
        resetAutoplay();
    }

    function startAutoplay() {
        if (totalSlides > 1) {
            stopAutoplay();
            animateProgressBar();
            autoplayInterval = setInterval(() => {
                nextSlide();
            }, SLIDE_DURATION);
        }
    }

    function stopAutoplay() {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
            autoplayInterval = null;
        }
        if (progressBar) {
            progressBar.style.transition = 'none';
            progressBar.style.width = '0%';
        }
    }

    function resetAutoplay() {
        stopAutoplay();
        startAutoplay();
    }

    // Lightbox Controls
    function openLightbox(index) {
        if (totalSlides === 0) return;
        if (typeof index !== 'number' || isNaN(index)) {
            index = window.currentSlideIndex || 0;
        }
        window.currentLightboxIndex = index;
        updateLightboxImage();

        const modal = document.getElementById('lightbox-modal');
        if (modal) {
            modal.style.display = 'flex';
        }
        stopAutoplay();
    }

    function closeLightbox() {
        const modal = document.getElementById('lightbox-modal');
        if (modal) {
            modal.style.display = 'none';
        }
        startAutoplay();
    }

    function closeLightboxOnBackdrop(e) {
        const modal = document.getElementById('lightbox-modal');
        if (e.target === modal) {
            closeLightbox();
        }
    }

    function updateLightboxImage() {
        const img = document.getElementById('lightbox-img');
        const counter = document.getElementById('lightbox-index');
        if (img && window.imagesList && window.imagesList[window.currentLightboxIndex]) {
            img.src = window.imagesList[window.currentLightboxIndex];
        }
        if (counter) {
            counter.textContent = window.currentLightboxIndex + 1;
        }
    }

    function nextLightboxSlide() {
        window.currentLightboxIndex = (window.currentLightboxIndex + 1) % totalSlides;
        updateLightboxImage();
    }

    function prevLightboxSlide() {
        window.currentLightboxIndex = (window.currentLightboxIndex - 1 + totalSlides) % totalSlides;
        updateLightboxImage();
    }

    // Expose all functions to window for guaranteed inline onclick execution
    window.openLightbox = openLightbox;
    window.closeLightbox = closeLightbox;
    window.closeLightboxOnBackdrop = closeLightboxOnBackdrop;
    window.nextSlide = nextSlide;
    window.prevSlide = prevSlide;
    window.goToSlide = goToSlide;
    window.nextLightboxSlide = nextLightboxSlide;
    window.prevLightboxSlide = prevLightboxSlide;

    // Attach direct DOM event listeners as well
    document.addEventListener('DOMContentLoaded', () => {
        const btnPerbesar = document.getElementById('btn-perbesar-foto');
        if (btnPerbesar) {
            btnPerbesar.addEventListener('click', (e) => {
                e.stopPropagation();
                openLightbox(window.currentSlideIndex || 0);
            });
        }

        const trackEl = document.getElementById('carousel-track');
        if (trackEl) {
            trackEl.addEventListener('click', () => {
                openLightbox(window.currentSlideIndex || 0);
            });
        }

        document.querySelectorAll('.thumb-item').forEach((thumb, idx) => {
            thumb.addEventListener('click', (e) => {
                e.stopPropagation();
                goToSlide(idx);
            });
        });

        startAutoplay();
    });

    window.addEventListener('keydown', function(e) {
        const modal = document.getElementById('lightbox-modal');
        if (modal && modal.style.display !== 'none') {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextLightboxSlide();
            if (e.key === 'ArrowLeft') prevLightboxSlide();
        }
    });

    // Fallback immediate startup
    if (document.readyState !== 'loading') {
        startAutoplay();
    }
</script>
@endsection
