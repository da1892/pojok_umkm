@extends('user.layouts.app')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb & Top Navigation -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <nav class="flex items-center gap-2 text-sm text-slate-500 font-medium">
                <a href="/" class="hover:text-[#800000] transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('toko.index') }}" class="hover:text-[#800000] transition-colors">UMKM</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Profil UMKM</span>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('toko.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-all shadow-xs">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Katalog Produk
                </a>
                <a href="{{ route('direktori.show', $umkm->id) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold bg-red-50 border border-red-200 text-[#800000] hover:bg-red-100 transition-all shadow-xs" title="Lihat tampilan profil toko Anda di direktori publik">
                    <svg class="w-4 h-4 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Lihat Profil Toko Publik
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 shadow-xs">
                <div class="flex items-start gap-3">
                    <span class="w-8 h-8 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    <div>
                        <h3 class="text-sm font-bold text-red-800">Terdapat kesalahan pada isian formulir:</h3>
                        <ul class="list-disc pl-5 mt-1 text-xs text-red-700 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if($umkm->status == 'rejected')
            <div class="mb-6 bg-red-50 border border-red-200 text-red-900 px-5 py-5 rounded-3xl shadow-xs">
                <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-red-900 text-base">Status Pengajuan Toko: Ditolak oleh Admin</h4>
                        <p class="text-xs text-red-700 mt-1 leading-relaxed">
                            Pengajuan toko Anda belum disetujui. Anda dapat melakukan perbaikan pada tab <strong>"Formulir Edit Data"</strong> di bawah (seperti mengunggah foto profil/logo toko, melengkapi nomor NIB, atau alamat lengkap). Saat formulir disimpan, toko Anda akan <strong>otomatis diajukan ulang ke antrean verifikasi Admin</strong>.
                        </p>
                        <div class="mt-3.5 flex flex-wrap items-center gap-3">
                            <button type="button" onclick="switchTab('edit')" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-red-800 hover:bg-red-50 border border-red-300 font-bold rounded-xl text-xs transition-colors shadow-2xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Buka Formulir Edit Data
                            </button>
                            <form action="{{ route('toko.resubmit') }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin data toko sudah siap diajukan ulang ke Admin?');">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#800000] hover:bg-red-900 text-white font-bold rounded-xl text-xs transition-all shadow-xs cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Ajukan Verifikasi Ulang Sekarang &rarr;
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Header Card Profil UMKM -->
        <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 overflow-hidden mb-8">
            <div class="p-6 sm:p-8 border-b border-slate-100 bg-gradient-to-r from-red-50/80 via-white to-amber-50/40">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="relative group shrink-0">
                            @if($umkm->image_path)
                                <img src="{{ asset('storage/' . $umkm->image_path) }}" alt="{{ $umkm->business_name }}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover shadow-md border-2 border-white">
                            @else
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-[#800000] to-[#b31b1b] text-white flex items-center justify-center shadow-md font-extrabold text-2xl sm:text-3xl">
                                    {{ strtoupper(substr($umkm->business_name, 0, 1)) }}
                                </div>
                            @endif
                            <button type="button" onclick="switchTab('edit')" class="absolute -bottom-1 -right-1 bg-white text-slate-700 hover:text-[#800000] p-1.5 rounded-full shadow-md border border-slate-200 transition-transform hover:scale-110" title="Ganti Foto Profil / Logo Toko">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </button>
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2.5 mb-1.5">
                                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $umkm->business_name }}</h1>
                                @if($umkm->status == 'verified')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        Disetujui
                                    </span>
                                @elseif($umkm->status == 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 shadow-2xs">
                                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                        Menunggu Persetujuan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200 shadow-2xs">
                                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                        Ditolak
                                    </span>
                                @endif
                            </div>
                            <div class="flex flex-wrap items-center gap-y-1 gap-x-4 text-xs sm:text-sm text-slate-500">
                                <span class="flex items-center gap-1.5 font-medium text-slate-700">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $umkm->owner_name }}
                                </span>
                                <span>&bull;</span>
                                <span class="flex items-center gap-1.5 font-medium text-slate-700">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    {{ $umkm->phone }}
                                </span>
                                <span>&bull;</span>
                                <span class="flex items-center gap-1 text-slate-500">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    Kec. {{ $umkm->district ?? 'Wonogiri' }}, Wonogiri
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button" id="tab-btn-edit" onclick="switchTab('edit')" class="inline-flex items-center justify-center bg-[#800000] hover:bg-red-900 text-white font-semibold py-2.5 px-6 rounded-full transition-all shadow-md text-sm gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit Profil Usaha
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tab Buttons -->
            <div class="px-6 sm:px-8 bg-white border-b border-slate-100 flex items-center gap-8">
                <button type="button" id="tab-btn-view" onclick="switchTab('view')" class="tab-button py-4 text-sm font-bold border-b-2 border-[#800000] text-[#800000] transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Ringkasan Profil
                </button>
                <button type="button" id="tab-btn-form" onclick="switchTab('edit')" class="tab-button py-4 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Formulir Edit Data
                </button>
            </div>
        </div>

        <!-- TAB 1: RINGKASAN PROFIL (VIEW MODE) -->
        <div id="tab-content-view" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Kolom Kiri: Informasi Utama & Kontak -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Kartu Detail Usaha -->
                    <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-xs border border-slate-200/80">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                            <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-xl bg-red-50 text-[#800000] flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </span>
                                Informasi Usaha & Pemilik
                            </h3>
                            <button type="button" onclick="switchTab('edit')" class="text-xs font-semibold text-[#800000] hover:underline flex items-center gap-1">
                                Ubah Data &rarr;
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-sm">
                            <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                                <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Usaha / Merk</span>
                                <span class="font-bold text-slate-800 text-base">{{ $umkm->business_name }}</span>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                                <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Pemilik</span>
                                <span class="font-bold text-slate-800 text-base">{{ $umkm->owner_name }}</span>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                                <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor Kontak / WhatsApp</span>
                                <span class="font-bold text-slate-800 text-base flex items-center gap-2">
                                    {{ $umkm->phone }}
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->phone) }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 text-xs font-semibold bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                                        Chat WA
                                    </a>
                                </span>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                                <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Status Kemitraan</span>
                                @if($umkm->status == 'verified')
                                    <span class="font-bold text-emerald-700 text-base">Disetujui</span>
                                @elseif($umkm->status == 'pending')
                                    <span class="font-bold text-amber-700 text-base">Menunggu Persetujuan</span>
                                @else
                                    <span class="font-bold text-red-700 text-base">Ditolak</span>
                                @endif
                            </div>
                        </div>

                        <!-- Deskripsi Usaha -->
                        <div class="mt-6 pt-5 border-t border-slate-100">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Profil Usaha</span>
                            <div class="p-4 rounded-2xl bg-slate-50/60 text-slate-700 text-sm leading-relaxed border border-slate-100">
                                {{ $umkm->description ?? 'Belum ada deskripsi usaha. Silakan lengkapi pada menu edit profil.' }}
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Alamat & Wilayah -->
                    <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-xs border border-slate-200/80">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                            <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-xl bg-red-50 text-[#800000] flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </span>
                                Lokasi & Wilayah Usaha
                            </h3>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs mb-4">
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block text-[10px] font-bold uppercase">Provinsi</span>
                                <span class="font-bold text-slate-800">{{ $umkm->province ?? 'Jawa Tengah' }}</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block text-[10px] font-bold uppercase">Kabupaten</span>
                                <span class="font-bold text-slate-800">{{ $umkm->regency ?? 'Kabupaten Wonogiri' }}</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block text-[10px] font-bold uppercase">Kecamatan</span>
                                <span class="font-bold text-slate-800">Kec. {{ $umkm->district ?? '-' }}</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block text-[10px] font-bold uppercase">Desa / Kelurahan</span>
                                <span class="font-bold text-slate-800">Desa {{ $umkm->village ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-amber-50/40 border border-amber-200/60">
                            <span class="block text-[10px] font-extrabold uppercase tracking-wider text-[#800000] mb-1">Alamat Lengkap Usaha:</span>
                            <p class="text-sm font-semibold text-slate-800">
                                {{ $umkm->full_address }}
                            </p>
                        </div>

                        <!-- Peta Lokasi Toko Otomatis -->
                        <div class="mt-4 rounded-2xl overflow-hidden border border-slate-200 bg-slate-50">
                            <div class="p-3 bg-white border-b border-slate-200 flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Peta Lokasi Toko (Terbaca Otomatis)
                                </span>
                                <a href="{{ $umkm->google_maps_directions_url }}" target="_blank" class="text-[11px] font-bold text-[#800000] hover:underline flex items-center gap-1">
                                    Buka Maps &rarr;
                                </a>
                            </div>
                            <div class="w-full h-44 bg-slate-100">
                                <iframe src="{{ $umkm->google_maps_embed_url }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                            <div class="p-2.5 bg-red-50/60 text-center border-t border-red-100">
                                <a href="{{ $umkm->google_maps_directions_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-red-700 hover:text-red-900">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    Buka Petunjuk Arah di Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Legalitas, Sertifikasi & Statistik -->
                <div class="space-y-6">
                    
                    <!-- Kartu Legalitas & Sertifikasi -->
                    <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/80">
                        <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                            Legalitas & Sertifikasi
                        </h3>

                        <div class="space-y-3.5">
                            <!-- NIB -->
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="block text-xs font-bold text-slate-600">Nomor Induk Berusaha (NIB)</span>
                                    <span class="text-xs font-medium text-slate-800">{{ $umkm->nib ?: 'Belum ditambahkan' }}</span>
                                </div>
                                @if($umkm->nib)
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-emerald-100 text-emerald-700">Ada</span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-slate-200 text-slate-600">-</span>
                                @endif
                            </div>

                            <!-- P-IRT -->
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="block text-xs font-bold text-slate-600">Sertifikat P-IRT</span>
                                    <span class="text-xs font-medium text-slate-800">{{ $umkm->pirt ?: 'Belum ditambahkan' }}</span>
                                </div>
                                @if($umkm->pirt)
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-emerald-100 text-emerald-700">Ada</span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-slate-200 text-slate-600">-</span>
                                @endif
                            </div>

                            <!-- Halal -->
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="block text-xs font-bold text-slate-600">Sertifikat Halal</span>
                                    <span class="text-xs font-medium text-slate-800">{{ $umkm->halal_cert ?: 'Belum ditambahkan' }}</span>
                                </div>
                                @if($umkm->halal_cert)
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-emerald-100 text-emerald-700">Ada</span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-slate-200 text-slate-600">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Ringkasan Aktivitas -->
                    <div class="bg-gradient-to-br from-[#800000] to-[#991b1b] rounded-3xl p-6 text-white shadow-md">
                        <h4 class="font-bold text-sm text-red-100 uppercase tracking-wider mb-4">Aktivitas Toko Anda</h4>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between border-b border-white/10 pb-3">
                                <span class="text-sm text-red-100">Total Produk di Etalase</span>
                                <span class="text-xl font-extrabold">{{ $productsCount ?? 0 }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-white/10 pb-3">
                                <span class="text-sm text-red-100">Tanggal Terdaftar</span>
                                <span class="text-sm font-semibold">{{ $umkm->created_at ? $umkm->created_at->format('d M Y') : '-' }}</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-2">
                            @if($umkm->status == 'verified')
                                <a href="{{ route('toko.product.create') }}" class="block w-full py-2.5 px-4 bg-white text-[#800000] hover:bg-red-50 text-center font-bold rounded-xl text-xs transition-colors shadow-xs">
                                    + Tambah Produk Baru
                                </a>
                            @else
                                <button type="button" disabled title="Toko Anda masih menunggu persetujuan admin." class="block w-full py-2.5 px-4 bg-white/40 text-white/80 cursor-not-allowed text-center font-bold rounded-xl text-xs">
                                    Menunggu Persetujuan Admin
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- TAB 2: FORMULIR EDIT PROFIL (EDIT MODE) -->
        <div id="tab-content-edit" class="hidden">
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 p-6 sm:p-10 max-w-4xl mx-auto">
                <div class="mb-8 border-b border-slate-100 pb-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Perbarui Profil UMKM</h2>
                        <p class="text-slate-500 text-sm mt-1">Sesuaikan informasi bisnis, kontak, dan alamat toko Anda.</p>
                    </div>
                    <button type="button" onclick="switchTab('view')" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors">
                        &larr; Batal
                    </button>
                </div>

                <form action="{{ route('toko.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Foto Profil / Logo Toko -->
                    <!-- Foto Profil / Logo Toko -->
                    <div class="p-6 rounded-2xl bg-gradient-to-r from-red-50/70 via-slate-50 to-white border-2 border-red-100 flex flex-col sm:flex-row items-center gap-6 shadow-xs">
                        <div class="relative shrink-0">
                            <div id="preview-container" class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-red-200 shadow-md bg-white flex items-center justify-center">
                                @if($umkm->image_path)
                                    <img id="image-preview" src="{{ asset('storage/' . $umkm->image_path) }}" alt="{{ $umkm->business_name }}" class="w-full h-full object-cover">
                                @else
                                    <div id="default-avatar" class="w-full h-full bg-gradient-to-br from-[#800000] to-[#b31b1b] text-white flex flex-col items-center justify-center font-extrabold text-2xl shadow-inner">
                                        <svg class="w-8 h-8 opacity-90 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-[11px] uppercase tracking-wider font-bold">LOGO</span>
                                    </div>
                                    <img id="image-preview" src="#" alt="Pratinjau Foto" class="w-full h-full object-cover hidden">
                                @endif
                            </div>
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <label class="block text-sm font-bold text-slate-900 mb-1">Foto Profil / Logo Toko UMKM</label>
                            <p class="text-xs text-slate-500 mb-3 leading-relaxed">Unggah logo atau foto toko fisik Anda agar profil mudah dikenali oleh pembeli. Format: JPG, PNG, atau WebP (Maks. 5MB).</p>
                            <div class="flex flex-wrap items-center gap-3">
                                <label for="store-image-input" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#800000] hover:bg-red-900 text-white text-xs font-bold transition-all shadow-xs cursor-pointer hover:shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Pilih Foto / Logo Baru
                                </label>
                                <span id="file-name-display" class="text-xs text-slate-500 italic">{{ $umkm->image_path ? 'Menggunakan foto tersimpan' : 'Belum ada file dipilih' }}</span>
                                <input type="file" name="image" id="store-image-input" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewStoreImage(this)" class="hidden">
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pokok -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-2">Nama UMKM / Usaha <span class="text-red-500">*</span></label>
                            <input type="text" name="business_name" value="{{ old('business_name', $umkm->business_name) }}" required class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs">
                            <p class="text-[11px] text-slate-400 mt-1.5">Nama brand atau toko UMKM Anda</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-2">Nama Pemilik Usaha <span class="text-red-500">*</span></label>
                            <input type="text" name="owner_name" value="{{ old('owner_name', $umkm->owner_name) }}" required class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs">
                            <p class="text-[11px] text-slate-400 mt-1.5">Nama lengkap pemilik usaha</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-2">Nomor Kontak / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone', $umkm->phone) }}" required class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs">
                        <p class="text-[11px] text-slate-400 mt-1.5">Nomor telepon aktif / WhatsApp untuk komunikasi transaksi</p>
                    </div>

                    <!-- Wilayah & Alamat Lengkap -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-5">
                        <div class="flex items-center gap-2.5 border-b border-slate-200 pb-3">
                            <span class="w-8 h-8 rounded-lg bg-red-100 text-[#800000] flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </span>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">Alamat & Lokasi Usaha Lengkap</h3>
                                <p class="text-[11px] text-slate-500">Pilih Kecamatan dan Desa di Kabupaten Wonogiri</p>
                            </div>
                        </div>

                        <!-- Pencarian Cepat Wilayah -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Pencarian Cepat Wilayah <span class="font-normal text-slate-500">(Ketik nama Desa atau Kecamatan):</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <input type="text" id="keyword-search" autocomplete="off" placeholder="Ketik kata kunci desa / kecamatan (contoh: Girimarto, Ngadirojo, Selogiri...)" class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs">
                                <div id="search-results" class="hidden absolute left-0 right-0 top-full mt-1.5 max-h-56 overflow-y-auto bg-white rounded-xl shadow-xl border border-slate-200 z-50 divide-y divide-slate-100"></div>
                            </div>
                        </div>

                        <!-- Dropdown Bertingkat -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Provinsi</label>
                                <input type="text" name="province" value="{{ old('province', $umkm->province ?: 'Jawa Tengah') }}" readonly class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-100/90 text-slate-700 text-sm font-semibold cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Kabupaten</label>
                                <input type="text" name="regency" value="{{ old('regency', $umkm->regency ?: 'Kabupaten Wonogiri') }}" readonly class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-100/90 text-slate-700 text-sm font-semibold cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Kecamatan <span class="text-red-500">*</span></label>
                                <select id="district-select" name="district" required class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs">
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Desa / Kelurahan <span class="text-red-500">*</span></label>
                                <select id="village-select" name="village" required class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs">
                                    <option value="">-- Pilih Desa / Kelurahan --</option>
                                </select>
                            </div>
                        </div>

                        <!-- Alamat Rinci & Kode Pos -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-3">
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Spesifik (Jalan, RT/RW, Dusun, No. Rumah) <span class="text-red-500">*</span></label>
                                <input type="text" id="address-input" name="address" required value="{{ old('address', $umkm->address) }}" class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs" placeholder="Contoh: Jl. Diponegoro No. 12, RT 02 / RW 04">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Kode Pos</label>
                                <input type="text" id="postal-input" name="postal_code" value="{{ old('postal_code', $umkm->postal_code) }}" maxlength="10" class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs" placeholder="57681">
                            </div>
                        </div>

                        <!-- Format Teks Alamat Realtime -->
                        <div class="p-4 rounded-xl bg-white border-2 border-red-100 shadow-xs">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#800000] block mb-1">Pratinjau Format Alamat Lengkap:</span>
                            <p id="full-address-preview" class="text-xs text-slate-800 font-semibold">
                                {{ $umkm->full_address }}
                            </p>
                        </div>

                        <!-- Link Titik Lokasi Google Maps -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center justify-between">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Tautan Titik Lokasi Google Maps <span class="text-slate-400 font-normal">(Agar pembeli tahu letak toko fisik Anda)</span>
                                </span>
                                <a href="{{ $umkm->google_maps_directions_url }}" target="_blank" class="text-[11px] text-red-700 font-bold hover:underline flex items-center gap-1">
                                    Tes Buka di Google Maps &rarr;
                                </a>
                            </label>
                            <input type="url" name="map_link" value="{{ old('map_link', $umkm->map_link) }}" placeholder="Contoh: https://maps.app.goo.gl/... atau https://maps.google.com/?q=..." class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs">
                            <p class="text-[11px] text-slate-500 mt-1.5 leading-relaxed">
                                💡 <em>Opsional: Peta toko otomatis membaca alamat, desa, dan kecamatan Anda di atas. Anda juga dapat menempelkan link Google Maps jika memiliki pin lokasi spesifik.</em>
                            </p>
                        </div>
                    </div>

                    <!-- Legalitas & Sertifikasi -->
                    <div>
                        <h3 class="text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-3">Legalitas & Sertifikasi Usaha</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Induk Berusaha (NIB)</label>
                                <input type="text" name="nib" value="{{ old('nib', $umkm->nib) }}" class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs" placeholder="Nomor NIB (opsional)">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Sertifikasi PIRT</label>
                                <input type="text" name="pirt" value="{{ old('pirt', $umkm->pirt) }}" class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs" placeholder="Nomor P-IRT (opsional)">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Sertifikasi Halal</label>
                                <input type="text" name="halal_cert" value="{{ old('halal_cert', $umkm->halal_cert) }}" class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs" placeholder="Nomor Sertifikat (opsional)">
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi Usaha -->
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-2">Deskripsi Singkat Usaha</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 shadow-xs focus:border-[#800000] focus:ring-4 focus:ring-red-500/15 focus:outline-none text-sm text-slate-900 bg-white placeholder:text-slate-400 transition-all" placeholder="Jelaskan mengenai produk, kapasitas produksi, sejarah, atau keunggulan UMKM Anda...">{{ old('description', $umkm->description) }}</textarea>
                    </div>

                    <!-- Tombol Aksi Simpan -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <button type="button" onclick="switchTab('view')" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="bg-[#800000] hover:bg-red-900 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-md hover:shadow-lg flex items-center gap-2 text-sm cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ $umkm->status == 'rejected' ? 'Simpan & Ajukan Ulang Verifikasi' : 'Simpan Perubahan' }}
                        </button>
                    </div>
                </form>

                <!-- Zona Bahaya: Hapus Toko / Akun -->
                <div class="mt-8 pt-6 border-t border-red-200">
                    <div class="bg-red-50/70 border border-red-200 rounded-2xl p-5 sm:p-6">
                        <div class="flex items-start gap-3.5 mb-4">
                            <div class="w-9 h-9 rounded-xl bg-red-100 text-red-700 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-red-900">Zona Bahaya: Hapus Toko UMKM</h4>
                                <p class="text-xs text-red-700 mt-1 leading-relaxed">
                                    Tindakan ini akan menghapus data profil toko <strong>{{ $umkm->business_name }}</strong> beserta seluruh produk yang pernah Anda unggah secara permanen. Anda dapat mendaftarkan kembali toko baru kapan saja setelah ini.
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-end gap-3 pt-3 border-t border-red-200/60">
                            <form action="{{ route('toko.destroy') }}" method="POST" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus toko UMKM ini? Seluruh data produk dan profil toko Anda akan dihapus secara permanen.');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors cursor-pointer flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus Toko UMKM
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Tab Controller
    function switchTab(tab) {
        const viewContent = document.getElementById('tab-content-view');
        const editContent = document.getElementById('tab-content-edit');
        const btnView = document.getElementById('tab-btn-view');
        const btnForm = document.getElementById('tab-btn-form');

        if (tab === 'edit') {
            viewContent.classList.add('hidden');
            editContent.classList.remove('hidden');

            btnView.className = 'tab-button py-4 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-2';
            btnForm.className = 'tab-button py-4 text-sm font-bold border-b-2 border-[#800000] text-[#800000] transition-colors flex items-center gap-2';
            window.location.hash = 'edit';
        } else {
            editContent.classList.add('hidden');
            viewContent.classList.remove('hidden');

            btnView.className = 'tab-button py-4 text-sm font-bold border-b-2 border-[#800000] text-[#800000] transition-colors flex items-center gap-2';
            btnForm.className = 'tab-button py-4 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-2';
            history.replaceState(null, null, ' ');
        }
    }

    // Cek apakah url memiliki hash #edit atau error validasi
    @if (isset($errors) && $errors->any())
        document.addEventListener('DOMContentLoaded', () => switchTab('edit'));
    @else
        if (window.location.hash === '#edit') {
            document.addEventListener('DOMContentLoaded', () => switchTab('edit'));
        }
    @endif

    // Logika Data Wilayah Wonogiri
    let wilayahData = {};
    const selectedDistrictCurrent = @json(old('district', $umkm->district));
    const selectedVillageCurrent = @json(old('village', $umkm->village));

    const districtSelect = document.getElementById('district-select');
    const villageSelect = document.getElementById('village-select');
    const searchInput = document.getElementById('keyword-search');
    const searchResults = document.getElementById('search-results');
    const addressInput = document.getElementById('address-input');
    const postalInput = document.getElementById('postal-input');
    const fullAddressPreview = document.getElementById('full-address-preview');

    function updateFullAddressPreview() {
        const addr = addressInput ? addressInput.value.trim() : '';
        const kec = districtSelect ? districtSelect.value : '';
        const desa = villageSelect ? villageSelect.value : '';
        const pos = postalInput ? postalInput.value.trim() : '';
        
        const parts = [];
        if (addr) parts.push(addr);
        if (desa) parts.push(`Desa/Kel. ${desa}`);
        if (kec) parts.push(`Kec. ${kec}`);
        parts.push('Kabupaten Wonogiri');
        parts.push('Provinsi Jawa Tengah');
        if (pos) parts.push(`Kode Pos ${pos}`);

        if (fullAddressPreview) {
            fullAddressPreview.textContent = parts.length > 0 ? parts.join(', ') : '-';
        }
    }

    if (addressInput) addressInput.addEventListener('input', updateFullAddressPreview);
    if (postalInput) postalInput.addEventListener('input', updateFullAddressPreview);

    fetch('/wonogiri_wilayah.json')
        .then(res => res.json())
        .then(data => {
            wilayahData = data;
            populateDistricts();

            if (selectedDistrictCurrent) {
                districtSelect.value = selectedDistrictCurrent;
                populateVillages(selectedDistrictCurrent);
                if (selectedVillageCurrent) {
                    villageSelect.value = selectedVillageCurrent;
                }
            }
            updateFullAddressPreview();
        })
        .catch(err => console.error('Gagal memuat master wilayah:', err));

    function populateDistricts() {
        if (!districtSelect) return;
        districtSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
        Object.keys(wilayahData).sort().forEach(kec => {
            const opt = document.createElement('option');
            opt.value = kec;
            opt.textContent = `Kec. ${kec}`;
            if (kec === selectedDistrictCurrent) {
                opt.selected = true;
            }
            districtSelect.appendChild(opt);
        });
    }

    function populateVillages(kecamatan) {
        if (!villageSelect) return;
        villageSelect.innerHTML = '<option value="">-- Pilih Desa / Kelurahan --</option>';
        if (wilayahData[kecamatan]) {
            wilayahData[kecamatan].sort().forEach(desa => {
                const opt = document.createElement('option');
                opt.value = desa;
                opt.textContent = `Desa/Kel. ${desa}`;
                if (desa === selectedVillageCurrent) {
                    opt.selected = true;
                }
                villageSelect.appendChild(opt);
            });
        }
        updateFullAddressPreview();
    }

    if (districtSelect) {
        districtSelect.addEventListener('change', function() {
            populateVillages(this.value);
            updateFullAddressPreview();
        });
    }

    if (villageSelect) {
        villageSelect.addEventListener('change', function() {
            updateFullAddressPreview();
        });
    }

    // Pencarian kata kunci otomatis
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            if (query.length < 2) {
                searchResults.classList.add('hidden');
                searchResults.innerHTML = '';
                return;
            }

            const matches = [];
            for (const [kec, desas] of Object.entries(wilayahData)) {
                if (kec.toLowerCase().includes(query)) {
                    matches.push({ type: 'kecamatan', kec: kec, text: `Kecamatan ${kec}, Kab. Wonogiri, Jawa Tengah` });
                }
                for (const desa of desas) {
                    if (desa.toLowerCase().includes(query)) {
                        matches.push({ type: 'desa', kec: kec, desa: desa, text: `Desa ${desa}, Kec. ${kec}, Kab. Wonogiri, Jawa Tengah` });
                    }
                }
            }

            if (matches.length === 0) {
                searchResults.innerHTML = '<div class="p-3 text-xs text-slate-400 italic">Tidak ada wilayah Wonogiri yang cocok</div>';
                searchResults.classList.remove('hidden');
                return;
            }

            searchResults.innerHTML = '';
            matches.slice(0, 10).forEach(item => {
                const div = document.createElement('div');
                div.className = 'p-2.5 text-xs text-slate-700 hover:bg-red-50 hover:text-[#800000] cursor-pointer font-medium transition-colors flex items-center justify-between';
                div.innerHTML = `<span>${item.text}</span><span class="text-[10px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-500 uppercase">${item.type}</span>`;
                div.addEventListener('click', function() {
                    districtSelect.value = item.kec;
                    populateVillages(item.kec);
                    if (item.desa) {
                        villageSelect.value = item.desa;
                    }
                    searchInput.value = item.text;
                    searchResults.classList.add('hidden');
                    updateFullAddressPreview();
                });
                searchResults.appendChild(div);
            });

            searchResults.classList.remove('hidden');
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
    }

    function previewStoreImage(input) {
        const fileNameDisplay = document.getElementById('file-name-display');
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (fileNameDisplay) {
                fileNameDisplay.textContent = file.name;
                fileNameDisplay.classList.remove('italic', 'text-slate-500');
                fileNameDisplay.classList.add('font-semibold', 'text-slate-800');
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('image-preview');
                const defaultAvatar = document.getElementById('default-avatar');
                if (previewImg) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                }
                if (defaultAvatar) {
                    defaultAvatar.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
