<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Petugas Dashboard') - Trash2Cash</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(to bottom right, #f8fafc 0%, #e2e8f0 100%);
            overflow-x: hidden;
            transition: margin-left 0.3s ease; /* Smooth adjust main content */
        }
        .gradient-bg { 
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%); 
        }
        .card-hover { 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            animation: fadeInUp 0.6s ease-out;
        }
        .card-hover:hover { 
            transform: translateY(-8px) scale(1.02); 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.05);
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .nav-link { 
            transition: all 0.3s ease; 
            position: relative; 
        }
        .nav-link:hover::before {
            content: ''; 
            position: absolute; 
            left: 0; 
            top: 50%; 
            transform: translateY(-50%); 
            width: 3px; 
            height: 20px; 
            background: #10b981; 
            border-radius: 0 2px 2px 0;
        }
        .activity-item { 
            position: relative; 
            padding-left: 2rem; 
        }
        .activity-item::before {
            content: ''; 
            position: absolute; 
            left: 0.5rem; 
            top: 0; 
            bottom: 0; 
            width: 2px; 
            background: linear-gradient(to bottom, #10b981, #d1fae5); 
        }
        .activity-dot {
            position: absolute; 
            left: 0.25rem; 
            top: 0.25rem; 
            width: 12px; 
            height: 12px; 
            background: #10b981; 
            border-radius: 50%; 
            z-index: 1;
        }
        .progress-bar {
            background: linear-gradient(to right, #10b981, #d1fae5);
            height: 4px;
            border-radius: 2px;
            transition: width 1s ease;
        }
        /* Mobile Backdrop */
        #mobile-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 40;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        #mobile-backdrop.active {
            opacity: 1;
            visibility: visible;
        }
        /* Sidebar States */
        #sidebar {
            transition: transform 0.3s ease-in-out;
        }
        #sidebar.collapsed {
            transform: translateX(-100%) !important; /* Full hide di desktop */
            width: 0;
        }
        #sidebar.collapsed nav ul li span {
            opacity: 0; /* Hide text saat collapsed */
        }
        /* Toggle Button Styles */
        .toggle-btn {
            transition: all 0.3s ease;
        }
        .toggle-btn:hover {
            transform: scale(1.1);
            background: rgba(16, 185, 129, 0.1);
        }
        /* Dark mode (opsional) */
        @media (prefers-color-scheme: dark) {
            body { background: #1e293b; color: #f1f5f9; }
            .bg-white { background: #334155; }
        }
        /* Slow spin for icon */
        .animate-spin-slow {
            animation: spin 3s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-50 flex min-h-screen">
    <!-- Mobile Backdrop -->
    <div id="mobile-backdrop"></div>

    <!-- Mobile Toggle Button (hanya di mobile) -->
    <button id="mobile-toggle" class="md:hidden fixed top-4 left-4 z-60 bg-white shadow-lg rounded-full p-3">
        <i class="fas fa-bars text-gray-600 text-lg"></i>
    </button>

    <aside id="sidebar" class="w-64 bg-white shadow-2xl min-h-screen fixed left-0 top-0 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto">
        <!-- Sidebar Header dengan Close Button -->
        <div class="gradient-bg p-4 sm:p-6 text-center border-b border-white/30 relative">
            <button id="sidebar-close" class="absolute right-2 top-2 p-2 text-white hover:bg-white/20 rounded-full transition-all md:hidden">
                <i class="fas fa-times text-lg"></i>
            </button>
            <div class="w-12 h-12 sm:w-16 h-16 bg-white/30 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4 animate-pulse">
                <i class="fas fa-recycle text-xl sm:text-2xl text-white"></i>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-white">Trash2Cash</h1>
            <p class="text-xs sm:text-sm text-white/90">Petugas Dashboard</p>
        </div>

        <nav class="mt-6 sm:mt-8 px-3 sm:px-4">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('petugas.dashboard') }}" 
                        class="nav-link flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 group {{ request()->routeIs('petugas.dashboard') ? 'bg-green-50 text-green-600' : '' }}">
                        <i class="fas fa-chart-line w-4 sm:w-5 mr-2 sm:mr-3 {{ request()->routeIs('petugas.dashboard') ? 'text-green-600' : 'text-gray-400 group-hover:text-green-600' }} transition-transform group-hover:scale-110"></i>
                        <span class="text-sm sm:text-base">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('petugas.setoran.create') }}" 
                        class="nav-link flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 group {{ request()->routeIs('petugas.setoran.create') ? 'bg-green-50 text-green-600' : '' }}">
                        <i class="fas fa-plus-circle w-4 sm:w-5 mr-2 sm:mr-3 {{ request()->routeIs('petugas.setoran.create') ? 'text-green-600' : 'text-gray-400 group-hover:text-green-600' }} transition-transform group-hover:scale-110"></i>
                        <span class="text-sm sm:text-base">Input Setoran</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('petugas.setoran.index') }}" 
                        class="nav-link flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 group {{ request()->routeIs('petugas.setoran.index') ? 'bg-green-50 text-green-600' : '' }}">
                        <i class="fas fa-folder w-4 sm:w-5 mr-2 sm:mr-3 {{ request()->routeIs('petugas.setoran.index') ? 'text-green-600' : 'text-gray-400 group-hover:text-green-600' }} transition-transform group-hover:scale-110"></i>
                        <span class="text-sm sm:text-base">Data Setoran</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('petugas.sampah.index') }}" 
                        class="nav-link flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 group {{ request()->routeIs('petugas.sampah.index') ? 'bg-green-50 text-green-600' : '' }}">
                        <i class="fas fa-trash-alt w-4 sm:w-5 mr-2 sm:mr-3 {{ request()->routeIs('petugas.sampah.index') ? 'text-green-600' : 'text-gray-400 group-hover:text-green-600' }} transition-transform group-hover:scale-110"></i>
                        <span class="text-sm sm:text-base">Kelola Sampah</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                        class="nav-link flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-xl text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-200 group">
                        <i class="fas fa-sign-out-alt w-4 sm:w-5 mr-2 sm:mr-3 text-gray-400 group-hover:text-red-600 transition-transform group-hover:scale-110"></i>
                        <span class="text-sm sm:text-base">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </aside>

    <main id="main-content" class="flex-1 ml-0 md:ml-64 p-4 sm:p-6 transition-all duration-300 overflow-hidden sm:overflow-auto">
        <header class="bg-white/80 backdrop-blur-sm shadow-xl rounded-3xl p-4 sm:p-6 mb-4 sm:mb-6 flex justify-between items-center relative border border-white/20">
            <!-- Desktop Toggle Button (selalu visible di md+) -->
            <button id="desktop-toggle" class="md:block hidden p-2 rounded-full bg-gray-100 hover:bg-gray-200 toggle-btn absolute left-4 top-1/2 -translate-y-1/2">
                <i id="toggle-icon" class="fas fa-bars text-gray-600"></i>
            </button>
            
            <div class="ml-0 md:ml-12"> <!-- Adjust margin untuk desktop toggle -->
                <h2 class="text-xl sm:text-3xl font-bold text-gray-800 flex items-center flex-wrap">
                    <i class="fas fa-tachometer-alt mr-2 sm:mr-3 text-green-600 animate-spin-slow"></i>
                    @yield('header_title')
                </h2>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">@yield('header_subtitle')</p>
            </div>
            <div class="flex items-center space-x-2 sm:space-x-4 w-full sm:w-auto justify-between sm:justify-end">
                <div class="flex flex-col sm:flex-row items-end sm:items-center space-y-1 sm:space-y-0 sm:space-x-4">
                    <span class="text-gray-700 font-semibold text-sm sm:text-base text-center sm:text-right">Halo, {{ auth()->user()->name }}</span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=10B981&color=fff&size=32 sm:size-40" 
                         alt="Avatar" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full shadow-lg ring-2 ring-green-200 hover:ring-green-300 transition-all">
                </div>
                <!-- Dark mode toggle (opsional, hidden di mobile jika tidak perlu) -->
                <button id="dark-toggle" class="p-2 sm:p-2 rounded-full bg-gray-100 hover:bg-gray-200 hidden sm:block">
                    <i class="fas fa-moon text-gray-600"></i>
                </button>
            </div>
        </header>

        @if (session('success'))
            <div class="bg-green-100 border border-green-200 text-green-800 p-3 sm:p-4 mb-4 sm:mb-6 rounded-2xl shadow-md animate-pulse text-sm sm:text-base" role="alert">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-200 text-red-800 p-3 sm:p-4 mb-4 sm:mb-6 rounded-2xl shadow-md animate-pulse text-sm sm:text-base" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            @yield('content')
        </div>
    </main>

    <script>
    // Elemen DOM
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const mobileToggle = document.getElementById('mobile-toggle');
    const desktopToggle = document.getElementById('desktop-toggle');
    const sidebarClose = document.getElementById('sidebar-close');
    const mobileBackdrop = document.getElementById('mobile-backdrop');
    const toggleIcon = document.getElementById('toggle-icon');

    let isSidebarOpen = false;
    let isMobile = window.innerWidth < 768;

    // Fungsi Unified Toggle (lanjutan)
    function toggleSidebar() {
        isSidebarOpen = !isSidebarOpen;
        
        if (isSidebarOpen) {
            // Buka Sidebar
            sidebar.classList.remove('-translate-x-full', 'collapsed');
            if (isMobile) {
                mobileBackdrop.classList.add('active');
                document.body.style.overflow = 'hidden';
            } else {
                mainContent.classList.remove('md:ml-0');
                mainContent.classList.add('md:ml-64');
                toggleIcon.classList.remove('fa-bars');
                toggleIcon.classList.add('fa-chevron-left');
            }
        } else {
            // Tutup Sidebar
            if (isMobile) {
                sidebar.classList.add('-translate-x-full');
                mobileBackdrop.classList.remove('active');
                document.body.style.overflow = '';
            } else {
                sidebar.classList.add('collapsed');
                mainContent.classList.remove('md:ml-64');
                mainContent.classList.add('md:ml-0');
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-bars');
            }
        }
    }

    // Fungsi untuk Update State Berdasarkan Ukuran Layar
    function updateSidebarState() {
        isMobile = window.innerWidth < 768;
        if (!isMobile && isSidebarOpen) {
            // Di desktop, pastikan sidebar expanded jika sebelumnya open
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.remove('collapsed');
            mainContent.classList.add('md:ml-64');
            toggleIcon.classList.add('fa-chevron-left');
            toggleIcon.classList.remove('fa-bars');
            mobileBackdrop.classList.remove('active');
            document.body.style.overflow = '';
        } else if (!isMobile && !isSidebarOpen) {
            // Default collapsed di desktop jika tidak open
            sidebar.classList.add('collapsed');
            mainContent.classList.add('md:ml-0');
            toggleIcon.classList.add('fa-bars');
            toggleIcon.classList.remove('fa-chevron-left');
        } else if (isMobile) {
            // Di mobile, default closed
            sidebar.classList.add('-translate-x-full');
            mobileBackdrop.classList.remove('active');
            document.body.style.overflow = '';
            isSidebarOpen = false;
        }
    }

    // Event Listeners untuk Toggle
    if (mobileToggle) {
        mobileToggle.addEventListener('click', toggleSidebar);
    }
    if (desktopToggle) {
        desktopToggle.addEventListener('click', toggleSidebar);
    }
    if (sidebarClose) {
        sidebarClose.addEventListener('click', () => {
            isSidebarOpen = false;
            toggleSidebar(); // Gunakan fungsi yang sama untuk tutup
        });
    }
    if (mobileBackdrop) {
        mobileBackdrop.addEventListener('click', () => {
            if (isMobile) {
                isSidebarOpen = false;
                toggleSidebar();
            }
        });
    }

    // Close on Nav Link Click (khusus mobile)
    const navLinks = sidebar.querySelectorAll('a[href]');
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            if (isMobile) {
                isSidebarOpen = false;
                toggleSidebar();
            }
        });
    });

    // Handle Window Resize
    window.addEventListener('resize', () => {
        updateSidebarState();
    });

    // Handle ESC Key untuk Close Sidebar (khusus mobile)
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isMobile && isSidebarOpen) {
            isSidebarOpen = false;
            toggleSidebar();
        }
    });

    // Dark Mode Toggle (opsional)
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

    // Fade-in Animation untuk Cards Saat Load (responsif)
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

        // Inisialisasi state sidebar saat load
        updateSidebarState();
    });

    // Touch-friendly: Simulate Hover untuk Mobile (tap effect)
    let touchStartY = 0;
    document.addEventListener('touchstart', (e) => {
        touchStartY = e.touches[0].clientY;
    });
    document.addEventListener('touchend', (e) => {
        const touchEndY = e.changedTouches[0].clientY;
        const touchDiff = touchEndY - touchStartY;
        if (Math.abs(touchDiff) < 10) { // Tap, bukan swipe
            const target = e.target.closest('.card-hover, .nav-link, .toggle-btn');
            if (target) {
                target.classList.add('ring-2', 'ring-green-300'); // Simulate hover ring
                setTimeout(() => target.classList.remove('ring-2', 'ring-green-300'), 200);
            }
        }
    });
</script>

    @stack('scripts')
</body>
</html>