@extends('public.layout')

@section('title', 'Marketplace — Browse Shops')

@section('content')
<!-- Hero -->
<section class="hero-banner" style="padding:2.5rem 0 3rem;">
    <div class="container text-center position-relative z-1" data-aos="fade-down">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">
            <i class="bi bi-shop me-1"></i> Verified Shops Only
        </span>
        <h1 class="display-6 fw-bold mb-2">SastaBazaar Marketplace</h1>
        <p class="opacity-90 mx-auto mb-0" style="max-width:560px;">
            Browse verified shops selling essential commodities at official government-regulated prices.
        </p>
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

        @if($shops->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-shop fs-1 text-muted d-block mb-3"></i>
                <h5 class="text-muted">No shops available yet</h5>
                <p class="text-muted">Check back soon — verified shops will appear here.</p>
            </div>
        @else
        <div class="row g-4">
            @foreach($shops as $shop)
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift" style="transition:transform .25s,box-shadow .25s;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-shop fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">{{ $shop->name }}</h5>
                                <p class="text-muted small mb-0"><i class="bi bi-person me-1"></i>{{ $shop->owner_name }}</p>
                            </div>
                            <span class="badge bg-success ms-auto"><i class="bi bi-patch-check-fill me-1"></i>Verified</span>
                        </div>
                        <p class="text-muted small mb-2">
                            <i class="bi bi-geo-alt me-1"></i>{{ Str::limit($shop->address, 80) }}
                        </p>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-telephone me-1"></i>{{ $shop->phone }}
                        </p>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="badge bg-info bg-opacity-15 text-info border border-info border-opacity-25 rounded-pill">
                                <i class="bi bi-box me-1"></i>{{ $shop->listings_count }} items in stock
                            </span>
                            <a href="{{ route('marketplace.shops.show', $shop) }}" class="btn btn-primary btn-sm rounded-pill px-3">
                                <i class="bi bi-eye me-1"></i> Browse
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $shops->links() }}</div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,.12) !important; }
</style>
@endpush
