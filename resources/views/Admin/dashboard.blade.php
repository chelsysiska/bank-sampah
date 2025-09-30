@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('header_title', 'Dashboard Admin')

@section('header_subtitle', 'Kelola dan lihat rekapitulasi laporan bulanan.')

@section('content')

<!-- Statistics Cards -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-8">
    <!-- Total Pendapatan Card -->
    <div class="card-hover bg-gradient-to-br from-yellow-50 to-amber-50 p-6 md:p-8 rounded-2xl shadow-lg border-l-4 border-yellow-500 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-200 opacity-10 rounded-full -translate-y-8 translate-x-8"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-yellow-200 opacity-10 rounded-full translate-y-8 -translate-x-8"></div>
        
        <div class="relative z-10">
            <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0">
                    <i class="fas fa-money-bill-wave text-2xl text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base md:text-lg font-semibold text-gray-700 mb-2">Total Pendapatan Semua Nasabah</h3>
                    <p class="text-2xl md:text-3xl lg:text-4xl font-bold text-yellow-600 break-all">
                        Rp{{ number_format($totalPendapatanSemuaNasabah, 0, ',', '.') }}
                    </p>
                    <div class="mt-2 flex items-center text-sm text-yellow-700">
                        <i class="fas fa-chart-line mr-1"></i>
                        <span>Total akumulasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Berat Sampah Card -->
    <div class="card-hover bg-gradient-to-br from-green-50 to-emerald-50 p-6 md:p-8 rounded-2xl shadow-lg border-l-4 border-green-500 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-green-200 opacity-10 rounded-full -translate-y-8 translate-x-8"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-green-200 opacity-10 rounded-full translate-y-8 -translate-x-8"></div>
        
        <div class="relative z-10">
            <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0">
                    <i class="fas fa-weight-hanging text-2xl text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base md:text-lg font-semibold text-gray-700 mb-2">Total Berat Sampah</h3>
                    <p class="text-2xl md:text-3xl lg:text-4xl font-bold text-green-600 break-all">
                        {{ number_format($totalBeratSemuaNasabah, 2, ',', '.') }} kg
                    </p>
                    <div class="mt-2 flex items-center text-sm text-green-700">
                        <i class="fas fa-recycle mr-1"></i>
                        <span>Sampah terkumpul</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Report Table -->
