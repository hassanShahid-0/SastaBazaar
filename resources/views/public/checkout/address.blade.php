@extends('public.layout')

@section('title', 'Checkout — Delivery Address')

@section('content')
<section class="hero-banner" style="padding:2rem 0 2.5rem;">
    <div class="container text-center position-relative z-1" data-aos="fade-down">
        <h1 class="display-6 fw-bold mb-2"><i class="bi bi-geo-alt me-2"></i>Delivery Address</h1>
        <p class="opacity-90 mb-0">Tell us where to deliver your order.</p>
    </div>
</section>

<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <!-- Progress -->
                <div class="d-flex align-items-center gap-2 mb-4">
                    <span class="badge bg-primary rounded-pill px-3 py-2">1. Address</span>
                    <div class="flex-grow-1 border-top border-2 border-secondary opacity-25"></div>
                    <span class="badge bg-secondary rounded-pill px-3 py-2 opacity-50">2. Payment</span>
                    <div class="flex-grow-1 border-top border-2 border-secondary opacity-25"></div>
                    <span class="badge bg-secondary rounded-pill px-3 py-2 opacity-50">3. Confirm</span>
                </div>

                <!-- Cart Summary -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h6 class="fw-bold mb-0"><i class="bi bi-receipt me-2 text-primary"></i>Order Summary</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between small mb-1">
                            <span>{{ $item['commodity']->name }} × {{ $item['quantity'] }}</span>
                            <span>Rs {{ number_format($item['subtotal'], 2) }}</span>
                        </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span class="text-success">Rs {{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Address Form -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger border-0 rounded-3 mb-3">
                                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('checkout.address') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-semibold" for="delivery_address">
                                    Delivery Address <span class="text-danger">*</span>
                                </label>
                                <textarea name="delivery_address" id="delivery_address" rows="4"
                                          class="form-control @error('delivery_address') is-invalid @enderror"
                                          placeholder="House #, Street, Mohalla, City…" required minlength="10">{{ old('delivery_address') }}</textarea>
                                @error('delivery_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">
                                    <i class="bi bi-arrow-right me-1"></i> Continue to Payment
                                </button>
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary rounded-pill">
                                    <i class="bi bi-arrow-left me-1"></i> Back to Cart
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
