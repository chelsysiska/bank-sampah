@extends('layouts.admin')

@section('title', 'Data Setoran')

@section('header_title', 'Data Setoran')

@section('header_subtitle', 'Daftar semua setoran yang telah dicatat.')

@section('content')
    <div class="bg-white shadow-lg rounded-2xl p-6 text-gray-800">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Riwayat Setoran</h3>
        
        {{-- Loop utama ... (sama seperti sebelumnya) --}}
        @forelse($setoransGroupedByMonth as $monthKey => $setoransInMonth)
            @php
                $date = \Carbon\Carbon::createFromFormat('Y-m', $monthKey);
                $monthName = $date->translatedFormat('F Y');
                $monthlyTotal = $setoransInMonth->sum('total_harga');
            @endphp

            <div class="mt-8 mb-4 p-4 border rounded-lg bg-green-50 shadow-md">
                <h4 class="text-xl font-extrabold text-green-800">
                    Bulan: {{ $monthName }}
                </h4>
                <p class="text-lg font-semibold text-green-700 mt-1">
                    Total Pendapatan Bulan Ini: <span class="text-red-600">Rp{{ number_format($monthlyTotal, 0, ',', '.') }}</span>
                </p>
            </div>

            <div class="overflow-x-auto mb-8 border rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-green-100">
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
                        @foreach($setoransInMonth as $setoran)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($setoran->tanggal_setoran)->translatedFormat('d F Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $setoran->nasabah->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $setoran->jenisSampah->nama ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($setoran->berat, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp{{ number_format($setoran->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-green-50 border-t-2 border-green-300">
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-right text-sm font-bold text-green-700 uppercase tracking-wider">
                                Total Setoran Bulan Ini ({{ $monthName }})
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm font-extrabold text-red-600">
                                Rp{{ number_format($monthlyTotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @empty
            <div class="p-6 text-center text-gray-500 bg-gray-50 rounded-lg shadow-inner">
                Tidak ada data setoran yang telah dilaporkan.
            </div>
        @endforelse
    </div>
@endsection
