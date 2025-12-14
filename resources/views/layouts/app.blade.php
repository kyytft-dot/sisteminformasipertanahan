<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'SIPertanahan')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --card-border: rgba(255, 255, 255, 0.1);
            --text: #f1f5f9;
            --text-light: #cbd5e1;
            --accent: #10b981;
            --sidebar-width: 280px;
        }
        body { background: var(--bg); color: var(--text); font-family: 'Inter', sans-serif; overflow-x:hidden; margin:0; padding:0; }
        .sidebar { position: fixed; left:0; top:0; width:var(--sidebar-width); height:100vh; background: rgba(15,23,42,0.95); backdrop-filter: blur(20px); border-right:1px solid rgba(16,185,129,0.2); padding:2rem 1.5rem; z-index:1000; }
        .sidebar-brand { font-family:'Orbitron',sans-serif; font-size:1.9rem; color:var(--accent); margin-bottom:3rem; text-align:center; }
        .nav-link { color:var(--text-light); padding:1rem 1.5rem; border-radius:12px; margin-bottom:.5rem; transition:all .3s; display:flex; align-items:center; gap:12px; text-decoration:none; }
        .nav-link:hover, .nav-link.active { background: rgba(16,185,129,0.2); color:white; border-left:4px solid var(--accent); }
        .main-content { margin-left: var(--sidebar-width); min-height:100vh; padding:2rem; }
        .glass-card { background: var(--card-bg); backdrop-filter: blur(16px); border:1px solid var(--card-border); border-radius:20px; box-shadow:0 8px 32px rgba(0,0,0,.3); }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">Pertanahan</div>
        <nav class="nav flex-column">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ url('/petnah') }}" class="nav-link {{ request()->is('petnah') ? 'active' : '' }}">Peta Pertanahan</a>
            <a href="{{ route('data-tanah.preview') }}" class="nav-link {{ request()->routeIs('data-tanah.preview') ? 'active' : '' }}">Data Tanah</a>
            <a href="{{ route('laporan.preview') }}" class="nav-link {{ request()->routeIs('laporan.preview') ? 'active' : '' }}">Laporan</a>
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('users.preview') }}" class="nav-link {{ request()->routeIs('users.preview') ? 'active' : '' }}">User Management</a>
            @endif
            <a href="{{ route('pengaturan.preview') }}" class="nav-link {{ request()->routeIs('pengaturan.preview') ? 'active' : '' }}">Pengaturan</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">Logout</a>
        </nav>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
    </script>
    @stack('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIPertanahan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f8fafc; font-family: 'Segoe UI', sans-serif; }
        .sidebar { min-height: 100vh; width: 280px; transition: all 0.3s; }
        .sidebar-admin { background: linear-gradient(180deg, #065f46, #064e3b); }
        .sidebar-staff { background: linear-gradient(180deg, #1e40af, #1e3a8a); }
        .sidebar-public { background: linear-gradient(180deg, #86efac, #6ee7b7); color: #065f46 !important; }
        .sidebar a { color: white; padding: 14px 20px; border-radius: 8px; margin: 8px 15px; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.2); transform: translateX(5px); }
        .sidebar-public a { color: #065f46; font-weight: 600; }
        .sidebar-public a:hover { background: rgba(0,0,0,0.1); }
        .content { margin-left: 280px; padding: 2rem; }
        @media (max-width: 768px) { .sidebar { width: 80px; } .content { margin-left: 80px; } }
    </style>
</head>
<body>

@php
    $role = auth()->user()->getRoleNames()->first() ?? 'public';
    $isAdmin = $role === 'admin';
    $isStaff = $role === 'staff';
    $sidebarClass = $isAdmin ? 'sidebar-admin' : ($isStaff ? 'sidebar-staff' : 'sidebar-public');
@endphp

<!-- Sidebar -->
<div class="sidebar fixed-top {{ $sidebarClass }} text-white">
    <div class="p-4 text-center">
        <h4 class="fw-bold">SIPertanahan</h4>
    </div>
    <nav class="mt-4">
        <a href="/" class="{{ request()->is('/') ? 'active' : '' }} d-flex align-items-center">
            <i class="bi bi-house-door me-3"></i> Dashboard
        </a>

        <a href="/petnah" class="{{ request()->is('petnah') ? 'active' : '' }} d-flex align-items-center">
            <i class="bi bi-map me-3"></i> Peta Pertanahan
        </a>

        @if($isAdmin || $isStaff)
        <a href="/datnah" class="{{ request()->is('datnah') ? 'active' : '' }} d-flex align-items-center">
            <i class="bi bi-table me-3"></i> Data Tanah
        </a>
        @endif

        @if($isAdmin || $isStaff)
        <a href="/lap" class="{{ request()->is('lap') ? 'active' : '' }} d-flex align-items-center">
            <i class="bi bi-file-earmark-text me-3"></i> Laporan
        </a>
        @endif

        <a href="/set" class="{{ request()->is('set') ? 'active' : '' }} d-flex align-items-center">
            <i class="bi bi-gear me-3"></i> Pengaturan
        </a>

        <hr class="my-4 opacity-50">
        <form method="POST" action="/logout" class="m-3">
            @csrf
            <button type="submit" class="btn w-100 text-start text-white d-flex align-items-center">
                <i class="bi bi-box-arrow-right me-3"></i> Logout
            </button>
        </form>
    </nav>
</div>

<!-- Content -->
<div class="content">
    @yield('content')
</div>

</body>
</html>