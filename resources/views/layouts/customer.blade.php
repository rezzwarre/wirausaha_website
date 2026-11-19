<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wirausahagoo - Produk Kerajinan Mahasiswa & Pouch Pensil')</title>
    
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('template/css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/style.css') }}">
    
    <!-- FontAwesome from starboostrap -->
    <link href="{{ asset('starboostrap/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        .badge-count {
            background-color: #d9534f;
            color: white;
            border-radius: 50%;
            padding: 2px 7px;
            font-size: 11px;
            position: relative;
            top: -10px;
            right: 5px;
        }
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 30px;
            right: 30px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.25);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .whatsapp-float:hover {
            background-color: #128c7e;
            color: #fff;
            transform: scale(1.1);
        }
        .qr-badge-banner {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 8px 15px;
            font-size: 13px;
            text-align: center;
        }
        .card-product-custom {
            border: 1px solid #eaeaea;
            border-radius: 8px;
            overflow: hidden;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            background: #fff;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .card-product-custom:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            transform: translateY(-4px);
        }
        .card-product-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
        .product-body {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .product-price {
            font-size: 18px;
            font-weight: 700;
            color: #2b7a78;
        }
        .badge-stock {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 4px;
        }
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            justify-content: center;
            margin-top: 25px;
        }
        .pagination li a, .pagination li span {
            padding: 8px 16px;
            border: 1px solid #ddd;
            margin: 0 4px;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
        }
        .pagination li.active span {
            background-color: #2b7a78;
            color: white;
            border-color: #2b7a78;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Top QR Announcement Bar -->
    <div class="qr-badge-banner">
        <span><i class="fas fa-qrcode mr-2"></i> Pindai QR di Pouch Pensil Mahasiswa untuk Akses Cepat Website Penjualan Produk Kami!</span>
        <a href="{{ route('home') }}#produk-pouch" class="text-warning ml-2 font-weight-bold" style="text-decoration: underline;">Lihat Koleksi Pouch</a>
    </div>

    <!-- Navigation Header -->
    <header id="header" class="site-header header-scrolled position-relative">
        <nav id="header-nav" class="navbar navbar-expand-lg px-3 mb-3">
            <div class="container-fluid">
                <a class="navbar-brand font-weight-bold text-dark d-flex align-items-center" href="{{ route('home') }}" style="font-size: 24px;">
                    <i class="fas fa-pen-fancy text-primary mr-2" style="color: #2b7a78 !important;"></i> 
                    <span>WIRAUSAHA<strong style="color: #2b7a78;">GOO</strong></span>
                </a>
                <button class="navbar-toggler d-flex d-lg-none flex-column justify-content-around" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header justify-content-between">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu Wirausahagoo</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 gap-1">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active text-primary font-weight-bold' : '' }}" href="{{ route('home') }}">
                                    <i class="fas fa-home mr-1"></i> Beranda
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}#katalog">
                                    <i class="fas fa-th-large mr-1"></i> Produk Kerajinan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}#tentang-kami">
                                    <i class="fas fa-info-circle mr-1"></i> Pouch QR Inovatif
                                </a>
                            </li>
                            @auth
                                @if(Auth::user()->isCustomer())
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('orders.*') ? 'active text-primary font-weight-bold' : '' }}" href="{{ route('orders.index') }}">
                                            <i class="fas fa-receipt mr-1"></i> Pesanan Saya
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('profile.*') ? 'active text-primary font-weight-bold' : '' }}" href="{{ route('profile.index') }}">
                                            <i class="fas fa-user-circle mr-1"></i> Profil
                                        </a>
                                    </li>
                                @endif
                                @if(Auth::user()->isAdmin())
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold text-danger" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-user-shield mr-1"></i> Panel Admin
                                        </a>
                                    </li>
                                @endif
                            @endauth
                        </ul>
                        
                        <div class="d-flex align-items-center ms-lg-4 gap-3 mt-3 mt-lg-0">
                            <!-- Cart Icon -->
                            @auth
                                @php
                                    $cartCount = \App\Models\Cart::where('user_id', Auth::id())->withCount('items')->first();
                                    $itemCount = $cartCount ? $cartCount->items_count : 0;
                                @endphp
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-dark position-relative py-2 px-3">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span class="d-none d-md-inline ms-1">Keranjang</span>
                                    @if($itemCount > 0)
                                        <span class="badge bg-danger text-white rounded-pill ms-1">{{ $itemCount }}</span>
                                    @endif
                                </a>
                                
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-secondary py-2 px-3" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary py-2 px-3">
                                    <i class="fas fa-sign-in-alt"></i> Masuk
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-primary py-2 px-3 text-white">
                                    <i class="fas fa-user-plus"></i> Daftar
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Flash Messages -->
    <div class="container mt-2">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-triangle mr-2"></i> Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin Wirausahagoo! Saya ingin bertanya tentang produk pouch pensil dan kerajinan mahasiswa.') }}" 
       class="whatsapp-float" target="_blank" title="Chat Admin via WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Footer -->
    <footer id="footer" class="py-5 bg-dark text-white mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-white font-weight-bold mb-3">
                        <i class="fas fa-pen-fancy text-primary mr-2" style="color: #64b5f6 !important;"></i> WIRAUSAHAGOO
                    </h5>
                    <p class="text-muted">
                        Platform e-commerce produk kerajinan mahasiswa: pouch pensil ber-QR Code inovatif, totebag kanvas lukis, buku catatan daur ulang, dan beragam produk modifikasi kreatif bernilai wirausaha.
                    </p>
                    <div class="text-muted small">
                        <i class="fas fa-university mr-2"></i> Karya Kewirausahaan Mahasiswa
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="text-white font-weight-bold mb-3">Menu Cepat</h6>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('home') }}#katalog" class="text-decoration-none text-muted">Katalog Produk</a></li>
                        <li class="mb-2"><a href="{{ route('cart.index') }}" class="text-decoration-none text-muted">Keranjang Belanja</a></li>
                        <li class="mb-2"><a href="{{ route('orders.index') }}" class="text-decoration-none text-muted">Status Pesanan</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white font-weight-bold mb-3">Metode Bayar</h6>
                    <ul class="list-unstyled text-muted small">
                        <li class="mb-1"><i class="fas fa-check-circle text-success mr-1"></i> Bank BCA</li>
                        <li class="mb-1"><i class="fas fa-check-circle text-success mr-1"></i> Bank Mandiri</li>
                        <li class="mb-1"><i class="fas fa-check-circle text-success mr-1"></i> Bank BRI</li>
                        <li class="mb-1"><i class="fas fa-check-circle text-success mr-1"></i> QRIS / E-Wallet</li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="text-white font-weight-bold mb-3">Hubungi Kami (WhatsApp)</h6>
                    <p class="text-muted small mb-2">Konsultasi produk dan konfirmasi pesanan secara langsung:</p>
                    <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin Wirausahagoo, saya ingin bertanya tentang produk kerajinan.') }}" 
                       target="_blank" class="btn btn-success btn-sm text-white">
                        <i class="fab fa-whatsapp mr-1"></i> WhatsApp: 0812-3456-7890
                    </a>
                </div>
            </div>
            <hr class="bg-secondary my-4">
            <div class="text-center text-muted small">
                &copy; {{ date('Y') }} <strong>Wirausahagoo</strong> - Proyek Tugas Kewirausahaan Mahasiswa (Pouch Pensil QR Code).
            </div>
        </div>
    </footer>

    <!-- Template JS Scripts -->
    <script src="{{ asset('template/js/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('template/js/plugins.js') }}"></script>
    <script src="{{ asset('template/js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>
