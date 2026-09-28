@extends('user.layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-[#801414]">Formulir Pendaftaran UMKM</h2>
                <p class="text-gray-500 text-sm mt-1">Lengkapi data usaha Anda untuk diverifikasi oleh admin Dinas.</p>
            </div>

            <form action="{{ route('toko.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Usaha / Merk <span class="text-red-500">*</span></label>
                        <input type="text" name="business_name" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#801414] focus:ring-[#801414]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik <span class="text-red-500">*</span></label>
                        <input type="text" name="owner_name" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#801414] focus:ring-[#801414]">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Produksi <span class="text-red-500">*</span></label>
                    <textarea name="address" rows="3" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#801414] focus:ring-[#801414]" placeholder="Jalan, RT/RW, Desa/Kelurahan, Kecamatan..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Kontak / WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#801414] focus:ring-[#801414]" placeholder="Contoh: 08123456789">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk Berusaha (NIB)</label>
                        <input type="text" name="nib" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#801414] focus:ring-[#801414]" placeholder="Opsional">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sertifikasi PIRT</label>
                        <input type="text" name="pirt" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#801414] focus:ring-[#801414]" placeholder="Opsional">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sertifikasi Halal</label>
                        <input type="text" name="halal_cert" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#801414] focus:ring-[#801414]" placeholder="Opsional">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat Usaha</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#801414] focus:ring-[#801414]"></textarea>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="bg-[#801414] hover:bg-red-900 text-white font-bold py-2.5 px-6 rounded-lg transition-colors shadow">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
