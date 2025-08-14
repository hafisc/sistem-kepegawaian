<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'is_active',
        // Personal Information
        'nip',
        'nik',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'religion',
        'marital_status',
        'address',
        'phone',
        // Employment Information
        'employee_id',
        'employee_type',
        'position',
        'rank',
        'grade',
        'work_unit',
        'start_date',
        'appointment_date',
        // Education Information
        'education_id',
        'education_major',
        'graduation_year',
        // Documents and Files
        'photo',
        'sk_file',
        'documents',
        // Status and Metadata
        'employment_status',
        'notes',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'date_of_birth' => 'date',
            'start_date' => 'date',
            'appointment_date' => 'date',
            'graduation_year' => 'integer',
            'documents' => 'array',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }



    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Get user's notifications
     */
    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    /**
     * Get user's education
     */
    public function education()
    {
        return $this->belongsTo(\App\Models\Education::class);
    }

    /**
     * Get user's photo URL
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/photos/' . $this->photo);
        }
        return asset('images/default-avatar.png');
    }

    /**
     * Get user's SK file URL
     */
    public function getSkFileUrlAttribute()
    {
        if ($this->sk_file) {
            return asset('storage/documents/' . $this->sk_file);
        }
        return null;
    }

    /**
     * Get user's full name with NIP
     */
    public function getFullNameAttribute()
    {
        return $this->name . ($this->nip ? ' (NIP: ' . $this->nip . ')' : '');
    }

    /**
     * Get user's age
     */
    public function getAgeAttribute()
    {
        if ($this->date_of_birth) {
            return \Carbon\Carbon::parse((string) $this->date_of_birth)->age;
        }
        return null;
    }

    /**
     * Get years of service
     */
    public function getYearsOfServiceAttribute()
    {
        if ($this->start_date) {
            return \Carbon\Carbon::parse((string) $this->start_date)->diffInYears(now());
        }
        return null;
    }

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for admin users
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope for regular users
     */
    public function scopeUsers($query)
    {
        return $query->where('role', 'user');
    }
}
