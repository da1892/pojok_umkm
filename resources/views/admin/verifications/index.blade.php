@extends('layouts.admin')

@section('page_title', 'Verifikasi Data')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Verifikasi Profil UMKM -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-200 bg-slate-50/50">
            <h3 class="font-bold text-slate-800">Verifikasi Profil UMKM Baru</h3>
            <p class="text-xs text-slate-500 mt-1">Daftar pendaftaran profil toko UMKM yang menunggu persetujuan admin.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-[10px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3">Nama Usaha</th>
                        <th class="px-5 py-3">Pemilik</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pendingUmkms as $umkm)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-5 py-3.5 font-medium text-slate-900">{{ $umkm->business_name }}</td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $umkm->owner_name }}</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-[11px] font-semibold bg-amber-50 text-amber-600 border border-amber-200/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <a href="{{ route('admin.umkm.show', $umkm->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900 text-xs font-semibold rounded-md transition-colors">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center">
                            <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-2 border border-slate-100">
                                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <p class="text-sm font-medium text-slate-500">Tidak ada pengajuan baru</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Verifikasi Produk Baru -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-200 bg-slate-50/50">
            <h3 class="font-bold text-slate-800">Verifikasi Produk Baru</h3>
            <p class="text-xs text-slate-500 mt-1">Daftar produk baru dari UMKM yang perlu divalidasi sebelum tayang di katalog.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-[10px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3">Nama Produk</th>
                        <th class="px-5 py-3">UMKM</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pendingProducts as $product)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded border border-slate-200 bg-slate-100 overflow-hidden shrink-0">
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                </div>
                                <div>
                                    <p class="font-medium text-slate-900 leading-none">{{ $product->name }}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ $product->category }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $product->umkmProfile->business_name ?? '-' }}</td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.product.verify', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-1.5 bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 rounded-md transition-colors" title="Setujui">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.product.reject', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak produk ini?');">
                                    @csrf
                                    <button type="submit" class="p-1.5 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-md transition-colors" title="Tolak">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-5 py-8 text-center">
                            <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-2 border border-slate-100">
                                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <p class="text-sm font-medium text-slate-500">Tidak ada produk baru</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
