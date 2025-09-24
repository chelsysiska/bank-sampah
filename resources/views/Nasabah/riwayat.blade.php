@extends('layouts.nasabah')

@section('title', 'Riwayat Setoran')

@section('content')
<div class="max-w-7xl mx-auto min-h-full">
    <div class="mb-8 text-center md:text-left">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center md:justify-start">
            <i class="fas fa-history text-green-600 mr-3"></i>
            Riwayat Setoran Anda
        </h1>
        <p class="text-gray-600">
            Berikut adalah detail riwayat setoran sampah Anda.
        </p>
    </div>

    <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Sampah</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Berat (kg)</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($riwayatSetoran as $setoran)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ \Carbon\Carbon::parse($setoran->tanggal_setoran)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ $setoran->jenisSampah->nama ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ number_format($setoran->berat, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                        Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                        Belum ada riwayat setoran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($riwayatSetoran) && $riwayatSetoran->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $riwayatSetoran->links() }}
    </div>
    @endif
</div>
@endsection