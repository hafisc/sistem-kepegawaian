<!-- Top Header -->
<header class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                
                
                <!-- Mobile menu button -->
                <button type="button" class="ml-4 md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Notification Bell -->
                <div class="relative">
                    <button type="button" class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-full transition-colors" onclick="toggleNotifications()">
                        <i class="fas fa-bell text-lg"></i>
                        <span id="notification-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
                    </button>
                    
                    <!-- Notification Dropdown -->
                    <div id="notification-dropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                        <div class="p-4 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-800">Notifikasi</h3>
                                <button onclick="markAllAsRead()" class="text-sm text-blue-600 hover:text-blue-800">Tandai Semua Dibaca</button>
                            </div>
                        </div>
                        <div id="notification-list" class="max-h-96 overflow-y-auto">
                            <div class="p-4 text-center text-gray-500">
                                <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                <p>Tidak ada notifikasi</p>
                            </div>
                        </div>
                        <div class="p-3 border-t border-gray-200">
                            <a href="{{ route('user.notifications') }}" class="block text-center text-sm text-blue-600 hover:text-blue-800">Lihat Semua Notifikasi</a>
                        </div>
                    </div>
                </div>

                <!-- User Info -->
                <span class="text-sm text-gray-700">
                    <i class="fas fa-user mr-1"></i>
                    {{ Auth::user()->name }}
                </span>
            </div>
        </div>
    </div>
</header>