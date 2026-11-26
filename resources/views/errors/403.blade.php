<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses Dibatasi (403) - Pojok UMKM Wonogiri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 font-sans text-slate-800">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-8 text-center">
        <!-- Badge & Icon -->
        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-200/80 shadow-xs">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>

        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-red-100 text-[#800000] mb-2">
            Error 403 &bull; Akses Dibatasi
        </span>

        <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-1">
            Area Khusus Administrator
        </h1>

        <p class="text-slate-500 text-xs sm:text-sm mt-2 leading-relaxed">
            Halaman administrasi ini hanya dapat diakses oleh akun dengan peran <strong>Administrator Resmi</strong>.
        </p>

        @auth
            <div class="mt-4 p-3.5 rounded-2xl bg-slate-50 border border-slate-200/90 text-left text-xs space-y-1">
                <p class="text-slate-500 font-medium">Akun yang sedang aktif saat ini:</p>
                <p class="font-bold text-slate-900 truncate">&bull; {{ auth()->user()->name }} ({{ auth()->user()->email }})</p>
                <p class="text-slate-600 font-semibold">
                    &bull; Peran Akun: <span class="uppercase px-2 py-0.5 rounded-md text-[10px] font-black {{ auth()->user()->role === 'admin' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">{{ auth()->user()->role }}</span>
                </p>
            </div>
        @endauth

        <div class="mt-6 flex flex-col gap-2.5">
            @auth
                @if(auth()->user()->role === 'umkm')
                    <a href="{{ route('toko.index') }}" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-[#800000] to-[#991b1b] hover:from-[#660000] hover:to-[#800000] text-white font-bold text-xs sm:text-sm shadow-xs transition-all">
                        Kembali ke Dashboard Toko UMKM
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs sm:text-sm transition-colors cursor-pointer">
                        Keluar & Masuk Sebagai Admin
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-full py-3 px-4 rounded-xl bg-[#800000] hover:bg-red-800 text-white font-bold text-xs sm:text-sm shadow-xs transition-all">
                    Masuk Akun Admin
                </a>
            @endauth

            <a href="/" class="w-full py-2.5 px-4 rounded-xl text-slate-500 hover:text-slate-800 text-xs font-semibold transition-colors">
                &larr; Kembali ke Beranda Publik
            </a>
        </div>
    </div>
</body>
</html>
