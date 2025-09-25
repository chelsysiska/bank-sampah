@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')

@section('header_title', 'Dashboard Petugas')

@section('header_subtitle', 'Selamat datang kembali! Kelola setoran sampah Anda dengan mudah dan efisien.')

@section('content')
    <div class="space-y-6 sm:space-y-8">
        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div class="bg-gradient-to-br from-green-400 via-green-500 to-green-600 text-white rounded-2xl sm:rounded-3xl shadow-2xl p-4 sm:p-6 card-hover relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 sm:w-32 sm:h-32 bg-white/10 rounded-full -mr-8 sm:-mr-16 -mt-8 sm:-mt-16"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex-1">
                        <h3 class="text-base sm:text-lg font-semibold opacity-90">Total Setoran</h3>
                        <p class="text-2xl sm:text-4xl font-bold mt-2">{{ $totalSetoran }}</p>
                        <div class="w-full bg-white/20 rounded-full h-1.5 sm:h-2 mt-2 sm:mt-3">
                            <div class="progress-bar w-75" style="width: 75%;"></div> {{-- Ganti dengan data real --}}
                        </div>
                    </div>
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/20 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-lg ml-2 sm:ml-0">
                        <i class="fas fa-boxes text-lg sm:text-2xl animate-bounce"></i>
                    </div>
                </div>
                <p class="text-xs sm:text-sm opacity-80 mt-3 sm:mt-4">Jumlah Semua Setoran</p>
            </div>
            
            <div class="bg-gradient-to-br from-blue-400 via-blue-500 to-blue-600 text-white rounded-2xl sm:rounded-3xl shadow-2xl p-4 sm:p-6 card-hover relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 sm:w-32 sm:h-32 bg-white/10 rounded-full -mr-8 sm:-mr-16 -mt-8 sm:-mt-16"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex-1">
                        <h3 class="text-base sm:text-lg font-semibold opacity-90">Total Berat (kg)</h3>
                        <p class="text-2xl sm:text-4xl font-bold mt-2">{{ number_format($totalBerat, 2) }}</p>
                        <div class="w-full bg-white/20 rounded-full h-1.5 sm:h-2 mt-2 sm:mt-3">
                            <div class="progress-bar w-60" style="width: 60%; background: linear-gradient(to right, #3b82f6, #e0f2fe);"></div>
                        </div>
                    </div>
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/20 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-lg ml-2 sm:ml-0">
                        <i class="fas fa-weight-hanging text-lg sm:text-2xl animate-pulse"></i>
                    </div>
                </div>
                <p class="text-xs sm:text-sm opacity-80 mt-3 sm:mt-4">Berat sampah terkumpul</p>
            </div>
            
            <div class="bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-600 text-white rounded-2xl sm:rounded-3xl shadow-2xl p-4 sm:p-6 card-hover relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 sm:w-32 sm:h-32 bg-white/10 rounded-full -mr-8 sm:-mr-16 -mt-8 sm:-mt-16"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex-1">
                        <h3 class="text-base sm:text-lg font-semibold opacity-90">Total Harga</h3>
                        <p class="text-2xl sm:text-4xl font-bold mt-2">Rp{{ number_format($totalHarga, 0, ',', '.') }}</p>
                        <div class="w-full bg-white/20 rounded-full h-1.5 sm:h-2 mt-2 sm:mt-3">
                            <div class="progress-bar w-80" style="width: 80%; background: linear-gradient(to right, #f59e0b, #fef3c7);"></div>
                        </div>
                    </div>
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/20 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-lg ml-2 sm:ml-0">
                        <i class="fas fa-wallet text-lg sm:text-2xl transition-transform hover:rotate-12"></i>
                    </div>
                </div>
                <p class="text-xs sm:text-sm opacity-80 mt-3 sm:mt-4">Nilai ekonomi setoran</p>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl sm:rounded-3xl shadow-xl p-4 sm:p-6 border border-white/20">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6 flex items-center">
                <i class="fas fa-clock mr-2 sm:mr-3 text-green-600"></i>
                Aktivitas Terbaru
            </h3>
            <div class="space-y-3 sm:space-y-4">
                @for($i = 0; $i < 3; $i++) {{-- Contoh loop; ganti dengan @foreach($aktivitas) untuk data real --}}
                    @php
                        $statuses = [
                            ['title' => 'Setoran berhasil ditambahkan', 'time' => 'Hari ini, ' . ($i + 1) . ' jam lalu', 'amount' => 'Rp12,000', 'color' => 'green', 'icon' => 'fa-check'],
                            ['title' => 'Setoran sedang diproses', 'time' => 'Kemarin, 1 hari lalu', 'amount' => 'Rp8,500', 'color' => 'yellow', 'icon' => 'fa-clock'],
                            ['title' => 'Sampah berhasil dikelola', 'time' => 'Kemarin, 2 hari lalu', 'amount' => 'Rp15,000', 'color' => 'blue', 'icon' => 'fa-recycle']
                        ];
                        $status = $statuses[$i];
                    @endphp
                    <div class="activity-item flex flex-col sm:flex-row items-start sm:items-center justify-between p-3 sm:p-4 bg-gradient-to-r from-gray-50 to-{{ $status['color'] }}-50 rounded-xl sm:rounded-2xl border-l-4 border-{{ $status['color'] }}-200 hover:shadow-md transition-all duration-300 hover:scale-[1.01]">
                        <div class="flex items-center relative w-full sm:w-auto mb-2 sm:mb-0">
                            <div class="activity-dot bg-{{ $status['color'] }}-500 shadow-sm flex-shrink-0"></div>
                            <div class="ml-5 sm:ml-6 flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-sm sm:text-base truncate">{{ $status['title'] }}</p>
                                <p class="text-xs sm:text-sm text-gray-500">{{ $status['time'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-end space-x-2 sm:space-x-4 w-full sm:w-auto">
                            <span class="text-{{ $status['color'] }}-600 font-bold text-base sm:text-lg">{{ $status['amount'] }}</span>
                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-{{ $status['color'] }}-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas {{ $status['icon'] }} text-{{ $status['color'] }}-500 text-xs sm:text-sm"></i>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            {{-- Tombol untuk load more (responsif) --}}
            <div class="mt-4 sm:mt-6 text-center">
                <a href="{{ route('petugas.setoran.index') }}" class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl sm:rounded-2xl font-semibold text-sm sm:text-base hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Lihat Semua Aktivitas
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Mobile sidebar toggle dengan backdrop
    const mobileToggle = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebar');
    const mobileBackdrop = document.getElementById('mobile-backdrop');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        mobileBackdrop.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent body scroll saat sidebar open
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        mobileBackdrop.classList.remove('active');
        document.body.style.overflow = '';
    }

    mobileToggle.addEventListener('click', openSidebar);

    // Close on backdrop click (outside click)
    mobileBackdrop.addEventListener('click', closeSidebar);

    // Close on nav link click (untuk mobile)
    const navLinks = sidebar.querySelectorAll('a[href]');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                closeSidebar();
            }
        });
    });

    // Auto-close sidebar on window resize (jika ke desktop)
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            closeSidebar();
            sidebar.classList.remove('-translate-x-full'); // Show sidebar di desktop
        }
    });

    // Dark mode toggle (opsional, hanya di desktop)
    const darkToggle = document.getElementById('dark-toggle');
    if (darkToggle) {
        darkToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark');
            const icon = darkToggle.querySelector('i');
            if (document.body.classList.contains('dark')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        });
    }

    // Fade-in animation untuk cards saat load (responsif)
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.card-hover');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            // Di mobile, kurangi delay untuk faster load
            if (window.innerWidth < 768) {
                card.style.animationDelay = `${index * 0.05}s`;
            }
        });

        // Tambahkan smooth scroll untuk main content
        document.querySelector('main').style.scrollBehavior = 'smooth';
    });

    // Touch-friendly: Tambahkan hover simulation untuk mobile (via touch)
    let touchStartY = 0;
    document.addEventListener('touchstart', (e) => {
        touchStartY = e.touches[0].clientY;
    });
    document.addEventListener('touchend', (e) => {
        const touchEndY = e.changedTouches[0].clientY;
        const touchDiff = touchEndY - touchStartY;
        if (Math.abs(touchDiff) < 10) { // Tap, bukan swipe
            const target = e.target.closest('.card-hover, .nav-link');
            if (target) {
                target.classList.add('active'); // Simulate hover
                setTimeout(() => target.classList.remove('active'), 200);
            }
        }
    });
</script>
@endpush