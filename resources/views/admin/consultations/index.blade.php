@extends('layouts.admin')

@section('page_title', 'Kelola Konsultasi')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-200">
        <h3 class="font-bold text-slate-800 text-lg">Tiket Konsultasi UMKM</h3>
        <p class="text-slate-500 text-sm mt-1">Daftar pertanyaan dan masalah yang diajukan oleh pelaku UMKM Wonogiri.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold">
                <tr>
                    <th class="px-6 py-4">ID Tiket</th>
                    <th class="px-6 py-4">Nama / UMKM</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($consultations as $consultation)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-900">#{{ $consultation->ticket_id ?? $consultation->id }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-900">{{ $consultation->name }}</div>
                        <div class="text-xs text-slate-500">{{ $consultation->email ?? $consultation->phone }}</div>
                    </td>
                    <td class="px-6 py-4">{{ $consultation->subject }}</td>
                    <td class="px-6 py-4">{{ $consultation->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        @php
                            $statusColor = match(strtolower($consultation->status)) {
                                'menunggu' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                'diterima' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'selesai' => 'bg-green-50 text-green-700 border-green-200',
                                'ditolak' => 'bg-red-50 text-red-700 border-red-200',
                                default => 'bg-slate-50 text-slate-700 border-slate-200'
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold border {{ $statusColor }}">
                            @if($consultation->status == 'diterima' || $consultation->status == 'selesai')
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            @elseif($consultation->status == 'ditolak')
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                            @elseif($consultation->status == 'diproses')
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                            @else
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            @endif
                            {{ ucfirst($consultation->status ?? 'menunggu') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="document.getElementById('reply-form-{{ $consultation->id }}').classList.toggle('hidden')" class="px-3 py-1.5 bg-slate-100 text-slate-700 border border-slate-200 rounded-md text-xs font-semibold hover:bg-slate-200 transition-colors shadow-2xs">
                            Tindak Lanjut & Balasan
                        </button>
                    </td>
                </tr>
                <tr id="reply-form-{{ $consultation->id }}" class="hidden bg-slate-50/70 border-t border-slate-200">
                    <td colspan="6" class="p-6">
                        <div class="mb-5">
                            <h4 class="font-bold text-slate-800 mb-1.5 text-sm flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#800000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                Isi Pertanyaan / Masalah Konsultasi:
                            </h4>
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-2xs">
                                <p class="text-sm text-slate-700 leading-relaxed">{{ $consultation->message }}</p>
                                
                                @if(!empty($consultation->attachments_list))
                                    <div class="pt-3 mt-3 border-t border-slate-100">
                                        <p class="text-xs font-semibold text-slate-500 mb-2">Berkas Pendukung ({{ count($consultation->attachments_list) }}):</p>
                                        <div class="flex flex-wrap items-center gap-3">
                                            @foreach($consultation->attachments_list as $adminAttach)
                                                @php
                                                    $adminExt = is_object($adminAttach) ? $adminAttach->extension : pathinfo((string)$adminAttach, PATHINFO_EXTENSION);
                                                    $adminIsImg = is_object($adminAttach) ? $adminAttach->is_image : in_array(strtolower($adminExt), ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                                    $adminFileExists = is_object($adminAttach) ? $adminAttach->exists : (file_exists(public_path('storage/' . $adminAttach)) || \Illuminate\Support\Facades\Storage::disk('public')->exists((string)$adminAttach));
                                                    $adminSrc = is_object($adminAttach) ? $adminAttach->view_url : asset('storage/' . $adminAttach);
                                                    $adminName = is_object($adminAttach) ? $adminAttach->name : basename((string)$adminAttach);
                                                @endphp
                                                @if(!$adminFileExists)
                                                    <div class="inline-flex items-center gap-2.5 px-3 py-2 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-xs shadow-2xs">
                                                        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                        <div>
                                                            <span class="font-semibold block">File fisik belum tersinkron</span>
                                                            <span class="text-[10px] text-amber-700 font-mono">{{ $adminName }}</span>
                                                            <span class="text-[9px] text-amber-600 block">(File ada di komputer pengunggah)</span>
                                                        </div>
                                                    </div>
                                                @elseif($adminIsImg)
                                                    <div class="inline-flex items-center gap-3 bg-white p-2.5 rounded-xl border border-slate-200 shadow-2xs hover:shadow-sm transition-all">
                                                        <a href="{{ $adminSrc }}" target="_blank" class="relative block group overflow-hidden rounded-lg shrink-0">
                                                            <img src="{{ $adminSrc }}" alt="Lampiran Foto" class="w-16 h-16 object-cover rounded-lg border border-slate-100 group-hover:scale-105 transition-transform duration-200">
                                                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                            </div>
                                                        </a>
                                                        <div class="flex flex-col pr-2">
                                                            <span class="text-xs font-bold text-slate-800">Foto Lampiran {{ $loop->iteration }}</span>
                                                            <span class="text-[10px] text-slate-400 font-mono truncate max-w-[150px]" title="{{ $adminName }}">{{ strtoupper($adminExt) }} &bull; {{ $adminName }}</span>
                                                            <a href="{{ $adminSrc }}" target="_blank" class="mt-1 inline-flex items-center gap-1 text-xs text-[#800000] hover:text-red-700 font-semibold">
                                                                <span>Buka Foto Penuh</span>
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <a href="{{ $adminSrc }}" target="_blank" download="{{ $adminName }}" class="inline-flex items-center gap-2.5 px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors shadow-2xs text-xs font-medium text-slate-700">
                                                        <div class="w-8 h-8 rounded-lg bg-red-50 text-[#800000] flex items-center justify-center font-bold text-[10px]">
                                                            {{ strtoupper($adminExt) }}
                                                        </div>
                                                        <div class="flex flex-col">
                                                            <span class="text-slate-800 font-bold truncate max-w-[150px]">{{ $adminName }} ({{ strtoupper($adminExt) }})</span>
                                                            <span class="text-[11px] text-blue-600 hover:underline">Unduh Berkas &rarr;</span>
                                                        </div>
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Form Tindak Lanjut: Terima / Tolak / Balas dengan Komentar -->
                        <form action="{{ route('admin.consultations.reply', $consultation->id) }}" method="POST" id="form-reply-{{ $consultation->id }}">
                            @csrf

                            <!-- Tombol Aksi Cepat Terima / Tolak -->
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="text-xs font-bold text-slate-600 mr-1">Tindakan Cepat:</span>
                                <button type="button" onclick="setConsultationStatus('{{ $consultation->id }}', 'diterima', 'Konsultasi Anda telah diterima oleh Admin Dinas Perdagangan dan KUKM Wonogiri. Silakan menunggu arahan atau tindak lanjut lebih lanjut dari tim kami.')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-300 transition-all shadow-2xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Terima Konsultasi
                                </button>
                                <button type="button" onclick="setConsultationStatus('{{ $consultation->id }}', 'ditolak', 'Mohon maaf, pengajuan konsultasi Anda belum dapat kami proses karena berada di luar bidang kewenangan Dinas Perdagangan dan KUKM Kabupaten Wonogiri.')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-red-50 text-red-700 hover:bg-red-100 border border-red-300 transition-all shadow-2xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Tolak Konsultasi
                                </button>
                                <button type="button" onclick="setConsultationStatus('{{ $consultation->id }}', 'selesai', '')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-300 transition-all shadow-2xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Selesai Dijawab
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-3">
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilih Status Konsultasi</label>
                                    <select name="status" id="status-select-{{ $consultation->id }}" onchange="updateFormMode('{{ $consultation->id }}')" class="w-full px-3.5 py-2.5 bg-white border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-900 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all cursor-pointer">
                                        <option value="menunggu" {{ strtolower($consultation->status) == 'menunggu' ? 'selected' : '' }}>Menunggu Tinjauan</option>
                                        <option value="diterima" {{ strtolower($consultation->status) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                        <option value="diproses" {{ strtolower($consultation->status) == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                        <option value="selesai" {{ strtolower($consultation->status) == 'selesai' ? 'selected' : '' }}>Selesai Dijawab</option>
                                        <option value="ditolak" {{ strtolower($consultation->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                    <p class="text-[11px] text-slate-500 mt-1" id="status-hint-{{ $consultation->id }}">
                                        Pilih status untuk menentukan tindakan respon.
                                    </p>
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5" id="response-label-{{ $consultation->id }}">
                                        Komentar / Balasan Admin Dinas <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="response" id="response-text-{{ $consultation->id }}" rows="3" required class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all" placeholder="Tuliskan komentar, tanggapan, atau alasan penolakan di sini...">{{ $consultation->response }}</textarea>

                                    <!-- Rekomendasi Template Cepat -->
                                    <div class="mt-2 flex flex-wrap items-center gap-1.5 text-xs" id="chips-container-{{ $consultation->id }}">
                                        <span class="text-[11px] text-slate-500 font-semibold mr-1">Template Cepat:</span>
                                        <button type="button" onclick="insertTemplate('{{ $consultation->id }}', 'Konsultasi Anda telah diterima oleh Dinas Perdagangan dan KUKM. Mohon tunggu informasi jadwal pendampingan lebih lanjut.')" class="px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-[11px] font-medium shadow-2xs transition-colors">
                                            + Terima & Jadwalkan
                                        </button>
                                        <button type="button" onclick="insertTemplate('{{ $consultation->id }}', 'Pengajuan konsultasi ditolak karena topik di luar kewenangan Dinas Perdagangan dan KUKM Wonogiri. Silakan mengajukan ke instansi terkait.')" class="px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-[11px] font-medium shadow-2xs transition-colors">
                                            + Tolak: Di luar kewenangan
                                        </button>
                                        <button type="button" onclick="insertTemplate('{{ $consultation->id }}', 'Pengajuan konsultasi ditolak karena data atau berkas yang dilampirkan belum lengkap. Silakan ajukan konsultasi baru dengan rincian yang lebih jelas.')" class="px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-[11px] font-medium shadow-2xs transition-colors">
                                            + Tolak: Data belum lengkap
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 pt-2 border-t border-slate-200">
                                <button type="button" onclick="document.getElementById('reply-form-{{ $consultation->id }}').classList.add('hidden')" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-100 transition-colors">
                                    Batal
                                </button>
                                <button type="submit" id="submit-btn-{{ $consultation->id }}" class="px-5 py-2 text-xs font-bold text-white bg-[#800000] rounded-lg hover:bg-red-900 shadow-sm transition-all flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Simpan Tanggapan
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-3 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Tiket Konsultasi</h4>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto">Semua data konsultasi sebelumnya telah dibersihkan. Tiket baru yang diajukan oleh UMKM akan muncul di sini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($consultations->hasPages())
    <div class="p-4 border-t border-slate-200">
        {{ $consultations->links() }}
    </div>
    @endif
</div>

<script>
    function setConsultationStatus(id, status, defaultComment) {
        var form = document.getElementById('reply-form-' + id);
        if (form && form.classList.contains('hidden')) {
            form.classList.remove('hidden');
        }
        var select = document.getElementById('status-select-' + id);
        if (select) {
            select.value = status;
        }
        var textarea = document.getElementById('response-text-' + id);
        if (textarea && defaultComment) {
            if (!textarea.value.trim() || textarea.value.trim() === '') {
                textarea.value = defaultComment;
            }
        }
        updateFormMode(id);
        if (textarea) {
            textarea.focus();
        }
    }

    function updateFormMode(id) {
        var select = document.getElementById('status-select-' + id);
        var label = document.getElementById('response-label-' + id);
        var textarea = document.getElementById('response-text-' + id);
        var submitBtn = document.getElementById('submit-btn-' + id);
        var hint = document.getElementById('status-hint-' + id);

        if (!select) return;
        var val = select.value;

        if (val === 'ditolak') {
            if (label) label.innerHTML = 'Alasan Penolakan / Komentar untuk Pemohon <span class="text-red-600 font-black">* (Wajib)</span>';
            if (textarea) textarea.placeholder = 'Tuliskan alasan penolakan secara jelas (misal: di luar kewenangan dinas, data tidak lengkap)...';
            if (submitBtn) {
                submitBtn.className = 'px-5 py-2 text-xs font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-sm transition-all flex items-center gap-1.5';
                submitBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Simpan & Tolak Konsultasi';
            }
            if (hint) hint.textContent = 'Konsultasi akan ditandai ditolak dengan komentar di samping.';
        } else if (val === 'diterima') {
            if (label) label.innerHTML = 'Komentar / Balasan Penerimaan Konsultasi <span class="text-emerald-600 font-black">* (Wajib)</span>';
            if (textarea) textarea.placeholder = 'Tuliskan komentar penerimaan, jadwal, atau petunjuk lanjut untuk pemohon...';
            if (submitBtn) {
                submitBtn.className = 'px-5 py-2 text-xs font-bold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 shadow-sm transition-all flex items-center gap-1.5';
                submitBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Simpan & Terima Konsultasi';
            }
            if (hint) hint.textContent = 'Konsultasi diterima dan menunggu tindak lanjut dinas.';
        } else if (val === 'selesai') {
            if (label) label.innerHTML = 'Jawaban Akhir / Solusi Konsultasi <span class="text-blue-600 font-black">*</span>';
            if (textarea) textarea.placeholder = 'Tuliskan jawaban tuntas atau solusi konsultasi...';
            if (submitBtn) {
                submitBtn.className = 'px-5 py-2 text-xs font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm transition-all flex items-center gap-1.5';
                submitBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Simpan Jawaban Selesai';
            }
            if (hint) hint.textContent = 'Konsultasi akan ditandai selesai.';
        } else if (val === 'diproses') {
            if (label) label.innerHTML = 'Catatan Sedang Diproses <span class="text-slate-600 font-black">*</span>';
            if (textarea) textarea.placeholder = 'Tuliskan catatan proses penanganan konsultasi...';
            if (submitBtn) {
                submitBtn.className = 'px-5 py-2 text-xs font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm transition-all flex items-center gap-1.5';
                submitBtn.innerHTML = 'Simpan Status Diproses';
            }
            if (hint) hint.textContent = 'Konsultasi sedang dalam proses kajian dinas.';
        } else {
            if (label) label.innerHTML = 'Komentar / Balasan Admin Dinas';
            if (textarea) textarea.placeholder = 'Tuliskan komentar atau catatan...';
            if (submitBtn) {
                submitBtn.className = 'px-5 py-2 text-xs font-bold text-white bg-[#800000] rounded-lg hover:bg-red-900 shadow-sm transition-all flex items-center gap-1.5';
                submitBtn.innerHTML = 'Simpan Tanggapan';
            }
            if (hint) hint.textContent = 'Pilih status untuk menentukan tindakan respon.';
        }
    }

    function insertTemplate(id, text) {
        var textarea = document.getElementById('response-text-' + id);
        if (textarea) {
            textarea.value = text;
            textarea.focus();
        }
    }
</script>
@endsection
