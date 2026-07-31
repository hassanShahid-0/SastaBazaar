<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commodity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'urdu_name',
        'unit',
    ];

    /**
     * Get the daily prices for the commodity.
     */
    public function dailyPrices(): HasMany
    {
        return $this->hasMany(DailyPrice::class);
    }

    /**
     * Get today's published price.
     */
    public function todayPrice()
    {
        return $this->hasOne(DailyPrice::class)->whereDate('active_date', now()->toDateString());
    }
}
