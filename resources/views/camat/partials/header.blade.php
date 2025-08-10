<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center">
                <h1 class="text-xl font-semibold text-gray-900">@yield('title', 'Dashboard')</h1>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Notification Bell -->
                <div class="relative">
                    <button id="notification-bell" 
                            class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
                        <i class="fas fa-bell text-lg"></i>
                        <span id="notification-badge" 
                              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">
                            0
                        </span>
                    </button>
                    
                    <!-- Notification Dropdown -->
                    <div id="notification-dropdown" 
                         class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 hidden z-50">
                        <div class="py-1">
                            <div class="px-4 py-2 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-sm font-medium text-gray-900">Notifikasi</h3>
                                    <button id="mark-all-read" class="text-xs text-blue-600 hover:text-blue-800">
                                        Tandai Semua Dibaca
                                    </button>
                                </div>
                            </div>
                            <div id="notification-list" class="max-h-64 overflow-y-auto">
                                <!-- Notifications will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="flex items-center">
                    <div class="flex items-center space-x-3">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Camat</p>
                        </div>
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-tie text-white text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
