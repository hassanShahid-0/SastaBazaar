@extends('public.layout')

@section('title', 'My Orders — Citizen Portal')

@section('content')
<section class="hero-banner" style="padding:2rem 0 2.5rem;">
    <div class="container text-center position-relative z-1" data-aos="fade-down">
        <h1 class="display-6 fw-bold mb-2"><i class="bi bi-clock-history me-2"></i>My Order History</h1>
        <p class="opacity-90 mb-0">Track and view details of your past marketplace purchases.</p>
    </div>
</section>

<section class="py-5 bg-body-tertiary">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-bag-x fs-1 text-muted d-block mb-3"></i>
                <h5 class="text-muted">You have not placed any orders yet.</h5>
                <a href="{{ route('marketplace.index') }}" class="btn btn-primary rounded-pill mt-3">
                    <i class="bi bi-shop me-1"></i> Start Shopping
                </a>
            </div>
        @else
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Shop</th>
                                <th>Date</th>
                                <th class="text-end">Total Amount</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Payment</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td class="fw-bold">#{{ $order->id }}</td>
                                <td>{{ $order->shop->name }}</td>
                                <td class="text-muted small">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                <td class="text-end fw-bold text-success">Rs {{ number_format($order->total_amount, 2) }}</td>
                                <td class="text-center">
                                    @php
                                        $statusColors = [
                                            'Pending' => 'warning text-dark',
                                            'Processing' => 'info text-dark',
                                            'Delivered' => 'success',
                                            'Cancelled' => 'danger',
                                        ];
                                        $badgeClass = $statusColors[$order->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">{{ $order->status }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success bg-opacity-15 text-success border border-success border-opacity-25">
                                        <i class="bi bi-check-circle me-1"></i>{{ $order->payment_status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('citizen.orders.show', $order) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="bi bi-eye me-1"></i> View Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($orders->hasPages())
                    <div class="card-footer bg-transparent py-3">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection
