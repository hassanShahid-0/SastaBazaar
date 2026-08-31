@extends('admin.layout')

@section('title', 'Shop Management')
@section('page-title', 'Shop Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-shop me-2 text-primary"></i>Shops</h5>
    <a href="{{ route('admin.shops.create') }}" class="btn btn-primary rounded-pill">
        <i class="bi bi-plus-circle me-1"></i> Add Shop
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Shop Name</th>
                    <th>Owner</th>
                    <th>Phone</th>
                    <th class="text-center">Listings</th>
                    <th class="text-center">Orders</th>
                    <th class="text-center">Verified</th>
                    <th class="text-center">Active</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shops as $shop)
                <tr>
                    <td class="text-muted small">{{ $shop->id }}</td>
                    <td class="fw-semibold">{{ $shop->name }}</td>
                    <td>{{ $shop->owner_name }}</td>
                    <td><code>{{ $shop->phone }}</code></td>
                    <td class="text-center"><span class="badge bg-info rounded-pill">{{ $shop->listings_count }}</span></td>
                    <td class="text-center"><span class="badge bg-primary rounded-pill">{{ $shop->orders_count }}</span></td>
                    <td class="text-center">
                        <form method="POST" action="{{ route('admin.shops.verify', $shop) }}" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $shop->is_verified ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill">
                                <i class="bi {{ $shop->is_verified ? 'bi-patch-check-fill' : 'bi-patch-check' }} me-1"></i>
                                {{ $shop->is_verified ? 'Verified' : 'Verify' }}
                            </button>
                        </form>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $shop->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $shop->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.shops.listings.index', $shop) }}" class="btn btn-outline-info rounded-start-pill" title="Manage Listings">
                                <i class="bi bi-list-ul"></i>
                            </a>
                            <a href="{{ route('admin.shops.edit', $shop) }}" class="btn btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.shops.destroy', $shop) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger rounded-end-pill" title="Delete"
                                        onclick="return confirm('Delete shop {{ addslashes($shop->name) }}?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        <i class="bi bi-shop fs-2 d-block mb-2 opacity-50"></i>
                        No shops yet. <a href="{{ route('admin.shops.create') }}">Add the first shop</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($shops->hasPages())
    <div class="card-footer bg-transparent">{{ $shops->links() }}</div>
    @endif
</div>
@endsection
