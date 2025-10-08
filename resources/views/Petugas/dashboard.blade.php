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
            <div class="bg-gradient-to-br from-green-400 via-green-500 to-green-600 text-white rounded-2xl shadow-2xl p-6 card-hover relative overflow-hidden">
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <h3 class="text-lg font-semibold opacity-90">Total Setoran</h3>
                        <p class="text-4xl font-bold mt-2">{{ $totalSetoran }}</p>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-boxes text-2xl"></i> {{-- ❌ Tidak bergerak --}}
                    </div>
                </div>
                <p class="text-sm opacity-80 mt-4">Jumlah Semua Setoran</p>
            </div>

            <!-- Total Berat -->
            <div class="bg-gradient-to-br from-blue-400 via-blue-500 to-blue-600 text-white rounded-2xl shadow-2xl p-6 card-hover relative overflow-hidden">
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <h3 class="text-lg font-semibold opacity-90">Total Berat (kg)</h3>
                        <p class="text-4xl font-bold mt-2">{{ number_format($totalBerat, 2) }}</p>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-weight-hanging text-2xl animate-pulse"></i>
                    </div>
                </div>
                <p class="text-sm opacity-80 mt-4">Berat sampah terkumpul</p>
            </div>

            <!-- Total Harga -->
            <div class="bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-600 text-white rounded-2xl shadow-2xl p-6 card-hover relative overflow-hidden">
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <h3 class="text-lg font-semibold opacity-90">Pendapatan Semua Nasabah</h3>
                        <p class="text-4xl font-bold mt-2">Rp{{ number_format($totalHarga, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-wallet text-2xl"></i>
                    </div>
                </div>
                <p class="text-sm opacity-80 mt-4">Nilai ekonomi setoran</p>
            </div>

            <!-- 🟢 Total Uang Kas -->
            <div class="bg-gradient-to-br from-emerald-400 via-emerald-500 to-emerald-600 text-white rounded-2xl shadow-2xl p-6 card-hover relative overflow-hidden">
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <h3 class="text-lg font-semibold opacity-90">Total Uang Kas</h3>
                        <p class="text-4xl font-bold mt-2">Rp{{ number_format($totalKas, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-coins text-2xl"></i> {{-- ❌ Tidak bergerak --}}
                    </div>
                </div>
                <p class="text-sm opacity-80 mt-4">Jumlah uang kas keseluruhan</p>
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
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
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
