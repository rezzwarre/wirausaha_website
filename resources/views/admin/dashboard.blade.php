@extends('layouts.admin')

@section('title', 'Admin Dashboard - Wirausahagoo')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Dashboard Wirausaha</h1>
    <a href="{{ route('admin.stock-movements.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Catat Stok Masuk/Keluar
    </a>
</div>

<!-- Content Row (Summary Stats) -->
<div class="row">

    <!-- Total Revenue Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Pendapatan (Lunas)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Orders Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Pesanan Masuk</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }} Pesanan</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Payments Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Perlu Konfirmasi Pembayaran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingPaymentsCount }} Pembayaran</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products & Low Stock Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Produk Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts }} Produk</div>
                        @if($lowStockProducts > 0)
                            <small class="text-danger font-weight-bold"><i class="fas fa-exclamation-triangle"></i> {{ $lowStockProducts }} stok menipis</small>
                        @endif
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-boxes fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Recent Payments Needing Verification -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-money-check-alt mr-1"></i> Bukti Pembayaran Customer Terbaru
                </h6>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Bukti Transfer</th>
                                <th>Pesanan & Pembeli</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPayments as $payment)
                                <tr>
                                    <td>
                                        <a href="{{ $payment->proof_image_url }}" target="_blank">
                                            <img src="{{ $payment->proof_image_url }}" alt="Bukti" class="img-thumbnail" style="width: 55px; height: 55px; object-fit: cover;">
                                        </a>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $payment->order->order_code ?? '-' }}</div>
                                        <small class="text-muted">{{ $payment->order->user->name ?? '-' }} ({{ $payment->order->formatted_total ?? '-' }})</small>
                                    </td>
                                    <td>
                                        @php
                                            $pBadge = match($payment->status) {
                                                'approved' => 'badge-success',
                                                'pending' => 'badge-warning',
                                                'rejected' => 'badge-danger',
                                                default => 'badge-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $pBadge }}">{{ $payment->status_label }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-search"></i> Verifikasi
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Belum ada pembayaran masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-shopping-bag mr-1"></i> Pesanan Customer Terbaru
                </h6>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td class="font-weight-bold text-primary">{{ $order->order_code }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->formatted_total }}</td>
                                    <td>
                                        <span class="badge {{ $order->status_badge }}">{{ $order->status_label }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3 text-muted">Belum ada data pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Recent Stock Movements -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-exchange-alt mr-1"></i> Riwayat Stok Masuk / Keluar Terbaru
                </h6>
                <a href="{{ route('admin.stock-movements.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Riwayat</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Waktu</th>
                                <th>Produk</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                                <th>Catatan / Keterangan</th>
                                <th>Dicatat Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentStockMovements as $mov)
                                <tr>
                                    <td>{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="font-weight-bold">{{ $mov->product->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $mov->type_badge }}">{{ $mov->type_label }}</span>
                                    </td>
                                    <td class="font-weight-bold">{{ $mov->quantity }} pcs</td>
                                    <td>{{ $mov->note }}</td>
                                    <td><small>{{ $mov->creator->name ?? 'Sistem' }}</small></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3 text-muted">Belum ada riwayat pergerakan stok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
