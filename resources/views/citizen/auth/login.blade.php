@extends('public.layout')

@section('title', 'Citizen Login')

@section('content')
<!-- Hero -->
<section class="hero-banner" style="padding: 2.5rem 0 3rem;">
    <div class="container text-center position-relative z-1" data-aos="fade-down">
        <span class="badge bg-primary bg-opacity-80 text-white px-3 py-2 rounded-pill mb-3">
            <i class="bi bi-person-fill me-1"></i> Citizen Portal
        </span>
        <h1 class="display-6 fw-bold mb-2">Sign In to Your Account</h1>
        <p class="opacity-90 mx-auto mb-0" style="max-width:500px;">
            Use your registered phone number and password to continue.
        </p>
    </div>
</section>

<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-xl-4">

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden" data-aos="fade-up">
                    <div class="card-header border-0 p-4" style="background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);">
                        <h5 class="fw-bold text-primary mb-1">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Citizen Login
                        </h5>
                        <p class="text-primary text-opacity-75 small mb-0">Enter your phone number and password below.</p>
                    </div>
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger border-0 rounded-3 mb-4">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Login failed:</strong>
                                <ul class="mb-0 mt-2 ps-3 small">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('citizen.login.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="phone">
                                    Phone Number <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-telephone text-muted"></i></span>
                                    <input type="text" name="phone" id="phone"
                                           class="form-control border-0 bg-light @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}" placeholder="e.g. 03001234567" maxlength="11" required autofocus>
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold" for="password">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" name="password" id="password"
                                           class="form-control border-0 bg-light @error('password') is-invalid @enderror"
                                           placeholder="Your password" required>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label small text-muted" for="remember">Remember me</label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary rounded-pill py-2 fw-semibold shadow-sm">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">
                        <p class="text-center text-muted small mb-0">
                            Don't have an account?
                            <a href="{{ route('citizen.register') }}" class="text-success fw-semibold">Register Free</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
