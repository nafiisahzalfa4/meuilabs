<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Dashboard') | MeUI Labs</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #173f46;
            --primary-light: #245c64;
            --background: #f4f7f8;
            --sidebar-width: 260px;
            --text-dark: #263238;
            --text-muted: #839096;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: var(--background);
            color: var(--text-dark);
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--primary);
            color: white;
            padding: 25px 18px;
            z-index: 1000;
            overflow-y: auto;
            transition: .3s;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 5px 10px 30px;
            border-bottom: 1px solid rgba(255,255,255,.12);
            margin-bottom: 25px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            background: #ffffff;
            color: var(--primary);
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 21px;
        }

        .brand h5 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .brand small {
            font-size: 11px;
            color: #b9d0d3;
        }

        .menu-label {
            color: #9bb7ba;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            padding: 0 12px;
            margin: 22px 0 10px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 6px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 14px;
            color: #d1e0e2;
            text-decoration: none;
            border-radius: 9px;
            font-size: 13px;
            transition: .2s;
        }

        .sidebar-menu a i {
            font-size: 17px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: var(--primary-light);
            color: white;
        }

        .sidebar-menu a.active {
            border-left: 3px solid #d9bd78;
        }

        /* MAIN CONTENT */

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* TOPBAR */

        .topbar {
            height: 75px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            border-bottom: 1px solid #e9eeee;
        }

        .topbar-title {
            font-size: 17px;
            font-weight: 700;
            margin: 0;
        }

        .topbar-subtitle {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #e4eff0;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .admin-name {
            font-size: 12px;
            font-weight: 700;
            margin: 0;
        }

        .admin-role {
            color: var(--text-muted);
            font-size: 10px;
        }

        /* PAGE CONTENT */

        .content-wrapper {
            padding: 30px 32px;
        }

        .page-heading {
            margin-bottom: 25px;
        }

        .page-heading h4 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .page-heading p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
        }

        .content-card {
            background: white;
            border: 1px solid #edf0f1;
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 3px 12px rgba(0,0,0,.025);
        }

        /* BUTTONS */

        .btn-primary-custom {
            background: var(--primary);
            border: none;
            color: white;
            padding: 9px 17px;
            border-radius: 7px;
            font-size: 12px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary-custom:hover {
            background: var(--primary-light);
            color: white;
        }

        /* TABLE */

        .table {
            vertical-align: middle;
        }

        .table thead th {
            background: #f5f8f8;
            color: #647579;
            font-size: 11px;
            font-weight: 700;
            padding: 14px;
            border-bottom: 1px solid #e9eeee;
            white-space: nowrap;
        }

        .table tbody td {
            font-size: 12px;
            padding: 14px;
            color: #45565a;
        }

        /* FORM */

        .form-label {
            font-size: 12px;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            font-size: 13px;
            padding: 10px 12px;
            border-radius: 7px;
        }

        /* FOOTER */

        .footer {
            padding: 18px 32px;
            color: var(--text-muted);
            font-size: 11px;
            border-top: 1px solid #e9eeee;
            background: white;
            margin-top: 30px;
        }

        /* MOBILE */

        .menu-toggle {
            display: none;
            background: transparent;
            border: none;
            color: var(--primary);
            font-size: 24px;
        }

        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 768px) {

            .sidebar {
                left: -260px;
            }

            .sidebar.show {
                left: 0;
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.4);
                z-index: 999;
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .topbar {
                padding: 0 18px;
            }

            .content-wrapper {
                padding: 22px 16px;
            }

            .footer {
                padding: 18px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="brand">
            <div class="brand-icon">
                <i class="bi bi-palette-fill"></i>
            </div>

            <div>
                <h5>MeUI Labs</h5>
                <small>Creative Management</small>
            </div>
        </div>

        <div class="menu-label">MENU UTAMA</div>

        <ul class="sidebar-menu">

            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    Dashboard
                </a>
            </li>

            <div class="menu-label">MANAJEMEN</div>

            <li>
                <a href="{{ route('admin.orders.index') }}"
                   class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i>
                    Pesanan
                </a>
            </li>

            <li>
                <a href="{{ route('admin.user.index') }}"
                   class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    Pengguna
                </a>
            </li>

            <li>
                <a href="{{ route('admin.services.index') }}"
                   class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i class="bi bi-briefcase-fill"></i>
                    Layanan
                </a>
            </li>

            <li>
                <a href="{{ route('admin.portfolios.index') }}"
                   class="{{ request()->routeIs('admin.portfolios.*') ? 'active' : '' }}">
                    <i class="bi bi-images"></i>
                    Portfolio
                </a>
            </li>

            <li>
                <a href="{{ route('admin.projects.index') }}"
                   class="{{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                    <i class="bi bi-kanban-fill"></i>
                    Project
                </a>
            </li>

        </ul>

        <div class="menu-label">AKUN</div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('home') }}">
                    <i class="bi bi-house-door"></i>
                    Halaman Website
                </a>
            </li>

            <li>
                <a href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                    Keluar
                </a>
            </li>
        </ul>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"
         onclick="toggleSidebar()"></div>


    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="d-flex align-items-center gap-3">

                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>

                <div>
                    <h6 class="topbar-title">@yield('page-title', 'Dashboard')</h6>
                    <div class="topbar-subtitle">
                        Selamat datang di panel administrasi MeUI Labs
                    </div>
                </div>

            </div>

            <div class="admin-profile">

                <div class="text-end d-none d-sm-block">
                    <p class="admin-name">
                        {{ Auth::user()->name ?? 'Administrator' }}
                    </p>
                    <span class="admin-role">Administrator</span>
                </div>

                <div class="admin-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>

            </div>

        </header>


        <!-- PAGE CONTENT -->
        <section class="content-wrapper">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Periksa kembali data yang kamu masukkan:</strong>

                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')

        </section>


        <!-- FOOTER -->
        <footer class="footer">
            &copy; {{ date('Y') }} MeUI Labs. All rights reserved.
        </footer>

    </main>


    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }
    </script>

    @stack('scripts')

</body>
</html>