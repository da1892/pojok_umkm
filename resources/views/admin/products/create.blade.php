@extends('layouts.admin')

@section('page_title', 'Tambah Produk UMKM Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Back & Title -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.products') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-[#800000] transition-colors mb-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Kelola Produk</span>
            </a>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Tambah Produk UMKM Baru</h2>
            <p class="text-xs sm:text-sm text-slate-500">Admin dinas dapat menambahkan produk untuk UMKM terdaftar yang membutuhkan bantuan digitalisasi. Produk yang ditambahkan langsung berstatus <strong>Disetujui</strong> (aktif di katalog).</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 text-xs sm:text-sm flex items-start gap-3 shadow-xs">
        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div class="flex-1 font-semibold leading-relaxed">
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-800 rounded-2xl p-4 text-xs sm:text-sm shadow-xs">
        <div class="font-bold mb-1 flex items-center gap-1.5 text-red-900">
            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Mohon periksa beberapa isian berikut:</span>
        </div>
        <ul class="list-disc list-inside space-y-0.5 text-red-700">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Container -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden p-6 sm:p-8">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- ============================================== -->
            <!-- 1. PILIH TOKO UMKM PEMILIK PRODUK -->
            <!-- ============================================== -->
            <div class="p-5 rounded-2xl bg-gradient-to-r from-red-50/70 via-amber-50/40 to-slate-50 border border-red-200/80 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <label class="block text-xs font-black text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Pilih Toko UMKM Pemilik Produk <span class="text-red-500">*</span></span>
                    </label>
                    <a href="{{ route('admin.users.create') }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-[#800000] hover:text-red-800 transition-colors">
                        <span>+ Belum Ada di Daftar? Buat Akun UMKM Baru</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>

                <div class="relative">
                    <select name="umkm_profile_id" id="umkm_select" required class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none transition-all cursor-pointer shadow-2xs">
                        <option value="">-- Pilih Toko UMKM Pemilik Produk --</option>
                        @foreach($allUmkms as $store)
                        <option value="{{ $store->id }}" 
                                data-owner="{{ $store->owner_name }}" 
                                data-district="{{ $store->district }}" 
                                data-village="{{ $store->village }}"
                                {{ (old('umkm_profile_id') == $store->id || (string)$selectedUmkmId === (string)$store->id) ? 'selected' : '' }}>
                            {{ $store->business_name }} (Pemilik: {{ $store->owner_name }} — Kec. {{ $store->district ?: 'Wonogiri' }}{{ $store->village ? ', Ds. ' . $store->village : '' }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <p class="text-[11px] text-slate-500">Pilih salah satu toko UMKM terdaftar yang memproduksi atau menjual produk ini.</p>
                @error('umkm_profile_id')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
            </div>

            <!-- ============================================== -->
            <!-- 2. INFORMASI PRODUK -->
            <!-- ============================================== -->
            <div class="space-y-4">
                <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                    <span class="w-7 h-7 rounded-xl bg-red-100 text-[#800000] font-black flex items-center justify-center text-xs">1</span>
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Detail Produk</h3>
                        <p class="text-[11px] text-slate-400">Informasi nama, kategori, harga, dan deskripsi produk.</p>
                    </div>
                </div>

                <!-- Nama Produk -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Kacang Mete Rasa Madu Wijen 250gr" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none transition-all">
                    @error('name')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                </div>

                <!-- Kategori & Harga -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Produk <span class="text-red-500">*</span></label>
                        <select name="category" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none cursor-pointer">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($standardCategories as $cat)
                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Harga Produk (Rp) <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2.5 text-xs font-bold text-slate-400">Rp</span>
                            <input type="number" name="price" value="{{ old('price') }}" min="0" step="500" placeholder="Contoh: 35000 (Kosongkan bila sistem negosiasi)" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none transition-all">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Bila dikosongkan atau diisi 0, pada katalog publik akan tertulis tombol <em>"Detail"</em> atau <em>"Siap Dipesan"</em> tanpa angka 0.</p>
                        @error('price')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Deskripsi Produk -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Produk (Keunggulan, Bahan Baku, Varian)</label>
                    <textarea name="description" rows="3" placeholder="Jelaskan keistimewaan rasa, bahan baku khas lokal Wonogiri, proses pengolahan, atau cara penyajian..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none transition-all">{{ old('description') }}</textarea>
                    @error('description')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- ============================================== -->
            <!-- 3. FOTO PRODUK -->
            <!-- ============================================== -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                    <span class="w-7 h-7 rounded-xl bg-red-100 text-[#800000] font-black flex items-center justify-center text-xs">2</span>
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Foto & Media Produk</h3>
                        <p class="text-[11px] text-slate-400">Unggah foto produk yang jelas dan menarik untuk katalog.</p>
                    </div>
                </div>

                <!-- Foto Utama -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Utama Produk</label>
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden shrink-0" id="main_preview_container">
                            <img id="main_preview_img" class="w-full h-full object-cover hidden" alt="Preview Foto">
                            <svg id="main_preview_placeholder" class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="image" id="main_image_input" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-[#800000] hover:file:bg-red-100 cursor-pointer border border-slate-200 rounded-xl bg-slate-50 p-2">
                            <p class="text-[10px] text-slate-400 mt-1">Disarankan foto rasio 1:1 (persegi) dengan pencahayaan terang. Maksimal 3MB (JPEG, PNG, WEBP).</p>
                        </div>
                    </div>
                    @error('image')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                </div>

                <!-- Foto Galeri Tambahan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Galeri Tambahan (Dapat memilih lebih dari 1 foto)</label>
                    <input type="file" name="images[]" multiple accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer border border-slate-200 rounded-xl bg-slate-50 p-2">
                    <p class="text-[10px] text-slate-400 mt-1">Opsional: Tambahkan foto sudut lain, kemasan, atau detail sertifikasi halal.</p>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- 4. PRODUK UNGGULAN -->
            <!-- ============================================== -->
            <div class="pt-4 border-t border-slate-100">
                <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200/80 flex items-start gap-3">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 text-amber-600 rounded border-amber-300 focus:ring-amber-500 mt-0.5 cursor-pointer">
                    <label for="is_featured" class="text-xs text-amber-950 font-semibold cursor-pointer">
                        <span class="font-bold flex items-center gap-1 text-amber-900">
                            <svg class="w-3.5 h-3.5 text-amber-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Tandai Sebagai "Produk Unggulan"
                        </span>
                        Produk ini akan ditampilkan pada carousel/section khusus <strong>Produk Unggulan</strong> di halaman depan website Pojok UMKM Wonogiri (Maksimal 2 produk unggulan per toko UMKM).
                    </label>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- 5. TOMBOL AKSI SUBMIT -->
            <!-- ============================================== -->
            <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                <a href="{{ route('admin.products') }}" class="w-full sm:w-auto px-5 py-2.5 text-xs font-bold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors text-center cursor-pointer">
                    Batal
                </a>

                <div class="flex flex-col sm:flex-row items-center gap-2.5 w-full sm:w-auto">
                    <!-- Tombol Simpan & Tambah Lagi -->
                    <button type="submit" name="action" value="save_and_add_another" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2.5 text-xs font-bold text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-300 rounded-xl transition-all shadow-2xs hover:shadow-xs cursor-pointer">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Simpan & Tambah Produk Lain</span>
                    </button>

                    <!-- Tombol Simpan & Selesai -->
                    <button type="submit" name="action" value="save" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-xs font-bold text-white bg-gradient-to-r from-[#800000] to-[#991b1b] hover:from-[#660000] hover:to-[#800000] rounded-xl shadow-xs hover:shadow-md transition-all cursor-pointer">
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan & Tayangkan Produk</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Preview Foto Utama
document.getElementById('main_image_input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(evt) {
            const img = document.getElementById('main_preview_img');
            const placeholder = document.getElementById('main_preview_placeholder');
            img.src = evt.target.result;
            img.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
