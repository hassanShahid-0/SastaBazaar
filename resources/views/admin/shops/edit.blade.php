@extends('admin.layout')

@section('title', 'Edit Shop')
@section('page-title', 'Edit Shop')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-transparent border-0 py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-pencil me-2 text-primary"></i>Edit: {{ $shop->name }}</h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.shops.update', $shop) }}">
                    @csrf @method('PUT')
                    @include('admin.shops._form', ['shop' => $shop])
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-check-circle me-1"></i> Save Changes
                        </button>
                        <a href="{{ route('admin.shops.index') }}" class="btn btn-outline-secondary rounded-pill">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
