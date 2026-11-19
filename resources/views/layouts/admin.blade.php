<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Admin Dashboard - Wirausahagoo')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('starboostrap/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('starboostrap/css/sb-admin-2.min.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-pen-nib"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Wirausaha<sup>Goo</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Kelola Produk
            </div>

            <!-- Nav Item - Products -->
            <li class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.products.index') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Data Produk</span></a>
            </li>

            <!-- Nav Item - Categories -->
            <li class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Kategori Produk</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Stok & Inventaris
            </div>

            <!-- Nav Item - Stock Movements -->
            <li class="nav-item {{ request()->routeIs('admin.stock-movements.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.stock-movements.index') }}">
                    <i class="fas fa-fw fa-exchange-alt"></i>
                    <span>Riwayat Stok (In/Out)</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Transaksi & Pembayaran
            </div>

            <!-- Nav Item - Orders -->
            <li class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-fw fa-shopping-bag"></i>
                    <span>Pesanan Customer</span></a>
            </li>

            <!-- Nav Item - Payments -->
            <li class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.payments.index') }}">
                    <i class="fas fa-fw fa-money-check-alt"></i>
                    <span>Konfirmasi Pembayaran</span>
                    @php
                        $pendingPayCount = \App\Models\Payment::where('status', 'pending')->count();
                    @endphp
                    @if($pendingPayCount > 0)
                        <span class="badge badge-danger badge-counter ml-1">{{ $pendingPayCount }}</span>
                    @endif
                </a>
            </li>

            <!-- Nav Item - Bank Accounts -->
            <li class="nav-item {{ request()->routeIs('admin.bank-accounts.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.bank-accounts.index') }}">
                    <i class="fas fa-fw fa-university"></i>
                    <span>Rekening Bank</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <li class="nav-item">
                <a class="nav-link text-warning" href="{{ route('home') }}" target="_blank">
                    <i class="fas fa-fw fa-external-link-alt"></i>
                    <span>Lihat Website Toko</span></a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Title -->
                    <span class="navbar-text d-none d-sm-inline-block text-gray-800 font-weight-bold">
                        <i class="fas fa-qrcode text-primary mr-1"></i> Sistem Penjualan Wirausaha Mahasiswa Pouch Pensil QR Code
                    </span>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small font-weight-bold">{{ Auth::user()->name }} (Admin)</span>
                                <img class="img-profile rounded-circle" src="{{ asset('starboostrap/img/undraw_profile.svg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('home') }}">
                                    <i class="fas fa-store fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Ke Halaman Toko
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle mr-2"></i> Perhatian:</strong>
                            <ul class="mb-0 mt-1">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Hak Cipta &copy; {{ date('Y') }} Wirausahagoo - Modul Panel Admin SB Admin 2</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('starboostrap/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('starboostrap/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('starboostrap/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('starboostrap/js/sb-admin-2.min.js') }}"></script>

    @stack('scripts')
</body>

</html>
