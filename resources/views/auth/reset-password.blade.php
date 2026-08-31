@extends('public.layout')

@section('title', 'Set New Password - Official Portal')

@section('content')
<!-- Hero -->
<section class="hero-banner" style="padding: 2.5rem 0 3rem;">
    <div class="container text-center position-relative z-1" data-aos="fade-down">
        <span class="badge bg-primary bg-opacity-80 text-white px-3 py-2 rounded-pill mb-3">
            <i class="bi bi-shield-lock-fill me-1"></i> Security Credentials
        </span>
        <h1 class="display-6 fw-bold mb-2">Create New Password</h1>
        <p class="opacity-90 mx-auto mb-0" style="max-width:520px;">
            Set a strong and secure password for your official account.
        </p>
    </div>
</section>

<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-xl-4">

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden" data-aos="fade-up">
                    <div class="card-header border-0 p-4" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.12) 0%, rgba(99, 102, 241, 0.22) 100%); border-bottom: 1px solid rgba(79, 70, 229, 0.15);">
                        <h5 class="fw-bold text-primary mb-1">
                            <i class="bi bi-key me-2"></i>Reset Your Password
                        </h5>
                        <p class="text-muted small mb-0">Enter your email and chosen new password below.</p>
                    </div>
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger border-0 rounded-3 mb-4">
                                <ul class="mb-0 ps-3 small">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                                           value="{{ old('email', $request->email) }}"
                                           required autofocus autocomplete="username">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3" x-data="{ showPass: false }">
                                <label class="form-label fw-semibold" for="password">
                                    New Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input :type="showPass ? 'text' : 'password'"
                                           name="password" id="password"
                                           class="form-control border-0 bg-light @error('password') is-invalid @enderror"
                                           placeholder="Enter new password"
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
                                    Confirm New Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-lock-fill text-muted"></i>
                                    </span>
                                    <input :type="showConfirm ? 'text' : 'password'"
                                           name="password_confirmation" id="password_confirmation"
                                           class="form-control border-0 bg-light @error('password_confirmation') is-invalid @enderror"
                                           placeholder="Confirm new password"
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
                                    <i class="bi bi-check-lg me-2"></i> Reset Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
