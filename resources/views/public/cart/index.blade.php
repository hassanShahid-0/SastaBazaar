@extends('public.layout')

@section('title', 'My Cart')

@section('content')
<section class="hero-banner" style="padding:2rem 0 2.5rem;">
    <div class="container text-center position-relative z-1" data-aos="fade-down">
        <h1 class="display-6 fw-bold mb-2"><i class="bi bi-cart3 me-2"></i>Your Cart</h1>
        <p class="opacity-90 mb-0">Review your items before checkout.</p>
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
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(empty($cartItems))
            <div class="text-center py-5">
                <i class="bi bi-cart-x fs-1 text-muted d-block mb-3"></i>
                <h5 class="text-muted">Your cart is empty</h5>
                <a href="{{ route('marketplace.index') }}" class="btn btn-primary rounded-pill mt-3">
                    <i class="bi bi-shop me-1"></i> Browse Marketplace
                </a>
            </div>
        @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h6 class="fw-bold mb-0"><i class="bi bi-bag me-2 text-primary"></i>Cart Items</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Shop</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-center" style="width:140px;">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $commodityId => $item)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $item['commodity']->name }}</div>
                                        <small class="text-muted">per {{ $item['commodity']->unit }}</small>
                                    </td>
                                    <td class="small text-muted">{{ $item['shop']->name }}</td>
                                    <td class="text-end">Rs {{ number_format($item['unit_price'], 2) }}</td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('cart.update', $commodityId) }}" class="d-flex align-items-center gap-1 justify-content-center">
                                            @csrf @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="100"
                                                   class="form-control form-control-sm text-center" style="width:60px;">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill" title="Update">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-end fw-bold">Rs {{ number_format($item['subtotal'], 2) }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.remove', $commodityId) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top:80px;">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h6 class="fw-bold mb-0"><i class="bi bi-receipt me-2 text-success"></i>Order Summary</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-semibold">Rs {{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Delivery</span>
                            <span class="text-success fw-semibold">Free</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold fs-5 text-success">Rs {{ number_format($total, 2) }}</span>
                        </div>

                        @auth('citizen')
                        <a href="{{ route('checkout.index') }}" class="btn btn-success rounded-pill w-100 fw-semibold py-2">
                            <i class="bi bi-credit-card me-2"></i> Proceed to Checkout
                        </a>
                        @else
                        <a href="{{ route('citizen.login') }}" class="btn btn-primary rounded-pill w-100 fw-semibold py-2">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Login to Checkout
                        </a>
                        @endauth

                        <a href="{{ route('marketplace.index') }}" class="btn btn-outline-secondary rounded-pill w-100 mt-2">
                            <i class="bi bi-arrow-left me-1"></i> Continue Shopping
                        </a>

                        <div class="mt-3 small text-muted text-center">
                            <i class="bi bi-info-circle me-1"></i>
                            Prices shown are live official rates from today's district price list.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
