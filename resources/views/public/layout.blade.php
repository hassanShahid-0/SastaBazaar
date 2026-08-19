<!DOCTYPE html>
<html lang="en" x-data="{ dark: localStorage.getItem('sb_dark') === 'true' }"
      :class="dark ? 'dark' : ''" :data-bs-theme="dark ? 'dark' : 'light'">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Daily Price List') | SastaBazaar</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Font: Inter & Noto Nastaliq Urdu / Noto Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Arabic:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- AOS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --sb-primary: #4f46e5;
            --sb-primary-dark: #3730a3;
        }
        * { font-family: 'Inter', system-ui, sans-serif; }
        .font-urdu { font-family: 'Noto Sans Arabic', 'Inter', sans-serif; }

        /* Hero banner */
        .hero-banner {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            color: #fff;
            padding: 3.5rem 0 4rem;
            position: relative;
            overflow: hidden;
        }
        .hero-banner::before {
            content: '';
            position: absolute;
            top: -50%; left: -20%;
            width: 140%; height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 60%);
            pointer-events: none;
        }

        /* Navbar */
        .navbar-public {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--bs-border-color);
            position: sticky; top: 0; z-index: 1050;
            transition: background-color .3s;
        }
        [data-bs-theme=dark] .navbar-public {
            background: rgba(15, 23, 42, 0.95);
        }

        /* Search input glow */
        .search-box {
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border-radius: 50rem;
            overflow: hidden;
        }
        .search-box input {
            border: none;
            padding: 1rem 1.5rem;
            font-size: 1.05rem;
        }
        .search-box input:focus {
            box-shadow: none;
        }

        /* Commodity Card */
        .price-card {
            border: 1px solid var(--bs-border-color);
            border-radius: 1rem;
            transition: transform .25s ease, box-shadow .25s ease;
            background: var(--bs-body-bg);
        }
        .price-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.1);
        }

        /* Badge Price Tag */
        .price-tag {
            font-size: 1.35rem;
            font-weight: 700;
            color: #059669;
        }
        [data-bs-theme=dark] .price-tag {
            color: #34d399;
        }

        /* Footer */
        .footer-public {
            background: #0f172a;
            color: #94a3b8;
            padding: 3rem 0 2rem;
            border-top: 1px solid #1e293b;
        }
        .footer-public a { color: #cbd5e1; text-decoration: none; }
        .footer-public a:hover { color: #a5b4fc; }
    </style>
    @stack('styles')
</head>
<body>

<!-- ════ Navbar ════ -->
<nav class="navbar navbar-expand-lg navbar-public">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-primary" href="{{ route('home') }}">
            <span class="fs-3">🛒</span>
            <span class="fs-4 tracking-tight">Sasta<span class="text-dark-emphasis">Bazaar</span></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPublic">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navPublic">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2 my-2 my-lg-0">
                <li class="nav-item">
                    <a class="nav-link active fw-medium" href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1"></i> Today's Prices
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium text-danger" href="#">
                        <i class="bi bi-exclamation-octagon me-1"></i> Report Overcharging
                    </a>
                </li>
                @auth
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-primary btn-sm rounded-pill px-3" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Admin Dashboard
                        </a>
                    </li>
                @else
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-secondary btn-sm rounded-pill px-3" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Official Login
                        </a>
                    </li>
                @endauth

                <!-- Dark Mode Toggle -->
                <li class="nav-item ms-lg-2">
                    <button class="btn btn-sm btn-outline-secondary rounded-circle p-2"
                            @click="dark = !dark; localStorage.setItem('sb_dark', dark)"
                            :title="dark ? 'Light mode' : 'Dark mode'" style="width:38px; height:38px;">
                        <i class="bi" :class="dark ? 'bi-sun' : 'bi-moon'"></i>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ════ Page Body ════ -->
@yield('content')

<!-- ════ Footer ════ -->
<footer class="footer-public">
    <div class="container text-center text-md-start">
        <div class="row g-4">
            <div class="col-md-6">
                <h5 class="text-white fw-bold mb-2">🛒 SastaBazaar Portal</h5>
                <p class="small mb-3">
                    Official daily commodity price monitoring portal by District Administration. Ensuring fair prices for essential groceries across local markets.
                </p>
                <div class="badge bg-success bg-opacity-20 text-success border border-success border-opacity-25 px-3 py-2">
                    <i class="bi bi-shield-check me-1"></i> Verified District Rates
                </div>
            </div>
            <div class="col-md-3">
                <h6 class="text-white fw-semibold mb-3">Quick Links</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2">
                    <li><a href="{{ route('home') }}">Daily Price List</a></li>
                    <li><a href="#">Register Complaint</a></li>
                    <li><a href="{{ route('login') }}">District Officer Login</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="text-white fw-semibold mb-3">Citizen Support</h6>
                <p class="small mb-1"><i class="bi bi-telephone-fill me-2 text-primary"></i> Toll Free: <strong>0800-12345</strong></p>
                <p class="small mb-0"><i class="bi bi-envelope-fill me-2 text-primary"></i> complaint@sastabazaar.pk</p>
            </div>
        </div>
        <hr class="my-4 border-secondary border-opacity-50">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-muted">
            <p class="mb-0">&copy; {{ date('Y') }} SastaBazaar. District Administration Portal.</p>
            <p class="mb-0">Powered by Laravel Monolith &amp; Bootstrap 5</p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
<!-- AOS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 500, once: true });
</script>
@stack('scripts')
</body>
</html>