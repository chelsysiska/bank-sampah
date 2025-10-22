@extends('layouts.nasabah')

@section('title', 'Dashboard Nasabah')
@section('header_title', 'Dashboard Nasabah')
@section('header_subtitle', 'Selamat datang kembali, ' . auth()->user()->name . '! 🌱')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 rounded-2xl p-6 mb-6 relative overflow-hidden card-hover">
    <div class="absolute inset-0 bg-black/10"></div>
    <div class="relative z-10 text-white">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="text-center md:text-left mb-4 md:mb-0">
                <h2 class="text-2xl md:text-3xl font-bold mb-1 flex items-center justify-center md:justify-start">
                    <i class="fas fa-seedling mr-2 text-lg" style="animation-delay: 0.2s;"></i>
                    Kontribusi Lingkungan Anda
                </h2>
                <p class="text-base opacity-90">Terima kasih telah berkontribusi untuk bumi yang lebih hijau! 🌍</p>
            </div>
            <div class="text-center">
                <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm">
                    <i class="fas fa-trophy text-2xl mb-1"></i>
                    <p class="font-semibold text-sm">Eco Warrior</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Decorative elements -->
    <div class="absolute top-3 right-3 w-10 h-10 bg-white/10 rounded-full floating" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-3 left-3 w-8 h-8 bg-white/5 rounded-full floating" style="animation-delay: 1.5s;"></div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6 animate-stagger">
    <!-- Total Pendapatan Pribadi Card -->
    <div class="card-hover bg-gradient-to-br from-amber-500 to-orange-500 p-6 rounded-2xl shadow-xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative z-10 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-wallet text-xl"></i>
                    </div>
                    <div style="display:flex;flex-direction:column;justify-content:flex-start;line-height:1;margin:0;padding:0;">
                        <h3 class="text-lg font-semibold" style="margin:0;padding:0;line-height:1;">Total Pendapatan Anda</h3>
                        <p class="opacity-90 text-sm h-[40px] flex items-end" style="margin:0;padding:0;line-height:1;align-items:flex-start !important;height:auto !important;">Kas operasional bank sampah</p>
                    </div>
                </div>
                <i class="fas fa-arrow-right text-lg opacity-60 group-hover:translate-x-2 transition-transform"></i>
            </div>
            <p class="text-3xl md:text-4xl font-bold mb-1 text-glow">
                Rp{{ number_format($totalPendapatanPribadi, 0, ',', '.') }}
            </p>
            <div class="flex items-center text-xs opacity-90">
                <i class="fas fa-user-circle mr-1"></i>
                <span>Pencapaian Personal</span>
            </div>
        </div>
        
        <!-- Animated dots -->
        <div class="absolute top-3 right-3 flex space-x-1">
            <div class="w-1.5 h-1.5 bg-white/40 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
            <div class="w-1.5 h-1.5 bg-white/40 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            <div class="w-1.5 h-1.5 bg-white/40 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
        </div>
    </div>

    <!-- Total Pendapatan Semua Nasabah Card -->
    <div class="card-hover bg-gradient-to-br from-blue-500 to-purple-600 p-6 rounded-2xl shadow-xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative z-10 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div style="display:flex;flex-direction:column;justify-content:flex-start;line-height:1;margin:0;padding:0;">
                        <h3 class="text-lg font-semibold" style="margin:0;padding:0;line-height:1;">Pendapatan Komunitas</h3>
                        <p class="opacity-90 text-sm h-[40px] flex items-end" style="margin:0;padding:0;line-height:1;align-items:flex-start !important;height:auto !important;">Total seluruh nasabah</p>
                    </div>
                </div>
                <i class="fas fa-arrow-right text-lg opacity-60 group-hover:translate-x-2 transition-transform"></i>
            </div>
            <p class="text-3xl md:text-4xl font-bold mb-1 text-glow">
                Rp{{ number_format($totalPendapatanSemuaNasabah, 0, ',', '.') }}
            </p>
            <div class="flex items-center text-xs opacity-90">
                <i class="fas fa-globe-asia mr-1"></i>
                <span>Kontribusi Komunitas</span>
            </div>
        </div>
        
        <!-- Animated dots -->
        <div class="absolute top-3 right-3 flex space-x-1">
            <div class="w-1.5 h-1.5 bg-white/40 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
            <div class="w-1.5 h-1.5 bg-white/40 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            <div class="w-1.5 h-1.5 bg-white/40 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
        </div>
    </div>

    <!-- Total Kas Card -->
    <div class="card-hover bg-gradient-to-br from-indigo-500 to-purple-600 p-6 rounded-2xl shadow-xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative z-10 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-piggy-bank text-xl"></i>
                    </div>
                    <div style="display:flex;flex-direction:column;justify-content:flex-start;line-height:1;margin:0;padding:0;">
                        <h3 class="text-lg font-semibold" style="margin:0;padding:0;line-height:1;">Total Uang Kas</h3>
                        <p class="opacity-90 text-sm h-[40px] flex items-end" style="margin:0;padding:0;line-height:1;align-items:flex-start !important;height:auto !important;">Kas operasional bank sampah</p>
                    </div>
                </div>
                <i class="fas fa-arrow-right text-lg opacity-60 group-hover:translate-x-2 transition-transform"></i>
            </div>
            <p class="text-3xl md:text-4xl font-bold mb-1 text-glow">
                Rp{{ number_format($totalKas, 0, ',', '.') }}
            </p>
            <div class="flex items-center text-xs opacity-90">
                <i class="fas fa-chart-line mr-1"></i>
                <span>Kas Operasional</span>
            </div>
        </div>
        
        <!-- Animated dots -->
        <div class="absolute top-3 right-3 flex space-x-1">
            <div class="w-1.5 h-1.5 bg-white/40 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
            <div class="w-1.5 h-1.5 bg-white/40 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            <div class="w-1.5 h-1.5 bg-white/40 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
        </div>
    </div>
</div>

<!-- Riwayat Setoran Terbaru -->
<div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden mb-6 card-hover">
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-history mr-2"></i>
                Riwayat Setoran Terbaru
            </h3>
            <span class="bg-white/20 px-2 py-0.5 rounded-full text-xs text-white">Terbaru</span>
        </div>
    </div>
    
    <div class="p-5">
        @if($riwayatSetoran->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="pb-3 text-left font-semibold text-gray-600">Tanggal</th>
                            <th class="pb-3 text-left font-semibold text-gray-600">Jenis Sampah</th>
                            <th class="pb-3 text-left font-semibold text-gray-600">Berat</th>
                            <th class="pb-3 text-left font-semibold text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($riwayatSetoran as $setoran)
                            <tr class="hover:bg-green-50/50 transition-colors group">
                                <td class="py-3 font-medium text-gray-900 group-hover:text-green-600">
                                    {{ \Carbon\Carbon::parse($setoran->tanggal_setoran)->format('d M Y') }}
                                </td>
                                <td class="py-3 text-gray-700">
                                    <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded-full text-xs">
                                        {{ $setoran->jenisSampah->nama ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-3 text-gray-700">{{ number_format($setoran->berat, 2) }} kg</td>
                                <td class="py-3 font-semibold text-green-600 group-hover:scale-105 transition-transform">
                                    Rp{{ number_format($setoran->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('nasabah.riwayat') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl font-medium hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105 text-sm">
                    <i class="fas fa-list mr-2"></i>
                    Lihat Semua Riwayat
                </a>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-inbox text-5xl text-gray-300 mb-2"></i>
                <h4 class="text-base font-semibold text-gray-600 mb-1">Belum ada riwayat setoran</h4>
                <p class="text-sm text-gray-500">Setoran pertama Anda akan muncul di sini</p>
            </div>
        @endif
    </div>
</div>

<!-- Eco Impact Section -->
<div class="mt-6 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-2xl p-6 text-white text-center">
    <i class="fas fa-earth-asia text-4xl mb-3"></i>
    <h3 class="text-xl font-bold mb-1">Dampak Lingkungan Positif</h3>
    <p class="opacity-90 mb-3 text-sm">Setiap setoran Anda membantu mengurangi polusi dan mendukung ekonomi sirkular</p>
    <div class="grid grid-cols-3 gap-3 text-center text-sm">
        <div>
            <p class="text-xl">🌿</p>
            <p>Ekosistem Terjaga</p>
        </div>
        <div>
            <p class="text-xl">💧</p>
            <p>Air Bersih</p>
        </div>
        <div>
            <p class="text-xl">🌍</p>
            <p>Bumi Sehat</p>
        </div>
    </div>
</div>
@endsection