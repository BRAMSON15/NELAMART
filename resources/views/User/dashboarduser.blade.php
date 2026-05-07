<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Dashboard User NELA MART" />
    <meta name="author" content="" />
    <title>Dashboard User - NELA MART</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{asset('mentahan1/css/styles.css')}}" rel="stylesheet" />
    <link href="{{asset('css/user-dashboard.css')}}?v={{ time() }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="/">NELA MART</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Cari..." aria-label="Search" />
                <button class="btn btn-light" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Profil Toko</a></li>
                    <li><a class="dropdown-item" href="#!">Pengaturan</a></li>
                    <li><hr class="dropdown-divider" /></li>
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
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu Utama</div>
                        <a class="nav-link active" href="{{ route('user.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Toko Saya</div>
                        <a class="nav-link" href="{{ route('user.toko.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                            Data Toko
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Produk</div> 
                        <a class="nav-link" href="{{ route('user.produk.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Daftar Produk
                        </a>
                        <!-- <a class="nav-link" href="{{ route('user.produk.create') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-plus-circle"></i></div>
                            Tambah Produk
                        </a> -->
                        
                        <div class="sb-sidenav-menu-heading">Pesanan</div>
                        <a class="nav-link" href="{{ route('user.pesanan.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Daftar Pesanan
                            @if(Auth::user()->toko)
                                @php
                                    $newOrders = \App\Models\Pesanan::whereHas('details.produk', function($q) {
                                        $q->where('toko_id', Auth::user()->toko->id);
                                    })->where('status', 'pending')->count();
                                @endphp
                                @if($newOrders > 0)
                                    <span class="badge bg-danger ms-auto">{{ $newOrders }}</span>
                                @endif
                            @endif
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Laporan</div>
                        <!-- <a class="nav-link" href="{{ route('user.laporan') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                            Laporan Transaksi
                        </a> -->
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Pemilik UMKM
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Selamat datang, {{ Auth::user()->name }}!</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>

                    {{-- Notifikasi Status Toko --}}
                    @php $toko = Auth::user()->toko; @endphp
                    @if(!$toko)
                        <div class="alert alert-warning d-flex align-items-center gap-3">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                            <div>
                                <strong>Toko belum didaftarkan.</strong> Daftarkan toko Anda agar produk bisa tampil di beranda.
                                <a href="{{ route('user.toko.create') }}" class="btn btn-warning btn-sm ms-3">Daftar Toko Sekarang</a>
                            </div>
                        </div>
                    @elseif($toko->status === 'pending')
                        <div class="alert alert-warning d-flex align-items-center gap-3">
                            <i class="fas fa-clock fa-2x"></i>
                            <div>
                                <strong>Toko Anda sedang menunggu verifikasi admin.</strong>
                                Produk yang Anda posting belum tampil di beranda publik sampai toko diverifikasi.
                                <span class="badge bg-warning text-dark ms-2">Status: Pending</span>
                            </div>
                        </div>
                    @elseif($toko->status === 'ditolak')
                        <div class="alert alert-danger d-flex align-items-center gap-3">
                            <i class="fas fa-times-circle fa-2x"></i>
                            <div>
                                <strong>Toko Anda ditolak oleh admin.</strong>
                                Silakan hubungi admin untuk informasi lebih lanjut.
                                <span class="badge bg-danger ms-2">Status: Ditolak</span>
                            </div>
                        </div>
                    @elseif($toko->status === 'aktif')
                        <div class="alert alert-success d-flex align-items-center gap-3">
                            <i class="fas fa-check-circle fa-2x"></i>
                            <div>
                                <strong>Toko Anda aktif!</strong>
                                Produk Anda sudah tampil di beranda publik dan dapat dilihat pelanggan.
                            </div>
                        </div>
                    @endif
                    
                    <!-- Stats Cards -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-white-75 small">Total Produk</div>
                                            <div class="h2 mb-0">
                                                @if(Auth::user()->toko)
                                                    {{ \App\Models\Produk::where('toko_id', Auth::user()->toko->id)->count() }}
                                                @else
                                                    0
                                                @endif
                                            </div>
                                        </div>
                                        <i class="fas fa-box fa-3x opacity-50"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="{{ route('user.produk.index') }}">Kelola Produk</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-white-75 small">Pesanan Baru</div>
                                            <div class="h2 mb-0">
                                                @if(Auth::user()->toko)
                                                    {{ \App\Models\Pesanan::whereHas('details.produk', function($q) {
                                                        $q->where('toko_id', Auth::user()->toko->id);
                                                    })->where('status', 'pending')->count() }}
                                                @else
                                                    0
                                                @endif
                                            </div>
                                        </div>
                                        <i class="fas fa-shopping-cart fa-3x opacity-50"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="{{ route('user.pesanan.index') }}">Lihat Pesanan</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-white-75 small">Pendapatan Bulan Ini</div>
                                            <div class="h5 mb-0">
                                                @if(Auth::user()->toko)
                                                    @php
                                                        $pendapatan = \App\Models\PesananDetail::whereHas('produk', function($q) {
                                                            $q->where('toko_id', Auth::user()->toko->id);
                                                        })->whereHas('pesanan', function($q) {
                                                            $q->where('status', 'selesai')
                                                              ->whereMonth('created_at', date('m'))
                                                              ->whereYear('created_at', date('Y'));
                                                        })->sum(\DB::raw('harga_satuan * jumlah'));
                                                    @endphp
                                                    Rp {{ number_format($pendapatan, 0, ',', '.') }}
                                                @else
                                                    Rp 0
                                                @endif
                                            </div>
                                        </div>
                                        <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="{{ route('user.laporan') }}">Lihat Laporan</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-white-75 small">Produk Terjual</div>
                                            <div class="h2 mb-0">
                                                @if(Auth::user()->toko)
                                                    {{ \App\Models\PesananDetail::whereHas('produk', function($q) {
                                                        $q->where('toko_id', Auth::user()->toko->id);
                                                    })->whereHas('pesanan', function($q) {
                                                        $q->where('status', 'selesai');
                                                    })->sum('jumlah') }}
                                                @else
                                                    0
                                                @endif
                                            </div>
                                        </div>
                                        <i class="fas fa-chart-line fa-3x opacity-50"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="{{ route('user.laporan') }}">Lihat Detail</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; NELA MART 2026</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('mentahan1/js/scripts.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('mentahan1/assets/demo/chart-area-demo.js')}}"></script>
    <script src="{{asset('mentahan1/assets/demo/chart-bar-demo.js')}}"></script>
</body>
</html>

