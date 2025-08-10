@extends('layout.camat')

@section('title', 'Detail Desa')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('camat.villages') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="text-xl font-semibold text-gray-800">Detail Desa: {{ $village->name }}</h2>
                </div>
                <a href="{{ route('camat.villages.edit', $village) }}" 
                   class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Village Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Desa</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Desa</label>
                            <p class="text-sm text-gray-900">{{ $village->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Kode Pos</label>
                            <p class="text-sm text-gray-900">{{ $village->postal_code ?? '-' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Deskripsi</label>
                            <p class="text-sm text-gray-900">{{ $village->description ?? '-' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Dibuat</label>
                            <p class="text-sm text-gray-900">{{ $village->created_at->format('d F Y H:i') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Terakhir Diupdate</label>
                            <p class="text-sm text-gray-900">{{ $village->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $village->users_count ?? 0 }}</div>
                            <div class="text-sm text-blue-800">Total Pegawai</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $village->active_users_count ?? 0 }}</div>
                            <div class="text-sm text-green-800">Pegawai Aktif</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee List -->
            @if($village->users && $village->users->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Pegawai</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">NIP</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($village->users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                                    @if($user->photo_url)
                                                        <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full object-cover">
                                                    @else
                                                        <i class="fas fa-user text-gray-600 text-xs"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $user->nip ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $user->position ?? '-' }}</td>
                                        <td class="px-4 py-2">
                                            @if($user->is_active)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Tidak Aktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('camat.employees.show', $user) }}" 
                                               class="text-blue-600 hover:text-blue-900 transition duration-200">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
