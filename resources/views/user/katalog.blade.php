@extends('layouts.app')

@section('content')
<div class="bg-red-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#800000] rounded-3xl p-10 text-white shadow-xl mb-10 relative overflow-hidden reveal">
            <!-- Decorative blobs -->
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-red-600 rounded-full mix-blend-overlay filter blur-3xl opacity-50"></div>
            
            <div class="relative z-10">
                <h1 class="text-4xl font-extrabold mb-4 reveal delay-100">Katalog Produk UMKM</h1>
                <p class="text-red-100 text-lg max-w-2xl reveal delay-200">Temukan berbagai produk unggulan dari UMKM Kabupaten Wonogiri. Mulai dari kuliner, kerajinan, fashion, hingga jasa.</p>
                
                <div class="mt-8 flex gap-4 reveal delay-300">
                    <input type="text" placeholder="Cari produk..." class="bg-red-100 w-full md:w-96 px-5 py-3 rounded-full text-slate-900 focus:outline-none focus:ring-4 focus:ring-red-400">
                    <button class="bg-white text-[#800000] font-bold px-8 py-3 rounded-full hover:bg-red-50 transition-colors shadow-lg">Cari</button>
                </div>
            </div>
        </div>
        
        <!-- Grid Produk -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @for ($i = 1; $i <= 8; $i++)
            <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-red-100 group cursor-pointer reveal" style="transition-delay: {{ $i * 50 }}ms;">
                <div class="h-48 bg-red-100 relative overflow-hidden">
                    <div class="absolute inset-0 bg-[#800000]/10 group-hover:bg-transparent transition-colors"></div>
                    <div class="absolute top-3 right-3 bg-white text-[#800000] text-xs font-bold px-3 py-1 rounded-full shadow-sm">Kuliner</div>
                    <!-- Placeholder image pattern -->
                    <svg class="w-full h-full text-red-200" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                </div>
                <div class="p-5">
                    <div class="text-xs text-red-600 font-bold mb-1 uppercase tracking-wide">UMKM Maju Bersama</div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-[#800000] transition-colors">Produk Contoh {{ $i }}</h3>
                    <div class="text-xl font-extrabold text-[#800000] mb-4">Rp 50.000</div>
                    <button class="w-full bg-red-50 hover:bg-[#800000] text-[#800000] hover:text-white border border-red-200 font-semibold py-2 rounded-xl transition-colors">
                        Lihat Detail
                    </button>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>
@endsection
