@extends('layouts.admin')

@section('title', 'Data Setoran')

@section('header_title', 'Data Setoran')

@section('header_subtitle', 'Daftar semua setoran yang telah dicatat.')

@section('content')
    <div class="bg-white shadow-lg rounded-2xl p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Riwayat Setoran</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Nasabah</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Jenis Sampah</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Berat (kg)</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Total Harga</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($setorans as $setoran)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($setoran->tanggal_setoran)->translatedFormat('d F Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $setoran->nasabah->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $setoran->jenisSampah->nama ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($setoran->berat, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($setoran->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data setoran yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $setorans->links() }}</div>
    </div>
@endsection