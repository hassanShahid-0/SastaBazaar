@extends('public.layout')

@section('title', 'Official Commodity Prices - ' . \Carbon\Carbon::parse($date)->format('d M Y'))

@section('content')
<div x-data="{
    search: '',
    viewMode: 'table',
    matchesSearch(name, urdu) {
        if (!this.search) return true;
        const q = this.search.toLowerCase();
        return name.toLowerCase().includes(q) || (urdu && urdu.toLowerCase().includes(q));
    }
}">

    <!-- â•â•â•â• Hero Section â•â•â•â• -->
    <section class="hero-banner">
        <div class="container text-center position-relative z-1" data-aos="fade-down">
            <span class="badge bg-white bg-opacity-20 text-white border border-white border-opacity-25 px-3 py-2 rounded-pill mb-3">
                <i class="bi bi-geo-alt-fill text-warning me-1"></i> Official District Price Control Portal
            </span>
            <h1 class="display-5 fw-extrabold mb-3">Daily Grocery &amp; Commodity Rates</h1>
            <p class="lead opacity-90 mx-auto mb-4" style="max-width: 650px;">
                View government-approved prices for essential items. If a shopkeeper charges above these official rates, report a complaint instantly.
            </p>

            <!-- Search & Date Filter Bar -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="bg-white p-2 p-md-3 rounded-4 shadow-lg text-dark">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-7">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-0 text-muted fs-5"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control border-0 shadow-none ps-0"
                                           x-model="search"
                                           placeholder="Search items (e.g. Sugar, Flour, Ú†ÛŒÙ†ÛŒ)...">
                                    <button class="btn text-muted" x-show="search" @click="search = ''" type="button">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <form method="GET" action="{{ route('home') }}" class="d-flex align-items-center gap-2">
                                    <input type="date" name="date" class="form-control form-control-sm border-0 bg-light fw-medium"
                                           value="{{ $date }}" onchange="this.form.submit()">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- â•â•â•â• Main Section â•â•â•â• -->
    <section class="py-5 bg-body-tertiary">
        <div class="container">

            <!-- Subheader & Controls -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4" data-aos="fade-up">
                <div>
                    <h4 class="fw-bold mb-1">
                        Price List for {{ \Carbon\Carbon::parse($date)->format('l, F d, Y') }}
                    </h4>
                    <p class="text-muted small mb-0">
                        @if($latestUpdate)
                            <i class="bi bi-clock-history me-1 text-primary"></i> Last updated {{ \Carbon\Carbon::parse($latestUpdate)->diffForHumans() }}
                        @else
                            <i class="bi bi-info-circle me-1 text-warning"></i> Displaying active commodities
                        @endif
                    </p>
                </div>

                <!-- View Mode Buttons -->
                <div class="d-flex align-items-center gap-2">
                    <div class="btn-group btn-group-sm bg-white shadow-sm p-1 rounded-pill border" role="group">
                        <button type="button" class="btn rounded-pill px-3"
                                :class="viewMode === 'table' ? 'btn-primary' : 'btn-light text-muted'"
                                @click="viewMode = 'table'">
                            <i class="bi bi-table me-1"></i> Table View
                        </button>
                        <button type="button" class="btn rounded-pill px-3"
                                :class="viewMode === 'cards' ? 'btn-primary' : 'btn-light text-muted'"
                                @click="viewMode = 'cards'">
                            <i class="bi bi-grid-fill me-1"></i> Card View
                        </button>
                    </div>
                </div>
            </div>

            <!-- â•â•â•â• TABLE VIEW â•â•â•â• -->
            <div x-show="viewMode === 'table'" class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" data-aos="fade-up">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 py-3">#</th>
                                    <th class="py-3">Commodity Name</th>
                                    <th class="py-3 font-urdu">Ù†Ø§Ù… (Urdu)</th>
                                    <th class="py-3">Unit</th>
                                    <th class="py-3 text-end">Official Price (PKR)</th>
                                    <th class="py-3 text-center pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($commodities as $commodity)
                                    @php
                                        $priceObj = $commodity->dailyPrices->first();
                                        $priceVal = $priceObj?->official_price;
                                    @endphp
                                    <tr x-show="matchesSearch('{{ addslashes($commodity->name) }}', '{{ addslashes($commodity->urdu_name ?? '') }}')"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform scale-95"
                                        x-transition:enter-end="opacity-100 transform scale-100">
                                        <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="fw-bold text-dark-emphasis">{{ $commodity->name }}</span>
                                        </td>
                                        <td class="font-urdu fs-5 text-secondary">
                                            {{ $commodity->urdu_name ?? 'â€”' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2.5 py-1">
                                                {{ $commodity->unit }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            @if($priceVal !== null)
                                                <span class="price-tag fw-bold">Rs. {{ number_format($priceVal, 2) }}</span>
                                                <span class="small text-muted d-block fs-7">per {{ $commodity->unit }}</span>
                                            @else
                                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">Not Set Today</span>
                                            @endif
                                        </td>
                                        <td class="text-center pe-4">
                                            <a href="{{ route('complaint.create') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                               title="Report overcharging for {{ $commodity->name }}">
                                                <i class="bi bi-flag me-1"></i> Report
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                            No commodities registered in system yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- â•â•â•â• CARDS GRID VIEW â•â•â•â• -->
            <div x-show="viewMode === 'cards'" class="row g-3 mb-4" x-cloak>
                @foreach($commodities as $commodity)
                    @php
                        $priceObj = $commodity->dailyPrices->first();
                        $priceVal = $priceObj?->official_price;
                    @endphp
                    <div class="col-sm-6 col-md-4 col-lg-3"
                         x-show="matchesSearch('{{ addslashes($commodity->name) }}', '{{ addslashes($commodity->urdu_name ?? '') }}')"
                         x-transition>
                        <div class="price-card p-3 h-100 d-flex flex-column justify-content-between shadow-sm">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                        {{ $commodity->unit }}
                                    </span>
                                    <span class="text-muted small">#{{ $loop->iteration }}</span>
                                </div>
                                <h5 class="fw-bold text-dark mb-1">{{ $commodity->name }}</h5>
                                @if($commodity->urdu_name)
                                    <p class="font-urdu fs-5 text-secondary mb-3">{{ $commodity->urdu_name }}</p>
                                @endif
                            </div>

                            <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                <div>
                                    @if($priceVal !== null)
                                        <div class="price-tag fw-bold">Rs. {{ number_format($priceVal, 2) }}</div>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning">Unpriced</span>
                                    @endif
                                </div>
                                <a href="{{ route('complaint.create') }}" class="btn btn-sm btn-outline-danger rounded-circle p-2"
                                   title="Report overcharging for {{ $commodity->name }}">
                                    <i class="bi bi-flag-fill"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Help Notice Card -->
            <div class="card border-0 bg-primary bg-opacity-10 rounded-4 p-4 mt-5 shadow-sm" data-aos="fade-up">
                <div class="row align-items-center g-3">
                    <div class="col-md-8">
                        <h5 class="fw-bold text-primary mb-1"><i class="bi bi-info-circle-fill me-2"></i>Know Your Rights as a Citizen</h5>
                        <p class="mb-0 text-muted small">
                            Retailers are legally required to display and sell daily grocery commodities at or below the official District Rate List. If any shopkeeper refuses or overcharges, file a direct complaint on this portal.
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('complaint.create') }}" class="btn btn-danger rounded-pill px-4 shadow-sm">
                            <i class="bi bi-megaphone me-1"></i> File a Complaint
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection