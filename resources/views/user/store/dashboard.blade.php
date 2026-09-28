@extends('user.layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-8 md:flex md:items-center md:justify-between border-b border-gray-100 bg-gradient-to-r from-red-50 to-white">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h2 class="text-3xl font-bold text-[#801414]">{{ $umkm->business_name }}</h2>
                        @if($umkm->status == 'verified')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Verified
                            </span>
                        @elseif($umkm->status == 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Menunggu Verifikasi
                            </span>
                        @endif
                    </div>
                    <p class="text-gray-500 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        {{ $umkm->owner_name }} &bull; {{ $umkm->phone }}
                    </p>
                </div>
                <div class="mt-4 md:mt-0 flex items-center gap-3">
                    <a href="{{ route('toko.consultations') }}" class="inline-flex items-center justify-center bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-semibold py-2.5 px-5 rounded-full transition-colors shadow-sm text-sm">
                        Riwayat Konsultasi
                    </a>
                    <a href="{{ route('toko.product.create') }}" class="inline-flex items-center justify-center bg-[#801414] hover:bg-red-900 text-white font-semibold py-2.5 px-5 rounded-full transition-colors shadow text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Produk Baru
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">Katalog Produk Anda</h3>
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 group flex flex-col">
                    <div class="relative h-48 overflow-hidden bg-gray-100">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        
                        <div class="absolute top-3 right-3">
                            @if($product->status == 'verified')
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-green-200 shadow-sm">Verified</span>
                            @elseif($product->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-yellow-200 shadow-sm">Pending</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-1 rounded-full border border-red-200 shadow-sm">Rejected</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="text-xs font-semibold text-[#eab308] uppercase tracking-wider mb-2">{{ $product->category }}</div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1">{{ $product->name }}</h4>
                        <p class="text-sm text-gray-500 line-clamp-2 mb-4 flex-1">{{ $product->description }}</p>
                        
                        @if($product->price)
                            <div class="font-bold text-[#801414] text-lg mb-4">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        @endif
                        
                        <div class="mt-auto border-t border-slate-100 pt-4 text-right">
                            <form action="{{ route('toko.product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold flex items-center justify-end gap-1 w-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus Produk
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada produk</h3>
                <p class="text-gray-500 mb-6">Anda belum menambahkan produk apapun ke etalase toko Anda.</p>
                <a href="{{ route('toko.product.create') }}" class="text-[#801414] font-semibold hover:underline">Tambah Produk Pertama Anda &rarr;</a>
            </div>
        @endif
    </div>
</div>
@endsection
