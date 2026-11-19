@extends('layouts.customer')

@section('title', 'Detail Pesanan #' . $order->order_code . ' - Wirausahagoo')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 rounded">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}" class="text-decoration-none">Pesanan Saya</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $order->order_code }}</li>
        </ol>
    </nav>

    <!-- Header & WhatsApp Action -->
    <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="text-muted small">Nomor Pesanan:</span>
                <h3 class="font-weight-bold mb-1" style="color: #2b7a78;">{{ $order->order_code }}</h3>
                <span class="text-muted small">Waktu Pemesanan: {{ $order->created_at->format('d F Y - H:i') }} WIB</span>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                @php
                    $badgeBg = match($order->status) {
                        'confirmed' => 'bg-success',
                        'waiting_confirmation' => 'bg-info text-dark',
                        'pending' => 'bg-warning text-dark',
                        'rejected' => 'bg-danger',
                        'cancelled' => 'bg-secondary',
                        default => 'bg-dark'
                    };
                @endphp
                <span class="badge {{ $badgeBg }} p-2" style="font-size: 14px;">
                    Status: {{ $order->status_label }}
                </span>

                <!-- Direct WhatsApp Chat Button -->
                <a href="{{ $waUrl }}" target="_blank" class="btn btn-success font-weight-bold text-white shadow-sm">
                    <i class="fab fa-whatsapp fa-lg mr-1"></i> Chat Admin via WhatsApp
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Order Items & Shipping Address -->
        <div class="col-lg-7">
            <!-- Order Items -->
            <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                <h5 class="font-weight-bold mb-3 border-bottom pb-2">
                    <i class="fas fa-boxes text-primary mr-2" style="color: #2b7a78 !important;"></i> Produk yang Dipesan
                </h5>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product)
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                                     class="rounded me-2 border" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <h6 class="font-weight-bold mb-0">{{ $item->product->name }}</h6>
                                                    <small class="text-muted">{{ $item->product->category->name ?? '-' }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">Produk telah dihapus</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $item->formatted_price }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end font-weight-bold" style="color: #2b7a78;">
                                        {{ $item->formatted_subtotal }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end pt-3">Total Tagihan:</th>
                                <th class="text-end pt-3 font-weight-bold" style="color: #2b7a78; font-size: 18px;">
                                    {{ $order->formatted_total }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="card border-0 shadow-sm rounded-3 p-4">
                <h5 class="font-weight-bold mb-3 border-bottom pb-2">
                    <i class="fas fa-map-marker-alt text-danger mr-2"></i> Alamat Pengiriman
                </h5>
                <p class="mb-1 font-weight-bold text-dark">{{ $order->user->name }} ({{ $order->user->phone }})</p>
                <p class="text-muted mb-0" style="white-space: pre-line;">{{ $order->shipping_address }}</p>
            </div>
        </div>

        <!-- Right Column: Payment Status & Upload Form -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-3 p-4">
                <h5 class="font-weight-bold mb-3 border-bottom pb-2">
                    <i class="fas fa-wallet text-success mr-2"></i> Status & Bukti Pembayaran
                </h5>

                @if($order->payment)
                    <!-- Payment Status Alert -->
                    @if($order->payment->status === 'approved')
                        <div class="alert alert-success d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle fa-2x me-3"></i>
                            <div>
                                <h6 class="font-weight-bold mb-0">Pembayaran Terverifikasi (Lunas)</h6>
                                <small>Diverifikasi pada: {{ $order->payment->verified_at ? $order->payment->verified_at->format('d M Y, H:i') : '-' }} WIB</small>
                            </div>
                        </div>
                        @if($order->payment->admin_note)
                            <div class="p-3 bg-light rounded mb-3 small">
                                <strong>Catatan Admin:</strong> {{ $order->payment->admin_note }}
                            </div>
                        @endif
                    @elseif($order->payment->status === 'pending')
                        <div class="alert alert-info d-flex align-items-center mb-3">
                            <i class="fas fa-clock fa-2x me-3"></i>
                            <div>
                                <h6 class="font-weight-bold mb-0">Menunggu Konfirmasi Admin</h6>
                                <small>Bukti transfer Anda telah diterima dan sedang diproses verifikasi oleh tim admin.</small>
                            </div>
                        </div>
                    @elseif($order->payment->status === 'rejected')
                        <div class="alert alert-danger mb-3">
                            <h6 class="font-weight-bold mb-1"><i class="fas fa-times-circle mr-1"></i> Bukti Pembayaran Ditolak</h6>
                            <p class="small mb-0"><strong>Alasan / Catatan Admin:</strong> {{ $order->payment->admin_note ?: 'Bukti tidak jelas atau nominal tidak cocok.' }}</p>
                            <small class="d-block mt-2 font-weight-bold">Silakan upload ulang bukti transfer yang benar di bawah ini:</small>
                        </div>
                    @endif

                    <!-- Display Uploaded Proof -->
                    <div class="mb-3 text-center p-3 bg-light rounded border">
                        <span class="d-block text-muted small mb-2 font-weight-bold">Bukti Transfer yang Diunggah:</span>
                        <a href="{{ $order->payment->proof_image_url }}" target="_blank">
                            <img src="{{ $order->payment->proof_image_url }}" alt="Bukti Transfer" class="img-fluid rounded border" style="max-height: 220px; object-fit: contain;">
                        </a>
                        <small class="d-block text-muted mt-2">Klik gambar untuk melihat ukuran penuh</small>
                        @if($order->payment->bankAccount)
                            <div class="mt-2 text-start small border-top pt-2">
                                <div><strong>Rekening Tujuan:</strong> {{ $order->payment->bankAccount->bank_name }}</div>
                                <div><strong>Nomor Rekening:</strong> {{ $order->payment->bankAccount->account_number }} (a.n. {{ $order->payment->bankAccount->account_name }})</div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="alert alert-warning mb-3">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Anda belum mengunggah bukti pembayaran untuk pesanan ini.
                    </div>
                @endif

                <!-- Upload / Re-Upload Form (Only if not approved and not cancelled) -->
                @if(!$order->payment || $order->payment->status === 'rejected' || $order->status === 'pending')
                    <div class="mt-3 p-3 bg-light rounded border">
                        <h6 class="font-weight-bold mb-2">
                            {{ $order->payment ? 'Upload Ulang Bukti Transfer' : 'Form Upload Bukti Pembayaran' }}
                        </h6>
                        <form action="{{ route('orders.payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label font-weight-bold small">Pilih Bank Tujuan Transfer:</label>
                                <select name="bank_account_id" class="form-select form-select-sm" required>
                                    @foreach($bankAccounts as $bank)
                                        <option value="{{ $bank->id }}">
                                            {{ $bank->bank_name }} - {{ $bank->account_number }} ({{ $bank->account_name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold small">File Gambar Bukti Transfer:</label>
                                <input type="file" name="proof_image" class="form-control form-control-sm" accept="image/*" required>
                                <small class="text-muted" style="font-size: 11px;">Maksimal 3MB (JPG, PNG, WEBP)</small>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm w-100 text-white font-weight-bold" style="background-color: #2b7a78; border-color: #2b7a78;">
                                <i class="fas fa-upload mr-1"></i> Kirim Bukti Transfer
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Destination Bank Reference -->
                <div class="mt-4 pt-3 border-top">
                    <h6 class="font-weight-bold small text-muted mb-2"><i class="fas fa-info-circle mr-1"></i> Info Rekening Resmi Wirausaha:</h6>
                    <ul class="list-unstyled small mb-0">
                        @foreach($bankAccounts as $bank)
                            <li class="mb-2 p-2 bg-white rounded border">
                                <strong>{{ $bank->bank_name }}</strong>: 
                                <span class="text-primary font-weight-bold" style="color: #2b7a78 !important;">{{ $bank->account_number }}</span><br>
                                <span class="text-muted">a.n. {{ $bank->account_name }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
