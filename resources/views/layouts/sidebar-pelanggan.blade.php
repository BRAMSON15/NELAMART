<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Pelanggan') - NELA MART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/pelanggan.css') }}" rel="stylesheet">
<link href="{{ asset('css/sidebar-pelanggan.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <!-- Sidebar Toggle (Mobile) -->
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="/" class="sidebar-brand">
                <i class="fas fa-store"></i>
                NELA MART
            </a>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-title">Menu Utama</div>
                <a href="{{ route('pelanggan.dashboard') }}" class="menu-item {{ request()->routeIs('pelanggan.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="/" class="menu-item">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Belanja</span>
                </a>
                <a href="{{ route('keranjang.index') }}" class="menu-item {{ request()->routeIs('keranjang.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Keranjang</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-title">Pesanan</div>
                <a href="#" class="menu-item">
                    <i class="fas fa-box"></i>
                    <span>Semua Pesanan</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-clock"></i>
                    <span>Menunggu Konfirmasi</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-truck"></i>
                    <span>Dalam Pengiriman</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Selesai</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-title">Akun</div>
                <a href="{{ route('profil.index') }}" class="menu-item {{ request()->routeIs('profil.*') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Profil Saya</span>
                </a>
                <a href="{{ route('pelanggan.dashboard') }}" class="menu-item {{ request()->routeIs('review.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i>
                    <span>Ulasan Saya</span>
                </a>
                <a href="{{ route('chat.admin') }}" class="menu-item {{ request()->routeIs('chat.admin') ? 'active' : '' }}">
                    <i class="fas fa-comment"></i>
                    <span>Chat Admin</span>
                </a>
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-details">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">Pelanggan</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="topbar">
            <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>
            <div class="topbar-actions">
                @yield('topbar-actions')
            </div>
        </div>

        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/sidebar-toggle.js') }}"></script>
    @stack('scripts')
</body>
</html>

