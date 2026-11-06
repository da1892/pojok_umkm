<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Pojok UMKM Wonogiri')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#FAF9F6] text-slate-900 antialiased overflow-hidden selection:bg-[#800000] selection:text-white">
    <div class="flex h-screen w-full relative">
        <!-- Mobile Sidebar Backdrop -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/50 z-30 lg:hidden hidden transition-opacity opacity-0"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-[#800000] text-white flex flex-col transition-transform duration-300 z-40 fixed inset-y-0 left-0 lg:relative lg:translate-x-0 h-full shrink-0 shadow-xl -translate-x-full">
            <!-- Logo Area -->
            <div class="flex items-center justify-between px-6 py-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-lg p-1 shadow-sm flex items-center justify-center shrink-0">
                        <img src="{{ asset('images/logo-wonogiri.png') }}" alt="Logo Wonogiri" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="font-bold text-sm tracking-wide leading-tight">Pojok UMKM</h1>
                        <p class="text-[10px] text-white/70">Wonogiri Admin</p>
                    </div>
                </div>
                <button id="sidebarCloseBtn" class="lg:hidden text-white/70 hover:text-white p-1 rounded-md hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar">
                @php
                    $unansweredConsultationsCount = \App\Models\Consultation::where('status', 'menunggu')->count();
                    $pendingUmkmCount = \App\Models\User\UmkmProfile::where('status', 'pending')->count();
                    $pendingProductsCount = \App\Models\User\Product::where('status', 'pending')->count();
                    $pendingVerificationsCount = $pendingUmkmCount + $pendingProductsCount;
                @endphp
                <a href="{{ route('dashboard') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-[#600000] text-white font-medium border border-white/10' : 'text-white/70 hover:bg-white/5 hover:text-white' }} text-sm transition-colors group">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span>Dashboard</span>
                    </div>
                    @if($pendingVerificationsCount > 0)
                        <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[11px] font-black rounded-full bg-amber-400 text-slate-900 shadow-xs animate-pulse" title="{{ $pendingVerificationsCount }} data baru menunggu verifikasi ({{ $pendingUmkmCount }} Profil UMKM, {{ $pendingProductsCount }} Produk)">
                            {{ $pendingVerificationsCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.products') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.products*') || request()->routeIs('admin.product.*') ? 'bg-[#600000] text-white font-medium border border-white/10' : 'text-white/70 hover:bg-white/5 hover:text-white' }} text-sm transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.products*') || request()->routeIs('admin.product.*') ? 'text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Kelola Produk
                </a>
                <a href="{{ route('admin.stores') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.stores*') || request()->routeIs('admin.umkm.*') ? 'bg-[#600000] text-white font-medium border border-white/10' : 'text-white/70 hover:bg-white/5 hover:text-white' }} text-sm transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.stores*') || request()->routeIs('admin.umkm.*') ? 'text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Data UMKM
                </a>
                <a href="{{ route('admin.consultations') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.consultations*') ? 'bg-[#600000] text-white font-medium border border-white/10' : 'text-white/70 hover:bg-white/5 hover:text-white' }} text-sm transition-colors group">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.consultations*') ? 'text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <span>Kelola Konsultasi</span>
                    </div>
                    @if($unansweredConsultationsCount > 0)
                        <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[11px] font-black rounded-full bg-amber-400 text-slate-900 shadow-xs animate-pulse" title="{{ $unansweredConsultationsCount }} pesan konsultasi belum dijawab">
                            {{ $unansweredConsultationsCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.verifications') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.verifications*') ? 'bg-[#600000] text-white font-medium border border-white/10' : 'text-white/70 hover:bg-white/5 hover:text-white' }} text-sm transition-colors group">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.verifications*') ? 'text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Verifikasi Data</span>
                    </div>
                    @if($pendingVerificationsCount > 0)
                        <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[11px] font-black rounded-full bg-amber-400 text-slate-900 shadow-xs animate-pulse" title="{{ $pendingVerificationsCount }} data baru menunggu verifikasi ({{ $pendingUmkmCount }} Profil UMKM, {{ $pendingProductsCount }} Produk)">
                            {{ $pendingVerificationsCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.news') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.news*') ? 'bg-[#600000] text-white font-medium border border-white/10' : 'text-white/70 hover:bg-white/5 hover:text-white' }} text-sm transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.news*') ? 'text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2"></path></svg>
                    Berita & Kegiatan
                </a>
                <a href="{{ route('admin.visitors') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.visitors*') || request()->routeIs('admin.reports*') ? 'bg-[#600000] text-white font-medium border border-white/10' : 'text-white/70 hover:bg-white/5 hover:text-white' }} text-sm transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.visitors*') || request()->routeIs('admin.reports*') ? 'text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Statistik Pengunjung
                </a>
            </nav>

            <!-- User Profile (Bottom) -->
            <div class="p-4 border-t border-white/10 bg-black/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center overflow-hidden shrink-0 border border-white/20">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin Wonogiri') }}&background=800000&color=fff" alt="User Avatar" class="w-full h-full object-cover">
                    </div>
                    <div class="overflow-hidden flex-1">
                        <p class="text-sm font-semibold truncate">{{ auth()->user()->name ?? 'Admin Wonogiri' }}</p>
                        <p class="text-[10px] text-white/60 truncate">Admin</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                        @csrf
                        <button type="submit" class="p-1.5 text-white/50 hover:text-red-300 hover:bg-white/10 rounded-md transition-colors" title="Logout">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 bg-[#F8FAFC] lg:w-full">
            <!-- Topbar -->
            <header class="h-16 bg-white/95 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-4 lg:px-8 shrink-0 z-10 sticky top-0 shadow-xs">
                <div class="flex items-center gap-3">
                    <button id="sidebarToggleBtn" class="lg:hidden p-2 text-slate-600 hover:text-[#800000] hover:bg-red-50 rounded-xl transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg lg:text-xl font-extrabold text-slate-800 tracking-tight truncate max-w-[200px] sm:max-w-xs md:max-w-md">@yield('page_title', 'Dashboard Pojok UMKM Wonogiri')</h2>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-[#800000] bg-slate-100 hover:bg-red-50 rounded-xl transition-colors border border-slate-200/80">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Lihat Situs Publik
                    </a>
                    <button class="relative p-2 text-slate-400 hover:text-[#800000] hover:bg-red-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                    </button>
                    <div class="h-6 w-px bg-slate-200"></div>
                    <div class="flex items-center gap-2.5 pl-1">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-[#800000] to-red-600 text-white font-bold text-xs flex items-center justify-center shadow-sm">
                            AW
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-xs font-bold text-slate-800 leading-tight">Admin Wonogiri</p>
                            <p class="text-[10px] text-slate-400">Super Admin</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-6 lg:p-8 relative">
                <!-- Background decoration -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-red-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
                
                <div class="relative z-10 max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarBackdrop.classList.remove('hidden');
                setTimeout(() => sidebarBackdrop.classList.remove('opacity-0'), 10);
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarBackdrop.classList.add('opacity-0');
                setTimeout(() => sidebarBackdrop.classList.add('hidden'), 300);
            }

            if(sidebarToggleBtn) sidebarToggleBtn.addEventListener('click', openSidebar);
            if(sidebarCloseBtn) sidebarCloseBtn.addEventListener('click', closeSidebar);
            if(sidebarBackdrop) sidebarBackdrop.addEventListener('click', closeSidebar);
        });

        // Global SweetAlert Confirmation Functions
        function confirmVerifyUmkm(formId, umkmName) {
            Swal.fire({
                title: 'Setujui Profil UMKM?',
                html: `
                    <div class="mt-2 text-center">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-extrabold uppercase tracking-wider mb-2.5 shadow-2xs">
                            PROFIL TOKO UMKM
                        </div>
                        <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-2xl">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Nama Toko UMKM</p>
                            <p class="text-base font-black text-slate-900 break-words leading-snug">"${umkmName}"</p>
                        </div>
                        <p class="text-xs text-slate-500 mt-3 leading-relaxed">
                            Apakah Anda yakin ingin menyetujui pendaftaran profil UMKM ini?<br>Toko akan langsung aktif dan terdaftar resmi di sistem Pojok UMKM.
                        </p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Setujui Toko',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'rounded-3xl shadow-2xl border border-slate-100 p-6',
                    title: 'text-slate-800 font-black text-lg mb-0',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5 text-xs shadow-md bg-emerald-600 hover:bg-emerald-700 text-white',
                    cancelButton: 'rounded-xl font-semibold px-5 py-2.5 text-xs bg-slate-100 hover:bg-slate-200 text-slate-700'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(formId);
                    if (form) form.submit();
                }
            });
        }

        function confirmVerifyProduct(formId, productName, umkmName = '') {
            const umkmInfo = umkmName ? `
                <div class="mt-1.5 flex items-center justify-center gap-1.5 text-xs text-slate-500">
                    <span>Milik Toko UMKM:</span>
                    <strong class="text-slate-800 font-bold">${umkmName}</strong>
                </div>` : '';

            Swal.fire({
                title: 'Setujui Produk Baru?',
                html: `
                    <div class="mt-2 text-center">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-extrabold uppercase tracking-wider mb-2.5 shadow-2xs">
                            PRODUK UMKM
                        </div>
                        <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-2xl">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Nama Produk</p>
                            <p class="text-base font-black text-slate-900 break-words leading-snug">"${productName}"</p>
                            ${umkmInfo}
                        </div>
                        <p class="text-xs text-slate-500 mt-3 leading-relaxed">
                            Apakah Anda yakin ingin menyetujui produk ini?<br>Produk akan langsung tayang dan dapat dilihat publik di katalog.
                        </p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Setujui Produk',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'rounded-3xl shadow-2xl border border-slate-100 p-6',
                    title: 'text-slate-800 font-black text-lg mb-0',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5 text-xs shadow-md bg-emerald-600 hover:bg-emerald-700 text-white',
                    cancelButton: 'rounded-xl font-semibold px-5 py-2.5 text-xs bg-slate-100 hover:bg-slate-200 text-slate-700'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(formId);
                    if (form) form.submit();
                }
            });
        }

        function confirmRejectProduct(formId, productName, umkmName = '') {
            const umkmInfo = umkmName ? `
                <div class="mt-1.5 flex items-center justify-center gap-1.5 text-xs text-red-600/80">
                    <span>Milik Toko UMKM:</span>
                    <strong class="text-red-950 font-bold">${umkmName}</strong>
                </div>` : '';

            Swal.fire({
                title: 'Tolak Produk Ini?',
                html: `
                    <div class="mt-2 text-center">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-red-800 text-[11px] font-extrabold uppercase tracking-wider mb-2.5 shadow-2xs">
                            PRODUK UMKM
                        </div>
                        <div class="p-3.5 bg-red-50/70 border border-red-200 rounded-2xl">
                            <p class="text-[10px] font-bold text-red-400 uppercase tracking-wider mb-0.5">Nama Produk</p>
                            <p class="text-base font-black text-red-950 break-words leading-snug">"${productName}"</p>
                            ${umkmInfo}
                        </div>
                        <p class="text-xs text-slate-500 mt-3 leading-relaxed">
                            Apakah Anda yakin ingin menolak produk ini?<br>Produk ini tidak akan ditampilkan pada katalog publik.
                        </p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Tolak Produk',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'rounded-3xl shadow-2xl border border-red-100 p-6',
                    title: 'text-red-600 font-black text-lg mb-0',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5 text-xs shadow-md bg-red-600 hover:bg-red-700 text-white',
                    cancelButton: 'rounded-xl font-semibold px-5 py-2.5 text-xs bg-slate-100 hover:bg-slate-200 text-slate-700'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(formId);
                    if (form) form.submit();
                }
            });
        }
        
        function confirmDeleteUmkm(umkmId, umkmName) {
            Swal.fire({
                title: 'Hapus Data UMKM?',
                html: `Apakah Anda yakin ingin menghapus data UMKM <strong>"${umkmName}"</strong>?<br><span class="text-xs text-red-500 mt-2 block font-medium">Peringatan: Seluruh produk dan informasi terkait UMKM ini akan dihapus secara permanen.</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl border border-slate-100',
                    confirmButton: 'rounded-xl font-bold px-5 py-2.5 text-sm shadow-sm',
                    cancelButton: 'rounded-xl font-semibold px-5 py-2.5 text-sm shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-umkm-form-' + umkmId);
                    if (form) form.submit();
                }
            });
        }
        // Global Floating Tooltip System
        (function() {
            let tip = null;

            function getOrCreateTooltip() {
                if (!tip) {
                    tip = document.createElement('div');
                    tip.id = 'app-global-tooltip';
                    tip.style.cssText = 'position:fixed; z-index:999999; pointer-events:none; background:#0f172a; color:#ffffff; font-size:11px; font-weight:600; padding:5px 10px; border-radius:6px; box-shadow:0 6px 18px rgba(0,0,0,0.25); transition:opacity 0.15s ease, transform 0.15s ease; opacity:0; transform:scale(0.95); white-space:nowrap; letter-spacing:0.2px; font-family:Inter,sans-serif;';
                    
                    const arrow = document.createElement('div');
                    arrow.id = 'app-global-tooltip-arrow';
                    arrow.style.cssText = 'position:absolute; width:6px; height:6px; background:#0f172a; transform:rotate(45deg);';
                    tip.appendChild(arrow);
                    
                    const textNode = document.createElement('span');
                    textNode.id = 'app-global-tooltip-text';
                    tip.appendChild(textNode);

                    document.body.appendChild(tip);
                }
                return tip;
            }

            document.addEventListener('mouseover', function(e) {
                const target = e.target.closest('[data-tooltip]');
                if (!target) return;

                const text = target.getAttribute('data-tooltip');
                if (!text) return;

                const tooltip = getOrCreateTooltip();
                const textSpan = tooltip.querySelector('#app-global-tooltip-text');
                const arrow = tooltip.querySelector('#app-global-tooltip-arrow');
                if (textSpan) textSpan.textContent = text;

                tooltip.style.opacity = '0';
                tooltip.style.display = 'block';

                const targetRect = target.getBoundingClientRect();
                const tipRect = tooltip.getBoundingClientRect();

                let top = targetRect.top - tipRect.height - 8;
                let isAbove = true;

                if (top < 10) {
                    top = targetRect.bottom + 8;
                    isAbove = false;
                }

                let left = targetRect.left + (targetRect.width - tipRect.width) / 2;
                if (left < 8) left = 8;
                if (left + tipRect.width > window.innerWidth - 8) {
                    left = window.innerWidth - tipRect.width - 8;
                }

                if (arrow) {
                    arrow.style.left = 'calc(50% - 3px)';
                    if (isAbove) {
                        arrow.style.top = 'auto';
                        arrow.style.bottom = '-3px';
                    } else {
                        arrow.style.bottom = 'auto';
                        arrow.style.top = '-3px';
                    }
                }

                tooltip.style.top = top + 'px';
                tooltip.style.left = left + 'px';
                tooltip.style.opacity = '1';
                tooltip.style.transform = 'scale(1)';
            });

            document.addEventListener('mouseout', function(e) {
                const target = e.target.closest('[data-tooltip]');
                if (!target) return;

                if (tip) {
                    tip.style.opacity = '0';
                    tip.style.transform = 'scale(0.95)';
                }
            });
        })();
    </script>

    @if(session('success') || session('verified_item'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const verifiedItem = {!! json_encode(session('verified_item')) !!};
            const rawMsg = {!! json_encode(session('success')) !!} || '';
            const lowerMsg = (rawMsg || '').toLowerCase();
            
            // Tentukan status penolakan atau persetujuan
            let isRejected = false;
            if (verifiedItem && verifiedItem.action === 'rejected') {
                isRejected = true;
            } else if (lowerMsg.includes('tolak') || lowerMsg.includes('ditolak')) {
                isRejected = true;
            }

            // A. Jika ada data verified_item terstruktur dari Controller
            if (verifiedItem) {
                const isProduct = verifiedItem.type === 'product';
                const badgeLabel = isProduct ? 'PRODUK UMKM' : 'PROFIL TOKO UMKM';
                const badgeBg = isRejected ? '#fee2e2' : '#dcfce7';
                const badgeColor = isRejected ? '#991b1b' : '#166534';
                const cardBg = isRejected ? '#fef2f2' : '#f0fdf4';
                const cardBorder = isRejected ? '#fecaca' : '#bbf7d0';
                const confirmBtnColor = isRejected ? '#dc2626' : '#059669';

                const subInfo = isProduct 
                    ? `<div style="display:inline-flex; align-items:center; gap:6px; margin-top:8px; padding:4px 12px; background:#ffffff; border:1px solid ${cardBorder}; border-radius:10px; font-size:12px; color:#475569;">
                         <span style="color:#64748b;">Milik Toko UMKM:</span>
                         <strong style="color:${isRejected ? '#991b1b' : '#166534'};">${verifiedItem.umkm_name || 'UMKM'}</strong>
                       </div>`
                    : (verifiedItem.owner ? `<div style="font-size:12px; color:#64748b; margin-top:6px;">Pemilik Usaha: <strong style="color:#1e293b;">${verifiedItem.owner}</strong></div>` : '');

                const noteInfo = verifiedItem.note ? `
                    <div style="margin-top:10px; text-align:left; background:#ffffff; border:1px dashed #f87171; border-radius:10px; padding:8px 12px; font-size:11px; color:#7f1d1d;">
                        <strong>Catatan Alasan:</strong> ${verifiedItem.note}
                    </div>` : '';

                Swal.fire({
                    icon: isRejected ? 'error' : 'success',
                    title: isRejected ? 'Pengajuan Ditolak' : 'Berhasil Disetujui!',
                    html: `
                        <div style="text-align:center; padding: 4px 0;">
                            <div style="display:inline-flex; align-items:center; gap:6px; padding:4px 14px; border-radius:9999px; background:${badgeBg}; color:${badgeColor}; font-size:11px; font-weight:800; letter-spacing:0.5px; margin-bottom:12px;">
                                ${badgeLabel}
                            </div>
                            <div style="background:${cardBg}; border:1.5px solid ${cardBorder}; border-radius:18px; padding:16px 18px; box-shadow:0 1px 2px rgba(0,0,0,0.04);">
                                <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">
                                    ${isProduct ? (isRejected ? 'Nama Produk Ditolak' : 'Nama Produk Disetujui') : (isRejected ? 'Nama Toko UMKM Ditolak' : 'Nama Toko UMKM Disetujui')}
                                </div>
                                <div style="font-size:19px; font-weight:900; color:#0f172a; line-height:1.3; word-break:break-word;">
                                    "${verifiedItem.name}"
                                </div>
                                ${subInfo}
                                ${noteInfo}
                            </div>
                            <div style="font-size:13px; color:#64748b; margin-top:12px; line-height:1.5; font-weight:500;">
                                ${verifiedItem.message || ''}
                            </div>
                        </div>
                    `,
                    confirmButtonColor: confirmBtnColor,
                    confirmButtonText: 'Oke',
                    showConfirmButton: true,
                    allowOutsideClick: false,
                    allowEscapeKey: true,
                    customClass: {
                        popup: 'rounded-3xl shadow-2xl p-6 border-2 ' + (isRejected ? 'border-red-100' : 'border-emerald-100'),
                        title: (isRejected ? 'text-red-600' : 'text-emerald-700') + ' font-bold text-xl mb-1',
                        confirmButton: 'rounded-xl font-bold px-8 py-2.5 text-sm shadow-md text-white'
                    }
                });
                return;
            }

            // B. Fallback Regex Parsing jika verified_item tidak ada tapi ada rawMsg verifikasi
            const isProduct = lowerMsg.includes('produk');
            const isUmkm = lowerMsg.includes('profil umkm') || lowerMsg.includes('umkm');

            if (isProduct || isUmkm) {
                const nameMatch = rawMsg.match(/'([^']+)'/) || rawMsg.match(/"([^"]+)"/);
                const itemName = nameMatch ? nameMatch[1] : (isProduct ? 'Produk UMKM' : 'Profil UMKM');
                const umkmMatch = rawMsg.match(/\(UMKM:\s*([^)]+)\)/i);
                const umkmDetail = umkmMatch ? umkmMatch[1] : '';

                const badgeLabel = isProduct ? 'PRODUK UMKM' : 'PROFIL TOKO UMKM';
                const badgeBg = isRejected ? '#fee2e2' : '#dcfce7';
                const badgeColor = isRejected ? '#991b1b' : '#166534';
                const cardBg = isRejected ? '#fef2f2' : '#f0fdf4';
                const cardBorder = isRejected ? '#fecaca' : '#bbf7d0';
                const confirmBtnColor = isRejected ? '#dc2626' : '#059669';

                const subInfo = (isProduct && umkmDetail) 
                    ? `<div style="display:inline-flex; align-items:center; gap:6px; margin-top:8px; padding:4px 12px; background:#ffffff; border:1px solid ${cardBorder}; border-radius:10px; font-size:12px; color:#475569;">
                         <span style="color:#64748b;">Milik Toko UMKM:</span>
                         <strong style="color:${isRejected ? '#991b1b' : '#166534'};">${umkmDetail}</strong>
                       </div>`
                    : '';

                const actionDesc = isRejected
                    ? (isProduct ? 'Produk telah ditolak dan tidak akan ditampilkan pada katalog produk UMKM.' : 'Pengajuan profil UMKM telah ditolak dengan catatan alasan perbaikan.')
                    : (isProduct ? 'Produk berhasil diverifikasi dan langsung tayang pada katalog produk publik.' : 'Pendaftaran profil UMKM telah resmi disetujui & aktif di sistem.');

                Swal.fire({
                    icon: isRejected ? 'error' : 'success',
                    title: isRejected ? 'Pengajuan Ditolak' : 'Berhasil Disetujui!',
                    html: `
                        <div style="text-align:center; padding: 4px 0;">
                            <div style="display:inline-flex; align-items:center; gap:6px; padding:4px 14px; border-radius:9999px; background:${badgeBg}; color:${badgeColor}; font-size:11px; font-weight:800; letter-spacing:0.5px; margin-bottom:12px;">
                                ${badgeLabel}
                            </div>
                            <div style="background:${cardBg}; border:1.5px solid ${cardBorder}; border-radius:18px; padding:16px 18px; box-shadow:0 1px 2px rgba(0,0,0,0.04);">
                                <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">
                                    ${isProduct ? (isRejected ? 'Nama Produk Ditolak' : 'Nama Produk Disetujui') : (isRejected ? 'Nama Toko UMKM Ditolak' : 'Nama Toko UMKM Disetujui')}
                                </div>
                                <div style="font-size:19px; font-weight:900; color:#0f172a; line-height:1.3; word-break:break-word;">
                                    "${itemName}"
                                </div>
                                ${subInfo}
                            </div>
                            <div style="font-size:13px; color:#64748b; margin-top:12px; line-height:1.5; font-weight:500;">
                                ${actionDesc}
                            </div>
                        </div>
                    `,
                    confirmButtonColor: confirmBtnColor,
                    confirmButtonText: 'Oke',
                    showConfirmButton: true,
                    allowOutsideClick: false,
                    allowEscapeKey: true,
                    customClass: {
                        popup: 'rounded-3xl shadow-2xl p-6 border-2 ' + (isRejected ? 'border-red-100' : 'border-emerald-100'),
                        title: (isRejected ? 'text-red-600' : 'text-emerald-700') + ' font-bold text-xl mb-1',
                        confirmButton: 'rounded-xl font-bold px-8 py-2.5 text-sm shadow-md text-white'
                    }
                });
                return;
            }

            // C. Pesan Umum Sukses / Gagal Lainnya
            if (isRejected) {
                Swal.fire({
                    icon: 'error',
                    title: 'Pemberitahuan',
                    html: `<div style="font-size: 14px; line-height: 1.6; color: #334155;">${rawMsg}</div>`,
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'Oke',
                    showConfirmButton: true,
                    allowOutsideClick: false,
                    allowEscapeKey: true,
                    customClass: {
                        popup: 'rounded-3xl shadow-2xl border-2 border-red-100 p-6',
                        title: 'text-red-600 font-bold text-xl mb-1',
                        confirmButton: 'rounded-xl font-bold px-8 py-2.5 text-sm shadow-md bg-red-600 hover:bg-red-700 text-white'
                    }
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    html: `<div style="font-size: 14px; line-height: 1.6; color: #334155;">${rawMsg}</div>`,
                    confirmButtonColor: '#059669',
                    confirmButtonText: 'Oke',
                    showConfirmButton: true,
                    allowOutsideClick: false,
                    allowEscapeKey: true,
                    customClass: {
                        popup: 'rounded-3xl shadow-2xl border-2 border-emerald-100 p-6',
                        title: 'text-emerald-700 font-bold text-xl mb-1',
                        confirmButton: 'rounded-xl font-bold px-8 py-2.5 text-sm shadow-md bg-emerald-600 hover:bg-emerald-700 text-white'
                    }
                });
            }
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Pemberitahuan',
                html: `<div style="font-size: 14px; line-height: 1.6; color: #334155;">{!! json_encode(session('error')) !!}</div>`,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Oke',
                showConfirmButton: true,
                allowOutsideClick: false,
                allowEscapeKey: true,
                customClass: {
                    popup: 'rounded-3xl shadow-2xl border-2 border-red-100 p-6',
                    title: 'text-red-600 font-bold text-xl mb-1',
                    confirmButton: 'rounded-xl font-bold px-8 py-2.5 text-sm shadow-md bg-red-600 hover:bg-red-700 text-white'
                }
            });
        });
    </script>
    @endif
    @stack('scripts')
</body>
</html>