<div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
    <!-- Table Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
        <h3 class="text-lg md:text-xl font-semibold text-white flex items-center">
            <i class="fas fa-file-alt mr-2"></i>
            <span>Rekap Laporan Bulanan</span>
        </h3>
    </div>
    
    <!-- Table Content -->
    <div class="p-4 md:p-6">
        <div class="overflow-x-auto -mx-2 md:mx-0">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden border border-gray-200 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-green-50 to-blue-50">
                            <tr>
                                <th scope="col" class="px-3 md:px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider whitespace-nowrap">No</th>
                                <th scope="col" class="px-3 md:px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Petugas</th>
                                <th scope="col" class="px-3 md:px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider whitespace-nowrap">Bulan & Tahun</th>
                                <th scope="col" class="px-3 md:px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider whitespace-nowrap">Jumlah Setoran</th>
                                <th scope="col" class="px-3 md:px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider whitespace-nowrap">Total Berat (kg)</th>
                                <th scope="col" class="px-3 md:px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider whitespace-nowrap">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($laporans as $laporan)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                            {{ $loop->iteration }}
                                        </div>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                                <i class="fas fa-user text-white text-xs"></i>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <span class="font-medium truncate block">{{ $laporan->petugas?->name ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                                            {{ \Carbon\Carbon::createFromDate($laporan->tahun, $laporan->bulan)->translatedFormat('F Y') }}
                                        </div>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-2">
                                                <i class="fas fa-box text-green-600 text-xs"></i>
                                            </div>
                                            <span class="font-medium">{{ $laporan->jumlah_setoran }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-2">
                                                <i class="fas fa-weight-hanging text-orange-600 text-xs"></i>
                                            </div>
                                            <span class="font-medium">{{ number_format($laporan->total_berat, 2) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-2">
                                                <i class="fas fa-money-bill text-yellow-600 text-xs"></i>
                                            </div>
                                            <span class="font-semibold text-green-600">Rp{{ number_format($laporan->total_harga, 0, ',', '.') }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 md:px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                            <h3 class="text-lg font-medium mb-2">Tidak ada laporan</h3>
                                            <p class="text-sm">Tidak ada laporan yang ditemukan untuk periode ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($laporans->hasPages())
            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan {{ $laporans->firstItem() }} - {{ $laporans->lastItem() }} dari {{ $laporans->total() }} data
                </div>
                <div>{{ $laporans->links() }}</div>
            </div>
        @endif
    </div>
</div>

<!-- Divider -->
<div class="flex items-center my-8">
    <div class="flex-1 h-px bg-gradient-to-r from-transparent to-gray-300"></div>
    <div class="px-4 text-gray-500 font-medium">
        <i class="fas fa-chart-bar mr-2"></i>
        Analisis Data
    </div>
    <div class="flex-1 h-px bg-gradient-to-l from-transparent to-gray-300"></div>
</div>

<!-- Chart Section -->
<div class="bg-white shadow-xl rounded-2xl overflow-hidden">
    <!-- Chart Header -->
    <div class="bg-gradient-to-r from-green-600 to-blue-600 px-6 py-4">
        <h3 class="text-lg md:text-xl font-semibold text-white flex items-center">
            <i class="fas fa-chart-line mr-2"></i>
            <span>Grafik Total Berat Sampah per Bulan</span>
        </h3>
    </div>
    <!-- Chart Content -->
    <div class="p-4 md:p-6">
        @if ($grafikBulananData->isEmpty())
            <div class="text-center py-16">
                <div class="flex flex-col items-center justify-center text-gray-500">
                    <i class="fas fa-chart-line text-6xl mb-6 text-gray-300"></i>
                    <h3 class="text-xl font-medium mb-2">Tidak ada data</h3>
                    <p class="text-sm max-w-md">Tidak ada data setoran yang dapat ditampilkan dalam grafik. Mulai tambahkan data setoran untuk melihat grafik.</p>
                </div>
            </div>
        @else
            <div class="relative" style="min-height: 420px;">
                <!-- Chart Loading Placeholder -->
                <div id="chart-loading" class="absolute inset-0 flex items-center justify-center bg-gray-50 rounded-lg z-10">
                    <div class="text-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                        <p class="text-gray-600">Memuat grafik...</p>
                    </div>
                </div>

                <!-- Chart Canvas -->
                <canvas id="monthlyWasteChart" class="w-full" style="height: 400px;"></canvas>
            </div>

            <!-- Chart Legend Info -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-500 rounded mr-2"></div>
                        <span>Data per bulan</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <span>Hover pada grafik untuk detail</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Pastikan elemen canvas ada
        const canvas = document.getElementById('monthlyWasteChart');
        if (!canvas) {
            console.error('Canvas element not found!');
            return;
        }

        // Ambil data dari PHP
        const grafikBulananData = @json($grafikBulananData);
        const jenisSampahData = @json($jenisSampahData);

        // Jika tidak ada data, sembunyikan loading dan tampilkan pesan
        if (!grafikBulananData || grafikBulananData.length === 0) {
            const loading = document.getElementById('chart-loading');
            if (loading) loading.style.display = 'none';
            return;
        }

        // Siapkan label bulan
        const bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Siapkan datasets
        const datasets = [];
        const colors = [
            { bg: '#4A90E2', border: '#357ABD' },
            { bg: '#50C878', border: '#3A9B5C' },
            { bg: '#FFD700', border: '#E6C200' },
            { bg: '#FF6384', border: '#E5455A' },
            { bg: '#9966FF', border: '#7A4DE6' },
            { bg: '#FF9F40', border: '#E6852D' }
        ];
        let colorIndex = 0;

        // Loop jenis sampah
        jenisSampahData.forEach(jenis => {
            const dataPoints = Array(12).fill(0);
            grafikBulananData.forEach(item => {
                if (item.jenis_sampah_id === jenis.id) {
                    dataPoints[item.month - 1] = item.total_berat;
                }
            });

            const color = colors[colorIndex % colors.length];
            datasets.push({
                label: jenis.nama,
                data: dataPoints,
                backgroundColor: color.bg + '80',
                borderColor: color.border,
                borderWidth: 2,
                borderRadius: 4,
                borderSkipped: false,
            });
            colorIndex++;
        });

        // Inisialisasi chart
        try {
            const ctx = canvas.getContext('2d');
            if (!ctx) {
                console.error('Failed to get 2D context!');
                return;
            }

            // Sembunyikan loading setelah 500ms
            setTimeout(() => {
                const loading = document.getElementById('chart-loading');
                if (loading) loading.style.display = 'none';
            }, 500);

            // Buat chart
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: bulanLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    size: 12,
                                    family: 'Inter'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y + ' kg';
                                    }
                                    return label;
                                },
                                footer: function(tooltipItems) {
                                    let sum = 0;
                                    tooltipItems.forEach(function(tooltipItem) {
                                        sum += tooltipItem.parsed.y;
                                    });
                                    return 'Total: ' + sum + ' kg';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12,
                                    family: 'Inter'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Bulan',
                                font: {
                                    size: 14,
                                    family: 'Inter',
                                    weight: 'bold'
                                },
                                color: '#374151'
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 12,
                                    family: 'Inter'
                                },
                                callback: function(value) {
                                    return value + ' kg';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Berat (kg)',
                                font: {
                                    size: 14,
                                    family: 'Inter',
                                    weight: 'bold'
                                },
                                color: '#374151'
                            }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    }
                }
            });

        } catch (error) {
            console.error('Chart initialization failed:', error);
            const loading = document.getElementById('chart-loading');
            if (loading) loading.style.display = 'none';
        }
    });
</script>
@endpush