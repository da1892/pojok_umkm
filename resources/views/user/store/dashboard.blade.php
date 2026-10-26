@extends('user.layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if($umkm->status == 'pending')
            <div class="mb-6 bg-amber-50 border border-amber-200 text-amber-900 px-5 py-4 rounded-2xl flex items-start gap-3 shadow-xs">
                <svg class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div class="text-sm">
                    <p class="font-bold text-amber-900">Pendaftaran Toko Sedang Menunggu Persetujuan Admin</p>
                    <p class="text-xs text-amber-700 mt-0.5">Akun toko Anda saat ini sedang ditinjau oleh Administrator. Tombol <strong>+ Produk Baru</strong> akan otomatis aktif setelah toko Anda diverifikasi dan disetujui.</p>
                </div>
            </div>
        @elseif($umkm->status == 'rejected')
            <div class="mb-6 bg-red-50 border border-red-200 text-red-900 px-5 py-5 rounded-2xl shadow-xs">
                <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-red-900 text-base">Pendaftaran Toko Belum Disetujui (Ditolak)</h4>
                        <p class="text-xs text-red-700 mt-1 leading-relaxed">
                            Pengajuan profil toko Anda saat ini belum memenuhi kriteria verifikasi. Jangan khawatir, Anda dapat memperbaiki data toko Anda (seperti melengkapi foto profil/logo, NIB, P-IRT, atau alamat lengkap), lalu mengajukan verifikasi ulang ke Administrator di bawah ini:
                        </p>
                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <a href="{{ route('toko.profile') }}#edit" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white text-red-800 hover:bg-red-50 border border-red-300 font-bold rounded-xl text-xs transition-colors shadow-2xs">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                1. Perbaiki Data Profil Toko
                            </a>
                            <form action="{{ route('toko.resubmit') }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin data profil toko sudah diperbaiki dan siap diajukan ulang ke Admin?');">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-[#801414] hover:bg-red-900 text-white font-bold rounded-xl text-xs transition-all shadow-xs cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    2. Ajukan Verifikasi Ulang Sekarang &rarr;
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-8 md:flex md:items-center md:justify-between border-b border-gray-100 bg-gradient-to-r from-red-50 to-white">
                <div class="flex items-center gap-4">
                    <div class="relative shrink-0">
                        @if($umkm->image_path)
                            <img src="{{ asset('storage/' . $umkm->image_path) }}" alt="{{ $umkm->business_name }}" class="w-16 h-16 rounded-2xl object-cover shadow-sm border-2 border-white">
                        @else
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#801414] to-[#b91c1c] text-white flex items-center justify-center font-bold text-2xl shadow-sm">
                                {{ strtoupper(substr($umkm->business_name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-1.5">
                            <h2 class="text-2xl sm:text-3xl font-bold text-[#801414]">{{ $umkm->business_name }}</h2>
                            @if($umkm->status == 'verified')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Disetujui
                                </span>
                            @elseif($umkm->status == 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Menunggu Persetujuan
                                </span>
                            @elseif($umkm->status == 'rejected')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Ditolak
                                </span>
                            @endif
                        </div>
                        <p class="text-gray-500 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $umkm->owner_name }} &bull; {{ $umkm->phone }} &bull; Kec. {{ $umkm->district ?? 'Wonogiri' }}
                        </p>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex flex-wrap items-center gap-2.5">
                    <a href="{{ route('direktori.show', $umkm->id) }}" target="_blank" class="inline-flex items-center justify-center bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-[#801414] font-semibold py-2.5 px-4 rounded-full transition-all shadow-sm text-sm" title="Lihat tampilan halaman toko Anda di direktori publik">
                        <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Lihat Toko
                    </a>
                    <a href="{{ route('toko.profile') }}" class="inline-flex items-center justify-center bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-[#801414] font-semibold py-2.5 px-4 rounded-full transition-all shadow-sm text-sm group">
                        <svg class="w-4 h-4 mr-1.5 text-slate-400 group-hover:text-[#801414] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profil UMKM
                    </a>
                    <a href="{{ route('toko.consultations') }}" class="inline-flex items-center justify-center bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold py-2.5 px-4 rounded-full transition-colors shadow-sm text-sm">
                        Riwayat Konsultasi
                    </a>
                    @if($umkm->status == 'verified')
                        <a href="{{ route('toko.product.create') }}" class="inline-flex items-center justify-center bg-[#801414] hover:bg-red-900 text-white font-semibold py-2.5 px-5 rounded-full transition-colors shadow text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            + Produk Baru
                        </a>
                    @else
                        <button type="button" disabled title="Toko Anda sedang Menunggu Persetujuan Admin sebelum dapat menambah produk baru." class="inline-flex items-center justify-center bg-slate-200 text-slate-400 font-semibold py-2.5 px-5 rounded-full cursor-not-allowed text-sm shadow-none opacity-80" onclick="alert('Pendaftaran toko Anda masih berstatus Menunggu Persetujuan admin. Anda belum dapat menambah produk baru.')">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            + Produk Baru
                        </button>
                    @endif
                </div>
            </div>

            <!-- Sub Navigasi Menu UMKM -->
            <div class="px-6 sm:px-8 bg-white border-t border-slate-100 flex items-center gap-8">
                <a href="{{ route('toko.index') }}" class="py-4 text-sm font-bold border-b-2 border-[#801414] text-[#801414] transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Katalog Produk
                    <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-[#801414] font-bold">{{ $products->count() }}</span>
                </a>
                <a href="{{ route('toko.profile') }}" class="py-4 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profil UMKM
                </a>
                <a href="{{ route('toko.consultations') }}" class="py-4 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Riwayat Konsultasi
                </a>
            </div>
        </div>

        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">Katalog Produk Anda</h3>
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 group flex flex-col">
                    <div class="relative h-48 overflow-hidden bg-gray-100">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        
                        <div class="absolute top-3 right-3">
                            @if($product->status == 'verified')
                                <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-emerald-200 shadow-sm">Disetujui</span>
                            @elseif($product->status == 'pending')
                                <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-amber-200 shadow-sm">Menunggu Persetujuan</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-red-200 shadow-sm">Ditolak</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="text-xs font-semibold text-[#eab308] uppercase tracking-wider mb-2">{{ $product->category }}</div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1">{{ $product->name }}</h4>
                        <p class="text-sm text-gray-500 line-clamp-2 mb-4 flex-1">{{ $product->description }}</p>
                        
                        <div class="mt-auto border-t border-slate-100 pt-4 flex items-center justify-between">
                            <a href="{{ route('toko.product.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit
                            </a>
                            <form action="{{ route('toko.product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada produk</h3>
                <p class="text-gray-500 mb-6">Anda belum menambahkan produk apapun ke etalase toko Anda.</p>
                @if($umkm->status == 'verified')
                    <a href="{{ route('toko.product.create') }}" class="inline-flex items-center gap-2 text-[#801414] font-semibold hover:underline">
                        Tambah Produk Pertama Anda &rarr;
                    </a>
                @elseif($umkm->status == 'pending')
                    <div class="inline-flex items-center gap-2 bg-amber-50 text-amber-800 border border-amber-200 px-4 py-2.5 rounded-full text-xs font-semibold shadow-xs">
                        <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Menunggu persetujuan admin sebelum dapat menambah produk baru
                    </div>
                @else
                    <div class="inline-flex flex-col sm:flex-row items-center gap-3 bg-red-50 text-red-800 border border-red-200 px-4 py-3 rounded-2xl text-xs font-semibold shadow-xs max-w-lg mx-auto">
                        <span class="flex items-center gap-1.5 text-red-700">
                            <svg class="w-4 h-4 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Toko belum disetujui oleh admin
                        </span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('toko.profile') }}#edit" class="text-xs font-bold text-red-800 underline hover:text-red-950">Perbaiki Data</a>
                            <span>&bull;</span>
                            <form action="{{ route('toko.resubmit') }}" method="POST" class="inline" onsubmit="return confirm('Ajukan ulang verifikasi toko ini ke Admin?');">
                                @csrf
                                <button type="submit" class="text-xs font-bold text-[#801414] hover:underline cursor-pointer">Ajukan Ulang &rarr;</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
