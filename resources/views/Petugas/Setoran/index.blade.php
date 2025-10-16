@extends('layouts.petugas')

@section('title', 'Data Setoran')
@section('header_title', 'Data Setoran')
@section('header_subtitle', 'Daftar semua setoran yang telah dicatat.')

@section('content')
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-500 px-6 py-4 flex flex-col md:flex-row justify-between items-center">
        <div>
            <h3 class="text-lg md:text-xl font-semibold text-white flex items-center">
                <i class="fas fa-recycle mr-2"></i> Riwayat Setoran
            </h3>
            <p class="text-sm text-white/90 mt-1">
                Bulan Berjalan: {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
            </p>
        </div>

        <!-- ✅ Form Kirim / Perbarui Laporan -->
        <div class="flex flex-col md:flex-row items-center gap-3 mt-3 md:mt-0">
            <form action="{{ route('petugas.laporan.kirim') }}" 
                  method="POST" enctype="multipart/form-data"
                  class="flex flex-col md:flex-row items-center gap-2" id="laporanForm">
                @csrf

                <div class="flex flex-col">
                    <input type="file" name="bukti" id="buktiInput" accept="image/*,.pdf"
                        class="bg-white/90 text-sm rounded-lg px-3 py-2 shadow-sm cursor-pointer focus:ring-2 focus:ring-green-400 transition"
                        {{ empty($laporanBulanIni?->bukti) ? 'required' : '' }}>

                    <img id="previewImage" src="#" alt="Preview" class="hidden mt-2 rounded-lg shadow-md max-h-32 border border-white/40">
                </div>

                <button type="submit"
                    id="submitButton"
                    class="px-4 py-2 bg-white text-green-700 font-semibold rounded-lg shadow-md hover:bg-gray-100 transition-all"
                    onclick="return confirm('Kirim atau perbarui laporan bulan ini ke admin?')">
                    <i class="fas fa-paper-plane mr-2"></i>
                    {{ empty($laporanBulanIni?->bukti) ? 'Kirim Laporan' : 'Perbarui Laporan' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Alerts -->
    <div class="p-4">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded">
                <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
            </div>
        @endif
    </div>

    <!-- ✅ Filter Bulan & Tahun -->
<div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-3 relative z-10 overflow-visible">

        <form method="GET" action="{{ route('petugas.setoran.index') }}"
              class="flex flex-wrap items-center gap-3 bg-white p-4 rounded-xl shadow-md overflow-visible flex-grow">
            
            <div class="flex items-center gap-2">
                <label for="bulan" class="text-gray-700 font-medium">Bulan:</label>
                <select name="bulan" id="bulan"
                        class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 bg-white focus:ring-2 focus:ring-green-400 focus:outline-none relative z-50">
                    <option value="">Semua</option>
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <label for="tahun" class="text-gray-700 font-medium">Tahun:</label>
                <select name="tahun" id="tahun"
                        class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 bg-white focus:ring-2 focus:ring-green-400 focus:outline-none relative z-50">
                    <option value="">Semua</option>
                    @for ($t = now()->year; $t >= now()->year - 5; $t--)
                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                            {{ $t }}
                        </option>
                    @endfor
                </select>
            </div>

            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                Filter
            </button>

            <a href="{{ route('petugas.setoran.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                Reset
            </a>

            @if(request('bulan') || request('tahun'))
            <div class="text-sm text-gray-700 italic bg-white px-3 py-2 rounded-lg shadow-sm border border-gray-200 md:ml-2">
                Menampilkan hasil untuk:
                <strong class="text-green-700">
                    {{ request('bulan') ? \Carbon\Carbon::create()->month(request('bulan'))->translatedFormat('F') : 'Semua Bulan' }}
                    {{ request('tahun') ?? '' }}
                </strong>
            </div>
            @endif
        </form>
    </div>
</div>

    <!-- Table -->
    <div class="overflow-x-auto px-4 pb-4">
        <table class="min-w-full border border-gray-200 rounded-lg text-sm bg-white">
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
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-gray-800">
                @forelse($setorans as $index => $setoran)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">{{ $setorans->firstItem() + $index }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($setoran->tanggal_setoran)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">{{ $setoran->nasabah->name }}</td>
                        <td class="px-4 py-3">{{ $setoran->jenisSampah->nama }}</td>
                        <td class="px-4 py-3">{{ number_format($setoran->berat, 2) }}</td>
                        <td class="px-4 py-3 font-semibold text-green-600">
                            Rp {{ number_format($setoran->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3">
                            @if($setoran->is_reported)
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    Dilaporkan
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    Belum Dilaporkan
                                </span>
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
                                <form action="{{ route('petugas.setoran.destroy', $setoran->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus setoran ini?')" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="text-red-600 hover:text-red-800 font-medium transition">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 italic">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-6 text-gray-500">
                            <i class="fas fa-database text-gray-400 text-3xl mb-2"></i><br>
                            Belum ada data setoran.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $setorans->links() }}</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buktiInput = document.getElementById('buktiInput');
    const fileInfo = document.getElementById('fileInfo');
    const submitButton = document.getElementById('submitButton');
    const previewImage = document.getElementById('previewImage');

    buktiInput.addEventListener('change', function() {
        if (buktiInput.files.length > 0) {
            const file = buktiInput.files[0];
            const fileName = file.name;
            const extension = fileName.split('.').pop().toUpperCase();

            fileInfo.textContent = `File dipilih: ${fileName} (${extension})`;
            fileInfo.classList.remove('italic');
            fileInfo.classList.add('font-semibold', 'text-yellow-200');

            submitButton.innerHTML = `<i class="fas fa-paper-plane mr-2"></i>Kirim Bukti Laporan`;

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.classList.add('hidden');
            }
        } else {
            fileInfo.textContent = 'Belum ada bukti laporan.';
            fileInfo.classList.remove('font-semibold', 'text-yellow-200');
            fileInfo.classList.add('italic');
            previewImage.classList.add('hidden');
        }
    });
});
</script>
@endsection
