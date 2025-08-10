@extends('layout.admin')

@section('title', 'Detail Mutasi - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.transfers') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Mutasi</h1>
                <p class="text-gray-600">Informasi lengkap mutasi {{ $transfer->employee->name }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <!-- Transfer Details Card -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-start mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Informasi Mutasi</h2>
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $transfer->status_color }}">
                    <i class="fas {{ $transfer->status_icon }} mr-1"></i>
                    {{ ucfirst($transfer->status) }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Employee Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-700 border-b pb-2">Data Pegawai</h3>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800">{{ $transfer->employee->name }}</h4>
                            <p class="text-gray-600">{{ $transfer->employee->username }}</p>
                            <p class="text-gray-600">{{ $transfer->employee->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Transfer Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-700 border-b pb-2">Detail Mutasi</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tanggal Mutasi:</label>
                            <p class="text-gray-800">{{ $transfer->transfer_date->format('d F Y') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tanggal Efektif:</label>
                            <p class="text-gray-800">{{ $transfer->effective_date->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transfer Route Card -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Rute Mutasi</h2>
            
            <div class="flex items-center justify-between">
                <!-- From Village -->
                <div class="flex-1 text-center">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $transfer->fromVillage->name }}</h3>
                    <p class="text-gray-600">{{ $transfer->fromVillage->district }}</p>
                    <p class="text-gray-500">{{ $transfer->fromVillage->regency }}, {{ $transfer->fromVillage->province }}</p>
                    <span class="inline-block mt-2 px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full">
                        Desa Asal
                    </span>
                </div>

                <!-- Arrow -->
                <div class="flex-shrink-0 mx-8">
                    <i class="fas fa-arrow-right text-blue-500 text-3xl"></i>
                </div>

                <!-- To Village -->
                <div class="flex-1 text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $transfer->toVillage->name }}</h3>
                    <p class="text-gray-600">{{ $transfer->toVillage->district }}</p>
                    <p class="text-gray-500">{{ $transfer->toVillage->regency }}, {{ $transfer->toVillage->province }}</p>
                    <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                        Desa Tujuan
                    </span>
                </div>
            </div>
        </div>

        <!-- Reason and Notes Card -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Alasan & Catatan</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">Alasan Mutasi:</label>
                    <p class="text-gray-800 mt-1 p-3 bg-gray-50 rounded-lg">{{ $transfer->reason }}</p>
                </div>
                
                @if($transfer->notes)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Catatan:</label>
                        <p class="text-gray-800 mt-1 p-3 bg-gray-50 rounded-lg">{{ $transfer->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Status Update Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Update Status</h2>
            
            <form action="{{ route('admin.transfers.status', $transfer) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-flag mr-2 text-blue-600"></i>Status Baru
                        </label>
                        <select 
                            id="status" 
                            name="status" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                        >
                            <option value="pending" {{ $transfer->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $transfer->status === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $transfer->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="completed" {{ $transfer->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sticky-note mr-2 text-blue-600"></i>Catatan Tambahan
                        </label>
                        <textarea 
                            id="notes" 
                            name="notes" 
                            rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Catatan untuk perubahan status"
                        ></textarea>
                    </div>
                </div>
                
                <div class="mt-6">
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors"
                    >
                        <i class="fas fa-save mr-2"></i>
                        Update Status
                    </button>
                </div>
            </form>
        </div>

        <!-- Metadata Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Informasi Sistem</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                <div>
                    <label class="text-gray-500">Dibuat pada:</label>
                    <p class="text-gray-800 font-medium">{{ $transfer->created_at->format('d F Y, H:i') }}</p>
                </div>
                <div>
                    <label class="text-gray-500">Terakhir diupdate:</label>
                    <p class="text-gray-800 font-medium">{{ $transfer->updated_at->format('d F Y, H:i') }}</p>
                </div>
                <div>
                    <label class="text-gray-500">ID Mutasi:</label>
                    <p class="text-gray-800 font-medium">#{{ $transfer->id }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-4 mt-6">
            <a href="{{ route('admin.transfers.edit', $transfer) }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                <i class="fas fa-edit mr-2"></i>
                Edit Mutasi
            </a>
            <form action="{{ route('admin.transfers.delete', $transfer) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mutasi ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus Mutasi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
