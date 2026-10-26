@extends('layouts.admin')

@section('page_title', 'Edit Profil UMKM')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-200 flex items-center justify-between">
        <div>
            <h3 class="font-bold text-slate-800 text-lg">Edit Profil UMKM</h3>
            <p class="text-slate-500 text-sm mt-1">Lengkapi atau perbaiki data profil UMKM ini.</p>
        </div>
        <a href="{{ route('admin.umkm.show', $umkm->id) }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800">
            &larr; Kembali
        </a>
    </div>
    
    <div class="p-6">
        <form id="form-admin-umkm-edit" action="{{ route('admin.umkm.update', $umkm->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Notifikasi Peringatan Jika Digit Kurang -->
            <div id="admin-alert-box" class="hidden mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div class="flex-1">
                        <h4 class="font-bold text-red-800 mb-1">Jumlah Digit Nomor Belum Lengkap</h4>
                        <div id="admin-alert-message" class="text-xs space-y-1"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Data Pemilik -->
                <div class="md:col-span-2">
                    <h4 class="font-bold text-slate-700 border-b border-slate-100 pb-2 mb-4">Informasi Utama</h4>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Nama UMKM <span class="text-red-500">*</span></label>
                    <input type="text" name="business_name" value="{{ old('business_name', $umkm->business_name) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-slate-900 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all" required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Nama Pemilik <span class="text-red-500">*</span></label>
                    <input type="text" name="owner_name" value="{{ old('owner_name', $umkm->owner_name) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-slate-900 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all" required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">
                        Nomor HP / WhatsApp <span class="text-red-500">*</span>
                        <span class="text-xs text-slate-400 font-normal ml-1">(Min. 10 Digit)</span>
                    </label>
                    <input type="tel" name="phone" id="admin-phone-input" value="{{ old('phone', $umkm->phone) }}" minlength="10" maxlength="15" pattern="[0-9]{10,15}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000] @error('phone') border-red-500 @enderror" required>
                    <div id="admin-phone-feedback" class="mt-1 text-xs"></div>
                    @error('phone')
                        <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Status Akun UMKM</label>
                    <select name="status" class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-slate-900 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all">
                        <option value="pending" {{ old('status', $umkm->status) == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                        <option value="verified" {{ old('status', $umkm->status) == 'verified' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ old('status', $umkm->status) == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Wilayah & Alamat Lengkap Dari Provinsi sampai Desa -->
                <div class="md:col-span-2 bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-red-100 text-[#800000] flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </span>
                            <div>
                                <label class="block text-sm font-bold text-slate-800">Alamat & Lokasi UMKM Lengkap</label>
                                <span class="text-[11px] text-slate-500">Struktur berjenjang dari Provinsi, Kabupaten, Kecamatan hingga Desa/Kelurahan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Pencarian Cepat Wilayah -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pencarian Cepat Wilayah (Ketik nama Desa atau Kecamatan):</label>
                        <div class="relative">
                            <input type="text" id="wilayah_search" placeholder="Ketik kata kunci desa / kecamatan (contoh: Girimarto, Wonokarto, Selogiri...)" autocomplete="off"
                                   class="w-full pl-10 pr-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <div id="search_results" class="hidden absolute z-30 left-0 right-0 mt-1 max-h-48 overflow-y-auto bg-white border border-slate-200 rounded-lg shadow-lg"></div>
                        </div>
                    </div>

                    <!-- Wilayah Administratif Bertingkat -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Provinsi <span class="text-red-500">*</span></label>
                            <input type="text" name="province" id="province_input" value="{{ old('province', $umkm->province ?? 'Jawa Tengah') }}" readonly class="w-full px-4 py-3 bg-slate-100 border-2 border-slate-300 rounded-xl text-sm font-medium text-slate-700 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Kabupaten / Kota <span class="text-red-500">*</span></label>
                            <input type="text" name="regency" id="regency_input" value="{{ old('regency', $umkm->regency ?? 'Kabupaten Wonogiri') }}" readonly class="w-full px-4 py-3 bg-slate-100 border-2 border-slate-300 rounded-xl text-sm font-medium text-slate-700 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                            <select id="district_select" name="district" required class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-sm text-slate-900 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all">
                                <option value="">-- Pilih Kecamatan --</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Desa / Kelurahan <span class="text-red-500">*</span></label>
                            <select id="village_select" name="village" required class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-sm text-slate-900 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all">
                                <option value="">-- Pilih Desa / Kelurahan --</option>
                            </select>
                        </div>
                    </div>

                    <!-- Alamat Spesifik & Kode Pos -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-3">
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Lengkap Produksi (Jalan, RT/RW, Dusun) <span class="text-red-500">*</span></label>
                            <textarea id="address_input" name="address" rows="2" class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-slate-900 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all" required>{{ old('address', $umkm->address) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                Kode Pos
                                <span class="text-[10px] text-slate-400 font-normal ml-1">(5 Digit)</span>
                            </label>
                            <input type="text" id="postal_code_input" name="postal_code" value="{{ old('postal_code', $umkm->postal_code) }}" minlength="5" maxlength="5" pattern="[0-9]{5}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Contoh: 57615" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-[#800000] focus:border-[#800000] @error('postal_code') border-red-500 @enderror">
                            <div id="admin-postal-feedback" class="mt-1 text-xs"></div>
                            @error('postal_code')
                                <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Pratinjau Alamat Lengkap Realtime -->
                    <div class="p-3 rounded-xl bg-white border border-slate-200">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#800000] block mb-0.5">Format Teks Alamat Lengkap:</span>
                        <p id="full_address_preview" class="text-xs text-slate-700 font-medium">
                            {{ $umkm->full_address ?? '(Belum ada alamat)' }}
                        </p>
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Deskripsi Singkat UMKM</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-slate-900 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all">{{ old('description', $umkm->description) }}</textarea>
                </div>
                
                <!-- Legalitas -->
                <div class="md:col-span-2 mt-4">
                    <h4 class="font-bold text-slate-700 border-b border-slate-100 pb-2 mb-4">Legalitas & Sertifikasi (Opsional)</h4>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1">
                        Nomor Induk Berusaha (NIB)
                        <span class="text-xs text-slate-400 font-normal ml-1">(13 Digit)</span>
                    </label>
                    <input type="text" 
                           name="nib" 
                           id="admin-nib-input"
                           value="{{ old('nib', $umkm->nib) }}" 
                           minlength="13" 
                           maxlength="13" 
                           pattern="[0-9]{13}" 
                           inputmode="numeric" 
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                           placeholder="Contoh: 9120003216549" 
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000] @error('nib') border-red-500 @enderror">
                    <div id="admin-nib-feedback" class="mt-1 text-xs"></div>
                    @error('nib')
                        <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1">
                        Sertifikasi PIRT
                        <span class="text-xs text-slate-400 font-normal ml-1">(15 Digit)</span>
                    </label>
                    <input type="text" 
                           name="pirt" 
                           id="admin-pirt-input"
                           value="{{ old('pirt', $umkm->pirt) }}" 
                           minlength="15" 
                           maxlength="35" 
                           placeholder="Contoh: 215331201014526 atau P-IRT 2153312010145-26" 
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000] @error('pirt') border-red-500 @enderror">
                    <div id="admin-pirt-feedback" class="mt-1 text-xs"></div>
                    @error('pirt')
                        <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1">
                        Sertifikasi Halal
                        <span class="text-xs text-slate-400 font-normal ml-1">(BPJPH / MUI)</span>
                    </label>
                    <input type="text" 
                           name="halal_cert" 
                           id="admin-halal-input"
                           value="{{ old('halal_cert', $umkm->halal_cert) }}" 
                           minlength="10" 
                           maxlength="35" 
                           placeholder="Contoh: ID33110000789010323" 
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000] @error('halal_cert') border-red-500 @enderror">
                    <div id="admin-halal-feedback" class="mt-1 text-xs"></div>
                    @error('halal_cert')
                        <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2 pt-4 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-[#800000] text-white font-bold rounded-lg hover:bg-red-900 transition-colors shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let wilayahData = {};
    const initialDistrict = "{{ old('district', $umkm->district) }}";
    const initialVillage = "{{ old('village', $umkm->village) }}";
    
    const districtSelect = document.getElementById('district_select');
    const villageSelect = document.getElementById('village_select');
    const addressInput = document.getElementById('address_input');
    const postalInput = document.getElementById('postal_code_input');
    const previewEl = document.getElementById('full_address_preview');
    const searchInput = document.getElementById('wilayah_search');
    const searchResults = document.getElementById('search_results');

    function updatePreview() {
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

        if (parts.length > 0) {
            previewEl.textContent = parts.join(', ');
        }
    }

    if (addressInput) addressInput.addEventListener('input', updatePreview);
    if (postalInput) postalInput.addEventListener('input', updatePreview);

    fetch('/wonogiri_wilayah.json')
        .then(res => res.json())
        .then(data => {
            wilayahData = data;
            populateDistricts(initialDistrict);
            if (initialDistrict) {
                populateVillages(initialDistrict, initialVillage);
            }
            updatePreview();
        })
        .catch(err => console.error('Error load wilayah wonogiri:', err));

    function populateDistricts(selected) {
        districtSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
        Object.keys(wilayahData).sort().forEach(kec => {
            const opt = document.createElement('option');
            opt.value = kec;
            opt.textContent = 'Kec. ' + kec;
            if (selected && selected.toLowerCase() === kec.toLowerCase()) {
                opt.selected = true;
            }
            districtSelect.appendChild(opt);
        });
    }

    function populateVillages(districtName, selectedVillage) {
        villageSelect.innerHTML = '<option value="">-- Pilih Desa / Kelurahan --</option>';
        if (!districtName || !wilayahData[districtName]) return;

        wilayahData[districtName].sort().forEach(v => {
            const opt = document.createElement('option');
            opt.value = v;
            opt.textContent = `Desa/Kel. ${v}`;
            if (selectedVillage && selectedVillage.toLowerCase() === v.toLowerCase()) {
                opt.selected = true;
            }
            villageSelect.appendChild(opt);
        });
        updatePreview();
    }

    districtSelect.addEventListener('change', function() {
        populateVillages(this.value, null);
        updatePreview();
    });

    villageSelect.addEventListener('change', function() {
        updatePreview();
    });

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const val = this.value.trim().toLowerCase();
            if (!val || val.length < 2) {
                searchResults.classList.add('hidden');
                searchResults.innerHTML = '';
                return;
            }

            const matches = [];
            for (const [kec, desas] of Object.entries(wilayahData)) {
                if (kec.toLowerCase().includes(val)) {
                    matches.push({ district: kec, village: null, label: `Kecamatan ${kec}, Kab. Wonogiri, Jawa Tengah` });
                }
                for (const desa of desas) {
                    if (desa.toLowerCase().includes(val)) {
                        matches.push({ district: kec, village: desa, label: `Desa ${desa}, Kec. ${kec}, Kab. Wonogiri, Jawa Tengah` });
                    }
                }
            }

            if (matches.length === 0) {
                searchResults.innerHTML = '<div class="px-3 py-2 text-xs text-slate-400 italic">Tidak ada wilayah Wonogiri yang cocok</div>';
                searchResults.classList.remove('hidden');
                return;
            }

            searchResults.innerHTML = '';
            matches.slice(0, 10).forEach(m => {
                const item = document.createElement('div');
                item.className = 'px-3 py-2 text-xs text-slate-700 hover:bg-red-50 hover:text-[#800000] cursor-pointer border-b border-slate-50 last:border-b-0 flex items-center justify-between font-medium';
                item.innerHTML = `<span>${m.label}</span><span class="text-[10px] text-slate-400">Pilih</span>`;
                item.addEventListener('click', () => {
                    districtSelect.value = m.district;
                    populateVillages(m.district, m.village);
                    if (m.village) {
                        villageSelect.value = m.village;
                    }
                    searchResults.classList.add('hidden');
                    searchInput.value = m.label;
                    updatePreview();
                });
                searchResults.appendChild(item);
            });
            searchResults.classList.remove('hidden');
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
    }

    // Live Validator & Notifikasi Digit Kurang
    (function setupLiveValidation() {
        const form = document.getElementById('form-admin-umkm-edit');
        if (!form) return;

        const nibInput = document.getElementById('admin-nib-input');
        const pirtInput = document.getElementById('admin-pirt-input');
        const halalInput = document.getElementById('admin-halal-input');
        const phoneInput = document.getElementById('admin-phone-input');
        const postalInput = document.getElementById('postal_code_input');

        const nibFb = document.getElementById('admin-nib-feedback');
        const pirtFb = document.getElementById('admin-pirt-feedback');
        const halalFb = document.getElementById('admin-halal-feedback');
        const phoneFb = document.getElementById('admin-phone-feedback');
        const postalFb = document.getElementById('admin-postal-feedback');
        const alertBox = document.getElementById('admin-alert-box');
        const alertMsg = document.getElementById('admin-alert-message');

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

                alert("⚠️ JUMLAH DIGIT NOMOR BELUM LENGKAP:\n\n• " + errors.join("\n• ") + "\n\nSilakan periksa dan lengkapi digit nomor sebelum menyimpan perubahan.");

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
});
</script>
@endsection
