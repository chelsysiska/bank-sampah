<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Trash2Cash</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #3b82f6 0%, #10b981 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="bg-gray-50 flex min-h-screen">

    <aside class="w-64 bg-white shadow-xl min-h-screen fixed left-0 top-0 z-50">
        <div class="gradient-bg p-6 text-center border-b border-white/20">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-recycle text-2xl text-white"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">Trash2Cash</h1>
            <p class="text-sm text-white/80">Admin Dashboard</p>
        </div>
        <nav class="mt-8 px-4">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-600' : '' }}">
                        <i class="fas fa-chart-line w-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-green-600' : 'text-gray-400 group-hover:text-green-600' }}"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.setoran.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 group {{ request()->routeIs('admin.setoran.index') ? 'bg-green-50 text-green-600' : '' }}">
                        <i class="fas fa-folder w-5 mr-3 {{ request()->routeIs('admin.setoran.index') ? 'text-green-600' : 'text-gray-400 group-hover:text-green-600' }}"></i>
                        Data Setoran
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.nasabah.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-600 transition-all duration-200 group {{ request()->routeIs('admin.nasabah.index') ? 'bg-green-50 text-green-600' : '' }}">
                        <i class="fas fa-users w-5 mr-3 {{ request()->routeIs('admin.nasabah.index') ? 'text-green-600' : 'text-gray-400 group-hover:text-green-600' }}"></i>
                        Kelola Nasabah
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

    <main class="flex-1 ml-0 md:ml-64 p-4 md:p-6 transition-all duration-300">
        <header class="bg-white shadow-lg rounded-2xl p-6 mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-tachometer-alt mr-3 text-blue-600"></i>
                    @yield('header_title')
                </h2>
                <p class="text-gray-600 mt-1">@yield('header_subtitle')</p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700 font-medium">Halo, {{ auth()->user()->name }}</span>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3B82F6&color=fff&size=40" 
                     alt="Avatar" class="w-10 h-10 rounded-full shadow-md">
            </div>
        </header>
        
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>