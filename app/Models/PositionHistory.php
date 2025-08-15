<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionHistory extends Model
{
    /** @use HasFactory<\Database\Factories\PositionHistoryFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position_name',
        'position_level',
        'unit_kerja',
        'start_date',
        'end_date',
        'sk_number',
        'sk_date',
        'description',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'sk_date' => 'date',
        ];
    }

    /**
     * Get the user that owns the position history
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for active positions
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope for completed positions
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'selesai');
    }
}
