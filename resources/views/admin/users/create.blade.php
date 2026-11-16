@extends('layouts.admin')

@section('page_title', 'Buat Akun Pelaku UMKM Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Back & Title -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-[#800000] transition-colors mb-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Manajemen User</span>
            </a>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Buat Akun Pelaku UMKM Baru</h2>
            <p class="text-xs sm:text-sm text-slate-500">Admin dinas dapat membuatkan akun login resmi, profil toko UMKM, dan langsung menambahkan produknya.</p>
        </div>
    </div>

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
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden p-6 sm:p-8">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- ============================================== -->
            <!-- SECTION 1: AKUN PENGGUNA (USER LOGIN) -->
            <!-- ============================================== -->
            <div class="space-y-4">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                    <span class="w-7 h-7 rounded-xl bg-red-100 text-[#800000] font-black flex items-center justify-center text-xs">1</span>
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Data Akun Login Pemilik</h3>
                        <p class="text-[11px] text-slate-400">Digunakan oleh pelaku UMKM untuk login ke website Pojok UMKM.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Pemilik -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap Pemilik <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="owner_name_input" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso" onblur="this.value = this.value.trim().replace(/\b\w/g, l => l.toUpperCase())" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none transition-all">
                        @error('name')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700">Alamat Email Login <span class="text-red-500">*</span></label>
                            <button type="button" onclick="suggestEmail()" class="text-[10px] font-bold text-blue-600 hover:text-blue-800 underline">
                                Buat Otomatis
                            </button>
                        </div>
                        <input type="email" name="email" id="email_input" value="{{ old('email') }}" required placeholder="Contoh: budi.santoso@gmail.com" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none transition-all">
                        @error('email')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700">Kata Sandi Akun <span class="text-red-500">*</span></label>
                            <button type="button" onclick="generateRandomPass()" class="text-[10px] font-bold text-amber-700 hover:text-amber-900 bg-amber-100 hover:bg-amber-200 px-2 py-0.5 rounded-md transition-colors">
                                ⚡ Acak Sandi
                            </button>
                        </div>
                        <div class="relative">
                            <input type="text" name="password" id="password_input" value="{{ old('password', 'PojokUmkm2026!') }}" required minlength="6" class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none transition-all">
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600" title="Tampilkan / Sembunyikan">
                                <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        @error('password')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jenis Kelamin Pemilik</label>
                        <select name="gender" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none cursor-pointer">
                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- SECTION 2: IDENTITAS TOKO / UMKM -->
            <!-- ============================================== -->
            <div class="space-y-4">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                    <span class="w-7 h-7 rounded-xl bg-amber-100 text-amber-800 font-black flex items-center justify-center text-xs">2</span>
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Profil Toko / Usaha UMKM</h3>
                        <p class="text-[11px] text-slate-400">Informasi usaha yang akan ditampilkan pada direktori UMKM Wonogiri.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Usaha -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Usaha / Merek Dagang <span class="text-red-500">*</span></label>
                        <input type="text" name="business_name" id="business_name_input" value="{{ old('business_name') }}" required placeholder="Contoh: Keripik Singkong Barokah" onblur="this.value = this.value.trim().replace(/\b\w/g, l => l.toUpperCase())" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none transition-all">
                        @error('business_name')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <!-- No WhatsApp / Telepon -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">No. WhatsApp / Telepon Usaha <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none transition-all">
                        @error('phone')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <!-- Foto Toko -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Tempat Usaha / Logo Toko (Opsional)</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-[#800000] hover:file:bg-red-100 cursor-pointer border border-slate-200 rounded-xl bg-slate-50 p-1.5">
                        <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maksimal 3MB.</p>
                    </div>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- SECTION 3: WILAYAH & LOKASI DI WONOGIRI -->
            <!-- ============================================== -->
            <div class="space-y-4">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                    <span class="w-7 h-7 rounded-xl bg-blue-100 text-blue-800 font-black flex items-center justify-center text-xs">3</span>
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Wilayah & Alamat Produksi di Wonogiri</h3>
                        <p class="text-[11px] text-slate-400">Pilih kecamatan dan desa sesuai lokasi usaha di Kabupaten Wonogiri.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Kecamatan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kecamatan di Wonogiri <span class="text-red-500">*</span></label>
                        <select name="district" id="district_select" required onchange="updateVillages()" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none cursor-pointer">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($districts as $distName => $vList)
                            <option value="{{ $distName }}" {{ old('district') == $distName ? 'selected' : '' }}>{{ $distName }}</option>
                            @endforeach
                        </select>
                        @error('district')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <!-- Desa -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Desa / Kelurahan <span class="text-red-500">*</span></label>
                        <select name="village" id="village_select" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none cursor-pointer">
                            <option value="">-- Pilih Kecamatan Terlebih Dahulu --</option>
                        </select>
                        @error('village')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Lengkap / Patokan Tempat Usaha <span class="text-red-500">*</span></label>
                        <textarea name="address" rows="2" required placeholder="Contoh: Jl. Ahmad Yani No. 12, RT 02 / RW 04 (Dekat Kantor Balai Desa)" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none transition-all">{{ old('address') }}</textarea>
                        @error('address')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- SECTION 4: LEGALITAS & DESKRIPSI (OPSIONAL) -->
            <!-- ============================================== -->
            <div class="space-y-4">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                    <span class="w-7 h-7 rounded-xl bg-slate-100 text-slate-700 font-black flex items-center justify-center text-xs">4</span>
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Legalitas & Deskripsi Usaha (Opsional)</h3>
                        <p class="text-[11px] text-slate-400">Dapat dilengkapi nanti bila pelaku usaha belum memiliki perizinan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Induk Berusaha (NIB)</label>
                        <input type="text" name="nib" value="{{ old('nib') }}" placeholder="13 Digit NIB" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">P-IRT (Izin Edar Makanan)</label>
                        <input type="text" name="pirt" value="{{ old('pirt') }}" placeholder="Contoh: P-IRT 20633..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Sertifikat Halal (BPJPH)</label>
                        <input type="text" name="halal_cert" value="{{ old('halal_cert') }}" placeholder="Contoh: ID3311000..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi / Cerita Singkat Usaha</label>
                        <textarea name="description" rows="3" placeholder="Ceritakan sejarah singkat, keunggulan produk, atau komitmen usaha..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="w-full sm:w-auto px-5 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors text-center cursor-pointer">
                    Batal
                </a>

                <!-- Opsi 1: Simpan Saja -->
                <button type="submit" name="action" value="save_only" class="w-full sm:w-auto px-5 py-2.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded-xl transition-colors cursor-pointer">
                    Simpan Akun UMKM
                </button>

                <!-- Opsi 2: Simpan & Lanjut Tambah Produk (Rekomendasi) -->
                <button type="submit" name="action" value="save_and_add_product" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 text-xs font-bold text-white bg-gradient-to-r from-[#800000] to-red-700 hover:from-[#600000] hover:to-[#800000] rounded-xl shadow-md transition-all cursor-pointer">
                    <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Simpan & Langsung Tambah Produk</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const wonogiriWilayah = @json($districts);
const oldVillage = "{{ old('village') }}";

function updateVillages() {
    const districtSelect = document.getElementById('district_select');
    const villageSelect = document.getElementById('village_select');
    const selectedDistrict = districtSelect.value;

    villageSelect.innerHTML = '<option value="">-- Pilih Desa / Kelurahan --</option>';

    if (selectedDistrict && wonogiriWilayah[selectedDistrict]) {
        const villages = wonogiriWilayah[selectedDistrict];
        villages.forEach(function(v) {
            const opt = document.createElement('option');
            opt.value = v;
            opt.textContent = v;
            if (oldVillage && oldVillage === v) {
                opt.selected = true;
            }
            villageSelect.appendChild(opt);
        });
    }
}

// Inisialisasi desa saat halaman pertama kali load (termasuk bila ada old value)
document.addEventListener('DOMContentLoaded', function() {
    const districtSelect = document.getElementById('district_select');
    if (districtSelect.value) {
        updateVillages();
    }
});

function togglePasswordVisibility() {
    const input = document.getElementById('password_input');
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}

function generateRandomPass() {
    const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789!@#';
    let pass = 'Pojok';
    for (let i = 0; i < 4; i++) {
        pass += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    pass += '!2026';
    document.getElementById('password_input').value = pass;
    document.getElementById('password_input').type = 'text';
}

function suggestEmail() {
    const businessName = document.getElementById('business_name_input').value.trim();
    const ownerName = document.getElementById('owner_name_input').value.trim();
    let base = businessName || ownerName;
    if (!base) {
        alert('Silakan ketik Nama Usaha atau Nama Pemilik terlebih dahulu.');
        return;
    }
    // Buat slug
    let slug = base.toLowerCase().replace(/[^a-z0-9]/g, '');
    let randomNum = Math.floor(10 + Math.random() * 90);
    document.getElementById('email_input').value = slug + randomNum + '@pojokumkm.id';
}
</script>
@endsection

