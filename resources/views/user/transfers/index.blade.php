@extends('layout.user')

@section('title', 'Data Mutasi - User')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Data Mutasi</h1>
                <p class="text-gray-600">Daftar seluruh mutasi pegawai dalam sistem kepegawaian</p>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('user.transfers') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Mutasi</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Nama pegawai, unit kerja...">
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="status" name="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                
                <div>
                    <label for="transfer_type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Mutasi</label>
                    <select id="transfer_type" name="transfer_type" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Semua Jenis</option>
                        <option value="masuk" {{ request('transfer_type') === 'masuk' ? 'selected' : '' }}>Mutasi Masuk</option>
                        <option value="riwayat" {{ request('transfer_type') === 'riwayat' ? 'selected' : '' }}>Riwayat Mutasi</option>
                        <option value="regular" {{ request('transfer_type') === 'regular' ? 'selected' : '' }}>Mutasi Regular</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Cari
                    </button>
                </div>
            </div>
            
            @if(request()->hasAny(['search', 'status', 'transfer_type']))
                <div class="flex justify-end">
                    <a href="{{ route('user.transfers') }}" 
                       class="text-gray-600 hover:text-gray-800 text-sm">
                        <i class="fas fa-times mr-1"></i>
                        Reset Filter
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Transfers Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">
                Daftar Mutasi Pegawai
                <span class="text-sm text-gray-500 ml-2">({{ $transfers->total() }} mutasi)</span>
            </h2>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jenis
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Alasan
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transfers as $transfer)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        @if($transfer->employee->photo)
                                            <img src="{{ Storage::url($transfer->employee->photo) }}" alt="{{ $transfer->employee->name }}" 
                                                 class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <i class="fas fa-user text-blue-600"></i>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $transfer->employee->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $transfer->employee->nip ?? $transfer->employee->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    @if($transfer->from_unit && $transfer->to_unit)
                                        <div class="flex items-center mb-1">
                                            <i class="fas fa-arrow-right text-gray-400 mx-2"></i>
                                            <span class="font-medium">Dari:</span>
                                            <span class="ml-1">{{ $transfer->from_unit }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-arrow-right text-blue-500 mx-2"></i>
                                            <span class="font-medium">Ke:</span>
                                            <span class="ml-1">{{ $transfer->to_unit }}</span>
                                        </div>
                                    @elseif($transfer->fromVillage && $transfer->toVillage)
                                        <div class="flex items-center mb-1">
                                            <i class="fas fa-arrow-right text-gray-400 mx-2"></i>
                                            <span class="font-medium">Dari:</span>
                                            <span class="ml-1">{{ $transfer->fromVillage->name }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-arrow-right text-blue-500 mx-2"></i>
                                            <span class="font-medium">Ke:</span>
                                            <span class="ml-1">{{ $transfer->toVillage->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-500">Data mutasi tidak lengkap</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <div><strong>Mutasi:</strong> {{ $transfer->transfer_date->format('d/m/Y') }}</div>
                                    <div class="text-gray-500"><strong>Efektif:</strong> {{ $transfer->effective_date->format('d/m/Y') }}</div>
                                    @if($transfer->sk_number)
                                        <div class="text-xs text-gray-400 mt-1">SK: {{ $transfer->sk_number }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $transfer->status_color }}">
                                    <i class="fas {{ $transfer->status_icon }} mr-1"></i>
                                    {{ ucfirst($transfer->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($transfer->transfer_type)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $transfer->transfer_type === 'masuk' ? 'bg-green-100 text-green-800' : 
                                           ($transfer->transfer_type === 'riwayat' ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ $transfer->transfer_type === 'masuk' ? 'Mutasi Masuk' : 
                                           ($transfer->transfer_type === 'riwayat' ? 'Riwayat' : 'Regular') }}
                                    </span>
                                @else
                                    <span class="text-gray-500 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs">
                                    <p class="truncate" title="{{ $transfer->reason }}">
                                        {{ $transfer->reason ?? 'Tidak ada keterangan' }}
                                    </p>
                                    @if($transfer->position_before && $transfer->position_after)
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $transfer->position_before }} → {{ $transfer->position_after }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-exchange-alt text-4xl mb-2"></i>
                                <p>Tidak ada data mutasi yang ditemukan</p>
                                @if(request()->hasAny(['search', 'status', 'transfer_type']))
                                    <a href="{{ route('user.transfers') }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">
                                        Tampilkan semua mutasi
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transfers->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $transfers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
