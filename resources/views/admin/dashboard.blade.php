@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Total UMKM Terdaftar</p>
                    <h3 class="text-3xl font-bold text-slate-800 tracking-tight">1.234</h3>
                </div>
                <div class="p-2.5 bg-red-50 text-[#800000] rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <p class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +24 UMKM baru minggu ini
            </p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Produk Terpublikasi</p>
                    <h3 class="text-3xl font-bold text-slate-800 tracking-tight">4.567</h3>
                </div>
                <div class="p-2.5 bg-red-50 text-[#800000] rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
            <p class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +56 produk baru terkurasi
            </p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Konsultasi Baru</p>
                    <h3 class="text-3xl font-bold text-slate-800 tracking-tight">24</h3>
                </div>
                <div class="p-2.5 bg-red-50 text-[#800000] rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
            </div>
            <p class="text-xs font-semibold text-amber-500">Perlu penanganan segera</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-xl p-6 border border-slate-200/60 shadow-sm flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Konsultasi Selesai</p>
                    <h3 class="text-3xl font-bold text-slate-800 tracking-tight">890</h3>
                </div>
                <div class="p-2.5 bg-red-50 text-[#800000] rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-xs font-semibold text-emerald-600">Tingkat penyelesaian 94%</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Bar Chart -->
        <div class="bg-white rounded-xl p-6 lg:p-7 border border-slate-200/60 shadow-sm lg:col-span-2">
            <h3 class="text-[15px] font-bold text-slate-800 mb-6">Konsultasi Masuk per Bulan</h3>
            <div class="w-full h-[250px] relative">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- Donut Chart -->
        <div class="bg-white rounded-xl p-6 lg:p-7 border border-slate-200/60 shadow-sm">
            <h3 class="text-[15px] font-bold text-slate-800 mb-6">Kategori Produk</h3>
            <div class="w-full h-[250px] relative flex justify-center items-center">
                <canvas id="donutChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Table 1 -->
        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-slate-200 bg-white">
                <h3 class="text-[15px] font-bold text-slate-800">Konsultasi Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50/80">
                            <th class="px-6 py-4">No Tiket</th>
                            <th class="px-6 py-4">Nama UMKM</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-[#800000]">#UMKM-0024</td>
                            <td class="px-6 py-4 font-semibold text-slate-800">UD Sari Rasa</td>
                            <td class="px-6 py-4 text-slate-500">Sertifikat Halal</td>
                            <td class="px-6 py-4 text-center"><span class="px-3 py-1.5 text-[11px] font-bold rounded-full bg-amber-100 text-amber-700 border border-amber-200/50">Menunggu</span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-[#800000]">#UMKM-0023</td>
                            <td class="px-6 py-4 font-semibold text-slate-800">Batik Sekar Wonogiri</td>
                            <td class="px-6 py-4 text-slate-500">PIRT</td>
                            <td class="px-6 py-4 text-center"><span class="px-3 py-1.5 text-[11px] font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-200/50">Diproses</span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-[#800000]">#UMKM-0022</td>
                            <td class="px-6 py-4 font-semibold text-slate-800">Madu Randu Asli</td>
                            <td class="px-6 py-4 text-slate-500">Sertifikat Halal</td>
                            <td class="px-6 py-4 text-center"><span class="px-3 py-1.5 text-[11px] font-bold rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200/50">Selesai</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Table 2 -->
        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-slate-200 bg-white">
                <h3 class="text-[15px] font-bold text-slate-800">Verifikasi Produk Baru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50/80">
                            <th class="px-6 py-4">Nama Produk</th>
                            <th class="px-6 py-4">UMKM</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-800">Mente Oven</td>
                            <td class="px-6 py-4 text-slate-500">UD Kacang Jaya</td>
                            <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                                <button class="px-3.5 py-1.5 text-xs font-semibold rounded-md bg-emerald-500 text-white hover:bg-emerald-600 transition-colors shadow-sm focus:ring focus:ring-emerald-200">Setujui</button>
                                <button class="px-3.5 py-1.5 text-xs font-semibold rounded-md bg-[#800000] text-white hover:bg-[#600000] transition-colors shadow-sm focus:ring focus:ring-red-200">Tolak</button>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-800">Batik Sakera</td>
                            <td class="px-6 py-4 text-slate-500">Batik Wonogiren</td>
                            <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                                <button class="px-3.5 py-1.5 text-xs font-semibold rounded-md bg-emerald-500 text-white hover:bg-emerald-600 transition-colors shadow-sm focus:ring focus:ring-emerald-200">Setujui</button>
                                <button class="px-3.5 py-1.5 text-xs font-semibold rounded-md bg-[#800000] text-white hover:bg-[#600000] transition-colors shadow-sm focus:ring focus:ring-red-200">Tolak</button>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-800">Sambel Pecel</td>
                            <td class="px-6 py-4 text-slate-500">Dapur Bu Lastri</td>
                            <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                                <button class="px-3.5 py-1.5 text-xs font-semibold rounded-md bg-emerald-500 text-white hover:bg-emerald-600 transition-colors shadow-sm focus:ring focus:ring-emerald-200">Setujui</button>
                                <button class="px-3.5 py-1.5 text-xs font-semibold rounded-md bg-[#800000] text-white hover:bg-[#600000] transition-colors shadow-sm focus:ring focus:ring-red-200">Tolak</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Shared Chart Defaults
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#64748b';
        
        // Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Konsultasi Masuk',
                    data: [15, 25, 30, 45, 60, 40, 75, 95, 70, 80, 50, 40],
                    backgroundColor: '#B91C1C', // tailwind red-700
                    borderRadius: 4,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 13 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [4, 4], color: '#f1f5f9', drawBorder: false },
                        ticks: { display: false }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });

        // Donut Chart
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Mamin', 'Kriya', 'Batik'],
                datasets: [{
                    data: [55, 25, 20],
                    backgroundColor: [
                        '#B91C1C', // red-700
                        '#EAB308', // yellow-500
                        '#3B82F6'  // blue-500
                    ],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 24,
                            font: { size: 12, weight: '500' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 13 }
                    }
                }
            }
        });
    });
</script>
@endpush
