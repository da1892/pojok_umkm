@extends('layouts.admin')

@section('page_title', 'Tambah UMKM Binaan Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Back button & Title -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.binaan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-[#800000] transition-colors mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar Binaan</span>
            </a>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Tambah UMKM Binaan Baru</h2>
            <p class="text-xs sm:text-sm text-slate-500">Daftarkan pelaku usaha mikro Wonogiri yang belum memiliki gawai atau akun mandiri.</p>
        </div>
    </div>

    <!-- Info Box: Kebijakan Binaan Dinas -->
    <div class="bg-amber-50/80 border border-amber-300/80 rounded-2xl p-4 sm:p-5 text-amber-950 text-xs flex items-start gap-3.5 shadow-2xs">
        <div class="w-9 h-9 rounded-xl bg-amber-200 text-amber-800 flex items-center justify-center shrink-0 font-bold">
            <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="space-y-1">
            <h4 class="font-extrabold text-amber-950 text-sm">Prinsip UMKM Binaan Tanpa Device / Email:</h4>
            <p class="text-amber-900 leading-relaxed">
                Anda tidak perlu menginput email atau kata sandi pemilik usaha. Profil UMKM ini akan langsung aktif berstatus <strong>Terverifikasi</strong> dan produknya siap dipromosikan ke masyarakat. Bila suatu saat pemilik telah memiliki perangkat pribadi, kepemilikan toko dapat diserahkan dengan fitur <em>Hubungkan Akun</em>.
            </p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden p-6 sm:p-8">
        <form action="{{ route('admin.binaan.umkm.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Identitas Usaha -->
            <div class="space-y-4">
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-red-100 text-[#800000] flex items-center justify-center text-xs">1</span>
                    Identitas Usaha & Pemilik
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Usaha / Merek Dagang <span class="text-red-500">*</span></label>
                        <input type="text" name="business_name" value="{{ old('business_name') }}" required placeholder="Contoh: Keripik Singkong Barokah" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                        @error('business_name')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap Pemilik Usaha <span class="text-red-500">*</span></label>
                        <input type="text" name="owner_name" value="{{ old('owner_name') }}" required placeholder="Contoh: Bpk. Slamet Riyadi" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                        @error('owner_name')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jenis Kelamin Pemilik</label>
                        <select name="gender" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">No. Kontak Narahubung (Opsional)</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="No. telepon pemilik / keluarga / pendamping desa" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                        <p class="text-[10px] text-slate-400 mt-1">Kosongkan jika tidak ada, sistem akan mencantumkan nomor narahubung Dinas KUKM.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Tempat Usaha / Merek (Opsional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-[#800000] hover:file:bg-red-100 cursor-pointer border border-slate-200 rounded-xl bg-slate-50 p-1.5">
                </div>
            </div>

            <!-- Section 2: Wilayah & Lokasi Usaha -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-red-100 text-[#800000] flex items-center justify-center text-xs">2</span>
                    Wilayah & Alamat Produksi di Wonogiri
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kecamatan <span class="text-red-500">*</span></label>
                        <select name="district" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                            <option value="">-- Pilih Kecamatan di Wonogiri --</option>
                            @foreach($districts as $dist => $villages)
                                <option value="{{ $dist }}" {{ old('district') == $dist ? 'selected' : '' }}>{{ $dist }}</option>
                            @endforeach
                        </select>
                        @error('district')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Desa / Kelurahan <span class="text-red-500">*</span></label>
                        <input type="text" name="village" value="{{ old('village') }}" required placeholder="Nama Desa atau Kelurahan" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                        @error('village')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Lengkap / Sentra Produksi <span class="text-red-500">*</span></label>
                    <textarea name="address" rows="2" required placeholder="Tuliskan nama jalan, dusun, RT/RW, dan patokan lokasi sentra usaha..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">{{ old('address') }}</textarea>
                    @error('address')<p class="text-[11px] text-red-600 mt-1 font-semibold">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Link Google Maps (Opsional)</label>
                    <input type="text" name="map_link" value="{{ old('map_link') }}" placeholder="https://maps.app.goo.gl/... atau link titik peta lokasi usaha" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                </div>
            </div>

            <!-- Section 3: Legalitas & Keterangan Tambahan -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-red-100 text-[#800000] flex items-center justify-center text-xs">3</span>
                    Legalitas Usaha & Deskripsi (Opsional)
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor NIB</label>
                        <input type="text" name="nib" value="{{ old('nib') }}" placeholder="Nomor Induk Berusaha" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor P-IRT</label>
                        <input type="text" name="pirt" value="{{ old('pirt') }}" placeholder="Izin Edar P-IRT" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Sertifikat Halal</label>
                        <input type="text" name="halal_cert" value="{{ old('halal_cert') }}" placeholder="Nomor Sertifikat Halal" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi / Cerita Usaha</label>
                    <textarea name="description" rows="3" placeholder="Ceritakan sejarah singkat, keunggulan bahan baku lokal Wonogiri, atau ciri khas produk usaha ini..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-[#800000] outline-none">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.binaan.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-[#800000] hover:bg-[#600000] transition-all shadow-md active:scale-95 cursor-pointer">
                    Simpan & Daftarkan UMKM Binaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
