<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * List orders for the currently logged-in citizen.
     */
    public function index()
    {
        $orders = Order::where('citizen_id', auth('citizen')->id())
            ->with('shop')
            ->latest()
            ->paginate(10);

        return view('citizen.orders.index', compact('orders'));
    }

    /**
     * Show a single order belonging to the citizen.
     */
    public function show(Order $order)
    {
        abort_unless($order->citizen_id === auth('citizen')->id(), 403);

        $order->load(['shop', 'orderItems.commodity']);

        return view('citizen.orders.show', compact('order'));
    }
}
