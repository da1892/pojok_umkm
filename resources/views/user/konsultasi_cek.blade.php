@extends('layouts.app')

@section('content')
<div class="bg-red-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10 reveal">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">Cek Status Konsultasi</h1>
            <p class="text-slate-600">Masukkan ID Tiket (UUID) Anda untuk melihat riwayat tanya-jawab dan jawaban resmi dari Admin Dinas Perdagangan Wonogiri.</p>
        </div>

        <!-- Search Card -->
        <div class="bg-white rounded-[24px] p-6 sm:p-8 shadow-sm border border-slate-100 mb-8 reveal delay-100">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl font-medium text-sm text-center flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl font-medium text-sm text-center">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-6 p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl font-medium text-sm text-center">
                    {{ session('warning') }}
                </div>
            @endif

            <form id="cekKonsultasiForm" action="{{ route('konsultasi.cek') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1 relative">
                    <input type="text" id="ticketIdInput" name="ticket_id" value="{{ $ticketId ?? request('ticket_id') }}" required placeholder="Masukkan ID Tiket (UUID)..." class="w-full px-4 py-3.5 pr-10 rounded-xl border-2 border-slate-300 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none transition-all text-slate-900 bg-white placeholder:text-slate-400 font-mono text-sm sm:text-base shadow-xs">
                    
                    @if(!empty($ticketId ?? request('ticket_id')))
                        <button type="button" onclick="document.getElementById('ticketIdInput').value=''; document.getElementById('ticketIdInput').focus();" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 rounded-full hover:bg-slate-100 transition-colors" title="Kosongkan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    @endif
                </div>
                <button type="submit" class="bg-[#800000] hover:bg-[#600000] text-white px-8 py-3.5 rounded-xl font-bold transition-all shadow-md shrink-0 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>Cek Status</span>
                </button>
            </form>
        </div>

        <!-- Result Card -->
        @if(isset($consultations) && $consultations->count() > 0)
        <div class="space-y-6 reveal delay-200">
            @foreach($consultations as $consultation)
            <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="border-b border-slate-100 bg-slate-50 p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="space-y-1.5">
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Nomor Tiket Konsultasi</p>
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                            <h3 class="text-lg sm:text-xl font-black font-mono text-[#800000] select-all tracking-wide break-all">{{ $consultation->ticket_id }}</h3>
                            
                            <!-- Tombol Salin ID -->
                            <button type="button" onclick="copyTicketId('{{ $consultation->ticket_id }}', this)" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-100/70 hover:bg-red-100 text-[#800000] border border-red-200 rounded-lg text-xs font-bold transition-all shadow-2xs active:scale-95 shrink-0" title="Salin ID Tiket ke Clipboard">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span class="copy-label">Salin ID</span>
                            </button>

                            <!-- Tombol Salin Link URL -->
                            <button type="button" onclick="copyDirectUrl('{{ route('konsultasi.cek', ['ticket_id' => $consultation->ticket_id]) }}', this)" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-xs font-semibold transition-all shadow-2xs active:scale-95 shrink-0" title="Salin Link Status Langsung">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                <span class="copy-url-label">Salin Link</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2.5 shrink-0 flex-wrap">
                        @if($consultation->status !== 'selesai' && $consultation->status !== 'ditolak')
                        <button type="button" onclick="openFinishModal('{{ $consultation->ticket_id }}', '{{ $consultation->id }}')" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-all shadow-xs hover:shadow-sm active:scale-95 cursor-pointer" title="Tandai Selesai jika kendala/pertanyaan Anda sudah terjawab">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Selesaikan Sesi</span>
                        </button>
                        @endif

                        @if($consultation->status == 'menunggu')
                            <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-bold shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Menunggu Balasan
                            </span>
                        @elseif($consultation->status == 'diterima')
                            <span class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-800 px-4 py-2 rounded-full text-sm font-bold shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Konsultasi Diterima
                            </span>
                        @elseif($consultation->status == 'diproses')
                            <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-bold shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Sedang Diproses
                            </span>
                        @elseif($consultation->status == 'ditolak')
                            <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-800 px-4 py-2 rounded-full text-sm font-bold shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Konsultasi Ditolak
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-800 px-4 py-2 rounded-full text-sm font-bold shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Selesai Tuntas
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Visual Stepper / Tracker Alur Konsultasi -->
                <div class="px-6 py-6 bg-gradient-to-r from-slate-50 via-white to-slate-50 border-b border-slate-100">
                    <div class="max-w-2xl mx-auto">
                        <div class="relative flex items-center justify-between">
                            <!-- Garis Background Penghubung -->
                            <div class="absolute left-8 right-8 top-5 -translate-y-1/2 h-1 bg-slate-200 -z-0"></div>
                            
                            <!-- Garis Progress Aktif -->
                            @php
                                $stepWidth = match(strtolower((string)$consultation->status)) {
                                    'menunggu' => 'w-[15%]',
                                    'diproses' => 'w-[55%]',
                                    'selesai', 'diterima' => 'w-[100%]',
                                    'ditolak' => 'w-[100%]',
                                    default => 'w-[15%]'
                                };
                                $stepColor = strtolower((string)$consultation->status) === 'ditolak' ? 'bg-red-500' : 'bg-emerald-500';
                            @endphp
                            <div class="absolute left-8 top-5 -translate-y-1/2 h-1 {{ $stepColor }} {{ $stepWidth }} transition-all duration-700 -z-0"></div>

                            <!-- Tahap 1: Pengajuan Tiket -->
                            <div class="relative z-10 flex flex-col items-center text-center">
                                <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div class="mt-2.5">
                                    <p class="text-xs font-bold text-slate-800">1. Tiket Terbit</p>
                                    <p class="text-[10px] text-slate-500 font-mono">{{ $consultation->created_at ? $consultation->created_at->format('d M Y') : '' }}</p>
                                </div>
                            </div>

                            <!-- Tahap 2: Pembahasan Solusi & Telaah -->
                            <div class="relative z-10 flex flex-col items-center text-center">
                                @if(strtolower((string)$consultation->status) === 'menunggu')
                                    <div class="w-10 h-10 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white animate-pulse">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div class="mt-2.5">
                                        <p class="text-xs font-bold text-amber-700">2. Menunggu Telaah</p>
                                        <p class="text-[10px] text-amber-600 font-medium">Antrean Ditinjau Admin</p>
                                    </div>
                                @elseif(strtolower((string)$consultation->status) === 'ditolak')
                                    <div class="w-10 h-10 rounded-full bg-red-600 text-white flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </div>
                                    <div class="mt-2.5">
                                        <p class="text-xs font-bold text-red-700">2. Ditolak</p>
                                        <p class="text-[10px] text-red-500">Topik / Berkas Tidak Sesuai</p>
                                    </div>
                                @elseif(strtolower((string)$consultation->status) === 'diproses')
                                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white animate-pulse">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    </div>
                                    <div class="mt-2.5">
                                        <p class="text-xs font-bold text-blue-700">2. Diskusi & Telaah</p>
                                        <p class="text-[10px] text-blue-600 font-medium">Saling Jawab Aktif</p>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="mt-2.5">
                                        <p class="text-xs font-bold text-emerald-800">2. Solusi Diberikan</p>
                                        <p class="text-[10px] text-emerald-600 font-medium">Arahan Tuntas</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Tahap 3: Penyelesaian Tuntas -->
                            <div class="relative z-10 flex flex-col items-center text-center">
                                @if(strtolower((string)$consultation->status) === 'selesai' || strtolower((string)$consultation->status) === 'diterima')
                                    <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div class="mt-2.5">
                                        <p class="text-xs font-bold text-emerald-800">3. Selesai Tuntas</p>
                                        <p class="text-[10px] text-emerald-600 font-medium">Tiket Selesai & Ditutup</p>
                                    </div>
                                @elseif(strtolower((string)$consultation->status) === 'ditolak')
                                    <div class="w-10 h-10 rounded-full bg-slate-300 text-slate-500 flex items-center justify-center font-bold text-sm shadow-xs ring-4 ring-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </div>
                                    <div class="mt-2.5">
                                        <p class="text-xs font-bold text-slate-500">3. Ditutup</p>
                                        <p class="text-[10px] text-slate-400">Pengajuan Ditolak</p>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-400 border border-slate-200 flex items-center justify-center font-bold text-sm shadow-2xs ring-4 ring-white">
                                        <span class="text-xs">3</span>
                                    </div>
                                    <div class="mt-2.5">
                                        <p class="text-xs font-bold text-slate-400">3. Penyelesaian</p>
                                        <p class="text-[10px] text-slate-400 font-medium">Konfirmasi Selesai</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-6">
                    <!-- Thread Percakapan (Saling Jawab) -->
                    <div class="space-y-6">
                        @php
                            $hasAdminReply = false;
                        @endphp

                        @foreach($consultation->thread_messages as $msg)
                            @if($msg->sender_type == 'user')
                                @if(str_contains($msg->message, 'KONSULTASI DISELESAIKAN OLEH PEMOHON') || str_contains($msg->message, 'SESI KONSULTASI DISELESAIKAN'))
                                    <!-- Kartu Penyelesaian Sesi Oleh Pemohon -->
                                    <div class="reveal">
                                        <div class="bg-gradient-to-br from-emerald-50 via-teal-50/50 to-green-50 border-2 border-emerald-300 rounded-2xl p-6 shadow-sm">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3 pb-3 border-b border-emerald-200">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shadow-xs shrink-0">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                    </div>
                                                    <div>
                                                        <div class="flex items-center gap-2">
                                                            <h4 class="font-black text-slate-900 text-sm sm:text-base">Konsultasi Diselesaikan oleh Pemohon</h4>
                                                            <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-emerald-200">Selesai Tuntas</span>
                                                        </div>
                                                        <p class="text-xs text-slate-500 font-mono">{{ $msg->created_at ? $msg->created_at->format('d M Y, H:i') : '' }} WIB &bull; Pemohon: <span class="font-semibold text-slate-700">{{ $msg->sender_name ?: $consultation->name }}</span></p>
                                                    </div>
                                                </div>
                                                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white text-emerald-800 border border-emerald-200 rounded-full text-xs font-bold shadow-2xs self-start sm:self-center">
                                                    <span>✓ Kasus Tuntas</span>
                                                </div>
                                            </div>
                                            <div class="whitespace-pre-line text-sm text-slate-800 leading-relaxed font-medium pl-1">
                                                {!! nl2br(e($msg->message)) !!}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Pesan Pengguna (Pemohon) Biasa -->
                                    <div class="reveal">
                                        <div class="flex items-center gap-3 mb-2.5">
                                            <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-sm shadow-2xs shrink-0">
                                                {{ substr($msg->sender_name ?: $consultation->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <p class="font-bold text-slate-900 text-sm sm:text-base">{{ $msg->sender_name ?: $consultation->name }}</p>
                                                    <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2 py-0.5 rounded-full">Pemohon</span>
                                                </div>
                                                <p class="text-xs text-slate-500 font-mono">
                                                    {{ $msg->created_at ? $msg->created_at->format('d M Y, H:i') : '' }} WIB
                                                    @if($loop->first)
                                                        &bull; Topik: <span class="font-semibold text-slate-700">{{ $consultation->subject }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-slate-50 p-5 rounded-2xl text-slate-800 text-sm leading-relaxed border border-slate-200 ml-0 sm:ml-13 shadow-2xs">
                                            <div class="whitespace-pre-line">{{ $msg->message }}</div>
                                        
                                        @if(!empty($msg->attachments_list))
                                            <div class="mt-4 pt-4 border-t border-slate-200">
                                                <p class="text-xs font-semibold text-slate-500 mb-2.5">Lampiran Berkas ({{ count($msg->attachments_list) }}):</p>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                                    @foreach($msg->attachments_list as $attachItem)
                                                        @php
                                                            $extension = is_object($attachItem) ? $attachItem->extension : pathinfo((string)$attachItem, PATHINFO_EXTENSION);
                                                            $isImage = is_object($attachItem) ? $attachItem->is_image : in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                                            $attachFileExists = is_object($attachItem) ? $attachItem->exists : (file_exists(public_path('storage/' . $attachItem)) || \Illuminate\Support\Facades\Storage::disk('public')->exists((string)$attachItem));
                                                            $attachSrc = is_object($attachItem) ? $attachItem->view_url : asset('storage/' . $attachItem);
                                                            $attachName = is_object($attachItem) ? $attachItem->name : basename((string)$attachItem);
                                                        @endphp
                                                        @if(!$attachFileExists)
                                                            <div class="bg-amber-50 p-3 rounded-xl border border-amber-200 flex items-center gap-2.5 text-xs text-amber-800">
                                                                <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                                <div class="overflow-hidden">
                                                                    <span class="font-semibold block truncate">File belum tersinkron</span>
                                                                    <span class="text-[10px] text-amber-700 font-mono truncate block">{{ $attachName }}</span>
                                                                </div>
                                                            </div>
                                                        @elseif($isImage)
                                                            <div class="space-y-1.5 bg-white p-2.5 rounded-xl border border-slate-200">
                                                                <a href="{{ $attachSrc }}" target="_blank" class="block group overflow-hidden rounded-lg">
                                                                    <img src="{{ $attachSrc }}" alt="Lampiran" class="w-full h-36 object-cover rounded-lg border border-slate-100 group-hover:scale-105 transition-all">
                                                                </a>
                                                                <a href="{{ $attachSrc }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-[#800000] font-semibold hover:underline">
                                                                    <span>Lihat Gambar Penuh</span>
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="bg-white p-3 rounded-xl border border-slate-200 flex items-center justify-between">
                                                                <div class="flex items-center gap-2 overflow-hidden">
                                                                    <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                                    <span class="text-xs font-semibold text-slate-700 truncate">{{ $attachName }} ({{ strtoupper($extension) }})</span>
                                                                </div>
                                                                <a href="{{ $attachSrc }}" target="_blank" download="{{ $attachName }}" class="shrink-0 text-xs text-[#800000] font-bold hover:underline ml-2">
                                                                    Unduh &rarr;
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            @else
                                @php
                                    $hasAdminReply = true;
                                @endphp
                                <!-- Balasan / Tanggapan Admin Dinas -->
                                <div class="reveal">
                                    <div class="flex items-center gap-3 mb-2.5">
                                        <div class="w-10 h-10 rounded-full bg-[#800000] text-white flex items-center justify-center font-bold text-sm shadow-xs shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <p class="font-bold text-slate-900 text-sm sm:text-base">{{ $msg->sender_name ?: 'Admin Dinas Perdagangan & KUKM' }}</p>
                                                <span class="bg-red-100 text-[#800000] text-[10px] font-bold px-2 py-0.5 rounded-full border border-red-200">Admin Resmi</span>
                                            </div>
                                            <p class="text-xs text-slate-500 font-mono">{{ $msg->created_at ? $msg->created_at->format('d M Y, H:i') : '' }} WIB</p>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-gradient-to-r from-red-50/50 via-rose-50/30 to-slate-50 p-5 rounded-2xl text-slate-800 text-sm leading-relaxed border-2 border-red-100 ml-0 sm:ml-13 shadow-xs">
                                        <div class="flex items-center gap-2 mb-2 text-[#800000] font-bold text-xs uppercase tracking-wider">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                            <span>Tanggapan Admin:</span>
                                        </div>
                                        <div class="whitespace-pre-line text-slate-800 font-normal leading-relaxed">{!! nl2br(e($msg->message)) !!}</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        @if(!$hasAdminReply)
                            <!-- Placeholder Jika Admin Belum Memberikan Tanggapan -->
                            <div class="reveal">
                                <div class="flex items-center gap-3 mb-2.5">
                                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-400 font-bold shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-400">Admin</p>
                                    </div>
                                </div>
                                <div class="bg-slate-50 p-5 rounded-2xl text-slate-400 text-sm italic border border-slate-100 ml-0 sm:ml-13 text-center">
                                    Admin belum memberikan balasan untuk pertanyaan ini.
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Area Balasan Saling Jawab (Turn Constraint) -->
                    @if(strtolower((string)$consultation->status) === 'selesai')
                        <!-- Konsultasi Telah Selesai: Pengkonsultasi tidak bisa mengirim pesan lagi -->
                        <div class="mt-8 pt-6 border-t border-slate-200 reveal">
                            <div class="bg-gradient-to-r from-emerald-50 via-teal-50 to-slate-50 border-2 border-emerald-300 rounded-2xl p-6 sm:p-8 shadow-xs text-center">
                                <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center mx-auto mb-3.5 shadow-md shadow-emerald-600/20">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <h4 class="text-lg sm:text-xl font-black text-slate-900 mb-1.5">Konsultasi Ini Telah Selesai</h4>
                                <p class="text-sm text-slate-600 max-w-xl mx-auto leading-relaxed mb-6">
                                    Sesi percakapan pada tiket ini telah dinyatakan <strong>selesai</strong> oleh Admin Dinas Perdagangan & KUKM Kabupaten Wonogiri. Tiket telah ditutup sehingga Anda tidak dapat mengirim pesan balasan lagi pada sesi ini. Jika Anda memerlukan konsultasi atau memiliki pertanyaan baru, silakan ajukan konsultasi baru.
                                </p>
                                <div class="inline-flex flex-col sm:flex-row items-center justify-center gap-3">
                                    <a href="{{ route('konsultasi') }}" class="inline-flex items-center gap-2 px-6 py-3.5 bg-[#800000] hover:bg-[#600000] text-white font-bold text-sm rounded-xl shadow-md transition-all active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        <span>Buat Pengajuan Konsultasi Baru</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @elseif(strtolower((string)$consultation->status) === 'ditolak')
                        <!-- Konsultasi Ditolak -->
                        <div class="mt-8 pt-6 border-t border-slate-200 reveal">
                            <div class="bg-red-50 border-2 border-red-200 rounded-2xl p-6 shadow-xs text-center">
                                <div class="w-12 h-12 rounded-2xl bg-red-600 text-white flex items-center justify-center mx-auto mb-3 shadow-md">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </div>
                                <h4 class="text-base font-bold text-slate-900 mb-1">Pengajuan Konsultasi Ditolak</h4>
                                <p class="text-xs sm:text-sm text-slate-600 max-w-lg mx-auto leading-relaxed mb-4">
                                    Pengajuan tiket konsultasi ini telah ditolak oleh Admin. Sesi percakapan ditutup. Jika Anda memiliki pertanyaan lain atau ingin melengkapi dokumen, silakan buat pengajuan konsultasi baru.
                                </p>
                                <a href="{{ route('konsultasi') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#800000] hover:bg-[#600000] text-white font-bold text-xs rounded-xl shadow-sm transition-all">
                                    <span>Buat Pengajuan Konsultasi Baru &rarr;</span>
                                </a>
                            </div>
                        </div>
                    @elseif($consultation->canUserReply())
                        <!-- Form Balas Aktif: Hanya muncul jika pertanyaan sudah dijawab admin dan tiket masih terbuka -->
                        <div class="mt-8 pt-8 border-t border-slate-200 reveal">
                            <div class="bg-gradient-to-r from-red-50/70 via-rose-50/50 to-white border-2 border-red-200 rounded-2xl p-6 sm:p-7 shadow-xs">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-[#800000] text-white flex items-center justify-center font-bold text-sm shadow-xs shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-900 text-base">Balas Tanggapan Admin</h4>
                                            <p class="text-xs text-slate-500">Pertanyaan Anda telah dijawab oleh Admin. Kirim balasan lanjutan atau selesaikan sesi jika sudah cukup.</p>
                                        </div>
                                    </div>

                                    <button type="button" onclick="openFinishModal('{{ $consultation->ticket_id }}', '{{ $consultation->id }}')" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-xs active:scale-95 cursor-pointer shrink-0" title="Tandai Selesai jika kendala Anda sudah terjawab">
                                        <svg class="w-3.5 h-3.5 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span>✓ Masalah Sudah Selesai</span>
                                    </button>
                                </div>

                                <form action="{{ route('konsultasi.cek.balas', ['ticket_id' => $consultation->ticket_id]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Pesan / Tanggapan Balasan <span class="text-red-500">*</span></label>
                                        <textarea name="message" rows="4" required placeholder="Tuliskan balasan atau pertanyaan lanjutan Anda untuk Admin Dinas di sini..." class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all resize-y"></textarea>
                                        @error('message')
                                            <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Lampirkan Berkas Pendukung (Opsional, Maks. 3 file @ 5MB):</label>
                                        <input type="file" name="attachments[]" multiple accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx" class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-[#800000] hover:file:bg-red-100 cursor-pointer border border-slate-200 rounded-xl bg-white p-1.5">
                                        <p class="text-[11px] text-slate-400 mt-1">Format file didukung: JPG, PNG, WEBP, PDF, DOC, DOCX.</p>
                                    </div>

                                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 pt-2">
                                        <span class="text-[11.5px] text-slate-500 italic">
                                            * Catatan: Anda baru dapat mengirim balasan berikutnya setelah Admin memberikan jawaban kembali.
                                        </span>
                                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-[#800000] hover:bg-[#600000] text-white font-bold text-sm rounded-xl shadow-md transition-all active:scale-95 shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                            <span>Kirim Balasan</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Form Terkunci: Menunggu Tanggapan Admin -->
                        <div class="mt-8 pt-6 border-t border-slate-200 reveal">
                            <div class="bg-amber-50/90 border border-amber-200 rounded-2xl p-5 flex flex-col sm:flex-row items-center justify-center gap-3.5 text-center sm:text-left shadow-2xs">
                                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 shrink-0">
                                    <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <h5 class="text-xs font-bold uppercase tracking-wider text-amber-900">Menunggu Tanggapan Admin Dinas</h5>
                                    <p class="text-xs text-amber-800 mt-0.5 leading-relaxed">
                                        Pertanyaan terakhir Anda sedang ditinjau oleh Admin Dinas Perdagangan & KUKM Wonogiri. Tombol balas akan otomatis terbuka kembali setelah Admin memberikan tanggapan untuk pertanyaan Anda.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modal Konfirmasi Selesai Konsultasi Interaktif -->
            <div id="modalFinishConsultation_{{ $consultation->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
                <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-100 relative transform transition-all duration-300 scale-95 opacity-0 modal-container">
                    
                    <!-- Tombol Close Modal -->
                    <button type="button" onclick="closeFinishModal('{{ $consultation->id }}')" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600 p-2 rounded-full hover:bg-slate-100 transition-colors" title="Batal & Tutup">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <form action="{{ route('konsultasi.cek.selesai', ['ticket_id' => $consultation->ticket_id]) }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <div class="text-center">
                            <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center mx-auto mb-4 shadow-sm">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono font-bold bg-emerald-100 text-emerald-800 mb-2">
                                TIKET #{{ $consultation->ticket_id }}
                            </span>
                            <h3 class="text-xl font-black text-slate-900">Selesaikan Sesi Konsultasi?</h3>
                            <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-sm mx-auto leading-relaxed">
                                Tandai sesi ini sebagai selesai jika seluruh kendala atau pertanyaan usaha Anda telah terjawab dengan jelas oleh Admin Dinas.
                            </p>
                        </div>

                        <!-- Rating Bintang Kepuasan -->
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-center">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Tingkat Kepuasan Pelayanan Dinas:
                            </label>
                            <div class="flex items-center justify-center gap-2 mb-2" id="starGroup_{{ $consultation->id }}">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="setRating('{{ $consultation->id }}', {{ $i }})" class="star-btn-{{ $consultation->id }} text-3xl transition-transform hover:scale-125 focus:outline-none cursor-pointer" data-value="{{ $i }}" title="{{ $i }} Bintang">
                                        ⭐
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="ratingInput_{{ $consultation->id }}" value="5">
                            <p class="text-xs font-bold text-emerald-700" id="ratingLabel_{{ $consultation->id }}">
                                Sangat Puas ⭐⭐⭐⭐⭐ (5/5)
                            </p>
                        </div>

                        <!-- Catatan / Ulasan Pemohon (Opsional) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                Catatan / Ulasan / Ucapan Terima Kasih (Opsional):
                            </label>
                            <textarea name="feedback" rows="3" placeholder="Contoh: Terima kasih banyak atas panduan sertifikasi halal & NIB-nya, penjelasan staf dinas sangat jelas dan mudah dipahami..." class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-emerald-500/15 focus:border-emerald-600 outline-none transition-all resize-none shadow-xs"></textarea>
                            <p class="text-[11px] text-slate-400 mt-1">Ulasan Anda akan tercatat resmi di riwayat sesi konsultasi.</p>
                        </div>

                        <!-- Tombol Batal & Konfirmasi Selesai -->
                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <button type="button" onclick="closeFinishModal('{{ $consultation->id }}')" class="w-full px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs sm:text-sm transition-all cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" class="w-full px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs sm:text-sm shadow-md shadow-emerald-600/20 transition-all active:scale-95 cursor-pointer flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Ya, Selesaikan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
            
            <div class="text-center pt-6 mt-6">
                <a href="{{ route('konsultasi') }}" class="text-[#800000] font-bold text-sm hover:underline bg-white px-6 py-3 rounded-xl shadow-sm border border-slate-200 inline-block">
                    &larr; Buat Pengajuan Konsultasi Baru
                </a>
            </div>
        </div>
        @endif
        
    </div>
</div>

<!-- SweetAlert2 & Auto-Copy Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fungsi copy ke clipboard dengan fallback
    function copyToClipboard(text) {
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text).catch(function() {
                return fallbackCopyTextToClipboard(text);
            });
        } else {
            return fallbackCopyTextToClipboard(text);
        }
    }

    function fallbackCopyTextToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        textArea.style.top = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        return new Promise(function(resolve, reject) {
            try {
                var successful = document.execCommand('copy');
                document.body.removeChild(textArea);
                if (successful) resolve(); else reject();
            } catch (err) {
                document.body.removeChild(textArea);
                reject(err);
            }
        });
    }

    // Floating Toast Notification
    function showToast(message, icon) {
        icon = icon || '✓';
        var toast = document.createElement('div');
        toast.className = 'fixed bottom-6 right-6 z-50 flex items-center gap-2.5 bg-slate-900 text-white px-5 py-3 rounded-2xl shadow-2xl border border-slate-700 font-medium text-sm transition-all duration-300 transform translate-y-8 opacity-0';
        toast.innerHTML = '<span class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold shrink-0">' + icon + '</span><span>' + message + '</span>';
        document.body.appendChild(toast);
        
        requestAnimationFrame(function() {
            toast.classList.remove('translate-y-8', 'opacity-0');
        });

        setTimeout(function() {
            toast.classList.add('translate-y-8', 'opacity-0');
            setTimeout(function() { toast.remove(); }, 350);
        }, 3000);
    }

    // Salin ID Tiket Manual
    function copyTicketId(id, btnElement) {
        copyToClipboard(id).then(function() {
            if (btnElement) {
                var label = btnElement.querySelector('.copy-label');
                var originalText = label ? label.textContent : '';
                if (label) label.textContent = 'Tersalin! ✓';
                btnElement.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
                setTimeout(function() {
                    if (label) label.textContent = originalText;
                    btnElement.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
                }, 2000);
            }
            showToast('ID Tiket berhasil disalin ke clipboard!');
        }).catch(function() {
            showToast('Gagal menyalin otomatis, silakan salin manual.', '!');
        });
    }

    // Salin URL Langsung
    function copyDirectUrl(url, btnElement) {
        copyToClipboard(url).then(function() {
            if (btnElement) {
                var label = btnElement.querySelector('.copy-url-label');
                var originalText = label ? label.textContent : '';
                if (label) label.textContent = 'Link Tersalin! ✓';
                btnElement.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
                setTimeout(function() {
                    if (label) label.textContent = originalText;
                    btnElement.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
                }, 2000);
            }
            showToast('Link halaman status berhasil disalin ke clipboard!');
        }).catch(function() {
            showToast('Gagal menyalin link.', '!');
        });
    }

    // Modal Selesaikan Sesi Konsultasi Interaktif
    function openFinishModal(ticketId, id) {
        var modal = document.getElementById('modalFinishConsultation_' + id);
        if (modal) {
            modal.classList.remove('hidden');
            setTimeout(function() {
                var container = modal.querySelector('.modal-container');
                if (container) {
                    container.classList.remove('scale-95', 'opacity-0');
                    container.classList.add('scale-100', 'opacity-100');
                }
            }, 20);
        }
    }

    function closeFinishModal(id) {
        var modal = document.getElementById('modalFinishConsultation_' + id);
        if (modal) {
            var container = modal.querySelector('.modal-container');
            if (container) {
                container.classList.remove('scale-100', 'opacity-100');
                container.classList.add('scale-95', 'opacity-0');
            }
            setTimeout(function() {
                modal.classList.add('hidden');
            }, 200);
        }
    }

    function setRating(id, val) {
        var input = document.getElementById('ratingInput_' + id);
        if (input) input.value = val;

        var label = document.getElementById('ratingLabel_' + id);
        var labels = {
            5: 'Sangat Puas ⭐⭐⭐⭐⭐ (5/5)',
            4: 'Puas ⭐⭐⭐⭐ (4/5)',
            3: 'Cukup ⭐⭐⭐ (3/5)',
            2: 'Kurang Puas ⭐⭐ (2/5)',
            1: 'Tidak Puas ⭐ (1/5)'
        };
        if (label && labels[val]) {
            label.textContent = labels[val];
        }

        var buttons = document.querySelectorAll('.star-btn-' + id);
        buttons.forEach(function(btn) {
            var btnVal = parseInt(btn.getAttribute('data-value'));
            if (btnVal <= val) {
                btn.style.opacity = '1';
                btn.style.filter = 'none';
            } else {
                btn.style.opacity = '0.35';
                btn.style.filter = 'grayscale(100%)';
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Intercept form submit agar diarahkan langsung ke URL path: /konsultasi/cek/{ticket_id}
        var form = document.getElementById('cekKonsultasiForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var input = document.getElementById('ticketIdInput');
                var val = input ? input.value.trim() : '';
                if (val) {
                    window.location.href = "{{ url('/konsultasi/cek') }}/" + encodeURIComponent(val);
                }
            });
        }

        @if(!empty($ticketId))
            // Otomatis salin ID ke clipboard saat halaman dimuat
            copyToClipboard('{{ $ticketId }}').then(function() {
                @if(session('auto_copy'))
                    showToast('ID Tiket Anda berhasil disalin otomatis ke clipboard!');
                @endif
            }).catch(function() {});
        @endif

        @if(session('success'))
            var successMessage = {!! json_encode(session('success')) !!};
            var isReply = successMessage.toLowerCase().includes('balasan');
            Swal.fire({
                icon: 'success',
                title: isReply ? 'Balasan Terkirim!' : 'Konsultasi Berhasil Dikirim!',
                html: `
                    <p class="text-sm text-slate-600 mb-4">{!! session('success') !!}</p>
                    <div class="bg-red-50 border border-red-200 rounded-xl p-3.5 mb-3 text-center">
                        <span class="text-xs font-bold text-red-700 uppercase tracking-wider block mb-1">ID Tiket (UUID) Anda</span>
                        <span class="font-mono font-black text-[#800000] text-sm sm:text-base select-all break-all">{{ $ticketId ?? session('ticket_id') }}</span>
                    </div>
                    @if(session('auto_copy'))
                    <div class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200 mb-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>ID Tiket telah otomatis tersalin ke clipboard</span>
                    </div>
                    @endif
                    <p class="text-xs text-slate-500 mt-2">Simpan atau bookmark tautan ini untuk terus memantau tanggapan dan perkembangan konsultasi Anda.</p>
                `,
                confirmButtonColor: '#800000',
                confirmButtonText: 'Tutup & Mengerti',
                customClass: {
                    title: 'text-xl font-bold text-slate-800',
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5'
                }
            });
        @endif
    });
</script>
@endsection
