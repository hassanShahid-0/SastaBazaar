<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Step 1 — Show delivery address form.
     */
    public function index()
    {
        $cartItems = CartController::buildCartItems();

        if (empty($cartItems)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Add items before checking out.');
        }

        // All items must be from the same shop (single-shop checkout)
        $shopIds = collect($cartItems)->pluck('shop.id')->unique();
        if ($shopIds->count() > 1) {
            return redirect()->route('cart.index')
                ->with('error', 'You can only checkout items from a single shop at a time.');
        }

        $total = collect($cartItems)->sum('subtotal');

        return view('public.checkout.address', compact('cartItems', 'total'));
    }

    /**
     * Step 2 — Accept delivery address and advance to payment page.
     */
    public function address(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string|min:10|max:500',
        ]);

        session()->put('checkout_delivery_address', $request->input('delivery_address'));

        return redirect()->route('checkout.payment');
    }

    /**
     * Step 3 — Show mock payment form.
     */
    public function payment()
    {
        $cartItems = CartController::buildCartItems();

        if (empty($cartItems)) {
            return redirect()->route('cart.index');
        }

        $total   = collect($cartItems)->sum('subtotal');
        $address = session()->get('checkout_delivery_address');

        if (! $address) {
            return redirect()->route('checkout.index');
        }

        return view('public.checkout.payment', compact('cartItems', 'total', 'address'));
    }

    /**
     * Step 4 — Place order (citizen confirmed mock payment).
     */
    public function placeOrder(Request $request)
    {
        $cartItems = CartController::buildCartItems();

        if (empty($cartItems)) {
            return redirect()->route('cart.index');
        }

        $address = session()->get('checkout_delivery_address');

        if (! $address) {
            return redirect()->route('checkout.index');
        }

        // All items from same shop
        $shopId = collect($cartItems)->first()['shop']->id;
        $total  = collect($cartItems)->sum('subtotal');

        $order = Order::create([
            'citizen_id'       => auth('citizen')->id(),
            'shop_id'          => $shopId,
            'status'           => 'Pending',
            'payment_status'   => 'Paid',
            'total_amount'     => $total,
            'delivery_address' => $address,
        ]);

        foreach ($cartItems as $commodityId => $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'commodity_id' => $commodityId,
                'quantity'     => $item['quantity'],
                'unit_price'   => $item['unit_price'],   // Price snapshot
                'subtotal'     => $item['subtotal'],
            ]);
        }

        // Clear cart and checkout session data
        session()->forget(['cart', 'checkout_delivery_address']);

        return redirect()->route('checkout.confirmation', $order);
    }

    /**
     * Order confirmation page.
     */
    public function confirmation(Order $order)
    {
        // Ensure the citizen can only see their own confirmation
        abort_unless($order->citizen_id === auth('citizen')->id(), 403);

        $order->load(['shop', 'orderItems.commodity']);

        return view('public.checkout.confirm', compact('order'));
    }
}
