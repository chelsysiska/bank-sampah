<!DOCTYPE html>
<html lang="id">
<head>
    </head>
<body class="bg-gray-50 flex min-h-screen">

    <aside class="w-64 bg-white shadow-xl min-h-screen fixed left-0 top-0 z-50">
        </aside>

    <main class="flex-1 ml-0 md:ml-64 p-4 md:p-6 transition-all duration-300">
        <header class="bg-white shadow-lg rounded-2xl p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-users mr-3 text-green-600"></i>
                Kelola Nasabah
            </h2>
            <p class="text-gray-600 mt-1">Daftar semua nasabah yang terdaftar di sistem.</p>
        </header>

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
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nasabah->name }}</td>
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
    </main>
</body>
</html>