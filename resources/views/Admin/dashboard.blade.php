@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('header_title', 'Dashboard Admin')

@section('header_subtitle', 'Kelola dan lihat rekapitulasi laporan bulanan.')

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-yellow-500">
        <div class="flex items-center">
            <i class="fas fa-money-bill-wave text-4xl text-yellow-500 mr-4"></i>
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Total Pendapatan Semua Nasabah</h3>
                <p class="text-3xl font-bold text-yellow-600 mt-1">
                    Rp{{ number_format($totalPendapatanSemuaNasabah, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
        <div class="flex items-center">
            <i class="fas fa-weight-hanging text-4xl text-green-500 mr-4"></i>
            <div>
                <h3 class="text-lg font-semibold text-gray-700">Total Berat Sampah</h3>
                <p class="text-3xl font-bold text-green-600 mt-1">
                    {{ number_format($totalBeratSemuaNasabah, 2, ',', '.') }} kg
                </p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white shadow-lg rounded-2xl p-6 mb-8">
    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-file-alt mr-2 text-blue-600"></i>
        Rekap Laporan Bulanan
    </h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-green-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Petugas</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Bulan & Tahun</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Jumlah Setoran</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Total Berat (kg)</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Total Harga</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($laporans as $laporan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $laporan->petugas?->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::createFromDate($laporan->tahun, $laporan->bulan)->translatedFormat('F Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $laporan->jumlah_setoran }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($laporan->total_berat, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($laporan->total_harga, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada laporan yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $laporans->links() }}</div>
</div>

<hr class="my-8">

<div class="bg-white shadow-lg rounded-2xl p-6">
    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-chart-line mr-2 text-green-600"></i>
        Grafik Total Berat Sampah per Bulan
    </h3>
    @if ($grafikBulananData->isEmpty())
        <p class="text-gray-500 text-center">Tidak ada data setoran yang dapat ditampilkan dalam grafik.</p>
    @else
        <canvas id="monthlyWasteChart" class="w-full"></canvas>
    @endif
</div>

@endsection

@push('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const grafikBulananData = @json($grafikBulananData);
        const jenisSampahData = @json($jenisSampahData);

        const bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const datasets = [];
        const colors = ['#4A90E2', '#50C878', '#FFD700', '#FF6384', '#9966FF', '#FF9F40'];
        let colorIndex = 0;

        jenisSampahData.forEach(jenis => {
            const dataPoints = Array(12).fill(0);
            grafikBulananData.forEach(item => {
                if (item.jenis_sampah_id === jenis.id) {
                    dataPoints[item.month - 1] = item.total_berat;
                }
            });

            datasets.push({
                label: jenis.nama,
                data: dataPoints,
                backgroundColor: colors[colorIndex % colors.length],
                borderColor: colors[colorIndex % colors.length],
                borderWidth: 1
            });
            colorIndex++;
        });

        const ctx = document.getElementById('monthlyWasteChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: bulanLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true,
                        title: { display: true, text: 'Bulan' }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        title: { display: true, text: 'Berat (kg)' }
                    }
                },
                plugins: {
                    tooltip: {
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
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });
    });
</script>
@endpush