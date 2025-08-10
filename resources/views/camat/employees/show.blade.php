@extends('layout.camat')

@section('title', 'Detail Pegawai')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('camat.employees') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="text-xl font-semibold text-gray-800">Detail Pegawai: {{ $employee->name }}</h2>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('camat.employees.edit', $employee) }}" 
                       class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Photo and Basic Info -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="text-center">
                            <div class="w-32 h-32 mx-auto bg-gray-300 rounded-full overflow-hidden mb-4">
                                @if($employee->photo_url)
                                    <img src="{{ $employee->photo_url }}" alt="{{ $employee->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">{{ $employee->name }}</h3>
                            <p class="text-gray-600">{{ $employee->position ?? 'Tidak ada jabatan' }}</p>
                            <div class="mt-4">
                                @if($employee->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>Tidak Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Information -->
                <div class="lg:col-span-2">
                    <div class="space-y-6">
                        <!-- Personal Information -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Pribadi</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">NIP</label>
                                    <p class="text-sm text-gray-900">{{ $employee->nip ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">NIK</label>
                                    <p class="text-sm text-gray-900">{{ $employee->nik ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Jenis Kelamin</label>
                                    <p class="text-sm text-gray-900">{{ $employee->gender == 'L' ? 'Laki-laki' : ($employee->gender == 'P' ? 'Perempuan' : '-') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</label>
                                    <p class="text-sm text-gray-900">
                                        {{ $employee->place_of_birth ?? '-' }}{{ $employee->date_of_birth ? ', ' . $employee->date_of_birth->format('d/m/Y') : '' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Agama</label>
                                    <p class="text-sm text-gray-900">{{ $employee->religion ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Status Pernikahan</label>
                                    <p class="text-sm text-gray-900">{{ $employee->marital_status ?? '-' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500">Alamat</label>
                                    <p class="text-sm text-gray-900">{{ $employee->address ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Telepon</label>
                                    <p class="text-sm text-gray-900">{{ $employee->phone ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Umur</label>
                                    <p class="text-sm text-gray-900">{{ $employee->age ?? '-' }} tahun</p>
                                </div>
                            </div>
                        </div>

                        <!-- Employment Information -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Kepegawaian</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Jabatan</label>
                                    <p class="text-sm text-gray-900">{{ $employee->position ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Pangkat</label>
                                    <p class="text-sm text-gray-900">{{ $employee->rank ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Golongan</label>
                                    <p class="text-sm text-gray-900">{{ $employee->grade ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Desa Penugasan</label>
                                    <p class="text-sm text-gray-900">{{ $employee->village->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Masa Kerja</label>
                                    <p class="text-sm text-gray-900">{{ $employee->years_of_service ?? '-' }} tahun</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Status Kepegawaian</label>
                                    <p class="text-sm text-gray-900">{{ $employee->employment_status ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Dokumen</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($employee->sk_file)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <label class="block text-sm font-medium text-gray-500 mb-2">SK Dokumen</label>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ $employee->sk_file_url }}" 
                                               target="_blank"
                                               class="inline-flex items-center px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                                                <i class="fas fa-download mr-2"></i>Lihat SK
                                            </a>
                                            @if(in_array(pathinfo($employee->sk_file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                <button type="button" 
                                                        onclick="showImageModal('{{ $employee->sk_file_url }}', 'SK - {{ $employee->name }}')"
                                                        class="inline-flex items-center px-3 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200">
                                                    <i class="fas fa-eye mr-2"></i>Preview
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal for SK Preview -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg max-w-4xl max-h-full overflow-auto">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 id="modalTitle" class="text-lg font-semibold"></h3>
            <button onclick="closeImageModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-4">
            <img id="modalImage" src="" alt="" class="max-w-full h-auto">
        </div>
    </div>
</div>

@push('scripts')
<script>
function showImageModal(imageUrl, title) {
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>
@endpush
@endsection
