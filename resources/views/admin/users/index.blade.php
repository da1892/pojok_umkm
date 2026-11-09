@extends('layouts.admin')

@section('page_title', $currentRole === 'admin' ? 'Manajemen Administrator' : 'Manajemen Pelaku UMKM')

@section('content')
<div class="space-y-6">
    <!-- Header Page & Flash Message -->
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 text-sm flex items-start gap-3 shadow-xs">
        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div class="flex-1 font-medium leading-relaxed">
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 rounded-2xl p-4 text-sm flex items-start gap-3 shadow-xs">
        <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div class="flex-1 font-medium leading-relaxed">
            {{ session('error') }}
        </div>
    </div>
    @endif

    <!-- SUMMARY CARDS -->
    @if($currentRole === 'umkm')
    <!-- 3 Kartu Khusus Pelaku UMKM (User biasa dan semua pengguna sudah dihapus) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Card 1: Total Pelaku UMKM -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 border border-amber-200/60">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pelaku UMKM</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($totalUmkmUsers) }}</h3>
                <p class="text-[11px] text-slate-500">Akun pelaku usaha terdaftar</p>
            </div>
        </div>

        <!-- Card 2: Toko Terverifikasi -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-200/60">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">UMKM Terverifikasi</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($totalVerifiedUmkms) }}</h3>
                <p class="text-[11px] text-slate-500">Toko aktif di direktori</p>
            </div>
        </div>

        <!-- Card 3: Total Produk -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0 border border-blue-200/60">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Produk UMKM</p>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($totalProductsCount) }}</h3>
                <p class="text-[11px] text-slate-500">Koleksi produk di katalog</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Container Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <!-- Filter & Actions Bar -->
        <div class="p-5 sm:p-6 border-b border-slate-200/80 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="text-base sm:text-lg font-extrabold text-slate-800 tracking-tight">
                        {{ $currentRole === 'admin' ? 'Daftar Akun Administrator Dinas' : 'Daftar Pelaku UMKM Terdaftar' }}
                    </h3>
                    <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $currentRole === 'admin' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ $users->total() }} Data
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    {{ $currentRole === 'admin' 
                        ? 'Kelola akun staf dinas yang memiliki akses pengelolaan sistem Pojok UMKM.' 
                        : 'Daftar resmi pelaku usaha mikro Wonogiri yang telah terdaftar di sistem.' }}
                </p>
            </div>

            <!-- Action Buttons & Search -->
            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Search Form -->
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="hidden" name="role" value="{{ $currentRole }}">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $currentRole === 'admin' ? 'Cari nama atau email admin...' : 'Cari nama, email, toko UMKM...' }}" class="pl-9 pr-3 py-2 text-xs font-medium text-slate-800 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none w-52 sm:w-60" style="height: 40px;">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    @if(request('search'))
                    <a href="{{ route('admin.users.index', ['role' => $currentRole]) }}" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors" title="Hapus Pencarian">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                    @endif
                </form>

                <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

                @if($currentRole === 'umkm')
                <!-- Tombol Template Excel -->
                <a href="{{ route('admin.users.template') }}" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200/80 rounded-xl transition-colors cursor-pointer" style="height: 40px;" title="Unduh format template Excel untuk import massal">
                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="hidden sm:inline">Unduh Template</span>
                </a>

                <!-- Tombol Import Excel -->
                <button type="button" onclick="openImportModal()" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-300 rounded-xl transition-colors cursor-pointer" style="height: 40px;">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span>Import Excel / CSV</span>
                </button>

                <!-- Tombol Tambah Akun UMKM -->
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-[#800000] hover:bg-[#600000] rounded-xl shadow-xs transition-colors cursor-pointer" style="height: 40px;">
                    <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Tambah Akun UMKM</span>
                </a>
                @else
                <!-- Tombol Tambah Admin Baru -->
                <button type="button" onclick="openAddAdminModal()" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-[#800000] hover:bg-[#600000] rounded-xl shadow-xs transition-colors cursor-pointer" style="height: 40px;">
                    <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Tambah Administrator Baru</span>
                </button>
                @endif
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5 whitespace-nowrap">Nama</th>
                        <th class="px-5 py-3.5 whitespace-nowrap">Email</th>
                        @if($currentRole === 'umkm')
                        <th class="px-5 py-3.5">Nama UMKM</th>
                        <th class="px-4 py-3.5 whitespace-nowrap">No. HP / WhatsApp</th>
                        <th class="px-5 py-3.5">Alamat / Wilayah</th>
                        <th class="px-4 py-3.5 text-center whitespace-nowrap">Produk</th>
                        @else
                        <th class="px-5 py-3.5 whitespace-nowrap">Peran</th>
                        @endif
                        <th class="px-4 py-3.5 whitespace-nowrap">Terdaftar</th>
                        <th class="px-5 py-3.5 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <!-- 1. Kolom Nama -->
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-xs text-slate-700 shrink-0 uppercase overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background={{ $user->role === 'admin' ? '800000' : 'd97706' }}&color=fff&size=80" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 flex items-center gap-1.5">
                                        <span>{{ $user->name }}</span>
                                        @if($user->id === auth()->id())
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-blue-100 text-blue-700">(Anda)</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-slate-400">ID: #{{ $user->id }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- 2. Kolom Email -->
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <span class="font-semibold text-slate-700">{{ $user->email }}</span>
                        </td>

                        @if($currentRole === 'umkm')
                        <!-- 3. Kolom Nama UMKM -->
                        <td class="px-5 py-3.5">
                            @if($user->umkmProfile)
                            <div>
                                <a href="{{ route('admin.umkm.show', $user->umkmProfile->id) }}" class="font-bold text-[#800000] hover:underline flex items-center gap-1 text-xs sm:text-sm">
                                    <span>{{ $user->umkmProfile->business_name }}</span>
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                                @if($user->umkmProfile->nib)
                                <p class="text-[10px] text-slate-400 font-mono mt-0.5">NIB: {{ $user->umkmProfile->nib }}</p>
                                @endif
                            </div>
                            @else
                            <span class="text-xs text-slate-400 italic">Belum mengisi profil</span>
                            @endif
                        </td>

                        <!-- 4. Kolom No. HP / WhatsApp -->
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            @if($user->umkmProfile && $user->umkmProfile->phone)
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $user->umkmProfile->phone);
                                if (str_starts_with($cleanPhone, '0')) {
                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                }
                            @endphp
                            <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 transition-colors" title="Hubungi via WhatsApp">
                                <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2z"/></svg>
                                <span>{{ $user->umkmProfile->phone }}</span>
                            </a>
                            @else
                            <span class="text-slate-300 text-xs">-</span>
                            @endif
                        </td>

                        <!-- 5. Kolom Alamat / Wilayah -->
                        <td class="px-5 py-3.5">
                            @if($user->umkmProfile)
                            <div>
                                <p class="text-xs font-semibold text-slate-800">
                                    Kec. {{ $user->umkmProfile->district ?: '-' }}
                                    @if($user->umkmProfile->village)
                                    <span class="text-slate-400 font-normal">, Ds. {{ $user->umkmProfile->village }}</span>
                                    @endif
                                </p>
                                @if($user->umkmProfile->address)
                                <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-1" title="{{ $user->umkmProfile->address }}">
                                    {{ $user->umkmProfile->address }}
                                </p>
                                @endif
                            </div>
                            @else
                            <span class="text-slate-300 text-xs">-</span>
                            @endif
                        </td>

                        <!-- 6. Kolom Produk (Hanya badge jumlah produk yang bisa diklik untuk melihat daftar produknya) -->
                        <td class="px-4 py-3.5 text-center whitespace-nowrap">
                            @if($user->umkmProfile)
                            @php
                                $productsList = $user->umkmProfile->products->map(function($p) {
                                    return [
                                        'id' => $p->id,
                                        'name' => $p->name,
                                        'category' => $p->category,
                                        'price' => number_format($p->price, 0, ',', '.'),
                                        'status' => $p->status,
                                        'image' => $p->image_path ? asset('storage/' . $p->image_path) : 'https://placehold.co/100x100/f1f5f9/94a3b8?text=Produk',
                                        'edit_url' => route('admin.product.edit', $p->id)
                                    ];
                                });
                            @endphp
                            <button type="button" 
                                onclick='openProductsListModal("{{ addslashes($user->umkmProfile->business_name) }}", "{{ route('admin.users.product.create', $user->umkmProfile->id) }}", {{ json_encode($productsList) }})'
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-black transition-colors cursor-pointer group {{ $user->umkmProfile->products->count() > 0 ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}"
                                title="Klik untuk melihat produk toko ini">
                                <span>{{ $user->umkmProfile->products->count() }} Produk</span>
                                <svg class="w-3.5 h-3.5 text-emerald-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            @else
                            <span class="text-slate-300">-</span>
                            @endif
                        </td>
                        @else
                        <!-- Kolom Peran untuk Admin -->
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-50 text-red-700 border border-red-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Administrator Dinas
                            </span>
                        </td>
                        @endif

                        <!-- Kolom Terdaftar -->
                        <td class="px-4 py-3.5 whitespace-nowrap text-xs text-slate-500">
                            {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                        </td>

                        <!-- Kolom Aksi -->
                        <td class="px-5 py-3.5 text-right whitespace-nowrap">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                @if($currentRole === 'umkm' && $user->umkmProfile)
                                <!-- Tombol Tambah Produk di Samping Kanan -->
                                <a href="{{ route('admin.users.product.create', $user->umkmProfile->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-2xs transition-colors" title="Tambah produk baru untuk toko ini">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    <span>+ Produk</span>
                                </a>
                                @endif

                                <!-- Reset Password Button -->
                                <button type="button" onclick="openResetPasswordModal('{{ $user->id }}', '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors border border-slate-200 cursor-pointer" title="Ubah / Reset Kata Sandi Akun">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                    <span class="hidden sm:inline">Sandi</span>
                                </button>

                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ addslashes($user->name) }}?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-red-200 cursor-pointer" title="Hapus Akun Pengguna">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $currentRole === 'umkm' ? '8' : '5' }}" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <p class="text-sm font-bold text-slate-700">Tidak ada data {{ $currentRole === 'admin' ? 'administrator' : 'pelaku UMKM' }} yang sesuai.</p>
                                <p class="text-xs text-slate-400 mt-1">Gunakan kata kunci pencarian lain atau buat akun baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

<!-- ==================================================== -->
<!-- MODAL DAFTAR PRODUK TOKO (LIHAT PRODUK DI TOKO TERSEBUT) -->
<!-- ==================================================== -->
<div id="productsListModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all flex flex-col max-h-[85vh]">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900" id="productsModalStoreTitle">Daftar Produk Toko</h3>
                    <p class="text-xs text-slate-500">Semua produk yang terdaftar di toko UMKM ini</p>
                </div>
            </div>
            <button type="button" onclick="closeProductsListModal()" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Scrollable Product List -->
        <div class="p-6 overflow-y-auto flex-1 space-y-3" id="productsListContainer">
            <!-- Dynamic Content via Javascript -->
        </div>

        <!-- Footer -->
        <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/70 flex items-center justify-between shrink-0">
            <button type="button" onclick="closeProductsListModal()" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer">
                Tutup
            </button>
            <a id="productsModalAddBtn" href="#" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Tambah Produk untuk Toko Ini</span>
            </a>
        </div>
    </div>
</div>

<!-- ==================================================== -->
<!-- MODAL TAMBAH ADMINISTRATOR BARU -->
<!-- ==================================================== -->
@if($currentRole === 'admin')
<div id="addAdminModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-red-100 text-[#800000] flex items-center justify-center font-bold">
                    <svg class="w-5 h-5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Tambah Administrator Baru</h3>
                    <p class="text-xs text-slate-500">Akun pengelola dinas dengan hak akses penuh</p>
                </div>
            </div>
            <button type="button" onclick="closeAddAdminModal()" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.users.admin.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap Administrator <span class="text-red-500">*</span></label>
                <input type="text" name="name" required placeholder="Contoh: Bpk. Haryanto, S.Sos" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email Login <span class="text-red-500">*</span></label>
                <input type="email" name="email" required placeholder="Contoh: haryanto@wonogirikab.go.id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold text-slate-700">Kata Sandi Akun <span class="text-red-500">*</span></label>
                    <button type="button" onclick="generateRandomPassAdmin()" class="text-[10px] font-bold text-amber-700 hover:text-amber-900 bg-amber-100 hover:bg-amber-200 px-2 py-0.5 rounded-md transition-colors">
                        ⚡ Acak Sandi
                    </button>
                </div>
                <input type="text" id="admin_new_pass_input" name="password" required minlength="6" value="AdminWonogiri2026!" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3">
                <button type="button" onclick="closeAddAdminModal()" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-[#800000] hover:bg-[#600000] rounded-xl shadow-xs transition-colors cursor-pointer">
                    <span>Simpan Administrator</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- ==================================================== -->
<!-- MODAL IMPORT EXCEL / CSV -->
<!-- ==================================================== -->
@if($currentRole === 'umkm')
<div id="importModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Import Akun UMKM dari Excel</h3>
                    <p class="text-xs text-slate-500">Mendukung file <strong>.xlsx</strong> dan <strong>.csv</strong></p>
                </div>
            </div>
            <button type="button" onclick="closeImportModal()" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            <!-- Step Guidance -->
            <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-2xl p-4 text-xs text-emerald-950 space-y-2">
                <p class="font-extrabold flex items-center gap-1.5 text-emerald-900">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Petunjuk Pengisian Excel:
                </p>
                <ol class="list-decimal list-inside space-y-1 text-emerald-800 leading-relaxed text-[11px]">
                    <li>Unduh template resmi terlebih dahulu agar format kolom sesuai.</li>
                    <li>Kolom <strong>nama_usaha</strong> wajib diisi. Kolom <strong>email</strong> dan <strong>password</strong> boleh dikosongkan (sistem otomatis membuatkannya).</li>
                    <li>Bila kolom produk diisi pada baris yang sama, produk pertamanya otomatis langsung dibuat dan tayang di katalog publik.</li>
                </ol>
                <div class="pt-1">
                    <a href="{{ route('admin.users.template') }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 hover:text-emerald-900 underline">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Unduh Template Excel (.CSV) Disini</span>
                    </a>
                </div>
            </div>

            <!-- Upload Field -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilih File Spreadsheet (.xlsx / .csv)</label>
                <input type="file" name="file" accept=".xlsx,.csv,.txt" required class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 cursor-pointer border-2 border-dashed border-slate-300 rounded-2xl bg-slate-50 p-3">
                <p class="text-[10px] text-slate-400 mt-1">Maksimal ukuran file: 10MB.</p>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-2">
                <button type="button" onclick="closeImportModal()" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Proses Import Data</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- ==================================================== -->
<!-- MODAL RESET PASSWORD -->
<!-- ==================================================== -->
<div id="resetModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-red-100 text-[#800000] flex items-center justify-center font-bold">
                    <svg class="w-5 h-5 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Ubah Kata Sandi</h3>
                    <p class="text-xs text-slate-500" id="resetModalUserLabel">Pengguna</p>
                </div>
            </div>
            <button type="button" onclick="closeResetModal()" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="resetPasswordForm" method="POST" action="" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi Baru (Min. 6 Karakter)</label>
                <div class="relative">
                    <input type="text" id="new_password_input" name="password" required minlength="6" placeholder="Masukkan kata sandi baru" class="w-full pl-3 pr-24 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                    <button type="button" onclick="generateRandomPass()" class="absolute right-2 top-2 px-2 py-1 text-[10px] font-bold text-amber-700 bg-amber-100 hover:bg-amber-200 rounded-lg transition-colors cursor-pointer">
                        Acak Sandi
                    </button>
                </div>
                <p class="text-[10px] text-slate-400 mt-1">Sandi ini akan langsung aktif dan dapat digunakan untuk login.</p>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-2">
                <button type="button" onclick="closeResetModal()" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-[#800000] hover:bg-[#600000] rounded-xl shadow-xs transition-colors cursor-pointer">
                    <span>Simpan Sandi Baru</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Modal Daftar Produk Toko
function openProductsListModal(storeName, addProductUrl, products) {
    document.getElementById('productsModalStoreTitle').textContent = 'Produk Toko: ' + storeName;
    document.getElementById('productsModalAddBtn').href = addProductUrl;

    const container = document.getElementById('productsListContainer');
    container.innerHTML = '';

    if (!products || products.length === 0) {
        container.innerHTML = `
            <div class="text-center py-10 text-slate-400">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <p class="font-bold text-slate-700 text-sm">Belum ada produk di toko ini.</p>
                <p class="text-xs text-slate-400 mt-0.5">Klik tombol di bawah untuk menambahkan produk pertama.</p>
            </div>
        `;
    } else {
        products.forEach(function(p) {
            const item = document.createElement('div');
            item.className = 'flex items-center justify-between gap-3 p-3 bg-slate-50 border border-slate-200/80 rounded-2xl hover:bg-slate-100/70 transition-colors';
            item.innerHTML = `
                <div class="flex items-center gap-3 min-w-0">
                    <img src="${p.image}" alt="${p.name}" class="w-12 h-12 rounded-xl object-cover bg-white border border-slate-200 shrink-0">
                    <div class="min-w-0">
                        <h4 class="font-bold text-slate-900 text-xs sm:text-sm truncate">${p.name}</h4>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-[10px] font-bold bg-slate-200 text-slate-700 px-2 py-0.2 rounded-md">${p.category || 'Umum'}</span>
                            <span class="text-xs font-black text-[#800000]">Rp ${p.price}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${p.status === 'verified' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200'}">
                        ${p.status === 'verified' ? 'Disetujui' : 'Pending'}
                    </span>
                    <a href="${p.edit_url}" class="p-1.5 text-slate-500 hover:text-[#800000] bg-white border border-slate-200 rounded-lg hover:bg-red-50 transition-colors" title="Edit Produk">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                </div>
            `;
            container.appendChild(item);
        });
    }

    document.getElementById('productsListModal').classList.remove('hidden');
}

function closeProductsListModal() {
    document.getElementById('productsListModal').classList.add('hidden');
}

// Modal Tambah Admin Baru
function openAddAdminModal() {
    const modal = document.getElementById('addAdminModal');
    if (modal) modal.classList.remove('hidden');
}
function closeAddAdminModal() {
    const modal = document.getElementById('addAdminModal');
    if (modal) modal.classList.add('hidden');
}
function generateRandomPassAdmin() {
    const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789!@#';
    let pass = 'Admin';
    for (let i = 0; i < 4; i++) {
        pass += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    pass += '!2026';
    const input = document.getElementById('admin_new_pass_input');
    if (input) input.value = pass;
}

// Modal Import Excel
function openImportModal() {
    const modal = document.getElementById('importModal');
    if (modal) modal.classList.remove('hidden');
}
function closeImportModal() {
    const modal = document.getElementById('importModal');
    if (modal) modal.classList.add('hidden');
}

// Modal Reset Sandi
function openResetPasswordModal(userId, name, email) {
    const form = document.getElementById('resetPasswordForm');
    form.action = "{{ url('/admin/users') }}/" + userId + "/reset-password";
    document.getElementById('resetModalUserLabel').textContent = name + ' (' + email + ')';
    document.getElementById('new_password_input').value = 'PojokUmkm' + Math.floor(100 + Math.random() * 900) + '!';
    document.getElementById('resetModal').classList.remove('hidden');
}
function closeResetModal() {
    document.getElementById('resetModal').classList.add('hidden');
}

function generateRandomPass() {
    const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789!@#';
    let pass = 'Pojok';
    for (let i = 0; i < 4; i++) {
        pass += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    pass += '!2026';
    document.getElementById('new_password_input').value = pass;
}

if (window.location.hash === '#modal-import') {
    openImportModal();
}
</script>
@endsection
