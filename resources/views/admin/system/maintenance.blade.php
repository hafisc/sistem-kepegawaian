@extends('layout.admin')

@section('title', 'Maintenance - Pengaturan Sistem')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.system') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Mode Maintenance</h1>
                <p class="text-gray-600">Kelola mode pemeliharaan sistem</p>
            </div>
        </div>
    </div>

    <!-- Maintenance Status -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Status Maintenance</h2>
                <p class="text-gray-600">Sistem saat ini dalam mode normal</p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                    <i class="fas fa-check-circle mr-2"></i>
                    Online
                </span>
            </div>
        </div>
    </div>

    <!-- Maintenance Tools -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivasi Mode Maintenance</h3>
            <p class="text-gray-600 mb-4">Mode maintenance akan menonaktifkan akses pengguna sementara untuk pemeliharaan sistem.</p>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
                    <span class="text-yellow-700 text-sm">Hanya admin yang dapat mengakses sistem dalam mode maintenance</span>
                </div>
            </div>

            <button class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors" onclick="toggleMaintenance()">
                <i class="fas fa-tools mr-2"></i>
                Aktifkan Mode Maintenance
            </button>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Maintenance</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="font-medium text-green-600">Normal</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Terakhir Maintenance:</span>
                    <span class="font-medium text-gray-800">Belum pernah</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Durasi Terakhir:</span>
                    <span class="font-medium text-gray-800">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Admin Terakhir:</span>
                    <span class="font-medium text-gray-800">-</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Schedule -->
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Jadwal Maintenance</h3>
        <p class="text-gray-600 mb-4">Atur jadwal maintenance rutin untuk sistem</p>
        
        <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Mulai</label>
                <input type="time" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Durasi (menit)</label>
                <input type="number" placeholder="60" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div class="md:col-span-3">
                <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                <textarea rows="3" placeholder="Deskripsi maintenance..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"></textarea>
            </div>
            <div class="md:col-span-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Jadwalkan Maintenance
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleMaintenance() {
    if (confirm('Apakah Anda yakin ingin mengaktifkan mode maintenance? Pengguna tidak akan dapat mengakses sistem.')) {
        // Here you would typically make an AJAX call to toggle maintenance mode
        alert('Mode maintenance akan diaktifkan. Fitur ini memerlukan implementasi backend tambahan.');
    }
}
</script>
@endsection
