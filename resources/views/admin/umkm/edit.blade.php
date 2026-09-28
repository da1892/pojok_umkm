@extends('layouts.admin')

@section('page_title', 'Edit Profil UMKM')

@section('content')
<div class="max-w-4xl bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
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
        <form action="{{ route('admin.umkm.update', $umkm->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Data Pemilik -->
                <div class="md:col-span-2">
                    <h4 class="font-bold text-slate-700 border-b border-slate-100 pb-2 mb-4">Informasi Utama</h4>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Nama Usaha / Bisnis</label>
                    <input type="text" name="business_name" value="{{ old('business_name', $umkm->business_name) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000]" required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Nama Pemilik</label>
                    <input type="text" name="owner_name" value="{{ old('owner_name', $umkm->owner_name) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000]" required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Nomor HP / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $umkm->phone) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000]" required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Kecamatan</label>
                    <select name="district" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000]" required>
                        <option value="">Pilih Kecamatan</option>
                        @php
                            $districts = ['Batuwarno', 'Baturetno', 'Bulukerto', 'Eromoko', 'Girimarto', 'Giritontro', 'Giriwoyo', 'Jatipurno', 'Jatiroto', 'Jatisrono', 'Karangtengah', 'Kismantoro', 'Manyaran', 'Ngadirojo', 'Nguntoronadi', 'Paranggupito', 'Pracimantoro', 'Puhpelem', 'Purwantoro', 'Slogohimo', 'Tirtomoyo', 'Wonogiri', 'Wuryantoro', 'Selogiri'];
                            sort($districts);
                        @endphp
                        @foreach($districts as $d)
                            <option value="{{ $d }}" {{ old('district', $umkm->district) == $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Alamat Lengkap (Produksi)</label>
                    <textarea name="address" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000]" required>{{ old('address', $umkm->address) }}</textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Deskripsi Bisnis</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000]">{{ old('description', $umkm->description) }}</textarea>
                </div>
                
                <!-- Legalitas -->
                <div class="md:col-span-2 mt-4">
                    <h4 class="font-bold text-slate-700 border-b border-slate-100 pb-2 mb-4">Legalitas & Sertifikasi (Opsional)</h4>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Nomor Induk Berusaha (NIB)</label>
                    <input type="text" name="nib" value="{{ old('nib', $umkm->nib) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000]">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Sertifikasi PIRT</label>
                    <input type="text" name="pirt" value="{{ old('pirt', $umkm->pirt) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000]">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-2">Sertifikasi Halal</label>
                    <input type="text" name="halal_cert" value="{{ old('halal_cert', $umkm->halal_cert) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-[#800000] focus:border-[#800000]">
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
@endsection
