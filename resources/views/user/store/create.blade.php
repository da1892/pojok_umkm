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

            <form action="{{ route('toko.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Informasi Pokok UMKM -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-1.5">Nama UMKM / Usaha <span class="text-red-500">*</span></label>
                        <input type="text" name="business_name" value="{{ old('business_name') }}" required class="w-full rounded-xl border-slate-300 shadow-xs focus:border-[#801414] focus:ring-[#801414]" placeholder="Contoh: Keripik Berkah Barokah">
                        <p class="text-[11px] text-slate-400 mt-1">Nama resmi toko/brand UMKM Anda</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-1.5">Nama Pemilik <span class="text-red-500">*</span></label>
                        <input type="text" name="owner_name" value="{{ old('owner_name') }}" required class="w-full rounded-xl border-slate-300 shadow-xs focus:border-[#801414] focus:ring-[#801414]" placeholder="Contoh: Budi Santoso">
                        <p class="text-[11px] text-slate-400 mt-1">Nama lengkap pemilik usaha</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-1.5">Nomor Kontak / WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full rounded-xl border-slate-300 shadow-xs focus:border-[#801414] focus:ring-[#801414]" placeholder="Contoh: 08123456789">
                    <p class="text-[11px] text-slate-400 mt-1">Digunakan oleh calon pembeli dan admin untuk menghubungi Anda</p>
                </div>

                <!-- Bagian Wilayah & Alamat Lengkap Dari Provinsi sampai Desa -->
                <div class="p-6 rounded-2xl bg-slate-50/90 border border-slate-200 space-y-5">
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
                            <input type="text" id="keyword-search" autocomplete="off" placeholder="Ketik kata kunci desa / kecamatan (contoh: Girimarto, Wonokarto, Baturetno, Selogiri...)" class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-300 text-sm focus:border-[#801414] focus:ring-[#801414] bg-white">
                            <div id="search-results" class="hidden absolute left-0 right-0 top-full mt-1.5 max-h-56 overflow-y-auto bg-white rounded-xl shadow-xl border border-slate-200 z-50 divide-y divide-slate-100"></div>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Pilih dari hasil pencarian otomatis untuk mengisi Kecamatan dan Desa seketika.</p>
                    </div>

                    <!-- Wilayah Administratif Bertingkat (Provinsi, Kabupaten, Kecamatan, Desa) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Provinsi <span class="text-red-500">*</span></label>
                            <input type="text" name="province" id="province-input" value="{{ old('province', 'Jawa Tengah') }}" readonly class="w-full rounded-xl border-slate-200 bg-slate-100/80 text-slate-700 text-sm font-semibold cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kabupaten / Kota <span class="text-red-500">*</span></label>
                            <input type="text" name="regency" id="regency-input" value="{{ old('regency', 'Kabupaten Wonogiri') }}" readonly class="w-full rounded-xl border-slate-200 bg-slate-100/80 text-slate-700 text-sm font-semibold cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                            <select id="district-select" name="district" required class="w-full rounded-xl border-slate-300 text-sm shadow-xs focus:border-[#801414] focus:ring-[#801414] bg-white">
                                <option value="">-- Pilih Kecamatan --</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Desa / Kelurahan <span class="text-red-500">*</span></label>
                            <select id="village-select" name="village" required class="w-full rounded-xl border-slate-300 text-sm shadow-xs focus:border-[#801414] focus:ring-[#801414] bg-white">
                                <option value="">-- Pilih Desa / Kelurahan --</option>
                            </select>
                        </div>
                    </div>

                    <!-- Alamat Rinci & Kode Pos -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Spesifik (Jalan, RT/RW, Dusun, Patokan Lokasi) <span class="text-red-500">*</span></label>
                            <input type="text" id="address-input" name="address" required value="{{ old('address') }}" class="w-full rounded-xl border-slate-300 text-sm shadow-xs focus:border-[#801414] focus:ring-[#801414] bg-white" placeholder="Contoh: Jl. Diponegoro No. 12, RT 02 / RW 04, Dusun Jatirejo">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kode Pos <span class="text-slate-400 font-normal">(Opsional)</span></label>
                            <input type="text" id="postal-input" name="postal_code" value="{{ old('postal_code') }}" maxlength="10" class="w-full rounded-xl border-slate-300 text-sm shadow-xs focus:border-[#801414] focus:ring-[#801414] bg-white" placeholder="Contoh: 57615">
                        </div>
                    </div>

                    <!-- Pratinjau Alamat Lengkap Realtime -->
                    <div class="p-3.5 rounded-xl bg-white border border-red-100 shadow-xs">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#801414] block mb-1">Format Teks Alamat Lengkap:</span>
                        <p id="full-address-preview" class="text-xs text-slate-700 font-medium italic">
                            (Isi data wilayah dan alamat spesifik di atas untuk melihat format alamat lengkap)
                        </p>
                    </div>
                </div>

                <!-- Legalitas & Sertifikasi Usaha -->
                <div>
                    <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider mb-3">Legalitas & Sertifikasi (Opsional)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Induk Berusaha (NIB)</label>
                            <input type="text" name="nib" value="{{ old('nib') }}" class="w-full rounded-xl border-slate-300 text-sm shadow-xs focus:border-[#801414] focus:ring-[#801414]" placeholder="Opsional">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Sertifikasi PIRT</label>
                            <input type="text" name="pirt" value="{{ old('pirt') }}" class="w-full rounded-xl border-slate-300 text-sm shadow-xs focus:border-[#801414] focus:ring-[#801414]" placeholder="Opsional">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Sertifikasi Halal</label>
                            <input type="text" name="halal_cert" value="{{ old('halal_cert') }}" class="w-full rounded-xl border-slate-300 text-sm shadow-xs focus:border-[#801414] focus:ring-[#801414]" placeholder="Opsional">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-1">Deskripsi Singkat Usaha</label>
                    <textarea name="description" rows="3" class="w-full rounded-xl border-slate-300 shadow-xs focus:border-[#801414] focus:ring-[#801414]" placeholder="Jelaskan jenis produk, kapasitas produksi, atau keunggulan UMKM Anda...">{{ old('description') }}</textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('toko.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="bg-[#801414] hover:bg-red-900 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md hover:shadow-lg flex items-center gap-2">
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
</script>
@endsection
