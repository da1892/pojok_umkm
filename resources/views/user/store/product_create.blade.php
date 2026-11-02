@extends('user.layouts.app')

@section('content')
<div class="py-10 bg-slate-50/60 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Halaman -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2.5 mb-1.5">
                    <span class="w-9 h-9 rounded-xl bg-red-100 text-[#801414] flex items-center justify-center font-bold shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    </span>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Tambah Produk Baru</h2>
                </div>
                <p class="text-xs sm:text-sm text-slate-500">Daftarkan produk unggulan UMKM Anda agar tayang di Katalog Resmi Kabupaten Wonogiri.</p>
            </div>
            <a href="{{ route('toko.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-50 rounded-xl border border-slate-200 shadow-2xs transition-all self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>

        <!-- ======================================================== -->
        <!-- PANDUAN & STANDAR KURASI PRODUK UMKM KABUPATEN WONOGIRI  -->
        <!-- ======================================================== -->
        <div class="mb-6 rounded-2xl border border-amber-200 bg-gradient-to-br from-amber-50/90 via-amber-50/40 to-white p-5 shadow-xs">
            <div class="flex items-start justify-between gap-3 mb-3.5">
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold shadow-xs">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    </span>
                    <div>
                        <h3 class="text-sm font-black text-amber-950 uppercase tracking-wider">Standar Produk Lolos Kurasi UMKM Wonogiri</h3>
                        <p class="text-xs text-amber-800">Ikuti 4 kriteria kurasi ini agar produk Anda langsung disetujui kurator Dinas KUKM:</p>
                    </div>
                </div>
                <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide bg-amber-100 text-amber-900 border border-amber-300/60">
                    Panduan Kurasi
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="bg-white/95 p-3 rounded-xl border border-amber-200/70 shadow-2xs">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-5 h-5 rounded-md bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs font-extrabold">1</span>
                        <h4 class="text-xs font-bold text-slate-800">Foto Asli & Jelas</h4>
                    </div>
                    <p class="text-[11px] text-slate-600 leading-relaxed">Gunakan foto asli dengan pencahayaan terang. Tampilkan kemasan depan dan label merek.</p>
                </div>
                <div class="bg-white/95 p-3 rounded-xl border border-amber-200/70 shadow-2xs">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-5 h-5 rounded-md bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs font-extrabold">2</span>
                        <h4 class="text-xs font-bold text-slate-800">Nama Terstruktur</h4>
                    </div>
                    <p class="text-[11px] text-slate-600 leading-relaxed">Format standar: <strong>Merek + Jenis + Varian/Netto</strong> (Cth: Mete Wonogiri Rasa Bawang 250g).</p>
                </div>
                <div class="bg-white/95 p-3 rounded-xl border border-amber-200/70 shadow-2xs">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-5 h-5 rounded-md bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs font-extrabold">3</span>
                        <h4 class="text-xs font-bold text-slate-800">Rincian Komposisi</h4>
                    </div>
                    <p class="text-[11px] text-slate-600 leading-relaxed">Cantumkan komposisi bahan, berat bersih (netto) atau ukuran, dan daya tahan simpan.</p>
                </div>
                <div class="bg-white/95 p-3 rounded-xl border border-amber-200/70 shadow-2xs">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-5 h-5 rounded-md bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs font-extrabold">4</span>
                        <h4 class="text-xs font-bold text-slate-800">Legalitas & Khas</h4>
                    </div>
                    <p class="text-[11px] text-slate-600 leading-relaxed">Cantumkan PIRT/Halal (jika ada) serta keistimewaan bahan lokal Wonogiri.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 p-6 sm:p-8">
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-900 shadow-2xs">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-xs font-bold text-red-800 uppercase tracking-wider">Periksa Kembali Data Anda:</h3>
                            <ul class="list-disc pl-5 space-y-1 mt-1 text-xs text-red-700 font-medium">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('toko.product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <!-- BAGIAN 1: FOTO PRODUK -->
                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-3 gap-2">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-lg bg-red-50 text-[#801414] flex items-center justify-center font-bold text-xs">
                                1
                            </span>
                            <label class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">
                                Foto Produk <span class="text-red-500">*</span>
                            </label>
                        </div>
                        <span id="photo-counter" class="text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1 rounded-full border border-slate-200 self-start sm:self-auto">
                            0 / 5 Foto dipilih
                        </span>
                    </div>

                    <p class="text-xs text-slate-500 leading-relaxed">
                        Unggah minimal 1 dan maksimal 5 foto produk. <strong>Foto pertama otomatis dijadikan foto sampul utama</strong> di katalog pembeli. Format: JPG, PNG, WEBP (maks. 10MB/foto).
                    </p>

                    <!-- Dropzone Area -->
                    <div id="dropzone-area" class="border-2 border-dashed border-slate-300 hover:border-[#801414] rounded-2xl p-6 text-center transition-all bg-slate-50/70 hover:bg-red-50/20 cursor-pointer relative group">
                        <input id="images-input" name="images[]" type="file" multiple accept="image/jpeg,image/png,image/jpg,image/webp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="flex flex-col items-center pointer-events-none">
                            <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-2xs text-[#801414] group-hover:scale-110 flex items-center justify-center mb-2.5 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-sm font-bold text-slate-800 group-hover:text-[#801414] transition-colors">Klik atau Seret Foto ke Sini</span>
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
                </div>

                <!-- BAGIAN 2: INFORMASI DASAR PRODUK -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                        <span class="w-6 h-6 rounded-lg bg-red-50 text-[#801414] flex items-center justify-center font-bold text-xs">
                            2
                        </span>
                        <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">
                            Informasi Produk
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 mb-1.5">
                                Nama Produk <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs" placeholder="Contoh: Mete Wonogiri Rasa Bawang 250gr">
                            <p class="text-[11px] text-slate-400 mt-1">Format: <strong>[Merek] + [Jenis Produk] + [Varian / Ukuran]</strong></p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-800 mb-1.5">
                                Kategori Produk <span class="text-red-500">*</span>
                            </label>
                            <select name="category" required class="w-full px-4 py-2.5 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs">
                                <option value="">-- Pilih Kategori Produk --</option>
                                <option value="Makanan & Minuman" {{ old('category') == 'Makanan & Minuman' ? 'selected' : '' }}>Makanan & Minuman</option>
                                <option value="Kerajinan" {{ old('category') == 'Kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                                <option value="Batik/Fashion" {{ old('category') == 'Batik/Fashion' ? 'selected' : '' }}>Batik/Fashion</option>
                                <option value="Olahan Hasil Pertanian" {{ old('category') == 'Olahan Hasil Pertanian' ? 'selected' : '' }}>Olahan Hasil Pertanian</option>
                                <option value="Produk Kreatif" {{ old('category') == 'Produk Kreatif' ? 'selected' : '' }}>Produk Kreatif</option>
                                <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Produk Unggulan Lainnya</option>
                            </select>
                            <p class="text-[11px] text-slate-400 mt-1">Sesuaikan kategori agar mudah ditemukan calon pembeli</p>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 3: RINCIAN & DESKRIPSI PRODUK STANDAR WONOGIRI -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                        <span class="w-6 h-6 rounded-lg bg-red-50 text-[#801414] flex items-center justify-center font-bold text-xs">
                            3
                        </span>
                        <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">
                            Deskripsi & Spesifikasi Produk
                        </h3>
                    </div>

                    <div>
                        <div class="mb-2">
                            <label class="block text-xs font-bold text-slate-800">
                                Deskripsi Produk <span class="text-red-500">*</span>
                            </label>
                        </div>

                        <textarea id="product-description-textarea" name="description" rows="7" required class="w-full px-4 py-3 rounded-2xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs leading-relaxed" placeholder="Jelaskan detail produk Anda, bahan utama, ukuran / netto, cara penyajian, atau keunggulan khas lokal Wonogiri...">{{ old('description') }}</textarea>
                        
                        <div class="mt-2 p-3 rounded-xl bg-slate-50 border border-slate-200/80 text-[11px] text-slate-600 flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span><strong>Tips Standar Wonogiri:</strong> Cantumkan izin edar resmi seperti nomor PIRT atau Sertifikat Halal pada deskripsi produk bila memilikinya untuk meningkatkan kepercayaan kurator dan pembeli.</span>
                        </div>
                    </div>
                </div>

                <!-- TOMBOL AKSI -->
                <div class="pt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('toko.index') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-100 text-center font-bold text-xs transition-colors shadow-2xs">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-gradient-to-r from-red-600 via-red-700 to-[#801414] hover:from-red-700 hover:to-[#660000] text-white font-bold text-xs transition-all shadow-md shadow-red-500/20 active:scale-98 flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Produk & Ajukan Kurasi</span>
                    </button>
                </div>
            </form>
        </div>
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

        photoCounter.textContent = `${uploadedFiles.length} / 5 Foto dipilih`;

        // Update slots
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
                slot.classList.remove('border-dashed');
                slot.classList.add('border-solid', 'border-[#801414]/40');
            } else {
                img.src = '';
                img.classList.add('hidden');
                placeholder.classList.remove('hidden');
                removeBtn.classList.add('hidden');
                removeBtn.classList.remove('flex');
                badge.classList.add('hidden');
                slot.classList.remove('border-solid', 'border-[#801414]/40');
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
