<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\DailyPrice;
use App\Models\Shop;
use App\Models\ShopListing;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * View cart (public, but empty for guests).
     */
    public function index()
    {
        $cartItems = $this->buildCartItems();
        $total = collect($cartItems)->sum('subtotal');

        return view('public.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a commodity to the cart (citizen auth required via route middleware).
     */
    public function add(Request $request)
    {
        $request->validate([
            'commodity_id' => 'required|exists:commodities,id',
            'shop_id'      => 'required|exists:shops,id',
            'quantity'     => 'required|integer|min:1|max:100',
        ]);

        $commodityId = $request->integer('commodity_id');
        $shopId      = $request->integer('shop_id');
        $qty         = $request->integer('quantity');

        // Verify listing exists for this shop+commodity
        $listing = ShopListing::where('shop_id', $shopId)
            ->where('commodity_id', $commodityId)
            ->first();

        if (! $listing) {
            return back()->with('error', 'This item is not available at the selected shop.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$commodityId]) && $cart[$commodityId]['shop_id'] === $shopId) {
            $cart[$commodityId]['quantity'] += $qty;
        } else {
            $cart[$commodityId] = [
                'shop_id'  => $shopId,
                'quantity' => $qty,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Item added to cart!');
    }

    /**
     * Update quantity of a cart item.
     */
    public function update(Request $request, $commodityId)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:100']);

        $cart = session()->get('cart', []);

        if (isset($cart[$commodityId])) {
            $cart[$commodityId]['quantity'] = $request->integer('quantity');
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated.');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove($commodityId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$commodityId]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Build enriched cart items array with live prices and subtotals.
     */
    public static function buildCartItems(): array
    {
        $cart  = session()->get('cart', []);
        $items = [];

        foreach ($cart as $commodityId => $data) {
            $commodity  = Commodity::find($commodityId);
            $shop       = Shop::find($data['shop_id']);
            $todayPrice = DailyPrice::where('commodity_id', $commodityId)
                ->whereDate('active_date', today())
                ->first();

            if (! $commodity || ! $shop || ! $todayPrice) {
                // Skip items with no live price today
                continue;
            }

            $qty      = $data['quantity'];
            $price    = (float) $todayPrice->official_price;
            $subtotal = $price * $qty;

            $items[$commodityId] = [
                'commodity'  => $commodity,
                'shop'       => $shop,
                'quantity'   => $qty,
                'unit_price' => $price,
                'subtotal'   => $subtotal,
            ];
        }

        return $items;
    }
}
