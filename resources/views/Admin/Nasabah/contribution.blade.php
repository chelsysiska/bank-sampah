@extends('layouts.admin')

@section('title', 'Kontribusi Nasabah')

@section('header_title', 'Kontribusi Nasabah')

@section('header_subtitle', 'Analisis setoran bulanan untuk ' . $nasabah->name)

@section('content')
    <div class="bg-white shadow-lg rounded-2xl p-6 mb-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Grafik Kontribusi Setoran (dalam kg)</h3>
        <canvas id="setoranChart" class="w-full"></canvas>
    </div>

    {{-- Tambahkan kode ini untuk tabel --}}
    <div class="bg-white shadow-lg rounded-2xl p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Rekap Data Setoran</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Bulan & Tahun</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Total Berat (kg)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($monthlyData as $data)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ \Carbon\Carbon::createFromDate($data->tahun, $data->bulan, 1)->translatedFormat('F Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($data->total_berat, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada data setoran yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const data = @json($monthlyData);

        const labels = data.map(item => {
            const date = new Date(item.tahun, item.bulan - 1);
            return date.toLocaleString('id-ID', { month: 'short', year: 'numeric' });
        });

        const setoranData = data.map(item => item.total_berat);

        const ctx = document.getElementById('setoranChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Berat Setoran (kg)',
                    data: setoranData,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    tension: 0.1,
                    fill: true
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
                        display: true
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
    });
</script>
@endpush