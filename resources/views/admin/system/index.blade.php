@extends('layout.admin')

@section('title', 'Pengaturan Sistem - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Pengaturan Sistem</h1>
                <p class="text-gray-600">Kelola dan monitor sistem kepegawaian</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- System Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Total Pengguna</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $systemStats['total_users'] }}</p>
                    <p class="text-sm text-gray-500">{{ $systemStats['active_users'] }} aktif</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-map-marker-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Total Desa</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $systemStats['total_villages'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-exchange-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Total Mutasi</h3>
                    <p class="text-2xl font-bold text-orange-600">{{ $systemStats['total_transfers'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-database text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Database</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ $systemStats['database_size'] }} MB</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-memory text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Cache</h3>
                    <p class="text-2xl font-bold text-yellow-600">{{ $systemStats['cache_size'] }} MB</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-server text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Status</h3>
                    <p class="text-2xl font-bold text-green-600">Online</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- System Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Sistem</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">PHP Version:</span>
                    <span class="font-medium text-gray-800">{{ $systemInfo['php_version'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Laravel Version:</span>
                    <span class="font-medium text-gray-800">{{ $systemInfo['laravel_version'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Server:</span>
                    <span class="font-medium text-gray-800">{{ $systemInfo['server_software'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Database:</span>
                    <span class="font-medium text-gray-800">{{ ucfirst($systemInfo['database_connection']) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Timezone:</span>
                    <span class="font-medium text-gray-800">{{ $systemInfo['timezone'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Environment:</span>
                    <span class="font-medium text-gray-800 {{ $systemInfo['environment'] === 'production' ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ ucfirst($systemInfo['environment']) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h2>
            <div class="space-y-4">
                @if($recentActivity['latest_user'])
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Pengguna Terbaru</p>
                            <p class="text-sm text-gray-600">{{ $recentActivity['latest_user']->name }}</p>
                            <p class="text-xs text-gray-500">{{ $recentActivity['latest_user']->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endif

                @if($recentActivity['latest_village'])
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Desa Terbaru</p>
                            <p class="text-sm text-gray-600">{{ $recentActivity['latest_village']->name }}</p>
                            <p class="text-xs text-gray-500">{{ $recentActivity['latest_village']->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endif

                @if($recentActivity['latest_transfer'])
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exchange-alt text-orange-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Mutasi Terbaru</p>
                            <p class="text-sm text-gray-600">{{ $recentActivity['latest_transfer']->employee->name }}</p>
                            <p class="text-xs text-gray-500">{{ $recentActivity['latest_transfer']->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- System Tools -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Cache Management -->
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-broom text-blue-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Bersihkan Cache</h3>
            <p class="text-gray-600 mb-4">Hapus cache aplikasi</p>
            <form action="{{ route('admin.system.cache.clear') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    Bersihkan
                </button>
            </form>
        </div>

        <!-- Optimization -->
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-rocket text-green-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Optimasi</h3>
            <p class="text-gray-600 mb-4">Optimasi aplikasi</p>
            <form action="{{ route('admin.system.optimize') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    Optimasi
                </button>
            </form>
        </div>

        <!-- Database Management -->
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-database text-purple-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Database</h3>
            <p class="text-gray-600 mb-4">Kelola database</p>
            <a href="{{ route('admin.system.database') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                Kelola
            </a>
        </div>

        <!-- System Logs -->
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-file-alt text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Log Sistem</h3>
            <p class="text-gray-600 mb-4">Lihat log aplikasi</p>
            <a href="{{ route('admin.system.logs') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                Lihat Log
            </a>
        </div>
    </div>
</div>
@endsection
