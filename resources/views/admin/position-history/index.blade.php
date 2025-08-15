@extends('layout.admin')

@section('title', 'Riwayat Jabatan - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Riwayat Jabatan</h1>
                    <p class="text-gray-600">Riwayat jabatan untuk pegawai: <strong>{{ $user->name }}</strong></p>
                </div>
            </div>
            <a href="{{ route('admin.position-history.create', $user) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Tambah Riwayat Jabatan
            </a>
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

    <!-- Employee Information -->
    <div class="bg-blue-50 rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
            <i class="fas fa-user mr-2 text-blue-600"></i>
            Informasi Pegawai
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <p class="text-gray-900 font-semibold">{{ $user->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                <p class="text-gray-900">{{ $user->nip ?? '-' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan Saat Ini</label>
                <p class="text-gray-900">{{ $user->position ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Position History List -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">
                <i class="fas fa-history mr-2 text-orange-600"></i>
                Daftar Riwayat Jabatan
            </h2>
        </div>

        @if($positionHistories->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Kerja</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($positionHistories as $index => $history)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $positionHistories->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $history->position_name }}</div>
                                    @if($history->position_level)
                                        <div class="text-sm text-gray-500">{{ $history->position_level }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $history->unit_kerja }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($history->start_date)->format('d M Y') }}
                                    @if($history->end_date)
                                        - {{ \Carbon\Carbon::parse($history->end_date)->format('d M Y') }}
                                    @else
                                        - Sekarang
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $history->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        <i class="fas {{ $history->status === 'aktif' ? 'fa-check-circle' : 'fa-history' }} mr-1"></i>
                                        {{ ucfirst($history->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.position-history.edit', [$user, $history]) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.position-history.destroy', [$user, $history]) }}" 
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat jabatan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $positionHistories->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <i class="fas fa-history text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Riwayat Jabatan</h3>
                <p class="text-gray-500 mb-4">Belum ada data riwayat jabatan untuk pegawai ini.</p>
                <a href="{{ route('admin.position-history.create', $user) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Riwayat Jabatan Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
