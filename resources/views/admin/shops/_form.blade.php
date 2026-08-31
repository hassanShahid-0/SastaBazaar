{{-- Shared form fields for create / edit shop --}}

@if($errors->any())
    <div class="alert alert-danger border-0 rounded-3 mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Please fix the following:</strong>
        <ul class="mb-0 mt-2 ps-3 small">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold" for="name">Shop Name <span class="text-danger">*</span></label>
        <input type="text" name="name" id="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $shop?->name) }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold" for="owner_name">Owner Name <span class="text-danger">*</span></label>
        <input type="text" name="owner_name" id="owner_name"
               class="form-control @error('owner_name') is-invalid @enderror"
               value="{{ old('owner_name', $shop?->owner_name) }}" required>
        @error('owner_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold" for="phone">Phone <span class="text-danger">*</span></label>
        <input type="text" name="phone" id="phone"
               class="form-control @error('phone') is-invalid @enderror"
               value="{{ old('phone', $shop?->phone) }}" required>
        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold" for="is_active">Status</label>
        <select name="is_active" id="is_active" class="form-select">
            <option value="1" @selected(old('is_active', $shop?->is_active ?? true))>Active</option>
            <option value="0" @selected(! old('is_active', $shop?->is_active ?? true))>Inactive</option>
        </select>
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold" for="address">Address <span class="text-danger">*</span></label>
        <textarea name="address" id="address" rows="2"
                  class="form-control @error('address') is-invalid @enderror"
                  required>{{ old('address', $shop?->address) }}</textarea>
        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
