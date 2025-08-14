@extends('layout.admin')

@section('title', 'Kelola Agama - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Kelola Agama</h1>
                <p class="text-gray-600">Manajemen data agama dalam sistem kepegawaian</p>
            </div>
            <button onclick="openModal('addModal')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Tambah Agama
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

    <!-- Religions Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Agama</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Agama
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Keterangan
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
                    @forelse($religions as $religion)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $religion->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-pray text-blue-600"></i>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ $religion->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $religion->description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $religion->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $religion->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button onclick="editReligion({{ $religion->id }}, '{{ $religion->name }}', '{{ $religion->description }}', {{ $religion->is_active ? 'true' : 'false' }})" 
                                            class="text-blue-600 hover:text-blue-900 transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.religions.destroy', $religion) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agama ini?')">
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
                                <i class="fas fa-pray text-4xl mb-2"></i>
                                <p>Belum ada data agama yang terdaftar</p>
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
                <h3 class="text-lg font-medium text-gray-900">Tambah Agama Baru</h3>
                <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addForm" method="POST" action="#" class="space-y-4">
                @csrf
                <div>
                    <label for="add_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Agama</label>
                    <input type="text" id="add_name" name="name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Contoh: Bahai">
                </div>
                <div>
                    <label for="add_description" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                    <textarea id="add_description" name="description" required 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                              placeholder="Deskripsi agama..." rows="3"></textarea>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="add_active" name="active" value="1" checked 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="add_active" class="ml-2 block text-sm text-gray-700">Aktif</label>
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
                <h3 class="text-lg font-medium text-gray-900">Edit Agama</h3>
                <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editForm" method="POST" action="#" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">
                <div>
                    <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Agama</label>
                    <input type="text" id="edit_name" name="name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                    <textarea id="edit_description" name="description" required 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                              rows="3"></textarea>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="edit_active" name="active" value="1" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="edit_active" class="ml-2 block text-sm text-gray-700">Aktif</label>
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

function editReligion(id, name, description, active) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_active').checked = active;
    openModal('editModal');
}

function toggleStatus(id, newStatus) {
    if (confirm('Apakah Anda yakin ingin mengubah status agama ini?')) {
        alert('Status agama ID ' + id + ' akan diubah menjadi ' + (newStatus ? 'Aktif' : 'Nonaktif'));
    }
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
