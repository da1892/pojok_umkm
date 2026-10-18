@extends('layouts.admin')

@section('page_title', 'Tambah Berita & Kegiatan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between bg-white/70 backdrop-blur-sm p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('admin.news') }}" class="hover:text-[#800000] font-medium transition-colors">Kelola Berita & Kegiatan</a>
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="font-bold text-slate-800">Tambah Baru</span>
        </div>
        <a href="{{ route('admin.news') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-50 rounded-xl border border-slate-200 shadow-2xs transition-all">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 sm:p-8">
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul Berita -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Judul Berita / Kegiatan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" 
                       class="w-full px-4 py-3 bg-slate-50/50 hover:bg-white focus:bg-white border border-slate-200 rounded-xl text-slate-800 text-sm font-semibold focus:ring-2 focus:ring-[#800000]/20 focus:border-[#800000] transition-all" 
                       placeholder="Contoh: Bimtek Pemasaran Digital UMKM Wonogiri Go-Global" required>
                @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Kategori & On/Off Toggle (Grid) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Kategori Agenda / Berita <span class="text-red-500">*</span>
                    </label>
                    <select name="category" class="w-full px-4 py-3 bg-slate-50/50 hover:bg-white focus:bg-white border border-slate-200 rounded-xl text-slate-800 text-sm font-semibold focus:ring-2 focus:ring-[#800000]/20 focus:border-[#800000] transition-all" required>
                        <option value="Pelatihan & Workshop" {{ old('category') == 'Pelatihan & Workshop' ? 'selected' : '' }}>Pelatihan & Workshop</option>
                        <option value="Sertifikasi & Legalitas" {{ old('category') == 'Sertifikasi & Legalitas' ? 'selected' : '' }}>Sertifikasi & Legalitas</option>
                        <option value="Pameran & Bazaar" {{ old('category') == 'Pameran & Bazaar' ? 'selected' : '' }}>Pameran & Bazaar</option>
                        <option value="Program Bantuan / Modal" {{ old('category') == 'Program Bantuan / Modal' ? 'selected' : '' }}>Program Bantuan / Modal</option>
                        <option value="Pengumuman Resmi" {{ old('category') == 'Pengumuman Resmi' ? 'selected' : '' }}>Pengumuman Resmi</option>
                    </select>
                    @error('category') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Status Publikasi On / Off Switch -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Status Publikasi (On / Off)
                    </label>
                    <label class="flex items-center gap-3 p-3 bg-slate-50/80 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition-colors">
                        <input type="checkbox" name="is_published" value="1" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600 relative"></div>
                        <span class="text-xs font-bold text-slate-700 peer-checked:text-emerald-700">
                            Aktif (Langsung tampil di halaman depan)
                        </span>
                    </label>
                </div>
            </div>

            <!-- Upload Beberapa Foto Berita (Multiple Images Carousel) -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Foto-Foto Dokumentasi Berita (Maksimal 6 Foto)
                    </label>
                    <span id="photo-counter" class="text-xs font-semibold text-[#800000] bg-red-50 px-2.5 py-1 rounded-full border border-red-100">
                        0 Foto dipilih
                    </span>
                </div>
                <p class="text-xs text-slate-500 mb-3">
                    Pilih 1 atau beberapa foto sekaligus. Di halaman pembaca berita, foto-foto ini akan otomatis menjadi <strong>slide animasi berjalan / bergerak otomatis</strong>. Foto pertama akan menjadi foto sampul.
                </p>

                <!-- Dropzone Area -->
                <div class="border-2 border-dashed border-slate-300 hover:border-[#800000] rounded-2xl p-6 text-center bg-slate-50/60 hover:bg-red-50/20 transition-all cursor-pointer relative group">
                    <input type="file" id="news-images-input" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                    <div class="flex flex-col items-center pointer-events-none">
                        <div class="w-12 h-12 rounded-2xl bg-white shadow-xs border border-slate-200 text-[#800000] group-hover:scale-110 flex items-center justify-center mb-2.5 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-800 group-hover:text-[#800000]">Klik atau seret beberapa foto ke sini</span>
                        <span class="text-xs text-slate-400 mt-0.5">Format JPG, PNG, WEBP (Bisa pilih 1 sampai 6 foto)</span>
                    </div>
                </div>
                @error('images') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                @error('images.*') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror

                <!-- 6 Slots Preview Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3 mt-4" id="news-preview-grid">
                    @for($i = 0; $i < 6; $i++)
                    <div id="slot-{{ $i }}" class="relative aspect-4/3 rounded-xl border border-slate-200 bg-slate-50 flex flex-col items-center justify-center overflow-hidden transition-all shadow-2xs">
                        <div class="slot-placeholder text-center p-2 text-slate-300 pointer-events-none">
                            <svg class="w-5 h-5 mx-auto mb-1 opacity-40 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path></svg>
                            <span class="text-[9px] font-semibold block text-slate-400">
                                {{ $i === 0 ? 'Foto Utama' : 'Foto ' . ($i + 1) }}
                            </span>
                        </div>
                        <img class="slot-image hidden w-full h-full object-cover" src="" alt="Preview {{ $i + 1 }}">
                        <button type="button" onclick="removeNewsImage({{ $i }})" class="slot-remove hidden absolute top-1 right-1 w-5 h-5 bg-red-600 hover:bg-red-700 text-white rounded-full items-center justify-center text-xs shadow-md transition-colors z-20" title="Hapus foto ini">
                            &times;
                        </button>
                        <span class="slot-badge hidden absolute bottom-1 left-1 px-1.5 py-0.5 rounded text-[8px] font-bold z-20 shadow-2xs {{ $i === 0 ? 'bg-amber-500 text-white' : 'bg-slate-900/80 text-white' }}">
                            {{ $i === 0 ? '★ Sampul' : 'Slide ' . ($i + 1) }}
                        </span>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Ringkasan Singkat (Excerpt) -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Ringkasan Singkat (Lead / Excerpt)
                    </label>
                    <span class="text-[11px] text-slate-400">Ditampilkan pada kartu berita di halaman utama</span>
                </div>
                <textarea name="excerpt" rows="2" 
                          class="w-full px-4 py-3 bg-slate-50/50 hover:bg-white focus:bg-white border border-slate-200 rounded-xl text-slate-800 text-sm focus:ring-2 focus:ring-[#800000]/20 focus:border-[#800000] transition-all" 
                          placeholder="Ringkasan 1-2 kalimat untuk preview di beranda...">{{ old('excerpt') }}</textarea>
                @error('excerpt') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Isi Konten Lengkap -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Isi Lengkap Berita & Kegiatan <span class="text-red-500">*</span>
                </label>
                <textarea name="content" rows="8" 
                          class="w-full px-4 py-3 bg-slate-50/50 hover:bg-white focus:bg-white border border-slate-200 rounded-xl text-slate-800 text-sm leading-relaxed focus:ring-2 focus:ring-[#800000]/20 focus:border-[#800000] transition-all" 
                          placeholder="Tuliskan berita lengkap, waktu pelaksanaan kegiatan, tempat, syarat pendaftaran, atau informasi penting lainnya..." required>{{ old('content') }}</textarea>
                @error('content') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-5 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.news') }}" class="px-5 py-2.5 text-xs font-bold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-7 py-3 bg-[#800000] hover:bg-red-900 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                    Simpan & Terbitkan Berita
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let uploadedNewsFiles = [];
    const newsImagesInput = document.getElementById('news-images-input');
    const photoCounter = document.getElementById('photo-counter');

    newsImagesInput.addEventListener('change', function(event) {
        const newFiles = Array.from(event.target.files);
        uploadedNewsFiles = [];
        for (const file of newFiles) {
            if (uploadedNewsFiles.length < 6) {
                uploadedNewsFiles.push(file);
            }
        }
        updateNewsFileInputAndPreview();
    });

    function updateNewsFileInputAndPreview() {
        const dataTransfer = new DataTransfer();
        uploadedNewsFiles.forEach(file => dataTransfer.items.add(file));
        newsImagesInput.files = dataTransfer.files;

        photoCounter.textContent = `${uploadedNewsFiles.length} / 6 Foto dipilih`;

        for (let i = 0; i < 6; i++) {
            const slot = document.getElementById(`slot-${i}`);
            const placeholder = slot.querySelector('.slot-placeholder');
            const img = slot.querySelector('.slot-image');
            const removeBtn = slot.querySelector('.slot-remove');
            const badge = slot.querySelector('.slot-badge');

            if (uploadedNewsFiles[i]) {
                img.src = URL.createObjectURL(uploadedNewsFiles[i]);
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
                removeBtn.classList.remove('hidden');
                removeBtn.classList.add('flex');
                badge.classList.remove('hidden');
                badge.className = `slot-badge absolute bottom-1 left-1 px-1.5 py-0.5 rounded text-[8px] font-bold z-20 shadow-2xs ${i === 0 ? 'bg-amber-500 text-white' : 'bg-slate-900/80 text-white'}`;
                badge.textContent = i === 0 ? '★ Sampul' : `Slide ${i + 1}`;
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

    function removeNewsImage(index) {
        uploadedNewsFiles.splice(index, 1);
        updateNewsFileInputAndPreview();
    }
</script>
@endsection
