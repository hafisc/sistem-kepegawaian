@extends('layout.admin')

@section('title', 'Tambah Desa - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.villages') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Tambah Desa Baru</h1>
                <p class="text-gray-600">Tambahkan data desa baru ke dalam sistem</p>
            </div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.villages.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>Nama Desa
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan nama desa"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Code Field -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-barcode mr-2 text-blue-600"></i>Kode Desa
                        </label>
                        <input 
                            type="text" 
                            id="code" 
                            name="code" 
                            value="{{ old('code') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan kode desa"
                        >
                        @error('code')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- District Field -->
                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-building mr-2 text-blue-600"></i>Kecamatan
                        </label>
                        <input 
                            type="text" 
                            id="district" 
                            name="district" 
                            value="{{ old('district') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan nama kecamatan"
                        >
                        @error('district')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Regency Field -->
                    <div>
                        <label for="regency" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-city mr-2 text-blue-600"></i>Kabupaten/Kota
                        </label>
                        <input 
                            type="text" 
                            id="regency" 
                            name="regency" 
                            value="{{ old('regency') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan nama kabupaten/kota"
                        >
                        @error('regency')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Province Field -->
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-flag mr-2 text-blue-600"></i>Provinsi
                        </label>
                        <input 
                            type="text" 
                            id="province" 
                            name="province" 
                            value="{{ old('province') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan nama provinsi"
                        >
                        @error('province')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Postal Code Field -->
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-mail-bulk mr-2 text-blue-600"></i>Kode Pos (Opsional)
                        </label>
                        <input 
                            type="text" 
                            id="postal_code" 
                            name="postal_code" 
                            value="{{ old('postal_code') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan kode pos"
                        >
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-file-alt mr-2 text-blue-600"></i>Deskripsi (Opsional)
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan deskripsi desa"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Field -->
                    <div>
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="is_active" 
                                value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                            >
                            <span class="ml-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-600 mr-1"></i>
                                Desa aktif
                            </span>
                        </label>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                        <a href="{{ route('admin.villages') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                        <button 
                            type="submit" 
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Simpan Desa
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
