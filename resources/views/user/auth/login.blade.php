@extends('layouts.auth')

@section('content')
<div>
    <h2 class="text-3xl font-bold mb-2 text-gray-900">Selamat Datang Kembali!</h2>
    <p class="text-gray-600 mb-8">Silakan masuk ke akun Anda untuk melanjutkan.</p>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-600 border border-red-100">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/login" class="space-y-6">
        @csrf
        
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all"
                placeholder="nama@email.com">
        </div>

        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <a href="#" class="text-sm text-[#800000] hover:underline font-medium">Lupa Password?</a>
            </div>
            <input id="password" type="password" name="password" required
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all"
                placeholder="••••••••">
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-[#800000] border-gray-300 rounded focus:ring-[#800000]">
            <label for="remember_me" class="ml-2 block text-sm text-gray-700">Ingat Saya</label>
        </div>

        <button type="submit"
            class="w-full bg-[#800000] text-white py-3 rounded-xl hover:bg-[#600000] transition-colors font-medium text-lg shadow-lg shadow-red-900/20 active:scale-[0.98]">
            Masuk
        </button>
    </form>

    <div class="mt-8 text-center text-sm text-gray-600">
        Belum punya akun? 
        <a href="/register" class="text-[#800000] hover:underline font-medium">Daftar sekarang</a>
    </div>
</div>
@endsection
