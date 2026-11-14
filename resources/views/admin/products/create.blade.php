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
            <div class="p-5 rounded-2xl bg-gradient-to-r from-red-50/70 via-amber-50/40 to-slate-50 border border-red-200/80 space-y-3.5">
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

                <!-- Input Hidden ID Toko yang dikirim saat submit form -->
                <input type="hidden" name="umkm_profile_id" id="selected_umkm_id" value="{{ old('umkm_profile_id', $selectedUmkmId ?? '') }}" required>

                <!-- Searchable Combobox Box -->
                <div class="relative" id="combobox_wrapper">
                    <!-- Search Input Box -->
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" 
                               id="umkm_search_input" 
                               autocomplete="off" 
                               placeholder="Ketik nama toko untuk mencari atau klik untuk memilih dari daftar..." 
                               class="w-full pl-10 pr-20 py-2.5 bg-white border border-slate-300 rounded-xl text-xs sm:text-sm font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-normal focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none transition-all shadow-2xs">
                        
                        <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center gap-1">
                            <button type="button" id="clear_selection_btn" class="hidden p-1 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-colors" title="Hapus pilihan">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                            <button type="button" id="toggle_dropdown_btn" class="p-1 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-colors" title="Buka daftar toko">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Dropdown List Options -->
                    <div id="umkm_dropdown_menu" class="hidden absolute left-0 right-0 top-full mt-1.5 max-h-64 overflow-y-auto bg-white rounded-2xl border border-slate-200 shadow-xl z-50 divide-y divide-slate-100">
                        <div id="no_store_found" class="hidden p-4 text-center text-xs text-slate-400">
                            Tidak ditemukan toko dengan kata kunci tersebut.
                        </div>
                        @foreach($allUmkms as $store)
                        <div class="umkm-option p-3 hover:bg-red-50/60 cursor-pointer transition-colors flex items-center justify-between gap-3"
                             data-id="{{ $store->id }}"
                             data-name="{{ $store->business_name }}"
                             data-owner="{{ $store->owner_name }}"
                             data-district="{{ $store->district ?: 'Wonogiri' }}"
                             data-village="{{ $store->village ?: '-' }}"
                             data-phone="{{ $store->phone ?: '-' }}">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-8 h-8 rounded-xl bg-red-100/70 text-[#800000] font-black text-xs flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($store->business_name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs sm:text-sm font-black text-slate-900 truncate">
                                        {{ $store->business_name }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 truncate flex items-center gap-1.5 mt-0.5">
                                        <span>Pemilik: <strong class="text-slate-700 font-semibold">{{ $store->owner_name }}</strong></span>
                                        <span>&bull;</span>
                                        <span>Kec. {{ $store->district ?: 'Wonogiri' }}{{ $store->village ? ', Ds. ' . $store->village : '' }}</span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-[#800000] bg-red-50 border border-red-200/80 px-2 py-0.5 rounded-md shrink-0">
                                Pilih
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kartu Informasi Toko Terpilih -->
                <div id="selected_store_card" class="hidden p-3.5 bg-white border border-emerald-300 rounded-2xl shadow-2xs flex items-center justify-between gap-3 transition-all">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center font-black text-sm shrink-0">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <h4 class="text-sm font-black text-slate-900 truncate" id="card_store_name">-</h4>
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    ✓ Toko Dipilih
                                </span>
                            </div>
                            <p class="text-xs text-slate-600 mt-0.5 truncate">
                                Pemilik: <strong class="text-slate-800" id="card_owner_name">-</strong> &bull; 
                                Wilayah: <span class="text-slate-700" id="card_location">-</span>
                            </p>
                        </div>
                    </div>
                    <button type="button" id="change_store_btn" class="px-3 py-1.5 text-xs font-bold text-slate-600 hover:text-red-700 hover:bg-red-50 border border-slate-200 rounded-xl transition-colors shrink-0">
                        Ganti Toko
                    </button>
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
                        <p class="text-[11px] text-slate-400">Informasi nama, kategori, dan deskripsi produk.</p>
                    </div>
                </div>

                <!-- Nama Produk -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Kacang Mete Rasa Madu Wijen 250gr" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none transition-all">
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
// Searchable Combobox Pemilihan Toko UMKM
(function() {
    const input = document.getElementById('umkm_search_input');
    const dropdown = document.getElementById('umkm_dropdown_menu');
    const hiddenId = document.getElementById('selected_umkm_id');
    const clearBtn = document.getElementById('clear_selection_btn');
    const toggleBtn = document.getElementById('toggle_dropdown_btn');
    const options = document.querySelectorAll('.umkm-option');
    const noFound = document.getElementById('no_store_found');
    const card = document.getElementById('selected_store_card');
    const cardName = document.getElementById('card_store_name');
    const cardOwner = document.getElementById('card_owner_name');
    const cardLocation = document.getElementById('card_location');
    const changeBtn = document.getElementById('change_store_btn');

    function openDropdown() {
        dropdown.classList.remove('hidden');
    }

    function closeDropdown() {
        dropdown.classList.add('hidden');
    }

    function selectStore(el) {
        const id = el.getAttribute('data-id');
        const name = el.getAttribute('data-name');
        const owner = el.getAttribute('data-owner');
        const district = el.getAttribute('data-district');
        const village = el.getAttribute('data-village');

        hiddenId.value = id;
        input.value = name; // HANYA NAMA TOKO YANG BERSIH!
        clearBtn.classList.remove('hidden');

        // Update Kartu Detail Toko Terpilih
        cardName.textContent = name;
        cardOwner.textContent = owner;
        cardLocation.textContent = 'Kec. ' + district + (village && village !== '-' ? ', Ds. ' + village : '');
        card.classList.remove('hidden');

        closeDropdown();
    }

    function clearSelection() {
        hiddenId.value = '';
        input.value = '';
        clearBtn.classList.add('hidden');
        card.classList.add('hidden');
        options.forEach(opt => opt.style.display = 'flex');
        if (noFound) noFound.classList.add('hidden');
    }

    // Filter pencarian live
    input.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        let matchCount = 0;
        options.forEach(opt => {
            const name = (opt.getAttribute('data-name') || '').toLowerCase();
            const owner = (opt.getAttribute('data-owner') || '').toLowerCase();
            const district = (opt.getAttribute('data-district') || '').toLowerCase();
            const village = (opt.getAttribute('data-village') || '').toLowerCase();

            if (name.includes(query) || owner.includes(query) || district.includes(query) || village.includes(query)) {
                opt.style.display = 'flex';
                matchCount++;
            } else {
                opt.style.display = 'none';
            }
        });

        if (noFound) {
            noFound.classList.toggle('hidden', matchCount > 0);
        }
        openDropdown();
    });

    input.addEventListener('focus', openDropdown);

    toggleBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (dropdown.classList.contains('hidden')) {
            openDropdown();
            input.focus();
        } else {
            closeDropdown();
        }
    });

    clearBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        clearSelection();
        input.focus();
    });

    if (changeBtn) {
        changeBtn.addEventListener('click', function() {
            clearSelection();
            input.focus();
            openDropdown();
        });
    }

    options.forEach(opt => {
        opt.addEventListener('click', function() {
            selectStore(this);
        });
    });

    // Tutup jika klik di luar dropdown
    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('combobox_wrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            closeDropdown();
        }
    });

    // Inisialisasi awal jika ada nilai terpilih (misal dari query atau old)
    const initialId = hiddenId.value;
    if (initialId) {
        const matched = Array.from(options).find(opt => opt.getAttribute('data-id') === initialId);
        if (matched) {
            selectStore(matched);
        }
    }
})();

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

