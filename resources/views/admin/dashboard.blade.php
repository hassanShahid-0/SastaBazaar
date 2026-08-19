@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="row g-4 mb-4">

    {{-- Metric cards --}}
    <div class="col-sm-6 col-xl-3" data-aos="fade-up" data-aos-delay="0">
        <div class="card metric-card text-white h-100"
             style="background: linear-gradient(135deg,#4f46e5,#7c3aed);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 opacity-75 small">Total Commodities</p>
                    <h2 class="fw-bold mb-0">{{ $commoditiesCount }}</h2>
                </div>
                <i class="bi bi-boxes fs-1 opacity-50"></i>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="{{ route('admin.commodities.index') }}" class="text-white text-decoration-none small">
                    Manage &rarr;
                </a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3" data-aos="fade-up" data-aos-delay="100">
        <div class="card metric-card text-white h-100"
             style="background: linear-gradient(135deg,#0891b2,#06b6d4);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 opacity-75 small">Prices Published Today</p>
                    <h2 class="fw-bold mb-0">{{ $pricesTodayCount }}</h2>
                </div>
                <i class="bi bi-tags fs-1 opacity-50"></i>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <span class="text-white small">As of {{ now()->format('d M Y') }}</span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3" data-aos="fade-up" data-aos-delay="200">
        <div class="card metric-card text-white h-100"
             style="background: linear-gradient(135deg,#059669,#10b981);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 opacity-75 small">Total Complaints</p>
                    <h2 class="fw-bold mb-0">{{ $complaintsCount }}</h2>
                </div>
                <i class="bi bi-chat-square-text fs-1 opacity-50"></i>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <span class="text-white small">{{ $pendingComplaints }} pending</span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3" data-aos="fade-up" data-aos-delay="300">
        <div class="card metric-card h-100 border-0 bg-warning bg-opacity-10">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 text-muted small">Last Price Update</p>
                    <h6 class="fw-bold mb-0">
                        {{ $latestUpdate ? \Carbon\Carbon::parse($latestUpdate)->diffForHumans() : 'N/A' }}
                    </h6>
                </div>
                <i class="bi bi-clock-history fs-1 text-warning opacity-75"></i>
            </div>
        </div>
    </div>
</div>

{{-- Quick actions --}}
<div class="row g-4" data-aos="fade-up" data-aos-delay="400">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-3">
                <h6 class="fw-semibold mb-0"><i class="bi bi-lightning-charge me-2 text-primary"></i>Quick Actions</h6>
            </div>
            <div class="card-body d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.commodities.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add Commodity
                </a>
                <a href="#" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-pencil-square me-1"></i> Publish Prices
                </a>
                <a href="#" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-envelope me-1"></i> View Complaints
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-3">
                <h6 class="fw-semibold mb-0"><i class="bi bi-info-circle me-2 text-info"></i>System Info</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted">App</td><td>SastaBazaar v1.0</td></tr>
                    <tr><td class="text-muted">Laravel</td><td>{{ app()->version() }}</td></tr>
                    <tr><td class="text-muted">PHP</td><td>{{ PHP_VERSION }}</td></tr>
                    <tr><td class="text-muted">Logged in</td><td>{{ auth()->user()->name }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
