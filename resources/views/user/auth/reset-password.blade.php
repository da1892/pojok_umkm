@extends('layouts.auth')

@section('content')
<div>
    <div class="mb-6">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-[#800000] transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Halaman Masuk</span>
        </a>
        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Atur Kata Sandi Baru</h2>
        <p class="text-slate-500 text-xs sm:text-sm mt-1.5 leading-relaxed">
            Buat kata sandi baru yang kuat dan mudah diingat untuk mengamankan akun Pojok UMKM Anda.
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
                <p class="font-bold mb-1">Terjadi Kesalahan:</p>
                <ul class="list-disc list-inside space-y-0.5 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Alamat Email Akun
            </label>
            <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required readonly
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-slate-600 bg-slate-100 font-medium text-sm outline-none cursor-not-allowed">
        </div>

        <div>
            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Kata Sandi Baru (Minimal 8 Karakter)
            </label>
            <div class="relative">
                <input id="password" type="password" name="password" required autofocus autocomplete="new-password"
                    class="w-full px-4 pr-11 py-2.5 rounded-xl border border-slate-300 text-slate-900 bg-white placeholder:text-slate-400 focus:ring-4 focus:ring-red-500/10 focus:border-[#800000] outline-none transition-all text-sm shadow-xs"
                    placeholder="Masukkan kata sandi baru">
                <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </button>
            </div>
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Ulangi Kata Sandi Baru
            </label>
            <div class="relative">
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="w-full px-4 pr-11 py-2.5 rounded-xl border border-slate-300 text-slate-900 bg-white placeholder:text-slate-400 focus:ring-4 focus:ring-red-500/10 focus:border-[#800000] outline-none transition-all text-sm shadow-xs"
                    placeholder="Ulangi kata sandi baru">
                <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </button>
            </div>
        </div>

        <button type="submit"
            class="w-full bg-gradient-to-r from-[#800000] to-[#991b1b] hover:from-[#660000] hover:to-[#800000] text-white py-3.5 rounded-xl font-bold text-sm shadow-sm hover:shadow-md transition-all active:scale-[0.99] flex items-center justify-center gap-2 cursor-pointer mt-2">
            <span>Simpan Kata Sandi Baru</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </button>
    </form>
</div>

<script>
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>`;
    } else {
        input.type = 'password';
        btn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>`;
    }
}
</script>
@endsection
