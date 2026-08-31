@extends('admin.layout')

@section('title', 'Order #' . $order->id)
@section('page-title', 'Order #' . $order->id . ' — Detail')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left me-1"></i> Back to Orders
    </a>
</div>

<div class="row g-4">
    <!-- Order Info -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-transparent border-0 py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-info-circle me-2 text-primary"></i>Order Info</h6>
            </div>
            <div class="card-body">
                <dl class="row small mb-0">
                    <dt class="col-5 text-muted">Order ID</dt><dd class="col-7 fw-bold">#{{ $order->id }}</dd>
                    <dt class="col-5 text-muted">Date</dt><dd class="col-7">{{ $order->created_at->format('d M Y H:i') }}</dd>
                    <dt class="col-5 text-muted">Citizen</dt><dd class="col-7">{{ $order->citizen->name }}<br><code class="small">{{ $order->citizen->phone }}</code></dd>
                    <dt class="col-5 text-muted">Shop</dt><dd class="col-7">{{ $order->shop->name }}</dd>
                    <dt class="col-5 text-muted">Total</dt><dd class="col-7 fw-bold text-success">Rs {{ number_format($order->total_amount, 2) }}</dd>
                    <dt class="col-5 text-muted">Payment</dt><dd class="col-7"><span class="badge bg-success">{{ $order->payment_status }}</span></dd>
                    <dt class="col-5 text-muted">Delivery</dt><dd class="col-7 small">{{ $order->delivery_address }}</dd>
                </dl>
            </div>
        </div>

        <!-- Update Status -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-transparent border-0 py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-arrow-repeat me-2 text-warning"></i>Update Status</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            @foreach(\App\Models\Order::statuses() as $s)
                                <option value="{{ $s }}" @selected($order->status === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning rounded-pill w-100">
                        <i class="bi bi-check-circle me-1"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-transparent border-0 py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-cart me-2 text-success"></i>Order Items</h6>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Commodity</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Unit Price (at order)</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td class="fw-semibold">{{ $item->commodity->name }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">Rs {{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-end fw-bold">Rs {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Grand Total</td>
                            <td class="text-end fw-bold text-success fs-5">Rs {{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
