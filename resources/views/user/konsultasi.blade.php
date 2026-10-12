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
                        <a href="{{ route('konsultasi.cek') }}" class="bg-white text-[#800000] font-bold px-8 py-3 rounded-full hover:bg-red-50 transition-colors shadow-lg">Cek Konsultasi</a>
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
                    
                    @if(session('success'))
                        <!-- SweetAlert will handle this -->
                    @endif

                    <form method="POST" action="{{ route('konsultasi.store') }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Nama Lengkap Pemohon <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#991b1b] focus:border-[#991b1b] outline-none transition-all bg-white text-sm" placeholder="Masukkan nama lengkap Anda...">
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="text" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#991b1b] focus:border-[#991b1b] outline-none transition-all bg-white text-sm" placeholder="Masukkan email aktif Anda...">
                        </div>
                        
                        <!-- Nama UMKM -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Nama UMKM / Usaha (Opsional)</label>
                            <input type="text" name="umkm_name" value="{{ old('umkm_name') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#991b1b] focus:border-[#991b1b] outline-none transition-all bg-white text-sm" placeholder="Masukkan nama badan usaha Anda...">
                        </div>
                        
                        <!-- Nomor HP -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Nomor HP / WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#991b1b] focus:border-[#991b1b] outline-none transition-all bg-white text-sm" placeholder="Masukan nomor anda...">
                        </div>
                        
                        <!-- Kategori Konsultasi -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Kategori Konsultasi <span class="text-red-500">*</span></label>
                            <select name="subject" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#991b1b] focus:border-[#991b1b] outline-none transition-all bg-white text-sm text-slate-500 appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22currentColor%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E')] bg-[position:right_1rem_center] bg-no-repeat pr-10">
                                <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Pilih Kategori Permasalahan</option>
                                <option value="Pemasaran & Penjualan" {{ old('subject') == 'Pemasaran & Penjualan' ? 'selected' : '' }}>Pemasaran & Penjualan</option>
                                <option value="Keuangan & Modal" {{ old('subject') == 'Keuangan & Modal' ? 'selected' : '' }}>Keuangan & Modal</option>
                                <option value="Perizinan Usaha" {{ old('subject') == 'Perizinan Usaha' ? 'selected' : '' }}>Perizinan Usaha</option>
                                <option value="Sertifikasi Halal / PIRT" {{ old('subject') == 'Sertifikasi Halal / PIRT' ? 'selected' : '' }}>Sertifikasi Halal / PIRT</option>
                                <option value="Lainnya" {{ old('subject') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        
                        <!-- Uraian Singkat -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Uraian Singkat Masalah / Kebutuhan <span class="text-red-500">*</span></label>
                            <textarea name="message" required rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#991b1b] focus:border-[#991b1b] outline-none transition-all bg-white text-sm resize-none" placeholder="Jelaskan kebutuhan konsultasi Anda secara rinci...">{{ old('message') }}</textarea>
                        </div>
                        
                        <!-- Lampiran -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-semibold text-slate-900">Lampiran Foto/Dokumen <span class="text-xs font-normal text-slate-500">(Opsional, Maks. 3 File)</span></label>
                                <span id="file-count-badge" class="hidden text-xs font-bold text-[#800000] bg-red-50 px-2.5 py-0.5 rounded-full border border-red-100">0/3 File</span>
                            </div>
                            
                            <div id="dropzone" class="relative border-2 border-dashed border-slate-300 hover:border-[#800000] rounded-2xl p-5 text-center bg-slate-50/70 hover:bg-slate-50 transition-all cursor-pointer group">
                                <input type="file" id="attachment-input" name="attachments[]" accept="image/*,.pdf,.doc,.docx" multiple class="hidden">
                                
                                <!-- Placeholder State -->
                                <div id="upload-placeholder" class="space-y-2 py-2">
                                    <div class="w-12 h-12 mx-auto bg-red-100/60 text-[#800000] rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p class="text-sm font-medium text-slate-700">
                                        <span class="text-[#800000] font-semibold underline underline-offset-2">Klik untuk memilih file</span> atau tarik ke sini
                                    </p>
                                    <p class="text-xs text-slate-400">Bisa upload hingga 3 foto/dokumen (Maks. 5MB per file)</p>
                                </div>

                                <!-- Preview State Container (List of Selected Files) -->
                                <div id="upload-preview-container" class="hidden space-y-3 text-left">
                                    <div id="file-list" class="space-y-2"></div>
                                    
                                    <div id="add-more-container" class="pt-2 text-center border-t border-slate-200">
                                        <button type="button" id="add-more-btn" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#800000] hover:text-red-900 transition-colors bg-white px-3.5 py-1.5 rounded-lg border border-red-200 shadow-sm hover:bg-red-50">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                            <span>Tambah Foto/Dokumen Lain (Maks. 3)</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-[#a31d1d] text-white font-bold py-3.5 rounded-xl hover:bg-[#8b1818] transition-all shadow-md hover:shadow-lg active:scale-[0.98] flex justify-center items-center gap-2 text-sm">
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

<!-- SweetAlert2 Pop Up -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('success'))
            @if(session('ticket_id'))
                Swal.fire({
                    icon: 'success',
                    title: 'Terkirim!',
                    html: `
                        <p class="mb-4">{!! session('success') !!}</p>
                        <p class="text-sm text-slate-500 mb-2">ID Tiket (UUID) Anda:</p>
                        <div class="flex items-center justify-center gap-2 mb-4 bg-slate-50 p-3 rounded-lg border border-slate-200">
                            <code id="ticket-id" class="font-bold text-[#800000] text-sm sm:text-base">{{ session('ticket_id') }}</code>
                            <button onclick="navigator.clipboard.writeText('{{ session('ticket_id') }}').then(() => { Swal.showValidationMessage('ID Berhasil Disalin!'); setTimeout(()=>Swal.resetValidationMessage(), 2000); })" class="bg-[#800000] text-white p-2 rounded-md hover:bg-red-900 transition flex-shrink-0" title="Salin ID">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </button>
                        </div>
                        <p class="text-xs text-slate-500">Fitur email menunggu SMTP. Silakan salin ID Tiket di atas untuk mengecek balasan Admin secara manual, atau klik tombol di bawah.</p>
                    `,
                    showDenyButton: true,
                    confirmButtonColor: '#800000',
                    confirmButtonText: 'Tutup & Salin',
                    denyButtonColor: '#10b981',
                    denyButtonText: 'Cek Tiket Sekarang',
                    background: '#ffffff',
                    customClass: {
                        title: 'text-xl font-bold text-slate-800',
                        popup: 'rounded-3xl',
                        confirmButton: 'rounded-xl font-bold px-4 py-2 mt-2',
                        denyButton: 'rounded-xl font-bold px-4 py-2 mt-2'
                    }
                }).then((result) => {
                    if (result.isDenied) {
                        window.location.href = "{{ route('konsultasi.cek') }}?ticket_id={{ session('ticket_id') }}";
                    }
                });
            @else
                Swal.fire({
                    icon: 'success',
                    title: 'Terkirim!',
                    text: {!! json_encode(session('success')) !!},
                    confirmButtonColor: '#800000',
                    confirmButtonText: 'Tutup & Mengerti',
                    background: '#ffffff',
                    customClass: {
                        title: 'text-xl font-bold text-slate-800',
                        popup: 'rounded-3xl',
                        confirmButton: 'rounded-xl font-bold px-6 py-3'
                    }
                });
            @endif
        @endif
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: {!! json_encode(session('error')) !!},
                confirmButtonColor: '#800000',
                confirmButtonText: 'Kembali'
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Pengisian Belum Lengkap',
                html: '<ul class="text-left space-y-1 text-sm text-slate-600">@foreach($errors->all() as $error)<li>&bull; {{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#800000',
                confirmButtonText: 'Perbaiki'
            });
        @endif

        // Multiple File Upload & Preview Handler (Up to 3 Files)
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('attachment-input');
        const placeholder = document.getElementById('upload-placeholder');
        const previewContainer = document.getElementById('upload-preview-container');
        const fileList = document.getElementById('file-list');
        const fileCountBadge = document.getElementById('file-count-badge');
        const addMoreBtn = document.getElementById('add-more-btn');

        if (dropzone && fileInput) {
            let selectedFiles = [];

            function renderFiles() {
                fileList.innerHTML = '';

                selectedFiles.forEach((file, index) => {
                    const row = document.createElement('div');
                    row.className = 'flex items-center justify-between p-2.5 bg-white rounded-xl border border-slate-200 shadow-xs';

                    const isImg = file.type.startsWith('image/');
                    const sizeStr = (file.size / (1024 * 1024)).toFixed(2) + ' MB';

                    let thumbHtml = '';
                    if (isImg) {
                        const blobUrl = URL.createObjectURL(file);
                        thumbHtml = `<img src="${blobUrl}" alt="Preview" class="w-12 h-12 object-cover rounded-lg border border-slate-200 shrink-0">`;
                    } else {
                        thumbHtml = `<div class="w-12 h-12 bg-red-50 text-[#800000] rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>`;
                    }

                    row.innerHTML = `
                        <div class="flex items-center space-x-3 truncate">
                            ${thumbHtml}
                            <div class="text-left truncate">
                                <p class="text-xs sm:text-sm font-semibold text-slate-800 truncate max-w-[200px] sm:max-w-xs">${file.name}</p>
                                <p class="text-xs text-slate-400">${sizeStr}</p>
                            </div>
                        </div>
                        <button type="button" data-index="${index}" class="remove-single-file p-2 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors shrink-0 ml-2" title="Hapus file ini">
                            <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    `;

                    fileList.appendChild(row);
                });

                fileList.querySelectorAll('.remove-single-file').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const idx = parseInt(btn.getAttribute('data-index'), 10);
                        selectedFiles.splice(idx, 1);
                        syncInput();
                    });
                });
            }

            function syncInput() {
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;

                const count = selectedFiles.length;
                if (count > 0) {
                    fileCountBadge.textContent = `${count}/3 File`;
                    fileCountBadge.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    previewContainer.classList.remove('hidden');

                    if (count >= 3) {
                        addMoreBtn.classList.add('hidden');
                    } else {
                        addMoreBtn.classList.remove('hidden');
                    }
                } else {
                    fileCountBadge.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                    previewContainer.classList.add('hidden');
                    addMoreBtn.classList.remove('hidden');
                }

                renderFiles();
            }

            function handleNewFiles(incomingFiles) {
                if (!incomingFiles || !incomingFiles.length) return;

                let exceeded = false;
                let oversized = false;

                for (let i = 0; i < incomingFiles.length; i++) {
                    const file = incomingFiles[i];

                    if (selectedFiles.length >= 3) {
                        exceeded = true;
                        break;
                    }

                    if (file.size > 5 * 1024 * 1024) {
                        oversized = true;
                        continue;
                    }

                    const exists = selectedFiles.some(f => f.name === file.name && f.size === file.size);
                    if (!exists) {
                        selectedFiles.push(file);
                    }
                }

                if (oversized) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran Terlalu Besar',
                        text: 'File yang melebihi batas 5MB otomatis diabaikan.',
                        confirmButtonColor: '#800000'
                    });
                }

                if (exceeded) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Batas Maksimal',
                        text: 'Maksimal 3 file lampiran yang dapat diunggah.',
                        confirmButtonColor: '#800000'
                    });
                }

                syncInput();
            }

            fileInput.addEventListener('click', (e) => e.stopPropagation());

            dropzone.addEventListener('click', (e) => {
                if (e.target.closest('.remove-single-file') || e.target.closest('#add-more-btn')) return;
                if (selectedFiles.length === 0) {
                    fileInput.click();
                }
            });

            if (addMoreBtn) {
                addMoreBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (selectedFiles.length < 3) {
                        fileInput.click();
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Batas Tercapai',
                            text: 'Anda sudah memilih batas maksimal 3 file.',
                            confirmButtonColor: '#800000'
                        });
                    }
                });
            }

            dropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropzone.classList.add('border-[#800000]', 'bg-red-50/50');
            });

            ['dragleave', 'dragend'].forEach(type => {
                dropzone.addEventListener(type, () => {
                    dropzone.classList.remove('border-[#800000]', 'bg-red-50/50');
                });
            });

            dropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzone.classList.remove('border-[#800000]', 'bg-red-50/50');
                if (e.dataTransfer.files && e.dataTransfer.files.length) {
                    handleNewFiles(e.dataTransfer.files);
                }
            });

            fileInput.addEventListener('change', () => {
                if (fileInput.files && fileInput.files.length) {
                    handleNewFiles(fileInput.files);
                }
            });
        }
    });
</script>

@endsection
