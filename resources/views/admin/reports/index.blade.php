@extends('layout.admin')

@section('title', 'Laporan - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Laporan Sistem</h1>
                <p class="text-gray-600">Dashboard laporan dan statistik sistem kepegawaian</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.reports.employees') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-users mr-2"></i>
                    Laporan Pegawai
                </a>
                <a href="{{ route('admin.reports.transfers') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-exchange-alt mr-2"></i>
                    Laporan Mutasi
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Pegawai -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Total Pegawai</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalEmployees }}</p>
                </div>
            </div>
        </div>

        <!-- Pegawai Aktif -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-user-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Pegawai Aktif</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $activeEmployees }}</p>
                </div>
            </div>
        </div>

        <!-- Total Desa -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-map-marker-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Total Desa</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ $totalVillages }}</p>
                </div>
            </div>
        </div>

        <!-- Total Mutasi -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-exchange-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Total Mutasi</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalMutasi }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Transfer Status Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Status Mutasi</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-yellow-400 rounded mr-3"></div>
                        <span class="text-gray-700">Pending</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-lg font-semibold text-gray-800 mr-2">{{ $pendingMutasi }}</span>
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $totalMutasi > 0 ? ($pendingMutasi / $totalMutasi) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-400 rounded mr-3"></div>
                        <span class="text-gray-700">Approved</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-lg font-semibold text-gray-800 mr-2">{{ $approvedMutasi }}</span>
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-green-400 h-2 rounded-full" style="width: {{ $totalMutasi > 0 ? ($approvedMutasi / $totalMutasi) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-400 rounded mr-3"></div>
                        <span class="text-gray-700">Completed</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-lg font-semibold text-gray-800 mr-2">{{ $completedMutasi }}</span>
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-400 h-2 rounded-full" style="width: {{ $totalMutasi > 0 ? ($completedMutasi / $totalMutasi) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Transfers -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Mutasi Bulanan (6 Bulan Terakhir)</h2>
            <div class="space-y-3">
                @forelse($monthlyTransfers as $monthly)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">
                            {{ DateTime::createFromFormat('!m', $monthly->month)->format('F') }} {{ $monthly->year }}
                        </span>
                        <div class="flex items-center">
                            <span class="text-lg font-semibold text-gray-800 mr-2">{{ $monthly->total }}</span>
                            <div class="w-20 bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $monthlyTransfers->max('total') > 0 ? ($monthly->total / $monthlyTransfers->max('total')) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Belum ada data mutasi</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Transfers -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Mutasi Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pegawai
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Mutasi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentTransfers as $transfer)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600 text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $transfer->employee->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $transfer->fromVillage->name }} → {{ $transfer->toVillage->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $transfer->transfer_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $transfer->status_color }}">
                                    {{ ucfirst($transfer->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Belum ada data mutasi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($recentTransfers->count() > 0)
            <div class="px-6 py-4 border-t border-gray-200">
                <a href="{{ route('admin.transfers') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Lihat semua mutasi →
                </a>
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-users text-blue-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Pegawai</h3>
            <p class="text-gray-600 mb-4">Lihat dan export data pegawai</p>
            <a href="{{ route('admin.reports.employees') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                Lihat Laporan
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-map-marker-alt text-green-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Desa</h3>
            <p class="text-gray-600 mb-4">Lihat data desa dan wilayah</p>
            <a href="{{ route('admin.reports.villages') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                Lihat Laporan
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exchange-alt text-orange-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Mutasi</h3>
            <p class="text-gray-600 mb-4">Lihat data mutasi pegawai</p>
            <a href="{{ route('admin.reports.transfers') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                Lihat Laporan
            </a>
        </div>
    </div>
</div>
@endsection
