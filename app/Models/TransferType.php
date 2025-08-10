<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'requires_approval',
        'is_active'
    ];

    protected $casts = [
        'requires_approval' => 'boolean',
        'is_active' => 'boolean'
    ];

    /**
     * Transfer types
     */
    const TYPES = [
        'MUTASI_BIASA' => 'Mutasi Biasa',
        'MUTASI_PROMOSI' => 'Mutasi Promosi',
        'MUTASI_DEMOSI' => 'Mutasi Demosi',
        'MUTASI_ROTASI' => 'Mutasi Rotasi',
        'MUTASI_PINDAH_TUGAS' => 'Pindah Tugas',
        'MUTASI_PENSIUN' => 'Pensiun',
        'MUTASI_PENUGASAN_KHUSUS' => 'Penugasan Khusus'
    ];

    /**
     * Get transfers with this type
     */
    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'transfer_type_id');
    }

    /**
     * Scope for active transfer types
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for types requiring approval
     */
    public function scopeRequiresApproval($query)
    {
        return $query->where('requires_approval', true);
    }
}
