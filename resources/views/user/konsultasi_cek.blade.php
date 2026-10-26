@extends('layouts.app')

@section('content')
<div class="bg-red-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10 reveal">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">Cek Status Konsultasi</h1>
            <p class="text-slate-600">Masukkan ID Tiket (UUID) Anda untuk melihat riwayat pertanyaan dan jawaban dari Admin Dinas Perdagangan Wonogiri.</p>
        </div>

        <!-- Search Card -->
        <div class="bg-white rounded-[24px] p-6 sm:p-8 shadow-sm border border-slate-100 mb-8 reveal delay-100">
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
                    
                    <div class="shrink-0">
                        @if($consultation->status == 'menunggu')
                            <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-bold shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Menunggu Balasan
                            </span>
                        @elseif($consultation->status == 'diproses')
                            <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-bold shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Sedang Diproses
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-bold shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Sudah Dijawab
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-6">
                    <!-- User Question -->
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold">
                                {{ substr($consultation->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-900">{{ $consultation->name }}</p>
                                <p class="text-xs text-slate-500">{{ $consultation->created_at->format('d M Y, H:i') }} • Topik: {{ $consultation->subject }}</p>
                            </div>
                        </div>
                        <div class="bg-slate-50 p-5 rounded-2xl text-slate-700 text-sm leading-relaxed border border-slate-100 ml-0 sm:ml-13">
                            {{ $consultation->message }}
                            
                            @if(!empty($consultation->attachments_list))
                                <div class="mt-4 pt-4 border-t border-slate-200">
                                    <p class="text-xs font-semibold text-slate-500 mb-2.5">Lampiran Berkas ({{ count($consultation->attachments_list) }}):</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                        @foreach($consultation->attachments_list as $attachItem)
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

                    <!-- Admin Response -->
                    <div class="pt-2">
                        @if($consultation->response)
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-full bg-[#800000] flex items-center justify-center text-white font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900">Admin Dinas Perdagangan</p>
                                    <p class="text-xs text-slate-500">{{ $consultation->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <div class="bg-red-50 p-5 rounded-2xl text-slate-800 text-sm leading-relaxed border border-red-100 ml-0 sm:ml-13 shadow-sm">
                                {!! nl2br(e($consultation->response)) !!}
                            </div>
                        @else
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-400 font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-400">Admin</p>
                                </div>
                            </div>
                            <div class="bg-slate-50 p-5 rounded-2xl text-slate-400 text-sm italic border border-slate-100 ml-0 sm:ml-13 text-center">
                                Admin belum memberikan balasan untuk pertanyaan ini.
                            </div>
                        @endif
                    </div>
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
            Swal.fire({
                icon: 'success',
                title: 'Konsultasi Berhasil Dikirim!',
                html: `
                    <p class="text-sm text-slate-600 mb-4">{!! session('success') !!}</p>
                    <div class="bg-red-50 border border-red-200 rounded-xl p-3.5 mb-3 text-center">
                        <span class="text-xs font-bold text-red-700 uppercase tracking-wider block mb-1">ID Tiket (UUID) Anda</span>
                        <span class="font-mono font-black text-[#800000] text-sm sm:text-base select-all break-all">{{ $ticketId ?? session('ticket_id') }}</span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200 mb-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>ID Tiket telah otomatis tersalin ke clipboard</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">URL di address bar browser Anda saat ini telah memuat ID Tiket tersebut. Simpan atau bookmark URL ini untuk melihat riwayat konsultasi.</p>
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
