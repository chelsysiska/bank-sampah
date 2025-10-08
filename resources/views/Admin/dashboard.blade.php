@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('header_title', 'Dashboard Admin')

@section('header_subtitle', 'Kelola dan lihat rekapitulasi laporan bulanan.')

@section('content')

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
    <!-- Total Pendapatan Card -->
    <div class="card-hover bg-gradient-to-br from-yellow-50 to-amber-50 p-6 md:p-8 rounded-2xl shadow-lg border-l-4 border-yellow-500 relative overflow-hidden">
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

    <!-- Total Uang Kas Card -->
    <div class="card-hover bg-gradient-to-br from-blue-50 to-indigo-50 p-6 md:p-8 rounded-2xl shadow-lg border-l-4 border-blue-500 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-200 opacity-10 rounded-full -translate-y-8 translate-x-8"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-blue-200 opacity-10 rounded-full translate-y-8 -translate-x-8"></div>
        <div class="relative z-10">
            <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0">
                    <i class="fas fa-wallet text-2xl text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base md:text-lg font-semibold text-gray-700 mb-2">Total Uang Kas</h3>
                    <p class="text-2xl md:text-3xl lg:text-4xl font-bold text-blue-600 break-all">
                        Rp{{ number_format($totalKas, 0, ',', '.') }}
                    </p>
                    <div class="mt-2 flex items-center text-sm text-blue-700">
                        <i class="fas fa-file-invoice mr-1"></i>
                        <span>Kas operasional</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex space-x-2">
                <a href="{{ route('admin.kas.create', ['jenis' => 'pemasukan']) }}" 
                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-green-700 bg-green-100 rounded-full hover:bg-green-200 transition">
                    <i class="fas fa-plus mr-1"></i> Tambah Pemasukan
                </a>
                <a href="{{ route('admin.kas.create', ['jenis' => 'pengeluaran']) }}" 
                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 rounded-full hover:bg-red-200 transition">
                    <i class="fas fa-minus mr-1"></i> Catat Pengeluaran
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Report Table -->
<div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
        <h3 class="text-lg md:text-xl font-semibold text-white flex items-center">
            <i class="fas fa-file-alt mr-2"></i>
            <span>Rekap Laporan Bulanan</span>
        </h3>
    </div>
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

<!-- Riwayat Kas -->
<div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
        <h3 class="text-lg md:text-xl font-semibold text-white flex items-center">
            <i class="fas fa-history mr-2"></i>
            <span>Riwayat Kas</span>
        </h3>
    </div>
    <div class="p-4 md:p-6">
        @if($riwayatKas->isNotEmpty())
            <div class="overflow-x-auto -mx-2">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Jenis</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Keterangan</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Jumlah</th>
                            @if(auth()->user()->isAdmin())
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Bukti</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($riwayatKas as $kas)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                    {{ $kas->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }}
                            </td>
                                <td class="px-4 py-3">
                                    @if($kas->jenis === 'pemasukan')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Pemasukan
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Pengeluaran
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 max-w-xs truncate">{{ $kas->keterangan }}</td>
                                <td class="px-4 py-3 text-sm font-medium {{ $kas->jenis === 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                    Rp{{ number_format($kas->jumlah, 0, ',', '.') }}
                                </td>
                                @if(auth()->user()->isAdmin() && $kas->dokumentasi)
                                    <td class="px-4 py-3 text-sm">
                                        <a href="{{ asset('storage/' . $kas->dokumentasi) }}" target="_blank" class="text-blue-600 hover:underline">
                                            <i class="fas fa-image mr-1"></i>Lihat
                                        </a>
                                    </td>
                                @elseif(auth()->user()->isAdmin())
                                    <td class="px-4 py-3 text-sm text-gray-400">–</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $riwayatKas->links() }}
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-receipt text-3xl mb-2 text-gray-300"></i>
                <p>Belum ada transaksi kas.</p>
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

<!-- Chart Bulanan -->
<div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
    <div class="flex justify-between items-center bg-gradient-to-r from-green-600 to-blue-600 px-6 py-4">
        <h3 class="text-lg md:text-xl font-semibold text-white flex items-center">
            <i class="fas fa-chart-line mr-2"></i>
            <span>Grafik Pendapatan per Bulan ({{ $tahunDipilih }})</span>
        </h3>
        <!-- Filter Tahun -->
        <form method="GET" class="bg-white rounded-lg px-3 py-1">
            <select name="tahun" onchange="this.form.submit()" class="border-0 text-sm font-medium text-gray-700">
                @php
                    $currentYear = now()->year;
                    $allowedYears = [$currentYear, $currentYear - 1]; // tahun ini dulu, baru tahun lalu
                @endphp
                @foreach($allowedYears as $thn)
                    <option value="{{ $thn }}" {{ $tahunDipilih == $thn ? 'selected' : '' }}>
                        {{ $thn }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="p-4 md:p-6">
        <canvas id="monthlyIncomeChart" style="height: 400px;"></canvas>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('monthlyIncomeChart');
        if (!canvas) return;

        const grafikBulananData = @json($grafikBulananData ?? []);

        if (!Array.isArray(grafikBulananData) || grafikBulananData.length === 0) return;

        const bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Siapkan data total pendapatan per bulan
        const dataPoints = Array(12).fill(0);
        grafikBulananData.forEach(item => {
            dataPoints[item.month - 1] = item.total_pendapatan;
        });

        // Dataset tunggal (total pendapatan)
        const datasets = [{
            label: 'Total Pendapatan',
            data: dataPoints,
            fill: false,
            tension: 0.3,
            borderColor: '#357ABD',
            backgroundColor: '#4A90E2',
            borderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
        }];

        // Buat chart
        new Chart(canvas.getContext('2d'), {
            type: 'line',
            data: { labels: bulanLabels, datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 12, family: 'Inter' }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        cornerRadius: 8,
                        callbacks: {
                            label: ctx => {
                                if (ctx.parsed.y !== null) {
                                    return 'Rp' + new Intl.NumberFormat('id-ID').format(ctx.parsed.y);
                                }
                            },
                            footer: items => {
                                let sum = items.reduce((acc, item) => acc + item.parsed.y, 0);
                                return 'Total: Rp' + new Intl.NumberFormat('id-ID').format(sum);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 12, family: 'Inter' } },
                        title: {
                            display: true,
                            text: 'Bulan',
                            font: { size: 14, family: 'Inter', weight: 'bold' },
                            color: '#374151'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' },
                        ticks: {
                            font: { size: 12, family: 'Inter' },
                            callback: v => 'Rp' + new Intl.NumberFormat('id-ID').format(v)
                        },
                        title: {
                            display: true,
                            text: 'Pendapatan (Rp)',
                            font: { size: 14, family: 'Inter', weight: 'bold' },
                            color: '#374151'
                        }
                    }
                },
                animation: { duration: 1000, easing: 'easeOutQuart' }
            }
        });
    });
</script>
@endpush