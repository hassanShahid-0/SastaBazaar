@extends('admin.layout')

@section('title', 'Order Management')
@section('page-title', 'Order Management')

@section('content')
<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-sm-3">
        <div class="card metric-card border-0 shadow-sm h-100" style="background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-bag-check-fill fs-2"></i>
                <div><div class="fs-4 fw-bold">{{ $totalOrders }}</div><div class="small opacity-90">Total Orders</div></div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card metric-card border-0 shadow-sm h-100" style="background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-clock-history fs-2"></i>
                <div><div class="fs-4 fw-bold">{{ $pendingOrders }}</div><div class="small opacity-90">Pending</div></div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card metric-card border-0 shadow-sm h-100" style="background:linear-gradient(135deg,#10b981,#059669);color:#fff;">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-truck fs-2"></i>
                <div><div class="fs-4 fw-bold">{{ $deliveredOrders }}</div><div class="small opacity-90">Delivered</div></div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card metric-card border-0 shadow-sm h-100" style="background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-cash-stack fs-2"></i>
                <div><div class="fs-4 fw-bold">Rs {{ number_format($totalRevenue, 0) }}</div><div class="small opacity-90">Total Revenue</div></div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body p-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by citizen name/phone…" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    @foreach(\App\Models\Order::statuses() as $s)
                        <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search me-1"></i>Filter</button>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Citizen</th>
                    <th>Shop</th>
                    <th class="text-end">Total</th>
                    <th class="text-center">Status</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="text-muted small">{{ $order->id }}</td>
                    <td>
                        <div class="fw-semibold">{{ $order->citizen->name }}</div>
                        <small class="text-muted">{{ $order->citizen->phone }}</small>
                    </td>
                    <td>{{ $order->shop->name }}</td>
                    <td class="text-end fw-bold">Rs {{ number_format($order->total_amount, 2) }}</td>
                    <td class="text-center">
                        @php
                            $statusColors = ['Pending'=>'warning','Processing'=>'info','Delivered'=>'success','Cancelled'=>'secondary'];
                            $color = $statusColors[$order->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $color }}">{{ $order->status }}</span>
                    </td>
                    <td class="text-muted small">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="bi bi-eye me-1"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-bag fs-2 d-block mb-2 opacity-50"></i>
                        No orders found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-transparent">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
