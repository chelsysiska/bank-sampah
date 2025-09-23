@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('header_title', 'Dashboard Admin')

@section('header_subtitle', 'Kelola dan lihat rekapitulasi laporan bulanan.')

@section('content')

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
                            <td class="px-6 py-4 whitespace-nowrap">{{ $laporan->petugas->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::create(null, $laporan->bulan, 1)->translatedFormat('F Y') }}</td>
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
            <i class="fas fa-chart-bar mr-2 text-green-600"></i>
            Grafik Berat Sampah Terkumpul per Jenis
        </h3>
        @if ($grafikData->isEmpty())
            <p class="text-gray-500 text-center">Tidak ada data setoran yang dapat ditampilkan dalam grafik.</p>
        @else
            <canvas id="sampahChart" class="w-full"></canvas>
        @endif
    </div>

@endsection

@push('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const grafikData = @json($grafikData);

        if (grafikData.length > 0) {
            const labels = grafikData.map(item => item.jenis);
            const data = grafikData.map(item => item.total_berat);
            const backgroundColors = [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 159, 64, 0.6)'
            ];

            const ctx = document.getElementById('sampahChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Berat (kg)',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: backgroundColors.map(color => color.replace('0.6', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Berat (kg)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
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
                        }
                    }
                }
            });
        }
    });
</script>
@endpush