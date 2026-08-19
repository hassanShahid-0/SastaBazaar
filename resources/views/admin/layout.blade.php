<!DOCTYPE html>
<html lang="en" x-data="{ dark: localStorage.getItem('sb_dark') === 'true' }"
      :class="dark ? 'dark' : ''" :data-bs-theme="dark ? 'dark' : 'light'">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | SastaBazaar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        :root { --sb-sidebar-w: 260px; }
        * { font-family: "Inter", sans-serif; }
        .sb-sidebar {
            width: var(--sb-sidebar-w); min-height: 100vh;
            position: fixed; top: 0; left: 0;
            background: linear-gradient(160deg, #1e1b4b 0%, #312e81 100%);
            display: flex; flex-direction: column;
            transition: transform .3s ease;
            z-index: 1040; box-shadow: 4px 0 20px rgba(0,0,0,.25);
        }
        .sb-sidebar .brand {
            padding: 1.5rem 1.2rem 1rem; color: #fff;
            font-size: 1.2rem; font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .sb-sidebar .brand span { color: #a5b4fc; }
        .sb-nav { padding: 1rem .75rem; flex: 1; }
        .sb-nav a {
            display: flex; align-items: center; gap: .75rem;
            padding: .65rem 1rem; color: rgba(255,255,255,.75);
            border-radius: .5rem; text-decoration: none;
            font-size: .9rem; transition: background .2s, color .2s, transform .15s;
            margin-bottom: .2rem;
        }
        .sb-nav a:hover { background: rgba(255,255,255,.12); color: #fff; transform: translateX(4px); }
        .sb-nav a.active { background: rgba(255,255,255,.2); color: #fff; font-weight: 600; }
        .sb-nav .nav-label {
            font-size: .7rem; text-transform: uppercase;
            letter-spacing: 1px; color: rgba(255,255,255,.4);
            padding: .75rem 1rem .3rem; margin-top: .5rem;
        }
        .sb-footer { padding: 1rem .75rem; border-top: 1px solid rgba(255,255,255,.1); }
        .sb-main { margin-left: var(--sb-sidebar-w); min-height: 100vh; transition: margin .3s ease; }
        .sb-topbar {
            background: var(--bs-body-bg);
            border-bottom: 1px solid var(--bs-border-color);
            padding: .75rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 1030;
        }
        .sb-content { padding: 2rem 1.5rem; }
        .metric-card { border: none; border-radius: 1rem; transition: transform .25s, box-shadow .25s; }
        .metric-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,.12); }
        .table tbody tr { transition: background .15s; }
        [data-bs-theme=dark] .sb-topbar { background: #1a1a2e; border-color: #2d2d4e; }
        @media (max-width: 767px) {
            .sb-sidebar { transform: translateX(-100%); }
            .sb-sidebar.open { transform: translateX(0); }
            .sb-main { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
<aside class="sb-sidebar" id="sidebar">
    <div class="brand">🛒 Sasta<span>Bazaar</span></div>
    <nav class="sb-nav">
        <div class="nav-label">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <div class="nav-label">Catalogue</div>
        <a href="{{ route('admin.commodities.index') }}" class="{{ request()->routeIs('admin.commodities.*') ? 'active' : '' }}">
            <i class="bi bi-boxes"></i> Commodities
        </a>
        <a href="{{ route('admin.prices.index') }}" class="{{ request()->routeIs('admin.prices.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Daily Prices
        </a>
        <div class="nav-label">Complaints</div>
        <a href="{{ route('admin.complaints.index') }}" class="{{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
            <i class="bi bi-chat-square-text"></i> Complaints
        </a>
    </nav>
    <div class="sb-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                <i class="bi bi-box-arrow-left me-1"></i> Logout
            </button>
        </form>
    </div>
</aside>

<div class="sb-main">
    <div class="sb-topbar">
        <button class="btn btn-sm d-md-none me-2" id="sidebarToggle">
            <i class="bi bi-list fs-5"></i>
        </button>
        <span class="fw-semibold text-muted">@yield('page-title', 'Dashboard')</span>
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary rounded-pill"
                    @click="dark = !dark; localStorage.setItem('sb_dark', dark)"
                    :title="dark ? 'Light mode' : 'Dark mode'">
                <i class="bi" :class="dark ? 'bi-sun' : 'bi-moon'"></i>
            </button>
            <span class="badge bg-primary">{{ auth()->user()->name }}</span>
        </div>
    </div>
    <div class="px-4 pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
    <div class="sb-content">@yield('content')</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 500, once: true });
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");
    if (sidebarToggle) { sidebarToggle.addEventListener("click", () => sidebar.classList.toggle("open")); }
</script>
@stack('scripts')
</body>
</html>