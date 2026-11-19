@extends('layouts.admin')

@section('title', 'Detail Pesanan ' . $order->order_code . ' - Admin Wirausahagoo')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Detail Pesanan: {{ $order->order_code }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali ke Daftar Pesanan
    </a>
</div>

<div class="row">
    <!-- Left Column: Order Items & Customer -->
    <div class="col-lg-8">
        <!-- Order Items Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Produk yang Dipesan</h6>
                <span class="badge {{ $order->status_badge }} px-2 py-1 font-weight-bold" style="font-size: 13px;">
                    {{ $order->status_label }}
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Harga Satuan</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-right pr-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product)
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                                     class="img-thumbnail mr-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <div class="font-weight-bold text-dark">{{ $item->product->name }}</div>
                                                    <small class="text-muted">{{ $item->product->category->name ?? '-' }} (Sisa Stok: {{ $item->product->stock }})</small>
                                                </div>
                                            @else
                                                <span class="text-muted">Produk telah dihapus</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $item->formatted_price }}</td>
                                    <td class="text-center font-weight-bold">{{ $item->quantity }} pcs</td>
                                    <td class="text-right pr-4 font-weight-bold text-success">{{ $item->formatted_subtotal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <th colspan="3" class="text-right pr-4">Total Tagihan:</th>
                                <th class="text-right pr-4 font-weight-bold text-success" style="font-size: 18px;">
                                    {{ $order->formatted_total }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Shipping & Customer Info -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Customer & Pengiriman</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <span class="text-muted small d-block">Nama Lengkap Customer:</span>
                        <strong>{{ $order->user->name }}</strong>
                    </div>
                    <div class="col-md-6 mb-3">
                        <span class="text-muted small d-block">Nomor Telepon / WhatsApp:</span>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->user->phone) }}" target="_blank" class="text-success font-weight-bold">
                            <i class="fab fa-whatsapp"></i> {{ $order->user->phone ?? '-' }}
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <span class="text-muted small d-block">Alamat Email:</span>
                        <span>{{ $order->user->email }}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <span class="text-muted small d-block">Waktu Pemesanan:</span>
                        <span>{{ $order->created_at->format('d F Y, H:i') }} WIB</span>
                    </div>
                    <div class="col-12">
                        <span class="text-muted small d-block">Alamat Pengiriman Lengkap:</span>
                        <div class="p-3 bg-light rounded border mt-1" style="white-space: pre-line;">{{ $order->shipping_address }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Payment & Order Status Control -->
    <div class="col-lg-4">
        <!-- Update Order Status Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ubah Status Pesanan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label class="font-weight-bold small">Status Saat Ini:</label>
                        <select name="status" class="form-control">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="waiting_confirmation" {{ $order->status === 'waiting_confirmation' ? 'selected' : '' }}>Menunggu Konfirmasi Bukti</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi (Lunas)</option>
                            <option value="rejected" {{ $order->status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Update Status Pesanan
                    </button>
                </form>
            </div>
        </div>

        <!-- Payment Verification Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Bukti Transfer Customer</h6>
            </div>
            <div class="card-body">
                @if($order->payment)
                    <div class="text-center mb-3">
                        <a href="{{ $order->payment->proof_image_url }}" target="_blank">
                            <img src="{{ $order->payment->proof_image_url }}" alt="Bukti Transfer" class="img-thumbnail" style="max-height: 250px; width: 100%; object-fit: contain;">
                        </a>
                        <small class="text-muted d-block mt-1">Klik foto untuk perbesar</small>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted small">Status Bukti:</span><br>
                        @php
                            $pBadge = match($order->payment->status) {
                                'approved' => 'badge-success',
                                'pending' => 'badge-warning',
                                'rejected' => 'badge-danger',
                                default => 'badge-secondary'
                            };
                        @endphp
                        <span class="badge {{ $pBadge }} px-2 py-1 font-weight-bold">{{ $order->payment->status_label }}</span>
                    </div>

                    @if($order->payment->bankAccount)
                        <div class="mb-2 small">
                            <strong>Rekening Dituju:</strong><br>
                            {{ $order->payment->bankAccount->bank_name }} - {{ $order->payment->bankAccount->account_number }}
                        </div>
                    @endif

                    @if($order->payment->admin_note)
                        <div class="alert alert-light border small mt-2 mb-3">
                            <strong>Catatan Admin:</strong> {{ $order->payment->admin_note }}
                        </div>
                    @endif

                    <a href="{{ route('admin.payments.show', $order->payment->id) }}" class="btn btn-info btn-block font-weight-bold mt-3">
                        <i class="fas fa-money-check-alt mr-1"></i> Buka Halaman Verifikasi
                    </a>
                @else
                    <div class="alert alert-warning small mb-0">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Customer belum mengunggah bukti pembayaran.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
