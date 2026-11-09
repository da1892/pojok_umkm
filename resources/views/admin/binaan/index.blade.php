@extends('layouts.admin')

@section('page_title', 'UMKM Binaan Dinas')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-red-900 via-rose-950 to-slate-900 rounded-2xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
        <div class="absolute right-0 top-0 bottom-0 w-1/3 bg-white/5 transform skew-x-12 pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/20 text-yellow-300 border border-yellow-300/30 text-xs font-bold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    <span>Fasilitasi Promosi Digital Dinas KUKM</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight">UMKM Binaan Dinas</h2>
                <p class="text-white/80 text-xs sm:text-sm leading-relaxed">
                    Khusus mengelola data pelaku usaha mikro Wonogiri yang belum memiliki perangkat smartphone/email mandiri. Produk langsung terverifikasi dan tayang di katalog publik, serta dapat diserahterimakan kapan saja saat pemilik telah memiliki gawai.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('admin.binaan.product.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white border border-white/20 transition-all shadow-xs cursor-pointer active:scale-95">
                    <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Tambah Produk Binaan</span>
                </a>
                <a href="{{ route('admin.binaan.umkm.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-extrabold bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-slate-950 transition-all shadow-md cursor-pointer active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    <span>+ Tambah UMKM Binaan Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
            <span class="text-xs font-bold text-slate-400 block mb-1">Total UMKM Binaan</span>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-black text-slate-900">{{ $totalBinaan }}</span>
                <span class="text-xs text-slate-500 font-semibold">Usaha Terdata</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
            <span class="text-xs font-bold text-slate-400 block mb-1">Produk Binaan Tayang</span>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-black text-[#800000]">{{ $totalProdukBinaan }}</span>
                <span class="text-xs text-slate-500 font-semibold">Di Katalog Publik</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
            <span class="text-xs font-bold text-slate-400 block mb-1">Dikelola Dinas (Offline)</span>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-black text-amber-600">{{ $totalBelumKlaim }}</span>
                <span class="text-xs text-amber-700 font-semibold">Belum Punya Device</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs">
            <span class="text-xs font-bold text-slate-400 block mb-1">Sudah Diserahterimakan</span>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-black text-emerald-600">{{ $totalSudahKlaim }}</span>
                <span class="text-xs text-emerald-700 font-semibold">Berhasil Go Digital</span>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <!-- Filter Tabs & Search Header -->
        <div class="p-5 border-b border-slate-200/80 bg-slate-50/50 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <!-- Navigation Tabs -->
                <div class="inline-flex p-1 bg-slate-200/70 rounded-xl text-xs font-bold">
                    <a href="{{ route('admin.binaan.index', ['tab' => 'all']) }}" class="px-3.5 py-1.5 rounded-lg transition-all {{ $tab === 'all' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                        Semua Binaan ({{ $totalBinaan }})
                    </a>
                    <a href="{{ route('admin.binaan.index', ['tab' => 'offline']) }}" class="px-3.5 py-1.5 rounded-lg transition-all {{ $tab === 'offline' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                        🏛️ Dikelola Dinas ({{ $totalBelumKlaim }})
                    </a>
                    <a href="{{ route('admin.binaan.index', ['tab' => 'online']) }}" class="px-3.5 py-1.5 rounded-lg transition-all {{ $tab === 'online' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                        👤 Sudah Punya Akun ({{ $totalSudahKlaim }})
                    </a>
                </div>

                <!-- Fast Actions -->
                <div class="text-xs text-slate-500">
                    Menampilkan daftar UMKM yang difasilitasi oleh Dinas
                </div>
            </div>

            <!-- Search & Kecamatan Filters -->
            <form method="GET" action="{{ route('admin.binaan.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="sm:col-span-7">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama usaha binaan, nama pemilik, atau desa..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>
                <div class="sm:col-span-3">
                    <select name="district" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                        <option value="">Semua Kecamatan (Wonogiri)</option>
                        @foreach($districts as $dist => $villages)
                            <option value="{{ $dist }}" {{ request('district') == $dist ? 'selected' : '' }}>{{ $dist }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2 flex gap-1.5">
                    <button type="submit" class="w-full px-4 py-2 bg-[#800000] hover:bg-[#600000] text-white rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'district']) || request('tab') != 'all')
                    <a href="{{ route('admin.binaan.index') }}" class="px-2.5 py-2 bg-slate-200 text-slate-600 rounded-xl hover:bg-slate-300 transition-colors flex items-center justify-center text-xs" title="Reset Filter">
                        ✕
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-700 font-extrabold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="px-5 py-3.5">Profil UMKM Binaan</th>
                        <th class="px-4 py-3.5">Wilayah & Alamat</th>
                        <th class="px-4 py-3.5">Kontak Narahubung</th>
                        <th class="px-3 py-3.5 text-center">Katalog Produk</th>
                        <th class="px-4 py-3.5">Status Kepemilikan</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($binaanUmkms as $binaan)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <!-- Profil Usaha -->
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                    @if($binaan->image_path)
                                        <img src="{{ Str::startsWith($binaan->image_path, ['http://', 'https://']) ? $binaan->image_path : asset('storage/' . $binaan->image_path) }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="font-black text-slate-400 text-sm">{{ substr($binaan->business_name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="font-extrabold text-sm text-slate-900 truncate flex items-center gap-1.5">
                                        <span>{{ $binaan->business_name }}</span>
                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-amber-100 text-amber-800 border border-amber-200">Binaan</span>
                                    </div>
                                    <div class="text-xs text-slate-500 flex items-center gap-1 mt-0.5">
                                        <span>Pemilik: <strong>{{ $binaan->owner_name }}</strong></span>
                                        @if($binaan->gender)
                                            <span class="text-[10px] text-slate-400">({{ $binaan->gender }})</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Wilayah & Alamat -->
                        <td class="px-4 py-3.5">
                            <div class="font-bold text-slate-800">Kec. {{ $binaan->district }}</div>
                            <div class="text-[11px] text-slate-500">Ds. {{ $binaan->village }}</div>
                            <div class="text-[10px] text-slate-400 truncate max-w-[200px]" title="{{ $binaan->address }}">{{ $binaan->address }}</div>
                        </td>

                        <!-- Kontak Narahubung -->
                        <td class="px-4 py-3.5">
                            <div class="font-semibold text-slate-800">{{ $binaan->phone ?: '-' }}</div>
                            <span class="text-[10px] text-slate-400 block">Narahubung Pembeli</span>
                        </td>

                        <!-- Katalog Produk -->
                        <td class="px-3 py-3.5 text-center whitespace-nowrap">
                            <div class="inline-flex flex-col items-center">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-red-50 text-[#800000] border border-red-200">
                                    {{ $binaan->products->count() }} Produk
                                </span>
                                <a href="{{ route('admin.binaan.product.create', ['umkm_id' => $binaan->id]) }}" class="text-[10px] text-blue-600 hover:text-blue-800 font-bold mt-1 inline-flex items-center gap-0.5 hover:underline" title="Tambah produk baru untuk UMKM ini">
                                    <span>+ Tambah</span>
                                </a>
                            </div>
                        </td>

                        <!-- Status Kepemilikan -->
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            @if($binaan->user && $binaan->user->role === 'umkm')
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    <div>
                                        <span class="font-bold block text-[11px]">Sudah Punya Akun</span>
                                        <span class="text-[9px] text-emerald-700 font-mono">{{ $binaan->user->email }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-900 border border-amber-300 text-xs">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    <div>
                                        <span class="font-bold block text-[11px]">Dikelola Dinas</span>
                                        <span class="text-[9px] text-amber-700">Belum Punya Device</span>
                                    </div>
                                </div>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="px-5 py-3.5 text-right whitespace-nowrap">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                @if(!$binaan->user || $binaan->user->role !== 'umkm')
                                    <!-- Tombol Serah Terima / Klaim Toko -->
                                    <button type="button" 
                                            onclick="openClaimModal({{ $binaan->id }}, '{{ addslashes($binaan->business_name) }}', '{{ addslashes($binaan->owner_name) }}')" 
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-all shadow-2xs active:scale-95 cursor-pointer" 
                                            title="Serahkan toko ke akun pemilik saat pemilik sudah punya gadget">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                        <span>Hubungkan Akun</span>
                                    </button>
                                @endif

                                <a href="{{ route('admin.umkm.edit', $binaan->id) }}" class="p-1.5 text-slate-500 hover:text-[#800000] hover:bg-red-50 rounded-lg border border-slate-200 transition-colors" title="Edit Profil UMKM Binaan">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                <form action="{{ route('admin.umkm.destroy', $binaan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data UMKM Binaan ini beserta produk-produknya?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-600 hover:text-white hover:bg-red-600 rounded-lg border border-red-200 transition-colors cursor-pointer" title="Hapus UMKM Binaan">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center mb-3">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                                </div>
                                <h4 class="font-extrabold text-sm text-slate-800 mb-1">Belum Ada UMKM Binaan</h4>
                                <p class="text-xs text-slate-500 mb-4">Gunakan tombol di bawah untuk mendaftarkan pelaku UMKM Wonogiri yang belum memiliki akun atau gawai mandiri.</p>
                                <a href="{{ route('admin.binaan.umkm.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#800000] hover:bg-[#600000] transition-colors shadow-xs">
                                    + Tambah UMKM Binaan Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($binaanUmkms->hasPages())
        <div class="p-4 border-t border-slate-200/80 bg-slate-50/50">
            {{ $binaanUmkms->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Serah Terima / Hubungkan Akun Pengguna -->
<div id="claim-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100 p-6 space-y-4 animate-fadeIn">
        <div class="flex items-start justify-between gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            </div>
            <button type="button" onclick="closeClaimModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                ✕
            </button>
        </div>

        <div>
            <h3 class="text-base font-extrabold text-slate-900">Serahkan Kepemilikan Toko</h3>
            <p class="text-xs text-slate-500 mt-0.5">Hubungkan toko binaan ke akun pengguna yang telah didaftarkan oleh pemilik usaha.</p>
        </div>

        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/80 text-xs text-slate-700 space-y-1">
            <div>Nama Usaha: <strong id="modal-business-name" class="text-slate-900"></strong></div>
            <div>Pemilik Usaha: <strong id="modal-owner-name" class="text-slate-900"></strong></div>
        </div>

        <form id="claim-form" method="POST" action="">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Pengguna Pemilik <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required placeholder="contoh: slamet.barokah@gmail.com" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 outline-none">
                    <p class="text-[10px] text-slate-500 mt-1 leading-relaxed">
                        * Pastikan pemilik usaha telah mendaftar mandiri di web dengan email tersebut. Kata sandi dibuat sendiri oleh pemilik sehingga aman dan terlindungi.
                    </p>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeClaimModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors shadow-sm">
                        Hubungkan & Serahkan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openClaimModal(umkmId, businessName, ownerName) {
        document.getElementById('modal-business-name').textContent = businessName;
        document.getElementById('modal-owner-name').textContent = ownerName;
        
        const form = document.getElementById('claim-form');
        form.action = '{{ url("/admin/binaan") }}/' + umkmId + '/klaim';

        document.getElementById('claim-modal').classList.remove('hidden');
    }

    function closeClaimModal() {
        document.getElementById('claim-modal').classList.add('hidden');
    }
</script>
@endsection

