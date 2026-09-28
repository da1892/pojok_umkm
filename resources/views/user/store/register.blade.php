@extends('user.layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-[70vh] flex items-center justify-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center bg-white p-12 rounded-3xl shadow-sm border border-gray-100">
        <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-[#801414] mb-4">Mulai Berjualan di Pojok UMKM</h2>
        <p class="text-gray-600 mb-8 max-w-xl mx-auto leading-relaxed">Anda belum mendaftarkan toko UMKM Anda. Daftar sekarang untuk mempublikasikan produk unggulan Anda ke seluruh Kabupaten Wonogiri dan dapatkan fasilitas promosi gratis dari Dinas Perdagangan dan KUKM.</p>
        <a href="{{ route('toko.create') }}" class="bg-[#eab308] hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full transition-colors inline-block shadow hover:shadow-md">
            Buka Toko Sekarang
        </a>
    </div>
</div>
@endsection
