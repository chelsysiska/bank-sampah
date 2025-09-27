@extends('layouts.nasabah')

@section('title', 'Dashboard Nasabah')
@section('header_title', 'Dashboard Nasabah')
@section('header_subtitle', 'Selamat datang kembali, ' . auth()->user()->name . '! 🌱')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 rounded-3xl p-8 mb-8 relative overflow-hidden card-hover">
    <div class="absolute inset-0 bg-black/10"></div>
    <div class="relative z-10 text-white">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="text-center md:text-left mb-6 md:mb-0">
                <h2 class="text-3xl md:text-4xl font-bold mb-2 flex items-center justify-center md:justify-start">
                    <i class="fas fa-seedling mr-3 floating" style="animation-delay: 0.2s;"></i>
                    Kontribusi Lingkungan Anda
                </h2>
                <p class="text-lg opacity-90">Terima kasih telah berkontribusi untuk bumi yang lebih hijau! 🌍</p>
            </div>
            <div class="text-center">
                <div class="bg-white/20 rounded-2xl p-4 backdrop-blur-sm">
                    <i class="fas fa-trophy text-3xl mb-2"></i>
                    <p class="font-semibold">Eco Warrior</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Decorative elements -->
    <div class="absolute top-4 right-4 w-16 h-16 bg-white/10 rounded-full floating" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-4 left-4 w-12 h-12 bg-white/5 rounded-full floating" style="animation-delay: 1.5s;"></div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 animate-stagger">
    <!-- Total Pendapatan Pribadi Card -->
    <div class="card-hover bg-gradient-to-br from-amber-500 to-orange-500 p-8 rounded-3xl shadow-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative z-10 text-white">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-wallet text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">Total Pendapatan Anda</h3>
                        <p class="opacity-90">Akumulasi pendapatan personal</p>
                    </div>
                </div>
                <i class="fas fa-arrow-right text-xl opacity-60 group-hover:translate-x-2 transition-transform"></i>
            </div>
            <p class="text-4xl md:text-5xl font-bold mb-2 text-glow">
                Rp{{ number_format($totalPendapatanPribadi, 0, ',', '.') }}
            </p>
            <div class="flex items-center text-sm opacity-90">
                <i class="fas fa-user-circle mr-2"></i>
                <span>Pencapaian Personal</span>
            </div>
        </div>
        
        <!-- Animated wave -->
        <div class="absolute bottom-0 left-0 right-0 h-2 bg-white/30">
            <div class="h-full bg-white/50 rounded-full animate-pulse" style="width: 85%"></div>
        </div>
    </div>

    <!-- Total Pendapatan Semua Nasabah Card -->
    <div class="card-hover bg-gradient-to-br from-blue-500 to-purple-600 p-8 rounded-3xl shadow-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative z-10 text-white">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">Pendapatan Komunitas</h3>
                        <p class="opacity-90">Total seluruh nasabah</p>
                    </div>
                </div>
                <i class="fas fa-arrow-right text-xl opacity-60 group-hover:translate-x-2 transition-transform"></i>
            </div>
            <p class="text-4xl md:text-5xl font-bold mb-2 text-glow">
                Rp{{ number_format($totalPendapatanSemuaNasabah, 0, ',', '.') }}
            </p>
            <div class="flex items-center text-sm opacity-90">
                <i class="fas fa-globe-asia mr-2"></i>
                <span>Kontribusi Komunitas</span>
            </div>
        </div>
        
        <!-- Animated dots -->
        <div class="absolute top-4 right-4 flex space-x-1">
            <div class="w-2 h-2 bg-white/40 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
            <div class="w-2 h-2 bg-white/40 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            <div class="w-2 h-2 bg-white/40 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
        </div>
    </div>
</div>

<!-- Riwayat Setoran Terbaru -->
<div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl overflow-hidden mb-8 card-hover">
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-history mr-3 floating"></i>
                Riwayat Setoran Terbaru
            </h3>
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm text-white">Terbaru</span>
        </div>
    </div>
    
    <div class="p-6">
        @if($riwayatSetoran->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="pb-4 text-left text-sm font-semibold text-gray-600">Tanggal</th>
                            <th class="pb-4 text-left text-sm font-semibold text-gray-600">Jenis Sampah</th>
                            <th class="pb-4 text-left text-sm font-semibold text-gray-600">Berat</th>
                            <th class="pb-4 text-left text-sm font-semibold text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($riwayatSetoran as $setoran)
                            <tr class="hover:bg-green-50/50 transition-colors group">
                                <td class="py-4 text-sm font-medium text-gray-900 group-hover:text-green-600">
                                    {{ \Carbon\Carbon::parse($setoran->tanggal_setoran)->format('d M Y') }}
                                </td>
                                <td class="py-4 text-sm text-gray-700">
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                        {{ $setoran->jenisSampah->nama ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-4 text-sm text-gray-700">{{ number_format($setoran->berat, 2) }} kg</td>
                                <td class="py-4 text-sm font-semibold text-green-600 group-hover:scale-110 transition-transform">
                                    Rp{{ number_format($setoran->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('nasabah.riwayat') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-2xl font-semibold hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-list mr-2"></i>
                    Lihat Semua Riwayat
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <h4 class="text-lg font-semibold text-gray-600 mb-2">Belum ada riwayat setoran</h4>
                <p class="text-gray-500">Setoran pertama Anda akan muncul di sini</p>
            </div>
        @endif
    </div>
</div>

<!-- Rekap Bulanan -->
@if(isset($bulanan) && $bulanan->count() > 0)
<div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl overflow-hidden card-hover">
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-8 py-6">
        <h3 class="text-xl font-semibold text-white flex items-center">
            <i class="fas fa-chart-bar mr-3 floating"></i>
            Rekap Bulanan
        </h3>
    </div>
    
    <div class="p-6">
        <div class="grid gap-4">
            @foreach($bulanan as $item)
            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl hover:from-blue-100 hover:to-purple-100 transition-all duration-300 group">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center text-white">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">{{ \Carbon\Carbon::create($item->tahun, $item->bulan)->translatedFormat('F Y') }}</h4>
                        <p class="text-sm text-gray-600">{{ number_format($item->total_berat, 1) }} kg sampah</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-green-600">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500">Pendapatan</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Eco Impact Section -->
<div class="mt-8 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-3xl p-8 text-white text-center">
    <i class="fas fa-earth-asia text-5xl mb-4 floating"></i>
    <h3 class="text-2xl font-bold mb-2">Dampak Lingkungan Positif</h3>
    <p class="opacity-90 mb-4">Setiap setoran Anda membantu mengurangi polusi dan mendukung ekonomi sirkular</p>
    <div class="grid grid-cols-3 gap-4 text-center">
        <div>
            <p class="text-2xl font-bold">🌿</p>
            <p class="text-sm">Ekosistem Terjaga</p>
        </div>
        <div>
            <p class="text-2xl font-bold">💧</p>
            <p class="text-sm">Air Bersih</p>
        </div>
        <div>
            <p class="text-2xl font-bold">🌍</p>
            <p class="text-sm">Bumi Sehat</p>
        </div>
    </div>
</div>
@endsection