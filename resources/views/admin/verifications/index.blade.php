@extends('layouts.admin')

@section('page_title', 'Verifikasi Data')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- 1. Verifikasi Profil UMKM Baru -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Verifikasi Profil UMKM Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar pendaftaran profil UMKM yang menunggu persetujuan admin.</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                    {{ $pendingUmkms->count() }} Menunggu
                </span>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-sm">
                    <thead class="text-[10px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/50 border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3">Nama UMKM</th>
                            <th class="px-5 py-3">Pemilik</th>
                            <th class="px-5 py-3 text-center">Status</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pendingUmkms as $umkm)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-3.5 font-bold text-[#800000]">
                                {{ $umkm->business_name }}
                                <div class="text-[11px] font-normal text-slate-500">
                                    Kec. {{ $umkm->district ?? '-' }} @if($umkm->village) &bull; Ds. {{ $umkm->village }} @endif
                                </div>
                            </td>
                            <td class="px-5 py-3.5 font-medium text-slate-700">{{ $umkm->owner_name }}</td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-[11px] font-semibold bg-amber-50 text-amber-600 border border-amber-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Menunggu
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" onclick="openModal('umkm-modal-{{ $umkm->id }}')" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-semibold rounded-md transition-colors" title="Lihat detail lengkap UMKM">
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Detail
                                    </button>
                                    <form action="{{ route('admin.umkm.verify', $umkm->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 hover:text-emerald-700 rounded-md transition-colors" title="Setujui Langsung">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.umkm.reject', $umkm->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak pendaftaran UMKM ini?');">
                                        @csrf
                                        <button type="submit" class="p-1.5 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-md transition-colors" title="Tolak Langsung">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center">
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

        <!-- 2. Verifikasi Produk Baru -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Verifikasi Produk Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar produk baru dari UMKM yang perlu divalidasi sebelum tayang di katalog.</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                    {{ $pendingProducts->count() }} Menunggu
                </span>
            </div>
            <div class="overflow-x-auto flex-1">
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
                                    <div class="w-9 h-9 rounded-lg border border-slate-200 bg-slate-100 overflow-hidden shrink-0">
                                        @if($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-[10px]">Foto</div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 leading-none">{{ $product->name }}</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $product->category }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 font-medium">{{ $product->umkmProfile->business_name ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" onclick="openModal('product-modal-{{ $product->id }}')" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-semibold rounded-md transition-colors" title="Lihat foto & rincian produk">
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Detail
                                    </button>
                                    <form action="{{ route('admin.product.verify', $product->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 hover:text-emerald-700 rounded-md transition-colors" title="Setujui Langsung">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.product.reject', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak produk ini?');">
                                        @csrf
                                        <button type="submit" class="p-1.5 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-md transition-colors" title="Tolak Langsung">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-5 py-10 text-center">
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
</div>

