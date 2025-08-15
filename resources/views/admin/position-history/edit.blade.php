@extends('layout.admin')

@section('title', 'Edit Riwayat Jabatan - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.position-history.index', $user) }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Edit Riwayat Jabatan</h1>
                <p class="text-gray-600">Edit riwayat jabatan untuk pegawai: <strong>{{ $user->name }}</strong></p>
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

    <form action="{{ route('admin.position-history.update', [$user, $positionHistory]) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit Kerja Saat Ini</label>
                    <p class="text-gray-900">{{ $user->work_unit ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Position Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-briefcase mr-2 text-green-600"></i>
                Informasi Jabatan
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="position_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Jabatan *</label>
                    <input type="text" id="position_name" name="position_name" value="{{ old('position_name', $positionHistory->position_name) }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Contoh: Kepala Desa, Sekretaris Desa">
                </div>
                
                <div>
                    <label for="position_level" class="block text-sm font-medium text-gray-700 mb-2">Tingkat Jabatan</label>
                    <input type="text" id="position_level" name="position_level" value="{{ old('position_level', $positionHistory->position_level) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Contoh: Eselon IV/a, Struktural">
                </div>
                
                <div>
                    <label for="unit_kerja" class="block text-sm font-medium text-gray-700 mb-2">Unit Kerja *</label>
                    <input type="text" id="unit_kerja" name="unit_kerja" value="{{ old('unit_kerja', $positionHistory->unit_kerja) }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Nama desa/instansi tempat menjabat">
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Jabatan *</label>
                    <select id="status" name="status" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Pilih Status</option>
                        <option value="aktif" {{ old('status', $positionHistory->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ old('status', $positionHistory->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai *</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $positionHistory->start_date?->format('Y-m-d')) }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $positionHistory->end_date?->format('Y-m-d')) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika masih aktif</p>
                </div>
            </div>
            
            <div class="mt-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Jabatan</label>
                <textarea id="description" name="description" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                          placeholder="Deskripsi tugas dan tanggung jawab">{{ old('description', $positionHistory->description) }}</textarea>
            </div>
        </div>

        <!-- SK Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-file-alt mr-2 text-purple-600"></i>
                Informasi SK
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="sk_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor SK</label>
                    <input type="text" id="sk_number" name="sk_number" value="{{ old('sk_number', $positionHistory->sk_number) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Nomor Surat Keputusan">
                </div>
                
                <div>
                    <label for="sk_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal SK</label>
                    <input type="date" id="sk_date" name="sk_date" value="{{ old('sk_date', $positionHistory->sk_date?->format('Y-m-d')) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
            </div>
            
            <div class="mt-4">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea id="notes" name="notes" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                          placeholder="Catatan tambahan">{{ old('notes', $positionHistory->notes) }}</textarea>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.position-history.index', $user) }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                <i class="fas fa-times mr-2"></i>
                Batal
            </a>
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                <i class="fas fa-save mr-2"></i>
                Update Riwayat Jabatan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const endDateInput = document.getElementById('end_date');
    
    statusSelect.addEventListener('change', function() {
        if (this.value === 'aktif') {
            endDateInput.value = '';
            endDateInput.disabled = true;
        } else {
            endDateInput.disabled = false;
        }
    });
    
    // Initialize on page load
    if (statusSelect.value === 'aktif') {
        endDateInput.disabled = true;
    }
});
</script>
@endsection
