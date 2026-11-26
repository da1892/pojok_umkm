<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Tidak Ditemukan (404) - Pojok UMKM Wonogiri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 font-sans text-slate-800">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-8 text-center">
        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-red-50 text-[#800000] flex items-center justify-center border border-red-200/80 shadow-xs">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>

        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-red-100 text-[#800000] mb-2">
            Error 404 &bull; Halaman Tidak Ditemukan
        </span>

        <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-1">
            Halaman Tidak Tersedia
        </h1>

        <p class="text-slate-500 text-xs sm:text-sm mt-2 leading-relaxed">
            Halaman yang Anda tuju mungkin telah dipindahkan, dihapus, atau alamat URL yang Anda masukkan kurang tepat.
        </p>

        <div class="mt-6 flex flex-col gap-2.5">
            <a href="/" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-[#800000] to-[#991b1b] hover:from-[#660000] hover:to-[#800000] text-white font-bold text-xs sm:text-sm shadow-xs transition-all">
                Kembali ke Beranda
            </a>
            <a href="javascript:history.back()" class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs sm:text-sm transition-colors cursor-pointer">
                &larr; Halaman Sebelumnya
            </a>
        </div>
    </div>
</body>
</html>
