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
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $consultation->ticket_id }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 mb-1">{{ $consultation->subject }}</div>
                                <p class="text-slate-600 line-clamp-2 text-xs leading-relaxed max-w-sm">{{ $consultation->message }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $consultation->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColor = match(strtolower($consultation->status)) {
                                        'menunggu' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                        'diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'selesai' => 'bg-green-50 text-green-700 border-green-200',
                                        default => 'bg-slate-50 text-slate-700 border-slate-200'
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-md text-xs font-medium border {{ $statusColor }}">
                                    {{ ucfirst($consultation->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($consultation->response)
                                    <div class="bg-green-50 border border-green-100 p-3 rounded-lg text-green-800 text-xs leading-relaxed max-w-sm">
                                        {{ $consultation->response }}
                                    </div>
                                @else
                                    <span class="text-slate-400 italic text-xs">Belum ada balasan</span>
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
