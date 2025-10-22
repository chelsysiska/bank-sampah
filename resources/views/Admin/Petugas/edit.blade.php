@extends('layouts.admin')

@section('title', 'Edit Petugas')
@section('header_title', 'Edit Petugas')
@section('header_subtitle', 'Ubah data petugas yang sudah ada.')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl p-6 sm:p-8 border border-gray-200">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6 flex items-center">
        <i class="fas fa-user-edit text-green-600 mr-3"></i> Edit Data Petugas
    </h2>

    {{-- ✅ Pastikan variabel $petugas dikirim dari controller --}}
    @if(isset($petugas))
    <form action="{{ route('admin.petugas.update', $petugas->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 font-medium mb-2">NIK (16 digit)</label>
            <input type="text" name="nik" value="{{ old('nik', $petugas->nik ?? '') }}" 
                class="w-full border border-gray-300 text-gray-800 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
            @error('nik') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Nama Petugas</label>
            <input type="text" name="name" value="{{ old('name', $petugas->name ?? '') }}" 
                class="w-full border border-gray-300 text-gray-800 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', $petugas->email ?? '') }}" 
                class="w-full border border-gray-300 text-gray-800 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Password Baru (opsional)</label>
            <input type="password" name="password" 
                class="w-full border border-gray-300 text-gray-800 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                placeholder="Kosongkan jika tidak ingin mengubah password">
            @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('admin.petugas.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded-lg transition-all">
                Batal
            </a>
            <button type="submit" 
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg transition-all">
                Update
            </button>
        </div>
    </form>
    @else
        <p class="text-center text-gray-600">Data petugas tidak ditemukan.</p>
    @endif
</div>
@endsection
