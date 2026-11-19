@extends('layouts.customer')

@section('title', 'Pembayaran & Checkout - Wirausahagoo')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="font-weight-bold"><i class="fas fa-credit-card text-primary mr-2" style="color: #2b7a78 !important;"></i> Pembayaran & Checkout</h2>
        <p class="text-muted">Lengkapi data pengiriman dan lakukan transfer sesuai data rekening tujuan.</p>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <!-- Left Column: Shipping & Payment Method -->
            <div class="col-lg-7">
                <!-- Data Penerima & Pengiriman -->
                <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                    <h5 class="font-weight-bold mb-3 border-bottom pb-2">
                        <i class="fas fa-map-marker-alt text-danger mr-2"></i> Alamat & Data Pengiriman
                    </h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <label class="form-label font-weight-bold small text-muted">Nama Pembeli:</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label font-weight-bold small text-muted">No. WhatsApp / HP:</label>
                            <input type="text" class="form-control" value="{{ $user->phone }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Alamat Pengiriman Lengkap <span class="text-danger">*</span></label>
                        <textarea name="shipping_address" class="form-control" rows="3" required placeholder="Contoh: Gedung PKM Kampus, Lantai 2 / Kost Melati No. 5B">{{ old('shipping_address', $user->address) }}</textarea>
                        <small class="text-muted">Pastikan alamat jelas (nama gedung/kampus/kamar kost) untuk mempermudah pengantaran.</small>
                    </div>
                </div>

                <!-- Rekening Bank Tujuan Transfer -->
                <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                    <h5 class="font-weight-bold mb-3 border-bottom pb-2">
                        <i class="fas fa-university text-primary mr-2" style="color: #2b7a78 !important;"></i> Pilih Rekening Bank Tujuan Transfer <span class="text-danger">*</span>
                    </h5>
                    <p class="text-muted small mb-3">Silakan transfer total tagihan ke salah satu rekening resmi wirausaha mahasiswa berikut:</p>

                    <div class="row g-3">
                        @foreach($bankAccounts as $bank)
                            <div class="col-12">
                                <div class="form-check p-3 border rounded bg-light d-flex align-items-center">
                                    <input class="form-check-input me-3" type="radio" name="bank_account_id" id="bank_{{ $bank->id }}" 
                                           value="{{ $bank->id }}" {{ $loop->first ? 'checked' : '' }} required style="transform: scale(1.3);">
                                    <label class="form-check-label flex-grow-1" for="bank_{{ $bank->id }}">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <div>
                                                <strong class="text-dark d-block" style="font-size: 16px;">{{ $bank->bank_name }}</strong>
                                                <span class="text-primary font-weight-bold" style="color: #2b7a78 !important; font-size: 15px;">{{ $bank->account_number }}</span>
                                                <span class="text-muted small d-block">a.n. {{ $bank->account_name }}</span>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary mt-1 mt-md-0" onclick="navigator.clipboard.writeText('{{ $bank->account_number }}'); alert('Nomor rekening disalin: {{ $bank->account_number }}')">
                                                <i class="fas fa-copy mr-1"></i> Salin
                                            </button>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Upload Bukti Transfer -->
                <div class="card border-0 shadow-sm rounded-3 p-4">
                    <h5 class="font-weight-bold mb-3 border-bottom pb-2">
                        <i class="fas fa-receipt text-success mr-2"></i> Upload Bukti Pembayaran / Transfer
                    </h5>
                    <p class="text-muted small">
                        Unggah struk / tangkapan layar (screenshot) transfer bank atau QRIS Anda.
                    </p>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">File Gambar Bukti Transfer (Opsional saat ini, dapat diupload nanti):</label>
                        <input type="file" name="proof_image" class="form-control" accept="image/*">
                        <small class="text-muted">Format file: JPG, PNG, WEBP (Maksimal 3MB). Jika belum transfer sekarang, Anda dapat mengunggahnya nanti di halaman riwayat pesanan.</small>
                    </div>

                    <div class="alert alert-info py-2 small mb-0">
                        <i class="fas fa-info-circle mr-1"></i> Setelah bukti transfer diupload, admin kami akan segera mengonfirmasi pesanan dan memproses stok barang.
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Items Summary & Submit -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-3 p-4 sticky-top" style="top: 20px;">
                    <h5 class="font-weight-bold mb-3 border-bottom pb-2">Rincian Pembelian</h5>

                    <div class="mb-3" style="max-height: 280px; overflow-y: auto;">
                        @foreach($cart->items as $item)
                            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                     class="rounded me-2 border" style="width: 50px; height: 50px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h6 class="font-weight-bold mb-0 text-truncate" style="max-width: 180px;">{{ $item->product->name }}</h6>
                                    <small class="text-muted">{{ $item->quantity }} x {{ $item->product->formatted_price }}</small>
                                </div>
                                <div class="text-end font-weight-bold" style="color: #2b7a78;">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal Produk:</span>
                        <span class="font-weight-bold">Rp {{ number_format($cart->total_price, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Ongkos Kirim (Kampus):</span>
                        <span class="text-success font-weight-bold">GRATIS</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="font-weight-bold" style="font-size: 16px;">Total Pembayaran:</span>
                        <span class="display-6 font-weight-bold" style="color: #2b7a78; font-size: 26px;">
                            Rp {{ number_format($cart->total_price, 0, ',', '.') }}
                        </span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 font-weight-bold text-white shadow" style="background-color: #2b7a78; border-color: #2b7a78;">
                        <i class="fas fa-check-circle mr-1"></i> Konfirmasi & Buat Pesanan
                    </button>

                    <div class="text-center mt-3">
                        <a href="{{ route('cart.index') }}" class="text-muted small text-decoration-none">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
