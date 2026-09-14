@extends('layouts.app')

@section('content')
<div class="bg-red-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-10 shadow-xl mb-10 relative overflow-hidden border border-red-100 reveal">
            <!-- Decorative corner -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-[#800000] rounded-full opacity-10"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h1 class="text-4xl font-extrabold text-[#800000] mb-2 reveal delay-100">Direktori UMKM</h1>
                    <p class="text-slate-600 text-lg reveal delay-200">Kenali lebih dekat profil usaha lokal yang beroperasi di Wonogiri.</p>
                </div>
                <div class="w-full md:w-auto flex gap-3 reveal delay-300">
                    <select class="bg-red-50 border border-red-100 text-slate-700 text-sm rounded-full focus:ring-[#800000] focus:border-[#800000] block p-3 px-5">
                        <option selected>Semua Kategori</option>
                        <option value="kuliner">Kuliner</option>
                        <option value="kerajinan">Kerajinan</option>
                        <option value="fashion">Fashion</option>
                    </select>
                    <button class="bg-[#800000] text-white px-6 py-3 rounded-full font-medium hover:bg-[#600000] transition-colors shadow-md">Filter</button>
                </div>
            </div>
        </div>
        
        <!-- Grid UMKM -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @for ($i = 1; $i <= 6; $i++)
            <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all border border-slate-100 group relative reveal" style="transition-delay: {{ $i * 100 }}ms;">
                <div class="w-20 h-20 bg-red-100 rounded-full flex-shrink-0 flex items-center justify-center text-[#800000]">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div class="mt-4">
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-[#800000] transition-colors">UMKM Wonogiri Sukses {{ $i }}</h3>
                    <div class="text-sm text-slate-500 mb-2 flex items-center gap-1 mt-1">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Kec. Wonogiri
                    </div>
                    <div class="flex gap-2">
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md">Terverifikasi</span>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>
@endsection
