@extends('layout.admin')

@section('title', 'Kelola Golongan - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Kelola Golongan</h1>
                <p class="text-gray-600">Manajemen golongan pegawai dalam sistem kepegawaian</p>
            </div>
            <button onclick="openModal('addModal')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Tambah Golongan
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('admin.grades.index') }}" class="flex items-center space-x-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                       placeholder="Cari golongan...">
            </div>
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-search mr-2"></i>
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.grades.index') }}" 
                   class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-times mr-1"></i>
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Grades Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Golongan Pegawai</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kode Golongan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Golongan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Deskripsi
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($grades as $index => $grade)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $grade->code }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $grade->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $grade->description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $grade->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $grade->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button onclick="editGrade({{ $grade->id }}, '{{ $grade->code }}', '{{ $grade->name }}', '{{ $grade->description }}', {{ $grade->is_active ? 'true' : 'false' }})" 
                                            class="text-blue-600 hover:text-blue-900 transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus golongan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition-colors" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                <i class="fas fa-layer-group text-4xl mb-2"></i>
                                <p>Belum ada data golongan yang terdaftar</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Tambah Golongan Baru</h3>
                <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addForm" method="POST" action="{{ route('admin.grades.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="add_code" class="block text-sm font-medium text-gray-700 mb-2">Kode Golongan</label>
                    <input type="text" id="add_code" name="code" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Contoh: IV/f">
                </div>
                <div>
                    <label for="add_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Golongan</label>
                    <input type="text" id="add_name" name="name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Contoh: Golongan IV/f">
                </div>
                <div>
                    <label for="add_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <input type="text" id="add_description" name="description" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Contoh: Pembina Utama Tinggi">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="add_is_active" name="is_active" value="1" checked 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="add_is_active" class="ml-2 block text-sm text-gray-700">Aktif</label>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal('addModal')" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg">
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Edit Golongan</h3>
                <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_grade_id" name="grade_id">
                <div>
                    <label for="edit_code" class="block text-sm font-medium text-gray-700 mb-2">Kode Golongan</label>
                    <input type="text" id="edit_code" name="code" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Golongan</label>
                    <input type="text" id="edit_name" name="name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <input type="text" id="edit_description" name="description" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="edit_is_active" class="ml-2 block text-sm text-gray-700">Aktif</label>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal('editModal')" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg">
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

function editGrade(id, code, name, description, active) {
    document.getElementById('edit_grade_id').value = id;
    document.getElementById('edit_code').value = code;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_is_active').checked = active;
    document.getElementById('editForm').action = '/admin/grades/' + id;
    openModal('editModal');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const addModal = document.getElementById('addModal');
    const editModal = document.getElementById('editModal');
    if (event.target == addModal) {
        closeModal('addModal');
    }
    if (event.target == editModal) {
        closeModal('editModal');
    }
}
</script>
@endsection
