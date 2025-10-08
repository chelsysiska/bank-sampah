@extends('layouts.petugas')

@section('title', 'Input Setoran')

@section('header_icon')
    <i class="fas fa-plus-circle mr-3 text-green-600"></i>
@endsection

@section('header_title', 'Input Setoran')

@section('header_subtitle', 'Isi data setoran nasabah dengan lengkap.')

@section('content')
<div class="bg-white shadow-md rounded-xl p-8">
    <form id="setoranForm" action="{{ route('petugas.setoran.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="p-4 bg-green-100 border-l-4 border-green-500 rounded-lg">
            <label class="block text-gray-900 font-medium mb-2">👤 Nasabah</label>
            <select name="nasabah_id"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 bg-white text-gray-900">
                <option value="" disabled selected>-- Pilih Nasabah --</option>
                @foreach($nasabahs as $n)
                    <option value="{{ $n->id }}">{{ $n->name }} - {{ $n->nik }}</option>
                @endforeach
            </select>
        </div>

        <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 rounded-lg">
    <label class="block text-gray-900 font-medium mb-2">📅 Tanggal Setoran</label>
    <input type="date" name="tanggal_setoran" id="tanggal_setoran"
        max="{{ date('Y-m-d') }}"
        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 bg-white text-gray-900">
</div>

        <div class="p-4 bg-blue-100 border-l-4 border-blue-500 rounded-lg">
            <label class="block text-gray-900 font-medium mb-2">♻️ Jenis Sampah</label>
            <select name="jenis_sampah_id" id="jenis"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900">
                <option value="" selected disabled>-- Pilih Jenis Sampah --</option>
                @foreach($jenis as $j)
                    <option value="{{ $j->id }}" data-harga="{{ $j->harga_per_kilo }}">
                        {{ $j->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="p-4 bg-purple-100 border-l-4 border-purple-500 rounded-lg">
    <label class="block text-gray-900 font-medium mb-2">⚖️ Berat (kg)</label>
    <input type="number" id="berat" name="berat" 
        step="0.5" min="0.5" placeholder="Pilih berat"
        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 bg-white text-gray-900">
</div>


        <div class="p-4 bg-pink-100 border-l-4 border-pink-500 rounded-lg">
            <label class="block text-gray-900 font-medium mb-2">💰 Harga per kilo</label>
            <input type="number" step="0.01" name="harga_per_kilo" id="harga_input" readonly
                class="w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 text-gray-900">
        </div>

        <div class="p-4 bg-indigo-100 border-l-4 border-indigo-500 rounded-lg">
            <label class="block text-gray-900 font-medium mb-2">💵 Total Harga</label>
            <input type="number" step="0.01" name="total_harga" id="total_harga" readonly
                class="w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-900">
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow transition">
                💾 Simpan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const jenis = document.getElementById('jenis');
    const hargaInput = document.getElementById('harga_input');
    const beratInput = document.getElementById('berat');
    const totalInput = document.getElementById('total_harga');
    const form = document.getElementById('setoranForm');

    function hitungTotal() {
        const harga = parseFloat(hargaInput.value) || 0;
        const berat = parseFloat(beratInput.value) || 0;
        totalInput.value = (harga * berat).toFixed(2);
    }

    jenis.addEventListener('change', function(e) {
        const selected = e.target.selectedOptions[0];
        const harga = selected.dataset.harga || 0;
        hargaInput.value = harga;
        hitungTotal();
    });

    beratInput.addEventListener('input', hitungTotal);

    // 🔔 Validasi sebelum submit
    form.addEventListener('submit', function(e) {
        const nasabah = form.querySelector('[name="nasabah_id"]').value;
        const tanggal = form.querySelector('[name="tanggal_setoran"]').value;
        const jenis = form.querySelector('[name="jenis_sampah_id"]').value;
        const berat = form.querySelector('[name="berat"]').value;

        if (!nasabah || !tanggal || !jenis || !berat) {
            e.preventDefault(); // cegah submit
            alert('⚠️ Semua data wajib diisi sebelum menyimpan!');
        }
    });

    // Inisialisasi awal jika ada nilai yang sudah dipilih
    document.addEventListener('DOMContentLoaded', function() {
        if (jenis.value) {
            const selected = jenis.selectedOptions[0];
            const harga = selected.dataset.harga || 0;
            hargaInput.value = harga;
            hitungTotal();
        }
    });
</script>
@endpush
