@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-800">Detail Pengajuan UMKM</h2>
        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
            <h3 class="text-lg font-bold text-slate-800">{{ $umkm->business_name }}</h3>
            <p class="text-sm text-slate-500">Pemilik: {{ $umkm->owner_name }}</p>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor WhatsApp</p>
                <p class="text-sm font-semibold text-slate-800">{{ $umkm->whatsapp_number ?? '-' }}</p>
            </div>
            
            <div class="md:col-span-2">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Produksi</p>
                <p class="text-sm font-semibold text-slate-800">{{ $umkm->address ?? '-' }}</p>
            </div>
            
            <div class="md:col-span-2">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Deskripsi Singkat Usaha</p>
                <p class="text-sm font-semibold text-slate-800">{{ $umkm->business_description ?? '-' }}</p>
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

        <div class="px-6 py-5 border-t border-slate-200 bg-slate-50/50 flex justify-end gap-3">
            <form action="{{ route('admin.umkm.reject', $umkm->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-5 py-2.5 text-sm font-bold rounded-lg bg-white border border-[#800000] text-[#800000] hover:bg-red-50 transition-colors shadow-sm focus:ring focus:ring-red-200">
                    Tolak Pengajuan
                </button>
            </form>
            <form action="{{ route('admin.umkm.verify', $umkm->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-5 py-2.5 text-sm font-bold rounded-lg bg-emerald-500 text-white hover:bg-emerald-600 transition-colors shadow-sm focus:ring focus:ring-emerald-200">
                    Setujui & Verifikasi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
