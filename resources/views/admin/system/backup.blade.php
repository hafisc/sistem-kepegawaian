@extends('layout.admin')

@section('title', 'Backup - Pengaturan Sistem')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.system') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Backup Database</h1>
                <p class="text-gray-600">Kelola backup dan restore database sistem</p>
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

    <!-- Backup Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Buat Backup Baru</h3>
            <p class="text-gray-600 mb-4">Buat backup database lengkap dengan timestamp</p>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Backup</label>
                    <input type="text" id="backupName" placeholder="backup_{{ date('Y-m-d_H-i-s') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="backupDescription" rows="3" placeholder="Deskripsi backup..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                </div>
                
                <button onclick="createBackup()" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors">
                    <i class="fas fa-download mr-2"></i>
                    Buat Backup
                </button>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Restore Database</h3>
            <p class="text-gray-600 mb-4">Restore database dari file backup</p>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">File Backup</label>
                    <input type="file" accept=".sql,.gz" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                        <span class="text-red-700 text-sm">Peringatan: Restore akan mengganti semua data yang ada!</span>
                    </div>
                </div>
                
                <button onclick="restoreBackup()" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors">
                    <i class="fas fa-upload mr-2"></i>
                    Restore Database
                </button>
            </div>
        </div>
    </div>

    <!-- Backup History -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Riwayat Backup</h2>
                <button onclick="refreshBackups()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Refresh
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama File
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ukuran
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($backups as $backup)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-file-archive text-green-600 text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $backup['name'] }}</div>
                                        <div class="text-sm text-gray-500">{{ $backup['description'] ?? 'Tidak ada deskripsi' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $backup['date'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $backup['size'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Berhasil
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <button onclick="downloadBackup('{{ $backup['name'] }}')" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-download mr-1"></i>
                                    Download
                                </button>
                                <button onclick="deleteBackup('{{ $backup['name'] }}')" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash mr-1"></i>
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-file-archive text-4xl mb-2"></i>
                                <p>Belum ada backup yang dibuat</p>
                                <p class="text-sm">Buat backup pertama Anda untuk mengamankan data</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Backup Settings -->
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengaturan Backup Otomatis</h3>
        <p class="text-gray-600 mb-4">Atur jadwal backup otomatis untuk keamanan data</p>
        
        <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Frekuensi</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <option value="">Pilih frekuensi</option>
                    <option value="daily">Harian</option>
                    <option value="weekly">Mingguan</option>
                    <option value="monthly">Bulanan</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Waktu</label>
                <input type="time" value="02:00" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Maksimal File</label>
                <input type="number" value="10" placeholder="10" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <option value="0">Nonaktif</option>
                    <option value="1">Aktif</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function createBackup() {
    const name = document.getElementById('backupName').value || 'backup_' + new Date().toISOString().slice(0,19).replace(/:/g, '-');
    const description = document.getElementById('backupDescription').value;
    
    if (confirm('Apakah Anda yakin ingin membuat backup database?')) {
        // Here you would typically make an AJAX call to create backup
        alert('Backup akan dibuat dengan nama: ' + name + '\nFitur ini memerlukan implementasi backend tambahan.');
    }
}

function restoreBackup() {
    if (confirm('PERINGATAN: Restore akan mengganti semua data yang ada!\n\nApakah Anda yakin ingin melanjutkan?')) {
        // Here you would typically make an AJAX call to restore backup
        alert('Fitur restore memerlukan implementasi backend tambahan.');
    }
}

function downloadBackup(filename) {
    // Here you would typically trigger download
    alert('Download backup: ' + filename + '\nFitur ini memerlukan implementasi backend tambahan.');
}

function deleteBackup(filename) {
    if (confirm('Apakah Anda yakin ingin menghapus backup: ' + filename + '?')) {
        // Here you would typically make an AJAX call to delete backup
        alert('Backup akan dihapus: ' + filename + '\nFitur ini memerlukan implementasi backend tambahan.');
    }
}

function refreshBackups() {
    window.location.reload();
}
</script>
@endsection
