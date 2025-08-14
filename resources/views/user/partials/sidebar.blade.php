<!-- Sidebar -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:static md:inset-0">
    <div class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between h-16 px-4 border-b bg-blue-50">
            <span class="text-lg font-semibold text-blue-800">Sistem Kepegawaian</span>
            <button type="button" class="md:hidden text-gray-500 hover:text-gray-700" onclick="toggleSidebar()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('user.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('user.dashboard') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-500' : '' }}">
                <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('user.employees') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('user.employees') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-500' : '' }}">
                <i class="fas fa-users w-5 h-5 mr-3"></i>
                <span class="font-medium">Data Pegawai</span>
            </a>

            <a href="{{ route('user.transfers') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('user.transfers') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-500' : '' }}">
                <i class="fas fa-exchange-alt w-5 h-5 mr-3"></i>
                <span class="font-medium">Data Mutasi</span>
            </a>
        </nav>

        <!-- Logout Button - Fixed at Bottom -->
        <div class="px-4 pb-4">
            <div class="border-t border-gray-200 pt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 rounded-lg hover:bg-red-50 hover:text-red-700 transition-colors">
                        <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        
        
    </div>
</aside>

<!-- Sidebar Overlay for Mobile -->
<div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden hidden" onclick="toggleSidebar()"></div>