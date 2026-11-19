@extends('layouts.customer')

@section('title', $product->name . ' - Wirausahagoo')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 rounded">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('home', ['category' => $product->category->slug]) }}#katalog" class="text-decoration-none">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Product Image -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-3 rounded-3 text-center">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 420px; object-fit: cover; width: 100%;">
                @if(str_contains(strtolower($product->category->slug), 'pouch'))
                    <div class="mt-3 p-2 bg-light rounded border text-muted small">
                        <i class="fas fa-qrcode text-primary me-1"></i> Produk ini dilengkapi label QR Code fisik untuk akses cepat ke website.
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4 rounded-3 h-100">
                <div class="mb-2">
                    <span class="badge bg-secondary text-white">{{ $product->category->name }}</span>
                    @if($product->stock > 0)
                        <span class="badge bg-success text-white ml-2">Tersedia (Stok: {{ $product->stock }})</span>
                    @else
                        <span class="badge bg-danger text-white ml-2">Stok Habis</span>
                    @endif
                </div>

                <h2 class="font-weight-bold text-dark mb-3">{{ $product->name }}</h2>

                <div class="display-6 font-weight-bold mb-4" style="color: #2b7a78;">
                    {{ $product->formatted_price }}
                </div>

                <hr>

                <h5 class="font-weight-bold mb-2">Deskripsi Produk:</h5>
                <p class="text-muted mb-4" style="line-height: 1.7;">
                    {{ $product->description ?: 'Produk kerajinan dan perlengkapan mahasiswa berkualitas tinggi karya wirausaha kreatif.' }}
                </p>

                <!-- Add to Cart Form -->
                @if($product->stock > 0)
                    <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="row align-items-center g-3 mb-3">
                            <div class="col-auto">
                                <label class="col-form-label font-weight-bold">Jumlah Beli:</label>
                            </div>
                            <div class="col-auto">
                                <div class="input-group" style="width: 140px;">
                                    <button class="btn btn-outline-secondary" type="button" onclick="decrementQty()">-</button>
                                    <input type="number" name="quantity" id="quantity" class="form-control text-center" value="1" min="1" max="{{ $product->stock }}">
                                    <button class="btn btn-outline-secondary" type="button" onclick="incrementQty()">+</button>
                                </div>
                            </div>
                            <div class="col-auto text-muted small">
                                Maksimal pembelian: {{ $product->stock }} unit
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-4 text-white font-weight-bold" style="background-color: #2b7a78; border-color: #2b7a78;">
                                <i class="fas fa-cart-plus mr-2"></i> Tambahkan ke Keranjang
                            </button>
                            
                            @php
                                $waProductMsg = urlencode("Halo Admin Wirausahagoo, saya ingin bertanya tentang produk: {$product->name} ({$product->formatted_price}). Apakah stok masih tersedia?");
                            @endphp
                            <a href="https://wa.me/{{ $companySetting->clean_whatsapp ?? '6281234567890' }}?text={{ $waProductMsg }}" target="_blank" class="btn btn-outline-success btn-lg px-4 font-weight-bold">
                                <i class="fab fa-whatsapp mr-1"></i> Tanya via WhatsApp
                            </a>
                        </div>
                    </form>
                @else
                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Mohon maaf, stok produk ini saat ini sedang habis. Anda bisa menghubungi admin untuk pre-order batch baru.
                    </div>
                    @php
                        $waPoMsg = urlencode("Halo Admin, saya ingin pre-order produk yang sedang habis: {$product->name}.");
                    @endphp
                    <a href="https://wa.me/{{ $companySetting->clean_whatsapp ?? '6281234567890' }}?text={{ $waPoMsg }}" target="_blank" class="btn btn-outline-success font-weight-bold">
                        <i class="fab fa-whatsapp mr-1"></i> Pre-Order via WhatsApp
                    </a>
                @endif

                <div class="mt-4 pt-3 border-top small text-muted">
                    <div class="row">
                        <div class="col-sm-6 mb-2">
                            <i class="fas fa-shipping-fast text-primary me-2" style="color: #2b7a78 !important;"></i> Pengiriman Kampus & Seluruh Indonesia
                        </div>
                        <div class="col-sm-6 mb-2">
                            <i class="fas fa-shield-alt text-primary me-2" style="color: #2b7a78 !important;"></i> Jaminan Kualitas Modifikasi Mahasiswa
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-5">
            <h4 class="font-weight-bold mb-4">Produk Terkait Lainnya</h4>
            <div class="row g-4">
                @foreach($relatedProducts as $rel)
                    <div class="col-lg-3 col-md-6">
                        <div class="card-product-custom">
                            <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" class="card-product-img">
                            <div class="product-body">
                                <h6 class="font-weight-bold mb-1 text-truncate">
                                    <a href="{{ route('products.show', $rel->slug) }}" class="text-dark text-decoration-none">
                                        {{ $rel->name }}
                                    </a>
                                </h6>
                                <div class="product-price mb-2">{{ $rel->formatted_price }}</div>
                                <a href="{{ route('products.show', $rel->slug) }}" class="btn btn-outline-secondary btn-sm mt-auto">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function incrementQty() {
        var input = document.getElementById('quantity');
        var max = parseInt(input.getAttribute('max')) || 999;
        var val = parseInt(input.value) || 1;
        if (val < max) {
            input.value = val + 1;
        }
    }

    function decrementQty() {
        var input = document.getElementById('quantity');
        var val = parseInt(input.value) || 1;
        if (val > 1) {
            input.value = val - 1;
        }
    }
</script>
@endpush
@endsection
