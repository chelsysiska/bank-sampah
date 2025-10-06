@extends('layouts.petugas')

@section('title', isset($jenisSampah) ? 'Edit Jenis Sampah' : 'Tambah Jenis Sampah')

@section('header_title')
    <i class="fas fa-trash-alt mr-3 text-green-600"></i>
    {{ isset($jenisSampah) ? 'Edit Jenis Sampah' : 'Tambah Jenis Sampah' }}
@endsection

@section('header_subtitle', 'Formulir untuk mengelola data jenis sampah.')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-6">
    <form 
        action="{{ isset($jenisSampah) && $jenisSampah->id 
                    ? route('petugas.sampah.update', $jenisSampah->id) 
                    : route('petugas.sampah.store') }}" 
        method="POST">
        @csrf
        @if(isset($jenisSampah))
            @method('PUT')
        @endif

        <!-- Nama Jenis Sampah -->
        <div class="mb-4">
            <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Jenis Sampah</label>
            <input type="text" id="nama" name="nama" 
                   value="{{ old('nama', $jenisSampah->nama ?? '') }}"
                   class="w-full px-4 py-2 border text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('nama') border-red-500 @enderror" 
                   required>
            @error('nama')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Harga per Kg -->
        <div class="mb-6">
            <label for="harga_per_kilo" class="block text-gray-700 font-semibold mb-2">Harga per Kg (Rp)</label>
            <input type="number" id="harga_per_kilo" name="harga_per_kilo" 
                   value="{{ old('harga_per_kilo', $jenisSampah->harga_per_kilo ?? '') }}"
                   class="w-full px-4 py-2 border text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('harga_per_kilo') border-red-500 @enderror" 
                   step="0.01" min="0" required>
            @error('harga_per_kilo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol -->
        <div class="flex items-center justify-between">
            <a href="{{ route('petugas.sampah.index') }}" 
               class="px-4 py-2 text-gray-700 rounded-lg border hover:bg-gray-100 transition duration-300">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 transition duration-300">
                {{ isset($jenisSampah) ? 'Perbarui' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection
