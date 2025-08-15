@extends('layout.admin')

@section('title', 'Form Mutasi Masuk - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Form Mutasi Masuk</h1>
                <p class="text-gray-600">Lengkapi data mutasi masuk untuk pegawai: <strong>{{ $user->name }}</strong></p>
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

    <form action="{{ route('admin.mutasi.masuk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        
        <!-- Employee Information Display -->
        <div class="bg-blue-50 rounded-lg shadow p-6">
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Pegawai</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        {{ $user->employee_type }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Transfer In Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-arrow-right mr-2 text-green-600"></i>
                Informasi Mutasi Masuk
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="from_unit" class="block text-sm font-medium text-gray-700 mb-2">Asal Unit Kerja *</label>
                    <input type="text" id="from_unit" name="from_unit" value="{{ old('from_unit') }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Unit kerja asal">
                </div>
                
                <div>
                    <label for="to_unit" class="block text-sm font-medium text-gray-700 mb-2">Tujuan Unit Kerja *</label>
                    <input type="text" id="to_unit" name="to_unit" value="{{ old('to_unit', $user->work_unit) }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Unit kerja tujuan">
                </div>
                
                <div>
                    <label for="transfer_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mutasi *</label>
                    <input type="date" id="transfer_date" name="transfer_date" value="{{ old('transfer_date') }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label for="effective_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Efektif *</label>
                    <input type="date" id="effective_date" name="effective_date" value="{{ old('effective_date') }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label for="sk_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor SK Mutasi *</label>
                    <input type="text" id="sk_number" name="sk_number" value="{{ old('sk_number') }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Nomor Surat Keputusan">
                </div>
                
                <div>
                    <label for="sk_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal SK *</label>
                    <input type="date" id="sk_date" name="sk_date" value="{{ old('sk_date') }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label for="position_before" class="block text-sm font-medium text-gray-700 mb-2">Jabatan Sebelumnya</label>
                    <input type="text" id="position_before" name="position_before" value="{{ old('position_before') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Jabatan sebelum mutasi">
                </div>
                
                <div>
                    <label for="position_after" class="block text-sm font-medium text-gray-700 mb-2">Jabatan Setelah Mutasi</label>
                    <input type="text" id="position_after" name="position_after" value="{{ old('position_after', $user->position) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Jabatan setelah mutasi">
                </div>
            </div>
            
            <div class="mt-4">
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Alasan Mutasi</label>
                <textarea id="reason" name="reason" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                          placeholder="Alasan dilakukan mutasi (opsional)">{{ old('reason') }}</textarea>
            </div>
            
            <div class="mt-4">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea id="notes" name="notes" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                          placeholder="Catatan tambahan">{{ old('notes') }}</textarea>
            </div>
        </div>

        <!-- Document Upload -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-file-upload mr-2 text-purple-600"></i>
                Dokumen Pendukung
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="sk_file" class="block text-sm font-medium text-gray-700 mb-2">File SK Mutasi</label>
                    <input type="file" id="sk_file" name="sk_file" accept=".pdf,.jpg,.jpeg,.png" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG (Max: 5MB)</p>
                </div>
                
                <div>
                    <label for="supporting_docs" class="block text-sm font-medium text-gray-700 mb-2">Dokumen Pendukung Lainnya</label>
                    <input type="file" id="supporting_docs" name="supporting_docs" accept=".pdf,.jpg,.jpeg,.png" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG (Max: 5MB)</p>
                </div>
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
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                <i class="fas fa-save mr-2"></i>
                Simpan Mutasi Masuk
            </button>
        </div>
    </form>
</div>
@endsection
