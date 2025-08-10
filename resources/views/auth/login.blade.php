@extends('layout.auth')

@section('title', 'Login - Sistem Kepegawaian')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <!-- Background Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white rounded-full mix-blend-multiply filter blur-xl opacity-30 floating-animation"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-40 floating-animation" style="animation-delay: 2s;"></div>
        <div class="absolute top-40 left-40 w-60 h-60 bg-white rounded-full mix-blend-multiply filter blur-xl opacity-20 floating-animation" style="animation-delay: 4s;"></div>
    </div>

    <!-- Login Container -->
    <div class="relative w-full max-w-md">
        <!-- Main Login Card -->
        <div class="glass-effect rounded-2xl shadow-2xl p-8 slide-in">
            <!-- Logo and Title -->
            <div class="text-center mb-8">
                <div class="mx-auto w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas fa-users text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Sistem Kepegawaian</h1>
                <p class="text-gray-600">Silakan masuk ke akun Anda</p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Username Field -->
                <div class="relative">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-blue-600"></i>Username
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            required
                            class="w-full px-4 py-3 pl-12 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan username Anda"
                            value="{{ old('username') }}"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-blue-500"></i>
                        </div>
                    </div>
                    @error('username')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-blue-600"></i>Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="w-full px-4 py-3 pl-12 pr-12 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan password Anda"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-blue-500"></i>
                        </div>
                        <button 
                            type="button" 
                            onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-500 hover:text-blue-700 transition-colors"
                        >
                            <i id="toggleIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                        >
                        <span class="ml-2 text-sm text-gray-700">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800 transition-colors">
                        Lupa password?
                    </a>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            <span class="text-red-700 text-sm">
                                @if ($errors->has('login'))
                                    {{ $errors->first('login') }}
                                @else
                                    Terjadi kesalahan. Silakan periksa input Anda.
                                @endif
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Login Button -->
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-500/50 shadow-lg"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk
                </button>
            </form>

            <!-- Additional Links -->
            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    Belum punya akun? 
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                        Hubungi Administrator
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        {{-- <div class="text-center mt-6">
            <p class="text-blue-200 text-sm">
                © {{ date('Y') }} Sistem Kepegawaian. All rights reserved.
            </p>
        </div> --}}
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

// Add loading state to login button
document.querySelector('form').addEventListener('submit', function() {
    const button = this.querySelector('button[type="submit"]');
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
    button.disabled = true;
});
</script>
@endsection