<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nasabah Dashboard') - Trash2Cash</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        
        body { 
            font-family: 'Inter', sans-serif; 
            overflow-x: hidden;
            transition: margin-left 0.3s ease-in-out;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #d1fae5 100%);
            min-height: 100vh;
        }
        
        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            background: 
                radial-gradient(circle at 20% 80%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(5, 150, 105, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(34, 197, 94, 0.05) 0%, transparent 50%);
            animation: bgFloat 20s ease-in-out infinite;
        }
        
        @keyframes bgFloat {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -20px) scale(1.02); }
            66% { transform: translate(-20px, 15px) scale(0.98); }
        }
        
        .gradient-bg { 
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .card-hover { 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .card-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s;
        }
        
        .card-hover:hover::before {
            left: 100%;
        }
        
        .card-hover:hover { 
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .sidebar-transition {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .nav-item {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #10b981, #34d399);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .nav-item.active::before,
        .nav-item:hover::before {
            transform: scaleY(1);
        }
        
        .nav-item:hover {
            transform: translateX(8px);
        }
        
        /* Floating animation for decorative elements */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Pulse animation for important elements */
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.4); }
            50% { box-shadow: 0 0 40px rgba(16, 185, 129, 0.8); }
        }
        
        .pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }
        
        /* Text glow effect */
        .text-glow {
            text-shadow: 0 0 20px rgba(16, 185, 129, 0.5);
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
                transition: all 0.4s ease-in-out;
            }
            
            .main-content.sidebar-closed {
                margin-left: 0;
                width: 100%;
            }
            
            .toggle-mobile {
                display: none;
            }
            
            .toggle-desktop {
                display: flex;
            }
        }
        
        .toggle-btn {
            transition: all 0.3s ease;
        }
        
        .toggle-btn:hover {
            transform: scale(1.1) rotate(5deg);
            background: rgba(16, 185, 129, 0.1);
        }
        
        .toggle-icon {
            transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        .sidebar-closed .toggle-icon {
            transform: rotate(180deg);
        }
        
        /* Staggered animation for cards */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .animate-stagger > * {
            animation: slideInUp 0.6s ease-out forwards;
            opacity: 0;
        }
        
        .animate-stagger > *:nth-child(1) { animation-delay: 0.1s; }
        .animate-stagger > *:nth-child(2) { animation-delay: 0.2s; }
        .animate-stagger > *:nth-child(3) { animation-delay: 0.3s; }
        .animate-stagger > *:nth-child(4) { animation-delay: 0.4s; }
        
        /* Eco particles */
        .eco-particle {
            position: absolute;
            pointer-events: none;
            z-index: -1;
            opacity: 0.6;
        }
    </style>
</head>
<body class="min-h-screen relative">
    
    <!-- Animated Background -->
    <div class="animated-bg"></div>
    
    <!-- Eco Particles -->
    <div id="eco-particles"></div>
    
    <!-- Mobile Backdrop -->
    <div id="backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300 backdrop-blur-sm"></div>
    
    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-0 h-full bg-white/95 backdrop-blur-lg shadow-2xl z-50 sidebar-transition overflow-hidden border-r border-green-200/30">
        <!-- Header Section -->
        <div class="gradient-bg p-6 relative overflow-hidden border-b border-white/20">
            <!-- Tombol Toggle untuk Desktop -->
            <button id="toggle-desktop-btn" class="toggle-desktop absolute top-4 right-4 text-white hover:text-gray-200 transition-colors toggle-btn floating">
                <i class="fas fa-chevron-left text-lg toggle-icon"></i>
            </button>
            
            <!-- Tombol Close untuk Mobile -->
            <button id="close-sidebar" class="toggle-mobile absolute top-4 right-4 text-white hover:text-gray-200 transition-colors floating">
                <i class="fas fa-times text-xl"></i>
            </button>
            
            <div class="relative z-10 pr-8">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4 backdrop-blur-sm border border-white/30 floating">
                    <i class="fas fa-recycle text-2xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-white text-glow text-center">Trash2Cash</h1>
                <p class="text-sm text-white/80 text-center mt-2">Eco-Friendly Banking</p>
            </div>
            
            <!-- Decorative elements -->
            <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-white/10 rounded-full"></div>
            <div class="absolute -top-4 -left-4 w-16 h-16 bg-white/5 rounded-full"></div>
        </div>
        
        <!-- Navigation -->
        <nav class="mt-8 px-4 h-[calc(100vh-12rem)] overflow-y-auto">
            <ul class="space-y-3">
                <li>
                    <a href="{{ route('nasabah.dashboard') }}" 
                       class="nav-item flex items-center px-4 py-4 rounded-2xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-300 group {{ request()->routeIs('nasabah.dashboard') ? 'bg-green-50 text-green-600 active pulse-glow' : '' }}">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center mr-4 transition-all duration-300 group-hover:scale-110">
                            <i class="fas fa-tachometer-alt text-lg {{ request()->routeIs('nasabah.dashboard') ? 'text-green-600' : 'text-green-400 group-hover:text-green-600' }}"></i>
                        </div>
                        <span class="font-semibold text-lg">Dashboard</span>
                        <i class="fas fa-chevron-right ml-auto text-gray-300 group-hover:text-green-400 transition-transform group-hover:translate-x-1"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('nasabah.riwayat') }}" 
                       class="nav-item flex items-center px-4 py-4 rounded-2xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-300 group {{ request()->routeIs('nasabah.riwayat') ? 'bg-green-50 text-green-600 active pulse-glow' : '' }}">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center mr-4 transition-all duration-300 group-hover:scale-110">
                            <i class="fas fa-history text-lg {{ request()->routeIs('nasabah.riwayat') ? 'text-blue-600' : 'text-blue-400 group-hover:text-blue-600' }}"></i>
                        </div>
                        <span class="font-semibold text-lg">Riwayat Setoran</span>
                        <i class="fas fa-chevron-right ml-auto text-gray-300 group-hover:text-blue-400 transition-transform group-hover:translate-x-1"></i>
                    </a>
                </li>
                <li class="mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="nav-item flex items-center px-4 py-4 rounded-2xl text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-100 to-red-200 rounded-xl flex items-center justify-center mr-4 transition-all duration-300 group-hover:scale-110">
                            <i class="fas fa-sign-out-alt text-lg text-red-400 group-hover:text-red-600"></i>
                        </div>
                        <span class="font-semibold text-lg">Logout</span>
                        <i class="fas fa-chevron-right ml-auto text-gray-300 group-hover:text-red-400 transition-transform group-hover:translate-x-1"></i>
                    </a>
                </li>
            </ul>
        </nav>
        
        <!-- Footer -->
        <div class="absolute bottom-0 left-0 right-0 p-4 text-center text-gray-500 text-sm border-t border-gray-100">
            <p>♻️ Making the World Greener</p>
        </div>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </aside>

    <!-- Main Content -->
    <main id="main-content" class="main-content min-h-screen p-4 md:p-6 transition-all duration-300">
        <!-- Top Header -->
        <header class="glass-effect rounded-3xl p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0 relative overflow-hidden">
            <!-- Background decoration -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-200/20 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-blue-200/20 rounded-full translate-y-12 -translate-x-12"></div>
            
            <div class="flex items-center space-x-4 w-full md:w-auto relative z-10">
                <!-- Tombol Toggle Sidebar untuk Mobile -->
                <button id="toggle-mobile-btn" class="toggle-mobile p-3 rounded-xl bg-white/80 shadow-lg hover:shadow-xl transition-all duration-300 toggle-btn floating">
                    <i class="fas fa-bars text-green-600 text-lg"></i>
                </button>
                
                <!-- Tombol Toggle Sidebar untuk Desktop -->
                <button id="toggle-desktop-btn-header" class="toggle-desktop p-3 rounded-xl bg-white/80 shadow-lg hover:shadow-xl transition-all duration-300 toggle-btn mr-4 floating">
                    <i class="fas fa-bars text-green-600 text-lg"></i>
                </button>
                
                <div class="min-w-0 flex-1 md:flex-initial">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center flex-wrap">
                        <i class="fas fa-leaf text-green-500 mr-3 flex-shrink-0 floating" style="animation-delay: 0.5s;"></i>
                        <span class="break-words bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">@yield('header_title', 'Dashboard Nasabah')</span>
                    </h2>
                    <p class="text-gray-600 mt-2 text-base">@yield('header_subtitle', 'Selamat datang di dashboard nasabah')</p>
                </div>
            </div>
            <div class="flex items-center space-x-4 w-full md:w-auto justify-end relative z-10">
                <div class="text-right">
                    <p class="text-gray-700 font-semibold text-lg">Halo, <span class="text-green-600">{{ auth()->user()->name }}</span></p>
                    <p class="text-gray-500 text-sm flex items-center justify-end">
                        <i class="fas fa-shield-alt text-green-400 mr-1"></i>
                        Akun Terverifikasi
                    </p>
                </div>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=10b981&color=fff&size=64&bold=true&font-size=0.8" 
                     alt="Avatar" class="w-12 h-12 md:w-14 md:h-14 rounded-2xl shadow-lg border-2 border-white floating">
            </div>
        </header>
        
        <!-- Alert Messages -->
        @if (session('success'))
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-4 mb-6 rounded-2xl shadow-lg animate-stagger" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-2xl mr-3"></i>
                    <span class="text-base font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-gradient-to-r from-red-500 to-pink-600 text-white p-4 mb-6 rounded-2xl shadow-lg animate-stagger" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-2xl mr-3"></i>
                    <span class="text-base font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Content Area -->
        <div class="animate-stagger">
            @yield('content')
        </div>
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
            let isSidebarOpen = window.innerWidth >= 769;

            function openSidebar() {
                if (window.innerWidth < 768) {
                    sidebar.classList.add('sidebar-open');
                    backdrop.classList.add('backdrop-open');
                    body.classList.add('sidebar-open');
                } else {
                    sidebar.classList.remove('sidebar-closed');
                    mainContent.classList.remove('sidebar-closed');
                }
                isSidebarOpen = true;
                updateToggleIcons();
            }

            function closeSidebar() {
                if (window.innerWidth < 768) {
                    sidebar.classList.remove('sidebar-open');
                    backdrop.classList.remove('backdrop-open');
                    body.classList.remove('sidebar-open');
                } else {
                    sidebar.classList.add('sidebar-closed');
                    mainContent.classList.add('sidebar-closed');
                }
                isSidebarOpen = false;
                updateToggleIcons();
            }

            function toggleSidebar() {
                if (isSidebarOpen) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            }

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

            // Event listeners
            if (toggleMobileBtn) toggleMobileBtn.addEventListener('click', toggleSidebar);
            if (toggleDesktopBtn) toggleDesktopBtn.addEventListener('click', toggleSidebar);
            if (toggleDesktopBtnHeader) toggleDesktopBtnHeader.addEventListener('click', toggleSidebar);
            if (closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);

            // Close sidebar ketika klik link navigasi (mobile)
            document.querySelectorAll('#sidebar a').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (window.innerWidth < 768 && !this.href.includes('logout')) {
                        closeSidebar();
                    }
                });
            });

            // Eco particles animation
            function createEcoParticles() {
                const particlesContainer = document.getElementById('eco-particles');
                const particles = ['♻️', '🌱', '🌍', '💧', '🌿', '🍃'];
                
                for (let i = 0; i < 15; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'eco-particle';
                    particle.innerHTML = particles[Math.floor(Math.random() * particles.length)];
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.top = Math.random() * 100 + '%';
                    particle.style.fontSize = (Math.random() * 20 + 10) + 'px';
                    particle.style.opacity = Math.random() * 0.3 + 0.1;
                    particle.style.animation = `float ${Math.random() * 10 + 10}s ease-in-out infinite`;
                    particle.style.animationDelay = Math.random() * 5 + 's';
                    particlesContainer.appendChild(particle);
                }
            }

            // Initialize
            if (window.innerWidth >= 768) {
                openSidebar();
            } else {
                closeSidebar();
            }

            createEcoParticles();

            // Add interactive effects to cards
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px) scale(0.95)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0) scale(1)';
                }, index * 150);
            });

            // Add parallax effect to background
            document.addEventListener('mousemove', function(e) {
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;
                
                document.querySelector('.animated-bg').style.transform = 
                    `translate(${x * 20}px, ${y * 20}px) scale(1.02)`;
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>