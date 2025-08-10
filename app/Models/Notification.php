<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'data',
        'read_at',
        'action_url'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Check if notification is read.
     */
    public function isRead()
    {
        return !is_null($this->read_at);
    }

    /**
     * Check if notification is unread.
     */
    public function isUnread()
    {
        return is_null($this->read_at);
    }

    /**
     * Get notification icon based on type.
     */
    public function getIconAttribute()
    {
        return match($this->type) {
            'success' => 'fas fa-check-circle',
            'error' => 'fas fa-exclamation-triangle',
            'warning' => 'fas fa-exclamation-circle',
            'info' => 'fas fa-info-circle',
            'user_created' => 'fas fa-user-plus',
            'user_updated' => 'fas fa-user-edit',
            'user_deleted' => 'fas fa-user-minus',
            'village_created' => 'fas fa-map-marker-alt',
            'village_updated' => 'fas fa-edit',
            'village_deleted' => 'fas fa-trash',
            'transfer_created' => 'fas fa-exchange-alt',
            'transfer_updated' => 'fas fa-edit',
            'transfer_deleted' => 'fas fa-trash',
            'system' => 'fas fa-cog',
            default => 'fas fa-bell'
        };
    }

    /**
     * Get notification color based on type.
     */
    public function getColorAttribute()
    {
        return match($this->type) {
            'success' => 'text-green-600',
            'error' => 'text-red-600',
            'warning' => 'text-yellow-600',
            'info' => 'text-blue-600',
            'user_created', 'user_updated', 'user_deleted' => 'text-blue-600',
            'village_created', 'village_updated', 'village_deleted' => 'text-green-600',
            'transfer_created', 'transfer_updated', 'transfer_deleted' => 'text-orange-600',
            'system' => 'text-purple-600',
            default => 'text-gray-600'
        };
    }

    /**
     * Get time ago format.
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Scope for unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope for read notifications.
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope for recent notifications.
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($days));
    }
}
