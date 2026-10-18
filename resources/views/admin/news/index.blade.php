@extends('layouts.admin')

@section('page_title', 'Kelola Berita & Kegiatan')

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-[#800000] flex items-center justify-center border border-red-100 shadow-2xs">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2"></path></svg>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-800 text-lg">Kelola Berita & Kegiatan Terkini</h3>
                <p class="text-slate-500 text-xs mt-0.5">Atur publikasi, tambahkan berita baru, atau aktifkan/nonaktifkan tombol switch publikasi kapan saja.</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.news.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#800000] hover:bg-red-900 text-white text-xs font-bold rounded-xl shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Berita / Kegiatan
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-4">
        <form action="{{ route('admin.news') }}" method="GET" class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                <div class="relative flex-1 md:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau topik..." class="w-full pl-9 pr-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-[#800000] focus:border-[#800000] bg-slate-50/50">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <select name="status" class="py-2 px-3 text-xs border border-slate-200 rounded-xl focus:ring-[#800000] focus:border-[#800000] bg-slate-50/50">
                    <option value="">Semua Status Publikasi</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Aktif (Tampil di Publik)</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Nonaktif (Disembunyikan)</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-[#800000] text-white text-xs font-bold rounded-xl hover:bg-red-900 transition-colors">
                    Filter
                </button>
                @if(request('search') || request('status'))
                <a href="{{ route('admin.news') }}" class="px-3 py-2 text-xs text-slate-500 hover:text-slate-800 bg-slate-100 rounded-xl">
                    Reset
                </a>
                @endif
            </div>

            <div class="text-xs font-semibold text-slate-500">
                Total: <span class="text-slate-800 font-bold">{{ $newsList->total() }}</span> Berita & Kegiatan
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Berita & Kegiatan</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Tanggal Rilis</th>
                        <th class="px-6 py-4 text-center">Status On / Off</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($newsList as $item)
                    @php
                        $itemImg = $item->image_path ? (str_starts_with($item->image_path, 'http') || str_starts_with($item->image_path, 'img/') ? asset($item->image_path) : asset('storage/' . $item->image_path)) : asset('img/news/bimtek.jpg');
                    @endphp
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3.5">
                                <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                    <img src="{{ $itemImg }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-slate-800 text-sm leading-snug truncate max-w-xs md:max-w-md">
                                        {{ $item->title }}
                                    </h4>
                                    <p class="text-xs text-slate-400 truncate max-w-xs md:max-w-md mt-0.5">
                                        {{ $item->excerpt ?: Str::limit(strip_tags($item->content), 60) }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-50 text-[#800000] border border-red-100">
                                {{ $item->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-600 font-medium">
                            {{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <!-- Toggle Button Switch On/Off -->
                            <form action="{{ route('admin.news.toggle', $item->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="group flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold transition-all shadow-2xs {{ $item->is_published ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200 hover:bg-slate-200' }}" title="Klik untuk mengaktifkan / menonaktifkan tampilan">
                                    <span class="w-2 h-2 rounded-full {{ $item->is_published ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                    <span>{{ $item->is_published ? 'Aktif (ON)' : 'Mati (OFF)' }}</span>
                                    <svg class="w-3.5 h-3.5 opacity-60 group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('informasi.show', $item->id) }}" target="_blank" class="p-2 text-slate-400 hover:text-slate-700 bg-slate-50 hover:bg-slate-100 rounded-lg transition-colors border border-slate-200/60" title="Lihat Tampilan Publik">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <a href="{{ route('admin.news.edit', $item->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-slate-700 hover:text-[#800000] bg-slate-100 hover:bg-red-50 rounded-lg transition-colors border border-slate-200/60" title="Edit Berita">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-600 hover:text-white hover:bg-red-600 rounded-lg transition-colors border border-red-200" title="Hapus Berita">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mb-2 text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2"></path></svg>
                                </div>
                                <span class="font-bold text-sm text-slate-600">Belum ada berita atau kegiatan</span>
                                <span class="text-xs text-slate-400 mt-0.5">Klik tombol Tambah Berita / Kegiatan di atas untuk mulai memposting.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($newsList->hasPages())
        <div class="p-4 border-t border-slate-200/80 bg-slate-50/50">
            {{ $newsList->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
