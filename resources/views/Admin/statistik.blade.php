<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Statistik - NELA MART" />
    <meta name="author" content="" />
    <title>Statistik - NELA MART</title>
    <link href="{{asset('mentahan1/css/styles.css')}}" rel="stylesheet" />
    <link href="{{asset('css/admin-dashboard.css')}}?v={{ time() }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="/">NELA MART</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Cari..." aria-label="Search" />
                <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
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
                        <!-- <a class="nav-link" href="/">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Beranda
                        </a> -->
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
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
                        
                        <div class="sb-sidenav-menu-heading">Laporan</div>
                        <!-- <a class="nav-link" href="{{ route('admin.laporan-transaksi') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Laporan Transaksi
                        </a> -->
                        <a class="nav-link active" href="{{ route('admin.statistik') }}">
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
                    <h1 class="mt-4">Statistik</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Statistik</li>
                    </ol>
                    
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Jumlah Pelaku UMKM Terdaftar
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-pie me-1"></i>
                                    Kategori Produk
                                </div>
                                <div class="card-body"><canvas id="myPieChart" width="100%" height="40"></canvas></div>
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
    <script>
        // ===== BAR CHART: Pelaku UMKM Terdaftar per Bulan =====
        var barLabels  = {!! json_encode($umkmPerBulan->pluck('bulan')) !!};
        var barData    = {!! json_encode($umkmPerBulan->pluck('total')) !!};

        var ctxBar = document.getElementById('myBarChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: [{
                    label: 'Jumlah UMKM',
                    data: barData,
                    backgroundColor: 'rgba(0, 97, 242, 0.7)',
                    borderColor: 'rgba(0, 97, 242, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: { beginAtZero: true, stepSize: 1 }
                    }]
                },
                legend: { display: false }
            }
        });

        // ===== PIE CHART: Kategori Produk =====
        var pieLabels = {!! json_encode($kategoriProduk->pluck('kategori')) !!};
        var pieData   = {!! json_encode($kategoriProduk->pluck('total')) !!};
        var pieColors = [
            '#0061f2','#6900c7','#00ac69','#f4a100','#e81500',
            '#17a2b8','#fd7e14','#6c757d','#20c997','#d63384'
        ];

        var ctxPie = document.getElementById('myPieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieData,
                    backgroundColor: pieColors.slice(0, pieLabels.length)
                }]
            },
            options: {
                legend: { position: 'bottom' }
            }
        });
    </script>
</body>
</html>

