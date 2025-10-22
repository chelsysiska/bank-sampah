@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')

@section('header_title', 'Dashboard Petugas')

@section('header_subtitle', 'Selamat datang kembali! Kelola setoran sampah Anda dengan mudah dan efisien.')

@section('content')
    <div class="space-y-6 sm:space-y-8">

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="p-4 rounded-lg bg-green-100 border-l-4 border-green-500 text-green-700 shadow-md">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 rounded-lg bg-red-100 border-l-4 border-red-500 text-red-700 shadow-md">
                {{ session('error') }}
            </div>
        @endif

       <!-- Statistik Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
    <!-- Total Setoran -->
    <div class="bg-gradient-to-br from-green-100 to-green-50 text-green-800 border border-green-200 rounded-2xl shadow-lg p-5 card-hover relative overflow-hidden">
        <div class="flex items-center justify-between">
            <div class="flex flex-col justify-between min-h-[90px]">
                <h3 class="text-base font-semibold opacity-90">Total Setoran</h3>
                <p class="text-3xl font-bold leading-none mt-1">{{ $totalSetoran }}</p>
            </div>
            <div class="flex items-center justify-center w-14 h-14 bg-green-500 text-white rounded-xl shrink-0 shadow-md">
                <i class="fas fa-boxes text-2xl animate-pulse"></i>
            </div>
        </div>
        <p class="text-sm text-green-700 opacity-80 mt-3">Jumlah Setoran Bulan Ini</p>
    </div>

    <!-- Total Berat -->
    <div class="bg-gradient-to-br from-purple-100 to-purple-50 text-purple-800 border border-purple-200 rounded-2xl shadow-lg p-5 card-hover relative overflow-hidden">
        <div class="flex items-center justify-between">
            <div class="flex flex-col justify-between min-h-[90px]">
                <h3 class="text-base font-semibold opacity-90">Total Berat (kg)</h3>
                <p class="text-3xl font-bold leading-none mt-1">
    {{ number_format($totalBeratSemuaNasabah ?? $totalBerat, 2) }}
</p>
            </div>
            <div class="flex items-center justify-center w-14 h-14 bg-purple-500 text-white rounded-xl shrink-0 shadow-md">
                <i class="fas fa-weight-hanging text-2xl animate-pulse"></i>
            </div>
        </div>
        <p class="text-sm text-purple-700 opacity-80 mt-3">Berat sampah terkumpul</p>
    </div>

    <!-- Pendapatan Semua Nasabah -->
    <div class="bg-gradient-to-br from-yellow-100 to-yellow-50 text-yellow-800 border border-yellow-200 rounded-2xl shadow-lg p-5 card-hover relative overflow-hidden">
    <div class="flex items-center justify-between">
        <div class="flex flex-col justify-between min-h-[90px] **flex-grow mr-3**">
            <h3 class="text-base font-semibold opacity-90">Pendapatan Semua Nasabah</h3>
            <p class="text-3xl font-bold leading-none mt-1">
    Rp{{ number_format($totalHargaSemuaNasabah ?? $totalHarga, 0, ',', '.') }}
</p>
        </div>
        <div class="flex items-center justify-center w-14 h-14 bg-yellow-500 text-white rounded-xl shrink-0 shadow-md">
            <i class="fas fa-wallet text-2xl animate-pulse"></i>
        </div>
    </div>
    <p class="text-sm text-yellow-700 opacity-80 mt-3">Nilai ekonomi setoran</p>
</div>

    <!-- Total Uang Kas -->
    <div class="bg-gradient-to-br from-sky-100 to-sky-50 text-sky-800 border border-sky-200 rounded-2xl shadow-lg p-5 card-hover relative overflow-hidden">
        <div class="flex items-center justify-between">
            <div class="flex flex-col justify-between min-h-[90px]">
                <h3 class="text-base font-semibold opacity-90">Total Uang Kas</h3>
                <p class="text-3xl font-bold leading-none mt-1">Rp{{ number_format($totalKas, 0, ',', '.') }}</p>
            </div>
            <div class="flex justify-center items-center w-14 h-14 bg-sky-500 text-white rounded-xl shrink-0 shadow-md">
                <i class="fas fa-coins text-2xl animate-pulse"></i>
            </div>
        </div>
        <p class="text-sm text-sky-700 opacity-80 mt-3">Jumlah uang kas keseluruhan</p>
    </div>
</div>
        <!-- Aktivitas Terbaru -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-white/20">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-clock mr-3 text-green-600"></i>
                Aktivitas Terbaru
            </h3>

            <div class="space-y-4">
                @forelse($aktivitas as $a)
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-green-50 rounded-2xl border-l-4 border-green-200 hover:shadow-md transition-all duration-300 hover:scale-[1.01]">
                        <div class="flex items-center w-full sm:w-auto mb-2 sm:mb-0">
                            <div class="w-3 h-3 bg-green-500 rounded-full shadow-sm"></div>
                            <div class="ml-4 flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-base truncate">
                                    Setoran dari {{ $a->nasabah->name ?? 'Nasabah' }} 
                                    ({{ $a->jenisSampah->nama ?? 'Jenis Sampah' }})
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $a->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-green-600 font-bold text-lg">
                                Rp{{ number_format($a->total_harga, 0, ',', '.') }}
                            </span>
                            <div class="flex items-center justify-center w-14 h-14 bg-white/20 rounded-xl shrink-0 relative -mt-5">
                                <i class="fas fa-check text-green-500 text-sm"></i>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Belum ada aktivitas terbaru.</p>
                @endforelse
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('petugas.setoran.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-2xl font-semibold text-base hover:from-green-600 hover:to-green-700 transition-all shadow-lg hover:shadow-xl">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Lihat Semua Aktivitas
                </a>
            </div>
        </div>
    </div>
@endsection
