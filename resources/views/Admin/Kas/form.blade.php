@extends('layouts.admin')

@section('title', $jenis === 'pemasukan' ? 'Tambah Pemasukan Kas' : 'Catat Pengeluaran Kas')

@section('header_title', $jenis === 'pemasukan' ? 'Tambah Pemasukan Kas' : 'Catat Pengeluaran Kas')

@section('header_subtitle', $jenis === 'pemasukan' ? 'Catat pemasukan uang kas baru.' : 'Catat pengeluaran uang kas.')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-2xl shadow-lg">
    <form action="{{ route('admin.kas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="jenis" value="{{ $jenis }}">

        <div class="mb-6">
            <label class="block text-gray-800 font-medium mb-2">
                {{ $jenis === 'pemasukan' ? 'Jumlah Pemasukan' : 'Jumlah Pengeluaran' }} (Rp)
            </label>
            <input type="number" name="jumlah" value="{{ old('jumlah') }}" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800"
                   style="color: #1f2937;"
                   placeholder="Contoh: 50000" required>
            @error('jumlah')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-800 font-medium mb-2">Keterangan</label>
            <textarea name="keterangan" rows="3" 
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800"
                      style="color: #1f2937;"
                      placeholder="Untuk apa pengeluaran ini? / Dari mana pemasukan ini?" required>{{ old('keterangan') }}</textarea>
            @error('keterangan')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
    <label class="block text-gray-800 font-medium mb-2">Dokumentasi (Foto Bukti)</label>
    <input type="file" name="dokumentasi" accept="image/*"
           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
           required> {{-- ✅ wajib diisi --}}
    <p class="text-xs text-gray-500 mt-1">Wajib upload foto bukti (JPG, PNG, GIF, max 2MB)</p>
    @error('dokumentasi')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
</div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-5 py-2.5 bg-{{ $jenis === 'pemasukan' ? 'green' : 'red' }}-600 text-white rounded-lg hover:bg-{{ $jenis === 'pemasukan' ? 'green' : 'red' }}-700 transition">
                {{ $jenis === 'pemasukan' ? 'Simpan Pemasukan' : 'Simpan Pengeluaran' }}
            </button>
        </div>
    </form>
</div>
@endsection