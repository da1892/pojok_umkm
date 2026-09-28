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
                            <p class="text-sm text-slate-600 bg-white p-4 rounded-lg border border-slate-200">{{ $consultation->message }}</p>
                        </div>
                        <form action="{{ route('admin.consultations.reply', $consultation->id) }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-semibold text-slate-700 mb-2">Ubah Status</label>
                                    <select name="status" class="w-full text-sm border-slate-200 rounded-lg focus:ring-[#800000] focus:border-[#800000]">
                                        <option value="menunggu" {{ strtolower($consultation->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="diproses" {{ strtolower($consultation->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ strtolower($consultation->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-xs font-semibold text-slate-700 mb-2">Balasan Admin</label>
                                    <textarea name="response" rows="3" class="w-full text-sm border-slate-200 rounded-lg focus:ring-[#800000] focus:border-[#800000]" placeholder="Tuliskan balasan atau tindak lanjut...">{{ $consultation->response }}</textarea>
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
                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                        Belum ada tiket konsultasi.
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
