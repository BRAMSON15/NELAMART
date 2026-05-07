<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Dashboard Admin NELA MART" />
    <meta name="author" content="" />
    <title>Dashboard Admin - NELA MART</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{asset('mentahan1/css/styles.css')}}" rel="stylesheet" />
    <link href="{{asset('css/admin-dashboard.css')}}?v={{ time() }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="/">NELA MART</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Cari..." aria-label="Search" />
                <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Pengaturan</a></li>
                    <li><a class="dropdown-item" href="#!">Log Aktivitas</a></li>
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
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Manajemen</div>
                        <a class="nav-link" href="{{ route('admin.kelola-toko') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                            Kelola Toko
                            <span class="badge bg-warning text-dark ms-auto">{{ \App\Models\Toko::where('status', 'pending')->count() }}</span>
                        </a>
                        <a class="nav-link" href="{{ route('admin.kelola-user') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Kelola User
                        </a>
                        <a class="nav-link" href="{{ route('admin.chat.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-comments"></i></div>
                            Terima Chat
                        </a>
                       
                        
                        <div class="sb-sidenav-menu-heading">Laporan</div>
                        <!-- <a class="nav-link" href="{{ route('admin.laporan-transaksi') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Laporan Transaksi
                        </a> -->
                        <a class="nav-link" href="{{ route('admin.statistik') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                            Statistik
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    {{ Auth::user()->role }}
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard Admin</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    
                    <!-- Stats Cards -->
                    <div class="row">
                        @if(session('success'))
                            <div class="col-12">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            </div>
                        @endif
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-white-75 small">Total Toko</div>
                                            <div class="h2 mb-0">{{ \App\Models\Toko::count() }}</div>
                                        </div>
                                        <i class="fas fa-store fa-3x opacity-50"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-white-75 small">Toko Pending</div>
                                            <div class="h2 mb-0">{{ \App\Models\Toko::where('status', 'pending')->count() }}</div>
                                        </div>
                                        <i class="fas fa-clock fa-3x opacity-50"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-white-75 small">Total Produk</div>
                                            <div class="h2 mb-0">{{ \App\Models\Produk::count() }}</div>
                                        </div>
                                        <i class="fas fa-box fa-3x opacity-50"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-white-75 small">Total Pesanan</div>
                                            <div class="h2 mb-0">{{ \App\Models\Pesanan::count() }}</div>
                                        </div>
                                        <i class="fas fa-shopping-cart fa-3x opacity-50"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Charts -->
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Grafik Transaksi Harian sampai Tahunan
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Jumlah pelaku UMKM yang terdaftar
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Toko Pending Verification Table -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Toko Menunggu Verifikasi
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Toko</th>
                                        <th>Pemilik</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Status</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(\App\Models\Toko::with('user')->where('status', 'pending')->get() as $toko)
                                    <tr>
                                        <td>{{ $toko->id }}</td>
                                        <td>{{ $toko->nama_toko }}</td>
                                        <td>{{ $toko->user->name }}</td>
                                        <td>{{ Str::limit($toko->alamat, 30) }}</td>
                                        <td>{{ $toko->telepon }}</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                        <td>{{ $toko->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <form action="{{ route('admin.toko.approve', $toko->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Setujui toko {{ $toko->nama_toko }}?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.toko.reject', $toko->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Tolak toko {{ $toko->nama_toko }}?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.toko.detail', $toko->id) }}" class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada toko yang menunggu verifikasi</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
    <script>
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#555555';

    // Area Chart — Pesanan harian 30 hari terakhir
    var ctxArea = document.getElementById("myAreaChart");
    new Chart(ctxArea, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: "Pesanan",
                lineTension: 0.4,
                backgroundColor: "rgba(38, 185, 154, 0.15)",
                borderColor: "rgba(38, 185, 154, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(38, 185, 154, 1)",
                pointBorderColor: "rgba(255,255,255,0.9)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(26, 187, 156, 1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: {!! json_encode($chartData) !!},
            }],
        },
        options: {
            scales: {
                xAxes: [{ gridLines: { display: false }, ticks: { maxTicksLimit: 10 } }],
                yAxes: [{ ticks: { min: 0, maxTicksLimit: 5, stepSize: 1 }, gridLines: { color: "rgba(0,0,0,0.06)" } }],
            },
            legend: { display: false },
            tooltips: {
                callbacks: {
                    label: function(item) { return item.yLabel + ' pesanan'; }
                }
            }
        }
    });

    // Bar Chart — UMKM terdaftar per bulan (12 bulan terakhir)
    var ctxBar = document.getElementById("myBarChart");
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: {!! json_encode($barLabels) !!},
            datasets: [{
                label: "UMKM Baru",
                backgroundColor: "rgba(38, 185, 154, 0.85)",
                borderColor: "rgba(38, 185, 154, 1)",
                data: {!! json_encode($barData) !!},
            }],
        },
        options: {
            scales: {
                xAxes: [{ gridLines: { display: false }, ticks: { maxTicksLimit: 12 } }],
                yAxes: [{ ticks: { min: 0, maxTicksLimit: 5, stepSize: 1 }, gridLines: { display: true, color: "rgba(0,0,0,0.06)" } }],
            },
            legend: { display: false },
            tooltips: {
                callbacks: {
                    label: function(item) { return item.yLabel + ' UMKM'; }
                }
            }
        }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('mentahan1/js/datatables-simple-demo.js')}}"></script>
</body>
</html>
