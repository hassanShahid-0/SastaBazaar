@extends('public.layout')

@section('title', 'Verify Email - Official Portal')

@section('content')
<!-- Hero -->
<section class="hero-banner" style="padding: 2.5rem 0 3rem;">
    <div class="container text-center position-relative z-1" data-aos="fade-down">
        <span class="badge bg-primary bg-opacity-80 text-white px-3 py-2 rounded-pill mb-3">
            <i class="bi bi-envelope-check-fill me-1"></i> Email Verification
        </span>
        <h1 class="display-6 fw-bold mb-2">Verify Your Email Address</h1>
        <p class="opacity-90 mx-auto mb-0" style="max-width:520px;">
            Please click on the verification link sent to your email to complete registration.
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
                            <i class="bi bi-envelope-check me-2"></i>Check Your Inbox
                        </h5>
                        <p class="text-muted small mb-0">Verification email sent.</p>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted small mb-4">
                            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                        </p>

                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 mb-4 small" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i> A new verification link has been sent to the email address you provided.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="d-flex flex-column gap-3">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary rounded-pill py-2.5 fw-semibold shadow-sm w-100">
                                    <i class="bi bi-arrow-repeat me-2"></i> Resend Verification Email
                                </button>
                            </form>

                            <form method="POST" action="{{ route('logout') }}" class="text-center">
                                @csrf
                                <button type="submit" class="btn btn-link text-danger text-decoration-none small">
                                    <i class="bi bi-box-arrow-left me-1"></i> Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
