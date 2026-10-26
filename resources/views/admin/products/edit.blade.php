@extends('layouts.admin')

@section('page_title', 'Edit Produk')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Breadcrumb & Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white/70 backdrop-blur-sm p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('admin.products') }}" class="hover:text-[#800000] font-medium transition-colors">Kelola Produk</a>
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="font-bold text-slate-800 truncate max-w-xs">{{ $product->name }}</span>
            @php
                $statusInfo = match(strtolower($product->status ?? 'active')) {
                    'verified', 'active' => [
                        'label' => 'Disetujui',
                        'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'
                    ],
                    'pending' => [
                        'label' => 'Menunggu Persetujuan',
                        'class' => 'bg-amber-50 text-amber-700 border-amber-200'
                    ],
                    'rejected' => [
                        'label' => 'Ditolak',
                        'class' => 'bg-red-50 text-red-700 border-red-200'
                    ],
                    default => [
                        'label' => 'Disetujui',
                        'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'
                    ]
                };
            @endphp
            <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full border {{ $statusInfo['class'] }}">
                {{ $statusInfo['label'] }}
            </span>
        </div>
        <a href="{{ route('admin.products') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-50 rounded-xl border border-slate-200 shadow-2xs transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

    <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Column: Media & Visual Assets (5 cols) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 space-y-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-slate-800 text-base flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#800000]"></span>
                                Galeri & Foto Produk
                            </h4>
                            <p class="text-xs text-slate-500 mt-0.5">Unggah hingga 5 gambar berkualitas tinggi</p>
                        </div>
                        <span id="photo-counter" class="text-[11px] font-bold text-[#800000] bg-red-50 border border-red-100 px-2.5 py-1 rounded-full shadow-2xs">
                            {{ count($product->all_images) }} / 5 Terpasang
                        </span>
                    </div>

                    <!-- Interactive Drag-and-Drop Zone -->
                    <div id="dropzone-area" class="group relative border-2 border-dashed border-slate-300 hover:border-[#800000] rounded-2xl p-6 text-center bg-radial from-slate-50 to-red-50/20 hover:bg-red-50/30 transition-all duration-200 cursor-pointer">
                        <input id="images-input" name="images[]" type="file" multiple accept="image/jpeg,image/png,image/jpg,image/webp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                        <div class="flex flex-col items-center pointer-events-none">
                            <div class="w-12 h-12 rounded-2xl bg-white shadow-xs border border-slate-200 text-[#800000] group-hover:scale-110 group-hover:shadow-md flex items-center justify-center mb-3 transition-all duration-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-sm font-bold text-slate-800 group-hover:text-[#800000] transition-colors">
                                Klik atau seret foto baru
                            </span>
                            <span class="text-[11px] text-slate-500 mt-1 max-w-xs">
                                Format JPG, PNG, WEBP (Maksimal 10MB per berkas). Foto #1 otomatis jadi sampul.
                            </span>
                        </div>
                    </div>
                    @error('images') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    @error('images.*') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror

                    <!-- 5 Slot Grid with Visual Cards -->
                    <div>
                        <div class="flex items-center justify-between mb-2.5">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Preview 5 Slot Foto</label>
                            <span class="text-[10px] text-slate-400">Klik tombol merah silang untuk hapus</span>
                        </div>
                        <div id="preview-grid" class="grid grid-cols-5 gap-2.5">
                            @php $existingImages = $product->all_images; @endphp
                            @for($i = 0; $i < 5; $i++)
                            <div id="slot-{{ $i }}" class="relative aspect-square rounded-xl border border-slate-200/90 bg-slate-50 flex flex-col items-center justify-center overflow-hidden transition-all group shadow-2xs hover:shadow-sm">
                                <div class="slot-placeholder {{ isset($existingImages[$i]) ? 'hidden' : '' }} text-center p-1 text-slate-400 pointer-events-none">
                                    <svg class="w-5 h-5 mx-auto mb-1 opacity-40 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path></svg>
                                    <span class="text-[9px] font-semibold block text-slate-400">
                                        {{ $i === 0 ? 'Sampul' : 'Foto ' . ($i + 1) }}
                                    </span>
                                </div>
                                <img class="slot-image {{ isset($existingImages[$i]) ? '' : 'hidden' }} w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                                     src="{{ isset($existingImages[$i]) ? asset('storage/' . $existingImages[$i]) : '' }}" 
                                     alt="Foto {{ $i + 1 }}">
                                <button type="button" onclick="removeImage({{ $i }})" class="slot-remove hidden absolute top-1 right-1 w-5 h-5 bg-red-600 hover:bg-red-700 text-white rounded-full items-center justify-center text-xs shadow-md transition-colors z-20" title="Hapus foto ini">
                                    &times;
                                </button>
                                <span class="slot-badge {{ isset($existingImages[$i]) ? '' : 'hidden' }} absolute bottom-1 left-1 px-1.5 py-0.5 rounded text-[8px] font-bold z-20 shadow-2xs {{ $i === 0 ? 'bg-amber-500 text-white' : 'bg-slate-900/80 text-white' }}">
                                    {{ $i === 0 ? '★ Sampul' : 'Foto ' . ($i + 1) }}
                                </span>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <div class="p-3.5 bg-amber-50/70 border border-amber-200/60 rounded-xl text-amber-800 text-xs flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Jika Anda tidak memilih foto baru, foto yang sudah ada tetap akan disimpan tanpa perubahan.</span>
                    </div>
                </div>

                <!-- Info UMKM Pemilik -->
                <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-5 space-y-3">
                    <h5 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Informasi UMKM Pemilik</h5>
                    <div class="flex items-center gap-3">
                        @if($product->umkmProfile && $product->umkmProfile->image_path)
                            <img src="{{ asset('storage/' . $product->umkmProfile->image_path) }}" alt="{{ $product->umkmProfile->business_name }}" class="w-10 h-10 rounded-xl object-cover border border-slate-200 shrink-0">
                        @else
                            <div class="w-10 h-10 rounded-xl bg-[#800000]/10 text-[#800000] font-black text-sm flex items-center justify-center border border-[#800000]/20 shrink-0">
                                {{ substr($product->umkmProfile->business_name ?? 'UMKM', 0, 2) }}
                            </div>
                        @endif
                        <div class="overflow-hidden">
                            <p class="font-bold text-sm text-slate-800 truncate">{{ $product->umkmProfile->business_name ?? '-' }}</p>
                            <p class="text-xs text-slate-500 truncate">Pemilik: {{ $product->umkmProfile->owner_name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                        <span>Wilayah:</span>
                        <span class="font-semibold text-slate-800">{{ $product->umkmProfile->district ?? '-' }}, Wonogiri</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Form Information (7 cols) -->
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 sm:p-7 space-y-6">
                    <div class="border-b border-slate-100 pb-4">
                        <h4 class="font-bold text-slate-800 text-lg">Informasi & Spesifikasi Produk</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola data detail produk yang ditampilkan di katalog umum publik.</p>
                    </div>

                    <!-- Nama Produk -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                                   class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-slate-900 text-sm font-semibold focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none transition-all shadow-xs" 
                                   placeholder="Contoh: Sambal Mete Khas Wonogiri Kemasan Botol" required>
                        </div>
                        @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Kategori & Status (Grid) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Kategori Produk <span class="text-red-500">*</span>
                            </label>
                            <select name="category" class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-slate-900 text-sm font-semibold focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none transition-all shadow-xs" required>
                                <option value="Makanan & Minuman" {{ (old('category', $product->category) == 'Makanan & Minuman' || old('category', $product->category) == 'makanan') ? 'selected' : '' }}>🍲 Makanan & Minuman</option>
                                <option value="Batik/Fashion" {{ (old('category', $product->category) == 'Batik/Fashion' || old('category', $product->category) == 'batik') ? 'selected' : '' }}>👔 Batik / Fashion</option>
                                <option value="Kerajinan" {{ (old('category', $product->category) == 'Kerajinan' || old('category', $product->category) == 'kerajinan') ? 'selected' : '' }}>🎨 Kerajinan Tangan</option>
                                <option value="Olahan Hasil Pertanian" {{ (old('category', $product->category) == 'Olahan Hasil Pertanian' || old('category', $product->category) == 'pertanian') ? 'selected' : '' }}>🌾 Olahan Hasil Pertanian</option>
                                <option value="Produk Kreatif" {{ (old('category', $product->category) == 'Produk Kreatif' || old('category', $product->category) == 'kreatif') ? 'selected' : '' }}>💡 Produk Kreatif</option>
                            </select>
                            @error('category') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Status Publikasi
                            </label>
                            <div class="w-full px-4 py-3 bg-emerald-50/60 border border-emerald-200 rounded-xl text-emerald-800 text-sm font-bold flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Terpublikasi (Aktif)
                                </span>
                                <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-100/80 px-2 py-0.5 rounded-md">Live</span>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi Produk -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Deskripsi Produk Lengkap
                            </label>
                            <span class="text-[11px] text-slate-400">Jelaskan keunikan, bahan, atau rasa</span>
                        </div>
                        <textarea name="description" rows="6" 
                                  class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-slate-900 text-sm leading-relaxed focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none transition-all shadow-xs" 
                                  placeholder="Tuliskan deskripsi lengkap produk UMKM ini...">{{ old('description', $product->description) }}</textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Action Buttons Card -->
                    <div class="pt-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <a href="{{ route('admin.products') }}" class="w-full sm:w-auto px-5 py-3 text-slate-600 hover:text-slate-900 font-bold text-sm text-center rounded-xl hover:bg-slate-100 transition-colors">
                            Batal
                        </a>
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3 bg-gradient-to-r from-[#800000] to-red-800 hover:from-red-900 hover:to-red-950 text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let uploadedFiles = [];
    const imagesInput = document.getElementById('images-input');
    const photoCounter = document.getElementById('photo-counter');

    imagesInput.addEventListener('change', function(event) {
        const newFiles = Array.from(event.target.files);
        
        uploadedFiles = [];
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

        if (uploadedFiles.length > 0) {
            photoCounter.textContent = `${uploadedFiles.length} / 5 Foto baru`;
        }

        for (let i = 0; i < 5; i++) {
            const slot = document.getElementById(`slot-${i}`);
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
                badge.className = `slot-badge absolute bottom-1 left-1 px-1.5 py-0.5 rounded text-[8px] font-bold z-20 shadow-2xs ${i === 0 ? 'bg-amber-500 text-white' : 'bg-slate-900/80 text-white'}`;
                badge.textContent = i === 0 ? '★ Sampul' : `Foto ${i + 1}`;
            } else {
                img.src = '';
                img.classList.add('hidden');
                placeholder.classList.remove('hidden');
                removeBtn.classList.add('hidden');
                removeBtn.classList.remove('flex');
                badge.classList.add('hidden');
            }
        }
    }

    function removeImage(index) {
        uploadedFiles.splice(index, 1);
        updateFileInputAndPreview();
    }
</script>
@endsection
