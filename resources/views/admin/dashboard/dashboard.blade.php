@extends('layout.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        {{-- <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1> --}}
        <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Pegawai -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Total Pegawai</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalPegawai ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Pegawai Aktif -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-user-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Pegawai Aktif</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $pegawaiAktif ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Pegawai Non-Aktif -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-user-times text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Pegawai Non-Aktif</h3>
                    <p class="text-2xl font-bold text-red-600">{{ $pegawaiNonAktif ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- PNS -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-id-badge text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">PNS</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ $pns ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- PPPK -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-user-tie text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">PPPK</h3>
                    <p class="text-2xl font-bold text-orange-600">{{ $pppk ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- NON ASN -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gray-100 text-gray-600">
                    <i class="fas fa-user-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">NON ASN</h3>
                    <p class="text-2xl font-bold text-gray-600">{{ $nonAsn ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

   
    
</div>
@endsection