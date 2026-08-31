@extends('public.layout')

@section('title', $shop->name . ' — Shop')

@section('content')
<!-- Hero -->
<section class="hero-banner" style="padding:2rem 0 2.5rem;">
    <div class="container position-relative z-1" data-aos="fade-down">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb text-white-50 small">
                <li class="breadcrumb-item"><a href="{{ route('marketplace.index') }}" class="text-white-50">Marketplace</a></li>
                <li class="breadcrumb-item active text-white">{{ $shop->name }}</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="rounded-3 p-3 bg-white bg-opacity-10">
                <i class="bi bi-shop fs-2 text-white"></i>
            </div>
            <div>
                <h1 class="fw-bold fs-3 mb-1">{{ $shop->name }}</h1>
                <p class="mb-0 opacity-90 small">
                    <i class="bi bi-person me-1"></i>{{ $shop->owner_name }} &nbsp;|&nbsp;
                    <i class="bi bi-telephone me-1"></i>{{ $shop->phone }} &nbsp;|&nbsp;
                    <i class="bi bi-geo-alt me-1"></i>{{ $shop->address }}
                </p>
            </div>
            <span class="badge bg-success ms-auto"><i class="bi bi-patch-check-fill me-1"></i>Verified</span>
        </div>
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

        @unless(auth('citizen')->check())
        <div class="alert alert-info border-0 rounded-4 mb-4">
            <i class="bi bi-info-circle me-2"></i>
            <a href="{{ route('citizen.login') }}" class="fw-semibold">Log in</a> or
            <a href="{{ route('citizen.register') }}" class="fw-semibold">register</a> to add items to your cart and place orders.
        </div>
        @endunless

        @if($listings->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                <h5 class="text-muted">No items in stock today</h5>
            </div>
        @else
        <div class="row g-4">
            @foreach($listings as $listing)
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="card h-100 border-0 shadow-sm rounded-4" style="transition:transform .25s,box-shadow .25s;"
                     onmouseenter="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,.12)'"
                     onmouseleave="this.style.transform='';this.style.boxShadow=''">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="fw-bold mb-1">{{ $listing->commodity->name }}</h6>
                                <span class="text-muted small">per {{ $listing->commodity->unit }}</span>
                            </div>
                            <span class="badge bg-secondary rounded-pill small">Stock: {{ $listing->stock_qty }}</span>
                        </div>

                        @if($listing->today_price)
                            <div class="price-tag mb-3">Rs {{ number_format($listing->today_price->official_price, 2) }}</div>
                            <div class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small mb-3">
                                <i class="bi bi-shield-check me-1"></i>Official Rate
                            </div>

                            @auth('citizen')
                            <form method="POST" action="{{ route('cart.add') }}">
                                @csrf
                                <input type="hidden" name="commodity_id" value="{{ $listing->commodity_id }}">
                                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text">Qty</span>
                                    <input type="number" name="quantity" value="1" min="1" max="50" class="form-control" style="max-width:80px;">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                    </button>
                                </div>
                            </form>
                            @else
                            <a href="{{ route('citizen.login') }}" class="btn btn-outline-primary btn-sm w-100 rounded-pill">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login to Buy
                            </a>
                            @endauth
                        @else
                            <div class="text-muted small">
                                <i class="bi bi-exclamation-circle me-1"></i>No official price set today
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection
