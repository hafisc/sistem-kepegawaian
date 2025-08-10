@extends('layout.camat')

@section('title', 'Edit Pegawai')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <a href="{{ route('camat.employees') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="text-xl font-semibold text-gray-800">Edit Pegawai: {{ $employee->name }}</h2>
            </div>
        </div>

        <div class="p-6">
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('camat.employees.update', $employee) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Basic Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $employee->name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $employee->email) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                        </div>
                        
                        <div>
                            <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                            <input type="text" id="nip" name="nip" value="{{ old('nip', $employee->nip) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                            <input type="text" id="nik" name="nik" value="{{ old('nik', $employee->nik) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Employment Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kepegawaian</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                            <input type="text" id="position" name="position" value="{{ old('position', $employee->position) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="rank" class="block text-sm font-medium text-gray-700 mb-2">Pangkat</label>
                            <input type="text" id="rank" name="rank" value="{{ old('rank', $employee->rank) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="grade" class="block text-sm font-medium text-gray-700 mb-2">Golongan</label>
                            <input type="text" id="grade" name="grade" value="{{ old('grade', $employee->grade) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="village_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Desa Penugasan <span class="text-red-500">*</span>
                            </label>
                            <select id="village_id" name="village_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                                <option value="">Pilih Desa</option>
                                @foreach($villages as $village)
                                    <option value="{{ $village->id }}" {{ old('village_id', $employee->village_id) == $village->id ? 'selected' : '' }}>
                                        {{ $village->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="employment_status" class="block text-sm font-medium text-gray-700 mb-2">Status Kepegawaian</label>
                            <select id="employment_status" name="employment_status" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="">Pilih Status</option>
                                <option value="Aktif" {{ old('employment_status', $employee->employment_status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Cuti" {{ old('employment_status', $employee->employment_status) == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="Pensiun" {{ old('employment_status', $employee->employment_status) == 'Pensiun' ? 'selected' : '' }}>Pensiun</option>
                                <option value="Mutasi" {{ old('employment_status', $employee->employment_status) == 'Mutasi' ? 'selected' : '' }}>Mutasi</option>
                                <option value="Nonaktif" {{ old('employment_status', $employee->employment_status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', $employee->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Status Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Photo Upload -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Foto Profil</h3>
                    <div class="flex items-center space-x-4">
                        @if($employee->photo_url)
                            <div class="w-20 h-20 bg-gray-300 rounded-full overflow-hidden">
                                <img src="{{ $employee->photo_url }}" alt="{{ $employee->name }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" 
                                   id="photo" 
                                   name="photo" 
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('camat.employees') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                        <i class="fas fa-save mr-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
