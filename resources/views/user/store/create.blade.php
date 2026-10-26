@extends('user.layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 sm:p-10">
            <div class="mb-8 border-b border-slate-100 pb-5">
                <div class="flex items-center gap-3 mb-2">
                    <span class="w-10 h-10 rounded-xl bg-red-50 text-[#801414] flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </span>
                    <div>
                        <h2 class="text-2xl font-extrabold text-[#801414]">Formulir Pendaftaran UMKM</h2>
                        <p class="text-slate-500 text-sm">Lengkapi data usaha Anda untuk diverifikasi oleh admin Dinas KUKM Kabupaten Wonogiri.</p>
                    </div>
                </div>
            </div>

            @if (isset($errors) && $errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-red-800">Terdapat kesalahan pengisian data:</h3>
                            <ul class="list-disc pl-5 mt-1 text-xs text-red-700 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form id="form-create-store" action="{{ route('toko.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Notifikasi Peringatan Jika Digit Kurang -->
                <div id="create-alert-box" class="hidden p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <div class="flex-1">
                            <h4 class="font-bold text-red-800 mb-1">Jumlah Digit Nomor Belum Lengkap</h4>
                            <div id="create-alert-message" class="text-xs space-y-1"></div>
                        </div>
                    </div>
                </div>

                <!-- Foto Profil / Logo UMKM -->
                <div class="p-6 rounded-2xl bg-gradient-to-r from-red-50/70 via-slate-50 to-white border-2 border-red-100 flex flex-col sm:flex-row items-center gap-6 shadow-xs">
                    <div class="relative shrink-0">
                        <div id="preview-container" class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-red-200 shadow-md bg-white flex items-center justify-center">
                            <div id="default-avatar" class="w-full h-full bg-gradient-to-br from-[#801414] to-[#b91c1c] text-white flex flex-col items-center justify-center font-extrabold shadow-inner">
                                <svg class="w-8 h-8 opacity-90 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-[11px] uppercase tracking-wider font-bold">LOGO</span>
                            </div>
                            <img id="image-preview" src="#" alt="Pratinjau Foto" class="w-full h-full object-cover hidden">
                        </div>
                    </div>
                    <div class="flex-1 text-center sm:text-left">
                        <label class="block text-sm font-bold text-slate-900 mb-1">Foto Profil / Logo UMKM <span class="text-slate-400 font-normal text-xs">(Opsional)</span></label>
                        <p class="text-xs text-slate-500 mb-3 leading-relaxed">Unggah logo atau foto tempat usaha fisik Anda agar profil mudah dikenali. Format: JPG, PNG, atau WebP (Maks. 5MB).</p>
                        <div class="flex flex-wrap items-center gap-3">
                            <label for="store-image-input" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#801414] hover:bg-red-900 text-white text-xs font-bold transition-all shadow-xs cursor-pointer hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Pilih Foto / Logo
                            </label>
                            <span id="file-name-display" class="text-xs text-slate-500 italic">Belum ada file dipilih</span>
                            <input type="file" name="image" id="store-image-input" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewStoreImage(this)" class="hidden">
                        </div>
                    </div>
                </div>

                <!-- Informasi Pokok UMKM -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-2">Nama UMKM / Usaha <span class="text-red-500">*</span></label>
                        <input type="text" name="business_name" value="{{ old('business_name') }}" required class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs" placeholder="Contoh: Keripik Berkah Barokah">
                        <p class="text-[11px] text-slate-400 mt-1.5">Nama resmi UMKM / Brand usaha Anda</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-2">Nama Pemilik <span class="text-red-500">*</span></label>
                        <input type="text" name="owner_name" value="{{ old('owner_name') }}" required class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs" placeholder="Contoh: Budi Santoso">
                        <p class="text-[11px] text-slate-400 mt-1.5">Nama lengkap pemilik usaha</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-1.5">
                        Nomor Kontak / WhatsApp <span class="text-red-500">*</span>
                        <span class="text-[10px] text-slate-400 font-normal ml-1">(Min. 10 Digit)</span>
                    </label>
                    <input type="tel" name="phone" id="create-phone-input" value="{{ old('phone') }}" required minlength="10" maxlength="15" pattern="[0-9]{10,15}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs @error('phone') border-red-500 @enderror" placeholder="Contoh: 081234567890 (minimal 10 digit)">
                    <div id="create-phone-feedback" class="mt-1 text-xs"></div>
                    @error('phone')
                        <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                    @else
                        <p class="text-[11px] text-slate-400 mt-1">Digunakan oleh calon pembeli dan admin untuk menghubungi Anda (10-15 digit)</p>
                    @enderror
                </div>

                <!-- Bagian Wilayah & Alamat Lengkap Dari Provinsi sampai Desa -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-red-100 text-[#801414] flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </span>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">Alamat & Lokasi Usaha Lengkap</h3>
                                <p class="text-[11px] text-slate-500">Struktur alamat berjenjang dari Provinsi, Kabupaten, Kecamatan hingga Desa/Kelurahan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Autocomplete / Kata Kunci Cepat Pencarian Wilayah -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Pencarian Cepat Wilayah <span class="font-normal text-slate-500">(Ketik nama Desa atau Kecamatan):</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" id="keyword-search" autocomplete="off" placeholder="Ketik kata kunci desa / kecamatan (contoh: Girimarto, Wonokarto, Baturetno, Selogiri...)" class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs">
                            <div id="search-results" class="hidden absolute left-0 right-0 top-full mt-1.5 max-h-56 overflow-y-auto bg-white rounded-xl shadow-xl border border-slate-200 z-50 divide-y divide-slate-100"></div>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1.5">Pilih dari hasil pencarian otomatis untuk mengisi Kecamatan dan Desa seketika.</p>
                    </div>

                    <!-- Wilayah Administratif Bertingkat (Provinsi, Kabupaten, Kecamatan, Desa) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Provinsi <span class="text-red-500">*</span></label>
                            <input type="text" name="province" id="province-input" value="{{ old('province', 'Jawa Tengah') }}" readonly class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-100/90 text-slate-700 text-sm font-semibold cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Kabupaten / Kota <span class="text-red-500">*</span></label>
                            <input type="text" name="regency" id="regency-input" value="{{ old('regency', 'Kabupaten Wonogiri') }}" readonly class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-100/90 text-slate-700 text-sm font-semibold cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Kecamatan <span class="text-red-500">*</span></label>
                            <select id="district-select" name="district" required class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs">
                                <option value="">-- Pilih Kecamatan --</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Desa / Kelurahan <span class="text-red-500">*</span></label>
                            <select id="village-select" name="village" required class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs">
                                <option value="">-- Pilih Desa / Kelurahan --</option>
                            </select>
                        </div>
                    </div>

                    <!-- Alamat Rinci & Kode Pos -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Spesifik (Jalan, RT/RW, Dusun, Patokan Lokasi) <span class="text-red-500">*</span></label>
                            <input type="text" id="address-input" name="address" required value="{{ old('address') }}" class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs" placeholder="Contoh: Jl. Diponegoro No. 12, RT 02 / RW 04, Dusun Jatirejo">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Kode Pos
                                <span class="text-[10px] text-slate-400 font-normal ml-1">(5 Digit)</span>
                            </label>
                            <input type="text" id="postal-input" name="postal_code" value="{{ old('postal_code') }}" minlength="5" maxlength="5" pattern="[0-9]{5}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs @error('postal_code') border-red-500 @enderror" placeholder="Contoh: 57615">
                            <div id="create-postal-feedback" class="mt-1 text-xs"></div>
                            @error('postal_code')
                                <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Pratinjau Alamat Lengkap Realtime -->
                    <div class="p-4 rounded-xl bg-white border-2 border-red-100 shadow-xs">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#801414] block mb-1">Format Teks Alamat Lengkap:</span>
                        <p id="full-address-preview" class="text-xs text-slate-700 font-medium italic">
                            (Isi data wilayah dan alamat spesifik di atas untuk melihat format alamat lengkap)
                        </p>
                    </div>

                    <!-- Link Titik Lokasi Google Maps -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Tautan Titik Lokasi Google Maps <span class="text-slate-400 font-normal">(Opsional - Agar calon pembeli tahu letak UMKM Anda)</span>
                        </label>
                        <input type="url" name="map_link" value="{{ old('map_link') }}" placeholder="Contoh: https://maps.app.goo.gl/... atau https://maps.google.com/?q=..." class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs">
                        <p class="text-[11px] text-slate-500 mt-1.5 leading-relaxed">
                            💡 <em>Opsional: Peta lokasi UMKM akan otomatis membaca alamat, desa, dan kecamatan Anda di atas. Anda juga dapat menempelkan link Google Maps jika memiliki pin lokasi yang lebih spesifik.</em>
                        </p>
                    </div>
                </div>

                <!-- Legalitas & Sertifikasi Usaha -->
                <div>
                    <h3 class="text-xs font-extrabold text-slate-500 uppercase tracking-wider mb-3">Legalitas & Sertifikasi (Opsional)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Nomor Induk Berusaha (NIB)
                                <span class="text-[10px] text-slate-400 font-normal ml-1">(13 Digit)</span>
                            </label>
                            <input type="text" 
                                   name="nib" 
                                   id="create-nib-input"
                                   value="{{ old('nib') }}" 
                                   minlength="13" 
                                   maxlength="13" 
                                   pattern="[0-9]{13}" 
                                   inputmode="numeric" 
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                                   class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs @error('nib') border-red-500 @enderror" 
                                   placeholder="Contoh: 9120003216549">
                            <div id="create-nib-feedback" class="mt-1 text-xs"></div>
                            @error('nib')
                                <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Sertifikasi PIRT
                                <span class="text-[10px] text-slate-400 font-normal ml-1">(15 Digit)</span>
                            </label>
                            <input type="text" 
                                   name="pirt" 
                                   id="create-pirt-input"
                                   value="{{ old('pirt') }}" 
                                   minlength="15" 
                                   maxlength="35" 
                                   class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs @error('pirt') border-red-500 @enderror" 
                                   placeholder="Contoh: 215331201014526 atau P-IRT 2153312010145-26">
                            <div id="create-pirt-feedback" class="mt-1 text-xs"></div>
                            @error('pirt')
                                <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                Sertifikasi Halal
                                <span class="text-[10px] text-slate-400 font-normal ml-1">(BPJPH / MUI)</span>
                            </label>
                            <input type="text" 
                                   name="halal_cert" 
                                   id="create-halal-input"
                                   value="{{ old('halal_cert') }}" 
                                   minlength="10" 
                                   maxlength="35" 
                                   class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs @error('halal_cert') border-red-500 @enderror" 
                                   placeholder="Contoh: ID33110000789010323">
                            <div id="create-halal-feedback" class="mt-1 text-xs"></div>
                            @error('halal_cert')
                                <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-2">Deskripsi Singkat Usaha</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 text-sm text-slate-900 bg-white placeholder:text-slate-400 focus:border-[#801414] focus:ring-4 focus:ring-red-500/15 focus:outline-none transition-all shadow-xs" placeholder="Jelaskan jenis produk, kapasitas produksi, atau keunggulan UMKM Anda...">{{ old('description') }}</textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('toko.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="bg-[#801414] hover:bg-red-900 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-md hover:shadow-lg flex items-center gap-2 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Kirim Pendaftaran UMKM
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let wilayahData = {};
    const districtSelect = document.getElementById('district-select');
    const villageSelect = document.getElementById('village-select');
    const searchInput = document.getElementById('keyword-search');
    const searchResults = document.getElementById('search-results');

    const addressInput = document.getElementById('address-input');
    const postalInput = document.getElementById('postal-input');
    const fullAddressPreview = document.getElementById('full-address-preview');

    function updateFullAddressPreview() {
        const addr = addressInput ? addressInput.value.trim() : '';
        const kec = districtSelect ? districtSelect.value : '';
        const desa = villageSelect ? villageSelect.value : '';
        const pos = postalInput ? postalInput.value.trim() : '';
        
        const parts = [];
        if (addr) parts.push(addr);
        if (desa) parts.push(`Desa/Kel. ${desa}`);
        if (kec) parts.push(`Kec. ${kec}`);
        parts.push('Kabupaten Wonogiri');
        parts.push('Provinsi Jawa Tengah');
        if (pos) parts.push(`Kode Pos ${pos}`);

        if (addr || kec || desa) {
            fullAddressPreview.textContent = parts.join(', ');
            fullAddressPreview.classList.remove('italic', 'text-slate-400');
            fullAddressPreview.classList.add('text-slate-800', 'font-semibold');
        } else {
            fullAddressPreview.textContent = '(Isi data wilayah dan alamat spesifik di atas untuk melihat format alamat lengkap)';
            fullAddressPreview.classList.add('italic', 'text-slate-400');
            fullAddressPreview.classList.remove('text-slate-800', 'font-semibold');
        }
    }

    if (addressInput) addressInput.addEventListener('input', updateFullAddressPreview);
    if (postalInput) postalInput.addEventListener('input', updateFullAddressPreview);

    const selectedDistrictOld = @json(old('district', ''));
    const selectedVillageOld = @json(old('village', ''));

    // Muat data master wilayah Wonogiri (Kecamatan & Desa)
    fetch('/wonogiri_wilayah.json')
        .then(res => res.json())
        .then(data => {
            wilayahData = data;
            populateDistricts();

            if (selectedDistrictOld) {
                districtSelect.value = selectedDistrictOld;
                populateVillages(selectedDistrictOld);
                if (selectedVillageOld) {
                    villageSelect.value = selectedVillageOld;
                }
            }
            updateFullAddressPreview();
        })
        .catch(err => console.error('Gagal memuat master wilayah:', err));

    function populateDistricts() {
        districtSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
        Object.keys(wilayahData).sort().forEach(kec => {
            const opt = document.createElement('option');
            opt.value = kec;
            opt.textContent = `Kec. ${kec}`;
            districtSelect.appendChild(opt);
        });
    }

    function populateVillages(kecamatan) {
        villageSelect.innerHTML = '<option value="">-- Pilih Desa / Kelurahan --</option>';
        if (wilayahData[kecamatan]) {
            wilayahData[kecamatan].sort().forEach(desa => {
                const opt = document.createElement('option');
                opt.value = desa;
                opt.textContent = `Desa/Kel. ${desa}`;
                villageSelect.appendChild(opt);
            });
        }
        updateFullAddressPreview();
    }

    districtSelect.addEventListener('change', function() {
        populateVillages(this.value);
        updateFullAddressPreview();
    });

    villageSelect.addEventListener('change', function() {
        updateFullAddressPreview();
    });

    // Pencarian kata kunci otomatis
    searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        if (query.length < 2) {
            searchResults.classList.add('hidden');
            searchResults.innerHTML = '';
            return;
        }

        const matches = [];
        for (const [kec, desas] of Object.entries(wilayahData)) {
            // Cek jika kecamatan cocok
            if (kec.toLowerCase().includes(query)) {
                matches.push({ type: 'kecamatan', kec: kec, text: `Kecamatan ${kec}, Kab. Wonogiri, Jawa Tengah` });
            }
            // Cek jika desa cocok
            for (const desa of desas) {
                if (desa.toLowerCase().includes(query)) {
                    matches.push({ type: 'desa', kec: kec, desa: desa, text: `Desa ${desa}, Kec. ${kec}, Kab. Wonogiri, Jawa Tengah` });
                }
            }
        }

        if (matches.length === 0) {
            searchResults.innerHTML = '<div class="p-3 text-xs text-slate-400 italic">Tidak ada wilayah Wonogiri yang cocok</div>';
            searchResults.classList.remove('hidden');
            return;
        }

        searchResults.innerHTML = '';
        matches.slice(0, 10).forEach(item => {
            const div = document.createElement('div');
            div.className = 'p-2.5 text-xs text-slate-700 hover:bg-red-50 hover:text-[#801414] cursor-pointer font-medium transition-colors flex items-center justify-between';
            div.innerHTML = `<span>${item.text}</span><span class="text-[10px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-500 uppercase">${item.type}</span>`;
            div.addEventListener('click', function() {
                districtSelect.value = item.kec;
                populateVillages(item.kec);
                if (item.desa) {
                    villageSelect.value = item.desa;
                }
                searchInput.value = item.text;
                searchResults.classList.add('hidden');
                updateFullAddressPreview();
            });
            searchResults.appendChild(div);
        });

        searchResults.classList.remove('hidden');
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });

    function previewStoreImage(input) {
        const fileNameDisplay = document.getElementById('file-name-display');
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (fileNameDisplay) {
                fileNameDisplay.textContent = file.name;
                fileNameDisplay.classList.remove('italic', 'text-slate-500');
                fileNameDisplay.classList.add('font-semibold', 'text-slate-800');
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('image-preview');
                const defaultAvatar = document.getElementById('default-avatar');
                if (previewImg) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                }
                if (defaultAvatar) {
                    defaultAvatar.classList.add('hidden');
                }
            }
            reader.readAsDataURL(file);
        }
    }

    // Live Validator & Notifikasi Digit Kurang
    (function setupLiveValidation() {
        const form = document.getElementById('form-create-store');
        if (!form) return;

        const nibInput = document.getElementById('create-nib-input');
        const pirtInput = document.getElementById('create-pirt-input');
        const halalInput = document.getElementById('create-halal-input');
        const phoneInput = document.getElementById('create-phone-input');
        const postalInput = document.getElementById('postal-input');

        const nibFb = document.getElementById('create-nib-feedback');
        const pirtFb = document.getElementById('create-pirt-feedback');
        const halalFb = document.getElementById('create-halal-feedback');
        const phoneFb = document.getElementById('create-phone-feedback');
        const postalFb = document.getElementById('create-postal-feedback');
        const alertBox = document.getElementById('create-alert-box');
        const alertMsg = document.getElementById('create-alert-message');

        function checkNib() {
            if (!nibInput || !nibFb) return true;
            const val = nibInput.value.trim();
            if (!val) { nibFb.innerHTML = ''; nibInput.classList.remove('border-red-500', 'border-emerald-500'); return true; }
            if (val.length < 13) {
                const sisa = 13 - val.length;
                nibFb.innerHTML = `<span class="text-red-500 font-medium">⚠️ Kurang ${sisa} digit lagi (saat ini ${val.length} digit, wajib 13 digit)</span>`;
                nibInput.classList.add('border-red-500'); nibInput.classList.remove('border-emerald-500');
                return false;
            } else {
                nibFb.innerHTML = `<span class="text-emerald-600 font-semibold">✓ Nomor NIB lengkap sesuai standar (13 digit)</span>`;
                nibInput.classList.remove('border-red-500'); nibInput.classList.add('border-emerald-500');
                return true;
            }
        }

        function checkPirt() {
            if (!pirtInput || !pirtFb) return true;
            const val = pirtInput.value.trim();
            if (!val) { pirtFb.innerHTML = ''; pirtInput.classList.remove('border-red-500', 'border-emerald-500'); return true; }
            if (val.length < 15) {
                const sisa = 15 - val.length;
                pirtFb.innerHTML = `<span class="text-red-500 font-medium">⚠️ Kurang ${sisa} digit lagi (saat ini ${val.length} digit, minimal 15 digit)</span>`;
                pirtInput.classList.add('border-red-500'); pirtInput.classList.remove('border-emerald-500');
                return false;
            } else {
                pirtFb.innerHTML = `<span class="text-emerald-600 font-semibold">✓ Nomor PIRT memenuhi jumlah minimal (15 digit)</span>`;
                pirtInput.classList.remove('border-red-500'); pirtInput.classList.add('border-emerald-500');
                return true;
            }
        }

        function checkHalal() {
            if (!halalInput || !halalFb) return true;
            const val = halalInput.value.trim();
            if (!val) { halalFb.innerHTML = ''; halalInput.classList.remove('border-red-500', 'border-emerald-500'); return true; }
            if (val.length < 10) {
                const sisa = 10 - val.length;
                halalFb.innerHTML = `<span class="text-red-500 font-medium">⚠️ Kurang ${sisa} karakter lagi (saat ini ${val.length} karakter, minimal 10 karakter)</span>`;
                halalInput.classList.add('border-red-500'); halalInput.classList.remove('border-emerald-500');
                return false;
            } else {
                halalFb.innerHTML = `<span class="text-emerald-600 font-semibold">✓ Nomor Sertifikasi Halal memenuhi jumlah minimal</span>`;
                halalInput.classList.remove('border-red-500'); halalInput.classList.add('border-emerald-500');
                return true;
            }
        }

        function checkPhone() {
            if (!phoneInput || !phoneFb) return true;
            const val = phoneInput.value.trim();
            if (!val) {
                phoneFb.innerHTML = `<span class="text-red-500 font-medium">⚠️ Nomor kontak / WhatsApp wajib diisi</span>`;
                phoneInput.classList.add('border-red-500'); phoneInput.classList.remove('border-emerald-500');
                return false;
            }
            if (val.length < 10) {
                const sisa = 10 - val.length;
                phoneFb.innerHTML = `<span class="text-red-500 font-medium">⚠️ Kurang ${sisa} digit lagi (saat ini ${val.length} digit, minimal 10 digit)</span>`;
                phoneInput.classList.add('border-red-500'); phoneInput.classList.remove('border-emerald-500');
                return false;
            } else {
                phoneFb.innerHTML = `<span class="text-emerald-600 font-semibold">✓ Nomor kontak valid</span>`;
                phoneInput.classList.remove('border-red-500'); phoneInput.classList.add('border-emerald-500');
                return true;
            }
        }

        function checkPostal() {
            if (!postalInput || !postalFb) return true;
            const val = postalInput.value.trim();
            if (!val) { postalFb.innerHTML = ''; postalInput.classList.remove('border-red-500', 'border-emerald-500'); return true; }
            if (val.length < 5) {
                const sisa = 5 - val.length;
                postalFb.innerHTML = `<span class="text-red-500 font-medium">⚠️ Kurang ${sisa} digit lagi (saat ini ${val.length} digit, wajib 5 digit)</span>`;
                postalInput.classList.add('border-red-500'); postalInput.classList.remove('border-emerald-500');
                return false;
            } else {
                postalFb.innerHTML = `<span class="text-emerald-600 font-semibold">✓ Kode pos valid (5 digit)</span>`;
                postalInput.classList.remove('border-red-500'); postalInput.classList.add('border-emerald-500');
                return true;
            }
        }

        if (nibInput) { nibInput.addEventListener('input', checkNib); checkNib(); }
        if (pirtInput) { pirtInput.addEventListener('input', checkPirt); checkPirt(); }
        if (halalInput) { halalInput.addEventListener('input', checkHalal); checkHalal(); }
        if (phoneInput) { phoneInput.addEventListener('input', checkPhone); checkPhone(); }
        if (postalInput) { postalInput.addEventListener('input', checkPostal); checkPostal(); }

        form.addEventListener('submit', function(e) {
            const vNib = checkNib();
            const vPirt = checkPirt();
            const vHalal = checkHalal();
            const vPhone = checkPhone();
            const vPostal = checkPostal();

            if (!vNib || !vPirt || !vHalal || !vPhone || !vPostal) {
                e.preventDefault();
                let errors = [];
                if (!vPhone) errors.push('Nomor Kontak / WhatsApp minimal 10 digit (saat ini: ' + (phoneInput ? phoneInput.value.trim().length : 0) + ' digit)');
                if (!vNib) errors.push('Nomor Induk Berusaha (NIB) harus tepat 13 digit angka (saat ini: ' + (nibInput ? nibInput.value.trim().length : 0) + ' digit)');
                if (!vPirt) errors.push('Nomor Sertifikasi PIRT minimal 15 digit (saat ini: ' + (pirtInput ? pirtInput.value.trim().length : 0) + ' digit)');
                if (!vHalal) errors.push('Nomor Sertifikasi Halal minimal 10 karakter (saat ini: ' + (halalInput ? halalInput.value.trim().length : 0) + ' karakter)');
                if (!vPostal) errors.push('Kode Pos harus tepat 5 digit angka (saat ini: ' + (postalInput ? postalInput.value.trim().length : 0) + ' digit)');

                if (alertBox && alertMsg) {
                    alertMsg.innerHTML = errors.map(err => `<div>• ${err}</div>`).join('');
                    alertBox.classList.remove('hidden');
                    alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }

                alert("⚠️ JUMLAH DIGIT NOMOR BELUM LENGKAP:\n\n• " + errors.join("\n• ") + "\n\nSilakan periksa dan lengkapi digit nomor sebelum mengirim pendaftaran.");

                if (!vPhone && phoneInput) phoneInput.focus();
                else if (!vNib && nibInput) nibInput.focus();
                else if (!vPirt && pirtInput) pirtInput.focus();
                else if (!vHalal && halalInput) halalInput.focus();
                else if (!vPostal && postalInput) postalInput.focus();
            } else {
                if (alertBox) alertBox.classList.add('hidden');
            }
        });
    })();
</script>
@endsection
