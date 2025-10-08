@extends('layouts.petugas')

@section('title', 'Data Setoran')
@section('header_title', 'Data Setoran')
@section('header_subtitle', 'Daftar semua setoran yang telah dicatat.')

@section('content')
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Riwayat Setoran</h3>
            
            <div class="flex items-center space-x-4">
                <!-- Info Bulan Berjalan -->
                <div class="bg-blue-50 px-4 py-2 rounded-lg">
                    <span class="text-blue-700 font-medium">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Bulan Berjalan: {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </span>
                </div>
                
                <form action="{{ route('petugas.laporan.kirim') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-colors"
                        onclick="return confirm('Apakah Anda yakin ingin mengirim laporan setoran ke admin?')">
                        <i class="fas fa-paper-plane mr-2"></i> Kirim Laporan ke Admin
                    </button>
                </form>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

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
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3">Aksi</th> {{-- ✅ kolom aksi --}}
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-900">
                    @forelse($setorans as $index => $setoran)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-900">{{ $setorans->firstItem() + $index }}</td>
                            <td class="px-4 py-3 text-gray-900">{{ \Carbon\Carbon::parse($setoran->tanggal_setoran)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-gray-900">{{ $setoran->nasabah->name }}</td>
                            <td class="px-4 py-3 text-gray-900">{{ $setoran->jenisSampah->nama }}</td>
                            <td class="px-4 py-3 text-gray-900">{{ number_format($setoran->berat, 2) }}</td>
                            <td class="px-4 py-3 text-green-600 font-semibold">Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                @if($setoran->is_reported)
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Dilaporkan</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Belum Dilaporkan</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if(!$setoran->is_reported)
                                    <span class="text-blue-600"><i class="fas fa-check-circle mr-1"></i>Bisa dilaporkan</span>
                                @else
                                    <span class="text-gray-600"><i class="fas fa-check-circle mr-1"></i>Terkirim</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if(!$setoran->is_reported)
                                    <form action="{{ route('petugas.setoran.destroy', $setoran->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus setoran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                            <i class="fas fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-center text-gray-800 font-medium" colspan="9">Belum ada data setoran.</td>
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
