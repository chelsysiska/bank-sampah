@extends('layouts.petugas')

@section('title', 'Kelola Sampah')

@section('header_title')
    <i class="fas fa-trash-alt mr-3 text-green-600"></i> Kelola Sampah
@endsection

@section('header_subtitle', 'Daftar jenis sampah yang dikelola bank sampah.')

@section('content')
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <!-- Tombol Tambah -->
        <a href="{{ route('petugas.sampah.create') }}" 
           class="inline-block px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition duration-300 mb-6">
            <i class="fas fa-plus-circle mr-2"></i> Tambah Jenis Sampah
        </a>

        <!-- Tabel Data Sampah -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-xl shadow-sm overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Jenis Sampah
                        </th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Harga per Kg
                        </th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($jenisSampah as $sampah)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-4 px-6 text-sm text-gray-900">{{ $sampah->nama }}</td>
                            <td class="py-4 px-6 text-sm text-gray-900">
                                Rp {{ number_format($sampah->harga_per_kilo, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-sm">
                                <!-- Tombol Edit -->
                                <a href="{{ route('petugas.sampah.edit', $sampah->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 transition-colors duration-200 mr-4">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <!-- Tombol Hapus -->
                                <button onclick="showDeleteModal('{{ $sampah->id }}')" 
                                        class="text-red-600 hover:text-red-800 transition-colors duration-200">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 px-6 text-center text-gray-500">
                                Tidak ada data jenis sampah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="delete-modal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
        <div class="bg-white rounded-xl shadow-2xl p-6 w-96">
            <div class="text-center">
                <i class="fas fa-exclamation-triangle text-5xl text-red-500 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Hapus</h3>
                <p class="text-gray-600 mb-6">
                    Apakah Anda yakin ingin menghapus data ini? Aksi ini tidak bisa dibatalkan.
                </p>
            </div>
            <div class="flex justify-center space-x-4">
                <button onclick="hideDeleteModal()" type="button" 
                        class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                    Batal
                </button>
                <form id="delete-form" method="POST" 
                      data-action-base="{{ route('petugas.sampah.destroy', ['sampah' => '__ID__']) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const deleteModal = document.getElementById('delete-modal');
    const deleteForm = document.getElementById('delete-form');

    function showDeleteModal(id) {
        const baseUrl = deleteForm.getAttribute('data-action-base');
        const deleteUrl = baseUrl.replace('__ID__', id);
        deleteForm.action = deleteUrl;
        deleteModal.classList.remove('hidden'); // tampilkan modal
    }

    function hideDeleteModal() {
        deleteModal.classList.add('hidden'); // sembunyikan modal
    }
</script>
@endpush
