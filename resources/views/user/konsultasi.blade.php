@extends('layouts.app')

@section('content')
<div class="bg-red-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Section Konsultasi -->
        <div class="bg-[#800000] rounded-3xl p-10 text-white shadow-xl mb-12 relative overflow-hidden reveal">
            <!-- Decorative blobs -->
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-red-600 rounded-full mix-blend-overlay filter blur-3xl opacity-50"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-orange-500 rounded-full mix-blend-overlay filter blur-3xl opacity-30"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-10">
                <div class="md:w-3/5">
                    <div class="inline-block bg-white text-[#800000] text-xs font-bold px-3 py-1 rounded-full mb-4 reveal delay-100 uppercase tracking-wider">Layanan Ekstra</div>
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-4 reveal delay-200 leading-tight">Konsultasi Bisnis<br>UMKM Gratis</h1>
                    <p class="text-red-100 text-lg reveal delay-300 mb-8">Punya kendala bisnis? Diskusikan langsung dengan pakar kami di bidang Pemasaran, Keuangan, Izin Usaha, dan lain-lain untuk memajukan UMKM Anda.</p>
                    <div class="flex gap-4 reveal delay-400">
                        <a href="#form-konsultasi" class="bg-white text-[#800000] font-bold px-8 py-3 rounded-full hover:bg-red-50 transition-colors shadow-lg">Mulai Konsultasi</a>
                    </div>
                </div>
                <div class="md:w-2/5 hidden md:flex justify-center reveal delay-400">
                    <div class="w-64 h-64 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/20 relative">
                        <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                        
                        <!-- Floating badges -->
                        <div class="absolute -top-4 -right-4 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full shadow-lg transform rotate-12">Cepat</div>
                        <div class="absolute -bottom-4 -left-4 bg-green-400 text-green-900 text-xs font-bold px-3 py-1 rounded-full shadow-lg transform -rotate-12">Pakar Ahli</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            
            <!-- Form Panel (Kiri, 8 columns) -->
            <div class="md:col-span-8" id="form-konsultasi">
                <div class="bg-white rounded-[24px] p-8 md:p-10 shadow-sm border border-slate-100 reveal delay-100">
                    <h2 class="text-[22px] font-bold text-slate-900 mb-8">Formulir Pengajuan Layanan</h2>
                    
                    <form class="space-y-5">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Nama Lengkap Pemohon</label>
                            <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#991b1b] focus:border-[#991b1b] outline-none transition-all bg-white text-sm" placeholder="Masukkan nama lengkap Anda...">
                        </div>
                        
                        <!-- Nama UMKM -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Nama UMKM / Usaha</label>
                            <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#991b1b] focus:border-[#991b1b] outline-none transition-all bg-white text-sm" placeholder="Masukkan nama badan usaha Anda...">
                        </div>
                        
                        <!-- Alamat Tempat Usaha -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Alamat Tempat Usaha</label>
                            <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#991b1b] focus:border-[#991b1b] outline-none transition-all bg-white text-sm" placeholder="Masukkan alamat lengkap usaha...">
                        </div>
                        
                        <!-- Nomor HP -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Nomor HP / WhatsApp</label>
                            <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#991b1b] focus:border-[#991b1b] outline-none transition-all bg-white text-sm" placeholder="Masukan nomor anda...">
                        </div>
                        
                        <!-- Kategori Konsultasi -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Kategori Konsultasi</label>
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#991b1b] focus:border-[#991b1b] outline-none transition-all bg-white text-sm text-slate-500 appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22currentColor%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_1rem_center] bg-no-repeat pr-10">
                                <option value="" disabled selected>Pilih Kategori Permasalahan</option>
                                <option value="pemasaran">Pemasaran & Penjualan</option>
                                <option value="keuangan">Keuangan & Modal</option>
                                <option value="perizinan">Perizinan Usaha</option>
                                <option value="sertifikasi">Sertifikasi Halal / PIRT</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        
                        <!-- Uraian Singkat -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Uraian Singkat Masalah / Kebutuhan</label>
                            <textarea rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#991b1b] focus:border-[#991b1b] outline-none transition-all bg-white text-sm resize-none" placeholder="Jelaskan kebutuhan konsultasi Anda secara rinci..."></textarea>
                        </div>
                        
                        <!-- Unggah Lampiran -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Unggah Lampiran Pendukung (KTP/NIB/Foto Produk)</label>
                            <div class="w-full border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors flex flex-col items-center justify-center py-6 cursor-pointer group">
                                <svg class="w-6 h-6 text-[#991b1b] mb-2 transition-transform group-hover:-translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="text-sm text-slate-500 font-medium">Klik untuk memilih berkas pendukung (Max 5MB)</span>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="button" class="w-full bg-[#a31d1d] text-white font-bold py-3.5 rounded-xl hover:bg-[#8b1818] transition-all shadow-md hover:shadow-lg active:scale-[0.98] flex justify-center items-center gap-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                                Kirim Pengajuan Konsultasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Info & FAQ Panel (Kanan, 4 columns) -->
            <div class="md:col-span-4 space-y-6">
                
                <!-- Kotak Informasi (Merah) -->
                <div class="bg-[#a31d1d] rounded-[24px] p-7 shadow-sm text-white reveal delay-200">
                    <h3 class="text-lg font-bold mb-4">Informasi Konsultasi</h3>
                    <p class="text-[13px] text-white/90 leading-relaxed mb-6">
                        Setiap berkas pengajuan akan ditinjau dalam waktu maksimal 2x24 jam kerja. Anda akan dihubungi oleh petugas resmi Dinas Perdagangan via WhatsApp untuk proses pendampingan lanjutan.
                    </p>
                    <div class="flex items-center gap-3 text-sm font-medium">
                        <svg class="w-5 h-5 text-white/80 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Senin - Jumat | 08.00 - 15.00 WIB
                    </div>
                </div>
                
                <!-- Tanya Jawab (FAQ) -->
                <div class="bg-white rounded-[24px] p-7 shadow-sm border border-slate-100 reveal delay-300">
                    <h3 class="text-[15px] font-bold text-slate-900 mb-5">Tanya Jawab Layanan (FAQ)</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-[13px] font-bold text-[#a31d1d] mb-1.5 leading-snug">Apakah layanan konsultasi ini berbayar?</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Seluruh layanan fasilitasi dan konsultasi ini gratis ditanggung oleh pemerintah daerah.</p>
                        </div>
                        
                        <div class="w-full h-px bg-slate-100"></div>
                        
                        <div>
                            <h4 class="text-[13px] font-bold text-[#a31d1d] mb-1.5 leading-snug">Bagaimana cara mendapatkan NIB?</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Sampaikan kebutuhan Anda melalui kategori konsultasi Perizinan Usaha, petugas kami akan memandu Anda.</p>
                        </div>
                        
                        <div class="w-full h-px bg-slate-100"></div>
                        
                        <div>
                            <h4 class="text-[13px] font-bold text-[#a31d1d] mb-1.5 leading-snug">Berapa lama proses sertifikasi Halal?</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">Proses bervariasi bergantung pada skema reguler maupun self-declare, biasanya selesai 14-30 hari.</p>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
        
    </div>
</div>
@endsection
