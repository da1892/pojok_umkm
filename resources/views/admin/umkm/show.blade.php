@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-800">Detail Data UMKM</h2>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.umkm.edit', $umkm->id) }}" class="text-sm font-semibold text-[#800000] hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-lg transition-colors">
                Edit Profil
            </a>
            <a href="{{ route('admin.stores') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                @if($umkm->image_path)
                    <img src="{{ asset('storage/' . $umkm->image_path) }}" alt="{{ $umkm->business_name }}" class="w-14 h-14 rounded-2xl object-cover border-2 border-white ring-1 ring-slate-200 shadow-sm shrink-0">
                @else
                    <div class="w-14 h-14 rounded-2xl bg-[#800000] text-white flex items-center justify-center font-bold text-xl shrink-0 shadow-sm">
                        {{ strtoupper(substr($umkm->business_name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h3 class="text-lg font-bold text-slate-800">{{ $umkm->business_name }}</h3>
                    <p class="text-sm text-slate-500">Pemilik: <span class="font-semibold text-slate-700">{{ $umkm->owner_name }}</span> @if($umkm->gender) <span class="text-xs text-slate-500 font-normal">({{ $umkm->gender }})</span> @endif</p>
                </div>
            </div>
            <div>
                @if($umkm->status == 'verified')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Disetujui
                    </span>
                @elseif($umkm->status == 'pending')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        Menunggu Persetujuan
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        Ditolak
                    </span>
                @endif
            </div>
        </div>
        
        @if($umkm->status == 'rejected' && !empty($umkm->rejection_note))
            <div class="mx-6 mt-6 p-5 rounded-2xl bg-gradient-to-r from-red-50 to-rose-50/50 border border-red-200/80 shadow-xs">
                <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 shadow-xs ring-4 ring-red-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-600 text-white uppercase tracking-wider">Status Ditolak</span>
                            <h4 class="text-xs font-bold text-red-950 uppercase tracking-wider">Catatan / Alasan Penolakan dari Admin:</h4>
                        </div>
                        <div class="p-3.5 bg-white/90 rounded-xl border border-red-100 text-sm font-medium text-slate-800 leading-relaxed shadow-2xs">
                            {!! nl2br(e($umkm->rejection_note)) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nama & Jenis Kelamin Pemilik</p>
                <div class="text-sm font-semibold text-slate-800 flex items-center gap-2">
                    <span>{{ $umkm->owner_name }}</span>
                    @if($umkm->gender === 'Laki-laki')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                            <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Laki-laki
                        </span>
                    @elseif($umkm->gender === 'Perempuan')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-pink-50 text-pink-700 border border-pink-200">
                            <svg class="w-3 h-3 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Perempuan
                        </span>
                    @endif
                </div>
            </div>

            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor WhatsApp</p>
                <p class="text-sm font-semibold text-slate-800">{{ $umkm->phone ?? '-' }}</p>
            </div>
            
            <div class="md:col-span-2 bg-slate-50/80 p-4 rounded-xl border border-slate-200/80">
                <p class="text-[11px] font-bold text-[#800000] uppercase tracking-wider mb-3">Wilayah & Alamat Lengkap</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs mb-3 pb-3 border-b border-slate-200">
                    <div>
                        <span class="text-slate-400 block text-[10px] font-semibold uppercase">Provinsi</span>
                        <span class="font-bold text-slate-800">{{ $umkm->province ?? 'Jawa Tengah' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] font-semibold uppercase">Kabupaten</span>
                        <span class="font-bold text-slate-800">{{ $umkm->regency ?? 'Kabupaten Wonogiri' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] font-semibold uppercase">Kecamatan</span>
                        <span class="font-bold text-slate-800">Kec. {{ $umkm->district ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] font-semibold uppercase">Desa / Kelurahan</span>
                        <span class="font-bold text-slate-800">Desa {{ $umkm->village ?? '-' }}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <span class="text-slate-400 block text-[10px] font-semibold uppercase mb-0.5">Format Alamat Lengkap</span>
                    <p class="text-sm font-bold text-slate-800">{{ $umkm->full_address }}</p>
                </div>
                <!-- Peta Lokasi UMKM Otomatis -->
                <div class="rounded-xl overflow-hidden border border-slate-200 mt-3 bg-white">
                    <div class="p-2.5 bg-slate-100 flex items-center justify-between text-xs">
                        <span class="font-bold text-slate-700 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Peta Lokasi UMKM (Terbaca Otomatis dari Alamat)
                        </span>
                        <a href="{{ $umkm->google_maps_directions_url }}" target="_blank" class="text-xs font-bold text-[#800000] hover:underline flex items-center gap-1">
                            Buka di Google Maps &rarr;
                        </a>
                    </div>
                    <div class="w-full h-48 bg-slate-100">
                        <iframe src="{{ $umkm->google_maps_embed_url }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
            
            <div class="md:col-span-2">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Deskripsi Singkat Usaha</p>
                <p class="text-sm font-semibold text-slate-800">{{ $umkm->description ?? $umkm->business_description ?? '-' }}</p>
            </div>
            
            <div class="pt-4 border-t border-slate-100 md:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Induk Berusaha (NIB)</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $umkm->nib ?? 'Tidak dilampirkan' }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Sertifikasi PIRT</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $umkm->pirt ?? 'Tidak dilampirkan' }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Sertifikasi Halal</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $umkm->halal_cert ?? 'Tidak dilampirkan' }}</p>
                </div>
            </div>
        </div>

        <!-- Bagian Daftar Produk -->
        <div class="px-6 py-5 border-t border-slate-200 bg-white">
            <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4">Daftar Produk UMKM</h4>
            @if(isset($umkm->products) && $umkm->products->count() > 0)
                <div class="overflow-x-auto border border-slate-200 rounded-lg">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold">
                            <tr>
                                <th class="px-4 py-3">Nama Produk</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($umkm->products as $product)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-medium text-slate-800">{{ $product->name }}</td>
                                <td class="px-4 py-3">{{ $product->category }}</td>
                                <td class="px-4 py-3">
                                    @if($product->status == 'verified')
                                        <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded">Disetujui</span>
                                    @elseif($product->status == 'pending')
                                        <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded">Menunggu Persetujuan</span>
                                    @else
                                        <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-1 rounded">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-sm text-slate-500 italic bg-slate-50 p-4 rounded-lg border border-dashed border-slate-300 text-center">
                    UMKM ini belum menambahkan produk apapun.
                </div>
            @endif
        </div>

        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50 flex flex-wrap items-center justify-between gap-3">
            <span class="text-xs text-slate-500">Terdaftar pada: {{ $umkm->created_at ? $umkm->created_at->format('d M Y, H:i') : '-' }}</span>
            <div class="flex items-center gap-3">
                @if($umkm->status == 'pending')
                    <button type="button" onclick="openRejectUmkmModal('{{ route('admin.umkm.reject', $umkm->id) }}', '{{ addslashes($umkm->business_name) }}')" class="px-4 py-2 text-xs font-bold rounded-lg bg-white border border-red-300 text-red-600 hover:bg-red-50 transition-colors shadow-sm">
                        Tolak Pengajuan
                    </button>
                    <form action="{{ route('admin.umkm.verify', $umkm->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-xs font-bold rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white transition-colors shadow-sm flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Setujui & Verifikasi
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.stores') }}" class="px-4 py-2 text-sm font-semibold rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                    Kembali ke Data UMKM
                </a>
                <a href="{{ route('admin.umkm.edit', $umkm->id) }}" class="px-4 py-2 text-sm font-semibold rounded-lg bg-[#800000] text-white hover:bg-red-800 transition-colors shadow-sm">
                    Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TOLAK PENDAFTARAN BUKA TOKO UMKM -->
<div id="reject-umkm-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md hidden opacity-0 transition-opacity duration-200">
    <div id="reject-umkm-card" class="bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border border-slate-100 transform scale-95 transition-all duration-200">
        <!-- Top Danger Gradient Line -->
        <div class="h-1.5 w-full bg-gradient-to-r from-red-500 via-rose-600 to-[#800000]"></div>

        <form id="reject-umkm-form" method="POST" action="">
            @csrf
            
            <!-- Modal Header -->
            <div class="px-6 py-4.5 bg-gradient-to-b from-red-50/70 to-white border-b border-red-100/80 flex items-center justify-between">
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-red-500 to-rose-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-red-500/20 ring-4 ring-red-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base leading-tight">Tolak Pengajuan Buka Toko UMKM</h3>
                        <div class="flex items-center gap-1.5 mt-1">
                            <span class="text-[11px] font-medium text-slate-500">Toko:</span>
                            <span id="reject-modal-umkm-name" class="inline-flex items-center px-2 py-0.5 rounded-md bg-red-100/70 text-red-700 border border-red-200/80 text-xs font-bold truncate max-w-[240px]"></span>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="closeRejectUmkmModal()" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-full transition-colors cursor-pointer" title="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4">
                <!-- Info Alert -->
                <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-amber-50/90 border border-amber-200/80 text-amber-900 text-xs leading-relaxed">
                    <div class="w-5 h-5 rounded-md bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 mt-0.5 font-bold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <span class="font-bold block text-amber-950 mb-0.5">Catatan Terbaca Langsung oleh Pelaku UMKM</span>
                        Komentar ini akan muncul di dashboard toko agar pelaku usaha dapat memperbaiki berkas atau data yang kurang sebelum mengajukan ulang.
                    </div>
                </div>

                <!-- Textarea Form Field -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="reject-modal-note" class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <span>Alasan / Komentar Penolakan</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700 border border-red-200">Wajib Diisi</span>
                        </label>
                    </div>
                    <textarea name="rejection_note" id="reject-modal-note" rows="4" required class="w-full px-4 py-3 bg-slate-50/60 hover:bg-slate-50 focus:bg-white border border-slate-300 focus:border-red-500 rounded-2xl text-sm text-slate-800 placeholder:text-slate-400 focus:ring-4 focus:ring-red-500/10 outline-none transition-all resize-y leading-relaxed shadow-2xs" placeholder="Tuliskan alasan penolakan secara jelas (misal: Dokumen NIB belum sesuai, foto produk kurang jelas, alamat belum lengkap)..."></textarea>
                </div>

                <!-- Template Catatan Cepat -->
                <div class="pt-1">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-slate-500 tracking-wide flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.001z"/></svg>
                            Template Catatan Cepat:
                        </span>
                        <span class="text-[10px] text-slate-400 italic">Klik untuk mengisi</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" onclick="addRejectTemplate('Dokumen Nomor Induk Berusaha (NIB) tidak valid atau belum terlampir dengan benar.')" class="group flex items-center gap-2 p-2 rounded-xl text-left text-xs font-semibold bg-slate-50 hover:bg-red-50/80 text-slate-700 hover:text-red-700 border border-slate-200 hover:border-red-200 transition-all active:scale-98 cursor-pointer">
                            <span class="w-6 h-6 rounded-lg bg-white border border-slate-200 group-hover:border-red-200 group-hover:bg-red-100/50 flex items-center justify-center shrink-0 text-slate-500 group-hover:text-red-600 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </span>
                            <span class="truncate">NIB Belum Sesuai</span>
                        </button>
                        <button type="button" onclick="addRejectTemplate('Foto profil toko atau produk belum memenuhi standar kejelasan visual.')" class="group flex items-center gap-2 p-2 rounded-xl text-left text-xs font-semibold bg-slate-50 hover:bg-red-50/80 text-slate-700 hover:text-red-700 border border-slate-200 hover:border-red-200 transition-all active:scale-98 cursor-pointer">
                            <span class="w-6 h-6 rounded-lg bg-white border border-slate-200 group-hover:border-red-200 group-hover:bg-red-100/50 flex items-center justify-center shrink-0 text-slate-500 group-hover:text-red-600 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </span>
                            <span class="truncate">Foto Kurang Jelas</span>
                        </button>
                        <button type="button" onclick="addRejectTemplate('Alamat fisik toko atau nama desa/kecamatan belum sesuai dengan wilayah Kabupaten Wonogiri.')" class="group flex items-center gap-2 p-2 rounded-xl text-left text-xs font-semibold bg-slate-50 hover:bg-red-50/80 text-slate-700 hover:text-red-700 border border-slate-200 hover:border-red-200 transition-all active:scale-98 cursor-pointer">
                            <span class="w-6 h-6 rounded-lg bg-white border border-slate-200 group-hover:border-red-200 group-hover:bg-red-100/50 flex items-center justify-center shrink-0 text-slate-500 group-hover:text-red-600 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            <span class="truncate">Alamat Belum Lengkap</span>
                        </button>
                        <button type="button" onclick="addRejectTemplate('Deskripsi profil usaha belum memuat rincian yang cukup mengenai jenis produk yang diproduksi/dijual.')" class="group flex items-center gap-2 p-2 rounded-xl text-left text-xs font-semibold bg-slate-50 hover:bg-red-50/80 text-slate-700 hover:text-red-700 border border-slate-200 hover:border-red-200 transition-all active:scale-98 cursor-pointer">
                            <span class="w-6 h-6 rounded-lg bg-white border border-slate-200 group-hover:border-red-200 group-hover:bg-red-100/50 flex items-center justify-center shrink-0 text-slate-500 group-hover:text-red-600 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </span>
                            <span class="truncate">Deskripsi Kurang Rinci</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" onclick="closeRejectUmkmModal()" class="px-5 py-2.5 text-xs font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-100 hover:text-slate-800 shadow-2xs transition-all cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold text-white bg-gradient-to-r from-red-600 via-red-700 to-[#800000] hover:from-red-700 hover:to-[#660000] rounded-xl shadow-md shadow-red-500/20 active:scale-98 transition-all flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Kirim Penolakan dengan Komentar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectUmkmModal(actionUrl, umkmName) {
        const modal = document.getElementById('reject-umkm-modal');
        const form = document.getElementById('reject-umkm-form');
        const nameEl = document.getElementById('reject-modal-umkm-name');
        const noteEl = document.getElementById('reject-modal-note');

        if (form) form.action = actionUrl;
        if (nameEl) nameEl.textContent = umkmName || 'Toko UMKM';
        if (noteEl) noteEl.value = '';

        if (modal) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                const inner = document.getElementById('reject-umkm-card') || modal.querySelector('div');
                if (inner) {
                    inner.classList.remove('scale-95');
                    inner.classList.add('scale-100');
                }
                if (noteEl) noteEl.focus();
            }, 10);
        }
    }

    function closeRejectUmkmModal() {
        const modal = document.getElementById('reject-umkm-modal');
        if (modal) {
            modal.classList.add('opacity-0');
            const inner = document.getElementById('reject-umkm-card') || modal.querySelector('div');
            if (inner) {
                inner.classList.remove('scale-100');
                inner.classList.add('scale-95');
            }
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }
    }

    function addRejectTemplate(text) {
        const noteEl = document.getElementById('reject-modal-note');
        if (noteEl) {
            const currentVal = noteEl.value.trim();
            if (currentVal === '') {
                noteEl.value = text;
            } else {
                noteEl.value = currentVal + '\n- ' + text;
            }
            noteEl.focus();
        }
    }

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeRejectUmkmModal();
        }
    });
</script>
@endsection
