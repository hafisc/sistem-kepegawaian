@extends('layout.admin')

@section('title', 'Tambah Pegawai - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Tambah Data Pegawai</h1>
                <p class="text-gray-600">Lengkapi semua informasi pegawai dengan benar</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                <span class="font-semibold text-red-700">Terdapat kesalahan:</span>
            </div>
            <ul class="list-disc list-inside text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <!-- Personal Information Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-user mr-2 text-blue-600"></i>
                Informasi Pribadi
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                    <input type="text" id="nip" name="nip" value="{{ old('nip') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Nomor Induk Pegawai">
                </div>
                
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Nomor Induk Kependudukan">
                </div>
                
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                    <select id="gender" name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                
                <div>
                    <label for="place_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                    <input type="text" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">Agama</label>
                    <select id="religion" name="religion" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Pilih Agama</option>
                        <option value="Islam" {{ old('religion') === 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('religion') === 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('religion') === 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('religion') === 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('religion') === 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('religion') === 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>
                
                <div>
                    <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-2">Status Pernikahan</label>
                    <select id="marital_status" name="marital_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Pilih Status</option>
                        <option value="Belum Menikah" {{ old('marital_status') === 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                        <option value="Menikah" {{ old('marital_status') === 'Menikah' ? 'selected' : '' }}>Menikah</option>
                        <option value="Cerai Hidup" {{ old('marital_status') === 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('marital_status') === 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="08xxxxxxxxxx">
                </div>
            </div>
            
            <div class="mt-4">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                <textarea id="address" name="address" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                          placeholder="Alamat lengkap dengan RT/RW, Kelurahan, Kecamatan">{{ old('address') }}</textarea>
            </div>
        </div>

        <!-- Employment Information Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-briefcase mr-2 text-green-600"></i>
                Informasi Kepegawaian
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">ID Pegawai</label>
                    <input type="text" id="employee_id" name="employee_id" value="{{ old('employee_id') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label for="employee_type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Pegawai *</label>
                    <select id="employee_type" name="employee_type" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Pilih Jenis Pegawai</option>
                        <option value="PNS" {{ old('employee_type') === 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="PPPK" {{ old('employee_type') === 'PPPK' ? 'selected' : '' }}>PPPK</option>
                        <option value="NON ASN" {{ old('employee_type') === 'NON ASN' ? 'selected' : '' }}>NON ASN</option>
                    </select>
                </div>
                
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                    <input type="text" id="position" name="position" value="{{ old('position') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Contoh: Kepala Desa, Sekretaris Desa">
                </div>
                
                <div>
                    <label for="rank" class="block text-sm font-medium text-gray-700 mb-2">Pangkat</label>
                    <input type="text" id="rank" name="rank" value="{{ old('rank') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Contoh: Penata Muda, Penata">
                </div>
                
                <div>
                    <label for="grade" class="block text-sm font-medium text-gray-700 mb-2">Golongan</label>
                    <input type="text" id="grade" name="grade" value="{{ old('grade') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Contoh: III/a, III/b, IV/a">
                </div>
                
                <div>
                    <label for="work_unit" class="block text-sm font-medium text-gray-700 mb-2">Unit Kerja</label>
                    <input type="text" id="work_unit" name="work_unit" value="{{ old('work_unit') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Nama desa/instansi tempat bekerja">
                </div>
                
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai Kerja</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">TMT (Terhitung Mulai Tanggal)</label>
                    <input type="date" id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label for="employment_status" class="block text-sm font-medium text-gray-700 mb-2">Status Kepegawaian</label>
                    <select id="employment_status" name="employment_status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="Aktif" {{ old('employment_status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Cuti" {{ old('employment_status') === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                        <option value="Pensiun" {{ old('employment_status') === 'Pensiun' ? 'selected' : '' }}>Pensiun</option>
                        <option value="Mutasi" {{ old('employment_status') === 'Mutasi' ? 'selected' : '' }}>Mutasi</option>
                        <option value="Nonaktif" {{ old('employment_status') === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Education Information Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-graduation-cap mr-2 text-purple-600"></i>
                Informasi Pendidikan
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="education_id" class="block text-sm font-medium text-gray-700 mb-2">Pendidikan Terakhir</label>
                    <select id="education_id" name="education_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Pilih Pendidikan</option>
                        @if(isset($educations))
                            @foreach($educations as $education)
                                <option value="{{ $education->id }}" {{ old('education_id') == $education->id ? 'selected' : '' }}>
                                    {{ $education->level_name }} - {{ $education->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div>
                    <label for="education_major" class="block text-sm font-medium text-gray-700 mb-2">Jurusan</label>
                    <input type="text" id="education_major" name="education_major" value="{{ old('education_major') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Jurusan/Program Studi">
                </div>
                
                <div>
                    <label for="graduation_year" class="block text-sm font-medium text-gray-700 mb-2">Tahun Lulus</label>
                    <input type="number" id="graduation_year" name="graduation_year" value="{{ old('graduation_year') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           min="1950" max="{{ date('Y') }}" placeholder="2020">
                </div>
            </div>
        </div>

        <!-- Documents and Files Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-file-upload mr-2 text-orange-600"></i>
                Dokumen dan File
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Pegawai</label>
                    <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <div class="mt-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        <strong>Persyaratan:</strong>
                        <ul class="list-disc list-inside mt-1 ml-4">
                            <li>Format: JPG, JPEG, PNG</li>
                            <li>Ukuran maksimal: 2MB</li>
                            <li>Resolusi minimal: 300x400 pixel</li>
                            <li>Background merah atau biru</li>
                        </ul>
                    </div>
                </div>
                
                <div>
                    <label for="sk_file" class="block text-sm font-medium text-gray-700 mb-2">File SK (Surat Keputusan)</label>
                    <input type="file" id="sk_file" name="sk_file" accept=".pdf,.jpg,.jpeg,.png" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <div class="mt-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        <strong>Persyaratan:</strong>
                        <ul class="list-disc list-inside mt-1 ml-4">
                            <li>Format: PDF, JPG, JPEG, PNG</li>
                            <li>Ukuran maksimal: 5MB</li>
                            <li>Dokumen harus jelas dan dapat dibaca</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-cog mr-2 text-red-600"></i>
                Informasi Sistem
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                    <select id="role" name="role" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="camat" {{ old('role') === 'camat' ? 'selected' : '' }}>Camat</option>
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                    <input type="password" id="password" name="password" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">Aktif</label>
                </div>
            </div>
            
            <div class="mt-4">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea id="notes" name="notes" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                          placeholder="Catatan tambahan tentang pegawai">{{ old('notes') }}</textarea>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.users') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                <i class="fas fa-times mr-2"></i>
                Batal
            </a>
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                <i class="fas fa-save mr-2"></i>
                Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection
