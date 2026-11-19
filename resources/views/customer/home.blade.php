@extends('layouts.customer')

@section('title', 'Wirausahagoo - Pouch Pensil Inovasi QR & Kerajinan Mahasiswa')

@section('content')
<!-- Hero Section -->
<!-- <section class="py-5 bg-light" style="background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <span class="badge bg-primary text-white px-3 py-2 rounded-pill mb-3" style="background-color: #2b7a78 !important;">
                    <i class="fas fa-award mr-1"></i> Produk Inovasi Kewirausahaan Mahasiswa
                </span>
                <h1 class="display-5 font-weight-bold text-dark mb-3" style="line-height: 1.2;">
                    Selamat Datang dan Selamat Belanja di Toko Kami
                </h1>
                <p class="lead text-muted mb-4">
                    Semoga anda betah dan menemukan produk yang sesuai dengan selera dan kebutuhan anda.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#katalog" class="btn btn-primary btn-lg text-white px-4 py-3 font-weight-bold" style="background-color: #2b7a78; border-color: #2b7a78;">
                        <i class="fas fa-shopping-bag mr-2"></i> Belanja Produk Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section> -->

<!-- Hero Section -->
<section class="py-5 d-flex align-items-center" style="
    min-height: 88vh;
    background: linear-gradient(90deg, rgba(20, 30, 35, 0.85) 0%, rgba(20, 30, 35, 0.55) 60%, rgba(20, 30, 35, 0.25) 100%), 
                url('{{ asset('images/bg1.png') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <span class="badge bg-primary text-white px-3 py-2 rounded-pill mb-3" style="background-color: #2b7a78 !important;">
                    <i class="fas fa-award mr-1"></i> Produk Inovasi Kewirausahaan Mahasiswa
                </span>
                <h1 class="display-5 font-weight-bold text-white mb-3" style="line-height: 1.2;">
                    Selamat Datang dan Selamat Belanja di Toko Kami
                </h1>
                <p class="lead text-light mb-4">
                    Semoga anda betah dan menemukan produk yang sesuai dengan selera dan kebutuhan anda.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#katalog" class="btn btn-primary btn-lg text-white px-4 py-3 font-weight-bold" style="background-color: #2b7a78; border-color: #2b7a78;">
                        <i class="fas fa-shopping-bag mr-2"></i> Belanja Produk Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fitur Keunggulan -->
<section class="py-5 border-bottom bg-white">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3 col-6">
                <div class="p-2">
                    <i class="fas fa-pencil-ruler fa-2x mb-2" style="color: #2b7a78;"></i>
                    <h6 class="font-weight-bold mb-1">Handmade & Modifikasi</h6>
                    <small class="text-muted">Karya modifikasi orisinil mahasiswa</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-2">
                    <i class="fas fa-qrcode fa-2x mb-2" style="color: #2b7a78;"></i>
                    <h6 class="font-weight-bold mb-1">Fitur Label QR Code</h6>
                    <small class="text-muted">Terhubung langsung ke website toko</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-2">
                    <i class="fas fa-wallet fa-2x mb-2" style="color: #2b7a78;"></i>
                    <h6 class="font-weight-bold mb-1">Harga Mahasiswa</h6>
                    <small class="text-muted">Terjangkau & ramah kantong kampus</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-2">
                    <i class="fab fa-whatsapp fa-2x mb-2 text-success"></i>
                    <h6 class="font-weight-bold mb-1">Fast Response WhatsApp</h6>
                    <small class="text-muted">Konfirmasi & tanya stok mudah</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Semua Katalog Produk dengan Filter & Search -->
<section id="katalog" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-uppercase small font-weight-bold" style="color: #2b7a78;">Semua Produk Mahasiswa</span>
            <h2 class="font-weight-bold">Katalog Produk Kerajinan & Modifikasi</h2>
            <p class="text-muted">Temukan produk pouch pensil, totebag kanvas, aksesoris, dan karya kreatif lainnya</p>
        </div>

        <!-- Search Bar and Category Tabs -->
        <div class="card border-0 shadow-sm mb-4 p-3 rounded-3">
            <div class="row g-3 align-items-center">
                <!-- Search Form -->
                <div class="col-lg-6">
                    <form action="{{ route('home') }}#katalog" method="GET" class="d-flex">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <input type="text" name="q" class="form-control me-2" placeholder="Cari nama produk atau deskripsi..." value="{{ request('q') }}">
                        <button type="submit" class="btn btn-primary text-white px-4" style="background-color: #2b7a78; border-color: #2b7a78;">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('q') || request('category'))
                            <a href="{{ route('home') }}#katalog" class="btn btn-outline-secondary ms-2" title="Reset filter">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Category Pills -->
                <div class="col-lg-6">
                    <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                        <a href="{{ route('home', array_merge(request()->except('category', 'page'))) }}#katalog" 
                           class="btn btn-sm {{ !request('category') ? 'btn-dark' : 'btn-outline-dark' }}">
                            Semua ({{ \App\Models\Product::where('is_active', true)->count() }})
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('home', array_merge(request()->except('category', 'page'), ['category' => $cat->slug])) }}#katalog" 
                               class="btn btn-sm {{ request('category') == $cat->slug ? 'btn-primary text-white' : 'btn-outline-secondary' }}"
                               @if(request('category') == $cat->slug) style="background-color: #2b7a78; border-color: #2b7a78;" @endif>
                                {{ $cat->name }} ({{ $cat->products_count }})
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card-product-custom">
                        <div class="position-relative">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="card-product-img">
                            <span class="position-absolute top-0 start-0 m-2 badge bg-secondary text-white small">
                                {{ $product->category->name }}
                            </span>
                            @if($product->stock <= 0)
                                <span class="position-absolute top-0 end-0 m-2 badge bg-danger text-white">Stok Habis</span>
                            @else
                                <span class="position-absolute top-0 end-0 m-2 badge bg-success text-white">Stok: {{ $product->stock }}</span>
                            @endif
                        </div>
                        <div class="product-body">
                            <h6 class="font-weight-bold mb-1 text-truncate" title="{{ $product->name }}">
                                <a href="{{ route('products.show', $product->slug) }}" class="text-dark text-decoration-none">
                                    {{ $product->name }}
                                </a>
                            </h6>
                            <p class="text-muted small text-truncate-2 mb-2" style="font-size: 12px; height: 36px; overflow: hidden;">
                                {{ Str::limit($product->description, 60) }}
                            </p>
                            <div class="product-price mb-3">{{ $product->formatted_price }}</div>
                            <div class="mt-auto d-flex gap-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-secondary btn-sm flex-fill">
                                    Detail
                                </a>
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" class="flex-fill">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary btn-sm w-100 text-white font-weight-bold" style="background-color: #2b7a78; border-color: #2b7a78;">
                                            <i class="fas fa-cart-plus"></i> +Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm flex-fill" disabled>Habis</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada produk yang cocok dengan pencarian Anda.</h5>
                    <a href="{{ route('home') }}#katalog" class="btn btn-outline-primary mt-2">Lihat Semua Produk</a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</section>

<!-- Tentang Konsep QR Code Pouch Pensil (Studi Kasus Edukasi/Wirausaha) -->
<section id="tentang-kami" class="py-5 bg-white border-top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="p-4 bg-light rounded-3 border">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-3 bg-primary text-white rounded-circle me-3" style="background-color: #2b7a78 !important;">
                            <i class="fas fa-qrcode fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="font-weight-bold mb-0">Inovasi Pouch Pensil QR Code</h5>
                            <small class="text-muted">Karya Nyata Tugas Kewirausahaan Mahasiswa</small>
                        </div>
                    </div>
                    <p class="text-muted">
                        Produk pouch pensil kami dibuat bukan hanya sebagai wadah alat tulis biasa, tetapi juga sebagai media promosi kreatif. Pada setiap fisik pouch pensil disematkan label bordir / tag berisi <strong>QR Code resmi</strong>.
                    </p>
                    <ul class="list-unstyled text-muted small">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> <strong>Pindai Seketika:</strong> Teman kuliah atau pembeli cukup mengarahkan kamera HP ke QR Code.</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> <strong>Akses Langsung:</strong> Otomatis membuka website penjualan ini untuk melihat stok terupdate, variasi motif, dan produk lainnya.</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> <strong>Pemesanan Mandiri:</strong> Pembeli dapat memesan secara langsung, mentransfer via rekening/QRIS, dan mengunggah bukti bayar secara transparan.</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ps-lg-4">
                    <span class="text-uppercase small font-weight-bold" style="color: #2b7a78;">Kewirausahaan Berkelanjutan</span>
                    <h3 class="font-weight-bold mb-3">Dukung Produk Kreatif & Modifikasi Mahasiswa</h3>
                    <p class="text-muted">
                        Dengan membeli produk kami, Anda mendukung kreativitas mahasiswa dalam menciptakan produk bernilai tambah tinggi, ramah lingkungan (upcycling bahan perca dan denim), serta pengembangan sistem bisnis digital modern.
                    </p>
                    <div class="d-flex gap-3 align-items-center mt-4">
                        <a href="https://wa.me/{{ $companySetting->clean_whatsapp ?? '6281234567890' }}?text={{ urlencode('Halo Admin ' . ($companySetting->company_name ?? 'Wirausahagoo') . ', saya tertarik untuk custom order produk kerajinan mahasiswa.') }}" 
                           target="_blank" class="btn btn-success px-4 py-2 font-weight-bold">
                            <i class="fab fa-whatsapp mr-1"></i> Hubungi Kami di WhatsApp
                        </a>
                        <span class="text-muted small">Siap melayani custom order & reseller kampus!</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
