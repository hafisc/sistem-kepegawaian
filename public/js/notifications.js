// Notification System JavaScript

let notificationDropdown = null;
let notificationBadge = null;
let notificationList = null;

document.addEventListener('DOMContentLoaded', function() {
    notificationDropdown = document.getElementById('notification-dropdown');
    notificationBadge = document.getElementById('notification-badge');
    notificationList = document.getElementById('notification-list');
    
    // Load notifications on page load
    loadNotifications();
    
    // Auto-refresh notifications every 30 seconds
    setInterval(loadNotifications, 30000);
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const notificationContainer = event.target.closest('.relative');
        if (!notificationContainer && notificationDropdown && !notificationDropdown.classList.contains('hidden')) {
            notificationDropdown.classList.add('hidden');
        }
    });
});

function toggleNotifications() {
    if (notificationDropdown) {
        notificationDropdown.classList.toggle('hidden');
        if (!notificationDropdown.classList.contains('hidden')) {
            loadNotifications();
        }
    }
}

function loadNotifications() {
    fetch('/notifications/recent')
        .then(response => response.json())
        .then(data => {
            updateNotificationBadge(data.unread_count);
            updateNotificationList(data.notifications);
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
        });
}

function updateNotificationBadge(count) {
    if (notificationBadge) {
        if (count > 0) {
            notificationBadge.textContent = count > 99 ? '99+' : count;
            notificationBadge.classList.remove('hidden');
        } else {
            notificationBadge.classList.add('hidden');
        }
    }
}

function updateNotificationList(notifications) {
    if (!notificationList) return;
    
    if (notifications.length === 0) {
        notificationList.innerHTML = `
            <div class="p-4 text-center text-gray-500">
                <i class="fas fa-bell-slash text-2xl mb-2"></i>
                <p>Tidak ada notifikasi</p>
            </div>
        `;
        return;
    }
    
    let html = '';
    notifications.forEach(notification => {
        const isUnread = !notification.read_at;
        const timeAgo = formatTimeAgo(notification.created_at);
        
        html += `
            <div class="notification-item border-b border-gray-100 p-3 hover:bg-gray-50 cursor-pointer ${isUnread ? 'bg-blue-50' : ''}" 
                 onclick="markNotificationAsRead(${notification.id}, '${notification.action_url || ''}')">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <i class="${getNotificationIcon(notification.type)} ${getNotificationColor(notification.type)}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 ${isUnread ? 'font-semibold' : ''}">${notification.title}</p>
                        <p class="text-sm text-gray-600">${notification.message}</p>
                        <p class="text-xs text-gray-500 mt-1">${timeAgo}</p>
                    </div>
                    ${isUnread ? '<div class="flex-shrink-0"><div class="w-2 h-2 bg-blue-500 rounded-full"></div></div>' : ''}
                </div>
            </div>
        `;
    });
    
    notificationList.innerHTML = html;
}

function getNotificationIcon(type) {
    const icons = {
        'success': 'fas fa-check-circle',
        'error': 'fas fa-exclamation-triangle',
        'warning': 'fas fa-exclamation-circle',
        'info': 'fas fa-info-circle',
        'user_created': 'fas fa-user-plus',
        'user_updated': 'fas fa-user-edit',
        'user_deleted': 'fas fa-user-minus',
        'village_created': 'fas fa-map-marker-alt',
        'village_updated': 'fas fa-edit',
        'village_deleted': 'fas fa-trash',
        'transfer_created': 'fas fa-exchange-alt',
        'transfer_updated': 'fas fa-edit',
        'transfer_deleted': 'fas fa-trash',
        'system': 'fas fa-cog'
    };
    return icons[type] || 'fas fa-bell';
}

function getNotificationColor(type) {
    const colors = {
        'success': 'text-green-600',
        'error': 'text-red-600',
        'warning': 'text-yellow-600',
        'info': 'text-blue-600',
        'user_created': 'text-blue-600',
        'user_updated': 'text-blue-600',
        'user_deleted': 'text-blue-600',
        'village_created': 'text-green-600',
        'village_updated': 'text-green-600',
        'village_deleted': 'text-green-600',
        'transfer_created': 'text-orange-600',
        'transfer_updated': 'text-orange-600',
        'transfer_deleted': 'text-orange-600',
        'system': 'text-purple-600'
    };
    return colors[type] || 'text-gray-600';
}

function formatTimeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffInSeconds = Math.floor((now - date) / 1000);
    
    if (diffInSeconds < 60) {
        return 'Baru saja';
    } else if (diffInSeconds < 3600) {
        const minutes = Math.floor(diffInSeconds / 60);
        return `${minutes} menit yang lalu`;
    } else if (diffInSeconds < 86400) {
        const hours = Math.floor(diffInSeconds / 3600);
        return `${hours} jam yang lalu`;
    } else {
        const days = Math.floor(diffInSeconds / 86400);
        return `${days} hari yang lalu`;
    }
}

function markNotificationAsRead(notificationId, actionUrl) {
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadNotifications(); // Refresh notifications
            if (actionUrl && actionUrl !== 'null' && actionUrl !== '') {
                window.location.href = actionUrl;
            }
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

function markAllAsRead() {
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadNotifications(); // Refresh notifications
            showToast('Semua notifikasi telah ditandai sebagai dibaca', 'success');
        }
    })
    .catch(error => {
        console.error('Error marking all notifications as read:', error);
    });
}

function showToast(message, type = 'info') {
    // Create toast notification
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white max-w-sm transform transition-all duration-300 translate-x-full`;
    
    const bgColor = type === 'success' ? 'bg-green-500' : 
                   type === 'error' ? 'bg-red-500' : 
                   type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';
    
    toast.classList.add(bgColor);
    toast.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}

// Function to create notification (called from other parts of the app)
function createNotification(title, message, type = 'info') {
    fetch('/notifications/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            title: title,
            message: message,
            type: type
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadNotifications(); // Refresh notifications
        }
    })
    .catch(error => {
        console.error('Error creating notification:', error);
    });
}
