@extends('admin.layout')

@section('title', 'Commodities')
@section('page-title', 'Commodities')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <div>
        <h4 class="fw-bold mb-0">Commodity List</h4>
        <p class="text-muted small mb-0">Manage all tracked commodities</p>
    </div>
    <a href="{{ route('admin.commodities.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Add Commodity
    </a>
</div>

<div class="card border-0 shadow-sm" data-aos="fade-up">
    <div class="card-body p-0">
        @if($commodities->count())
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>English Name</th>
                        <th>Urdu Name</th>
                        <th>Unit</th>
                        <th>Created</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commodities as $commodity)
                    <tr style="animation: fadeIn .4s ease both; animation-delay: {{ $loop->index * 40 }}ms">
                        <td class="ps-4 text-muted">{{ $loop->iteration + ($commodities->currentPage()-1) * $commodities->perPage() }}</td>
                        <td class="fw-semibold">{{ $commodity->name }}</td>
                        <td>{{ $commodity->urdu_name ?? '—' }}</td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $commodity->unit }}</span></td>
                        <td class="text-muted small">{{ $commodity->created_at->format('d M Y') }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.commodities.edit', $commodity) }}"
                               class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.commodities.destroy', $commodity) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete {{ $commodity->name }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $commodities->links() }}
        </div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
            No commodities found. <a href="{{ route('admin.commodities.create') }}">Add one now</a>.
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
@keyframes fadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
</style>
@endpush
@endsection
