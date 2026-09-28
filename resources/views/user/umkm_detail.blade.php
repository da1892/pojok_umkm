@extends('user.layouts.app')

@section('content')
<div class="bg-[#FAF9F6] min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-8 font-medium">
            <a href="/" class="hover:text-[#800000] transition-colors">Beranda</a>
            <span>/</span>
            <a href="/direktori" class="hover:text-[#800000] transition-colors">Direktori UMKM</a>
            <span>/</span>
            <span class="text-slate-800">{{ $umkm->business_name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- UMKM Profile Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Main Info Card -->
                <div class="bg-white rounded-[24px] p-8 shadow-sm border border-slate-100 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-24 bg-[#800000]"></div>
                    
                    <div class="relative w-32 h-32 mx-auto mt-4 mb-4 bg-white rounded-full p-2 shadow-md">
                        <div class="w-full h-full rounded-full bg-slate-100 flex items-center justify-center border border-slate-200">
                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                    </div>
                    
                    <h1 class="text-2xl font-bold text-slate-900">{{ $umkm->business_name }}</h1>
                    <p class="text-slate-500 text-sm mt-1">{{ $umkm->owner_name }}</p>
                    
                    <div class="mt-6 flex flex-col gap-3 text-sm text-left">
                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl">
                            <svg class="w-5 h-5 text-[#800000] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-slate-600 leading-relaxed">{{ $umkm->address }}<br>{{ $umkm->district }}, Wonogiri</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                            <svg class="w-5 h-5 text-[#800000] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span class="text-slate-600">{{ $umkm->phone }}</span>
                        </div>
                    </div>
                </div>

                <!-- Google Maps Embed (Dummy Map to Wonogiri region) -->
                <div class="bg-white rounded-[24px] overflow-hidden shadow-sm border border-slate-100">
                    <div class="p-5 border-b border-slate-100">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            Peta Lokasi
                        </h3>
                    </div>
                    <div class="w-full h-64 bg-slate-200">
                        <!-- Simulated Map -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126462.66258957442!2d110.84092289650072!3d-7.86903746654876!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a2e88a0db8d3b%3A0x3027a76e352bbf0!2sKabupaten%20Wonogiri%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            <!-- Products List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[24px] p-8 shadow-sm border border-slate-100 mb-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center justify-between">
                        Katalog Produk Usaha
                        <span class="text-sm font-medium text-slate-500 bg-slate-100 px-3 py-1 rounded-full">{{ $umkm->products->where('status', 'verified')->count() }} Produk</span>
                    </h2>
                    
                    @if($umkm->products->where('status', 'verified')->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($umkm->products->where('status', 'verified') as $product)
                            <a href="{{ route('katalog.show', $product->id) }}" class="group block bg-white rounded-2xl overflow-hidden shadow-xs border border-slate-200 hover:shadow-lg transition-all duration-300">
                                <div class="relative h-48 overflow-hidden bg-slate-100">
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                                <div class="p-4">
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-[#991b1b] mb-1">{{ $product->category }}</div>
                                    <h3 class="font-bold text-slate-800 text-sm mb-2 group-hover:text-[#991b1b] transition-colors line-clamp-1">{{ $product->name }}</h3>
                                    <div class="font-bold text-slate-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-slate-50 rounded-2xl border border-slate-100 border-dashed">
                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <p class="text-slate-500 font-medium">UMKM ini belum memiliki produk terverifikasi.</p>
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
