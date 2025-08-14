@extends('layout.admin')

@section('title', 'Form Riwayat Mutasi - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Form Riwayat Mutasi</h1>
                <p class="text-gray-600">Lengkapi riwayat mutasi untuk pegawai: <strong>{{ $user->name }}</strong></p>
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

    <form action="{{ route('admin.mutasi.riwayat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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

        <!-- Transfer History Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-history mr-2 text-orange-600"></i>
                Riwayat Mutasi Sebelumnya
            </h2>
            
            <div id="transfer-history-container">
                <div class="transfer-history-item border border-gray-200 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-medium text-gray-800">Riwayat Mutasi #1</h3>
                        <button type="button" class="remove-history-item text-red-600 hover:text-red-800 hidden">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dari Unit Kerja *</label>
                            <input type="text" name="history[0][from_unit]" value="{{ old('history.0.from_unit') }}" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                   placeholder="Unit kerja asal">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ke Unit Kerja *</label>
                            <input type="text" name="history[0][to_unit]" value="{{ old('history.0.to_unit') }}" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                   placeholder="Unit kerja tujuan">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mutasi *</label>
                            <input type="date" name="history[0][transfer_date]" value="{{ old('history.0.transfer_date') }}" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor SK</label>
                            <input type="text" name="history[0][sk_number]" value="{{ old('history.0.sk_number') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                   placeholder="Nomor Surat Keputusan">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan Sebelumnya</label>
                            <input type="text" name="history[0][position_before]" value="{{ old('history.0.position_before') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                   placeholder="Jabatan sebelum mutasi">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan Setelahnya</label>
                            <input type="text" name="history[0][position_after]" value="{{ old('history.0.position_after') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                   placeholder="Jabatan setelah mutasi">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Mutasi</label>
                        <textarea name="history[0][reason]" rows="2" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                  placeholder="Alasan dilakukan mutasi">{{ old('history.0.reason') }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-center mt-4">
                <button type="button" id="add-history-item" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Riwayat Mutasi
                </button>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-info-circle mr-2 text-indigo-600"></i>
                Informasi Tambahan
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="total_mutations" class="block text-sm font-medium text-gray-700 mb-2">Total Mutasi</label>
                    <input type="number" id="total_mutations" name="total_mutations" value="{{ old('total_mutations', 1) }}" min="1" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           readonly>
                </div>
                
                <div>
                    <label for="last_mutation_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mutasi Terakhir</label>
                    <input type="date" id="last_mutation_date" name="last_mutation_date" value="{{ old('last_mutation_date') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
            </div>
            
            <div class="mt-4">
                <label for="general_notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Umum</label>
                <textarea id="general_notes" name="general_notes" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                          placeholder="Catatan umum tentang riwayat mutasi pegawai">{{ old('general_notes') }}</textarea>
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
                    class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                <i class="fas fa-save mr-2"></i>
                Simpan Riwayat Mutasi
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let historyIndex = 1;
    
    // Add new history item
    document.getElementById('add-history-item').addEventListener('click', function() {
        const container = document.getElementById('transfer-history-container');
        const newItem = createHistoryItem(historyIndex);
        container.appendChild(newItem);
        historyIndex++;
        updateTotalMutations();
        updateRemoveButtons();
    });
    
    // Remove history item
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-history-item')) {
            e.target.closest('.transfer-history-item').remove();
            updateTotalMutations();
            updateRemoveButtons();
        }
    });
    
    function createHistoryItem(index) {
        const div = document.createElement('div');
        div.className = 'transfer-history-item border border-gray-200 rounded-lg p-4 mb-4';
        div.innerHTML = `
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-lg font-medium text-gray-800">Riwayat Mutasi #${index + 1}</h3>
                <button type="button" class="remove-history-item text-red-600 hover:text-red-800">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dari Unit Kerja *</label>
                    <input type="text" name="history[${index}][from_unit]" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Unit kerja asal">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ke Unit Kerja *</label>
                    <input type="text" name="history[${index}][to_unit]" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Unit kerja tujuan">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mutasi *</label>
                    <input type="date" name="history[${index}][transfer_date]" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor SK</label>
                    <input type="text" name="history[${index}][sk_number]" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Nomor Surat Keputusan">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan Sebelumnya</label>
                    <input type="text" name="history[${index}][position_before]" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Jabatan sebelum mutasi">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan Setelahnya</label>
                    <input type="text" name="history[${index}][position_after]" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Jabatan setelah mutasi">
                </div>
            </div>
            
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Mutasi</label>
                <textarea name="history[${index}][reason]" rows="2" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                          placeholder="Alasan dilakukan mutasi"></textarea>
            </div>
        `;
        return div;
    }
    
    function updateTotalMutations() {
        const totalItems = document.querySelectorAll('.transfer-history-item').length;
        document.getElementById('total_mutations').value = totalItems;
    }
    
    function updateRemoveButtons() {
        const items = document.querySelectorAll('.transfer-history-item');
        const removeButtons = document.querySelectorAll('.remove-history-item');
        
        removeButtons.forEach(button => {
            button.classList.toggle('hidden', items.length <= 1);
        });
    }
    
    // Initialize
    updateRemoveButtons();
});
</script>
@endsection
