@extends('layouts.admin')

@section('page_title', 'Data UMKM')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h3 class="font-bold text-slate-800 text-lg">Kelola Data UMKM</h3>
            <p class="text-slate-500 text-sm mt-1">Daftar semua UMKM yang telah terdaftar di sistem. Anda dapat melihat, mengedit, dan menghapus UMKM.</p>
        </div>
        <form id="filter-form" action="{{ route('admin.stores') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
            <div class="relative flex items-center">
                <span class="absolute left-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" id="search-input" name="search" value="{{ request('search') }}" placeholder="Cari nama UMKM / pemilik / desa..." autocomplete="off" class="pl-10 pr-9 py-2 text-sm bg-white border-2 border-slate-300 rounded-xl text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none w-72 shadow-xs transition-all">
                <button type="button" id="clear-search-btn" class="absolute right-3 text-slate-400 hover:text-slate-600 {{ request('search') ? '' : 'hidden' }}" onclick="clearSearch()" title="Hapus pencarian">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <select name="status" onchange="document.getElementById('filter-form').submit()" class="py-2 px-3 text-sm bg-white border-2 border-slate-300 rounded-xl text-slate-900 focus:ring-4 focus:ring-red-500/15 focus:border-[#800000] outline-none shadow-xs transition-all cursor-pointer">
                <option value="">Semua Status</option>
                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Disetujui</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.stores') }}" class="px-3 py-2 text-sm text-slate-600 hover:text-slate-900 border border-slate-300 rounded-xl bg-slate-50 transition-colors shadow-2xs" title="Reset pencarian">
                    Reset
                </a>
            @endif
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold">
                <tr>
                    <th class="px-6 py-4 w-1/4">Nama UMKM</th>
                    <th class="px-6 py-4 w-40 whitespace-nowrap">No HP / WhatsApp</th>
                    <th class="px-6 py-4 w-1/6 whitespace-nowrap">Pemilik</th>
                    <th class="px-6 py-4 w-1/5 whitespace-nowrap">Wilayah (Kecamatan & Desa)</th>
                    <th class="px-6 py-4 w-28 whitespace-nowrap">Status</th>
                    <th class="px-6 py-4 text-center whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($umkms as $umkm)
                <tr class="umkm-row hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-[#800000] text-base">
                        {{ $umkm->business_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center text-sm text-slate-600 font-medium">
                            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $umkm->phone }}
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-slate-800 whitespace-nowrap">{{ $umkm->owner_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium text-slate-800">{{ $umkm->district ?? '-' }}</div>
                        @if($umkm->village)
                            <div class="text-xs text-slate-500">Ds. {{ $umkm->village }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($umkm->status == 'verified')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Disetujui
                            </span>
                        @elseif($umkm->status == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu Persetujuan
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                Ditolak
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.umkm.show', $umkm->id) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Lihat Detail</a>
                            <a href="{{ route('admin.umkm.edit', $umkm->id) }}" class="text-[#800000] hover:text-red-700 font-medium text-sm">Edit</a>
                            <form action="{{ route('admin.umkm.destroy', $umkm->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus UMKM ini beserta seluruh produknya?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                        Belum ada UMKM yang terdaftar.
                    </td>
                </tr>
                @endforelse
                <tr id="no-match-row" class="hidden">
                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                        Tidak ada UMKM yang sesuai dengan kata kunci pencarian.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @if($umkms->hasPages())
    <div class="p-4 border-t border-slate-200">
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
