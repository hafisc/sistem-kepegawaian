<div class="bg-gray-800 text-white w-64 flex-shrink-0">
    <div class="p-4">
        <div class="flex items-center">
            <i class="fas fa-building text-2xl text-blue-400"></i>
            <div class="ml-3">
                <h1 class="text-lg font-semibold">Sistem Kepegawaian</h1>
                <p class="text-xs text-gray-300">Panel Camat</p>
            </div>
        </div>
    </div>
    
    <nav class="mt-8">
        <div class="px-4 py-2">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</p>
        </div>
        
        <a href="{{ route('camat.dashboard') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200 {{ request()->routeIs('camat.dashboard') ? 'bg-gray-700 text-white border-r-4 border-blue-500' : '' }}">
            <i class="fas fa-tachometer-alt w-5"></i>
            <span class="ml-3">Dashboard</span>
        </a>
        
        <a href="{{ route('camat.employees') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200 {{ request()->routeIs('camat.employees.*') ? 'bg-gray-700 text-white border-r-4 border-blue-500' : '' }}">
            <i class="fas fa-users w-5"></i>
            <span class="ml-3">Manajemen Pegawai</span>
        </a>
        
        <a href="{{ route('camat.villages') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200 {{ request()->routeIs('camat.villages.*') ? 'bg-gray-700 text-white border-r-4 border-blue-500' : '' }}">
            <i class="fas fa-map-marker-alt w-5"></i>
            <span class="ml-3">Manajemen Desa</span>
        </a>
        
        <a href="{{ route('camat.transfers') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200 {{ request()->routeIs('camat.transfers.*') ? 'bg-gray-700 text-white border-r-4 border-blue-500' : '' }}">
            <i class="fas fa-exchange-alt w-5"></i>
            <span class="ml-3">Manajemen Transfer</span>
        </a>
        
        <div class="px-4 py-2 mt-6">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Laporan</p>
        </div>
        
        <a href="{{ route('camat.reports') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200 {{ request()->routeIs('camat.reports.*') ? 'bg-gray-700 text-white border-r-4 border-blue-500' : '' }}">
            <i class="fas fa-chart-bar w-5"></i>
            <span class="ml-3">Laporan</span>
        </a>
        
        <div class="px-4 py-2 mt-6">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Akun</p>
        </div>
        
        <a href="#" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200">
            <i class="fas fa-user w-5"></i>
            <span class="ml-3">Profil</span>
        </a>
        
        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" 
                    class="flex items-center w-full px-4 py-3 text-gray-300 hover:bg-red-600 hover:text-white transition duration-200">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span class="ml-3">Logout</span>
            </button>
        </form>
    </nav>
</div>
