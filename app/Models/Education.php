<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';

    protected $fillable = [
        'name',
        'level',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Education levels
     */
    const LEVELS = [
        'SD' => 'Sekolah Dasar',
        'SMP' => 'Sekolah Menengah Pertama', 
        'SMA' => 'Sekolah Menengah Atas',
        'SMK' => 'Sekolah Menengah Kejuruan',
        'D1' => 'Diploma 1',
        'D2' => 'Diploma 2',
        'D3' => 'Diploma 3',
        'D4' => 'Diploma 4',
        'S1' => 'Sarjana (S1)',
        'S2' => 'Magister (S2)',
        'S3' => 'Doktor (S3)'
    ];

    /**
     * Get users with this education
     */
    public function users()
    {
        return $this->hasMany(User::class, 'education_id');
    }

    /**
     * Scope for active educations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get level name
     */
    public function getLevelNameAttribute()
    {
        return self::LEVELS[$this->level] ?? $this->level;
    }
}
