<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-50 via-teal-50 to-green-50 px-6 py-12 relative overflow-hidden">
        
        <!-- Animated background patterns -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-72 h-72 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 4s;"></div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl p-8 md:p-10 w-full max-w-xl relative border border-white/20">

            <!-- Decorative corner accents -->
            <div class="absolute top-0 left-0 w-16 h-16 border-t-4 border-l-4 border-green-500 rounded-tl-3xl opacity-50"></div>
            <div class="absolute bottom-0 right-0 w-16 h-16 border-b-4 border-r-4 border-teal-500 rounded-br-3xl opacity-50"></div>

            <!-- Header Section -->
            <div class="text-center mb-6 relative">
                <div class="relative inline-block mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 via-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center mx-auto shadow-2xl transform hover:scale-105 transition duration-300 relative">
                        <!-- Recycle Logo -->
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="w-9 h-9 text-white" 
                             viewBox="0 0 512 512" 
                             fill="currentColor">
                            <path d="M184.561 261.903c3.232 13.997-12.123 24.635-24.068 17.168l-40.736-25.455-50.867 81.402C55.606 356.273 70.96 384 96.012 384H148c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12H96.115c-75.334 0-121.302-83.048-81.408-146.88l50.822-81.388-40.725-25.448c-12.081-7.547-8.966-25.961 4.879-29.158l110.237-25.45c8.611-1.988 17.201 3.381 19.189 11.99l25.452 110.237zm98.561-182.915l41.289 66.076-40.74 25.457c-12.051 7.528-9 25.953 4.879 29.158l110.237 25.45c8.672 1.999 17.215-3.438 19.189-11.99l25.45-110.237c3.197-13.844-11.99-24.719-24.068-17.168l-40.687 25.424-41.263-66.082c-37.521-60.033-125.209-60.171-162.816 0l-17.963 28.766c-3.51 5.62-1.8 13.021 3.82 16.533l33.919 21.195c5.62 3.512 13.024 1.803 16.536-3.817l17.961-28.743c12.712-20.341 41.973-19.676 54.257-.022zM497.288 301.12l-27.515-44.065c-3.511-5.623-10.916-7.334-16.538-3.821l-33.861 21.159c-5.62 3.512-7.33 10.915-3.818 16.536l27.564 44.112c13.257 21.211-2.057 48.96-27.136 48.96H320V336.02c0-14.213-17.242-21.383-27.313-11.313l-80 79.981c-6.249 6.248-6.249 16.379 0 22.627l80 79.989C302.689 517.308 320 510.3 320 495.989V448h95.88c75.274 0 121.335-82.997 81.408-146.88z"/>
                        </svg>
                        <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-teal-400 rounded-2xl blur-xl opacity-50 -z-10"></div>
                    </div>
                </div>
                
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-1">
                    <span class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 bg-clip-text text-transparent">
                        Daftar Akun Baru
                    </span>
                </h1>
                <p class="text-gray-600 text-sm font-medium">Bergabung dengan Trash2Cash hari ini</p>
                <div class="w-14 h-1 bg-gradient-to-r from-green-500 to-teal-500 mx-auto mt-2 rounded-full"></div>
            </div>

            <!-- Form Section -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Nama Lengkap -->
                <div class="group">
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1 tracking-wide">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400 group-focus-within:text-green-500 transition-colors duration-300"></i>
                        </div>
                        <input id="name" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus
                               autocomplete="name"
                               class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 placeholder-gray-400 text-gray-900 bg-white/50 backdrop-blur-sm font-medium" 
                               placeholder="Masukkan nama lengkap" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm text-red-600 font-medium" />
                </div>

                <!-- NIK -->
                <div class="group">
                    <label for="nik" class="block text-sm font-bold text-gray-700 mb-1 tracking-wide">
                        NIK (Nomor Induk Kependudukan)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-id-card text-gray-400 group-focus-within:text-green-500 transition-colors duration-300"></i>
                        </div>
                        <input id="nik" 
                               type="text" 
                               name="nik" 
                               value="{{ old('nik') }}" 
                               required
                               autocomplete="nik"
                               maxlength="16"
                               pattern="[0-9]{16}"
                               class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 placeholder-gray-400 text-gray-900 bg-white/50 backdrop-blur-sm font-medium" 
                               placeholder="16 digit NIK" />
                    </div>
                    <x-input-error :messages="$errors->get('nik')" class="mt-1 text-sm text-red-600 font-medium" />
                </div>

                <!-- Email -->
                <div class="group">
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1 tracking-wide">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 group-focus-within:text-green-500 transition-colors duration-300"></i>
                        </div>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required
                               autocomplete="username"
                               class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 placeholder-gray-400 text-gray-900 bg-white/50 backdrop-blur-sm font-medium" 
                               placeholder="nama@email.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600 font-medium" />
                </div>

                <!-- Password -->
                <div class="group">
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-1 tracking-wide">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 group-focus-within:text-green-500 transition-colors duration-300"></i>
                        </div>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required
                               autocomplete="new-password"
                               class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 placeholder-gray-400 text-gray-900 bg-white/50 backdrop-blur-sm font-medium" 
                               placeholder="Min. 8 karakter" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600 font-medium" />
                </div>

                <!-- Konfirmasi Password -->
                <div class="group">
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1 tracking-wide">
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 group-focus-within:text-green-500 transition-colors duration-300"></i>
                        </div>
                        <input id="password_confirmation" 
                               type="password" 
                               name="password_confirmation" 
                               required
                               autocomplete="new-password"
                               class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300 placeholder-gray-400 text-gray-900 bg-white/50 backdrop-blur-sm font-medium" 
                               placeholder="Ulangi password" />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm text-red-600 font-medium" />
                </div>

                <!-- Terms & Conditions -->
                <div class="bg-green-50 border border-green-200 rounded-xl p-3">
                    <p class="text-xs text-gray-600 text-center leading-relaxed">
                        <i class="fas fa-info-circle text-green-600"></i>
                        Dengan mendaftar, Anda menyetujui <a href="#" class="text-green-600 font-bold hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-green-600 font-bold hover:underline">Kebijakan Privasi</a> kami
                    </p>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-3.5 rounded-xl bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 text-white font-bold text-base shadow-xl hover:shadow-2xl transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 relative overflow-hidden group">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        <i class="fas fa-user-plus"></i>
                        Daftar Sekarang
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-700 via-emerald-700 to-teal-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </button>

            </form>

            <!-- Divider -->
            <div class="relative my-5">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-3 bg-white text-gray-500 font-medium">atau</span>
                </div>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-2 font-medium">
                    Sudah punya akun?
                </p>
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-white border-2 border-green-500 text-green-600 font-bold text-sm hover:bg-green-50 transform hover:scale-[1.02] transition-all duration-300 shadow-md hover:shadow-lg">
                    <i class="fas fa-sign-in-alt"></i>
                    Masuk ke Akun
                </a>
            </div>

        </div>
    </div>

    <style>
        @keyframes pulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.5; }
        }
        
        .animate-pulse {
            animation: pulse 6s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</x-guest-layout>
