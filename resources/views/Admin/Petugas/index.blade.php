@extends('layouts.admin')

@section('title', 'Kelola Petugas')
@section('header_title', 'Kelola Petugas')
@section('header_subtitle', 'Tambah, ubah, dan hapus data petugas.')

@section('content')
<div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800 mb-3 md:mb-0">Daftar Petugas</h2>
        <a href="{{ route('admin.petugas.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Petugas
        </a>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-2 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table Section -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-emerald-50 border-b border-gray-200 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold">No</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">NIK</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Nama Petugas</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Email</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-gray-700">
                @forelse ($petugas as $index => $p)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-sm">{{ $p->nik }}</td>
                        <td class="px-4 py-3 text-sm font-medium">{{ $p->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $p->email }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.petugas.edit', $p->id) }}" 
                                   class="text-blue-600 hover:text-blue-800"
                                   title="Edit Petugas">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.petugas.destroy', $p->id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus petugas ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus Petugas">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">
                            Belum ada data petugas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
