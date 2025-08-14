@extends('layout.admin')

@section('title', 'Detail Pegawai - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Data Pegawai</h1>
                <p class="text-gray-600">Informasi lengkap pegawai {{ $user->name }}</p>
            </div>
        </div>
    </div>

    <!-- Personal Information Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
            <i class="fas fa-user mr-2 text-blue-600"></i>
            Informasi Pribadi
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                <p class="text-gray-900 font-medium">{{ $user->name ?: '-' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">NIP</label>
                <p class="text-gray-900">{{ $user->nip ?: '-' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">NIK</label>
                <p class="text-gray-900">{{ $user->nik ?: '-' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Kelamin</label>
                <p class="text-gray-900">
                    @if($user->gender)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $user->gender === 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                            <i class="fas {{ $user->gender === 'L' ? 'fa-mars' : 'fa-venus' }} mr-1"></i>
                            {{ $user->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    @else
                        -
                    @endif
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tempat Lahir</label>
                <p class="text-gray-900">{{ $user->place_of_birth ?: '-' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                <p class="text-gray-900">
                    @if($user->date_of_birth)
                        {{ \Carbon\Carbon::parse($user->date_of_birth)->format('d F Y') }}
                        <span class="text-sm text-gray-500">({{ \Carbon\Carbon::parse($user->date_of_birth)->age }} tahun)</span>
                    @else
                        -
                    @endif
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Agama</label>
                <p class="text-gray-900">{{ $user->religion ?: '-' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status Pernikahan</label>
                <p class="text-gray-900">
                    @if($user->marital_status)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <i class="fas fa-heart mr-1"></i>
                            {{ $user->marital_status }}
                        </span>
                    @else
                        -
                    @endif
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">No. Telepon</label>
                <p class="text-gray-900">{{ $user->phone ?: '-' }}</p>
            </div>
        </div>
        
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-500 mb-1">Alamat Lengkap</label>
            <p class="text-gray-900">{{ $user->address ?: '-' }}</p>
        </div>
    </div>

    <!-- Employment Information Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
            <i class="fas fa-briefcase mr-2 text-green-600"></i>
            Informasi Kepegawaian
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">ID Pegawai</label>
                <p class="text-gray-900">{{ $user->employee_id ?: '-' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Pegawai</label>
                <p class="text-gray-900">
                    @if($user->employee_type)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                            {{ $user->employee_type === 'PNS' ? 'bg-green-100 text-green-800' : 
                               ($user->employee_type === 'PPPK' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                            <i class="fas fa-id-badge mr-1"></i>
                            {{ $user->employee_type }}
                        </span>
                    @else
                        -
                    @endif
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Jabatan</label>
                <p class="text-gray-900">{{ $user->position ?: '-' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Pangkat</label>
                <p class="text-gray-900">{{ $user->rank ?: '-' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Golongan</label>
                <p class="text-gray-900">{{ $user->grade ?: '-' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Unit Kerja</label>
                <p class="text-gray-900">{{ $user->work_unit ?: '-' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Mulai Kerja</label>
                <p class="text-gray-900">
                    @if($user->start_date)
                        {{ \Carbon\Carbon::parse($user->start_date)->format('d F Y') }}
                    @else
                        -
                    @endif
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">TMT (Terhitung Mulai Tanggal)</label>
                <p class="text-gray-900">
                    @if($user->appointment_date)
                        {{ \Carbon\Carbon::parse($user->appointment_date)->format('d F Y') }}
                    @else
                        -
                    @endif
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status Kepegawaian</label>
                <p class="text-gray-900">
                    @if($user->employment_status)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                            {{ $user->employment_status === 'Aktif' ? 'bg-green-100 text-green-800' : 
                               ($user->employment_status === 'Cuti' ? 'bg-yellow-100 text-yellow-800' : 
                               ($user->employment_status === 'Pensiun' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800')) }}">
                            <i class="fas fa-circle mr-1"></i>
                            {{ $user->employment_status }}
                        </span>
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Education Information Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
            <i class="fas fa-graduation-cap mr-2 text-purple-600"></i>
            Informasi Pendidikan
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Pendidikan Terakhir</label>
                <p class="text-gray-900">
                    @if($user->education)
                        {{ $user->education->level_name }} - {{ $user->education->name }}
                    @else
                        -
                    @endif
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Jurusan</label>
                <p class="text-gray-900">{{ $user->education_major ?: '-' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tahun Lulus</label>
                <p class="text-gray-900">{{ $user->graduation_year ?: '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Documents Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
            <i class="fas fa-file-alt mr-2 text-orange-600"></i>
            Dokumen
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">Foto</label>
                @if($user->photo)
                    <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto {{ $user->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-gray-400 text-2xl"></i>
                    </div>
                @endif
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">Scan KTP</label>
                @if($user->scan_ktp)
                    <a href="{{ asset('storage/' . $user->scan_ktp) }}" target="_blank" 
                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-file-pdf mr-2 text-red-500"></i>
                        Lihat KTP
                    </a>
                @else
                    <p class="text-gray-400 text-sm">Tidak ada file</p>
                @endif
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">Scan KK</label>
                @if($user->scan_kk)
                    <a href="{{ asset('storage/' . $user->scan_kk) }}" target="_blank" 
                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-file-pdf mr-2 text-red-500"></i>
                        Lihat KK
                    </a>
                @else
                    <p class="text-gray-400 text-sm">Tidak ada file</p>
                @endif
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">Scan SK</label>
                @if($user->scan_sk)
                    <a href="{{ asset('storage/' . $user->scan_sk) }}" target="_blank" 
                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-file-pdf mr-2 text-red-500"></i>
                        Lihat SK
                    </a>
                @else
                    <p class="text-gray-400 text-sm">Tidak ada file</p>
                @endif
            </div>
        </div>
        
        @if($user->tanda_tangan_sk)
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-500 mb-1">Tanda Tangan SK</label>
            <p class="text-gray-900">{{ $user->tanda_tangan_sk }}</p>
        </div>
        @endif
    </div>

    <!-- System Information Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
            <i class="fas fa-cog mr-2 text-red-600"></i>
            Informasi Sistem
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Username</label>
                <p class="text-gray-900">{{ $user->username }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                <p class="text-gray-900">{{ $user->email }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Role</label>
                <p class="text-gray-900">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                        <i class="fas {{ $user->role === 'admin' ? 'fa-user-shield' : 'fa-user' }} mr-1"></i>
                        {{ ucfirst($user->role) }}
                    </span>
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status Akun</label>
                <p class="text-gray-900">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        <i class="fas {{ $user->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Dibuat</label>
                <p class="text-gray-900">{{ $user->created_at->format('d F Y H:i') }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Terakhir Diupdate</label>
                <p class="text-gray-900">{{ $user->updated_at->format('d F Y H:i') }}</p>
            </div>
        </div>
        
        @if($user->notes)
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-500 mb-1">Catatan</label>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-900">{{ $user->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end space-x-4">
        <a href="{{ route('admin.users') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
        <a href="{{ route('admin.users.edit', $user) }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
            <i class="fas fa-edit mr-2"></i>
            Edit Data
        </a>
    </div>
</div>
@endsection
