@extends('public.layout')

@section('title', 'Official Registration')

@section('content')
<!-- Hero -->
<section class="hero-banner" style="padding: 2.5rem 0 3rem;">
    <div class="container text-center position-relative z-1" data-aos="fade-down">
        <span class="badge bg-primary bg-opacity-80 text-white px-3 py-2 rounded-pill mb-3">
            <i class="bi bi-person-plus-fill me-1"></i> Staff Onboarding
        </span>
        <h1 class="display-6 fw-bold mb-2">Create Official Account</h1>
        <p class="opacity-90 mx-auto mb-0" style="max-width:540px;">
            Register as an authorized officer to manage prices, commodities, and district reports.
        </p>
    </div>
</section>

<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden" data-aos="fade-up">
                    <div class="card-header border-0 p-4" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.12) 0%, rgba(99, 102, 241, 0.22) 100%); border-bottom: 1px solid rgba(79, 70, 229, 0.15);">
                        <h5 class="fw-bold text-primary mb-1">
                            <i class="bi bi-person-badge me-2"></i>Official Registration
                        </h5>
                        <p class="text-muted small mb-0">Enter your official credentials.</p>
                    </div>
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger border-0 rounded-3 mb-4">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    <strong>Registration Failed</strong>
                                </div>
                                <ul class="mb-0 ps-3 small">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="name">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-person text-muted"></i>
                                    </span>
                                    <input type="text" name="name" id="name"
                                           class="form-control border-0 bg-light @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" placeholder="e.g. Officer Ahmed"
                                           required autofocus autocomplete="name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="email">
                                    Official Email Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input type="email" name="email" id="email"
                                           class="form-control border-0 bg-light @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" placeholder="e.g. ahmed@sastabazaar.pk"
                                           required autocomplete="username">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3" x-data="{ showPass: false }">
                                <label class="form-label fw-semibold" for="password">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input :type="showPass ? 'text' : 'password'"
                                           name="password" id="password"
                                           class="form-control border-0 bg-light @error('password') is-invalid @enderror"
                                           placeholder="Enter a secure password"
                                           required autocomplete="new-password">
                                    <button type="button" class="btn bg-light border-0 text-muted"
                                            @click="showPass = !showPass" tabindex="-1">
                                        <i class="bi" :class="showPass ? 'bi-eye-slash' : 'bi-eye'"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4" x-data="{ showConfirm: false }">
                                <label class="form-label fw-semibold" for="password_confirmation">
                                    Confirm Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-lock-fill text-muted"></i>
                                    </span>
                                    <input :type="showConfirm ? 'text' : 'password'"
                                           name="password_confirmation" id="password_confirmation"
                                           class="form-control border-0 bg-light @error('password_confirmation') is-invalid @enderror"
                                           placeholder="Re-enter password"
                                           required autocomplete="new-password">
                                    <button type="button" class="btn bg-light border-0 text-muted"
                                            @click="showConfirm = !showConfirm" tabindex="-1">
                                        <i class="bi" :class="showConfirm ? 'bi-eye-slash' : 'bi-eye'"></i>
                                    </button>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary rounded-pill py-2.5 fw-semibold shadow-sm">
                                    <i class="bi bi-person-check-fill me-2"></i> Register Official Account
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <p class="text-center text-muted small mb-0">
                            Already have an official account?
                            <a href="{{ route('login') }}" class="text-primary fw-semibold">Sign In</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
