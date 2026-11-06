@extends('layouts.admin')

@section('title', 'Statistik Pengunjung - Admin Pojok UMKM Wonogiri')
@section('page_title', 'Statistik & Analitik Pengunjung')

@section('content')
<div class="space-y-6">

    <!-- Header & Period Filter -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-[#800000] border border-red-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Live Traffic Analytics
                </span>
                <span class="text-xs text-slate-400 font-medium">Periode: {{ $periodLabel }}</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Statistik Pengunjung Website</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Pemantauan trafik pengunjung, halaman favorit, persebaran perangkat, dan aktivitas real-time portal Pojok UMKM Wonogiri.</p>
        </div>

        <!-- Filter Periode -->
        <div class="flex items-center gap-2 flex-wrap">
            <span class="text-xs font-bold text-slate-500">Rentang:</span>
            <div class="inline-flex rounded-xl bg-slate-100 p-1 border border-slate-200/60 text-xs font-semibold">
                <a href="{{ route('admin.visitors', ['period' => 'today']) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ $period === 'today' ? 'bg-white text-[#800000] shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">Hari Ini</a>
                <a href="{{ route('admin.visitors', ['period' => '7_days']) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ $period === '7_days' ? 'bg-white text-[#800000] shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">7 Hari</a>
                <a href="{{ route('admin.visitors', ['period' => '30_days']) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ $period === '30_days' ? 'bg-white text-[#800000] shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">30 Hari</a>
                <a href="{{ route('admin.visitors', ['period' => 'this_month']) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ $period === 'this_month' ? 'bg-white text-[#800000] shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">Bulan Ini</a>
                <a href="{{ route('admin.visitors', ['period' => 'all_time']) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ $period === 'all_time' ? 'bg-white text-[#800000] shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">Semua</a>
            </div>
        </div>
    </div>

    <!-- 4 Key Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Card 1: Pengunjung Hari Ini -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pengunjung Hari Ini</span>
                <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </span>
            </div>
            <div>
                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">{{ number_format($todayVisitors, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1 font-medium">
                    <span class="text-blue-600 font-bold">{{ number_format($todayViews, 0, ',', '.') }}</span> total tayangan halaman
                </p>
            </div>
        </div>

        <!-- Card 2: Pengunjung Bulan Ini -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pengunjung Bulan Ini</span>
                <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </span>
            </div>
            <div>
                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">{{ number_format($monthVisitors, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1 font-medium">
                    <span class="text-emerald-600 font-bold">{{ number_format($monthViews, 0, ',', '.') }}</span> tayangan bulan ini
                </p>
            </div>
        </div>

        <!-- Card 3: Total Pengunjung Periode -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pengunjung Unik (Periode)</span>
                <span class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </span>
            </div>
            <div>
                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">{{ number_format($uniqueVisitors, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Berdasarkan sesi unik perangkat</p>
            </div>
        </div>

        <!-- Card 4: Total Pageviews Periode -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Tayangan (Pageviews)</span>
                <span class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </span>
            </div>
            <div>
                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">{{ number_format($totalViews, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Seluruh interaksi halaman</p>
            </div>
        </div>
    </div>

    <!-- Main Trend Chart -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-800">Grafik Tren Kunjungan Harian</h3>
                <p class="text-xs text-slate-500 mt-0.5">Perbandingan antara jumlah tayangan halaman (Pageviews) dan pengunjung unik (Unique Visitors).</p>
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#800000]"></span>
                    <span class="text-slate-600">Total Tayangan (Pageviews)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                    <span class="text-slate-600">Pengunjung Unik</span>
                </div>
            </div>
        </div>
        <div class="w-full h-[280px] sm:h-[320px] relative">
            <canvas id="visitorTrendChart"></canvas>
        </div>
    </div>

    <!-- 2 Column: Breakdown Charts & Top Pages -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Column 1: Perangkat & Browser (1 Col) -->
        <div class="space-y-6">
            <!-- Donut Chart: Perangkat -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
                <h3 class="text-base font-bold text-slate-800 mb-1">Perangkat Pengunjung</h3>
                <p class="text-xs text-slate-500 mb-4">Distribusi perangkat yang digunakan mengakses portal.</p>
                <div class="w-full h-[180px] relative flex justify-center items-center">
                    <canvas id="deviceChart"></canvas>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 space-y-2">
                    @php
                        $devColors = [
                            'Mobile' => 'bg-blue-500',
                            'Desktop' => 'bg-[#800000]',
                            'Tablet' => 'bg-amber-500',
                        ];
                    @endphp
                    @foreach($deviceStats as $d)
                        @php
                            $dPercent = $totalViews > 0 ? round(($d->count / $totalViews) * 100) : 0;
                        @endphp
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-semibold text-slate-700 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full {{ $devColors[$d->device] ?? 'bg-slate-400' }}"></span>
                                {{ $d->device }}
                            </span>
                            <span class="font-bold text-slate-800">{{ number_format($d->count, 0, ',', '.') }} <span class="text-slate-400 font-normal">({{ $dPercent }}%)</span></span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- List: Browser Populer -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
                <h3 class="text-base font-bold text-slate-800 mb-1">Browser Terbanyak</h3>
                <p class="text-xs text-slate-500 mb-4">Peramban web yang digunakan pengunjung.</p>
                <div class="space-y-3">
                    @foreach($browserStats->take(5) as $b)
                        @php
                            $bPercent = $totalViews > 0 ? round(($b->count / $totalViews) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="font-semibold text-slate-800">{{ $b->browser }}</span>
                                <span class="font-bold text-slate-700">{{ number_format($b->count, 0, ',', '.') }} <span class="text-slate-400 font-normal">({{ $bPercent }}%)</span></span>
                            </div>
                            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-[#800000] rounded-full" style="width: {{ $bPercent }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Column 2: Halaman Terpopuler (2 Col) -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Halaman Paling Sering Dikunjungi</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar halaman web yang mendapatkan tayangan tertinggi pada periode ini.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] font-bold tracking-wider">
                            <tr>
                                <th class="px-4 py-3 rounded-l-lg">Halaman</th>
                                <th class="px-4 py-3">URL</th>
                                <th class="px-4 py-3 text-right">Tayangan</th>
                                <th class="px-4 py-3 rounded-r-lg text-right">Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($topPages as $idx => $p)
                                @php
                                    $pPercent = $totalViews > 0 ? round(($p->count / $totalViews) * 100, 1) : 0;
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-4 py-3.5 font-bold text-slate-800 flex items-center gap-2">
                                        <span class="w-5 h-5 rounded-full bg-red-50 text-[#800000] text-[10px] font-black flex items-center justify-center shrink-0">
                                            {{ $idx + 1 }}
                                        </span>
                                        <span class="truncate max-w-[200px]">{{ $p->page_name ?: 'Halaman Publik' }}</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-500 truncate max-w-[220px]">
                                        <a href="{{ $p->url }}" target="_blank" class="hover:text-[#800000] hover:underline flex items-center gap-1">
                                            <span class="truncate">{{ parse_url($p->url, PHP_URL_PATH) ?: '/' }}</span>
                                            <svg class="w-3 h-3 opacity-50 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    </td>
                                    <td class="px-4 py-3.5 text-right font-black text-slate-800">
                                        {{ number_format($p->count, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        <div class="inline-flex items-center gap-2 justify-end w-full">
                                            <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden hidden sm:block">
                                                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ min(100, $pPercent) }}%;"></div>
                                            </div>
                                            <span class="font-bold text-slate-700 w-12">{{ $pPercent }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-400 italic">Belum ada data halaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Real-Time Activity Log Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Log Aktivitas Kunjungan Terkini</h3>
                <p class="text-xs text-slate-500 mt-0.5">Catatan riwayat interaksi pengguna saat membuka halaman Pojok UMKM.</p>
            </div>

            <!-- Search & Filter Log -->
            <form action="{{ route('admin.visitors') }}" method="GET" class="flex items-center gap-2 flex-wrap">
                <input type="hidden" name="period" value="{{ $period }}">
                
                <select name="device_filter" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 focus:outline-none focus:border-[#800000]">
                    <option value="">Semua Perangkat</option>
                    <option value="Mobile" {{ request('device_filter') === 'Mobile' ? 'selected' : '' }}>Mobile</option>
                    <option value="Desktop" {{ request('device_filter') === 'Desktop' ? 'selected' : '' }}>Desktop</option>
                    <option value="Tablet" {{ request('device_filter') === 'Tablet' ? 'selected' : '' }}>Tablet</option>
                </select>

                <div class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari IP / Halaman..." class="bg-slate-50 border border-slate-200 text-slate-700 text-xs rounded-xl pl-9 pr-3 py-2 w-48 focus:outline-none focus:border-[#800000]" style="padding-left: 2.25rem !important;">
                    <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <button type="submit" class="bg-[#800000] text-white px-3.5 py-2 rounded-xl text-xs font-semibold hover:bg-[#600000] transition-colors">
                    Filter
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Waktu Akses</th>
                        <th class="px-6 py-3.5">IP Address</th>
                        <th class="px-6 py-3.5">Halaman Diakses</th>
                        <th class="px-6 py-3.5">Perangkat</th>
                        <th class="px-6 py-3.5">Browser & Platform</th>
                        <th class="px-6 py-3.5">Rujukan (Referer)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($visitorLogs as $log)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-6 py-3.5 text-slate-600 whitespace-nowrap font-medium">
                                {{ $log->visited_at ? $log->visited_at->translatedFormat('d M Y, H:i:s') : '-' }}
                            </td>
                            <td class="px-6 py-3.5 font-mono text-slate-700 font-semibold">
                                {{ $log->ip_address }}
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="font-bold text-slate-800 block">{{ $log->page_name ?: 'Halaman Publik' }}</span>
                                <span class="text-[11px] text-slate-400 truncate max-w-[200px] block font-mono">{{ parse_url($log->url, PHP_URL_PATH) ?: '/' }}</span>
                            </td>
                            <td class="px-6 py-3.5">
                                @if($log->device === 'Mobile')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        Mobile
                                    </span>
                                @elseif($log->device === 'Tablet')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        Tablet
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        Desktop
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 text-slate-700">
                                <span class="font-bold">{{ $log->browser }}</span>
                                <span class="text-slate-400 text-[11px]">({{ $log->platform }})</span>
                            </td>
                            <td class="px-6 py-3.5 text-slate-500 text-[11px] truncate max-w-[180px]">
                                {{ $log->referer ? parse_url($log->referer, PHP_URL_HOST) : 'Langsung (Direct)' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">
                                Belum ada riwayat kunjungan yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($visitorLogs->hasPages())
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $visitorLogs->links() }}
        </div>
        @endif
    </div>

</div>

<!-- Inisialisasi Chart.js -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Line/Bar Chart Kunjungan
    const trendCtx = document.getElementById('visitorTrendChart')?.getContext('2d');
    if (trendCtx) {
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [
                    {
                        label: 'Total Tayangan (Pageviews)',
                        data: {!! json_encode($chartViews) !!},
                        borderColor: '#800000',
                        backgroundColor: 'rgba(128, 0, 0, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Pengunjung Unik',
                        data: {!! json_encode($chartVisitors) !!},
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.08)',
                        borderWidth: 2,
                        borderDash: [4, 4],
                        fill: false,
                        tension: 0.35,
                        pointRadius: 2.5,
                        pointHoverRadius: 5,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 12 },
                        cornerRadius: 8,
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 }, color: '#64748b' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            precision: 0,
                            font: { size: 11 },
                            color: '#64748b'
                        }
                    }
                }
            }
        });
    }

    // 2. Donut Chart Perangkat
    const deviceCtx = document.getElementById('deviceChart')?.getContext('2d');
    if (deviceCtx) {
        const devLabels = {!! json_encode($deviceStats->pluck('device')) !!};
        const devData = {!! json_encode($deviceStats->pluck('count')) !!};

        new Chart(deviceCtx, {
            type: 'doughnut',
            data: {
                labels: devLabels,
                datasets: [{
                    data: devData,
                    backgroundColor: ['#3b82f6', '#800000', '#f59e0b', '#10b981'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
});
</script>
@endsection
