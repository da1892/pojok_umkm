@extends('layouts.auth')

@section('content')
<div>
    <div class="mb-6">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-[#800000] transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Halaman Masuk</span>
        </a>
        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Lupa Kata Sandi?</h2>
        <p class="text-slate-500 text-xs sm:text-sm mt-1.5 leading-relaxed">
            Masukkan alamat email yang terdaftar pada akun Anda. Sistem akan memverifikasi identitas Anda untuk melanjutkan pembuatan kata sandi baru.
        </p>
    </div>

    @if (session('status'))
        <div class="mb-5 p-4 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200/90 text-xs sm:text-sm flex items-start gap-2.5">
            <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="leading-relaxed font-medium">{{ session('status') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 p-4 rounded-xl bg-red-50 text-red-700 border border-red-200/90 text-xs sm:text-sm flex items-start gap-2.5">
            <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="font-bold mb-1">Gagal Memproses Permintaan:</p>
                <ul class="list-disc list-inside space-y-0.5 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Alamat Email Akun
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 text-slate-900 bg-white placeholder:text-slate-400 focus:ring-4 focus:ring-red-500/10 focus:border-[#800000] outline-none transition-all text-sm shadow-xs"
                    placeholder="nama@email.com">
            </div>
        </div>

        <button type="submit"
            class="w-full bg-gradient-to-r from-[#800000] to-[#991b1b] hover:from-[#660000] hover:to-[#800000] text-white py-3.5 rounded-xl font-bold text-sm shadow-sm hover:shadow-md transition-all active:scale-[0.99] flex items-center justify-center gap-2 cursor-pointer">
            <span>Lanjut Reset Kata Sandi</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </button>
    </form>

    <!-- Bantuan Helpdesk Alternatif -->
    <div class="mt-8 pt-6 border-t border-slate-200">
        <div class="bg-emerald-50/70 border border-emerald-200/90 rounded-2xl p-4 sm:p-5">
            <div class="flex items-start gap-3">
                <span class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                </span>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-emerald-950">Butuh Bantuan Langsung?</h4>
                    <p class="text-[11px] sm:text-xs text-emerald-800 mt-0.5 leading-relaxed">
                        Jika Anda lupa email atau nomor ponsel sudah berganti, tim kurasi dan admin Pojok UMKM Wonogiri siap membantu memulihkan akun Anda secara langsung.
                    </p>
                </div>
            </div>

            <div class="mt-3.5 flex flex-col sm:flex-row gap-2.5">
                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin Pojok UMKM Wonogiri, saya ingin meminta bantuan pemulihan kata sandi akun saya.') }}"
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-xs cursor-pointer">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    <span>Chat WhatsApp Helpdesk Dinas</span>
                </a>
                <a href="{{ route('konsultasi') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 rounded-xl text-xs font-bold transition-all cursor-pointer">
                    <span>Tiket Konsultasi Online</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
