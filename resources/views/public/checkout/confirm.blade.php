@extends('public.layout')

@section('title', 'Order Confirmed — #' . $order->id)

@section('content')
<section class="py-5 bg-body-tertiary" style="min-height:80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7" data-aos="fade-up">

                <!-- Success Banner -->
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white mb-4"
                         style="width:90px;height:90px;">
                        <i class="bi bi-check-lg" style="font-size:2.5rem;"></i>
                    </div>
                    <h2 class="fw-bold text-success mb-2">Order Confirmed!</h2>
                    <p class="text-muted mb-0">
                        Your order <strong>#{{ $order->id }}</strong> has been placed successfully.
                        You'll receive your delivery soon.
                    </p>
                </div>

                <!-- Order Detail Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 py-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-bag-check me-2 text-success"></i>Order Details</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <dl class="row small mb-3">
                            <dt class="col-5 text-muted">Order ID</dt><dd class="col-7 fw-bold">#{{ $order->id }}</dd>
                            <dt class="col-5 text-muted">Shop</dt><dd class="col-7">{{ $order->shop->name }}</dd>
                            <dt class="col-5 text-muted">Status</dt>
                            <dd class="col-7"><span class="badge bg-warning">{{ $order->status }}</span></dd>
                            <dt class="col-5 text-muted">Payment</dt>
                            <dd class="col-7"><span class="badge bg-success">{{ $order->payment_status }}</span></dd>
                            <dt class="col-5 text-muted">Deliver to</dt><dd class="col-7">{{ $order->delivery_address }}</dd>
                        </dl>

                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->commodity->name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">Rs {{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-end fw-bold">Rs {{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total Paid</td>
                                    <td class="text-end fw-bold text-success fs-5">Rs {{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('citizen.orders.index') }}" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-clock-history me-1"></i> View My Orders
                    </a>
                    <a href="{{ route('marketplace.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-shop me-1"></i> Continue Shopping
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
