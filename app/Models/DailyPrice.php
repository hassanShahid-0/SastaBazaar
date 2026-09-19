<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'commodity_id',
        'official_price',
        'active_date',
    ];

    protected $casts = [
        'official_price' => 'decimal:2',
        'active_date' => 'date:Y-m-d',
    ];

    /**
     * Get the commodity associated with the price.
     */
    public function commodity(): BelongsTo
    {
        return $this->belongsTo(Commodity::class);
    }
}
