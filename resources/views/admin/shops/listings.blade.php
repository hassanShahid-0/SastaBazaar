@extends('admin.layout')

@section('title', 'Shop Listings — ' . $shop->name)
@section('page-title', 'Stock Listings: ' . $shop->name)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.shops.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left me-1"></i> Shops
    </a>
    <div>
        <h6 class="fw-bold mb-0">{{ $shop->name }}</h6>
        <small class="text-muted">{{ $shop->address }}</small>
    </div>
    @if($shop->is_verified)
        <span class="badge bg-success ms-auto"><i class="bi bi-patch-check-fill me-1"></i>Verified</span>
    @else
        <span class="badge bg-secondary ms-auto">Not Verified</span>
    @endif
</div>

<div class="row g-4">
    <!-- Add Listing Form -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-transparent border-0 py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2 text-primary"></i>Add Commodity to Stock</h6>
            </div>
            <div class="card-body p-4">
                @if($commodities->isEmpty())
                    <p class="text-muted small">All commodities are already listed for this shop.</p>
                @else
                <form method="POST" action="{{ route('admin.shops.listings.store', $shop) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="commodity_id">Commodity <span class="text-danger">*</span></label>
                        <select name="commodity_id" id="commodity_id" class="form-select @error('commodity_id') is-invalid @enderror" required>
                            <option value="">Select commodity…</option>
                            @foreach($commodities as $commodity)
                                <option value="{{ $commodity->id }}" @selected(old('commodity_id') == $commodity->id)>
                                    {{ $commodity->name }} ({{ $commodity->unit }})
                                </option>
                            @endforeach
                        </select>
                        @error('commodity_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="stock_qty">Stock Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="stock_qty" id="stock_qty" min="0"
                               class="form-control @error('stock_qty') is-invalid @enderror"
                               value="{{ old('stock_qty', 0) }}" required>
                        @error('stock_qty')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="alert alert-info border-0 small mb-3 rounded-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Price is <strong>never set by the shop</strong> — it is always fetched from the official daily price list.
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill w-100">
                        <i class="bi bi-plus-circle me-1"></i> Add to Stock
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Current Listings -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-transparent border-0 py-3 d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0"><i class="bi bi-list-ul me-2 text-success"></i>Current Stock Listings</h6>
                <span class="badge bg-secondary rounded-pill">{{ $listings->count() }} items</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Commodity</th>
                            <th>Unit</th>
                            <th class="text-center">Stock Qty</th>
                            <th class="text-end">Today's Official Price</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listings as $listing)
                        @php $todayPrice = $listing->todayPrice(); @endphp
                        <tr>
                            <td class="fw-semibold">{{ $listing->commodity->name }}</td>
                            <td class="text-muted small">{{ $listing->commodity->unit }}</td>
                            <td class="text-center">{{ $listing->stock_qty }}</td>
                            <td class="text-end">
                                @if($todayPrice)
                                    <span class="fw-bold text-success">Rs {{ number_format($todayPrice->official_price, 2) }}</span>
                                @else
                                    <span class="text-muted small">No price today</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('admin.shops.listings.destroy', [$shop, $listing]) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"
                                            onclick="return confirm('Remove this listing?')">
                                        <i class="bi bi-trash me-1"></i> Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                No listings yet. Add commodities from the left panel.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
