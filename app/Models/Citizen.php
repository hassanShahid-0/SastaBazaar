<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Citizen extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The guard for this model.
     */
    protected $guard = 'citizen';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'is_blocked',
        'blocked_reason',
        'blocked_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password'   => 'hashed',
            'is_blocked' => 'boolean',
            'blocked_at' => 'datetime',
        ];
    }

    public function isBlocked(): bool
    {
        return (bool) $this->is_blocked;
    }

    /**
     * Complaints filed by this citizen.
     */
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    /**
     * Orders placed by this citizen.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
