@extends('user.layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Riwayat Konsultasi Saya</h1>
            <a href="{{ route('konsultasi') }}" class="px-4 py-2 bg-[#800000] text-white rounded-lg hover:bg-red-800 transition-colors text-sm font-medium shadow-sm">
                + Konsultasi Baru
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold">
                        <tr>
                            <th class="px-6 py-4">ID Tiket</th>
                            <th class="px-6 py-4">Topik & Pertanyaan</th>
                            <th class="px-6 py-4">Tanggal Pengajuan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Balasan Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($consultations as $consultation)
                        <tr class="hover:bg-slate-50 transition-colors align-top">
                            <td class="px-6 py-4 font-medium text-slate-900">
                                <a href="{{ route('konsultasi.cek', ['ticket_id' => $consultation->ticket_id]) }}" class="text-[#800000] hover:underline font-mono text-xs font-bold block" title="Buka & Balas Percakapan">
                                    {{ $consultation->ticket_id }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 mb-1">{{ $consultation->subject }}</div>
                                <p class="text-slate-600 line-clamp-2 text-xs leading-relaxed max-w-sm">{{ $consultation->message }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $consultation->created_at->format('d M Y, H:i') }}</td>
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
                                        'diproses' => 'Sedang Diskusi',
                                        'selesai' => 'Selesai Tuntas',
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
                            <td class="px-6 py-4">
                                @if($consultation->response)
                                    @if($consultation->status == 'ditolak')
                                        <div class="bg-red-50 border border-red-200 p-3 rounded-lg text-red-900 text-xs leading-relaxed max-w-sm shadow-2xs">
                                            <span class="font-bold block text-red-800 uppercase tracking-wider text-[10px] mb-1">Alasan Penolakan:</span>
                                            {{ $consultation->response }}
                                        </div>
                                    @elseif($consultation->status == 'diterima')
                                        <div class="bg-emerald-50 border border-emerald-200 p-3 rounded-lg text-emerald-950 text-xs leading-relaxed max-w-sm shadow-2xs">
                                            <span class="font-bold block text-emerald-800 uppercase tracking-wider text-[10px] mb-1">Catatan Penerimaan:</span>
                                            {{ $consultation->response }}
                                        </div>
                                    @else
                                        <div class="bg-green-50 border border-green-100 p-3 rounded-lg text-green-800 text-xs leading-relaxed max-w-sm">
                                            <span class="font-bold block text-green-800 uppercase tracking-wider text-[10px] mb-1">Tanggapan Admin:</span>
                                            {{ $consultation->response }}
                                        </div>
                                    @endif
                                    <a href="{{ route('konsultasi.cek', ['ticket_id' => $consultation->ticket_id]) }}" class="mt-2 inline-flex items-center gap-1 text-[11px] font-bold text-[#800000] hover:underline">
                                        <span>Buka Percakapan & Solusi &rarr;</span>
                                    </a>
                                @else
                                    <div>
                                        <span class="text-slate-400 italic text-xs block mb-1.5">Belum ada balasan dari staf dinas</span>
                                        <a href="{{ route('konsultasi.cek', ['ticket_id' => $consultation->ticket_id]) }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-600 hover:text-[#800000] hover:underline">
                                            <span>Pantau Tiket &rarr;</span>
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 border border-slate-100">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <p class="text-slate-500 font-medium">Anda belum pernah mengajukan konsultasi.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>
@endsection
