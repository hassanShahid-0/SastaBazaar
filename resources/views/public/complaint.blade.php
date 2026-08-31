@extends('public.layout')

@section('title', 'File a Complaint - SastaBazaar')

@section('content')
<!-- Hero Banner -->
<section class="hero-banner" style="padding: 2.5rem 0 3rem;">
    <div class="container text-center position-relative z-1" data-aos="fade-down">
        <span class="badge bg-danger bg-opacity-80 text-white px-3 py-2 rounded-pill mb-3">
            <i class="bi bi-exclamation-octagon-fill me-1"></i> Citizen Complaint Portal
        </span>
        <h1 class="display-6 fw-bold mb-2">Report Overcharging</h1>
        <p class="opacity-90 mx-auto mb-0" style="max-width:600px;">
            If a shopkeeper is selling commodities above official district rates, report them here. Your complaint will be reviewed by the District Administration.
        </p>
    </div>
</section>

<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 p-4 mb-4" role="alert" data-aos="fade-up">
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-check-circle-fill fs-3 text-success mt-1"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Complaint Submitted!</h5>
                                <p class="mb-0">{{ session('success') }}</p>
                                <p class="text-muted small mt-2 mb-0">The District Administration will review your complaint promptly. Fraudulent complaints may be subject to action.</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden" data-aos="fade-up">
                    <!-- Card Header -->
                    <div class="card-header border-0 p-4" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
                        <h5 class="fw-bold text-danger mb-1">
                            <i class="bi bi-megaphone-fill me-2"></i>Complaint Form
                        </h5>
                        <p class="text-danger text-opacity-75 small mb-0">All fields marked with <span class="fw-bold">*</span> are required. Your information is kept confidential.</p>
                    </div>

                    <div class="card-body p-4">
                        @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2 ps-3 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Citizen Info (auto-filled from account) -->
                            <h6 class="fw-semibold text-muted text-uppercase small mb-3 mt-1 letter-spacing-1">
                                <i class="bi bi-person-fill me-1"></i> Your Information
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 ms-2 fw-normal text-capitalize" style="font-size:.7rem;">Auto-filled from your account</span>
                            </h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="citizen_name">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-person text-success"></i></span>
                                        <input type="text" id="citizen_name"
                                               class="form-control border-0 bg-light"
                                               value="{{ $citizen->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="citizen_phone">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-telephone text-success"></i></span>
                                        <input type="text" id="citizen_phone"
                                               class="form-control border-0 bg-light"
                                               value="{{ $citizen->phone }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Shop Info -->
                            <h6 class="fw-semibold text-muted text-uppercase small mb-3 letter-spacing-1">
                                <i class="bi bi-shop me-1"></i> Shop Details
                            </h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="shop_name">Shop / Vendor Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-shop text-muted"></i></span>
                                    <input type="text" name="shop_name" id="shop_name"
                                           class="form-control border-0 bg-light @error('shop_name') is-invalid @enderror"
                                           value="{{ old('shop_name') }}" placeholder="e.g. Malik General Store" required>
                                    @error('shop_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold" for="location_address">Shop Address / Location <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 align-items-start pt-2"><i class="bi bi-geo-alt text-muted"></i></span>
                                    <textarea name="location_address" id="location_address" rows="2"
                                              class="form-control border-0 bg-light @error('location_address') is-invalid @enderror"
                                              placeholder="e.g. Near Main Bazaar, Sector F-7, Islamabad" required>{{ old('location_address') }}</textarea>
                                    @error('location_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <!-- Complaint Description -->
                            <h6 class="fw-semibold text-muted text-uppercase small mb-3 letter-spacing-1">
                                <i class="bi bi-file-text me-1"></i> Complaint Details
                            </h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="description">
                                    Description <span class="text-danger">*</span>
                                    <small class="text-muted fw-normal">(min. 20 characters)</small>
                                </label>
                                <textarea name="description" id="description" rows="4"
                                          class="form-control bg-light border-0 @error('description') is-invalid @enderror"
                                          placeholder="Describe the overcharging incident in detail — which item was overcharged, what price was charged vs official rate, approximate date/time, etc."
                                          required minlength="20">{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Photo Upload -->
                            <div class="mb-4"
                                 x-data="{ fileName: '' }">
                                <label class="form-label fw-semibold" for="photo">
                                    Photo Evidence <span class="text-muted fw-normal">(optional)</span>
                                    <small class="text-muted d-block fw-normal mt-1">JPG / PNG / WEBP — max 3 MB</small>
                                </label>
                                <div class="border rounded-3 bg-light p-3 text-center position-relative"
                                     :class="fileName ? 'border-success' : 'border-dashed'">
                                    <input type="file" name="photo" id="photo"
                                           class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer @error('photo') is-invalid @enderror"
                                           accept="image/jpg,image/jpeg,image/png,image/webp"
                                           @change="fileName = $event.target.files[0]?.name || ''">
                                    <div x-show="!fileName">
                                        <i class="bi bi-cloud-upload fs-2 text-muted d-block mb-2"></i>
                                        <p class="mb-0 text-muted small">Click or drag & drop a photo here</p>
                                    </div>
                                    <div x-show="fileName" x-transition>
                                        <i class="bi bi-image fs-2 text-success d-block mb-1"></i>
                                        <p class="mb-0 fw-semibold text-success small" x-text="fileName"></p>
                                    </div>
                                </div>
                                @error('photo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- Declaration -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="declaration" required>
                                    <label class="form-check-label small text-muted" for="declaration">
                                        I declare that the above information is accurate to the best of my knowledge. I understand that filing a false complaint is a punishable offence.
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex">
                                <button type="submit" class="btn btn-danger px-5 py-2 rounded-pill fw-semibold shadow-sm">
                                    <i class="bi bi-send-fill me-2"></i> Submit Complaint
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                    <i class="bi bi-arrow-left me-1"></i> Back to Price List
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card border-0 bg-info bg-opacity-10 rounded-4 mt-4 p-4 shadow-sm" data-aos="fade-up">
                    <h6 class="fw-bold text-info mb-2"><i class="bi bi-shield-check-fill me-2"></i>Your Privacy is Protected</h6>
                    <p class="text-muted small mb-0">Your contact information is only used to process this complaint and will not be publicly displayed. District Administration officers will contact you if they need further details.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection