<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Bank Sampah</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .overlay { transition: opacity 0.3s ease-in-out; }
        .gradient-green { background: linear-gradient(135deg, #10b981, #059669); }
        body {
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(5, 150, 105, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(34, 197, 94, 0.05) 0%, transparent 50%),
                linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            position: relative;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310b981' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"),
                url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23059669' fill-opacity='0.02'%3E%3Cpath d='M20 0v40M0 20h40'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 60px 60px, 40px 40px;
            background-position: 0 0, 20px 20px;
            z-index: -2;
            animation: float 20s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .header-glow {
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.15), 0 0 30px rgba(16, 185, 129, 0.1);
        }
        .nav-item {
            position: relative;
            overflow: hidden;
        }
        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.1), transparent);
            transition: left 0.5s;
        }
        .nav-item:hover::before {
            left: 100%;
        }
        .user-dropdown {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1), 0 0 20px rgba(16, 185, 129, 0.05);
        }
        .icon-spin {
            animation: spin 3s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .bounce-in {
            animation: bounceIn 0.8s ease-out;
        }
        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
        .pulse-glow {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        }
        .floating-icon {
            position: absolute;
            font-size: 1.5rem;
            color: rgba(16, 185, 129, 0.1);
            animation: float-icon 6s ease-in-out infinite;
            pointer-events: none;
            z-index: -1;
        }
        .floating-icon:nth-child(1) { top: 10%; left: 5%; animation-delay: 0s; }
        .floating-icon:nth-child(2) { top: 20%; right: 10%; animation-delay: 1s; font-size: 2rem; }
        .floating-icon:nth-child(3) { bottom: 20%; left: 10%; animation-delay: 2s; }
        .floating-icon:nth-child(4) { top: 60%; right: 5%; animation-delay: 3s; font-size: 1.2rem; }
        .floating-icon:nth-child(5) { bottom: 10%; left: 20%; animation-delay: 4s; }
        @keyframes float-icon {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 0.6; }
        }
        .wavy-line {
            position: absolute;
            height: 2px;
            background: linear-gradient(90deg, transparent, #10b981, transparent);
            animation: wave 3s ease-in-out infinite;
        }
        @keyframes wave {
            0%, 100% { opacity: 0.5; transform: scaleX(0); }
            50% { opacity: 1; transform: scaleX(1); }
        }
        .leaf-pattern {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath d='M50 20 Q60 30 50 40 Q40 30 50 20' fill='%2310b981' fill-opacity='0.02'/%3E%3Cpath d='M20 50 Q30 60 20 70 Q10 60 20 50' fill='%23059669' fill-opacity='0.03'/%3E%3C/svg%3E");
            background-size: 100px 100px;
            animation: drift 15s linear infinite;
        }
        @keyframes drift {
            from { background-position: 0 0; }
            to { background-position: 100px 100px; }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased leaf-pattern">

    <div id="main-content" class="flex flex-col min-h-screen relative">
        <!-- Floating Icons Dekoratif -->
        <i class="fas fa-leaf floating-icon"></i>
        <i class="fas fa-recycle floating-icon"></i>
        <i class="fas fa-leaf floating-icon"></i>
        <i class="fas fa-recycle floating-icon"></i>
        <i class="fas fa-leaf floating-icon"></i>

        <header class="bg-white header-glow p-4 flex justify-between items-center z-30 relative bounce-in pulse-glow">
            <div class="flex items-center">
                <i class="fas fa-recycle icon-spin text-green-600 text-3xl mr-2"></i>
                <span class="text-2xl font-bold text-gray-800 bg-gradient-to-r from-green-600 via-emerald-600 to-green-800 bg-clip-text text-transparent">TRASH2CASH</span>
                <span class="ml-2 text-sm bg-green-100 text-green-700 px-2 py-1 rounded-full animate-pulse">Eco-Friendly</span>
            </div>

            <div class="flex items-center space-x-4 relative">
                <nav class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('nasabah.dashboard') }}"
                       class="nav-item py-2 px-4 rounded-xl text-gray-600 hover:bg-gradient-to-r hover:from-green-100 hover:to-emerald-100 hover:text-green-600 transition-all duration-300 transform hover:scale-110 hover:rotate-1 shadow-md border border-green-200 hover:border-green-400 flex items-center"
                       title="Dashboard Utama">
                       <i class="fas fa-tachometer-alt mr-2 text-green-500"></i>Dashboard
                    </a>
                    <a href="{{ route('nasabah.riwayat') }}"
                       class="nav-item py-2 px-4 rounded-xl text-gray-600 hover:bg-gradient-to-r hover:from-green-100 hover:to-emerald-100 hover:text-green-600 transition-all duration-300 transform hover:scale-110 hover:rotate-1 shadow-md border border-green-200 hover:border-green-400 flex items-center"
                       title="Riwayat Transaksi">
                       <i class="fas fa-history mr-2 text-green-500"></i>Riwayat Setoran
                    </a>
                </nav>

                <div class="relative inline-block text-left" x-data="{ open: false }" @click.outside="open = false">
                    <div>
                        <button type="button" @click="open = !open"
                            class="inline-flex justify-center items-center w-full rounded-full shadow-lg px-4 py-2 bg-gradient-to-r from-green-50 to-emerald-50 text-sm font-semibold text-gray-700 hover:from-green-100 hover:to-emerald-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-green-500 transition-all duration-200 transform hover:scale-105 hover:shadow-xl border border-green-200"
                            id="menu-button" aria-expanded="true" aria-haspopup="true">
                            <i class="fas fa-user-circle text-2xl text-gray-500 hover:text-green-600 mr-2"></i>
                            <span class="hidden md:block font-medium">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down -mr-1 ml-2 h-5 w-5 transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                        </button>
                    </div>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="origin-top-right absolute right-0 mt-2 w-64 rounded-2xl user-dropdown bg-white ring-1 ring-black ring-opacity-5 focus:outline-none py-2"
                         role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="px-2" role="none">
                            <div class="text-xs text-gray-500 px-4 py-1 border-b border-gray-100">Selamat datang!</div>
                            <form method="POST" action="{{ route('logout') }}" class="block" role="menuitem" tabindex="-1">
                                @csrf
                                <button type="submit" class="text-red-700 w-full text-left block px-4 py-3 text-sm hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 transition-all duration-200 transform hover:scale-105 flex items-center">
                                    <i class="fas fa-sign-out-alt mr-3 text-red-500"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-6 relative">
            <!-- Elemen Dekoratif Tambahan -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-400 via-emerald-500 to-green-600 opacity-80 wavy-line"></div>
            <div class="absolute bottom-0 right-0 w-48 h-48 bg-green-200 rounded-full opacity-20 -z-10 transform rotate-12"></div>
            <div class="absolute top-1/4 left-0 w-32 h-32 bg-emerald-200 rounded-full opacity-15 -z-10 transform -translate-y-1/2 rotate-45"></div>
            <div class="absolute top-3/4 right-0 w-24 h-24 bg-green-300 rounded-full opacity-10 -z-10 transform translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-1/4 left-1/2 w-20 h-20 bg-emerald-100 rounded-full opacity-20 -z-10 transform -translate-x-1/2"></div>
            <!-- Wavy lines tambahan untuk kedalaman -->
            <div class="absolute top-20 left-0 w-1/3 h-1 bg-gradient-to-r from-transparent via-green-400 to-transparent opacity-40 wavy-line" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-32 right-0 w-1/4 h-1 bg-gradient-to-r from-transparent via-emerald-500 to-transparent opacity-30 wavy-line" style="animation-delay: 2s;"></div>
            @yield('content')
        </main>
    </div>

    <script>
        // Tambahan JS sederhana untuk efek ramai (particles-like) tanpa library eksternal
        function createParticle() {
            const particle = document.createElement('div');
            particle.innerHTML = '<i class="fas fa-leaf text-green-400 text-xs"></i>';
            particle.className = 'absolute pointer-events-none animate-float-particle z-0';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animationDuration = (Math.random() * 3 + 2) + 's';
            particle.style.opacity = Math.random() * 0.5 + 0.2;
            document.getElementById('main-content').appendChild(particle);
            setTimeout(() => particle.remove(), 5000);
        }
        function animateParticles() {
            setInterval(createParticle, 3000);
        }
        // Mulai animasi setelah load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', animateParticles);
        } else {
            animateParticles();
        }
        // CSS untuk particle (inline untuk menghindari error)
        const style = document.createElement('style');
        style.textContent = `
            @keyframes float-particle {
                0% { transform: translateY(0) rotate(0deg) scale(1); opacity: 1; }
                100% { transform: translateY(-100vh) rotate(360deg) scale(0); opacity: 0; }
            }
            .animate-float-particle { animation: float-particle linear infinite; }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>