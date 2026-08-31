@extends('admin.layout')

@section('title', 'Citizen Management')
@section('page-title', 'Citizen Management')

@section('content')
<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card metric-card border-0 shadow-sm h-100" style="background: linear-gradient(135deg,#6366f1,#4f46e5); color:#fff;">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-people-fill fs-2"></i>
                <div>
                    <div class="fs-4 fw-bold">{{ $totalCitizens }}</div>
                    <div class="small opacity-90">Total Citizens</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card metric-card border-0 shadow-sm h-100" style="background: linear-gradient(135deg,#ef4444,#dc2626); color:#fff;">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-slash-circle-fill fs-2"></i>
                <div>
                    <div class="fs-4 fw-bold">{{ $blockedCount }}</div>
                    <div class="small opacity-90">Blocked</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card metric-card border-0 shadow-sm h-100" style="background: linear-gradient(135deg,#10b981,#059669); color:#fff;">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-person-check-fill fs-2"></i>
                <div>
                    <div class="fs-4 fw-bold">{{ $totalCitizens - $blockedCount }}</div>
                    <div class="small opacity-90">Active</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body p-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name or phone…" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Citizens</option>
                    <option value="active" @selected(request('status') === 'active')>Active Only</option>
                    <option value="blocked" @selected(request('status') === 'blocked')>Blocked Only</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-primary w-100">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.citizens.index') }}" class="btn btn-sm btn-outline-secondary w-100">
                    <i class="bi bi-x-circle me-1"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Citizens Table -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-transparent border-0 py-3 d-flex align-items-center justify-content-between">
        <h6 class="fw-bold mb-0"><i class="bi bi-people me-2 text-primary"></i>Registered Citizens</h6>
        <span class="badge bg-secondary rounded-pill">{{ $citizens->total() }} total</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th class="text-center">Complaints</th>
                    <th class="text-center">Status</th>
                    <th>Blocked Reason</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($citizens as $citizen)
                <tr>
                    <td class="text-muted small">{{ $citizen->id }}</td>
                    <td class="fw-semibold">{{ $citizen->name }}</td>
                    <td><code>{{ $citizen->phone }}</code></td>
                    <td class="text-muted small">{{ $citizen->email ?? '—' }}</td>
                    <td class="text-center">
                        <span class="badge bg-primary rounded-pill">{{ $citizen->complaints_count }}</span>
                    </td>
                    <td class="text-center">
                        @if($citizen->is_blocked)
                            <span class="badge bg-danger"><i class="bi bi-slash-circle me-1"></i>Blocked</span>
                        @else
                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Active</span>
                        @endif
                    </td>
                    <td class="text-muted small" style="max-width:200px;">
                        @if($citizen->blocked_reason)
                            <span title="{{ $citizen->blocked_reason }}">
                                {{ Str::limit($citizen->blocked_reason, 60) }}
                            </span>
                        @else
                            —
                        @endif
                    </td>
                    <td class="text-center">
                        @if($citizen->is_blocked)
                            <!-- Unblock form -->
                            <form method="POST" action="{{ route('admin.citizens.toggleBlock', $citizen) }}" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success rounded-pill"
                                        onclick="return confirm('Unblock {{ addslashes($citizen->name) }}?')">
                                    <i class="bi bi-unlock me-1"></i> Unblock
                                </button>
                            </form>
                        @else
                            <!-- Block button triggers modal -->
                            <button type="button" class="btn btn-sm btn-danger rounded-pill"
                                    data-bs-toggle="modal"
                                    data-bs-target="#blockModal"
                                    data-citizen-id="{{ $citizen->id }}"
                                    data-citizen-name="{{ $citizen->name }}"
                                    data-action="{{ route('admin.citizens.toggleBlock', $citizen) }}">
                                <i class="bi bi-slash-circle me-1"></i> Block
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="bi bi-people fs-2 d-block mb-2 opacity-50"></i>
                        No citizens found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($citizens->hasPages())
    <div class="card-footer bg-transparent">
        {{ $citizens->links() }}
    </div>
    @endif
</div>

<!-- Block Modal -->
<div class="modal fade" id="blockModal" tabindex="-1" aria-labelledby="blockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="blockModalLabel">
                    <i class="bi bi-slash-circle me-2"></i>Block Citizen
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="blockForm" method="POST">
                @csrf @method('PATCH')
                <div class="modal-body">
                    <p class="text-muted mb-3">
                        You are about to block <strong id="blockCitizenName"></strong>.
                        They will be immediately logged out and unable to log in again.
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="blocked_reason">
                            Reason <span class="text-muted fw-normal">(optional)</span>
                        </label>
                        <textarea name="blocked_reason" id="blocked_reason" rows="3"
                                  class="form-control"
                                  placeholder="e.g. Filed fraudulent complaints, suspicious activity…"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-pill">
                        <i class="bi bi-slash-circle me-1"></i> Confirm Block
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const blockModal = document.getElementById('blockModal');
    blockModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('blockCitizenName').textContent = button.getAttribute('data-citizen-name');
        document.getElementById('blockForm').action = button.getAttribute('data-action');
        document.getElementById('blocked_reason').value = '';
    });
</script>
@endpush
