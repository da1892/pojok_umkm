@extends('layouts.admin')

@section('page_title', 'Manajemen Pengguna & UMKM')

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

    <!-- 4 Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Users -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pengguna</p>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">{{ number_format($totalUsers) }}</h3>
                <p class="text-[11px] text-slate-500">Semua akun sistem</p>
            </div>
        </div>

        <!-- Card 2: Pelaku UMKM -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-amber-700 uppercase tracking-wider">Pelaku UMKM</p>
                <h3 class="text-2xl font-black text-amber-600 tracking-tight">{{ number_format($totalUmkmUsers) }}</h3>
                <p class="text-[11px] text-slate-500">Memiliki profil toko</p>
            </div>
        </div>

        <!-- Card 3: Administrator -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-red-50 text-[#800000] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-red-800 uppercase tracking-wider">Administrator</p>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">{{ number_format($totalAdminUsers) }}</h3>
                <p class="text-[11px] text-slate-500">Pengelola dinas</p>
            </div>
        </div>

        <!-- Card 4: User Publik -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">User Publik</p>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">{{ number_format($totalPublicUsers) }}</h3>
                <p class="text-[11px] text-slate-500">Masyarakat umum</p>
            </div>
        </div>
    </div>

    <!-- Main Container Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <!-- Filter & Actions Bar -->
        <div class="p-5 sm:p-6 border-b border-slate-200/80 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
            <div>
                <h3 class="text-base sm:text-lg font-extrabold text-slate-800 tracking-tight">Daftar Pengguna Sistem</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola akun pelaku UMKM, administrator dinas, dan import data massal dari file Excel.</p>
            </div>

            <!-- Action Buttons & Search -->
            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Search & Role Form -->
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, toko..." class="pl-9 pr-3 py-2 text-xs font-medium text-slate-800 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none w-48 sm:w-56" style="height: 40px;">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <select name="role" onchange="this.form.submit()" class="px-3 py-2 text-xs font-bold text-slate-700 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none cursor-pointer" style="height: 40px;">
                        <option value="">Semua Peran</option>
                        <option value="umkm" {{ request('role') == 'umkm' ? 'selected' : '' }}>Pelaku UMKM</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User Publik</option>
                    </select>

                    @if(request('search') || request('role'))
                    <a href="{{ route('admin.users.index') }}" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors" title="Reset Filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                    @endif
                </form>

                <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

                <!-- Template Download Button -->
                <a href="{{ route('admin.users.template') }}" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200/80 rounded-xl transition-colors cursor-pointer" style="height: 40px;" title="Unduh format template Excel untuk import massal">
                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="hidden sm:inline">Unduh Template</span>
                </a>

                <!-- Import Excel Modal Trigger -->
                <button type="button" onclick="openImportModal()" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-300 rounded-xl transition-colors cursor-pointer" style="height: 40px;">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span>Import Excel / CSV</span>
                </button>

                <!-- Create UMKM User Button (Main Action) -->
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-[#800000] hover:bg-[#600000] rounded-xl shadow-xs transition-colors cursor-pointer" style="height: 40px;">
                    <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Buat Akun Pelaku UMKM</span>
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Pengguna & Email</th>
                        <th class="px-4 py-3.5 whitespace-nowrap">Peran</th>
                        <th class="px-5 py-3.5">Toko / UMKM Terkait</th>
                        <th class="px-3 py-3.5 text-center whitespace-nowrap">Produk</th>
                        <th class="px-4 py-3.5 whitespace-nowrap">Terdaftar</th>
                        <th class="px-5 py-3.5 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <!-- User Name & Email -->
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-xs text-slate-700 shrink-0 uppercase overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=800000&color=fff&size=80" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0">
                                    <div class="font-bold text-slate-900 truncate flex items-center gap-1.5">
                                        <span>{{ $user->name }}</span>
                                        @if($user->id === auth()->id())
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-blue-100 text-blue-700">(Anda)</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-slate-500 truncate flex items-center gap-1">
                                        <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Role Badge -->
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            @if($user->role === 'admin')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-50 text-red-700 border border-red-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Administrator
                            </span>
                            @elseif($user->role === 'umkm')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-300">
                                <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                Pelaku UMKM
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                User Publik
                            </span>
                            @endif
                        </td>

                        <!-- Store / UMKM Profile -->
                        <td class="px-5 py-3.5">
                            @if($user->umkmProfile)
                            <div>
                                <a href="{{ route('admin.umkm.show', $user->umkmProfile->id) }}" class="font-bold text-[#800000] hover:underline flex items-center gap-1 text-xs sm:text-sm">
                                    <span>{{ $user->umkmProfile->business_name }}</span>
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                                <p class="text-[11px] text-slate-500 mt-0.5">
                                    Kec. {{ $user->umkmProfile->district }} @if($user->umkmProfile->village) • Ds. {{ $user->umkmProfile->village }} @endif
                                </p>
                                @if($user->umkmProfile->phone)
                                <p class="text-[11px] text-slate-400 flex items-center gap-1 mt-0.5">
                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>{{ $user->umkmProfile->phone }}</span>
                                </p>
                                @endif
                            </div>
                            @else
                            <span class="text-xs text-slate-400 italic">Belum memiliki toko</span>
                            @endif
                        </td>

                        <!-- Product Count -->
                        <td class="px-3 py-3.5 text-center whitespace-nowrap">
                            @if($user->umkmProfile)
                            <div class="inline-flex flex-col items-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-black {{ $user->umkmProfile->products->count() > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $user->umkmProfile->products->count() }} Produk
                                </span>
                                <a href="{{ route('admin.users.product.create', $user->umkmProfile->id) }}" class="text-[10px] text-blue-600 hover:text-blue-800 font-bold mt-1 inline-flex items-center gap-0.5" title="Tambah produk untuk UMKM ini">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    <span>+ Produk</span>
                                </a>
                            </div>
                            @else
                            <span class="text-slate-300">-</span>
                            @endif
                        </td>

                        <!-- Joined Date -->
                        <td class="px-4 py-3.5 whitespace-nowrap text-xs text-slate-500">
                            {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                        </td>

                        <!-- Actions -->
                        <td class="px-5 py-3.5 text-right whitespace-nowrap">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                @if($user->umkmProfile)
                                <a href="{{ route('admin.users.product.create', $user->umkmProfile->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors border border-emerald-200" title="Tambah produk baru untuk toko ini">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    <span class="hidden sm:inline">Produk</span>
                                </a>
                                @endif

                                <!-- Reset Password Button -->
                                <button type="button" onclick="openResetPasswordModal('{{ $user->id }}', '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors border border-slate-200" title="Ubah / Reset Kata Sandi Akun">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                    <span class="hidden sm:inline">Sandi</span>
                                </button>

                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ addslashes($user->name) }}? Semua data toko dan produk miliknya juga akan terhapus.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-red-200" title="Hapus Akun Pengguna">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <p class="text-sm font-bold text-slate-700">Tidak ada data pengguna yang sesuai.</p>
                                <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci lain atau buat akun baru.</p>
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
<!-- MODAL IMPORT EXCEL / CSV -->
<!-- ==================================================== -->
<div id="importModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Import Akun UMKM dari Excel</h3>
                    <p class="text-xs text-slate-500">Mendukung format file <strong>.xlsx</strong> dan <strong>.csv</strong></p>
                </div>
            </div>
            <button type="button" onclick="closeImportModal()" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100">
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
                    <li>Kolom <strong>nama_usaha</strong> wajib diisi. Kolom <strong>email</strong> dan <strong>password</strong> boleh dikosongkan (sistem akan otomatis membuatkannya).</li>
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
            <button type="button" onclick="closeResetModal()" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="resetPasswordForm" method="POST" action="" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi Baru (Min. 6 Karakter)</label>
                <div class="relative">
                    <input type="text" id="new_password_input" name="password" required minlength="6" placeholder="Masukkan kata sandi baru" class="w-full pl-3 pr-24 py-2.5 text-xs sm:text-sm font-semibold text-slate-800 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                    <button type="button" onclick="generateRandomPass()" class="absolute right-2 top-2 px-2 py-1 text-[10px] font-bold text-amber-700 bg-amber-100 hover:bg-amber-200 rounded-lg transition-colors">
                        Acak Sandi
                    </button>
                </div>
                <p class="text-[10px] text-slate-400 mt-1">Sandi ini akan langsung aktif dan dapat digunakan pemilik untuk login.</p>
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
function openImportModal() {
    document.getElementById('importModal').classList.remove('hidden');
}
function closeImportModal() {
    document.getElementById('importModal').classList.add('hidden');
}

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

// Auto open modal jika ada hash #modal-import
if (window.location.hash === '#modal-import') {
    openImportModal();
}
</script>
@endsection