<!-- ============================================== -->
<!-- MODAL DETAIL VERIFIKASI PROFIL UMKM -->
<!-- ============================================== -->
@foreach($pendingUmkms as $umkm)
<div id="umkm-modal-{{ $umkm->id }}" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-200">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-2xl overflow-hidden transform scale-95 transition-transform duration-200" onclick="event.stopPropagation()">
        <!-- Header Modal -->
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/80 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-[#800000] flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 leading-tight">{{ $umkm->business_name }}</h3>
                    <p class="text-xs text-slate-500">Pemilik: <span class="font-semibold text-slate-700">{{ $umkm->owner_name }}</span></p>
                </div>
            </div>
            <button type="button" onclick="closeModal('umkm-modal-{{ $umkm->id }}')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Body Modal -->
        <div class="p-6 max-h-[70vh] overflow-y-auto space-y-5 text-sm">
            <!-- Status Info -->
            <div class="flex items-center justify-between p-3 rounded-xl bg-amber-50 border border-amber-200/60 text-amber-800">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                    <span class="font-semibold text-xs uppercase tracking-wide">Status: Menunggu Persetujuan Admin</span>
                </div>
                <span class="text-xs text-slate-500">{{ $umkm->created_at ? $umkm->created_at->format('d M Y, H:i') : '-' }}</span>
            </div>

            <!-- Kontak & Lokasi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor WhatsApp</p>
                    <p class="font-semibold text-slate-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        {{ $umkm->phone ?? '-' }}
                    </p>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kecamatan & Desa</p>
                    <p class="font-semibold text-slate-800">
                        Kec. {{ $umkm->district ?? '-' }}
                        @if($umkm->village)
                            <span class="block text-xs font-normal text-slate-600">Desa/Kel. {{ $umkm->village }}</span>
                        @endif
                    </p>
                </div>
                <div class="sm:col-span-2 p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Lengkap</p>
                    <p class="font-bold text-slate-800 text-sm mb-1.5">{{ $umkm->full_address }}</p>
                    <div class="text-xs text-slate-600 flex flex-wrap gap-x-2 gap-y-1 bg-white p-2 rounded-lg border border-slate-200">
                        <span><strong class="text-slate-400">Provinsi:</strong> {{ $umkm->province ?? 'Jawa Tengah' }}</span>
                        <span class="text-slate-300">|</span>
                        <span><strong class="text-slate-400">Kabupaten:</strong> {{ $umkm->regency ?? 'Kabupaten Wonogiri' }}</span>
                        <span class="text-slate-300">|</span>
                        <span><strong class="text-slate-400">Kecamatan:</strong> Kec. {{ $umkm->district ?? '-' }}</span>
                        <span class="text-slate-300">|</span>
                        <span><strong class="text-slate-400">Desa:</strong> Desa {{ $umkm->village ?? '-' }}</span>
                        @if($umkm->postal_code)
                            <span class="text-slate-300">|</span>
                            <span><strong class="text-slate-400">Kode Pos:</strong> {{ $umkm->postal_code }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Deskripsi Usaha -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Deskripsi Singkat Usaha</p>
                <p class="text-slate-700 leading-relaxed">{{ $umkm->description ?: ($umkm->business_description ?: 'Tidak ada deskripsi usaha yang dicantumkan.') }}</p>
            </div>

            <!-- Dokumen Legalitas -->
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Legalitas & Sertifikasi</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="p-3 rounded-lg border border-slate-200 bg-white">
                        <span class="text-[10px] font-semibold text-slate-400 block">NIB</span>
                        <span class="font-bold text-slate-800 text-xs">{{ $umkm->nib ?: 'Tidak dilampirkan' }}</span>
                    </div>
                    <div class="p-3 rounded-lg border border-slate-200 bg-white">
                        <span class="text-[10px] font-semibold text-slate-400 block">Sertifikasi PIRT</span>
                        <span class="font-bold text-slate-800 text-xs">{{ $umkm->pirt ?: 'Tidak dilampirkan' }}</span>
                    </div>
                    <div class="p-3 rounded-lg border border-slate-200 bg-white">
                        <span class="text-[10px] font-semibold text-slate-400 block">Sertifikasi Halal</span>
                        <span class="font-bold text-slate-800 text-xs">{{ $umkm->halal_cert ?: 'Tidak dilampirkan' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Modal with Confirmation Actions -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/80 flex items-center justify-between gap-3">
            <button type="button" onclick="closeModal('umkm-modal-{{ $umkm->id }}')" class="px-4 py-2 text-xs font-semibold rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-100 transition-colors shadow-sm">
                Tutup
            </button>
            <div class="flex items-center gap-2">
                <form action="{{ route('admin.umkm.reject', $umkm->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak pengajuan profil UMKM ini?');">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-bold rounded-lg bg-white border border-red-300 text-red-600 hover:bg-red-50 transition-colors shadow-sm">
                        Tolak Pengajuan
                    </button>
                </form>
                <form action="{{ route('admin.umkm.verify', $umkm->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-bold rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white transition-colors shadow-sm flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Setujui & Verifikasi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- ============================================== -->
<!-- MODAL DETAIL VERIFIKASI PRODUK BARU -->
<!-- ============================================== -->
@foreach($pendingProducts as $product)
<div id="product-modal-{{ $product->id }}" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-200">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-2xl overflow-hidden transform scale-95 transition-transform duration-200" onclick="event.stopPropagation()">
        <!-- Header Modal -->
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/80 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 leading-tight">{{ $product->name }}</h3>
                    <p class="text-xs text-slate-500">Kategori: <span class="font-semibold text-slate-700">{{ $product->category }}</span></p>
                </div>
            </div>
            <button type="button" onclick="closeModal('product-modal-{{ $product->id }}')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Body Modal -->
        <div class="p-6 max-h-[70vh] overflow-y-auto space-y-5 text-sm">
            <!-- Status Info -->
            <div class="flex items-center justify-between p-3 rounded-xl bg-amber-50 border border-amber-200/60 text-amber-800">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                    <span class="font-semibold text-xs uppercase tracking-wide">Status: Menunggu Validasi Produk</span>
                </div>
                <span class="text-xs text-slate-500">{{ $product->created_at ? $product->created_at->format('d M Y, H:i') : '-' }}</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Foto Produk -->
                <div>
                    <div class="w-full h-56 rounded-xl border border-slate-200 overflow-hidden bg-slate-100 shadow-inner flex items-center justify-center">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-slate-400 text-center">
                                <svg class="w-12 h-12 mx-auto mb-1 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-xs">Tidak ada foto</span>
                            </div>
                        @endif
                    </div>
                    @if(count($product->all_images) > 1)
                        <div class="grid grid-cols-5 gap-2 mt-2">
                            @foreach($product->all_images as $img)
                                <img src="{{ asset('storage/' . $img) }}" alt="Preview" class="h-12 w-full object-cover rounded-lg border border-slate-200">
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Informasi UMKM & Kategori -->
                <div class="space-y-3.5">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kategori Produk</p>
                        <p class="text-base font-bold text-slate-800">{{ $product->category }}</p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">UMKM Pemilik</p>
                        <p class="font-bold text-slate-800">{{ $product->umkmProfile->business_name ?? 'Tidak ada data UMKM' }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">Pemilik: {{ $product->umkmProfile->owner_name ?? '-' }}</p>
                        @if(isset($product->umkmProfile->phone))
                            <p class="text-xs text-emerald-600 font-medium mt-1 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $product->umkmProfile->phone }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Deskripsi Produk -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Deskripsi Produk</p>
                <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $product->description ?: 'Tidak ada deskripsi produk.' }}</p>
            </div>
        </div>

        <!-- Footer Modal with Confirmation Actions -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/80 flex items-center justify-between gap-3">
            <button type="button" onclick="closeModal('product-modal-{{ $product->id }}')" class="px-4 py-2 text-xs font-semibold rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-100 transition-colors shadow-sm">
                Tutup
            </button>
            <div class="flex items-center gap-2">
                <form action="{{ route('admin.product.reject', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak produk ini?');">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-bold rounded-lg bg-white border border-red-300 text-red-600 hover:bg-red-50 transition-colors shadow-sm">
                        Tolak Produk
                    </button>
                </form>
                <form action="{{ route('admin.product.verify', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-bold rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white transition-colors shadow-sm flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Setujui Produk
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                const inner = modal.querySelector('div');
                if (inner) {
                    inner.classList.remove('scale-95');
                    inner.classList.add('scale-100');
                }
            });
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('opacity-0');
            const inner = modal.querySelector('div');
            if (inner) {
                inner.classList.remove('scale-100');
                inner.classList.add('scale-95');
            }
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }
    }

    // Tutup saat mengklik backdrop
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('backdrop-blur-sm')) {
            closeModal(e.target.id);
        }
    });

    // Tutup saat tombol ESC ditekan
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.backdrop-blur-sm:not(.hidden)').forEach(modal => {
                closeModal(modal.id);
            });
        }
    });
</script>
@endsection
