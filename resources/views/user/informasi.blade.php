@extends('layouts.app')

@section('content')
<div class="bg-red-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#800000] rounded-3xl p-10 text-white shadow-xl mb-10 relative overflow-hidden reveal">
            <!-- Decorative blobs -->
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-red-600 rounded-full mix-blend-overlay filter blur-3xl opacity-50"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="md:w-2/3">
                    <div class="inline-block bg-white text-[#800000] text-xs font-bold px-3 py-1 rounded-full mb-3 reveal delay-100 uppercase tracking-wider">Pusat Informasi</div>
                    <h1 class="text-4xl font-extrabold mb-4 reveal delay-200">Berita & Informasi UMKM</h1>
                    <p class="text-red-100 text-lg reveal delay-300">Dapatkan update terbaru mengenai program pemerintah, jadwal pelatihan, pameran, dan regulasi terkait perizinan UMKM di Kabupaten Wonogiri.</p>
                </div>
                <div class="md:w-1/3 w-full reveal delay-400">
                    <input type="text" placeholder="Cari artikel..." class="w-full bg-red-900/50 border border-red-500/50 px-5 py-3 rounded-full text-white placeholder-red-200 focus:outline-none focus:ring-2 focus:ring-white">
                </div>
            </div>
        </div>
        
        <!-- Kategori Tabs -->
        <div class="flex overflow-x-auto gap-4 mb-8 pb-2 hide-scrollbar reveal delay-300">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @for ($i = 1; $i <= 4; $i++)
            <div class="bg-white rounded-2xl overflow-hidden shadow-md border border-red-100 flex flex-col md:flex-row group hover:shadow-xl transition-all duration-300 reveal delay-{{ $i * 100 }}">
                <div class="w-full md:w-1/3 bg-red-100 h-48 md:h-auto flex items-center justify-center text-red-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-tr from-[#800000]/80 to-red-500/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <svg class="w-16 h-16 z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2"></path></svg>
                </div>
                <div class="p-6 w-full md:w-2/3 flex flex-col justify-center">
                    <div class="text-xs text-[#800000] font-bold mb-2 uppercase tracking-wide">Pelatihan & Workshop</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-[#800000] transition-colors">Digitalisasi Pemasaran UMKM Menembus Pasar Global {{ $i }}</h3>
                    <p class="text-slate-600 text-sm mb-4 line-clamp-2">Ikuti pelatihan intensif tentang bagaimana memasarkan produk Anda menggunakan media sosial dan e-commerce untuk menjangkau pasar yang lebih luas.</p>
                    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mt-auto">
                        <svg class="w-4 h-4 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        12 Oktober 2026
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>
@endsection
