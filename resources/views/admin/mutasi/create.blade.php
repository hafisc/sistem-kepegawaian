@extends('layout.admin')

@section('title', 'Tambah Data Mutasi - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.mutasi.index') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Tambah Data Mutasi</h1>
                <p class="text-gray-600">Buat data mutasi pegawai baru</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.mutasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Jenis Mutasi -->
                    <div class="md:col-span-2">
                        <label for="transfer_type" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-exchange-alt mr-2 text-blue-600"></i>Jenis Mutasi
                        </label>
                        <select 
                            id="transfer_type" 
                            name="transfer_type" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                        >
                            <option value="">Pilih Jenis Mutasi</option>
                            <option value="Masuk" {{ old('transfer_type') == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                            <option value="Keluar" {{ old('transfer_type') == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                        @error('transfer_type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Employee Field -->
                    <div class="md:col-span-2">
                        <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-blue-600"></i>Pegawai
                        </label>
                        <select 
                            id="employee_id" 
                            name="employee_id" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                        >
                            <option value="">Pilih Pegawai</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }} ({{ $employee->username }})
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor SK -->
                    <div>
                        <label for="sk_number" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-file-alt mr-2 text-blue-600"></i>Nomor SK
                        </label>
                        <input 
                            type="text" 
                            id="sk_number" 
                            name="sk_number" 
                            value="{{ old('sk_number') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan nomor SK"
                        >
                        @error('sk_number')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal SK -->
                    <div>
                        <label for="sk_date" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-2 text-blue-600"></i>Tanggal SK
                        </label>
                        <input 
                            type="date" 
                            id="sk_date" 
                            name="sk_date" 
                            value="{{ old('sk_date') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                        >
                        @error('sk_date')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Penempatan Lama -->
                    <div>
                        <label for="from_unit" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-building mr-2 text-blue-600"></i>Penempatan Lama (Instansi Asal)
                        </label>
                        <input 
                            type="text" 
                            id="from_unit" 
                            name="from_unit" 
                            value="{{ old('from_unit') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan instansi asal"
                        >
                        @error('from_unit')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Penempatan Baru -->
                    <div>
                        <label for="to_unit" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-building mr-2 text-green-600"></i>Penempatan Baru
                        </label>
                        <input 
                            type="text" 
                            id="to_unit" 
                            name="to_unit" 
                            value="{{ old('to_unit', 'Kecamatan Kademangan') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan penempatan baru"
                        >
                        @error('to_unit')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jabatan Sebelumnya -->
                    <div>
                        <label for="position_before" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user-tie mr-2 text-blue-600"></i>Jabatan Sebelumnya
                        </label>
                        <input 
                            type="text" 
                            id="position_before" 
                            name="position_before" 
                            value="{{ old('position_before') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan jabatan sebelumnya"
                        >
                        @error('position_before')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jabatan Setelah -->
                    <div>
                        <label for="position_after" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user-tie mr-2 text-green-600"></i>Jabatan Setelah
                        </label>
                        <input 
                            type="text" 
                            id="position_after" 
                            name="position_after" 
                            value="{{ old('position_after') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan jabatan setelah"
                        >
                        @error('position_after')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="md:col-span-2">
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-comment mr-2 text-blue-600"></i>Keterangan
                        </label>
                        <textarea 
                            id="reason" 
                            name="reason" 
                            rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan keterangan atau alasan mutasi"
                        >{{ old('reason') }}</textarea>
                        @error('reason')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File SK -->
                    <div>
                        <label for="sk_file" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-file-pdf mr-2 text-red-600"></i>File SK (Optional)
                        </label>
                        <input 
                            type="file" 
                            id="sk_file" 
                            name="sk_file" 
                            accept=".pdf,.doc,.docx"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                        >
                        <p class="mt-1 text-xs text-gray-500">Format: PDF, DOC, DOCX (Max: 2MB)</p>
                        @error('sk_file')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dokumen Pendukung -->
                    <div>
                        <label for="supporting_docs" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-paperclip mr-2 text-blue-600"></i>Dokumen Pendukung (Optional)
                        </label>
                        <input 
                            type="file" 
                            id="supporting_docs" 
                            name="supporting_docs" 
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                        >
                        <p class="mt-1 text-xs text-gray-500">Format: PDF, DOC, DOCX, JPG, PNG (Max: 2MB)</p>
                        @error('supporting_docs')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('admin.mutasi.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
