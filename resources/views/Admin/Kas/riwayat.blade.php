@extends('layouts.admin')

@section('title', 'Riwayat Uang Kas')
@section('header_title', 'Riwayat Uang Kas')
@section('header_subtitle', 'Transaksi pemasukan dan pengeluaran kas operasional.')

@section('content')
<div class="bg-white shadow-xl rounded-2xl overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
        <h3 class="text-lg md:text-xl font-semibold text-white flex items-center">
            <i class="fas fa-history mr-2"></i> Riwayat Transaksi Kas
        </h3>
    </div>

    <div class="p-4 md:p-6">
        <!-- 🔍 Filter Bulan & Tahun -->
        <form method="GET" action="{{ route('admin.kas.riwayat') }}" 
              class="mb-6 flex flex-wrap items-end gap-3 bg-white/80 backdrop-blur-sm p-3 rounded-xl shadow-sm relative overflow-visible z-10">
            <div>
                <label for="bulan" class="block text-sm font-semibold text-gray-800">Bulan</label>
                <select name="bulan" id="bulan" 
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white px-3 py-2">
                    <option value="">Semua</option>
                    @foreach(range(1, 12) as $b)
                        <option value="{{ sprintf('%02d', $b) }}" {{ request('bulan') == sprintf('%02d', $b) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="tahun" class="block text-sm font-semibold text-gray-800">Tahun</label>
                <select name="tahun" id="tahun" 
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white px-3 py-2">
                    <option value="">Semua</option>
                    @foreach($tahunList as $t)
                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                            {{ $t }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2 items-center">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-sm">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
                <a href="{{ route('admin.kas.riwayat') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition shadow-sm">
                    <i class="fas fa-undo mr-1"></i> Reset
                </a>
            </div>
        </form>

        @if($riwayatKas->isNotEmpty())
            <div class="overflow-x-auto -mx-2">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase tracking-wider">Jenis</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase tracking-wider">Keterangan</th>
                            <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase tracking-wider">Jumlah</th>
                            @if(auth()->user()->isAdmin())
                                <th class="px-4 py-3 text-left font-bold text-gray-600 uppercase tracking-wider">Bukti</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($riwayatKas as $kas)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 whitespace-nowrap text-gray-700">
                                    {{ $kas->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($kas->jenis === 'pemasukan')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-arrow-down mr-1"></i> Pemasukan
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-arrow-up mr-1"></i> Pengeluaran
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $kas->keterangan ?? '-' }}</td>
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
                {{ $riwayatKas->appends(['bulan' => request('bulan'), 'tahun' => request('tahun')])->links() }}
            </div>
        @else
            <div class="text-center py-10 text-gray-500">
                <i class="fas fa-leaf text-4xl mb-3 text-gray-300"></i>
                <h4 class="text-lg font-medium mb-1">Belum ada transaksi</h4>
                <p class="text-sm">Data kas akan muncul di sini setelah transaksi tercatat.</p>
            </div>
        @endif
    </div>
</div>

{{-- Tom Select agar dropdown tampil lebih rapi --}}
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new TomSelect('#bulan', {
        dropdownParent: 'body',
        openOnFocus: true,
        positionDropdown: true,
        dropdownDirection: 'down',
    });

    new TomSelect('#tahun', {
        dropdownParent: 'body',
        openOnFocus: true,
        positionDropdown: true,
        dropdownDirection: 'down',
    });
});
</script>
@endsection
