<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['citizen', 'shop'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('citizen', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(20)->withQueryString();

        $totalOrders    = Order::count();
        $pendingOrders  = Order::where('status', 'Pending')->count();
        $deliveredOrders = Order::where('status', 'Delivered')->count();
        $totalRevenue   = Order::where('status', '!=', 'Cancelled')->sum('total_amount');

        return view('admin.orders.index', compact(
            'orders', 'totalOrders', 'pendingOrders', 'deliveredOrders', 'totalRevenue'
        ));
    }

    public function show(Order $order)
    {
        $order->load(['citizen', 'shop', 'orderItems.commodity']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', Order::statuses()),
        ]);

        $order->update(['status' => $request->input('status')]);

        return redirect()->back()
            ->with('success', "Order #{$order->id} status updated to {$order->status}.");
    }
}
