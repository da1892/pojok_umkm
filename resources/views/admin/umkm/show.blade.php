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
            <div>
                <h3 class="text-lg font-bold text-slate-800">{{ $umkm->business_name }}</h3>
                <p class="text-sm text-slate-500">Pemilik: {{ $umkm->owner_name }}</p>
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
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
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
                <div>
                    <span class="text-slate-400 block text-[10px] font-semibold uppercase mb-0.5">Format Alamat Lengkap</span>
                    <p class="text-sm font-bold text-slate-800">{{ $umkm->full_address }}</p>
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
@endsection
