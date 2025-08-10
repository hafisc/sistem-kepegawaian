@extends('layout.admin')

@section('title', 'Edit Pendidikan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <a href="{{ route('admin.education.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="text-xl font-semibold text-gray-800">Edit Pendidikan: {{ $education->name }}</h2>
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

            <form action="{{ route('admin.education.update', $education) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Pendidikan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $education->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Contoh: Universitas Indonesia"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Nama institusi atau jenjang pendidikan</p>
                    </div>

                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 mb-2">
                            Tingkat Pendidikan <span class="text-red-500">*</span>
                        </label>
                        <select id="level" 
                                name="level" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                            <option value="">Pilih Tingkat Pendidikan</option>
                            @foreach(\App\Models\Education::LEVELS as $key => $value)
                                <option value="{{ $key }}" {{ old('level', $education->level) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Deskripsi tambahan tentang pendidikan ini...">{{ old('description', $education->description) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Opsional: Informasi tambahan tentang pendidikan</p>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', $education->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Status Aktif</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1">Centang untuk mengaktifkan pendidikan ini</p>
                </div>

                @if($education->users_count > 0)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Pendidikan ini digunakan oleh <strong>{{ $education->users_count }} pegawai</strong>. 
                                       Perubahan akan mempengaruhi data pegawai tersebut.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.education.index') }}" 
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
