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
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pengisian:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('toko.product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-semibold text-gray-800">
                            Foto Produk (Maksimal 5 Foto) <span class="text-red-500">*</span>
                        </label>
                        <span id="photo-counter" class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">
                            0 / 5 Foto dipilih
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mb-3">
                        Unggah minimal 1 dan maksimal 5 foto produk. Foto pertama akan dijadikan foto sampul utama. Format: JPG, PNG, JPEG, WEBP (maks. 10MB/foto).
                    </p>

                    <!-- Dropzone Area -->
                    <div id="dropzone-area" class="border-2 border-gray-300 border-dashed rounded-2xl p-6 text-center hover:border-[#801414] transition-colors bg-gray-50/70 cursor-pointer relative">
                        <input id="images-input" name="images[]" type="file" multiple accept="image/jpeg,image/png,image/jpg,image/webp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="flex flex-col items-center pointer-events-none">
                            <div class="w-12 h-12 rounded-full bg-red-50 text-[#801414] flex items-center justify-center mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-sm font-bold text-[#801414]">Klik atau seret file ke sini untuk memilih foto</span>
                            <span class="text-xs text-slate-400 mt-1">Bisa memilih sekaligus hingga 5 foto</span>
                        </div>
                    </div>

                    <!-- 5 Slot Preview Grid -->
                    <div id="preview-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3 mt-4">
                        @for($i = 0; $i < 5; $i++)
                        <div id="slot-{{ $i }}" class="relative aspect-square rounded-xl border border-slate-200 bg-slate-100 flex flex-col items-center justify-center overflow-hidden transition-all group">
                            <div class="slot-placeholder text-center p-2 text-slate-400 pointer-events-none">
                                <svg class="w-6 h-6 mx-auto mb-1 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path></svg>
                                <span class="text-[10px] font-medium block">
                                    {{ $i === 0 ? 'Foto Utama' : 'Foto ' . ($i + 1) }}
                                </span>
                            </div>
                            <img class="slot-image hidden w-full h-full object-cover" alt="Preview {{ $i + 1 }}">
                            <button type="button" onclick="removeImage({{ $i }})" class="slot-remove hidden absolute top-1.5 right-1.5 w-6 h-6 bg-red-600 text-white rounded-full items-center justify-center text-xs shadow hover:bg-red-700 transition-colors z-20" title="Hapus foto ini">
                                &times;
                            </button>
                            <span class="slot-badge hidden absolute bottom-1.5 left-1.5 px-1.5 py-0.5 rounded text-[9px] font-bold z-20 {{ $i === 0 ? 'bg-amber-500 text-white' : 'bg-slate-900/70 text-white' }}">
                                {{ $i === 0 ? 'Sampul' : 'Foto ' . ($i + 1) }}
                            </span>
                        </div>
                        @endfor
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs" placeholder="Contoh: Keripik Singkong Balado">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Kategori Produk <span class="text-red-500">*</span></label>
                    <select name="category" required class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs">
                        <option value="">Pilih Kategori...</option>
                        <option value="Makanan & Minuman" {{ old('category') == 'Makanan & Minuman' ? 'selected' : '' }}>Makanan & Minuman</option>
                        <option value="Kerajinan" {{ old('category') == 'Kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                        <option value="Batik/Fashion" {{ old('category') == 'Batik/Fashion' ? 'selected' : '' }}>Batik/Fashion</option>
                        <option value="Olahan Hasil Pertanian" {{ old('category') == 'Olahan Hasil Pertanian' ? 'selected' : '' }}>Olahan Hasil Pertanian</option>
                        <option value="Produk Kreatif" {{ old('category') == 'Produk Kreatif' ? 'selected' : '' }}>Produk Kreatif</option>
                        <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Produk Unggulan Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Deskripsi Produk <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="5" required class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs" placeholder="Jelaskan detail produk Anda, bahan, keunggulan, dll...">{{ old('description') }}</textarea>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="bg-[#801414] hover:bg-red-900 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md hover:shadow-lg flex items-center cursor-pointer">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Simpan Produk
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
        // Sync DataTransfer back to imagesInput so form submits all uploaded files
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
                slot.classList.add('border-solid', 'border-[#801414]/30');
            } else {
                img.src = '';
                img.classList.add('hidden');
                placeholder.classList.remove('hidden');
                removeBtn.classList.add('hidden');
                removeBtn.classList.remove('flex');
                badge.classList.add('hidden');
                slot.classList.remove('border-solid', 'border-[#801414]/30');
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
