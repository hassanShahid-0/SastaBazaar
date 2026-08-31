<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'commodity_id',
        'stock_qty',
    ];

    /**
     * The shop this listing belongs to.
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * The commodity for this listing.
     * Price is NEVER stored here — always fetched live from DailyPrice.
     */
    public function commodity(): BelongsTo
    {
        return $this->belongsTo(Commodity::class);
    }

    /**
     * Get today's official price for this listing's commodity.
     */
    public function todayPrice(): ?DailyPrice
    {
        return DailyPrice::where('commodity_id', $this->commodity_id)
            ->whereDate('active_date', today())
            ->first();
    }
}
