<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Data Toko - NELA MART</title>
    <link href="{{asset('mentahan1/css/styles.css')}}" rel="stylesheet" />
    <link href="{{asset('css/user-dashboard.css')}}?v={{ time() }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="/">NELA MART</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user fa-fw"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link active" href="{{ route('user.toko.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                            Data Toko
                        </a>
                        <a class="nav-link" href="{{ route('user.produk.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Daftar Produk
                        </a>
                        <a class="nav-link" href="{{ route('user.produk.create') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-plus-circle"></i></div>
                            Tambah Produk
                        </a>
                        <a class="nav-link" href="{{ route('user.pesanan.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Daftar Pesanan
                        </a>
                        <a class="nav-link" href="{{ route('user.laporan') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                            Laporan
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Toko</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Toko</li>
                    </ol>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($toko)
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-store me-1"></i>
                            Informasi Toko
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nama Toko:</strong> {{ $toko->nama_toko }}</p>
                                    <p><strong>Alamat:</strong> {{ $toko->alamat }}</p>
                                    <p><strong>Telepon:</strong> {{ $toko->telepon }}</p>
                                    <p><strong>Deskripsi:</strong> {{ $toko->deskripsi ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Status:</strong> 
                                        @if($toko->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif($toko->status == 'pending')
                                            <span class="badge bg-warning">Menunggu Verifikasi</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </p>
                                    <p><strong>Tanggal Daftar:</strong> {{ $toko->created_at->format('d F Y') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('user.toko.edit') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-edit"></i> Edit Data Toko
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info">
                        Anda belum mendaftarkan toko.
                        <a href="{{ route('user.toko.create') }}" class="btn btn-primary btn-sm">Daftar Sekarang</a>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('mentahan1/js/scripts.js')}}"></script>
</body>
</html>

