@extends('layouts.customer')

@section('title', 'Keranjang Belanja - Wirausahagoo')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="font-weight-bold"><i class="fas fa-shopping-cart text-primary mr-2" style="color: #2b7a78 !important;"></i> Keranjang Belanja Anda</h2>
        <p class="text-muted">Periksa kembali daftar produk kerajinan mahasiswa pilihan Anda sebelum checkout.</p>
    </div>

    @if(!$cart || $cart->items->isEmpty())
        <div class="card border-0 shadow-sm p-5 text-center rounded-3">
            <div class="my-3">
                <i class="fas fa-shopping-basket fa-4x text-muted mb-3"></i>
                <h4 class="font-weight-bold text-dark">Keranjang Belanja Anda Masih Kosong</h4>
                <p class="text-muted mb-4">Yuk dukung wirausaha mahasiswa dengan memilih produk pouch pensil, totebag, dan aksesoris keren kami.</p>
                <a href="{{ route('home') }}#katalog" class="btn btn-primary px-4 py-2 font-weight-bold text-white" style="background-color: #2b7a78; border-color: #2b7a78;">
                    <i class="fas fa-store mr-1"></i> Mulai Belanja Sekarang
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            <!-- Items Table -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="font-weight-bold mb-0">Daftar Item ({{ $totalItems }} Barang)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="min-width: 220px;">Produk</th>
                                        <th class="text-center">Harga Satuan</th>
                                        <th class="text-center" style="width: 140px;">Jumlah</th>
                                        <th class="text-end pe-4">Subtotal</th>
                                        <th class="text-center" style="width: 60px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                                         class="rounded me-3 border" style="width: 65px; height: 65px; object-fit: cover;">
                                                    <div>
                                                        <h6 class="font-weight-bold mb-0">
                                                            <a href="{{ route('products.show', $item->product->slug) }}" class="text-dark text-decoration-none">
                                                                {{ $item->product->name }}
                                                            </a>
                                                        </h6>
                                                        <small class="text-muted">{{ $item->product->category->name }}</small>
                                                        @if($item->product->stock < $item->quantity)
                                                            <div class="text-danger small font-weight-bold">
                                                                <i class="fas fa-exclamation-circle"></i> Stok tersisa hanya {{ $item->product->stock }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                {{ $item->product->formatted_price }}
                                            </td>
                                            <td>
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex justify-content-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="input-group input-group-sm" style="max-width: 110px;">
                                                        <input type="number" name="quantity" class="form-control text-center" 
                                                               value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                                               onchange="this.form.submit()">
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-end pe-4 font-weight-bold" style="color: #2b7a78;">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus produk">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center">
                        <a href="{{ route('home') }}#katalog" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Lanjut Belanja
                        </a>
                        <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Ubah angka jumlah untuk update otomatis.</small>
                    </div>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 p-4">
                    <h5 class="font-weight-bold mb-3 border-bottom pb-2">Ringkasan Belanja</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Jumlah Produk:</span>
                        <span class="font-weight-bold">{{ $totalItems }} Barang</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Tagihan:</span>
                        <span class="display-6 font-weight-bold" style="color: #2b7a78; font-size: 24px;">
                            Rp {{ number_format($totalPrice, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="p-3 bg-light rounded mb-4 small text-muted">
                        <i class="fas fa-truck text-primary mr-1" style="color: #2b7a78 !important;"></i> 
                        Biaya pengiriman di lingkungan kampus <strong>GRATIS (Bebas Ongkir)</strong>.
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 py-3 font-weight-bold text-white shadow-sm" style="background-color: #2b7a78; border-color: #2b7a78;">
                        Lanjut ke Pembayaran <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
