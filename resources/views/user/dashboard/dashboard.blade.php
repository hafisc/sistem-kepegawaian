@extends('layout.user')

@section('title', 'Dashboard - Sistem Kepegawaian')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ $user->name }}!</h1>
                    <p class="text-blue-100">{{ now()->format('l, d F Y') }}</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        @if($user->photo)
                            <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}" 
                                 class="w-16 h-16 rounded-full object-cover">
                        @else
                            <i class="fas fa-user text-3xl text-white"></i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Pegawai -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pegawai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalEmployees ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Mutasi -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-exchange-alt text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Mutasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalTransfers ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Pegawai PNS -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-id-badge text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pegawai PNS</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalPNS ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Status Akun -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-emerald-100 rounded-lg">
                    <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Status Akun</p>
                    <p class="text-lg font-bold text-emerald-600">Aktif</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Informasi Profil</h2>
                    <a href="{{ route('user.profile') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Edit Profil <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-600">Nama Lengkap</p>
                                <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <i class="fas fa-envelope text-green-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-semibold text-gray-900">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="p-2 bg-purple-100 rounded-lg">
                                <i class="fas fa-id-card text-purple-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-600">Username</p>
                                <p class="font-semibold text-gray-900">{{ $user->username }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="p-2 bg-orange-100 rounded-lg">
                                <i class="fas fa-shield-alt text-orange-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-600">Role</p>
                                <p class="font-semibold text-gray-900 capitalize">{{ $user->role }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Menu Utama</h3>
                <div class="space-y-3">
                    <a href="{{ route('user.employees') }}" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors group">
                        <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-blue-800">Data Pegawai</p>
                            <p class="text-xs text-blue-600">Lihat daftar pegawai</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('user.transfers') }}" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                        <div class="p-2 bg-green-100 rounded-lg group-hover:bg-green-200">
                            <i class="fas fa-exchange-alt text-green-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-green-800">Data Mutasi</p>
                            <p class="text-xs text-green-600">Lihat riwayat mutasi</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('user.profile') }}" class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors group">
                        <div class="p-2 bg-purple-100 rounded-lg group-hover:bg-purple-200">
                            <i class="fas fa-edit text-purple-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-purple-800">Edit Profil</p>
                            <p class="text-xs text-purple-600">Update informasi</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- System Info -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Sistem</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-gray-600 mr-2"></i>
                            <span class="text-sm text-gray-600">Login terakhir</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ now()->format('H:i') }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-calendar text-gray-600 mr-2"></i>
                            <span class="text-sm text-gray-600">Akun dibuat</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-shield-check text-emerald-600 mr-2"></i>
                            <span class="text-sm text-emerald-700">Status Keamanan</span>
                        </div>
                        <span class="text-sm font-medium text-emerald-700">Aman</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity (Optional) -->
    <div class="mt-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Aktivitas Terbaru</h3>
            <div class="text-center py-8">
                <i class="fas fa-history text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Belum ada aktivitas terbaru</p>
                <p class="text-sm text-gray-400 mt-2">Aktivitas Anda akan muncul di sini</p>
            </div>
        </div>
    </div>
</div>
@endsection
