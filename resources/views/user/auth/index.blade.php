<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autentikasi - Pojok UMKM Wonogiri</title>
    
    <!-- Memuat berkas CSS Tailwind dan Javascript dasar melalui Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* ==============================================================
           CSS UNTUK ANIMASI SLIDING PANEL
           Pengaturan dimensi dan gaya visual pembungkus utama form
           ============================================================== */
        
        /* Kontainer utama pembungkus antarmuka login dan register */
        .container-auth {
            position: relative;
            width: 100%;
            max-width: 1000px;
            min-height: 650px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(128, 0, 0, 0.15);
            overflow: hidden;
        }

        /* Kontainer untuk masing-masing blok form */
        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        /* 1. SEGMEN FORM LOGIN */
        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        /* Modifikasi transisi form login saat panel bergeser */
        .container-auth.right-panel-active .sign-in-container {
            transform: translateX(100%);
            opacity: 0;
        }

        /* 2. SEGMEN FORM REGISTER */
        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        /* Modifikasi transisi form register saat panel bergeser */
        .container-auth.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }

        /* Definisi keyframe untuk memunculkan form secara gradual */
        @keyframes show {
            0%, 49.99% { opacity: 0; z-index: 1; }
            50%, 100% { opacity: 1; z-index: 5; }
        }

        /* ==============================================================
           CSS UNTUK PANEL OVERLAY
           ============================================================== */
        
        /* Kontainer untuk panel overlay penutup */
        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        /* Pergeseran posisi panel penutup */
        .container-auth.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }

        /* Visualisasi warna gradasi pada panel penutup */
        .overlay {
            background: #800000;
            background: linear-gradient(135deg, #800000, #a80000); 
            color: #ffffff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        /* Penyesuaian konten di dalam overlay saat panel bergeser */
        .container-auth.right-panel-active .overlay {
            transform: translateX(50%);
        }

        /* Layout konten informatif dalam panel overlay */
        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        /* Posisi teks bagian kiri */
        .overlay-left {
            transform: translateX(-20%);
        }
        .container-auth.right-panel-active .overlay-left {
            transform: translateX(0);
        }

        /* Posisi teks bagian kanan */
        .overlay-right {
            right: 0;
            transform: translateX(0);
        }
        .container-auth.right-panel-active .overlay-right {
            transform: translateX(20%);
        }

        /* ==============================================================
           PENYESUAIAN TAMPILAN RESPONSIVE (MOBILE)
           ============================================================== */
        @media (max-width: 768px) {
            .container-auth {
                min-height: 100vh;
                border-radius: 0;
                display: flex;
                flex-direction: column;
            }
            .form-container {
                position: relative;
                width: 100%;
                min-height: 100vh;
                left: 0 !important;
                transform: none !important;
                opacity: 1 !important;
                z-index: 1 !important;
                animation: none !important;
                padding: 2rem !important;
            }
            .sign-in-container { display: flex; }
            .container-auth.right-panel-active .sign-in-container { display: none; }
            .sign-up-container { display: none; opacity: 1; }
            .container-auth.right-panel-active .sign-up-container { display: flex; }
            .overlay-container { display: none; }
        }
    </style>
</head>

<body class="bg-red-50 flex items-center justify-center min-h-screen p-0 md:p-4 font-sans antialiased">
    
    <!-- Elemen pembungkus antarmuka dengan kondisi kelas aktif berdasarkan variabel controller -->
    <div class="container-auth {{ $isRegister ? 'right-panel-active' : '' }}" id="container">
        
        <!-- ==============================================================
             SEGMEN FORM PENDAFTARAN (REGISTER)
             ============================================================== -->
        <div class="form-container sign-up-container flex flex-col justify-center md:px-12 bg-white">
            <div class="w-full">
                <!-- Elemen logo khusus tampilan seluler -->
                <a href="/" class="flex items-center justify-center gap-2 text-xl font-bold text-[#800000] mb-8 md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Pojok UMKM
                </a>
                
                <!-- Identitas form pendaftaran -->
                <h2 class="text-3xl font-bold mb-2 text-gray-900 text-center">Buat Akun Baru</h2>
                <p class="text-gray-600 mb-6 text-center">Daftarkan bisnis Anda di UMKM Wonogiri</p>

                <!-- Blok penanganan pesan kesalahan pada proses pendaftaran -->
                @if ($errors->any() && session('form') === 'register')
                    <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 border border-red-100 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form utama pendaftaran -->
                <form method="POST" action="/register" class="space-y-4">
                    @csrf 
                    
                    <!-- Variabel identifikasi jenis form yang dikirimkan -->
                    <input type="hidden" name="form_type" value="register">
                    
                    <!-- Kolom pengisian nama lengkap -->
                    <div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all bg-gray-50 focus:bg-white"
                            placeholder="Nama Lengkap">
                    </div>
                    
                    <!-- Kolom pengisian alamat surat elektronik (email) -->
                    <div>
                        <input id="email_reg" type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all bg-gray-50 focus:bg-white"
                            placeholder="Email">
                    </div>
                    
                    <!-- Kolom pemilihan peran (role) pengguna -->
                    <div>
                        <select id="role" name="role" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all bg-gray-50 focus:bg-white text-gray-600">
                            <option value="" disabled selected>Daftar Sebagai...</option>
                            <option value="user">Masyarakat Umum</option>
                            <option value="umkm">Pemilik UMKM</option>
                        </select>
                    </div>
                    
                    <!-- Kolom pengisian kata sandi dan konfirmasi -->
                    <div class="grid grid-cols-2 gap-4">
                        <input id="password_reg" type="password" name="password" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all bg-gray-50 focus:bg-white"
                            placeholder="Password">
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all bg-gray-50 focus:bg-white"
                            placeholder="Konfirmasi">
                    </div>

                    <!-- Tombol eksekusi pendaftaran -->
                    <button type="submit"
                        class="w-full bg-[#800000] text-white py-3 rounded-xl hover:bg-[#600000] transition-colors font-bold shadow-lg mt-2">
                        Daftar
                    </button>
                </form>

                <!-- Tautan navigasi alternatif pada perangkat seluler -->
                <div class="mt-6 text-center text-sm text-gray-600 md:hidden">
                    Sudah punya akun? 
                    <a href="#" id="mobileToSignIn" class="text-[#800000] font-bold">Masuk</a>
                </div>
            </div>
        </div>

        <!-- ==============================================================
             SEGMEN FORM AUTENTIKASI (LOGIN)
             ============================================================== -->
        <div class="form-container sign-in-container flex flex-col justify-center md:px-12 bg-white">
            <div class="w-full">
                <!-- Elemen logo khusus tampilan seluler -->
                <a href="/" class="flex items-center justify-center gap-2 text-2xl font-bold text-[#800000] mb-10 md:hidden">
                    <img src="{{ asset('img/kukm_wonogiri.png') }}" class="w-8 h-8" alt="Logo">
                    Pojok UMKM
                </a>

                <!-- Identitas form login -->
                <h2 class="text-3xl font-bold mb-2 text-gray-900 text-center">Masuk Akun</h2>
                <p class="text-gray-600 mb-8 text-center">Gunakan email Anda untuk login</p>

                <!-- Blok penanganan pesan kesalahan pada proses login -->
                @if ($errors->any() && (!session('form') || session('form') === 'login'))
                    <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-600 border border-red-100 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form utama autentikasi -->
                <form method="POST" action="/login" class="space-y-5">
                    @csrf
                    
                    <!-- Variabel identifikasi jenis form yang dikirimkan -->
                    <input type="hidden" name="form_type" value="login">
                    
                    <!-- Kolom pengisian alamat surat elektronik (email) -->
                    <div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all bg-gray-50 focus:bg-white"
                            placeholder="Email">
                    </div>

                    <!-- Kolom pengisian kata sandi -->
                    <div>
                        <input id="password" type="password" name="password" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all bg-gray-50 focus:bg-white"
                            placeholder="Password">
                    </div>
                    
                    <!-- Opsi kelola sesi dan reset kata sandi -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-[#800000] border-gray-300 rounded focus:ring-[#800000]">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700">Ingat Saya</label>
                        </div>
                        <a href="#" class="text-sm text-[#800000] font-medium hover:underline">Lupa Password?</a>
                    </div>

                    <!-- Tombol eksekusi login -->
                    <button type="submit"
                        class="w-full bg-[#800000] text-white py-3 rounded-xl hover:bg-[#600000] transition-colors font-bold shadow-lg mt-4">
                        Masuk
                    </button>
                </form>

                <!-- Tautan navigasi alternatif pada perangkat seluler -->
                <div class="mt-8 text-center text-sm text-gray-600 md:hidden">
                    Belum punya akun? 
                    <a href="#" id="mobileToSignUp" class="text-[#800000] font-bold">Daftar sekarang</a>
                </div>
            </div>
        </div>

        <!-- ==============================================================
             PANEL OVERLAY TRANSISI
             ============================================================== -->
        <div class="overlay-container hidden md:block pointer-events-none">
            <div class="overlay pointer-events-auto shadow-2xl relative">
                
                <!-- Latar belakang pola geometris pada overlay -->
                <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                
                <!-- Teks informasi sisi kiri overlay -->
                <div class="overlay-panel overlay-left">
                    <h1 class="text-4xl font-extrabold mb-4 leading-tight">Selamat Datang Kembali!</h1>
                    <p class="mb-8 text-lg opacity-90 font-medium">Tetap terhubung dan kelola bisnis UMKM Anda dengan mudah.</p>
                    
                    <!-- Tombol interaktif untuk memicu transisi ke form login -->
                    <button class="bg-transparent border-2 border-white text-white rounded-full px-12 py-3 font-bold hover:bg-white hover:text-[#800000] transition-colors" id="signInBtn">
                        Masuk Sekarang
                    </button>
                </div>
                
                <!-- Teks informasi sisi kanan overlay -->
                <div class="overlay-panel overlay-right">
                    
                    <!-- Tautan kembali ke halaman utama -->
                    <a href="/" class="absolute top-8 left-8 text-white hover:text-red-200 transition-colors hidden lg:flex items-center gap-2">
                        <img src="{{ asset('img/kukm_wonogiri.png') }}" class="w-8 h-8" alt="Logo">
                        Beranda
                    </a>
                    
                    <h1 class="text-4xl font-extrabold mb-4 leading-tight">Halo, Kawan UMKM!</h1>
                    <p class="mb-8 text-lg opacity-90 font-medium">Bergabunglah dan kembangkan pasar bisnis lokal Wonogiri bersama kami.</p>
                    
                    <!-- Tombol interaktif untuk memicu transisi ke form registrasi -->
                    <button class="bg-transparent border-2 border-white text-white rounded-full px-12 py-3 font-bold hover:bg-white hover:text-[#800000] transition-colors shadow-[0_0_15px_rgba(255,255,255,0.3)]" id="signUpBtn">
                        Daftar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ==============================================================
         PENGENDALIAN ANIMASI ANTARMUKA (JAVASCRIPT)
         ============================================================== -->
    <script>
        // Inisialisasi elemen DOM
        const signUpButton = document.getElementById('signUpBtn');
        const signInButton = document.getElementById('signInBtn');
        const container = document.getElementById('container');
        
        const mobileToSignUp = document.getElementById('mobileToSignUp');
        const mobileToSignIn = document.getElementById('mobileToSignIn');

        // Pengecekan keberadaan pesan kesalahan pada saat pendaftaran
        // Jika variabel bernilai true, panel transisi akan ditahan pada sisi kiri
        const isRegisterErrors = {{ ($errors->any() && session('form') === 'register') ? 'true' : 'false' }};
        if(isRegisterErrors) {
            container.classList.add("right-panel-active");
        }

        // Penanganan kegiatan klik pada tombol pendaftaran
        if(signUpButton) {
            signUpButton.addEventListener('click', () => {
                container.classList.add("right-panel-active");
                window.history.pushState({}, '', '/register');
            });
        }

        // Penanganan kegiatan klik pada tombol otentikasi
        if(signInButton) {
            signInButton.addEventListener('click', () => {
                container.classList.remove("right-panel-active");
                window.history.pushState({}, '', '/login');
            });
        }
        
        // Penanganan navigasi pada perangkat layar berukuran kecil
        if(mobileToSignUp) {
            mobileToSignUp.addEventListener('click', (e) => {
                e.preventDefault();
                container.classList.add("right-panel-active");
                window.history.pushState({}, '', '/register');
            });
        }
        
        if(mobileToSignIn) {
            mobileToSignIn.addEventListener('click', (e) => {
                e.preventDefault();
                container.classList.remove("right-panel-active");
                window.history.pushState({}, '', '/login');
            });
        }
    </script>
</body>
</html>
