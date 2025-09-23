<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Setoran - Trash2Cash</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%); }
    </style>
</head>
<body class="bg-gray-50 flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-xl min-h-screen fixed left-0 top-0 z-50">
        <div class="gradient-bg p-6 text-center border-b border-white/20">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-recycle text-2xl text-white"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">Trash2Cash</h1>
            <p class="text-sm text-white/80">Petugas Dashboard</p>
        </div>

        <nav class="mt-8 px-4">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('petugas.dashboard') }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 group">
                        <i class="fas fa-chart-line w-5 mr-3 text-gray-400 group-hover:text-green-600"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('petugas.setoran.create') }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-green-600 bg-green-50 transition-all duration-200 group">
                        <i class="fas fa-plus-circle w-5 mr-3 text-green-600"></i>
                        Input Setoran
                    </a>
                </li>
                <li>
                    <a href="{{ route('petugas.setoran.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 group">
                        <i class="fas fa-folder w-5 mr-3 text-gray-400 group-hover:text-green-600"></i>
                        Data Setoran
                    </a>
                </li>
                <li>
                    <a href="{{ route('petugas.sampah.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 group">
                        <i class="fas fa-trash-alt w-5 mr-3 text-gray-400 group-hover:text-green-600"></i>
                        Kelola Sampah
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-200 group">
                        <i class="fas fa-sign-out-alt w-5 mr-3 text-gray-400 group-hover:text-red-600"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </nav>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-0 md:ml-64 p-4 md:p-6 transition-all duration-300">
        <!-- Header -->
        <header class="bg-white shadow-lg rounded-2xl p-6 mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-plus-circle mr-3 text-green-600"></i>
                    Input Setoran
                </h2>
                <p class="text-gray-600 mt-1">Isi data setoran nasabah dengan lengkap.</p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700 font-medium">Halo, {{ auth()->user()->name }}</span>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=10B981&color=fff&size=40" 
                     alt="Avatar" class="w-10 h-10 rounded-full shadow-md">
            </div>
        </header>

        <!-- Form -->
        <!-- Form -->
<div class="bg-white shadow-md rounded-xl p-8">
    <form action="{{ route('petugas.setoran.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Nasabah -->
        <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
            <label class="block text-gray-700 font-medium mb-2">👤 Nasabah</label>
            <select name="nasabah_id"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 bg-white">
                <option value="" disabled selected>-- Pilih Nasabah --</option>
                @foreach($nasabahs as $n)
                    <option value="{{ $n->id }}">{{ $n->name }} - {{ $n->nik }}</option>
                @endforeach
            </select>
        </div>

        <!-- Jenis Sampah -->
        <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
            <label class="block text-gray-700 font-medium mb-2">♻️ Jenis Sampah</label>
            <select name="jenis_sampah_id" id="jenis"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="" selected disabled>-- Pilih Jenis Sampah --</option>
                @foreach($jenis as $j)
                    <option value="{{ $j->id }}" data-harga="{{ $j->harga_per_kilo }}">
                        {{ $j->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tanggal -->
        <div class="p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded-lg">
            <label class="block text-gray-700 font-medium mb-2">📅 Tanggal Setoran</label>
            <input type="date" name="tanggal_setoran"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 bg-white">
        </div>

        <!-- Berat -->
        <div class="p-4 bg-purple-50 border-l-4 border-purple-500 rounded-lg">
            <label class="block text-gray-700 font-medium mb-2">⚖️ Berat (kg)</label>
            <input type="number" step="0.01" id="berat" name="berat" placeholder="Masukkan berat (kg)"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 bg-white">
        </div>

        <!-- Harga -->
        <div class="p-4 bg-pink-50 border-l-4 border-pink-500 rounded-lg">
            <label class="block text-gray-700 font-medium mb-2">💰 Harga per kilo</label>
            <input type="number" step="0.01" name="harga_per_kilo" id="harga_input" readonly
                value=""
                class="w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500">
        </div>

        <!-- Total -->
        <div class="p-4 bg-indigo-50 border-l-4 border-indigo-500 rounded-lg">
            <label class="block text-gray-700 font-medium mb-2">💵 Total Harga</label>
            <input type="number" step="0.01" name="total_harga" id="total_harga" readonly
                value=""
                class="w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow">
                💾 Simpan
            </button>
        </div>
    </form>
</div>

    </main>
    <script>
const jenis = document.getElementById('jenis');
const hargaInput = document.getElementById('harga_input');
const beratInput = document.getElementById('berat');
const totalInput = document.getElementById('total_harga');

function hitungTotal() {
    const harga = parseFloat(hargaInput.value) || 0;
    const berat = parseFloat(beratInput.value) || 0;
    totalInput.value = harga * berat;
}

jenis.addEventListener('change', function(e){
    const selected = e.target.selectedOptions[0];
    const harga = selected.dataset.harga || 0;
    hargaInput.value = harga;
    hitungTotal();
});

beratInput.addEventListener('input', hitungTotal);
</script>
</body>
</html>
