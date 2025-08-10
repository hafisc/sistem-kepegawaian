@extends('layout.user')

@section('title', 'User Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard User</h1>
        <p class="text-gray-600">Selamat datang, {{ $user->name }}</p>
    </div>

    <!-- User Info Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Profil</h2>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <i class="fas fa-user text-blue-600 w-6"></i>
                        <span class="ml-3 text-gray-600">Nama:</span>
                        <span class="ml-2 font-medium">{{ $user->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-id-card text-blue-600 w-6"></i>
                        <span class="ml-3 text-gray-600">Username:</span>
                        <span class="ml-2 font-medium">{{ $user->username }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-blue-600 w-6"></i>
                        <span class="ml-3 text-gray-600">Email:</span>
                        <span class="ml-2 font-medium">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt text-blue-600 w-6"></i>
                        <span class="ml-3 text-gray-600">Role:</span>
                        <span class="ml-2 font-medium capitalize">{{ $user->role }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 w-6"></i>
                        <span class="ml-3 text-gray-600">Status:</span>
                        <span class="ml-2 font-medium text-green-600">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('user.profile') }}" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <i class="fas fa-edit text-blue-600 mr-3"></i>
                        <span class="font-medium text-blue-800">Edit Profil</span>
                    </a>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                            <i class="fas fa-sign-out-alt text-red-600 mr-3"></i>
                            <span class="font-medium text-red-800">Logout</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- System Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Sistem Info</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Login terakhir:</span>
                        <span class="font-medium">{{ now()->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Akun dibuat:</span>
                        <span class="font-medium">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
        <h2 class="text-2xl font-bold mb-2">Selamat Datang di Sistem Kepegawaian</h2>
        <p class="text-blue-100">
            Sistem ini dirancang untuk membantu pengelolaan data kepegawaian dengan mudah dan efisien. 
            Gunakan menu navigasi untuk mengakses fitur-fitur yang tersedia.
        </p>
    </div>
</div>
@endsection
