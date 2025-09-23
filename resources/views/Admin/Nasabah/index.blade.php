@extends('layouts.admin')

@section('title', 'Kelola Nasabah')

@section('header_title', 'Kelola Nasabah')

@section('header_subtitle', 'Daftar semua nasabah yang terdaftar di sistem.')

@section('content')
    <div class="bg-white shadow-lg rounded-2xl p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Daftar Nasabah</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-green-600 uppercase tracking-wider">Bergabung Sejak</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($nasabahs as $nasabah)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.nasabah.contribution', $nasabah->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    {{ $nasabah->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $nasabah->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($nasabah->created_at)->translatedFormat('d F Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data nasabah yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $nasabahs->links() }}
        </div>
    </div>
@endsection