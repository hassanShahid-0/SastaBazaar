@extends('public.layout')

@section('title', 'Confirm Password - Official Portal')

@section('content')
<!-- Hero -->
<section class="hero-banner" style="padding: 2.5rem 0 3rem;">
    <div class="container text-center position-relative z-1" data-aos="fade-down">
        <span class="badge bg-danger bg-opacity-80 text-white px-3 py-2 rounded-pill mb-3">
            <i class="bi bi-shield-lock-fill me-1"></i> Security Verification
        </span>
        <h1 class="display-6 fw-bold mb-2">Confirm Your Password</h1>
        <p class="opacity-90 mx-auto mb-0" style="max-width:520px;">
            This is a secure area of SastaBazaar. Please confirm your password before continuing.
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
                            <i class="bi bi-lock me-2"></i>Authentication Required
                        </h5>
                        <p class="text-muted small mb-0">Confirm your identity to proceed.</p>
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

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <!-- Password -->
                            <div class="mb-4" x-data="{ showPass: false }">
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
                                           placeholder="Enter your current password"
                                           required autocomplete="current-password" autofocus>
                                    <button type="button" class="btn bg-light border-0 text-muted"
                                            @click="showPass = !showPass" tabindex="-1">
                                        <i class="bi" :class="showPass ? 'bi-eye-slash' : 'bi-eye'"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary rounded-pill py-2.5 fw-semibold shadow-sm">
                                    <i class="bi bi-shield-check me-2"></i> Confirm
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
