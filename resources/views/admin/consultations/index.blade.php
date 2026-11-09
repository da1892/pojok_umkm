@extends('layouts.admin')

@section('page_title', 'Kelola Konsultasi')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-200">
        <h3 class="font-bold text-slate-800 text-lg">Konsultasi UMKM</h3>
        <p class="text-slate-500 text-sm mt-1">Daftar pertanyaan dan masalah pelaku UMKM Wonogiri.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold">
                <tr>
                    <th class="px-6 py-4">ID Tiket</th>
                    <th class="px-6 py-4">Nama / UMKM</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Waktu Masuk</th>
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
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium text-slate-900">{{ $consultation->created_at->translatedFormat('d M Y') }}</div>
                        <div class="text-xs text-slate-500 font-mono flex items-center gap-1.5 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ $consultation->created_at->format('H:i') }} WIB</span>
                            <span class="text-[10px] text-slate-400">({{ $consultation->created_at->diffForHumans() }})</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusColor = match(strtolower($consultation->status)) {
                                'menunggu' => 'bg-yellow-50 text-yellow-800 border-yellow-200',
                                'diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'selesai', 'diterima' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'ditolak' => 'bg-red-50 text-red-700 border-red-200',
                                default => 'bg-slate-50 text-slate-700 border-slate-200'
                            };

                            $statusText = match(strtolower($consultation->status)) {
                                'menunggu' => 'Menunggu Balasan',
                                'diproses' => 'Sedang Diproses',
                                'selesai' => 'Selesai Dijawab',
                                'diterima' => 'Diterima',
                                'ditolak' => 'Ditolak',
                                default => ucfirst($consultation->status ?? 'menunggu')
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold border {{ $statusColor }}">
                            @if($consultation->status == 'menunggu')
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            @elseif($consultation->status == 'diproses')
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                            @elseif($consultation->status == 'ditolak')
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                            @else
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            @endif
                            {{ $statusText }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <div class="inline-flex items-center justify-end gap-1.5">
                            @if($consultation->status !== 'selesai')
                                <form action="{{ route('admin.consultations.reply', $consultation->id) }}" method="POST" class="inline" onsubmit="return confirm('Tandai konsultasi #{{ $consultation->ticket_id }} sebagai SELESAI?\n\nPengkonsultasi tidak akan dapat mengirim pesan balasan lagi dan harus membuat pengajuan baru jika ingin berkonsultasi lagi.');">
                                    @csrf
                                    <input type="hidden" name="action" value="selesai">
                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md text-xs font-bold transition-all shadow-2xs cursor-pointer active:scale-95" title="Tandai Konsultasi Ini Selesai">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span>Selesai</span>
                                    </button>
                                </form>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-md text-[11px] font-bold">
                                    <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    <span>Tuntas</span>
                                </span>
                            @endif

                            <button type="button" onclick="document.getElementById('reply-form-{{ $consultation->id }}').classList.toggle('hidden')" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 text-slate-700 border border-slate-200 rounded-md text-xs font-semibold hover:bg-slate-200 transition-colors shadow-2xs cursor-pointer">
                                <span>Detail & Balas</span>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr id="reply-form-{{ $consultation->id }}" class="hidden bg-slate-50/70 border-t border-slate-200">
                    <td colspan="6" class="p-6">
                        <!-- Riwayat Percakapan (Saling Jawab) -->
                        <div class="mb-5 space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-200">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-red-100 text-[#800000] flex items-center justify-center font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                    </div>
                                    <h4 class="font-bold text-slate-800 text-sm">
                                        Riwayat Percakapan ({{ count($consultation->thread_messages) }} Pesan)
                                    </h4>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span class="text-xs text-slate-500 font-mono">Tiket: #{{ $consultation->ticket_id }}</span>
                                    @if($consultation->status !== 'selesai')
                                        <button type="button" 
                                                onclick="submitFinishConsultation('{{ $consultation->id }}', '{{ $consultation->ticket_id }}')" 
                                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-all shadow-2xs cursor-pointer active:scale-95" 
                                                title="Selesaikan konsultasi dan tutup sesi (Pengkonsultasi tidak bisa membalas lagi)">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            <span>Selesai</span>
                                        </button>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-lg text-[11px] font-bold">
                                            <svg class="w-3 h-3 text-emerald-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            <span>Konsultasi Selesai</span>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="space-y-3 max-h-[380px] overflow-y-auto pr-1">
                                @forelse($consultation->thread_messages as $threadMsg)
                                    @if($threadMsg->sender_type == 'user')
                                        <!-- Pesan dari Pemohon / Pengguna -->
                                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-2xs">
                                            <div class="flex items-center justify-between gap-2 mb-2 pb-2 border-b border-slate-100">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center text-xs font-bold">
                                                        {{ substr($threadMsg->sender_name ?: $consultation->name, 0, 1) }}
                                                    </span>
                                                    <span class="text-xs font-bold text-slate-900">{{ $threadMsg->sender_name ?: $consultation->name }}</span>
                                                    <span class="text-[10px] bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded font-medium">Pemohon</span>
                                                </div>
                                                <span class="text-[11px] text-slate-400 font-mono">{{ $threadMsg->created_at ? $threadMsg->created_at->format('d M Y, H:i') : '' }} WIB</span>
                                            </div>

                                            <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $threadMsg->message }}</p>

                                            @if(!empty($threadMsg->attachments_list))
                                                <div class="pt-3 mt-3 border-t border-slate-100">
                                                    <p class="text-xs font-semibold text-slate-500 mb-2">Berkas Pendukung ({{ count($threadMsg->attachments_list) }}):</p>
                                                    <div class="flex flex-wrap items-center gap-3">
                                                        @foreach($threadMsg->attachments_list as $adminAttach)
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
                                    @else
                                        <!-- Balasan dari Admin -->
                                        <div class="bg-gradient-to-r from-red-50/60 to-rose-50/40 p-4 rounded-xl border border-red-200/80 shadow-2xs">
                                            <div class="flex items-center justify-between gap-2 mb-2 pb-2 border-b border-red-100">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-6 h-6 rounded-full bg-[#800000] text-white flex items-center justify-center text-xs font-bold">
                                                        A
                                                    </span>
                                                    <span class="text-xs font-bold text-red-950">{{ $threadMsg->sender_name ?: 'Admin Dinas Perdagangan & KUKM' }}</span>
                                                    <span class="text-[10px] bg-red-100 text-[#800000] font-bold px-1.5 py-0.5 rounded border border-red-200">Respon Resmi</span>
                                                </div>
                                                <span class="text-[11px] text-slate-400 font-mono">{{ $threadMsg->created_at ? $threadMsg->created_at->format('d M Y, H:i') : '' }} WIB</span>
                                            </div>
                                            <p class="text-sm text-slate-800 leading-relaxed whitespace-pre-line font-medium">{{ $threadMsg->message }}</p>
                                        </div>
                                    @endif
                                @empty
                                    <div class="bg-white p-4 rounded-xl border border-slate-200 text-xs text-slate-500 italic text-center">
                                        Belum ada riwayat percakapan.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        @if($consultation->status == 'selesai')
                            <!-- Status Selesai Banner -->
                            <div class="mt-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex flex-col sm:flex-row items-center justify-between gap-3 shadow-2xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div>
                                        <h5 class="text-xs font-bold text-emerald-950">Sesi Konsultasi Ini Telah Ditandai Selesai</h5>
                                        <p class="text-[11px] text-emerald-800">Tiket berstatus selesai. Pengkonsultasi tidak dapat mengirim pesan balasan lagi dan diarahkan untuk membuat konsultasi baru jika memerlukan bantuan tambahan.</p>
                                    </div>
                                </div>
                                <form action="{{ route('admin.consultations.reply', $consultation->id) }}" method="POST" class="inline" onsubmit="return confirm('Buka kembali sesi percakapan tiket konsultasi ini agar pemohon dapat mengirim pesan balasan lagi?');">
                                    @csrf
                                    <input type="hidden" name="action" value="buka_kembali">
                                    <button type="submit" class="px-3.5 py-2 bg-white hover:bg-emerald-100 text-emerald-800 border border-emerald-300 rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer whitespace-nowrap active:scale-95">
                                        Buka Kembali Tiket
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Form Balasan Admin dengan Aksi Status Otomatis -->
                            <form action="{{ route('admin.consultations.reply', $consultation->id) }}" method="POST" id="form-reply-{{ $consultation->id }}">
                                @csrf

                                <div class="mt-4 pt-4 border-t border-slate-200">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                                        <label class="block text-xs font-bold text-slate-800">
                                            Tulis Tanggapan / Balasan
                                        </label>
                                        <span class="text-[11px] text-slate-400">Pilih template cepat di bawah jika diperlukan</span>
                                    </div>

                                    <!-- Rekomendasi Template Cepat -->
                                    <div class="mb-3 flex flex-wrap items-center gap-1.5 text-xs">
                                        <span class="text-[11px] text-slate-500 font-semibold mr-1">Template Balasan Cepat:</span>
                                        <button type="button" onclick="insertTemplate('{{ $consultation->id }}', 'Terima kasih atas pertanyaannya. Terkait kendala yang Anda hadapi, berikut arahan dan solusinya:\n1. ...\n2. ...\nSilakan dicoba terlebih dahulu dan kabari kami jika masih ada kendala.')" class="px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-[11px] font-medium shadow-2xs transition-colors cursor-pointer">
                                            + Solusi & Arahan
                                        </button>
                                        <button type="button" onclick="insertTemplate('{{ $consultation->id }}', 'Mohon maaf, permohonan konsultasi ini berada di luar bidang kewenangan Dinas Perdagangan dan KUKM Kabupaten Wonogiri. Untuk perihal tersebut, silakan berkoordinasi langsung dengan dinas/instansi terkait.')" class="px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-[11px] font-medium shadow-2xs transition-colors cursor-pointer">
                                            + Di Luar Kewenangan Dinas
                                        </button>
                                        <button type="button" onclick="insertTemplate('{{ $consultation->id }}', 'Mohon maaf, rincian data atau berkas lampiran pendukung Anda belum lengkap. Silakan kirimkan dokumen/data tambahan agar dapat kami proses lebih lanjut.')" class="px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-[11px] font-medium shadow-2xs transition-colors cursor-pointer">
                                            + Berkas Belum Lengkap
                                        </button>
                                    </div>

                                    <textarea name="response" id="response-text-{{ $consultation->id }}" rows="3" class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all" placeholder="Tuliskan tanggapan, balasan, atau solusi untuk pemohon di sini..."></textarea>

                                    <!-- Keterangan Alur Konsultasi -->
                                    <div class="mt-2 text-[11px] text-slate-500 bg-slate-100/80 p-2.5 rounded-lg border border-slate-200/70 flex items-start gap-2">
                                        <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>
                                            Klik <strong>"Kirim Tanggapan"</strong> untuk membalas dan melanjutkan konsultasi dengan pemohon. Jika permasalahan telah tuntas dan ingin menutup percakapan, gunakan tombol <strong>"Selesai"</strong> di bagian atas.
                                        </span>
                                    </div>

                                    <!-- Tombol Aksi Status Otomatis & Notifikasi Email -->
                                    <div class="mt-3.5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 pt-3 border-t border-slate-200">
                                        <div class="text-[11.5px] text-slate-500 flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            <span>Notifikasi balasan otomatis dikirimkan ke <strong class="text-slate-700 font-semibold">{{ $consultation->email ?? 'email pemohon' }}</strong></span>
                                        </div>

                                        <div class="flex items-center gap-2 shrink-0">
                                            <button type="button" onclick="document.getElementById('reply-form-{{ $consultation->id }}').classList.add('hidden')" class="px-3.5 py-2 text-xs font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                                                Tutup Panel
                                            </button>

                                            <!-- Tombol Kirim Tanggapan: Konsultasi Tetap Berjalan -->
                                            <button type="submit" name="action" value="balas" class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-bold text-white bg-[#800000] hover:bg-[#600000] rounded-xl shadow-xs transition-all active:scale-95 cursor-pointer" title="Kirim tanggapan ini ke pemohon (konsultasi tetap aktif)">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                                <span>Kirim Tanggapan</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
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
    function insertTemplate(id, text) {
        var textarea = document.getElementById('response-text-' + id);
        if (textarea) {
            textarea.value = text;
            textarea.focus();
        }
    }

    function submitFinishConsultation(id, ticketId) {
        if (!confirm('Tandai tiket konsultasi #' + ticketId + ' sebagai SELESAI?\n\nPengkonsultasi tidak akan dapat mengirim pesan balasan lagi dan harus membuat pengajuan baru jika ingin berkonsultasi lagi.')) {
            return;
        }

        const form = document.getElementById('form-reply-' + id);
        if (form) {
            let actionInput = form.querySelector('input[name="action"]');
            if (!actionInput) {
                actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                form.appendChild(actionInput);
            }
            actionInput.value = 'selesai';
            form.submit();
        } else {
            const fallbackForm = document.createElement('form');
            fallbackForm.method = 'POST';
            fallbackForm.action = '{{ url("/admin/konsultasi") }}/' + id + '/reply';
            fallbackForm.innerHTML = `@csrf<input type="hidden" name="action" value="selesai">`;
            document.body.appendChild(fallbackForm);
            fallbackForm.submit();
        }
    }
</script>
@endsection
