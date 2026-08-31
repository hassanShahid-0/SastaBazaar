<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use App\Models\Shop;
use App\Models\ShopListing;
use Illuminate\Http\Request;

class ShopListingController extends Controller
{
    public function index(Shop $shop)
    {
        $listings    = $shop->listings()->with('commodity')->get();
        $commodities = Commodity::orderBy('name')
            ->whereNotIn('id', $listings->pluck('commodity_id'))
            ->get();

        return view('admin.shops.listings', compact('shop', 'listings', 'commodities'));
    }

    public function store(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'commodity_id' => 'required|exists:commodities,id',
            'stock_qty'    => 'required|integer|min:0',
        ]);

        // Use updateOrCreate to handle re-adding a previously removed listing
        ShopListing::updateOrCreate(
            ['shop_id' => $shop->id, 'commodity_id' => $validated['commodity_id']],
            ['stock_qty' => $validated['stock_qty']]
        );

        return redirect()->route('admin.shops.listings.index', $shop)
            ->with('success', 'Listing added/updated successfully.');
    }

    public function destroy(Shop $shop, ShopListing $listing)
    {
        abort_unless($listing->shop_id === $shop->id, 404);
        $listing->delete();

        return redirect()->route('admin.shops.listings.index', $shop)
            ->with('success', 'Listing removed.');
    }
}
