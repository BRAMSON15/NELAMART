<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="fas fa-store"></i> NELA MART
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pelanggan.dashboard') ? 'active' : '' }}" href="{{ route('pelanggan.dashboard') }}">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="fas fa-shopping-bag"></i> Belanja
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('keranjang.*') ? 'active' : '' }}" href="{{ route('keranjang.index') }}">
                        <i class="fas fa-shopping-cart"></i> Keranjang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-history"></i> Pesanan
                    </a>
                </li>
            </ul>
            
            <div class="d-flex align-items-center">
                <div class="dropdown user-dropdown">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" style="background: rgba(255,255,255,0.15); border: none; color: white; padding: 8px 16px; border-radius: 8px; font-weight: 500;">
                        <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 12px; margin-top: 8px;">
                        <li>
                            <a class="dropdown-item" href="{{ route('profil.index') }}" style="padding: 10px 20px;">
                                <i class="fas fa-user" style="width: 20px; margin-right: 8px;"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('pelanggan.dashboard') }}" style="padding: 10px 20px;">
                                <i class="fas fa-star" style="width: 20px; margin-right: 8px;"></i> Ulasan Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('chat.admin') }}" style="padding: 10px 20px;">
                                <i class="fas fa-comment" style="width: 20px; margin-right: 8px;"></i> Chat Admin
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger" style="padding: 10px 20px;">
                                    <i class="fas fa-sign-out-alt" style="width: 20px; margin-right: 8px;"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<link href="{{ asset('css/navbar-pelanggan.css') }}" rel="stylesheet">

