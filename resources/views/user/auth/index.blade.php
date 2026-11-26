<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autentikasi - Pojok UMKM Wonogiri</title>
    
    <!-- Memuat berkas CSS Tailwind dan Javascript dasar melalui Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google reCAPTCHA v2 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
        <!-- ==============================================================
             SEGMEN FORM PENDAFTARAN (REGISTER)
             ============================================================== -->
        <div class="form-container sign-up-container flex flex-col justify-center px-6 md:px-10 lg:px-12 py-8 bg-white overflow-y-auto">
            <div class="w-full max-w-sm mx-auto">
                <!-- Elemen logo khusus tampilan seluler -->
                <a href="/" class="flex items-center justify-center gap-2 text-xl font-bold text-[#800000] mb-6 md:hidden">
                    <img src="{{ asset('img/kukm_wonogiri.png') }}" class="w-8 h-8 object-contain" alt="Logo">
                    <span>Pojok UMKM</span>
                </a>
                
                <!-- Identitas form pendaftaran -->
                <div class="text-center mb-6">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">Daftar Akun Baru</h2>
                    <p class="text-slate-500 text-xs md:text-sm mt-1">Lengkapi data diri Anda untuk membuat akun</p>
                </div>

                <!-- Blok penanganan pesan kesalahan pada proses pendaftaran -->
                @if ($errors->any() && session('form') === 'register')
                    <div class="mb-4 p-3.5 rounded-xl bg-red-50 text-red-600 border border-red-100 text-xs leading-relaxed">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form utama pendaftaran -->
                <form method="POST" action="/register" class="space-y-3.5">
                    @csrf 
                    
                    <input type="hidden" name="form_type" value="register">
                    
                    <!-- Kolom pengisian nama lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#800000] focus:ring-4 focus:ring-red-500/10 outline-none transition text-sm text-slate-900 placeholder:text-slate-400 bg-white"
                            placeholder="Nama lengkap Anda">
                    </div>
                    
                    <!-- Kolom pengisian alamat surat elektronik (email) -->
                    <div>
                        <label for="email_reg" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <input id="email_reg" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#800000] focus:ring-4 focus:ring-red-500/10 outline-none transition text-sm text-slate-900 placeholder:text-slate-400 bg-white"
                            placeholder="nama@email.com">
                    </div>
                    
                    <!-- Kolom pengisian kata sandi -->
                    <div>
                        <label for="password_reg" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                        <div class="relative">
                            <input id="password_reg" type="password" name="password" required autocomplete="new-password"
                                class="w-full px-4 pr-11 py-2.5 rounded-xl border border-slate-300 focus:border-[#800000] focus:ring-4 focus:ring-red-500/10 outline-none transition text-sm text-slate-900 placeholder:text-slate-400 bg-white"
                                placeholder="Minimal 8 karakter">
                            <button type="button" onclick="togglePassword('password_reg', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Kolom konfirmasi kata sandi -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                class="w-full px-4 pr-11 py-2.5 rounded-xl border border-slate-300 focus:border-[#800000] focus:ring-4 focus:ring-red-500/10 outline-none transition text-sm text-slate-900 placeholder:text-slate-400 bg-white"
                                placeholder="Ulangi kata sandi">
                            <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- reCAPTCHA Pendaftaran -->
                    <div class="flex flex-col items-center justify-center pt-2">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') ?? env('RECAPTCHA_SITE_KEY') }}"></div>
                        @if ($errors->has('g-recaptcha-response') && session('form') === 'register')
                            <p class="text-xs text-red-600 mt-1 font-medium">{{ $errors->first('g-recaptcha-response') }}</p>
                        @endif
                    </div>

                    <!-- Tombol eksekusi pendaftaran -->
                    <button type="submit"
                        class="w-full bg-[#800000] hover:bg-[#680000] text-white py-3 px-4 rounded-xl font-bold shadow-md shadow-red-950/20 hover:shadow-lg transition-all duration-200 active:scale-[0.99] flex items-center justify-center gap-2 mt-4 cursor-pointer">
                        <span>Daftar Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>

                <!-- Tautan navigasi alternatif pada perangkat seluler -->
                <div class="mt-6 text-center text-xs md:text-sm text-slate-600 md:hidden">
                    Sudah punya akun? 
                    <a href="#" id="mobileToSignIn" class="text-[#800000] font-bold hover:underline">Masuk</a>
                </div>
            </div>
        </div>

        <!-- ==============================================================
             SEGMEN FORM AUTENTIKASI (LOGIN)
             ============================================================== -->
        <div class="form-container sign-in-container flex flex-col justify-center px-6 md:px-10 lg:px-12 py-8 bg-white overflow-y-auto">
            <div class="w-full max-w-sm mx-auto">
                <!-- Elemen logo khusus tampilan seluler -->
                <a href="/" class="flex items-center justify-center gap-2 text-xl font-bold text-[#800000] mb-6 md:hidden">
                    <img src="{{ asset('img/kukm_wonogiri.png') }}" class="w-8 h-8 object-contain" alt="Logo">
                    <span>Pojok UMKM</span>
                </a>

                <!-- Identitas form login -->
                <div class="text-center mb-6">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">Masuk Akun</h2>
                    <p class="text-slate-500 text-xs md:text-sm mt-1">Gunakan akun Anda untuk melanjutkan</p>
                </div>

                @if (session('success'))
                    <div class="mb-4 p-3.5 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs leading-relaxed flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Blok penanganan pesan kesalahan pada proses login -->
                @if ($errors->any() && (!session('form') || session('form') === 'login'))
                    <div class="mb-4 p-3.5 rounded-xl bg-red-50 text-red-600 border border-red-100 text-xs leading-relaxed">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form utama autentikasi -->
                <form method="POST" action="/login" class="space-y-4">
                    @csrf
                    
                    <input type="hidden" name="form_type" value="login">
                    
                    <!-- Kolom pengisian email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#800000] focus:ring-4 focus:ring-red-500/10 outline-none transition text-sm text-slate-900 placeholder:text-slate-400 bg-white"
                            placeholder="nama@email.com">
                    </div>

                    <!-- Kolom pengisian kata sandi -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">Kata Sandi</label>
                            <a href="{{ route('password.request') }}" onclick="openForgotPasswordModal(event)" class="text-xs text-[#800000] hover:underline font-medium cursor-pointer">Lupa Password?</a>
                        </div>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="w-full px-4 pr-11 py-2.5 rounded-xl border border-slate-300 focus:border-[#800000] focus:ring-4 focus:ring-red-500/10 outline-none transition text-sm text-slate-900 placeholder:text-slate-400 bg-white"
                                placeholder="Masukkan kata sandi">
                            <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Opsi kelola sesi -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-[#800000] border-slate-300 rounded focus:ring-[#800000]">
                        <label for="remember_me" class="ml-2 block text-xs font-medium text-slate-600">Ingat Saya</label>
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="flex flex-col items-center justify-center pt-1">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') ?? env('RECAPTCHA_SITE_KEY') }}"></div>
                        @if ($errors->has('g-recaptcha-response') && (!session('form') || session('form') === 'login'))
                            <p class="text-xs text-red-600 mt-1 font-medium">{{ $errors->first('g-recaptcha-response') }}</p>
                        @endif
                    </div>

                    <button type="submit"
                        class="w-full bg-[#800000] hover:bg-[#680000] text-white py-3 px-4 rounded-xl font-bold shadow-md shadow-red-950/20 hover:shadow-lg transition-all duration-200 active:scale-[0.99] flex items-center justify-center gap-2 mt-2 cursor-pointer">
                        <span>Masuk</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>

                <!-- Tautan navigasi alternatif pada perangkat seluler -->
                <div class="mt-6 text-center text-xs md:text-sm text-slate-600 md:hidden">
                    Belum punya akun? 
                    <a href="#" id="mobileToSignUp" class="text-[#800000] font-bold hover:underline">Daftar sekarang</a>
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
                
                <!-- Teks informasi sisi kiri overlay (saat form registrasi tampil) -->
                <div class="overlay-panel overlay-left">
                    <h1 class="text-3xl lg:text-4xl font-extrabold mb-3 leading-tight">Selamat Datang Kembali!</h1>
                    <p class="mb-8 text-sm lg:text-base opacity-90 font-normal leading-relaxed">Sudah memiliki akun? Masuk untuk melanjutkan aktivitas Anda di Pojok UMKM Wonogiri.</p>
                    
                    <button class="bg-transparent border-2 border-white text-white rounded-xl px-10 py-2.5 font-bold hover:bg-white hover:text-[#800000] transition-all duration-200 shadow-sm cursor-pointer" id="signInBtn">
                        Masuk Sekarang
                    </button>
                </div>
                
                <!-- Teks informasi sisi kanan overlay (saat form login tampil) -->
                <div class="overlay-panel overlay-right">
                    <a href="/" class="absolute top-8 left-8 text-white hover:text-red-200 transition-colors hidden lg:flex items-center gap-2 font-semibold text-sm">
                        <img src="{{ asset('img/kukm_wonogiri.png') }}" class="w-7 h-7 object-contain" alt="Logo">
                        <span>Beranda</span>
                    </a>
                    
                    <h1 class="text-3xl lg:text-4xl font-extrabold mb-3 leading-tight">Halo, Kawan UMKM!</h1>
                    <p class="mb-8 text-sm lg:text-base opacity-90 font-normal leading-relaxed">Belum memiliki akun? Daftarkan diri Anda dan mari kembangkan potensi UMKM Wonogiri bersama kami.</p>
                    
                    <button class="bg-transparent border-2 border-white text-white rounded-xl px-10 py-2.5 font-bold hover:bg-white hover:text-[#800000] transition-all duration-200 shadow-[0_0_15px_rgba(255,255,255,0.25)] cursor-pointer" id="signUpBtn">
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

        // Fungsi toggle kata sandi (lihat/sembunyikan)
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>`;
            } else {
                input.type = 'password';
                btn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>`;
            }
        }

        // Modal Lupa Kata Sandi
        function openForgotPasswordModal(e) {
            if (e) e.preventDefault();
            const modal = document.getElementById('forgotPasswordModal');
            if (modal) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    const emailInput = document.getElementById('modal_reset_email');
                    if (emailInput) {
                        const loginEmail = document.getElementById('email');
                        if (loginEmail && loginEmail.value) {
                            emailInput.value = loginEmail.value;
                        }
                        emailInput.focus();
                    }
                }, 100);
            }
        }

        function closeForgotPasswordModal() {
            const modal = document.getElementById('forgotPasswordModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        function handleBackdropClick(e) {
            if (e.target.id === 'forgotPasswordModal') {
                closeForgotPasswordModal();
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeForgotPasswordModal();
            }
        });

        @if(session('form') === 'forgot' || ($errors->has('email') && old('form_type') === 'forgot'))
            document.addEventListener('DOMContentLoaded', () => {
                openForgotPasswordModal();
            });
        @endif
    </script>

    <!-- Modal Lupa Kata Sandi -->
    <div id="forgotPasswordModal" class="fixed inset-0 flex items-center justify-center p-4 bg-slate-900/65 backdrop-blur-xs hidden transition-all duration-300" style="z-index: 99999;" onclick="handleBackdropClick(event)">
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all p-6 sm:p-7" style="z-index: 100000;" onclick="event.stopPropagation()">
            <!-- Close Button -->
            <button type="button" onclick="closeForgotPasswordModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-2 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer" title="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <!-- Icon & Header -->
            <div class="text-center mb-5">
                <div class="w-12 h-12 mx-auto mb-3 bg-red-50 text-[#800000] rounded-2xl flex items-center justify-center shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Lupa Kata Sandi?</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-xs mx-auto leading-relaxed">
                    Masukkan alamat email akun Anda untuk mengatur ulang kata sandi secara mandiri.
                </p>
            </div>

            @if ($errors->has('email') && session('form') === 'forgot')
                <div class="mb-4 p-3 rounded-xl bg-red-50 text-red-600 border border-red-100 text-xs leading-relaxed">
                    {{ $errors->first('email') }}
                </div>
            @endif

            <!-- Form Reset Mandiri -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="form_type" value="forgot">
                <div>
                    <label for="modal_reset_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email Terdaftar</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </span>
                        <input type="email" name="email" id="modal_reset_email" required value="{{ old('email') }}"
                            class="w-full pl-10 pr-4 py-2.5 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-red-500/10 outline-none transition-all placeholder:text-slate-400"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-3 px-4 bg-gradient-to-r from-[#800000] to-[#991b1b] hover:from-[#660000] hover:to-[#800000] text-white text-xs sm:text-sm font-bold rounded-xl shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <span>Lanjut Reset Kata Sandi</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-4 flex items-center justify-center">
                <div class="border-t border-slate-200 w-full"></div>
                <span class="bg-white px-2.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest absolute">atau bantuan dinas</span>
            </div>

            <!-- Helpdesk WhatsApp Button -->
            <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-2xl p-3.5 text-center">
                <p class="text-[11px] text-emerald-800 font-medium mb-2.5 leading-snug">
                    Lupa email atau butuh bantuan kurator dinas? Hubungi Helpdesk Resmi Pojok UMKM Wonogiri.
                </p>
                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin Helpdesk Pojok UMKM Wonogiri, saya ingin meminta bantuan pemulihan kata sandi akun saya.') }}"
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-3 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors cursor-pointer">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    <span>Hubungi Helpdesk via WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
    </script>
</body>
</html>
