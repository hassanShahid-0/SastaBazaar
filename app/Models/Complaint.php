<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'citizen_id',
        'citizen_name',
        'citizen_phone',
        'shop_name',
        'location_address',
        'description',
        'photo_path',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function isPending(): bool
    {
        return $this->status === 'Pending';
    }

    public function isResolved(): bool
    {
        return $this->status === 'Resolved';
    }

    /**
     * The citizen who filed this complaint (nullable for anonymous).
     */
    public function citizen(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Citizen::class);
    }
}