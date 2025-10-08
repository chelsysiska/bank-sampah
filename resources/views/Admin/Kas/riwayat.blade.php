@extends('layouts.admin')

@section('title', 'Riwayat Uang Kas')

@section('header_title', 'Riwayat Uang Kas')

@section('header_subtitle', 'Transaksi pemasukan dan pengeluaran kas operasional.')

@section('content')

<!-- Riwayat Kas -->
<div class="bg-white shadow-xl rounded-2xl overflow-hidden">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
        <h3 class="text-lg md:text-xl font-semibold text-white flex items-center">
            <i class="fas fa-history mr-2"></i>
            <span>Riwayat Transaksi Kas</span>
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
                                @if(auth()->user()->isAdmin())
                                    <td class="px-4 py-3 text-sm">
                                        @if($kas->dokumentasi)
                                            <a href="{{ asset('storage/' . $kas->dokumentasi) }}" target="_blank" class="text-blue-600 hover:underline">
                                                <i class="fas fa-image mr-1"></i>Lihat
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">Tidak ada</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

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

@endsection
