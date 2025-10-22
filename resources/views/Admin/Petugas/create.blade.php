@extends('layouts.admin')

@section('title', 'Tambah Petugas')
@section('header_title', 'Tambah Petugas')
@section('header_subtitle', 'Form untuk menambahkan petugas baru.')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl p-6 sm:p-8 border border-gray-200">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6 flex items-center">
        <i class="fas fa-user-plus text-green-600 mr-3"></i> Tambah Petugas Baru
    </h2>

    <form action="{{ route('admin.petugas.store') }}" method="POST" class="space-y-5" autocomplete="off">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium mb-2">NIK (16 digit)</label>
            <input type="text" name="nik" value="{{ old('nik') }}" 
                class="w-full border border-gray-300 text-gray-800 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                placeholder="Masukkan NIK petugas" autocomplete="off">
            @error('nik') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Nama Petugas</label>
            <input type="text" name="name" value="{{ old('name') }}" 
            class="w-full border border-gray-900 text-gray-800 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none" 
            placeholder="Masukkan nama petugas" autocomplete="off">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" 
                class="w-full border border-gray-900 text-gray-800 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                placeholder="Masukkan email petugas" autocomplete="new-email">
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Password</label>
            <input type="password" name="password" 
                class="w-full border border-gray-300 text-gray-800 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                placeholder="Minimal 6 karakter" autocomplete="new-password">
            @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('admin.petugas.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded-lg transition-all">
                Batal
            </a>
            <button type="submit" 
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg transition-all">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
