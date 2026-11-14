@extends('layouts.admin')

@section('page_title', 'Tambah Produk untuk UMKM: ' . $umkm->business_name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header Back & Title -->
    <div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-[#800000] transition-colors mb-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Manajemen User</span>
        </a>
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Tambah Produk Baru</h2>
        <p class="text-xs sm:text-sm text-slate-500">Produk yang diunggah oleh admin dinas akan langsung berstatus <strong>Terverifikasi</strong> dan tayang di katalog publik.</p>
    </div>

    <!-- Store Profile Summary Card -->
    <div class="bg-gradient-to-r from-red-50 to-amber-50 border border-red-200/80 rounded-2xl p-4 sm:p-5 flex items-center justify-between gap-4 shadow-xs">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-white border border-red-200/80 flex items-center justify-center font-bold text-[#800000] shadow-2xs shrink-0">
                <svg class="w-6 h-6 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <span class="text-[10px] font-bold text-[#800000] uppercase tracking-wider bg-red-100/80 px-2 py-0.5 rounded-md">Toko Pemilik</span>
                <h4 class="text-base font-black text-slate-900 leading-tight mt-0.5">{{ $umkm->business_name }}</h4>
                <p class="text-xs text-slate-600 mt-0.5">
                    Pemilik: <strong>{{ $umkm->owner_name }}</strong> • Kec. {{ $umkm->district }} @if($umkm->village) • Ds. {{ $umkm->village }} @endif
                </p>
            </div>
        </div>
        @if($umkm->user)
        <div class="hidden sm:block text-right">
            <span class="text-[11px] text-slate-500">Akun Login:</span>
            <p class="text-xs font-bold text-slate-800">{{ $umkm->user->email }}</p>
        </div>
        @endif
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-800 rounded-2xl p-4 text-xs sm:text-sm">
        <div class="font-bold mb-1">Terjadi kesalahan pada isian form:</div>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Container -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden p-6 sm:p-8">
        <form action="{{ route('admin.users.product.store', $umkm->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Nama Produk -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Keripik Singkong Rasa Balado 250gr" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none transition-all">
                @error('name')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
            </div>

            <!-- Kategori Produk -->
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

            <!-- Deskripsi Produk -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Produk (Bahan, Keunggulan, Varian)</label>
                <textarea name="description" rows="3" placeholder="Jelaskan keistimewaan rasa, bahan baku lokal, atau keunikan produk..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none transition-all">{{ old('description') }}</textarea>
                @error('description')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
            </div>

            <!-- Foto Utama -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Utama Produk</label>
                <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-[#800000] hover:file:bg-red-100 cursor-pointer border border-slate-200 rounded-xl bg-slate-50 p-2">
                <p class="text-[10px] text-slate-400 mt-1">Disarankan foto rasio 1:1 (persegi) dengan pencahayaan jelas. Maks 3MB.</p>
                @error('image')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
            </div>

            <!-- Foto Galeri Tambahan -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Galeri Tambahan (Opsional, Bisa Pilih Banyak)</label>
                <input type="file" name="images[]" multiple accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer border border-slate-200 rounded-xl bg-slate-50 p-2">
                <p class="text-[10px] text-slate-400 mt-1">Dapat memilih lebih dari 1 foto sekaligus untuk galeri produk.</p>
            </div>

            <!-- Produk Unggulan Checkbox -->
            <div class="bg-amber-50/70 border border-amber-200 rounded-2xl p-4 flex items-start gap-3">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 text-[#800000] border-slate-300 rounded focus:ring-red-500 mt-0.5 cursor-pointer">
                <label for="is_featured" class="text-xs text-amber-950 font-bold cursor-pointer">
                    Jadikan Produk Unggulan (Tampil di Halaman Beranda Publik)
                    <p class="text-[11px] font-normal text-amber-800 mt-0.5">Setiap UMKM maksimal dapat memiliki 2 produk unggulan di sistem.</p>
                </label>
            </div>

            <!-- Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 text-xs font-bold text-white bg-[#800000] hover:bg-[#600000] rounded-xl shadow-xs transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan & Tayangkan Produk</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

