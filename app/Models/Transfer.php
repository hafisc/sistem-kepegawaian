<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'from_village_id',
        'to_village_id',
        'from_unit',
        'to_unit',
        'transfer_date',
        'effective_date',
        'sk_number',
        'sk_date',
        'position_before',
        'position_after',
        'reason',
        'notes',
        'status',
        'transfer_type',
        'sk_file',
        'supporting_docs',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'transfer_date' => 'date',
        'effective_date' => 'date',
        'sk_date' => 'date',
    ];

    /**
     * Get the employee that owns the transfer.
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Get the village where the employee is transferred from.
     */
    public function fromVillage()
    {
        return $this->belongsTo(Village::class, 'from_village_id');
    }

    /**
     * Get the village where the employee is transferred to.
     */
    public function toVillage()
    {
        return $this->belongsTo(Village::class, 'to_village_id');
    }

    /**
     * Check if transfer is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if transfer is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if transfer is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if transfer is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Scope a query to only include pending transfers.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved transfers.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include completed transfers.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'completed' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status icon.
     */
    public function getStatusIconAttribute(): string
    {
        return match($this->status) {
            'pending' => 'fa-clock',
            'approved' => 'fa-check-circle',
            'rejected' => 'fa-times-circle',
            'completed' => 'fa-flag-checkered',
            default => 'fa-question-circle',
        };
    }
}
