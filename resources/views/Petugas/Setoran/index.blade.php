@extends('layouts.petugas')

@section('title', 'Data Setoran')
@section('header_title', 'Data Setoran')
@section('header_subtitle', 'Daftar semua setoran yang telah dicatat.')

@section('content')
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Riwayat Setoran</h3>
            
            <form action="{{ route('petugas.laporan.kirim') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i> Kirim Laporan ke Admin
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-green-600 text-white text-left">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Nasabah</th>
                        <th class="px-4 py-3">Jenis Sampah</th>
                        <th class="px-4 py-3">Berat (kg)</th>
                        <th class="px-4 py-3">Total Harga</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($setorans as $index => $setoran)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $setorans->firstItem() + $index }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($setoran->tanggal_setoran)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">{{ $setoran->nasabah->name }}</td>
                            <td class="px-4 py-3">{{ $setoran->jenisSampah->nama }}</td>
                            <td class="px-4 py-3">{{ number_format($setoran->berat, 2) }}</td>
                            <td class="px-4 py-3 text-green-600 font-semibold">Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                @if($setoran->is_reported)
                                    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Dilaporkan</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Belum Dilaporkan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-center text-gray-500" colspan="7">Belum ada data setoran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $setorans->links() }}
        </div>
    </div>
@endsection