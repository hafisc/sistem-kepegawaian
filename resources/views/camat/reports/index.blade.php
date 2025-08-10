@extends('layout.camat')

@section('title', 'Laporan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Report Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Laporan Pegawai</h3>
                    <p class="text-sm text-gray-600 mt-1">Data lengkap pegawai di wilayah kecamatan</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('camat.reports.employees') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                    <i class="fas fa-file-alt mr-2"></i>Lihat Laporan
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Laporan Desa</h3>
                    <p class="text-sm text-gray-600 mt-1">Statistik dan data desa di kecamatan</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-map-marker-alt text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('camat.reports.villages') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200">
                    <i class="fas fa-file-alt mr-2"></i>Lihat Laporan
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Laporan Transfer</h3>
                    <p class="text-sm text-gray-600 mt-1">Riwayat dan status transfer pegawai</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-exchange-alt text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('camat.reports.transfers') }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-200">
                    <i class="fas fa-file-alt mr-2"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Statistics -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Statistik Cepat</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $stats['total_employees'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Total Pegawai</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $stats['total_villages'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Total Desa</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending_transfers'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Transfer Pending</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-600">{{ $stats['approved_transfers'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Transfer Disetujui</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-md mt-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terbaru</h3>
        </div>
        <div class="p-6">
            @if(isset($recent_activities) && $recent_activities->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_activities as $activity)
                        <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-{{ $activity->icon ?? 'info' }} text-blue-600 text-xs"></i>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $activity->title }}</p>
                                <p class="text-xs text-gray-500">{{ $activity->description }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-history text-4xl text-gray-300 mb-2"></i>
                    <p class="text-gray-500">Belum ada aktivitas terbaru</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
