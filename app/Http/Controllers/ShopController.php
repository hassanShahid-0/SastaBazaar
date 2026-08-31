<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\DailyPrice;

class ShopController extends Controller
{
    /**
     * Public marketplace — list all verified + active shops.
     */
    public function index()
    {
        $shops = Shop::where('is_verified', true)
            ->where('is_active', true)
            ->withCount('listings')
            ->orderBy('name')
            ->paginate(12);

        return view('public.shops.index', compact('shops'));
    }

    /**
     * Public shop detail — show in-stock commodities with today's official price.
     */
    public function show(Shop $shop)
    {
        abort_unless($shop->is_verified && $shop->is_active, 404);

        $listings = $shop->listings()
            ->with('commodity')
            ->get()
            ->map(function ($listing) {
                $listing->today_price = DailyPrice::where('commodity_id', $listing->commodity_id)
                    ->whereDate('active_date', today())
                    ->first();
                return $listing;
            });

        return view('public.shops.show', compact('shop', 'listings'));
    }
}
