<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pojok UMKM Wonogiri') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen flex">
        <!-- Left Side (Form) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                <div class="mb-10 text-center lg:text-left">
                    <a href="/" class="flex items-center justify-center lg:justify-start gap-2 text-2xl font-bold text-[#800000]">
                        <svg class="w-8 h-8 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Pojok UMKM
                    </a>
                </div>
                
                @yield('content')
            </div>
        </div>

        <!-- Right Side (Image/Branding) -->
        <div class="hidden lg:flex lg:w-1/2 bg-[#800000] text-white flex-col justify-center items-center p-12 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            
            <div class="relative z-10 max-w-lg text-center">
                <h1 class="text-4xl font-bold mb-6">Majukan UMKM Wonogiri, Jangkau Pasar Lebih Luas</h1>
                <p class="text-lg opacity-90 leading-relaxed">
                    Platform resmi direktori dan katalog produk Usaha Mikro, Kecil, dan Menengah (UMKM) Kabupaten Wonogiri. Temukan produk lokal berkualitas dan ajukan konsultasi pengembangan bisnis Anda.
                </p>
                
                <div class="mt-12 grid grid-cols-2 gap-6 text-left">
                    <div class="bg-white/10 backdrop-blur-sm p-4 rounded-xl border border-white/20">
                        <div class="font-bold text-xl mb-1">1000+</div>
                        <div class="text-sm opacity-80">UMKM Terdaftar</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm p-4 rounded-xl border border-white/20">
                        <div class="font-bold text-xl mb-1">Beragam</div>
                        <div class="text-sm opacity-80">Kategori Produk Lokal</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
