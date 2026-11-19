@extends('layouts.customer')

@section('title', 'Riwayat Pesanan Saya - Wirausahagoo')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h2 class="font-weight-bold"><i class="fas fa-receipt text-primary mr-2" style="color: #2b7a78 !important;"></i> Riwayat Pesanan Saya</h2>
            <p class="text-muted">Pantau status konfirmasi pesanan dan pembayaran produk kerajinan Anda.</p>
        </div>
        <a href="{{ route('home') }}#katalog" class="btn btn-outline-primary font-weight-bold" style="border-color: #2b7a78; color: #2b7a78;">
            <i class="fas fa-plus mr-1"></i> Pesan Produk Baru
        </a>
    </div>

    @if($orders->isEmpty())
        <div class="card border-0 shadow-sm p-5 text-center rounded-3">
            <div class="my-3">
                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                <h4 class="font-weight-bold text-dark">Belum Ada Pesanan</h4>
                <p class="text-muted mb-4">Anda belum pernah melakukan pemesanan produk kerajinan mahasiswa.</p>
                <a href="{{ route('home') }}#katalog" class="btn btn-primary px-4 py-2 font-weight-bold text-white" style="background-color: #2b7a78; border-color: #2b7a78;">
                    Mulai Belanja Sekarang
                </a>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Kode Pesanan</th>
                            <th>Tanggal</th>
                            <th>Total Tagihan</th>
                            <th>Status Pesanan</th>
                            <th>Status Pembayaran</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $ord)
                            <tr>
                                <td class="ps-4 font-weight-bold">
                                    <span class="text-primary font-monospace" style="color: #2b7a78 !important; font-size: 15px;">
                                        {{ $ord->order_code }}
                                    </span>
                                </td>
                                <td>
                                    {{ $ord->created_at->format('d M Y, H:i') }} WIB
                                </td>
                                <td class="font-weight-bold" style="color: #2b7a78;">
                                    {{ $ord->formatted_total }}
                                </td>
                                <td>
                                    @php
                                        $badgeBg = match($ord->status) {
                                            'confirmed' => 'bg-success',
                                            'waiting_confirmation' => 'bg-info text-dark',
                                            'pending' => 'bg-warning text-dark',
                                            'rejected' => 'bg-danger',
                                            'cancelled' => 'bg-secondary',
                                            default => 'bg-dark'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeBg }} px-2 py-1">
                                        {{ $ord->status_label }}
                                    </span>
                                </td>
                                <td>
                                    @if($ord->payment)
                                        @php
                                            $payBg = match($ord->payment->status) {
                                                'approved' => 'bg-success',
                                                'pending' => 'bg-warning text-dark',
                                                'rejected' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $payBg }} px-2 py-1">
                                            {{ $ord->payment->status_label }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary px-2 py-1">Belum Upload Bukti</span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    <a href="{{ route('orders.show', $ord->id) }}" class="btn btn-sm btn-primary text-white font-weight-bold" style="background-color: #2b7a78; border-color: #2b7a78;">
                                        <i class="fas fa-eye mr-1"></i> Detail & Bukti
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
