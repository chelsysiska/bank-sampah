<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Trash2Cash</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(to bottom right, #f8fafc 0%, #e2e8f0 100%);
            overflow-x: hidden;
            transition: margin-left 0.3s ease;
        }
        .gradient-bg { background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%); }
        .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); animation: fadeInUp 0.6s ease-out; }
        .card-hover:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15); }
        @keyframes fadeInUp { from { opacity:0; transform:translateY(20px);} to {opacity:1; transform:translateY(0);} }
        .nav-link { transition: all 0.3s ease; position: relative; }
        .nav-link:hover::before {
            content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
            width: 3px; height: 20px; background: #10b981; border-radius: 0 2px 2px 0;
        }
        #mobile-backdrop { position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);
            z-index:40; opacity:0; visibility:hidden; transition: all 0.3s ease; }
        #mobile-backdrop.active { opacity:1; visibility:visible; }
        #sidebar { transition: transform 0.3s ease-in-out; }
        #sidebar.collapsed { transform: translateX(-100%) !important; width: 0; }
        .toggle-btn { transition: all 0.3s ease; }
        .toggle-btn:hover { background: rgba(16,185,129,0.1); }
        @media (prefers-color-scheme: dark) {
            body { background:#1e293b; color:#f1f5f9; }
            .bg-white { background:#334155; }
        }
        .animate-spin-slow { animation: spin 3s linear infinite; }
        @keyframes spin { from {transform:rotate(0deg);} to {transform:rotate(360deg);} }
    </style>
</head>
<body class="bg-gray-50 flex min-h-screen">
    <!-- Backdrop Mobile -->
    <div id="mobile-backdrop"></div>

    <!-- Tombol Toggle Mobile -->
    <button id="mobile-toggle" class="md:hidden fixed top-4 left-4 z-60 bg-white shadow-lg rounded-full p-3">
        <i class="fas fa-bars text-gray-600 text-lg"></i>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-white shadow-2xl min-h-screen fixed left-0 top-0 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto">
        <!-- Header Sidebar -->
        <div class="gradient-bg p-4 sm:p-6 text-center border-b border-white/30 relative">
            <button id="sidebar-close" class="absolute right-2 top-2 p-2 text-white hover:bg-white/20 rounded-full transition-all md:hidden">
                <i class="fas fa-times text-lg"></i>
            </button>
            <div class="w-12 h-12 sm:w-16 h-16 bg-white/30 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4 animate-pulse">
                <i class="fas fa-recycle text-xl sm:text-2xl text-white"></i>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-white">Trash2Cash</h1>
            <p class="text-xs sm:text-sm text-white/90">Admin Dashboard</p>
        </div>

        <!-- Menu Navigasi -->
        <nav class="mt-6 sm:mt-8 px-3 sm:px-4">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-link flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                        <i class="fas fa-chart-line w-4 sm:w-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-green-600' : 'text-gray-400 group-hover:text-green-600' }}"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.setoran.index') }}" 
                       class="nav-link flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-xl {{ request()->routeIs('admin.setoran.index') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                        <i class="fas fa-folder w-4 sm:w-5 mr-3"></i>
                        <span>Data Setoran</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.kas.riwayat') }}" 
                       class="nav-link flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-xl {{ request()->routeIs('admin.kas.riwayat') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                        <i class="fas fa-wallet w-4 sm:w-5 mr-3"></i>
                        <span>Riwayat Kas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.petugas.index') }}" 
                       class="nav-link flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-xl {{ request()->routeIs('admin.petugas.*') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                        <i class="fas fa-user-shield w-4 sm:w-5 mr-3"></i>
                        <span>Kelola Petugas</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main -->
    <main id="main-content" class="flex-1 ml-0 md:ml-64 p-4 sm:p-6 transition-all duration-300 overflow-hidden sm:overflow-auto">
        
        <!-- HEADER ADMIN DENGAN DROPDOWN PROFIL -->
        <header class="gradient-bg shadow-xl rounded-3xl p-4 sm:p-6 mb-4 sm:mb-6 flex justify-between items-center relative text-white">
            <button id="desktop-toggle" class="md:block hidden p-2 rounded-full bg-white/20 hover:bg-white/30 toggle-btn absolute left-4 top-1/2 -translate-y-1/2">
                <i id="toggle-icon" class="fas fa-bars text-white"></i>
            </button>

            <div class="ml-0 md:ml-12">
                <h2 class="text-xl sm:text-3xl font-bold flex items-center flex-wrap">
                    <i class="fas fa-tachometer-alt mr-2 sm:mr-3 animate-spin-slow"></i>
                    @yield('header_title')
                </h2>
                <p class="mt-1 text-sm sm:text-base opacity-90">@yield('header_subtitle')</p>
            </div>

            <!-- === Dropdown Profil === -->
            <div class="relative group">
                <div class="flex items-center space-x-3 cursor-pointer select-none">
                    <span class="font-semibold text-sm sm:text-base text-center sm:text-right">
                        Halo, {{ auth()->user()->name }}
                    </span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=10B981&color=fff&size=32"
                        alt="Avatar"
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full shadow-lg ring-2 ring-white/40 hover:ring-white/60 transition-all">
                    <i class="fas fa-chevron-down text-white/80 text-sm"></i>
                </div>

                <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible 
                    group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                    <div class="px-4 py-3 border-b border-gray-200 text-gray-800">
                        <p class="font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'Admin' }}</p>
                    </div>

                    <a href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                        class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </div>
        </header>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

        <!-- Alert -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-200 text-green-800 p-4 mb-4 rounded-2xl shadow-md">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-200 text-red-800 p-4 mb-4 rounded-2xl shadow-md">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">@yield('content')</div>

        <!-- Footer -->
        <footer class="footer w-full bg-green-600 text-white mt-8">
            <div class="px-6 py-4">
                <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left space-y-4 md:space-y-0">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-recycle text-xl"></i>
                        <p class="text-sm">&copy; 2025 Trash2Cash. Semua hak dilindungi.</p>
                    </div>
                    <div class="flex space-x-6 text-sm">
                        <a href="#" class="hover:underline">Kebijakan Privasi</a>
                        <a href="#" class="hover:underline">Syarat Layanan</a>
                        <a href="#" class="hover:underline">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const mobileToggle = document.getElementById('mobile-toggle');
        const desktopToggle = document.getElementById('desktop-toggle');
        const sidebarClose = document.getElementById('sidebar-close');
        const mobileBackdrop = document.getElementById('mobile-backdrop');
        const toggleIcon = document.getElementById('toggle-icon');
        let isSidebarOpen = true;
        let isMobile = window.innerWidth < 768;

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full','collapsed');
            if (isMobile) {
                mobileBackdrop.classList.add('active');
                document.body.style.overflow='hidden';
            } else {
                mainContent.classList.add('md:ml-64');
                toggleIcon.classList.replace('fa-bars','fa-chevron-left');
            }
            isSidebarOpen = true;
        }
        function closeSidebar() {
            if (isMobile) {
                sidebar.classList.add('-translate-x-full');
                mobileBackdrop.classList.remove('active');
                document.body.style.overflow='';
            } else {
                sidebar.classList.add('collapsed');
                mainContent.classList.remove('md:ml-64');
                toggleIcon.classList.replace('fa-chevron-left','fa-bars');
            }
            isSidebarOpen = false;
        }
        function toggleSidebar(){ isSidebarOpen ? closeSidebar() : openSidebar(); }
        function updateSidebarState(){
            isMobile = window.innerWidth < 768;
            isMobile ? closeSidebar() : openSidebar();
        }
        mobileToggle?.addEventListener('click',toggleSidebar);
        desktopToggle?.addEventListener('click',toggleSidebar);
        sidebarClose?.addEventListener('click',closeSidebar);
        mobileBackdrop?.addEventListener('click',()=>{if(isMobile)closeSidebar();});
        window.addEventListener('resize',updateSidebarState);
        document.addEventListener('DOMContentLoaded',updateSidebarState);
    </script>
</body>
</html>
