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
                                'diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'selesai' => 'bg-green-50 text-green-700 border-green-200',
                                default => 'bg-slate-50 text-slate-700 border-slate-200'
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-md text-xs font-medium border {{ $statusColor }}">
                            {{ ucfirst($consultation->status ?? 'menunggu') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="document.getElementById('reply-form-{{ $consultation->id }}').classList.toggle('hidden')" class="px-3 py-1.5 bg-slate-100 text-slate-700 border border-slate-200 rounded-md text-xs font-medium hover:bg-slate-200 transition-colors">Tindak Lanjut</button>
                    </td>
                </tr>
                <tr id="reply-form-{{ $consultation->id }}" class="hidden bg-slate-50 border-t border-slate-100">
                    <td colspan="6" class="p-6">
                        <div class="mb-4">
                            <h4 class="font-semibold text-slate-800 mb-1">Pertanyaan / Masalah:</h4>
                            <div class="bg-white p-4 rounded-lg border border-slate-200">
                                <p class="text-sm text-slate-600 mb-3">{{ $consultation->message }}</p>
                                
                                @if(!empty($consultation->attachments_list))
                                    <div class="pt-3 border-t border-slate-100">
                                        <p class="text-xs font-semibold text-slate-500 mb-2">Berkas Pendukung ({{ count($consultation->attachments_list) }}):</p>
                                        <div class="flex flex-wrap items-center gap-3">
                                            @foreach($consultation->attachments_list as $adminAttach)
                                                @php
                                                    $adminExt = pathinfo($adminAttach, PATHINFO_EXTENSION);
                                                    $adminIsImg = in_array(strtolower($adminExt), ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                                    $adminFileExists = file_exists(public_path('storage/' . $adminAttach)) || \Illuminate\Support\Facades\Storage::disk('public')->exists($adminAttach);
                                                @endphp
                                                @if(!$adminFileExists)
                                                    <div class="inline-flex items-center gap-2 px-3 py-2 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-xs shadow-2xs">
                                                        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                        <div>
                                                            <span class="font-semibold block">File fisik tidak ditemukan</span>
                                                            <span class="text-[10px] text-amber-700 font-mono">{{ basename($adminAttach) }}</span>
                                                        </div>
                                                    </div>
                                                @elseif($adminIsImg)
                                                    <div class="inline-flex items-center gap-3 bg-white p-2.5 rounded-xl border border-slate-200 shadow-2xs hover:shadow-sm transition-all">
                                                        <a href="{{ asset('storage/' . $adminAttach) }}" target="_blank" class="relative block group overflow-hidden rounded-lg shrink-0">
                                                            <img src="{{ asset('storage/' . $adminAttach) }}" alt="Lampiran Foto" class="w-16 h-16 object-cover rounded-lg border border-slate-100 group-hover:scale-105 transition-transform duration-200">
                                                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                            </div>
                                                        </a>
                                                        <div class="flex flex-col pr-2">
                                                            <span class="text-xs font-bold text-slate-800">Foto Lampiran {{ $loop->iteration }}</span>
                                                            <span class="text-[10px] text-slate-400 font-mono truncate max-w-[150px]" title="{{ basename($adminAttach) }}">{{ strtoupper($adminExt) }} &bull; {{ basename($adminAttach) }}</span>
                                                            <a href="{{ asset('storage/' . $adminAttach) }}" target="_blank" class="mt-1 inline-flex items-center gap-1 text-xs text-[#800000] hover:text-red-700 font-semibold">
                                                                <span>Buka Foto Penuh</span>
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <a href="{{ asset('storage/' . $adminAttach) }}" target="_blank" class="inline-flex items-center gap-2.5 px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors shadow-2xs text-xs font-medium text-slate-700">
                                                        <div class="w-8 h-8 rounded-lg bg-red-50 text-[#800000] flex items-center justify-center font-bold text-[10px]">
                                                            {{ strtoupper($adminExt) }}
                                                        </div>
                                                        <div class="flex flex-col">
                                                            <span class="text-slate-800 font-bold truncate max-w-[150px]">Dokumen {{ $loop->iteration }} ({{ strtoupper($adminExt) }})</span>
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
                        <form action="{{ route('admin.consultations.reply', $consultation->id) }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-semibold text-slate-700 mb-2">Ubah Status</label>
                                    <select name="status" class="w-full px-4 py-2.5 bg-white border-2 border-slate-300 rounded-xl text-sm text-slate-900 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all">
                                        <option value="menunggu" {{ strtolower($consultation->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="diproses" {{ strtolower($consultation->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ strtolower($consultation->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-xs font-semibold text-slate-700 mb-2">Balasan Admin</label>
                                    <textarea name="response" rows="3" class="w-full px-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all" placeholder="Tuliskan balasan atau tindak lanjut...">{{ $consultation->response }}</textarea>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="document.getElementById('reply-form-{{ $consultation->id }}').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50">Batal</button>
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-[#800000] rounded-lg hover:bg-red-900 shadow-sm">Simpan Tanggapan</button>
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
@endsection
