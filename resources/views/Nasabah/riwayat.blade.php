@extends('layouts.nasabah')

@section('title', 'Riwayat Setoran')
@section('header_title', 'Riwayat Setoran')
@section('header_subtitle', 'Detail lengkap riwayat setoran sampah Anda')

@section('content')
<div class="bg-white shadow-xl rounded-2xl overflow-hidden">
    <!-- Table Header -->
    <div class="bg-gradient-to-r from-green-600 to-blue-600 px-6 py-4">
        <h3 class="text-lg md:text-xl font-semibold text-white flex items-center">
            <i class="fas fa-list-alt mr-2"></i>
            <span>Detail Riwayat Setoran</span>
        </h3>
    </div>
    
    <!-- Table Content -->
    <div class="p-4 md:p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Sampah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Berat (kg)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga per Kg</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($riwayatSetoran as $setoran)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($setoran->tanggal_setoran)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $setoran->jenisSampah->nama ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ number_format($setoran->berat, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                Rp{{ number_format($setoran->harga_per_kilo, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                Rp{{ number_format($setoran->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $setoran->petugas->name ?? 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p>Belum ada riwayat setoran</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($riwayatSetoran->hasPages())
            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan {{ $riwayatSetoran->firstItem() }} - {{ $riwayatSetoran->lastItem() }} dari {{ $riwayatSetoran->total() }} setoran
                </div>
                <div class="flex space-x-2">
                    {{ $riwayatSetoran->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Info Section -->
<div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200">
    <div class="flex items-center">
        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mr-4">
            <i class="fas fa-info-circle text-white text-xl"></i>
        </div>
        <div>
            <h4 class="text-lg font-semibold text-blue-800">Informasi Setoran</h4>
            <p class="text-blue-600 mt-1">
                Nasabah hanya dapat melihat riwayat setoran dan total pendapatan. 
                Untuk informasi saldo dan penarikan, silakan hubungi petugas bank sampah.
            </p>
        </div>
    </div>
</div>
@endsection