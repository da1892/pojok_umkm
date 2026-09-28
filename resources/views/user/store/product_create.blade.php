@extends('user.layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Tambah Produk Baru</h2>
            <a href="{{ route('toko.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center text-sm font-medium">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('toko.product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk <span class="text-red-500">*</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-[#801414] transition-colors bg-gray-50">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-[#801414] hover:text-red-900 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#801414] px-1">
                                    <span>Unggah file</span>
                                    <input id="file-upload" name="image" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg" required>
                                </label>
                                <p class="pl-1">atau tarik dan lepas</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, JPEG maks 2MB
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#801414] focus:ring-[#801414]" placeholder="Contoh: Keripik Singkong Balado">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Produk <span class="text-red-500">*</span></label>
                        <select name="category" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#801414] focus:ring-[#801414]">
                            <option value="">Pilih Kategori...</option>
                            <option value="Makanan & Minuman">Makanan & Minuman</option>
                            <option value="Kerajinan">Kerajinan</option>
                            <option value="Batik/Fashion">Batik/Fashion</option>
                            <option value="Olahan Hasil Pertanian">Olahan Hasil Pertanian</option>
                            <option value="Produk Kreatif">Produk Kreatif</option>
                            <option value="Lainnya">Produk Unggulan Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Opsional)</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="price" class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-[#801414] focus:ring-[#801414]" placeholder="0">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="5" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#801414] focus:ring-[#801414]" placeholder="Jelaskan detail produk Anda, bahan, keunggulan, dll..."></textarea>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="bg-[#801414] hover:bg-red-900 text-white font-bold py-2.5 px-6 rounded-lg transition-colors shadow flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
