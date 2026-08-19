@extends('admin.layout')

@section('title', 'Complaint #' . $complaint->id)
@section('page-title', 'Complaint Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9" data-aos="fade-up">

        <!-- Header row -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Complaint #{{ $complaint->id }}</h4>
                <p class="text-muted small mb-0">Submitted {{ $complaint->created_at->diffForHumans() }} on {{ $complaint->created_at->format('D, d M Y H:i') }}</p>
            </div>
            <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> All Complaints
            </a>
        </div>

        <div class="row g-4">
            <!-- Complaint Info -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-transparent border-0 pt-4 ps-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-file-text me-2 text-primary"></i>Complaint Details</h6>
                    </div>
                    <div class="card-body px-4">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td class="text-muted fw-medium pe-3" width="160">Citizen Name</td>
                                <td class="fw-semibold">{{ $complaint->citizen_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">Phone</td>
                                <td>{{ $complaint->citizen_phone }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">Shop Name</td>
                                <td class="fw-semibold text-danger">{{ $complaint->shop_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">Address</td>
                                <td>{{ $complaint->location_address }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">Status</td>
                                <td>
                                    @if($complaint->isPending())
                                        <span class="badge bg-danger bg-opacity-15 text-danger border border-danger border-opacity-25">Pending</span>
                                    @else
                                        <span class="badge bg-success bg-opacity-15 text-success border border-success border-opacity-25">Resolved</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <hr class="my-3">
                        <h6 class="fw-semibold mb-2 text-muted">Description</h6>
                        <p class="text-dark-emphasis" style="line-height:1.75;">{{ $complaint->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions & Photo -->
            <div class="col-md-4">
                <!-- Action Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 ps-4">
                        <h6 class="fw-bold mb-0"><i class="bi bi-tools me-2 text-warning"></i>Actions</h6>
                    </div>
                    <div class="card-body px-4 pb-4 d-grid gap-2">
                        <form action="{{ route('admin.complaints.toggle', $complaint) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn w-100 {{ $complaint->isPending() ? 'btn-success' : 'btn-outline-warning' }} rounded-pill">
                                <i class="bi {{ $complaint->isPending() ? 'bi-check2-circle' : 'bi-arrow-counterclockwise' }} me-2"></i>
                                {{ $complaint->isPending() ? 'Mark as Resolved' : 'Reopen Complaint' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.complaints.destroy', $complaint) }}" method="POST"
                              onsubmit="return confirm('Permanently delete this complaint?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger rounded-pill w-100">
                                <i class="bi bi-trash me-2"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Photo Evidence -->
                @if($complaint->photo_path)
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-transparent border-0 pt-3 ps-3">
                        <h6 class="fw-bold mb-0 small"><i class="bi bi-image me-2 text-info"></i>Photo Evidence</h6>
                    </div>
                    <div class="card-body p-2">
                        <img src="{{ Storage::url($complaint->photo_path) }}"
                             alt="Complaint photo"
                             class="img-fluid rounded-3 w-100"
                             style="object-fit:cover; max-height:250px;">
                    </div>
                </div>
                @else
                <div class="card border-0 bg-light rounded-4 text-center py-4 text-muted">
                    <i class="bi bi-image fs-2 d-block mb-2 opacity-40"></i>
                    <small>No photo provided</small>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection