@extends('layouts.admin')

@section('page_title', 'Tambah Produk Binaan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Back button & Title -->
    <div>
        <a href="{{ route('admin.binaan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-[#800000] transition-colors mb-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Daftar Binaan</span>
        </a>
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Tambah Produk UMKM Binaan</h2>
        <p class="text-xs sm:text-sm text-slate-500">Unggah produk dari pelaku usaha binaan agar langsung tampil di etalase dan katalog publik.</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden p-6 sm:p-8">
        <form action="{{ route('admin.binaan.product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Pilih UMKM Binaan -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilih UMKM Binaan Pemilik Produk <span class="text-red-500">*</span></label>
                @if($binaanUmkms->isEmpty())
                    <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-center justify-between">
                        <span>Belum ada data UMKM Binaan terdaftar.</span>
                        <a href="{{ route('admin.binaan.umkm.create') }}" class="font-bold underline text-[#800000]">Daftarkan UMKM Terlebih Dahulu &rarr;</a>
                    </div>
                @else
                    <select name="umkm_profile_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                        <option value="">-- Pilih UMKM Binaan --</option>
                        @foreach($binaanUmkms as $u)
                            <option value="{{ $u->id }}" {{ (old('umkm_profile_id') == $u->id || $selectedUmkmId == $u->id) ? 'selected' : '' }}>
                                {{ $u->business_name }} (Pemilik: {{ $u->owner_name }} &bull; Kec. {{ $u->district }})
                            </option>
                        @endforeach
                    </select>
                @endif
                @error('umkm_profile_id')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
            </div>

            <!-- Nama & Kategori Produk -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Keripik Singkong Renyah Balado 200g" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                    @error('name')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Produk <span class="text-red-500">*</span></label>
                    <select name="category" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Makanan & Minuman" {{ old('category') == 'Makanan & Minuman' ? 'selected' : '' }}>Makanan & Minuman</option>
                        <option value="Olahan Hasil Pertanian" {{ old('category') == 'Olahan Hasil Pertanian' ? 'selected' : '' }}>Olahan Hasil Pertanian</option>
                        <option value="Kerajinan & Kesenian" {{ old('category') == 'Kerajinan & Kesenian' ? 'selected' : '' }}>Kerajinan & Kesenian</option>
                        <option value="Batik & Fashion" {{ old('category') == 'Batik & Fashion' ? 'selected' : '' }}>Batik & Fashion</option>
                        <option value="Herbal & Kesehatan" {{ old('category') == 'Herbal & Kesehatan' ? 'selected' : '' }}>Herbal & Kesehatan</option>
                        <option value="Jasa & Lainnya" {{ old('category') == 'Jasa & Lainnya' ? 'selected' : '' }}>Jasa & Lainnya</option>
                    </select>
                    @error('category')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Harga Produk -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Harga Produk (Rp) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-xs font-extrabold text-slate-400">Rp</span>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0" placeholder="Contoh: 15000" class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                </div>
                <p class="text-[10px] text-slate-400 mt-1">Masukkan angka bulat tanpa titik atau koma (misal 15000 untuk Rp 15.000).</p>
                @error('price')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
            </div>

            <!-- Upload Foto Produk -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Utama Produk <span class="text-red-500">*</span></label>
                    <input type="file" name="image" accept="image/*" required class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-[#800000] hover:file:bg-red-100 cursor-pointer border border-slate-200 rounded-xl bg-slate-50 p-1.5">
                    <p class="text-[10px] text-slate-400 mt-1">Disarankan foto terang dengan rasio 1:1 (persegi).</p>
                    @error('image')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Galeri Tambahan (Maks. 4 foto, Opsional)</label>
                    <input type="file" name="all_images[]" multiple accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer border border-slate-200 rounded-xl bg-slate-50 p-1.5">
                    <p class="text-[10px] text-slate-400 mt-1">Dapat memilih lebih dari 1 foto untuk sudut pandang berbeda.</p>
                </div>
            </div>

            <!-- Deskripsi Produk -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Produk <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required placeholder="Jelaskan keunggulan rasa, bahan baku khas Wonogiri, berat kemasan, daya simpan, atau cara pemesanan..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">{{ old('description') }}</textarea>
                @error('description')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
            </div>

            <!-- Opsi Jadikan Produk Unggulan (1 UMKM 1 Unggulan) -->
            <div class="bg-amber-50/70 border border-amber-200 rounded-xl p-4 flex items-start gap-3">
                <input type="checkbox" name="is_featured" value="1" id="is_featured_cb" class="mt-1 w-4 h-4 text-amber-600 rounded border-slate-300 focus:ring-amber-500 cursor-pointer">
                <label for="is_featured_cb" class="text-xs text-slate-800 cursor-pointer">
                    <span class="font-extrabold text-amber-950 block">⭐ Jadikan Produk Unggulan di Beranda Publik</span>
                    <span class="text-slate-600 text-[11px] block mt-0.5">
                        Sesuai aturan 1 UMKM = 1 Produk Unggulan, jika opsi ini dicentang dan UMKM ini sudah memiliki produk unggulan lain, maka produk lama akan digantikan oleh produk baru ini.
                    </span>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.binaan.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-[#800000] hover:bg-[#600000] transition-all shadow-md active:scale-95 cursor-pointer">
                    Simpan & Terbitkan Produk Binaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

