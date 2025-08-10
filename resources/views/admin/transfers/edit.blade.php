@extends('layout.admin')

@section('title', 'Edit Mutasi - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.transfers') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Edit Mutasi</h1>
                <p class="text-gray-600">Edit data mutasi {{ $transfer->employee->name }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.transfers.update', $transfer) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Employee Field -->
                    <div>
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
                                <option value="{{ $employee->id }}" {{ old('employee_id', $transfer->employee_id) == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }} ({{ $employee->username }})
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- From Village Field -->
                    <div>
                        <label for="from_village_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>Dari Desa
                        </label>
                        <select 
                            id="from_village_id" 
                            name="from_village_id" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                        >
                            <option value="">Pilih Desa Asal</option>
                            @foreach($villages as $village)
                                <option value="{{ $village->id }}" {{ old('from_village_id', $transfer->from_village_id) == $village->id ? 'selected' : '' }}>
                                    {{ $village->name }} - {{ $village->district }}
                                </option>
                            @endforeach
                        </select>
                        @error('from_village_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- To Village Field -->
                    <div>
                        <label for="to_village_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>Ke Desa
                        </label>
                        <select 
                            id="to_village_id" 
                            name="to_village_id" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                        >
                            <option value="">Pilih Desa Tujuan</option>
                            @foreach($villages as $village)
                                <option value="{{ $village->id }}" {{ old('to_village_id', $transfer->to_village_id) == $village->id ? 'selected' : '' }}>
                                    {{ $village->name }} - {{ $village->district }}
                                </option>
                            @endforeach
                        </select>
                        @error('to_village_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Transfer Date Field -->
                    <div>
                        <label for="transfer_date" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-2 text-blue-600"></i>Tanggal Mutasi
                        </label>
                        <input 
                            type="date" 
                            id="transfer_date" 
                            name="transfer_date" 
                            value="{{ old('transfer_date', $transfer->transfer_date->format('Y-m-d')) }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                        >
                        @error('transfer_date')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Effective Date Field -->
                    <div>
                        <label for="effective_date" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar-check mr-2 text-blue-600"></i>Tanggal Efektif
                        </label>
                        <input 
                            type="date" 
                            id="effective_date" 
                            name="effective_date" 
                            value="{{ old('effective_date', $transfer->effective_date->format('Y-m-d')) }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                        >
                        @error('effective_date')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reason Field -->
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-clipboard-list mr-2 text-blue-600"></i>Alasan Mutasi
                        </label>
                        <textarea 
                            id="reason" 
                            name="reason" 
                            rows="3"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan alasan mutasi"
                        >{{ old('reason', $transfer->reason) }}</textarea>
                        @error('reason')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes Field -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sticky-note mr-2 text-blue-600"></i>Catatan (Opsional)
                        </label>
                        <textarea 
                            id="notes" 
                            name="notes" 
                            rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                            placeholder="Masukkan catatan tambahan"
                        >{{ old('notes', $transfer->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Field -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-flag mr-2 text-blue-600"></i>Status
                        </label>
                        <select 
                            id="status" 
                            name="status" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300"
                        >
                            <option value="">Pilih Status</option>
                            <option value="pending" {{ old('status', $transfer->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status', $transfer->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status', $transfer->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="completed" {{ old('status', $transfer->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Transfer Info -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Informasi Mutasi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Dibuat:</span>
                                <span class="ml-2 text-gray-700">{{ $transfer->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Terakhir diupdate:</span>
                                <span class="ml-2 text-gray-700">{{ $transfer->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                        <a href="{{ route('admin.transfers') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                        <button 
                            type="submit" 
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Update Mutasi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
