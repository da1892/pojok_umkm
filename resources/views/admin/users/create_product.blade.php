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

            <!-- Foto & Media Produk (5 Slot) -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-3 gap-2">
                    <label class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Foto & Media Produk <span class="text-red-500">*</span></span>
                    </label>
                    <span id="photo-counter" class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-full border border-slate-200 self-start sm:self-auto">
                        0 / 5 Foto dipilih
                    </span>
                </div>

                <p class="text-xs text-slate-500 leading-relaxed">
                    Unggah minimal 1 dan maksimal 5 foto produk. <strong>Foto pertama otomatis dijadikan foto sampul utama</strong> di katalog pembeli. Format: JPG, PNG, WEBP (maks. 10MB/foto).
                </p>

                <!-- Dropzone Area -->
                <div id="dropzone-area" class="border-2 border-dashed border-slate-300 hover:border-[#800000] rounded-2xl p-6 text-center transition-all bg-slate-50/70 hover:bg-red-50/20 cursor-pointer relative group">
                    <input id="images-input" name="images[]" type="file" multiple accept="image/jpeg,image/png,image/jpg,image/webp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="flex flex-col items-center pointer-events-none">
                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-2xs text-[#800000] group-hover:scale-110 flex items-center justify-center mb-2.5 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-800 group-hover:text-[#800000] transition-colors">Klik atau Seret Foto ke Sini</span>
                        <span class="text-xs text-slate-400 mt-1">Dapat memilih sekaligus hingga 5 foto produk</span>
                    </div>
                </div>

                <!-- 5 Slot Preview Grid -->
                <div id="preview-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3 pt-1">
                    @for($i = 0; $i < 5; $i++)
                    <div id="slot-{{ $i }}" class="relative aspect-square rounded-2xl border-2 {{ $i === 0 ? 'border-amber-300 bg-amber-50/30' : 'border-slate-200 bg-slate-50' }} flex flex-col items-center justify-center overflow-hidden transition-all group shadow-2xs">
                        <div class="slot-placeholder text-center p-2 text-slate-400 pointer-events-none">
                            <svg class="w-6 h-6 mx-auto mb-1 {{ $i === 0 ? 'text-amber-500/60' : 'text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path></svg>
                            <span class="text-[10px] font-bold block uppercase {{ $i === 0 ? 'text-amber-700' : 'text-slate-400' }}">
                                {{ $i === 0 ? 'Sampul Utama' : 'Foto ' . ($i + 1) }}
                            </span>
                        </div>
                        <img class="slot-image hidden w-full h-full object-cover" alt="Preview {{ $i + 1 }}">
                        <button type="button" onclick="removeImage({{ $i }})" class="slot-remove hidden absolute top-1.5 right-1.5 w-6 h-6 bg-red-600 text-white rounded-full items-center justify-center text-xs shadow-md hover:bg-red-700 transition-colors z-20 cursor-pointer" title="Hapus foto ini">
                            &times;
                        </button>
                        <span class="slot-badge hidden absolute bottom-1.5 left-1.5 px-2 py-0.5 rounded-md text-[9px] font-extrabold z-20 uppercase tracking-wider {{ $i === 0 ? 'bg-amber-500 text-white shadow-xs' : 'bg-slate-900/80 text-white' }}">
                            {{ $i === 0 ? 'Sampul' : 'Foto ' . ($i + 1) }}
                        </span>
                    </div>
                    @endfor
                </div>
                @error('images')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                @error('images.*')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
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

<script>
let uploadedFiles = [];
const imagesInput = document.getElementById('images-input');
const photoCounter = document.getElementById('photo-counter');

imagesInput.addEventListener('change', function(event) {
    const newFiles = Array.from(event.target.files);
    
    // Append new files up to limit of 5
    for (const file of newFiles) {
        if (uploadedFiles.length < 5) {
            uploadedFiles.push(file);
        }
    }
    
    updateFileInputAndPreview();
});

function updateFileInputAndPreview() {
    const dataTransfer = new DataTransfer();
    uploadedFiles.forEach(file => dataTransfer.items.add(file));
    imagesInput.files = dataTransfer.files;

    if (photoCounter) {
        photoCounter.textContent = `${uploadedFiles.length} / 5 Foto dipilih`;
    }

    // Update slots
    for (let i = 0; i < 5; i++) {
        const slot = document.getElementById(`slot-${i}`);
        if (!slot) continue;
        const placeholder = slot.querySelector('.slot-placeholder');
        const img = slot.querySelector('.slot-image');
        const removeBtn = slot.querySelector('.slot-remove');
        const badge = slot.querySelector('.slot-badge');

        if (uploadedFiles[i]) {
            img.src = URL.createObjectURL(uploadedFiles[i]);
            img.classList.remove('hidden');
            placeholder.classList.add('hidden');
            removeBtn.classList.remove('hidden');
            removeBtn.classList.add('flex');
            badge.classList.remove('hidden');
            slot.classList.remove('border-dashed');
            slot.classList.add('border-solid', 'border-[#800000]/40');
        } else {
            img.src = '';
            img.classList.add('hidden');
            placeholder.classList.remove('hidden');
            removeBtn.classList.add('hidden');
            removeBtn.classList.remove('flex');
            badge.classList.add('hidden');
            slot.classList.remove('border-solid', 'border-[#800000]/40');
        }
    }
}

function removeImage(index) {
    if (index >= 0 && index < uploadedFiles.length) {
        uploadedFiles.splice(index, 1);
        updateFileInputAndPreview();
    }
}
</script>
@endsection

