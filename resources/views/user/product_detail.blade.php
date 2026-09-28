@extends('user.layouts.app')

@section('content')
<div class="bg-[#FAF9F6] min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-8 font-medium">
            <a href="/" class="hover:text-[#800000] transition-colors">Beranda</a>
            <span>/</span>
            <a href="/katalog" class="hover:text-[#800000] transition-colors">Katalog</a>
            <span>/</span>
            <span class="text-slate-800">{{ $product->name }}</span>
        </nav>

        <div class="bg-white rounded-[24px] overflow-hidden shadow-sm border border-slate-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                <!-- Product Image -->
                <div class="relative bg-slate-100 h-[400px] md:h-auto">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div class="absolute top-6 right-6">
                        <span class="bg-white/90 backdrop-blur text-[#800000] text-xs font-bold px-4 py-1.5 rounded-full shadow-sm">
                            {{ $product->category }}
                        </span>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">{{ $product->name }}</h1>
                    
                    <div class="text-2xl font-bold text-[#800000] mb-8">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                    
                    <div class="prose prose-sm prose-slate mb-8 max-w-none">
                        <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-2">Deskripsi Produk</h4>
                        <p class="text-slate-600 leading-relaxed whitespace-pre-wrap">{{ $product->description }}</p>
                    </div>
                    
                    <!-- UMKM Profile Card -->
                    <div class="mt-auto pt-8 border-t border-slate-100">
                        <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Diproduksi Oleh</h4>
                        
                        <div class="bg-slate-50 rounded-2xl p-4 flex items-center justify-between border border-slate-100">
                            <div>
                                <h5 class="font-bold text-slate-900">{{ $product->umkmProfile->business_name ?? 'UMKM Tidak Diketahui' }}</h5>
                                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $product->umkmProfile->district ?? '-' }}, Wonogiri
                                </p>
                            </div>
                            @if($product->umkmProfile)
                            <a href="{{ route('direktori.show', $product->umkmProfile->id) }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-100 transition-colors shadow-sm">
                                Lihat Profil
                            </a>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
