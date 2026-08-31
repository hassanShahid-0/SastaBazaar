<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_name',
        'phone',
        'address',
        'is_verified',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'is_active'   => 'boolean',
        ];
    }

    /**
     * Commodities listed by this shop.
     */
    public function listings(): HasMany
    {
        return $this->hasMany(ShopListing::class);
    }

    /**
     * Orders placed with this shop.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isVerified(): bool
    {
        return (bool) $this->is_verified;
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }
}
