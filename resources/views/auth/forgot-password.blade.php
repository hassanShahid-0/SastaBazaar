@extends('public.layout')

@section('title', 'Forgot Password - Official Portal')

@section('content')
<!-- Hero -->
<section class="hero-banner" style="padding: 2.5rem 0 3rem;">
    <div class="container text-center position-relative z-1" data-aos="fade-down">
        <span class="badge bg-primary bg-opacity-80 text-white px-3 py-2 rounded-pill mb-3">
            <i class="bi bi-key-fill me-1"></i> Account Recovery
        </span>
        <h1 class="display-6 fw-bold mb-2">Forgot Your Password?</h1>
        <p class="opacity-90 mx-auto mb-0" style="max-width:520px;">
            No problem. Enter your registered email address and we will email you a secure password reset link.
        </p>
    </div>
</section>

<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-xl-4">

                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden" data-aos="fade-up">
                    <div class="card-header border-0 p-4" style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.12) 0%, rgba(99, 102, 241, 0.22) 100%); border-bottom: 1px solid rgba(79, 70, 229, 0.15);">
                        <h5 class="fw-bold text-primary mb-1">
                            <i class="bi bi-envelope-paper me-2"></i>Reset Password
                        </h5>
                        <p class="text-muted small mb-0">We will send a reset link to your email.</p>
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

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-4">
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
                                           required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary rounded-pill py-2.5 fw-semibold shadow-sm">
                                    <i class="bi bi-send-fill me-2"></i> Email Password Reset Link
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <p class="text-center text-muted small mb-0">
                            Remember your password?
                            <a href="{{ route('login') }}" class="text-primary fw-semibold">Back to Login</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
