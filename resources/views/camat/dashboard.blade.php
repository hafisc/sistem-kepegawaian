@extends('layout.camat')

@section('title', 'Dashboard Camat')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md text-white p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}</h1>
                <p class="text-blue-100 mt-1">Dashboard Camat - Sistem Kepegawaian</p>
                <p class="text-blue-100 text-sm">{{ now()->format('l, d F Y') }}</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-user-tie text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Pegawai</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_employees'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-map-marker-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Desa</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_villages'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-exchange-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Transfer Pending</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_transfers'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Transfer Disetujui</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['approved_transfers'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Transfers -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Transfer Terbaru</h3>
                    <a href="{{ route('camat.transfers') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if(isset($recent_transfers) && $recent_transfers->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_transfers as $transfer)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $transfer->user->name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">{{ $transfer->from_village->name ?? 'N/A' }} → {{ $transfer->to_village->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($transfer->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($transfer->status == 'approved') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($transfer->status) }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $transfer->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-exchange-alt text-4xl text-gray-300 mb-2"></i>
                        <p class="text-gray-500">Belum ada transfer terbaru</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Aksi Cepat</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('camat.employees') }}" 
                       class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                        <i class="fas fa-users text-2xl text-blue-600 mb-2"></i>
                        <span class="text-sm font-medium text-blue-800">Kelola Pegawai</span>
                    </a>
                    
                    <a href="{{ route('camat.villages') }}" 
                       class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                        <i class="fas fa-map-marker-alt text-2xl text-green-600 mb-2"></i>
                        <span class="text-sm font-medium text-green-800">Kelola Desa</span>
                    </a>
                    
                    <a href="{{ route('camat.transfers') }}" 
                       class="flex flex-col items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition duration-200">
                        <i class="fas fa-exchange-alt text-2xl text-yellow-600 mb-2"></i>
                        <span class="text-sm font-medium text-yellow-800">Kelola Transfer</span>
                    </a>
                    
                    <a href="{{ route('camat.reports') }}" 
                       class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition duration-200">
                        <i class="fas fa-chart-bar text-2xl text-purple-600 mb-2"></i>
                        <span class="text-sm font-medium text-purple-800">Laporan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    @if(isset($recent_notifications) && $recent_notifications->count() > 0)
        <div class="bg-white rounded-lg shadow-md mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Notifikasi Terbaru</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($recent_notifications as $notification)
                        <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <i class="fas {{ $notification->icon }} text-{{ $notification->color }}-600"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $notification->title }}</p>
                                <p class="text-xs text-gray-500">{{ $notification->message }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
