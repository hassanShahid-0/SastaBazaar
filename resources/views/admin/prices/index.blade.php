@extends('admin.layout')

@section('title', 'Publish Daily Prices')
@section('page-title', 'Publish Daily Prices')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <div>
        <h4 class="fw-bold mb-0">Daily Commodity Prices</h4>
        <p class="text-muted small mb-0">Set or update official prices issued by district administration</p>
    </div>
    <!-- Date picker form -->
    <form method="GET" action="{{ route('admin.prices.index') }}" class="d-flex align-items-center gap-2">
        <label for="date" class="form-label mb-0 fw-semibold text-nowrap">Active Date:</label>
        <input type="date" name="date" id="date" class="form-control form-control-sm"
               value="{{ $date }}" onchange="this.form.submit()">
    </form>
</div>

<div class="card border-0 shadow-sm" data-aos="fade-up">
    <div class="card-header bg-transparent border-0 pt-4 ps-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0"><i class="bi bi-calendar-check me-2 text-primary"></i>Prices for {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h6>
        <span class="badge bg-info bg-opacity-10 text-info">
            {{ count($existingPrices) }} of {{ count($commodities) }} Prices Set
        </span>
    </div>
    <div class="card-body p-4">
        @if($commodities->count())
        <form action="{{ route('admin.prices.store') }}" method="POST">
            @csrf
            <input type="hidden" name="active_date" value="{{ $date }}">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Commodity Name</th>
                            <th>Urdu Name</th>
                            <th>Unit</th>
                            <th style="width: 250px;">Official Price (PKR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commodities as $commodity)
                        <tr>
                            <td class="ps-3 text-muted">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $commodity->name }}</td>
                            <td>{{ $commodity->urdu_name ?? '—' }}</td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $commodity->unit }}</span></td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Rs.</span>
                                    <input type="number" step="0.01" min="0"
                                           name="prices[{{ $commodity->id }}]"
                                           class="form-control"
                                           value="{{ old('prices.' . $commodity->id, $existingPrices[$commodity->id] ?? '') }}"
                                           placeholder="e.g. 150.00">
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check2-circle me-1"></i> Save & Publish Prices
                </button>
            </div>
        </form>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-boxes fs-1 d-block mb-2"></i>
            No commodities available. <a href="{{ route('admin.commodities.create') }}">Add commodities first</a>.
        </div>
        @endif
    </div>
</div>
@endsection