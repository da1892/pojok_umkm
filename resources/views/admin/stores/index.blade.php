@extends('layouts.admin')

@section('page_title', 'Data UMKM')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-200">
        <h3 class="font-bold text-slate-800 text-lg">Kelola Data Toko / UMKM</h3>
        <p class="text-slate-500 text-sm mt-1">Daftar semua UMKM yang telah terdaftar di sistem. Anda dapat melihat, mengedit, dan menghapus toko.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold">
                <tr>
                    <th class="px-6 py-4">Nama Toko / Usaha</th>
                    <th class="px-6 py-4">Pemilik</th>
                    <th class="px-6 py-4">Kecamatan</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($umkms as $umkm)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-[#800000]">
                        {{ $umkm->business_name }}
                        <div class="text-xs text-slate-500 font-normal mt-0.5">{{ $umkm->phone }}</div>
                    </td>
                    <td class="px-6 py-4 font-medium text-slate-800">{{ $umkm->owner_name }}</td>
                    <td class="px-6 py-4">{{ $umkm->district ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @if($umkm->status == 'verified')
                            <span class="px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">Verified</span>
                        @elseif($umkm->status == 'pending')
                            <span class="px-2.5 py-1 rounded-md text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">Pending</span>
                        @else
                            <span class="px-2.5 py-1 rounded-md text-xs font-medium bg-red-50 text-red-700 border border-red-200">Rejected</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.umkm.edit', $umkm->id) }}" class="text-[#800000] hover:text-red-700 font-medium text-sm">Edit</a>
                            <form action="{{ route('admin.umkm.destroy', $umkm->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus toko UMKM ini beserta seluruh produknya?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                        Belum ada UMKM yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($umkms->hasPages())
    <div class="p-4 border-t border-slate-200">
        {{ $umkms->links() }}
    </div>
    @endif
</div>
@endsection
