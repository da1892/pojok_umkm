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
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Informasi & Kategori Panel (Kiri) -->
            <div class="md:col-span-1 space-y-8">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 reveal delay-100">
                    <h3 class="text-xl font-bold text-slate-900 mb-6">Bidang Konsultasi</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-red-50 transition-colors cursor-pointer group">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:bg-[#800000] group-hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-pie"><path d="M21 12c.552 0 1.005-.449.95-.998a10 10 0 0 0-8.953-8.951c-.55-.055-.998.398-.998.95v8a1 1 0 0 0 1 1z"/><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/></svg>                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Pemasaran Digital</h4>
                                <p class="text-xs text-slate-500 mt-1">Strategi media sosial, e-commerce, & branding.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-red-50 transition-colors cursor-pointer group">
                            <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0 group-hover:bg-[#800000] group-hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-dollar-sign"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Keuangan & Modal</h4>
                                <p class="text-xs text-slate-500 mt-1">Pembukuan, akses KUR, & manajemen aset.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-red-50 transition-colors cursor-pointer group">
                            <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0 group-hover:bg-[#800000] group-hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Legal & Perizinan</h4>
                                <p class="text-xs text-slate-500 mt-1">NIB, PIRT, Sertifikasi Halal, & HAKI.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Info Jam Operasional -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 reveal delay-200">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Jam Operasional Konsultasi</h3>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex justify-between items-center border-b border-slate-100 pb-2">
                            <span>Senin - Kamis</span>
                            <span class="font-bold text-slate-900">08:00 - 15:00 WIB</span>
                        </li>
                        <li class="flex justify-between items-center border-b border-slate-100 pb-2">
                            <span>Jumat</span>
                            <span class="font-bold text-slate-900">08:00 - 11:00 WIB</span>
                        </li>
                        <li class="flex justify-between items-center text-red-500 pt-1">
                            <span>Sabtu - Minggu</span>
                            <span class="font-bold">Tutup</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Form Panel (Kanan) -->
            <div class="md:col-span-2" id="form-konsultasi">
                <div class="bg-white rounded-3xl p-8 md:p-12 shadow-md border border-slate-100 reveal delay-300">
                    <div class="mb-8 border-b border-slate-100 pb-6">
                        <h2 class="text-2xl md:text-3xl font-extrabold text-[#800000] mb-2">Formulir Konsultasi</h2>
                        <p class="text-slate-500">Silakan isi data diri dan ceritakan kendala yang Anda hadapi. Tim pakar kami akan segera menghubungi Anda kembali.</p>
                    </div>
                    
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                                <input type="text" class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all bg-slate-50 focus:bg-white" placeholder="Masukkan nama Anda">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Nomor WhatsApp</label>
                                <input type="text" class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all bg-slate-50 focus:bg-white" placeholder="08xx xxxx xxxx">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama UMKM (Opsional)</label>
                            <input type="text" class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all bg-slate-50 focus:bg-white" placeholder="Nama usaha Anda (jika ada)">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Topik Konsultasi</label>
                            <select class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all bg-slate-50 focus:bg-white text-slate-700">
                                <option value="" disabled selected>Pilih topik yang paling sesuai</option>
                                <option value="pemasaran">Pemasaran Digital & Penjualan</option>
                                <option value="keuangan">Keuangan, Modal & Pembukuan</option>
                                <option value="legal">Legal, Izin Usaha (NIB) & Sertifikasi Halal</option>
                                <option value="produksi">Teknis Produksi & Pengemasan</option>
                                <option value="lainnya">Topik Lainnya</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Ceritakan Detail Kendala Anda</label>
                            <textarea rows="5" class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#800000] focus:border-[#800000] outline-none transition-all bg-slate-50 focus:bg-white resize-none" placeholder="Jelaskan secara singkat masalah atau pertanyaan yang ingin Anda konsultasikan..."></textarea>
                        </div>
                        
                        <div class="pt-4">
                            <button type="button" class="w-full bg-[#800000] text-white font-bold py-4 rounded-xl hover:bg-[#600000] transition-colors shadow-lg hover:shadow-xl active:scale-95 flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Kirim Permintaan Konsultasi
                            </button>
                            <p class="text-xs text-center text-slate-400 mt-4">Dengan menekan tombol kirim, Anda menyetujui data Anda digunakan untuk keperluan sesi konsultasi resmi.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
