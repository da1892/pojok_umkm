@extends('user.layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Hero Header -->
        <div class="bg-[#800000] rounded-3xl p-8 sm:p-12 text-white shadow-xl mb-10 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-red-600 rounded-full mix-blend-overlay filter blur-3xl opacity-50 pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="md:w-2/3">
                    <span class="inline-block bg-white text-[#800000] text-xs font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider">
                        Pusat Informasi & Kegiatan
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold mb-3">Berita & Kegiatan UMKM Wonogiri</h1>
                    <p class="text-red-100 text-sm sm:text-base leading-relaxed">
                        Dapatkan update terpercaya mengenai program bimbingan teknis, fasilitasi perizinan, sertifikasi halal gratis, dan festival produk UMKM di Kabupaten Wonogiri.
                    </p>
                </div>
                
                <div class="w-full md:w-1/3">
                    <form action="{{ route('informasi') }}" method="GET" class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita atau agenda..." 
                               class="w-full bg-white/15 border border-white/30 px-5 py-3 rounded-2xl text-white placeholder-red-200 focus:outline-none focus:ring-2 focus:ring-white text-sm">
                        <button type="submit" class="absolute right-3 top-3 text-white/70 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- News Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($newsList as $item)
            @php
                $itemImg = $item->image_path ? (str_starts_with($item->image_path, 'http') || str_starts_with($item->image_path, 'img/') ? asset($item->image_path) : asset('storage/' . $item->image_path)) : asset('img/news/bimtek.jpg');
            @endphp
            <div class="bg-white rounded-2xl overflow-hidden shadow-xs hover:shadow-lg border border-slate-200/80 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="h-52 w-full overflow-hidden bg-slate-100 relative">
                        <img src="{{ $itemImg }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-white/90 backdrop-blur-xs text-[#800000] shadow-xs">
                            {{ $item->category }}
                        </span>
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-bold text-[#b91c1c] mb-2 block">
                            {{ $item->created_at ? $item->created_at->translatedFormat('d F Y') : '-' }}
                        </span>
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-[#800000] transition-colors leading-snug mb-2 line-clamp-2">
                            {{ $item->title }}
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                            {{ $item->excerpt ?: Str::limit(strip_tags($item->content), 120) }}
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-0 border-t border-slate-50 mt-4 flex items-center justify-between">
                    <span class="text-xs text-slate-400">Oleh Admin Pojok UMKM</span>
                    <a href="{{ route('informasi.show', $item->id) }}" class="text-xs font-bold text-[#800000] hover:text-red-900 inline-flex items-center gap-1">
                        Baca Lengkap &rarr;
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-16 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2"></path></svg>
                </div>
                <h3 class="font-bold text-slate-700 text-base">Belum ada berita atau kegiatan yang dipublikasikan</h3>
                <p class="text-xs text-slate-400 mt-1">Silakan kunjungi kembali halaman ini nanti.</p>
            </div>
            @endforelse
        </div>

        @if($newsList->hasPages())
        <div class="mt-10">
            {{ $newsList->links() }}
        </div>
        @endif

    </div>
</div>
@endsection
