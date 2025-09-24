@extends('layouts.nasabah')

@section('title', 'Dashboard Nasabah')

@section('content')
<div class="max-w-7xl mx-auto min-h-full">
    <div class="mb-8 text-center md:text-left">
        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center md:justify-start">
            <i class="fas fa-tachometer-alt text-green-600 mr-3"></i>
            Dashboard Nasabah
        </h1>
        <p class="text-gray-600">
            Selamat datang kembali,
            <span class="font-semibold text-green-700">{{ auth()->user()->name }}!</span>
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <i class="fas fa-wallet text-yellow-500 text-3xl mr-4"></i>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Total Pendapatan Anda</h2>
                    <p class="text-3xl font-bold text-yellow-600 mt-1">
                        Rp {{ number_format($totalPendapatanPribadi, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border-l-4 border-blue-500">
            <div class="flex items-center">
                <i class="fas fa-users text-blue-500 text-3xl mr-4"></i>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Total Pendapatan Semua Nasabah</h2>
                    <p class="text-3xl font-bold text-blue-600 mt-1">
                        Rp {{ number_format($totalPendapatanSemuaNasabah, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    @if(isset($bulanan) && $bulanan->count() > 0)
    <hr class="my-12 border-gray-200">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-calendar-alt text-green-600 mr-3"></i>
            Rekap Bulanan
        </h2>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan & Tahun</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Berat (kg)</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($bulanan as $item)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ \Carbon\Carbon::create($item->tahun, $item->bulan)->format('F Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ number_format($item->total_berat, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                            Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection