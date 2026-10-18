@extends('layouts.admin')

@section('page_title', 'Kelola Produk')

@section('content')
<div class="space-y-6">
    <!-- Header Section with stats/actions -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-[#800000] flex items-center justify-center border border-red-100 shadow-2xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 text-lg">Daftar Produk UMKM Wonogiri</h3>
                    <p class="text-slate-500 text-xs mt-0.5">Kelola katalog produk terkurasi yang tampil kepada calon pembeli.</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                Total: {{ $products->total() ?? count($products) }} Produk
            </span>
        </div>
    </div>

    <!-- Products Table Card -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">UMKM & Wilayah</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3.5">
                                <div class="relative w-14 h-14 rounded-xl overflow-hidden bg-slate-100 border border-slate-200/80 shrink-0 group-hover:shadow-xs transition-shadow">
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @if(count($product->all_images) > 1)
                                    <span class="absolute bottom-1 right-1 px-1 py-0.2 rounded text-[8px] font-bold bg-black/70 text-white backdrop-blur-2xs">
                                        +{{ count($product->all_images) - 1 }}
                                    </span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-800 text-sm leading-snug group-hover:text-[#800000] transition-colors truncate max-w-xs md:max-w-md">
                                        {{ $product->name }}
                                    </p>
                                    <p class="text-xs text-slate-400 truncate max-w-xs mt-0.5">
                                        {{ Str::limit($product->description, 55) }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-800 text-sm">
                                {{ $product->umkmProfile->business_name ?? '-' }}
                            </div>
                            <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                Kec. {{ $product->umkmProfile->district ?? '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-50 text-[#800000] border border-red-100">
                                {{ $product->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusInfo = match(strtolower($product->status ?? 'active')) {
                                    'verified', 'active' => [
                                        'label' => 'Disetujui',
                                        'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'dot' => 'bg-emerald-500'
                                    ],
                                    'pending' => [
                                        'label' => 'Menunggu Persetujuan',
                                        'class' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'dot' => 'bg-amber-500 animate-pulse'
                                    ],
                                    'rejected' => [
                                        'label' => 'Ditolak',
                                        'class' => 'bg-red-50 text-red-700 border-red-200',
                                        'dot' => 'bg-red-500'
                                    ],
                                    default => [
                                        'label' => 'Disetujui',
                                        'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'dot' => 'bg-emerald-500'
                                    ]
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $statusInfo['class'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $statusInfo['dot'] }}"></span>
                                {{ $statusInfo['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.product.edit', $product->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-slate-700 hover:text-[#800000] bg-slate-100 hover:bg-red-50 rounded-lg transition-colors border border-slate-200/60" title="Edit Produk">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold text-red-600 hover:text-white hover:bg-red-600 rounded-lg transition-colors border border-red-200" title="Hapus Produk">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mb-2 text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </div>
                                <span class="font-bold text-sm text-slate-600">Belum ada produk</span>
                                <span class="text-xs text-slate-400 mt-0.5">Produk dari UMKM yang telah diverifikasi akan muncul di sini.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="p-4 border-t border-slate-200/80 bg-slate-50/50">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
