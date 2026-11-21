@extends('layouts.admin')

@section('page_title', 'Data UMKM')

@section('content')
<div class="bg-white rounded-2xl shadow-xs border border-slate-200/90 overflow-hidden">
    <!-- Header: Judul & Tombol Aksi Utama -->
    <div class="p-4 sm:p-5 lg:p-6 border-b border-slate-200/80 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <h3 class="font-black text-slate-800 text-lg sm:text-xl tracking-tight">Kelola Data UMKM</h3>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-red-100 text-[#800000] border border-red-200">
                    {{ $umkms->total() }} Data
                </span>
            </div>
            <p class="text-slate-500 text-xs sm:text-sm mt-1">Daftar semua UMKM Kabupaten Wonogiri yang terdaftar di sistem. Kelola data, status, dan produk.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 shrink-0">
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-1.5 px-3 sm:px-3.5 py-2 text-xs font-bold text-white bg-[#800000] hover:bg-[#600000] rounded-xl shadow-xs transition-all cursor-pointer h-10" title="Tambah Akun Pelaku UMKM Baru">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Akun UMKM</span>
            </a>
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-1.5 px-3 sm:px-3.5 py-2 text-xs font-bold text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-300 rounded-xl transition-all cursor-pointer h-10" title="Tambah produk baru untuk UMKM terdaftar">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Tambah Produk</span>
            </a>
            <a href="{{ route('admin.users.index') }}#modal-import" class="inline-flex items-center gap-1.5 px-3 sm:px-3.5 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded-xl transition-all cursor-pointer h-10" title="Import data UMKM dari Excel">
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                <span>Import Excel</span>
            </a>
        </div>
    </div>

    <!-- Toolbar: Filter Pencarian & Status (Responsif & Rapi di Tablet/Pad) -->
    <div class="px-4 py-3 sm:px-5 sm:py-3.5 bg-slate-50/70 border-b border-slate-200/80">
        <form id="filter-form" action="{{ route('admin.stores') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
            <div class="relative flex-1 min-w-[200px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 z-10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="search-input" name="search" value="{{ request('search') }}" placeholder="Cari nama UMKM / pemilik / kecamatan / desa..." autocomplete="off" class="w-full text-xs sm:text-sm font-semibold text-slate-900 placeholder:text-slate-400 placeholder:font-normal bg-white border border-slate-300 rounded-xl focus:ring-3 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-2xs transition-all h-10 pl-10 pr-9">
                <button type="button" id="clear-search-btn" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-700 transition-colors z-10 {{ request('search') ? '' : 'hidden' }}" onclick="clearSearch()" title="Hapus pencarian">
                    <span class="w-5 h-5 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </span>
                </button>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <select name="status" onchange="document.getElementById('filter-form').submit()" class="h-10 px-3 text-xs sm:text-sm font-semibold bg-white border border-slate-300 rounded-xl text-slate-800 focus:ring-3 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-2xs transition-all cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Disetujui</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
                @if(request('search') || request('status'))
                <a href="{{ route('admin.stores') }}" class="h-10 px-3 inline-flex items-center justify-center text-xs font-bold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl transition-colors shrink-0" title="Reset filter">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Data UMKM (Pas di Tablet/iPad dengan Sticky Action Column) -->
    <div class="overflow-x-auto table-scrollbar -mx-px">
        <table class="w-full min-w-[760px] text-left text-sm border-collapse">
            <thead class="bg-slate-50/90 border-b border-slate-200/90 text-slate-600 font-bold text-[11px] uppercase tracking-wider">
                <tr>
                    <th class="px-3.5 py-3 sm:px-4 sm:py-3.5">Nama UMKM</th>
                    <th class="px-3 py-3 sm:px-3.5 sm:py-3.5 whitespace-nowrap">No HP / WhatsApp</th>
                    <th class="px-3 py-3 sm:px-3.5 sm:py-3.5 whitespace-nowrap">Pemilik</th>
                    <th class="px-2.5 py-3 sm:px-3 sm:py-3.5 text-center whitespace-nowrap">Gender</th>
                    <th class="px-3 py-3 sm:px-3.5 sm:py-3.5 whitespace-nowrap">Wilayah (Kecamatan & Desa)</th>
                    <th class="px-3 py-3 sm:px-3.5 sm:py-3.5 whitespace-nowrap">Status</th>
                    <th class="px-3 py-3 sm:px-4 sm:py-3.5 text-center whitespace-nowrap sticky right-0 bg-slate-50/95 backdrop-blur-xs z-10 border-l border-slate-200/80 shadow-[-4px_0_6px_-2px_rgba(0,0,0,0.04)]">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($umkms as $umkm)
                <tr class="umkm-row hover:bg-slate-50/80 transition-colors group">
                    <td class="px-3.5 py-3 sm:px-4 sm:py-3.5 font-bold text-[#800000] text-sm sm:text-base">
                        <a href="{{ route('admin.umkm.show', $umkm->id) }}" class="hover:underline line-clamp-2 block" title="{{ $umkm->business_name }}">
                            {{ $umkm->business_name }}
                        </a>
                    </td>
                    <td class="px-3 py-3 sm:px-3.5 sm:py-3.5 whitespace-nowrap">
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $umkm->phone)) }}" target="_blank" class="inline-flex items-center text-xs sm:text-sm text-slate-600 hover:text-emerald-700 font-medium transition-colors" title="Hubungi via WhatsApp">
                            <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>{{ $umkm->phone }}</span>
                        </a>
                    </td>
                    <td class="px-3 py-3 sm:px-3.5 sm:py-3.5 font-medium text-slate-800 text-xs sm:text-sm whitespace-nowrap">
                        {{ $umkm->owner_name }}
                    </td>
                    <td class="px-2.5 py-3 sm:px-3 sm:py-3.5 text-center whitespace-nowrap">
                        @php
                            $g = strtoupper(trim((string)$umkm->gender));
                            $isMale = in_array($g, ['L', 'LAKI-LAKI', 'PRIA']);
                            $isFemale = in_array($g, ['P', 'PEREMPUAN', 'WANITA']);
                        @endphp
                        @if($isMale)
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-blue-50 text-blue-700 text-xs font-bold border border-blue-200" title="Laki-laki">L</span>
                        @elseif($isFemale)
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-pink-50 text-pink-700 text-xs font-bold border border-pink-200" title="Perempuan">P</span>
                        @else
                            <span class="text-xs text-slate-400">-</span>
                        @endif
                    </td>
                    <td class="px-3 py-3 sm:px-3.5 sm:py-3.5 whitespace-nowrap">
                        <div class="font-bold text-slate-800 text-xs sm:text-sm">{{ $umkm->district ?? '-' }}</div>
                        @if($umkm->village)
                            <div class="text-[11px] text-slate-500 font-medium">Ds. {{ $umkm->village }}</div>
                        @endif
                    </td>
                    <td class="px-3 py-3 sm:px-3.5 sm:py-3.5 whitespace-nowrap">
                        @if($umkm->status == 'verified')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Disetujui
                            </span>
                        @elseif($umkm->status == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                Ditolak
                            </span>
                            @if(!empty($umkm->rejection_note))
                                <div class="text-[10px] text-red-600 font-medium mt-0.5 max-w-[120px] truncate" title="Alasan: {{ $umkm->rejection_note }}">
                                    Catatan: {{ $umkm->rejection_note }}
                                </div>
                            @endif
                        @endif
                    </td>
                    <td class="px-3 py-3 sm:px-4 sm:py-3.5 text-center whitespace-nowrap sticky right-0 bg-white group-hover:bg-slate-50/95 transition-colors z-10 border-l border-slate-100 shadow-[-4px_0_6px_-2px_rgba(0,0,0,0.04)]">
                        <div class="flex items-center justify-center gap-1.5">
                            <!-- Tambah Produk untuk UMKM Ini -->
                            <a href="{{ route('admin.products.create', ['umkm_id' => $umkm->id]) }}" 
                               data-tooltip="Tambah Produk untuk UMKM Ini" 
                               title="Tambah Produk untuk UMKM Ini"
                               class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white border border-emerald-200/80 flex items-center justify-center transition-all duration-200 shadow-2xs">
                                <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </a>

                            <!-- Lihat Detail -->
                            <a href="{{ route('admin.umkm.show', $umkm->id) }}" 
                               data-tooltip="Lihat Detail" 
                               title="Lihat Detail"
                               class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white border border-blue-200/80 flex items-center justify-center transition-all duration-200 shadow-2xs">
                                <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>

                            <!-- Edit -->
                            <a href="{{ route('admin.umkm.edit', $umkm->id) }}" 
                               data-tooltip="Edit UMKM" 
                               title="Edit UMKM"
                               class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white border border-amber-200/80 flex items-center justify-center transition-all duration-200 shadow-2xs">
                                <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>

                            <!-- Hapus -->
                            <button type="button" 
                                    onclick="confirmDeleteUmkm('{{ $umkm->id }}', '{{ addslashes($umkm->business_name) }}')" 
                                    data-tooltip="Hapus UMKM" 
                                    title="Hapus UMKM"
                                    class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white border border-red-200/80 flex items-center justify-center transition-all duration-200 shadow-2xs cursor-pointer">
                                <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            <form id="delete-umkm-form-{{ $umkm->id }}" action="{{ route('admin.umkm.destroy', $umkm->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                        Belum ada UMKM yang terdaftar.
                    </td>
                </tr>
                @endforelse
                <tr id="no-match-row" class="hidden">
                    <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                        Tidak ada UMKM yang sesuai dengan kata kunci pencarian.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @if($umkms->hasPages())
    <div class="p-4 border-t border-slate-200 bg-white">
        {{ $umkms->links() }}
    </div>
    @endif
</div>

<script>
    let searchTimeout = null;
    const searchInput = document.getElementById('search-input');
    const clearBtn = document.getElementById('clear-search-btn');
    const filterForm = document.getElementById('filter-form');

    function clearSearch() {
        if (searchInput) {
            searchInput.value = '';
            if (clearBtn) clearBtn.classList.add('hidden');
            filterForm.submit();
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();

            if (clearBtn) {
                if (query.length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }

            // Filter instan di sisi klien
            const rows = document.querySelectorAll('tbody tr.umkm-row');
            let matchCount = 0;
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                    matchCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const noMatchRow = document.getElementById('no-match-row');
            if (noMatchRow) {
                noMatchRow.classList.toggle('hidden', matchCount > 0 || rows.length === 0);
            }

            // Debounce otomatis kirim ke server tanpa perlu tombol filter
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filterForm.submit();
            }, 500);
        });

        // Pertahankan kursor di akhir teks saat halaman termuat
        if (searchInput.value) {
            const val = searchInput.value;
            searchInput.value = '';
            searchInput.value = val;
        }
    }
</script>
@endsection
