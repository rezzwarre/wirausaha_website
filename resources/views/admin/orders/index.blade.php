@extends('layouts.admin')

@section('title', 'Pesanan Customer - Admin Wirausahagoo')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Pesanan Customer</h1>
</div>

<!-- Filters -->
<div class="card shadow mb-4">
    <div class="card-body py-3">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5 mb-2 mb-md-0">
                <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari kode pesanan / nama customer..." value="{{ request('q') }}">
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <select name="status" class="form-control form-control-sm">
                    <option value="">-- Semua Status Pesanan --</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="waiting_confirmation" {{ request('status') === 'waiting_confirmation' ? 'selected' : '' }}>Menunggu Konfirmasi Bukti</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi (Lunas)</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                @if(request('q') || request('status'))
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary ml-1">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Orders Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi Pesanan ({{ $orders->total() }})</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Customer</th>
                        <th>Waktu Pesan</th>
                        <th>Total Tagihan</th>
                        <th>Status Pesanan</th>
                        <th>Status Bukti Bayar</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $ord)
                        <tr>
                            <td class="font-weight-bold text-primary">{{ $ord->order_code }}</td>
                            <td>
                                <div class="font-weight-bold">{{ $ord->user->name }}</div>
                                <small class="text-muted">{{ $ord->user->phone ?? $ord->user->email }}</small>
                            </td>
                            <td>{{ $ord->created_at->format('d/m/Y H:i') }}</td>
                            <td class="font-weight-bold text-success">{{ $ord->formatted_total }}</td>
                            <td>
                                <span class="badge {{ $ord->status_badge }} px-2 py-1">{{ $ord->status_label }}</span>
                            </td>
                            <td>
                                @if($ord->payment)
                                    @php
                                        $payBadge = match($ord->payment->status) {
                                            'approved' => 'badge-success',
                                            'pending' => 'badge-warning',
                                            'rejected' => 'badge-danger',
                                            default => 'badge-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $payBadge }}">{{ $ord->payment->status_label }}</span>
                                @else
                                    <span class="badge badge-secondary">Belum Upload</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="btn btn-sm btn-info font-weight-bold" title="Detail Pesanan">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        {{ $orders->links() }}
    </div>
</div>
@endsection
