@extends('layouts.admin')

@section('page_title', 'Edit Produk')

@section('content')
<div class="max-w-3xl bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-200 flex items-center justify-between">
        <div>
            <h3 class="font-bold text-slate-800 text-lg">Edit Data Produk</h3>
            <p class="text-slate-500 text-sm mt-1">Perbaiki nama, kategori, harga, atau deskripsi produk ini.</p>
        </div>
        <a href="{{ route('admin.products') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800">
            &larr; Kembali
        </a>
    </div>
    
    <div class="p-6">
        <form action="{{ route('admin.product.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000]" required>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Kategori</label>
                    <select name="category" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000]" required>
                        <option value="Makanan & Minuman" {{ (old('category', $product->category) == 'Makanan & Minuman' || old('category', $product->category) == 'makanan') ? 'selected' : '' }}>Makanan & Minuman</option>
                        <option value="Batik/Fashion" {{ (old('category', $product->category) == 'Batik/Fashion' || old('category', $product->category) == 'batik') ? 'selected' : '' }}>Batik/Fashion</option>
                        <option value="Kerajinan" {{ (old('category', $product->category) == 'Kerajinan' || old('category', $product->category) == 'kerajinan') ? 'selected' : '' }}>Kerajinan</option>
                        <option value="Olahan Hasil Pertanian" {{ (old('category', $product->category) == 'Olahan Hasil Pertanian' || old('category', $product->category) == 'pertanian') ? 'selected' : '' }}>Olahan Hasil Pertanian</option>
                        <option value="Produk Kreatif" {{ (old('category', $product->category) == 'Produk Kreatif' || old('category', $product->category) == 'kreatif') ? 'selected' : '' }}>Produk Kreatif</option>
                    </select>
                    @error('category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Harga (Opsional)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000]">
                    @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Deskripsi Produk</label>
                    <textarea name="description" rows="5" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000]">{{ old('description', $product->description) }}</textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div class="pt-4 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-[#800000] text-white font-bold rounded-lg hover:bg-red-900 transition-colors shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
