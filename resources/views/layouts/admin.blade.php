<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Trash2Cash</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { 
            font-family: 'Inter', sans-serif; 
            overflow-x: hidden;
            transition: margin-left 0.3s ease-in-out;
        }
        
        .gradient-bg { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card-hover { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        }
        
        .card-hover:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); 
        }
        
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .backdrop {
            backdrop-filter: blur(4px);
            transition: opacity 0.3s ease;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .nav-item {
            position: relative;
            overflow: hidden;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .nav-item.active::before,
        .nav-item:hover::before {
            transform: scaleY(1);
        }
        
        /* Mobile Styles */
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            
            #sidebar.sidebar-open {
                transform: translateX(0);
            }
            
            #backdrop {
                display: none;
                opacity: 0;
            }
            
            #backdrop.backdrop-open {
                display: block;
                opacity: 1;
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            body.sidebar-open {
                overflow: hidden;
            }
            
            /* Tombol toggle untuk mobile */
            .toggle-mobile {
                display: flex;
            }
            
            .toggle-desktop {
                display: none;
            }
        }
        
        /* Desktop Styles */
        @media (min-width: 769px) {
            #sidebar {
                transform: translateX(0);
                width: 16rem;
            }
            
            #sidebar.sidebar-closed {
                transform: translateX(-100%);
                width: 0;
            }
            
            #backdrop {
                display: none !important;
            }
            
            .main-content {
                margin-left: 16rem;
                width: calc(100% - 16rem);
                transition: all 0.3s ease-in-out;
            }
            
            .main-content.sidebar-closed {
                margin-left: 0;
                width: 100%;
            }
            
            /* Tombol toggle untuk desktop */
            .toggle-mobile {
                display: none;
            }
            
            .toggle-desktop {
                display: flex;
            }
            
            body.sidebar-open {
                overflow: auto;
            }
        }
        
        /* Style untuk tombol toggle */
        .toggle-btn {
            transition: all 0.3s ease;
        }
        
        .toggle-btn:hover {
            transform: scale(1.1);
            background: rgba(59, 130, 246, 0.1);
        }
        
        /* Animasi icon toggle */
        .toggle-icon {
            transition: transform 0.3s ease;
        }
        
        .sidebar-closed .toggle-icon {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    
    <!-- Mobile Backdrop -->
    <div id="backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"></div>
    
    <!-- Sidebar dengan Tombol Toggle -->
    <aside id="sidebar" class="fixed left-0 top-0 h-full bg-white shadow-2xl z-50 sidebar-transition overflow-hidden">
        <!-- Header Section dengan Tombol Toggle dan Close -->
        <div class="gradient-bg p-6 relative overflow-hidden border-b border-white/20">
            <!-- Tombol Toggle untuk Desktop -->
            <button id="toggle-desktop-btn" class="toggle-desktop absolute top-4 right-4 text-white hover:text-gray-200 transition-colors toggle-btn">
                <i class="fas fa-chevron-left text-lg toggle-icon"></i>
            </button>
            
            <!-- Tombol Close untuk Mobile -->
            <button id="close-sidebar" class="toggle-mobile absolute top-4 right-4 text-white hover:text-gray-200 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
            
            <div class="relative z-10 pr-8">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm border border-white/30">
                    <i class="fas fa-recycle text-2xl text-white drop-shadow-lg"></i>
                </div>
                <h1 class="text-2xl font-bold text-white drop-shadow-lg">Trash2Cash</h1>
                <p class="text-sm text-white/80">Admin Dashboard</p>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="mt-8 px-4 h-[calc(100vh-12rem)] overflow-y-auto">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-item flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-600 active' : '' }}">
                        <i class="fas fa-chart-line w-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-green-600' : 'text-gray-400 group-hover:text-green-600' }}"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.setoran.index') }}" 
                       class="nav-item flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 group {{ request()->routeIs('admin.setoran.index') ? 'bg-green-50 text-green-600 active' : '' }}">
                        <i class="fas fa-folder w-5 mr-3 {{ request()->routeIs('admin.setoran.index') ? 'text-green-600' : 'text-gray-400 group-hover:text-green-600' }}"></i>
                        <span class="font-medium">Data Setoran</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="nav-item flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-200 group">
                        <i class="fas fa-sign-out-alt w-5 mr-3 text-gray-400 group-hover:text-red-600"></i>
                        <span class="font-medium">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </aside>

    <!-- Main Content dengan Tombol Toggle Mobile -->
    <main id="main-content" class="main-content min-h-screen p-4 md:p-6 transition-all duration-300">
        <!-- Top Header -->
        <header class="glass-effect shadow-lg rounded-2xl p-4 md:p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4 w-full md:w-auto">
                <!-- Tombol Toggle Sidebar untuk Mobile -->
                <button id="toggle-mobile-btn" class="toggle-mobile p-3 rounded-lg bg-white shadow-md hover:shadow-lg transition-shadow duration-200 toggle-btn">
                    <i class="fas fa-bars text-gray-600 text-lg"></i>
                </button>
                
                <!-- Tombol Toggle Sidebar untuk Desktop -->
                <button id="toggle-desktop-btn-header" class="toggle-desktop p-3 rounded-lg bg-white shadow-md hover:shadow-lg transition-shadow duration-200 toggle-btn mr-4">
                    <i class="fas fa-bars text-gray-600 text-lg"></i>
                </button>
                
                <div class="min-w-0 flex-1 md:flex-initial">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 flex items-center flex-wrap">
                        <i class="fas fa-tachometer-alt mr-2 md:mr-3 text-blue-600 flex-shrink-0"></i>
                        <span class="break-words">@yield('header_title')</span>
                    </h2>
                    <p class="text-gray-600 mt-1 text-sm md:text-base">@yield('header_subtitle')</p>
                </div>
            </div>
            <div class="flex items-center space-x-3 md:space-x-4 w-full md:w-auto justify-end">
                <span class="text-gray-700 font-medium text-sm md:text-base truncate max-w-32 md:max-w-none">Halo, {{ auth()->user()->name }}</span>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3B82F6&color=fff&size=40" 
                     alt="Avatar" class="w-8 h-8 md:w-10 md:h-10 rounded-full shadow-md flex-shrink-0">
            </div>
        </header>
        
        <!-- Alert Messages -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-r-lg shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span class="text-sm md:text-base">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-r-lg shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span class="text-sm md:text-base">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Content Area -->
        @yield('content')
    </main>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('backdrop');
            const mainContent = document.getElementById('main-content');
            const body = document.body;

            // Tombol-tombol toggle
            const toggleMobileBtn = document.getElementById('toggle-mobile-btn');
            const toggleDesktopBtn = document.getElementById('toggle-desktop-btn');
            const toggleDesktopBtnHeader = document.getElementById('toggle-desktop-btn-header');
            const closeSidebarBtn = document.getElementById('close-sidebar');

            // State sidebar
            let isSidebarOpen = window.innerWidth >= 769; // Desktop default open

            // Function to open sidebar
            function openSidebar() {
                if (window.innerWidth < 768) {
                    // Mobile behavior
                    sidebar.classList.add('sidebar-open');
                    backdrop.classList.add('backdrop-open');
                    body.classList.add('sidebar-open');
                } else {
                    // Desktop behavior
                    sidebar.classList.remove('sidebar-closed');
                    mainContent.classList.remove('sidebar-closed');
                }
                isSidebarOpen = true;
                updateToggleIcons();
            }

            // Function to close sidebar
            function closeSidebar() {
                if (window.innerWidth < 768) {
                    // Mobile behavior
                    sidebar.classList.remove('sidebar-open');
                    backdrop.classList.remove('backdrop-open');
                    body.classList.remove('sidebar-open');
                } else {
                    // Desktop behavior
                    sidebar.classList.add('sidebar-closed');
                    mainContent.classList.add('sidebar-closed');
                }
                isSidebarOpen = false;
                updateToggleIcons();
            }

            // Function to toggle sidebar
            function toggleSidebar() {
                if (isSidebarOpen) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            }

            // Update icon toggle berdasarkan state
            function updateToggleIcons() {
                const icons = document.querySelectorAll('.toggle-icon');
                icons.forEach(icon => {
                    if (isSidebarOpen) {
                        icon.classList.remove('fa-chevron-right');
                        icon.classList.add('fa-chevron-left');
                    } else {
                        icon.classList.remove('fa-chevron-left');
                        icon.classList.add('fa-chevron-right');
                    }
                });
            }

            // Event listeners untuk semua tombol toggle
            toggleMobileBtn.addEventListener('click', toggleSidebar);
            toggleDesktopBtn.addEventListener('click', toggleSidebar);
            toggleDesktopBtnHeader.addEventListener('click', toggleSidebar);
            closeSidebarBtn.addEventListener('click', closeSidebar);
            backdrop.addEventListener('click', closeSidebar);

            // Close sidebar ketika klik link navigasi (mobile)
            document.querySelectorAll('#sidebar a').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (window.innerWidth < 768) {
                        if (!this.href.includes('logout')) {
                            closeSidebar();
                        }
                    }
                });
            });

            // Close sidebar dengan Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (window.innerWidth < 768) {
                        closeSidebar();
                    }
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    // Desktop - reset backdrop dan body class
                    backdrop.classList.remove('backdrop-open');
                    body.classList.remove('sidebar-open');
                    
                    // Jika sebelumnya di mobile tertutup, buka di desktop
                    if (!isSidebarOpen) {
                        openSidebar();
                    }
                } else {
                    // Mobile - pastikan state correct
                    if (isSidebarOpen) {
                        sidebar.classList.add('sidebar-open');
                        backdrop.classList.add('backdrop-open');
                    } else {
                        sidebar.classList.remove('sidebar-open');
                        backdrop.classList.remove('backdrop-open');
                    }
                }
            });

            // Initialize berdasarkan screen size
            if (window.innerWidth >= 768) {
                openSidebar(); // Desktop default open
            } else {
                closeSidebar(); // Mobile default closed
            }

            // Card animations
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>