@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')

@section('header_title', 'Dashboard Petugas')

@section('header_subtitle', 'Selamat datang kembali! Kelola setoran sampah Anda dengan mudah.')

@section('content')
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-green-400 to-green-600 text-white rounded-2xl shadow-lg p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold opacity-90">Total Setoran</h3>
                        <p class="text-3xl font-bold mt-2">{{ $totalSetoran }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-boxes text-xl"></i>
                    </div>
                </div>
                <p class="text-sm opacity-80 mt-3">Setoran bulan ini</p>
            </div>
            
            <div class="bg-gradient-to-br from-blue-400 to-blue-600 text-white rounded-2xl shadow-lg p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold opacity-90">Total Berat (kg)</h3>
                        <p class="text-3xl font-bold mt-2">{{ number_format($totalBerat, 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-weight-hanging text-xl"></i>
                    </div>
                </div>
                <p class="text-sm opacity-80 mt-3">Berat sampah terkumpul</p>
            </div>
            
            <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 text-white rounded-2xl shadow-lg p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold opacity-90">Total Harga</h3>
                        <p class="text-3xl font-bold mt-2">Rp{{ number_format($totalHarga, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-wallet text-xl"></i>
                    </div>
                </div>
                <p class="text-sm opacity-80 mt-3">Nilai ekonomi setoran</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-clock mr-2 text-green-600"></i>
                Aktivitas Terbaru
            </h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-700">Setoran berhasil ditambahkan</p>
                            <p class="text-sm text-gray-500">Hari ini, 2 jam lalu</p>
                        </div>
                    </div>
                    <span class="text-green-600 font-medium">Rp12,000</span>
                </div>
            </div>
        </div>
    </div>
@endsection