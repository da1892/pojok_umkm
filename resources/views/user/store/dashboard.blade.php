@extends('user.layouts.app')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Flash Messages --}}
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

        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-2xl flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <span class="text-sm font-semibold">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        {{-- Status Notification Alerts --}}
        @if($umkm->status == 'pending')
            <div class="mb-6 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 text-amber-950 p-5 rounded-3xl flex items-start gap-4 shadow-xs">
                <div class="w-10 h-10 rounded-2xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-amber-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-amber-950 text-sm sm:text-base">Pendaftaran UMKM Sedang Menunggu Persetujuan Admin Dinas</h4>
                    <p class="text-xs text-amber-800 mt-1 leading-relaxed">Profil toko Anda sedang dikurasi oleh tim Dinas Perdagangan & KUKM Kabupaten Wonogiri. Tombol <strong>Tambah Produk</strong> akan otomatis aktif setelah toko Anda diverifikasi dan disetujui.</p>
                </div>
            </div>
        @elseif($umkm->status == 'rejected')
            <div class="mb-8 bg-gradient-to-r from-red-50 via-rose-50/40 to-white border border-red-200/90 text-red-950 p-6 rounded-3xl shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-500 to-rose-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-red-500/20 ring-4 ring-red-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-600 text-white shadow-2xs">Perlu Perbaikan</span>
                            <h4 class="font-bold text-red-950 text-base">Pendaftaran Toko Belum Disetujui</h4>
                        </div>
                        
                        @if(!empty($umkm->rejection_note))
                            <div class="mt-3.5 mb-3 p-4 bg-white rounded-2xl border border-red-200 shadow-2xs">
                                <div class="flex items-center gap-2 mb-2 text-xs font-bold text-red-800 uppercase tracking-wider">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                    <span>Catatan & Alasan Penolakan dari Admin Dinas:</span>
                                </div>
                                <div class="text-sm text-slate-800 font-medium leading-relaxed bg-red-50/50 p-3.5 rounded-xl border border-red-100">
                                    {!! nl2br(e($umkm->rejection_note)) !!}
                                </div>
                            </div>
                        @endif

                        <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                            Pengajuan toko Anda belum lolos verifikasi. Silakan periksa catatan di atas, lengkapi berkas atau data toko Anda, lalu ajukan verifikasi ulang ke Administrator:
                        </p>
                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <a href="{{ route('toko.profile') }}#edit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-slate-700 hover:text-red-700 hover:bg-red-50/50 border border-slate-200 hover:border-red-200 font-bold rounded-xl text-xs transition-all shadow-2xs">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                1. Perbaiki Data Toko
                            </a>
                            <form id="resubmit-store-form-main" action="{{ route('toko.resubmit') }}" method="POST" class="inline">
                                @csrf
                                <button type="button" onclick="confirmResubmitStore('resubmit-store-form-main')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-red-600 to-[#800000] hover:from-red-700 hover:to-red-900 text-white font-bold rounded-xl text-xs transition-all shadow-sm shadow-red-500/20 active:scale-98 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    2. Ajukan Verifikasi Ulang Sekarang &rarr;
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- KARTU HERO PROFIL UMKM (Modern, Elegan & Lengkap) --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/90 overflow-hidden mb-8">
            
            {{-- Bagian Atas: Banner Profil UMKM dengan Brand Marun Wonogiri --}}
            <div class="bg-gradient-to-r from-red-950 via-[#800000] to-red-900 text-white p-6 sm:p-8 relative overflow-hidden">
                {{-- Aksen Dekorasi Ambient --}}
                <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-amber-400/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute right-1/3 -top-20 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    
                    {{-- Identitas Usaha & Avatar --}}
                    <div class="flex items-start sm:items-center gap-5">
                        <div class="relative shrink-0">
                            @if($umkm->image_path)
                                <img src="{{ asset('storage/' . $umkm->image_path) }}" alt="{{ $umkm->business_name }}" class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover shadow-xl border-2 border-white/40 ring-4 ring-black/10">
                            @else
                                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 text-slate-950 font-black text-3xl sm:text-4xl flex items-center justify-center shadow-xl border-2 border-white/40 ring-4 ring-black/10">
                                    {{ strtoupper(substr($umkm->business_name, 0, 1)) }}
                                </div>
                            @endif
                            <a href="{{ route('toko.profile') }}#edit" class="absolute -bottom-1.5 -right-1.5 bg-white text-slate-800 hover:text-[#800000] p-1.5 rounded-full shadow-md border border-slate-200 hover:scale-110 transition-transform" title="Ubah Logo / Foto UMKM">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                            </a>
                        </div>

                        <div>
                            {{-- Baris Badge Status & Legalitas --}}
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                @if($umkm->status == 'verified')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-200 border border-emerald-400/40 backdrop-blur-md shadow-xs">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                        Disetujui Dinas KUKM
                                    </span>
                                @elseif($umkm->status == 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-200 border border-amber-400/40 backdrop-blur-md shadow-xs">
                                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                        Menunggu Persetujuan
                                    </span>
                                @elseif($umkm->status == 'rejected')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-500/20 text-rose-200 border border-rose-400/40 backdrop-blur-md shadow-xs">
                                        <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                                        Ditolak Admin
                                    </span>
                                @endif

                                @if($umkm->nib)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-white/15 text-white/90 border border-white/20">
                                        <svg class="w-3 h-3 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        NIB Terdaftar
                                    </span>
                                @endif
                                @if($umkm->pirt)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-white/15 text-white/90 border border-white/20">
                                        <svg class="w-3 h-3 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        P-IRT
                                    </span>
                                @endif
                                @if($umkm->halal_cert)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-white/15 text-white/90 border border-white/20">
                                        <svg class="w-3 h-3 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        Halal
                                    </span>
                                @endif
                            </div>

                            {{-- Nama Usaha --}}
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight mb-2">{{ $umkm->business_name }}</h1>

                            {{-- Info Pemilik & Kontak --}}
                            <div class="flex flex-wrap items-center gap-y-1.5 gap-x-4 text-xs sm:text-sm text-red-100 font-medium">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $umkm->owner_name }}
                                </span>
                                <span>&bull;</span>
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $umkm->phone)) }}" target="_blank" class="flex items-center gap-1.5 text-emerald-200 hover:text-white underline transition-colors" title="Hubungi via WhatsApp">
                                    <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.173.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.086s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/></svg>
                                    {{ $umkm->phone }}
                                </a>
                                <span>&bull;</span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    Kec. {{ $umkm->district ?? 'Wonogiri' }}, Wonogiri
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi Cepat Header --}}
                    <div class="flex flex-wrap items-center gap-3">
                        @if($umkm->status == 'verified')
                            <a href="{{ route('toko.product.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 hover:from-amber-500 hover:to-amber-700 text-slate-950 font-black text-xs sm:text-sm shadow-lg shadow-amber-950/20 active:scale-95 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                <span>Tambah Produk</span>
                            </a>
                        @else
                            <button type="button" disabled title="UMKM sedang dalam peninjauan oleh admin." class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 text-white/50 border border-white/10 font-bold text-xs cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Menunggu Verifikasi</span>
                            </button>
                        @endif

                        <a href="{{ route('direktori', ['search' => $umkm->business_name]) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white border border-white/20 font-bold text-xs sm:text-sm backdrop-blur-md transition-all shadow-xs" title="Lihat profil publik UMKM Anda di direktori">
                            <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            <span>Lihat di Direktori</span>
                        </a>

                        <a href="{{ route('toko.profile') }}#edit" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white border border-white/20 font-bold text-xs sm:text-sm backdrop-blur-md transition-all shadow-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <span>Edit Profil</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Bagian Tengah: Jalur Statistik Ringkas (Quick Metric Strip) --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 divide-y lg:divide-y-0 lg:divide-x divide-slate-100 bg-slate-50/70 border-b border-slate-100">
                <div class="p-4 sm:p-5 flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-[#800000] flex items-center justify-center font-black shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div>
                        <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Produk</span>
                        <span class="text-xl font-black text-slate-900">{{ $products->count() }} <span class="text-xs font-semibold text-slate-500">item</span></span>
                    </div>
                </div>

                <div class="p-4 sm:p-5 flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-black shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Produk Disetujui</span>
                        <span class="text-xl font-black text-emerald-700">{{ $products->where('status', 'verified')->count() }} <span class="text-xs font-semibold text-slate-500">tayang</span></span>
                    </div>
                </div>

                <div class="p-4 sm:p-5 flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-black shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Menunggu Kurasi</span>
                        <span class="text-xl font-black text-amber-700">{{ $products->where('status', 'pending')->count() }} <span class="text-xs font-semibold text-slate-500">antrean</span></span>
                    </div>
                </div>

                <div class="p-4 sm:p-5 flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-black shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <div>
                        <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Konsultasi Dinas</span>
                        <span class="text-xl font-black text-blue-700">{{ $consultationsCount ?? 0 }} <span class="text-xs font-semibold text-slate-500">tiket</span></span>
                    </div>
                </div>
            </div>

            {{-- Bagian Bawah: Tab Navigasi Halaman Toko UMKM --}}
            <div class="px-6 sm:px-8 bg-white flex items-center gap-2 sm:gap-6 overflow-x-auto scrollbar-none py-2 border-t border-slate-100">
                <a href="{{ route('toko.index') }}" class="py-3 px-4 text-sm font-black border-b-2 border-[#800000] text-[#800000] transition-all flex items-center gap-2 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span>Katalog Produk</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-[#800000] font-black">{{ $products->count() }}</span>
                </a>
                <a href="{{ route('toko.profile') }}" class="py-3 px-4 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300 transition-all flex items-center gap-2 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Profil Lengkap Usaha</span>
                </a>
                <a href="{{ route('toko.consultations') }}" class="py-3 px-4 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300 transition-all flex items-center gap-2 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <span>Riwayat Konsultasi</span>
                    @if(isset($consultationsCount) && $consultationsCount > 0)
                        <span class="text-xs px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 font-bold">{{ $consultationsCount }}</span>
                    @endif
                </a>
            </div>
        </div>

        {{-- BAGIAN KATALOG PRODUK ANDA --}}
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                    <span>Katalog Produk Anda</span>
                    <span class="text-xs px-2.5 py-1 rounded-full bg-red-100 text-[#800000] font-black">{{ $products->count() }} Produk</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">Kelola data produk, foto kemasan, harga resmi, dan pantau status kurasi oleh Dinas.</p>
            </div>
            @if($umkm->status == 'verified')
                <a href="{{ route('toko.product.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#800000] hover:bg-red-900 text-white text-xs sm:text-sm font-bold py-2.5 px-4 rounded-xl transition-all shadow-xs hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Produk Baru</span>
                </a>
            @endif
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-3xl overflow-hidden shadow-xs hover:shadow-xl border border-slate-200/80 hover:border-red-200 transition-all duration-300 group flex flex-col">
                    
                    {{-- Area Foto & Badge --}}
                    <div class="relative h-52 overflow-hidden bg-slate-100">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-100">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-[11px] font-semibold mt-1">Belum ada foto</span>
                            </div>
                        @endif

                        {{-- Gradient Overlay Bawah Foto --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-black/20 pointer-events-none"></div>

                        {{-- Badge Kiri: Produk Unggulan --}}
                        @if($product->is_featured)
                            <div class="absolute top-3 left-3">
                                <span class="bg-gradient-to-r from-amber-500 to-amber-600 text-white text-[10px] font-black px-2.5 py-1 rounded-xl shadow-md flex items-center gap-1 border border-amber-300/40">
                                    <svg class="w-3 h-3 text-yellow-200 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Unggulan
                                </span>
                            </div>
                        @endif
                        
                        {{-- Badge Kanan: Status Kurasi --}}
                        <div class="absolute top-3 right-3">
                            @if($product->status == 'verified')
                                <span class="inline-flex items-center gap-1 bg-emerald-600/90 text-white text-[11px] font-bold px-3 py-1 rounded-xl backdrop-blur-md shadow-sm border border-emerald-400/30">
                                    <svg class="w-3 h-3 text-emerald-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Disetujui
                                </span>
                            @elseif($product->status == 'pending')
                                <span class="inline-flex items-center gap-1 bg-amber-500/90 text-white text-[11px] font-bold px-3 py-1 rounded-xl backdrop-blur-md shadow-sm border border-amber-300/30">
                                    <svg class="w-3 h-3 text-amber-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                    Menunggu
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-rose-600/90 text-white text-[11px] font-bold px-3 py-1 rounded-xl backdrop-blur-md shadow-sm border border-rose-400/30">
                                    Ditolak
                                </span>
                            @endif
                        </div>

                        {{-- Tampilan Harga Menarik di Atas Foto --}}
                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white pointer-events-none">
                            <span class="text-base sm:text-lg font-black text-amber-300 drop-shadow-md tracking-tight">
                                Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Isi Kartu Produk --}}
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="mb-2">
                            <span class="inline-block text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md bg-red-50 text-[#800000] border border-red-100">
                                {{ $product->category ?: 'Produk UMKM' }}
                            </span>
                        </div>

                        <h4 class="text-base font-extrabold text-slate-900 group-hover:text-[#800000] transition-colors line-clamp-1 mb-1.5" title="{{ $product->name }}">
                            {{ $product->name }}
                        </h4>

                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4 flex-1">
                            {{ $product->description ?: 'Tidak ada deskripsi produk.' }}
                        </p>
                        
                        {{-- Peringatan Alasan Penolakan Jika Ada --}}
                        @if($product->status == 'rejected' && !empty($product->rejection_note))
                            <div class="mb-4 p-3 bg-red-50 border border-red-200/90 rounded-2xl text-xs text-red-900 shadow-2xs">
                                <div class="font-bold flex items-center gap-1.5 text-red-800 mb-1">
                                    <svg class="w-3.5 h-3.5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <span>Catatan Penolakan Admin:</span>
                                </div>
                                <p class="text-[11px] text-red-700 leading-relaxed italic">{!! nl2br(e($product->rejection_note)) !!}</p>
                                <a href="{{ route('toko.product.edit', $product->id) }}" class="mt-2 inline-flex items-center gap-1 text-[11px] font-bold text-red-800 hover:text-red-950 hover:underline">
                                    <span>Perbaiki produk ini</span> &rarr;
                                </a>
                            </div>
                        @endif
                        
                        {{-- Footer Kartu: Tombol Aksi --}}
                        <div class="mt-auto border-t border-slate-100 pt-3.5 flex items-center justify-between gap-2">
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('toko.product.edit', $product->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 hover:text-slate-900 transition-all shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    <span>Edit</span>
                                </a>
                                @if($product->status == 'verified')
                                    <a href="{{ route('katalog', ['search' => $product->name]) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-bold text-[#800000] bg-red-50 hover:bg-red-100 transition-all shadow-2xs" title="Lihat di Katalog Publik">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                @endif
                            </div>

                            <form id="delete-product-form-{{ $product->id }}" action="{{ route('toko.product.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDeleteStoreProduct('delete-product-form-{{ $product->id }}', '{{ addslashes($product->name) }}')" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 transition-all cursor-pointer shadow-2xs" title="Hapus Produk">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 px-6 bg-white rounded-3xl border border-slate-200/90 shadow-sm">
                <div class="w-20 h-20 bg-red-50 text-[#800000] rounded-3xl flex items-center justify-center mx-auto mb-4 shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2">Belum ada produk di etalase Anda</h3>
                <p class="text-xs sm:text-sm text-slate-500 mb-6 max-w-md mx-auto leading-relaxed">Etalase toko Anda masih kosong. Tambahkan produk unggulan Anda lengkap dengan foto menarik, rincian varian, dan harga agar dapat dipromosikan ke pembeli.</p>
                
                @if($umkm->status == 'verified')
                    <a href="{{ route('toko.product.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#800000] via-[#941515] to-[#800000] hover:from-red-900 hover:to-red-950 text-white font-bold rounded-2xl text-xs sm:text-sm shadow-md shadow-red-950/20 active:scale-98 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Produk Pertama Anda</span>
                    </a>
                @elseif($umkm->status == 'pending')
                    <div class="inline-flex items-center gap-2 bg-amber-50 text-amber-800 border border-amber-200 px-5 py-3 rounded-2xl text-xs font-semibold shadow-xs">
                        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>Menunggu verifikasi admin Dinas sebelum dapat menambah produk baru.</span>
                    </div>
                @else
                    <div class="inline-flex flex-col sm:flex-row items-center gap-3 bg-red-50 text-red-800 border border-red-200 px-5 py-3 rounded-2xl text-xs font-semibold shadow-xs max-w-lg mx-auto">
                        <span class="flex items-center gap-1.5 text-red-700">
                            <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            UMKM belum disetujui oleh admin
                        </span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('toko.profile') }}#edit" class="text-xs font-bold text-red-800 underline hover:text-red-950">Perbaiki Data</a>
                            <span>&bull;</span>
                            <form id="resubmit-store-form-empty" action="{{ route('toko.resubmit') }}" method="POST" class="inline">
                                @csrf
                                <button type="button" onclick="confirmResubmitStore('resubmit-store-form-empty')" class="text-xs font-bold text-[#800000] hover:underline cursor-pointer">Ajukan Ulang &rarr;</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
