@extends('layouts.auth')

@section('content')
<div>
    <h2 class="text-3xl font-bold mb-2 text-gray-900">Daftar Akun Baru</h2>
    <p class="text-gray-600 mb-8">Bergabunglah dengan ekosistem UMKM Wonogiri.</p>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-600 border border-red-100">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/register" class="space-y-5">
        @csrf
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all"
                placeholder="Budi Santoso">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all"
                placeholder="nama@email.com">
        </div>

        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Daftar Sebagai</label>
            <select id="role" name="role" required
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all bg-white">
                <option value="user">Masyarakat Umum</option>
                <option value="umkm">Pemilik UMKM</option>
            </select>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" type="password" name="password" required
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all"
                placeholder="Minimal 8 karakter">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all"
                placeholder="Ulangi password">
        </div>

        <button type="submit"
            class="w-full bg-[#800000] text-white py-3 rounded-xl hover:bg-[#600000] transition-colors font-medium text-lg shadow-lg shadow-red-900/20 active:scale-[0.98] mt-2">
            Daftar
        </button>
    </form>

    <div class="mt-8 text-center text-sm text-gray-600">
        Sudah punya akun? 
        <a href="/login" class="text-[#800000] hover:underline font-medium">Masuk di sini</a>
    </div>
</div>
@endsection
