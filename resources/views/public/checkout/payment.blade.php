@extends('public.layout')

@section('title', 'Checkout — Payment')

@section('content')
<section class="hero-banner" style="padding:2rem 0 2.5rem;">
    <div class="container text-center position-relative z-1" data-aos="fade-down">
        <h1 class="display-6 fw-bold mb-2"><i class="bi bi-credit-card me-2"></i>Secure Payment</h1>
        <p class="opacity-90 mb-0">Enter your card details to complete your order.</p>
    </div>
</section>

<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <!-- Progress -->
                <div class="d-flex align-items-center gap-2 mb-4">
                    <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-check me-1"></i>1. Address</span>
                    <div class="flex-grow-1 border-top border-2 border-primary opacity-50"></div>
                    <span class="badge bg-primary rounded-pill px-3 py-2">2. Payment</span>
                    <div class="flex-grow-1 border-top border-2 border-secondary opacity-25"></div>
                    <span class="badge bg-secondary rounded-pill px-3 py-2 opacity-50">3. Confirm</span>
                </div>

                <!-- Order Summary -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold">Order Total</span>
                            <span class="fs-4 fw-bold text-success">Rs {{ number_format($total, 2) }}</span>
                        </div>
                        <div class="small text-muted">
                            <i class="bi bi-geo-alt me-1"></i>Deliver to: {{ $address }}
                        </div>
                    </div>
                </div>

                <!-- Mock Payment Card Form -->
                <div class="card border-0 shadow-sm rounded-4" x-data="{ cardNumber: '', expiry: '', cvv: '', name: '' }">
                    <div class="card-header border-0 py-3 px-4" style="background:linear-gradient(135deg,#1e1b4b,#4338ca);">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-white fw-semibold"><i class="bi bi-lock-fill me-2"></i>Secure Card Payment</span>
                            <div class="d-flex gap-2">
                                <span class="badge bg-white text-dark px-2">VISA</span>
                                <span class="badge bg-white text-dark px-2">MC</span>
                            </div>
                        </div>
                    </div>

                    <!-- Live Card Preview -->
                    <div class="p-4 pb-0">
                        <div class="rounded-4 p-4 mb-4 text-white position-relative overflow-hidden"
                            style="background:linear-gradient(135deg,#1e1b4b 0%,#4338ca 60%,#6366f1 100%);min-height:180px;">
                            <div class="position-absolute opacity-25" style="font-size:8rem; top: 10px; right: 40px; transform: translateY(-30%);">●</div>
                            <div class="small opacity-75 mb-3">SastaBazaar Pay</div>
                            <div class="fs-5 fw-bold letter-spacing mb-3" style="letter-spacing:.2em;" x-text="cardNumber || '•••• •••• •••• ••••'"></div>
                            <div class="d-flex justify-content-between small">
                                <div>
                                    <div class="opacity-75 small">Card Holder</div>
                                    <div class="fw-semibold" x-text="name || 'YOUR NAME'"></div>
                                </div>
                                <div>
                                    <div class="opacity-75 small">Expires</div>
                                    <div class="fw-semibold" x-text="expiry || 'MM/YY'"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body px-4 pb-4">
                        <form method="POST" action="{{ route('checkout.placeOrder') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="card_name">Name on Card</label>
                                <input type="text" id="card_name" class="form-control"
                                    placeholder="e.g. Muhammad Ali" x-model="name" autocomplete="off">
                                <div class="form-text text-muted">Demo only — not stored or charged.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="card_number">Card Number</label>
                                <input type="text" id="card_number" class="form-control"
                                    placeholder="1234 5678 9012 3456" maxlength="19"
                                    x-model="cardNumber"
                                    @input="cardNumber = $event.target.value.replace(/\D/g,'').replace(/(.{4})/g,'$1 ').trim().slice(0,19)"
                                    autocomplete="off">
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <label class="form-label fw-semibold" for="card_expiry">Expiry Date</label>
                                    <input type="text" id="card_expiry" class="form-control"
                                        placeholder="MM/YY" maxlength="5"
                                        x-model="expiry"
                                        @input="expiry = $event.target.value.replace(/\D/g,'').replace(/^(\d{2})(\d)/,'$1/$2').slice(0,5)"
                                        autocomplete="off">
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold" for="card_cvv">CVV</label>
                                    <input type="text" id="card_cvv" class="form-control"
                                        placeholder="•••" maxlength="3"
                                        x-model="cvv"
                                        @input="cvv = $event.target.value.replace(/\D/g,'').slice(0,3)"
                                        autocomplete="off">
                                </div>
                            </div>

                            <div class="alert alert-warning border-0 rounded-3 small mb-4">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                <strong>Demo Mode:</strong> This is a simulated payment form. No real transaction will occur.
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success rounded-pill py-3 fw-bold fs-5 shadow">
                                    <i class="bi bi-lock-fill me-2"></i> Pay Now — Rs {{ number_format($total, 2) }}
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <a href="{{ route('checkout.index') }}" class="text-muted small">
                                <i class="bi bi-arrow-left me-1"></i> Change delivery address
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection