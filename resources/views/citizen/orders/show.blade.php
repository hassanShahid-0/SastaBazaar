@extends('public.layout')

@section('title', 'Order #' . $order->id . ' — Details')

@section('content')
<section class="hero-banner" style="padding:2rem 0 2.5rem;">
    <div class="container position-relative z-1" data-aos="fade-down">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb text-white-50 small">
                <li class="breadcrumb-item"><a href="{{ route('citizen.orders.index') }}" class="text-white-50">My Orders</a></li>
                <li class="breadcrumb-item active text-white">Order #{{ $order->id }}</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="fw-bold fs-3 mb-1">Order #{{ $order->id }}</h1>
                <p class="mb-0 opacity-90 small">Placed on {{ $order->created_at->format('d M Y \a\t h:i A') }}</p>
            </div>
            <div>
                @php
                    $statusColors = [
                        'Pending' => 'warning text-dark',
                        'Processing' => 'info text-dark',
                        'Delivered' => 'success',
                        'Cancelled' => 'danger',
                    ];
                    $badgeClass = $statusColors[$order->status] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $badgeClass }} fs-6 px-3 py-2 rounded-pill">{{ $order->status }}</span>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row g-4">
            <!-- Order summary & details -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-transparent border-0 py-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-basket me-2 text-primary"></i>Items Ordered</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Commodity</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Unit Price (Snapshot)</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $item->commodity->name }}</div>
                                        <small class="text-muted">{{ $item->commodity->urdu_name ?? '' }} (per {{ $item->commodity->unit }})</small>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">Rs {{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-end fw-bold">Rs {{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total Amount:</td>
                                    <td class="text-end fw-bold text-success fs-5">Rs {{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <a href="{{ route('citizen.orders.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i> Back to Orders
                </a>
            </div>

            <!-- Shop & delivery meta -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 py-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-shop me-2 text-primary"></i>Shop Details</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <h6 class="fw-bold mb-1">{{ $order->shop->name }}</h6>
                        <p class="text-muted small mb-2"><i class="bi bi-person me-1"></i>{{ $order->shop->owner_name }}</p>
                        <p class="text-muted small mb-2"><i class="bi bi-telephone me-1"></i>{{ $order->shop->phone }}</p>
                        <p class="text-muted small mb-0"><i class="bi bi-geo-alt me-1"></i>{{ $order->shop->address }}</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-transparent border-0 py-3 px-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-truck me-2 text-primary"></i>Delivery & Payment</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="mb-3">
                            <span class="text-muted small d-block">Delivery Address:</span>
                            <div class="fw-medium small mt-1">{{ $order->delivery_address }}</div>
                        </div>
                        <div class="mb-3">
                            <span class="text-muted small d-block">Payment Status:</span>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 mt-1">
                                <i class="bi bi-check-circle me-1"></i>{{ $order->payment_status }} (Card Payment)
                            </span>
                        </div>
                        <div>
                            <span class="text-muted small d-block">Price Guarantee:</span>
                            <small class="text-muted">Prices are locked at today's official government rate snapshot at time of checkout.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
