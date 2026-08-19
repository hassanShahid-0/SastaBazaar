@extends('admin.layout')

@section('title', 'Complaints')
@section('page-title', 'Citizen Complaints')

@section('content')
<!-- Metrics -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
        <div class="card border-0 h-100" style="background:linear-gradient(135deg,#7c3aed,#a855f7);">
            <div class="card-body d-flex justify-content-between align-items-center text-white">
                <div><p class="small mb-1 opacity-75">Total Complaints</p><h3 class="fw-bold mb-0">{{ $totalComplaints }}</h3></div>
                <i class="bi bi-chat-square-text fs-1 opacity-40"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
        <div class="card border-0 h-100" style="background:linear-gradient(135deg,#dc2626,#f87171);">
            <div class="card-body d-flex justify-content-between align-items-center text-white">
                <div><p class="small mb-1 opacity-75">Pending</p><h3 class="fw-bold mb-0">{{ $pendingCount }}</h3></div>
                <i class="bi bi-hourglass-split fs-1 opacity-40"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
        <div class="card border-0 h-100" style="background:linear-gradient(135deg,#059669,#34d399);">
            <div class="card-body d-flex justify-content-between align-items-center text-white">
                <div><p class="small mb-1 opacity-75">Resolved</p><h3 class="fw-bold mb-0">{{ $resolvedCount }}</h3></div>
                <i class="bi bi-check-circle fs-1 opacity-40"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
        <div class="card border-0 bg-warning bg-opacity-10 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="small text-muted mb-1">Most Complained Shop</p>
                    <h6 class="fw-bold mb-0">{{ $topShop?->shop_name ?? '—' }}</h6>
                    <small class="text-muted">{{ $topShop?->total ?? 0 }} complaints</small>
                </div>
                <i class="bi bi-shop fs-1 text-warning opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filter + Table -->
<div class="card border-0 shadow-sm" data-aos="fade-up">
    <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <h6 class="fw-bold mb-0"><i class="bi bi-funnel me-2 text-primary"></i>Complaint Records</h6>
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('admin.complaints.index') }}" class="btn {{ $status === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">All</a>
            <a href="{{ route('admin.complaints.index', ['status' => 'pending']) }}" class="btn {{ $status === 'pending' ? 'btn-danger' : 'btn-outline-secondary' }}">Pending</a>
            <a href="{{ route('admin.complaints.index', ['status' => 'resolved']) }}" class="btn {{ $status === 'resolved' ? 'btn-success' : 'btn-outline-secondary' }}">Resolved</a>
        </div>
    </div>
    <div class="card-body p-0">
        @if($complaints->count())
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3">#</th>
                        <th class="py-3">Citizen</th>
                        <th class="py-3">Shop</th>
                        <th class="py-3">Address</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Date</th>
                        <th class="text-end pe-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($complaints as $complaint)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $complaint->id }}</td>
                        <td>
                            <div class="fw-semibold">{{ $complaint->citizen_name }}</div>
                            <small class="text-muted">{{ $complaint->citizen_phone }}</small>
                        </td>
                        <td class="fw-medium">{{ $complaint->shop_name }}</td>
                        <td class="text-muted small" style="max-width:180px;">{{ Str::limit($complaint->location_address, 50) }}</td>
                        <td>
                            @if($complaint->isPending())
                                <span class="badge bg-danger bg-opacity-15 text-danger border border-danger border-opacity-25 px-2 py-1">
                                    <i class="bi bi-clock me-1"></i>Pending
                                </span>
                            @else
                                <span class="badge bg-success bg-opacity-15 text-success border border-success border-opacity-25 px-2 py-1">
                                    <i class="bi bi-check2 me-1"></i>Resolved
                                </span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $complaint->created_at->format('d M Y') }}</td>
                        <td class="text-end pe-4">
                            <div class="d-flex gap-1 justify-content-end">
                                <a href="{{ route('admin.complaints.show', $complaint) }}" class="btn btn-sm btn-outline-secondary" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('admin.complaints.toggle', $complaint) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $complaint->isPending() ? 'btn-outline-success' : 'btn-outline-warning' }}"
                                            title="{{ $complaint->isPending() ? 'Mark Resolved' : 'Reopen' }}">
                                        <i class="bi {{ $complaint->isPending() ? 'bi-check2' : 'bi-arrow-counterclockwise' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.complaints.destroy', $complaint) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this complaint permanently?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $complaints->links() }}</div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
            No complaints found.
        </div>
        @endif
    </div>
</div>
@endsection