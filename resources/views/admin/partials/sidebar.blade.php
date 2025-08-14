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
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-500' : '' }}">
                <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.users*') ? 'bg-blue-100 text-blue-700 border-r-4 border-blue-500' : '' }}">
                <i class="fas fa-users w-5 h-5 mr-3"></i>
                <span class="font-medium">Kelola Pegawai</span>
            </a>

            <a href="{{ route('admin.mutasi.index') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.mutasi*') ? 'bg-blue-100 text-blue-700' : '' }}">
                <i class="fas fa-exchange-alt w-5 h-5 mr-3"></i>
                <span class="font-medium">Detail Mutasi</span>
            </a>

            <!-- Pengaturan Admin Dropdown -->
            <div class="relative">
                <button type="button" onclick="toggleDropdown('admin-settings')" class="w-full flex items-center justify-between px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.users*') || request()->routeIs('admin.villages*') || request()->routeIs('admin.education*') || request()->routeIs('admin.system*') ? 'bg-blue-100 text-blue-700' : '' }}">
                    <div class="flex items-center">
                        <i class="fas fa-cogs w-5 h-5 mr-3"></i>
                        <span class="font-medium">Pengaturan Admin</span>
                    </div>
                    <i class="fas fa-chevron-down w-4 h-4 transition-transform duration-200" id="admin-settings-icon"></i>
                </button>
                
                <div id="admin-settings" class="hidden mt-2 ml-4 space-y-1 border-l-2 border-gray-200 pl-4">
                    <a href="{{ route('admin.users') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.users*') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-user-cog w-4 h-4 mr-2"></i>
                        <span>Kelola User</span>
                    </a>
                    
                    <a href="{{ route('admin.villages') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.villages*') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-map-marker-alt w-4 h-4 mr-2"></i>
                        <span>Kelola Penempatan</span>
                    </a>
                    
                    <a href="{{ route('admin.education.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.education*') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-graduation-cap w-4 h-4 mr-2"></i>
                        <span>Kelola Pendidikan</span>
                    </a>
                    
                    <a href="{{ route('admin.grades.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.grades*') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-layer-group w-4 h-4 mr-2"></i>
                        <span>Kelola Golongan</span>
                    </a>
                    
                    <a href="{{ route('admin.ranks.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.ranks*') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-star w-4 h-4 mr-2"></i>
                        <span>Kelola Pangkat</span>
                    </a>
                    
                    <a href="{{ route('admin.religions.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.religions*') ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-pray w-4 h-4 mr-2"></i>
                        <span>Kelola Agama</span>
                    </a>
                </div>
            </div>
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

<script>
function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const icon = document.getElementById(dropdownId + '-icon');
    
    if (dropdown.classList.contains('hidden')) {
        dropdown.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        dropdown.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}
</script>