@extends('layout.user')

@section('title', 'Data Pegawai - User')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Data Pegawai</h1>
                <p class="text-gray-600">Daftar seluruh pegawai dalam sistem kepegawaian</p>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('user.employees') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Pegawai</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Nama, NIP, NIK...">
                </div>
                
                <div>
                    <label for="employee_type" class="block text-sm font-medium text-gray-700 mb-2">Status Pegawai</label>
                    <select id="employee_type" name="employee_type" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="PNS" {{ request('employee_type') === 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="PPPK" {{ request('employee_type') === 'PPPK' ? 'selected' : '' }}>PPPK</option>
                        <option value="NON ASN" {{ request('employee_type') === 'NON ASN' ? 'selected' : '' }}>NON ASN</option>
                    </select>
                </div>
                
                <div>
                    <label for="work_unit" class="block text-sm font-medium text-gray-700 mb-2">Unit Kerja</label>
                    <input type="text" id="work_unit" name="work_unit" value="{{ request('work_unit') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Unit kerja...">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Cari
                    </button>
                </div>
            </div>
            
            @if(request()->hasAny(['search', 'employee_type', 'work_unit']))
                <div class="flex justify-end">
                    <a href="{{ route('user.employees') }}" 
                       class="text-gray-600 hover:text-gray-800 text-sm">
                        <i class="fas fa-times mr-1"></i>
                        Reset Filter
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Employees Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">
                Daftar Pegawai
                <span class="text-sm text-gray-500 ml-2">({{ $employees->total() }} pegawai)</span>
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
                            Identitas
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status & Unit
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jabatan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kontak
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($employees as $employee)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        @if($employee->photo)
                                            <img src="{{ Storage::url($employee->photo) }}" alt="{{ $employee->name }}" 
                                                 class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <i class="fas fa-user text-blue-600"></i>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $employee->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $employee->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if($employee->nip)
                                        <div><strong>NIP:</strong> {{ $employee->nip }}</div>
                                    @endif
                                    @if($employee->nik)
                                        <div><strong>NIK:</strong> {{ $employee->nik }}</div>
                                    @endif
                                    @if($employee->employee_id)
                                        <div><strong>ID:</strong> {{ $employee->employee_id }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if($employee->employee_type)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $employee->employee_type === 'PNS' ? 'bg-green-100 text-green-800' : 
                                               ($employee->employee_type === 'PPPK' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ $employee->employee_type }}
                                        </span>
                                    @endif
                                    @if($employee->work_unit)
                                        <div class="text-xs text-gray-500 mt-1">{{ $employee->work_unit }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if($employee->position)
                                        <div>{{ $employee->position }}</div>
                                    @endif
                                    @if($employee->rank)
                                        <div class="text-xs text-gray-500">{{ $employee->rank }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <div>{{ $employee->email }}</div>
                                    @if($employee->phone)
                                        <div class="text-xs text-gray-500">{{ $employee->phone }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $employee->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $employee->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-users text-4xl mb-2"></i>
                                <p>Tidak ada data pegawai yang ditemukan</p>
                                @if(request()->hasAny(['search', 'employee_type', 'work_unit']))
                                    <a href="{{ route('user.employees') }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">
                                        Tampilkan semua pegawai
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($employees->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $employees->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
