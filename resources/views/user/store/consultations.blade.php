@extends('user.layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(isset($umkm) && $umkm)
            {{-- KARTU HERO PROFIL UMKM (Modern, Elegan & Lengkap) --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200/90 overflow-hidden mb-8">
                
                {{-- Bagian Atas: Banner Profil UMKM dengan Brand Marun Wonogiri --}}
                <div class="bg-gradient-to-r from-red-950 via-[#800000] to-red-900 text-white p-6 sm:p-8 relative overflow-hidden">
                    <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-amber-400/10 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute right-1/3 -top-20 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        
                        {{-- Identitas Usaha & Avatar --}}
                        <div class="flex items-start sm:items-center gap-5">
                            <div class="relative shrink-0">
                                @if($umkm->image_path)
                                    <img src="{{ asset('storage/' . $umkm->image_path) }}" alt="{{ $umkm->business_name }}" class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover shadow-xl border-2 border-white/40 ring-4 ring-black/10">
                                @else
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 text-slate-950 font-black text-3xl sm:text-4xl flex items-center justify-center shadow-xl border-2 border-white/40 ring-4 ring-black/10">
                                        {{ strtoupper(substr($umkm->business_name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div>
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    @if($umkm->status == 'verified')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-200 border border-emerald-400/40 backdrop-blur-md shadow-xs">
                                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                            Disetujui Dinas KUKM
                                        </span>
                                    @elseif($umkm->status == 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-200 border border-amber-400/40 backdrop-blur-md shadow-xs">
                                            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                            Menunggu Persetujuan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-500/20 text-rose-200 border border-rose-400/40 backdrop-blur-md shadow-xs">
                                            <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                                            Ditolak
                                        </span>
                                    @endif

                                    @if($umkm->nib)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-white/15 text-white/90 border border-white/20">
                                            <svg class="w-3 h-3 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            NIB Terdaftar
                                        </span>
                                    @endif
                                </div>

                                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight mb-2">{{ $umkm->business_name }}</h1>

                                <div class="flex flex-wrap items-center gap-y-1.5 gap-x-4 text-xs sm:text-sm text-red-100 font-medium">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $umkm->owner_name }}
                                    </span>
                                    <span>&bull;</span>
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        Kec. {{ $umkm->district ?? 'Wonogiri' }}, Wonogiri
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi Cepat Header --}}
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('konsultasi') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 hover:from-amber-500 hover:to-amber-700 text-slate-950 font-black text-xs sm:text-sm shadow-lg shadow-amber-950/20 active:scale-95 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                <span>Ajukan Konsultasi Baru</span>
                            </a>
                            <a href="{{ route('direktori', ['search' => $umkm->business_name]) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white border border-white/20 font-bold text-xs sm:text-sm backdrop-blur-md transition-all shadow-xs">
                                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                <span>Lihat di Direktori</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Bagian Bawah: Tab Navigasi Halaman Toko UMKM --}}
                <div class="px-6 sm:px-8 bg-white flex items-center gap-2 sm:gap-6 overflow-x-auto scrollbar-none py-2 border-t border-slate-100">
                    <a href="{{ route('toko.index') }}" class="py-3 px-4 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300 transition-all flex items-center gap-2 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <span>Katalog Produk</span>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-bold">{{ $productsCount ?? 0 }}</span>
                    </a>
                    <a href="{{ route('toko.profile') }}" class="py-3 px-4 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300 transition-all flex items-center gap-2 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>Profil Lengkap Usaha</span>
                    </a>
                    <a href="{{ route('toko.consultations') }}" class="py-3 px-4 text-sm font-black border-b-2 border-[#800000] text-[#800000] transition-all flex items-center gap-2 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <span>Riwayat Konsultasi</span>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-[#800000] font-black">{{ $consultations->count() }}</span>
                    </a>
                </div>
            </div>
        @endif

        {{-- Header Konten Konsultasi --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                    <span>Riwayat Konsultasi Online</span>
                    <span class="text-xs px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 font-bold">{{ $consultations->count() }} Tiket</span>
                </h1>
                <p class="text-xs text-slate-500 mt-1">Pantau respon, saran pendampingan perizinan, dan solusi dari staf Dinas KUKM Kabupaten Wonogiri.</p>
            </div>
            <a href="{{ route('konsultasi') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#800000] hover:bg-red-900 text-white rounded-xl font-bold text-xs sm:text-sm shadow-xs transition-all shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Ajukan Konsultasi Baru</span>
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xs border border-slate-200/90 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200/80 text-slate-600 font-bold text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">ID Tiket</th>
                            <th class="px-6 py-4">Topik & Pertanyaan</th>
                            <th class="px-6 py-4">Tanggal Pengajuan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Tanggapan Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($consultations as $consultation)
                        <tr class="hover:bg-slate-50/70 transition-colors align-top">
                            <td class="px-6 py-4 font-medium text-slate-900">
                                <a href="{{ route('konsultasi.cek', ['ticket_id' => $consultation->ticket_id]) }}" class="text-[#800000] hover:underline font-mono text-xs font-black block" title="Buka & Balas Percakapan">
                                    {{ $consultation->ticket_id }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 text-sm mb-1">{{ $consultation->subject }}</div>
                                <p class="text-slate-600 line-clamp-2 text-xs leading-relaxed max-w-sm">{{ $consultation->message }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">{{ $consultation->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColor = match(strtolower($consultation->status)) {
                                        'menunggu' => 'bg-amber-50 text-amber-800 border-amber-200',
                                        'diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'selesai', 'diterima' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'ditolak' => 'bg-rose-50 text-rose-700 border-rose-200',
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
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold border {{ $statusColor }} whitespace-nowrap">
                                    @if($consultation->status == 'menunggu')
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    @elseif($consultation->status == 'diproses')
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    @elseif($consultation->status == 'ditolak')
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    @else
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    @endif
                                    {{ $statusText }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($consultation->response)
                                    @if($consultation->status == 'ditolak')
                                        <div class="bg-rose-50 border border-rose-200 p-3 rounded-2xl text-rose-900 text-xs leading-relaxed max-w-sm shadow-2xs">
                                            <span class="font-bold block text-rose-800 uppercase tracking-wider text-[10px] mb-1">Alasan Penolakan:</span>
                                            {{ $consultation->response }}
                                        </div>
                                    @elseif($consultation->status == 'diterima')
                                        <div class="bg-emerald-50 border border-emerald-200 p-3 rounded-2xl text-emerald-950 text-xs leading-relaxed max-w-sm shadow-2xs">
                                            <span class="font-bold block text-emerald-800 uppercase tracking-wider text-[10px] mb-1">Catatan Penerimaan:</span>
                                            {{ $consultation->response }}
                                        </div>
                                    @else
                                        <div class="bg-emerald-50/70 border border-emerald-200 p-3 rounded-2xl text-emerald-900 text-xs leading-relaxed max-w-sm shadow-2xs">
                                            <span class="font-bold block text-emerald-800 uppercase tracking-wider text-[10px] mb-1">Tanggapan Admin:</span>
                                            {{ $consultation->response }}
                                        </div>
                                    @endif
                                    <a href="{{ route('konsultasi.cek', ['ticket_id' => $consultation->ticket_id]) }}" class="mt-2 inline-flex items-center gap-1 text-[11px] font-bold text-[#800000] hover:underline">
                                        <span>Buka Percakapan & Solusi &rarr;</span>
                                    </a>
                                @else
                                    <div>
                                        <span class="text-slate-400 italic text-xs block mb-1">Belum ada balasan dari staf dinas</span>
                                        <a href="{{ route('konsultasi.cek', ['ticket_id' => $consultation->ticket_id]) }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-600 hover:text-[#800000] hover:underline">
                                            <span>Pantau Tiket &rarr;</span>
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-red-50 text-[#800000] rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-inner">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <h3 class="text-base font-bold text-slate-800 mb-1">Belum ada riwayat konsultasi</h3>
                                <p class="text-xs text-slate-500 mb-4 max-w-sm mx-auto">Punya kendala perizinan NIB, sertifikasi halal, atau pemasaran produk? Staf Dinas siap membantu Anda.</p>
                                <a href="{{ route('konsultasi') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#800000] text-white rounded-xl text-xs font-bold hover:bg-red-900 transition-all shadow-xs">
                                    <span>Ajukan Pertanyaan Baru &rarr;</span>
                                </a>
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
