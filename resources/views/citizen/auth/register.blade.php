@extends('public.layout')

@section('title', 'Citizen Registration')

@section('content')
<!-- Hero -->
<section class="hero-banner" style="padding: 2.5rem 0 3rem;">
    <div class="container text-center position-relative z-1" data-aos="fade-down">
        <span class="badge bg-success bg-opacity-80 text-white px-3 py-2 rounded-pill mb-3">
            <i class="bi bi-person-plus-fill me-1"></i> New Citizen Account
        </span>
        <h1 class="display-6 fw-bold mb-2">Create Your Citizen Account</h1>
        <p class="opacity-90 mx-auto mb-0" style="max-width:560px;">
            Register once to file complaints, shop at the marketplace, and track your orders.
        </p>
    </div>
</section>

<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden" data-aos="fade-up">
                    <div class="card-header border-0 p-4" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                        <h5 class="fw-bold text-success mb-1">
                            <i class="bi bi-person-badge-fill me-2"></i>Citizen Registration
                        </h5>
                        <p class="text-success text-opacity-75 small mb-0">Join SastaBazaar — free & instant.</p>
                    </div>
                    <div class="card-body p-4">
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

                        <form action="{{ route('citizen.register.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="name">Full Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-person text-muted"></i></span>
                                    <input type="text" name="name" id="name"
                                           class="form-control border-0 bg-light @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" placeholder="e.g. Muhammad Ali" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="phone">
                                    Phone Number <span class="text-danger">*</span>
                                    <small class="text-muted fw-normal">(03XXXXXXXXX — used to log in)</small>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-telephone text-muted"></i></span>
                                    <input type="text" name="phone" id="phone"
                                           class="form-control border-0 bg-light @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}" placeholder="e.g. 03001234567" maxlength="11" required>
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="email">
                                    Email <span class="text-muted fw-normal">(optional)</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" name="email" id="email"
                                           class="form-control border-0 bg-light @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" placeholder="e.g. ali@email.com">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="password">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" name="password" id="password"
                                           class="form-control border-0 bg-light @error('password') is-invalid @enderror"
                                           placeholder="Min. 8 characters" required>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold" for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock-fill text-muted"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="form-control border-0 bg-light"
                                           placeholder="Re-enter your password" required>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success rounded-pill py-2 fw-semibold shadow-sm">
                                    <i class="bi bi-person-plus-fill me-2"></i> Create Account
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">
                        <p class="text-center text-muted small mb-0">
                            Already have an account?
                            <a href="{{ route('citizen.login') }}" class="text-primary fw-semibold">Sign In</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
