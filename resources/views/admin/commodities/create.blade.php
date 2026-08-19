@extends('admin.layout')

@section('title', 'Add Commodity')
@section('page-title', 'Add Commodity')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7" data-aos="fade-up">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 ps-4">
                <h5 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2 text-primary"></i>New Commodity</h5>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('admin.commodities.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="name">English Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="e.g. Sugar" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="urdu_name">Urdu Name</label>
                        <input type="text" name="urdu_name" id="urdu_name"
                               class="form-control @error('urdu_name') is-invalid @enderror"
                               value="{{ old('urdu_name') }}" placeholder="e.g. چینی" dir="rtl">
                        @error('urdu_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" for="unit">Unit of Measurement <span class="text-danger">*</span></label>
                        <select name="unit" id="unit"
                                class="form-select @error('unit') is-invalid @enderror" required>
                            <option value="">-- Select unit --</option>
                            @foreach(['kg','gram','litre','dozen','piece','bag (50kg)','maund'] as $u)
                                <option value="{{ $u }}" {{ old('unit') == $u ? 'selected' : '' }}>{{ $u }}</option>
                            @endforeach
                        </select>
                        @error('unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Save Commodity
                        </button>
                        <a href="{{ route('admin.commodities.index') }}" class="btn btn-outline-secondary px-4">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
