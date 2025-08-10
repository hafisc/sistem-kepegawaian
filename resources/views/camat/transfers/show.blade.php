@extends('layout.camat')

@section('title', 'Detail Transfer')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('camat.transfers') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="text-xl font-semibold text-gray-800">Detail Transfer</h2>
                </div>
                @if($transfer->status == 'pending')
                    <div class="flex space-x-2">
                        <form action="{{ route('camat.transfers.approve', $transfer) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200"
                                    onclick="return confirm('Apakah Anda yakin ingin menyetujui transfer ini?')">
                                <i class="fas fa-check mr-2"></i>Setujui
                            </button>
                        </form>
                        <form action="{{ route('camat.transfers.reject', $transfer) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200"
                                    onclick="return confirm('Apakah Anda yakin ingin menolak transfer ini?')">
                                <i class="fas fa-times mr-2"></i>Tolak
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Transfer Information -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Transfer</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Status</label>
                                <div class="mt-1">
                                    @if($transfer->status == 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>Pending
                                        </span>
                                    @elseif($transfer->status == 'approved')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Disetujui
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>Ditolak
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Jenis Transfer</label>
                                <p class="text-sm text-gray-900">{{ $transfer->transferType->name ?? 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Tanggal Transfer</label>
                                <p class="text-sm text-gray-900">{{ $transfer->transfer_date ? $transfer->transfer_date->format('d F Y') : '-' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Dari Desa</label>
                                <p class="text-sm text-gray-900">{{ $transfer->from_village->name ?? 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Ke Desa</label>
                                <p class="text-sm text-gray-900">{{ $transfer->to_village->name ?? 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Alasan</label>
                                <p class="text-sm text-gray-900">{{ $transfer->reason ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employee Information -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pegawai</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                                <p class="text-sm text-gray-900">{{ $transfer->user->name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">NIP</label>
                                <p class="text-sm text-gray-900">{{ $transfer->user->nip ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Jabatan</label>
                                <p class="text-sm text-gray-900">{{ $transfer->user->position ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Pangkat</label>
                                <p class="text-sm text-gray-900">{{ $transfer->user->rank ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Golongan</label>
                                <p class="text-sm text-gray-900">{{ $transfer->user->grade ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email</label>
                                <p class="text-sm text-gray-900">{{ $transfer->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            @if($transfer->notes)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Catatan</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-900">{{ $transfer->notes }}</p>
                    </div>
                </div>
            @endif

            <!-- Approval Information -->
            @if($transfer->status != 'pending')
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Persetujuan</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Disetujui/Ditolak Oleh</label>
                                <p class="text-sm text-gray-900">{{ $transfer->approved_by_user->name ?? 'System' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Tanggal</label>
                                <p class="text-sm text-gray-900">{{ $transfer->updated_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
