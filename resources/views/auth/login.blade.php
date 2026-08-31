@extends('public.layout')

@section('title', 'Official & Admin Login')

@section('content')
<!-- Hero -->
<section class="hero-banner" style="padding: 2.5rem 0 3rem;">
    <div class="container text-center position-relative z-1" data-aos="fade-down">
        <span class="badge bg-primary bg-opacity-80 text-white px-3 py-2 rounded-pill mb-3">
            <i class="bi bi-shield-lock-fill me-1"></i> Official Portal
        </span>
        <h1 class="display-6 fw-bold mb-2">District Officer &amp; Admin Login</h1>
        <p class="opacity-90 mx-auto mb-0" style="max-width:540px;">
            Access price monitoring, complaints resolution, marketplace supervision, and administrative tools.
        </p>
    </div>
</section>

<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-xl-4">

                @if(session('status'))
                    <div class="alert alert-info alert-dismissible fade show rounded-4 border-0 mb-4" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i> {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

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
                    <div class="card-header border-0 p-4" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.12) 0%, rgba(99, 102, 241, 0.22) 100%); border-bottom: 1px solid rgba(79, 70, 229, 0.15);">
                        <h5 class="fw-bold text-primary mb-1">
                            <i class="bi bi-shield-lock me-2"></i>Official Login
                        </h5>
                        <p class="text-muted small mb-0">Authorized district staff and administration only.</p>
                    </div>
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger border-0 rounded-3 mb-4">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    <strong>Authentication Failed</strong>
                                </div>
                                <ul class="mb-0 ps-3 small">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="email">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input type="email" name="email" id="email"
                                           class="form-control border-0 bg-light @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" placeholder="e.g. admin@sastabazaar.pk"
                                           required autofocus autocomplete="username">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3" x-data="{ showPassword: false }">
                                <label class="form-label fw-semibold" for="password">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input :type="showPassword ? 'text' : 'password'"
                                           name="password" id="password"
                                           class="form-control border-0 bg-light @error('password') is-invalid @enderror"
                                           placeholder="Enter your password"
                                           required autocomplete="current-password">
                                    <button type="button" class="btn bg-light border-0 text-muted"
                                            @click="showPassword = !showPassword"
                                            tabindex="-1"
                                            title="Toggle password visibility">
                                        <i class="bi" :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                    <label class="form-check-label small text-muted" for="remember_me">
                                        Remember me
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="small text-primary fw-medium text-decoration-none">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary rounded-pill py-2 fw-semibold shadow-sm">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Sign In to Portal
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <p class="text-center text-muted small mb-3">
                            Looking for citizen services?
                            <a href="{{ route('citizen.login') }}" class="text-success fw-semibold">Citizen Login</a>
                        </p>

                        <div class="p-2 bg-body-secondary rounded-3 text-center small text-muted">
                            <i class="bi bi-shield-check text-primary me-1"></i> Authorized Personnel Only &bull; 256-bit SSL
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
