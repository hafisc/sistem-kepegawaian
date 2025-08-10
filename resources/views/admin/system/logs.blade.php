@extends('layout.admin')

@section('title', 'Log Sistem - Pengaturan Sistem')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.system') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Log Sistem</h1>
                <p class="text-gray-600">Monitor aktivitas dan error sistem</p>
            </div>
        </div>
    </div>

    <!-- Log Display -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Log Terbaru (100 baris terakhir)</h2>
                <div class="flex space-x-2">
                    <button onclick="refreshLogs()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Refresh
                    </button>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            @if(count($logs) > 0)
                <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto" style="max-height: 600px;">
                    <pre class="text-green-400 text-sm font-mono whitespace-pre-wrap">@foreach($logs as $log){{ $log }}
@endforeach</pre>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-file-alt text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">Tidak Ada Log</h3>
                    <p class="text-gray-500">File log tidak ditemukan atau kosong</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Log Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Error</h3>
                    <p class="text-2xl font-bold text-red-600">{{ collect($logs)->filter(function($log) { return str_contains(strtolower($log), 'error'); })->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Warning</h3>
                    <p class="text-2xl font-bold text-yellow-600">{{ collect($logs)->filter(function($log) { return str_contains(strtolower($log), 'warning'); })->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-info-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Info</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ collect($logs)->filter(function($log) { return str_contains(strtolower($log), 'info'); })->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gray-100 text-gray-600">
                    <i class="fas fa-list text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Total</h3>
                    <p class="text-2xl font-bold text-gray-600">{{ count($logs) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function refreshLogs() {
    window.location.reload();
}
</script>
@endsection
