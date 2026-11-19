@extends('layouts.admin')

@section('title', 'Konfirmasi Pembayaran - Admin Wirausahagoo')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Konfirmasi Bukti Pembayaran</h1>
</div>

<!-- Filters -->
<div class="card shadow mb-4">
    <div class="card-body py-3">
        <form action="{{ route('admin.payments.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <select name="status" class="form-control form-control-sm">
                    <option value="">-- Semua Status Pembayaran --</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi (Pending)</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui (Approved)</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                @if(request('status'))
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-outline-secondary ml-1">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Payments Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Bukti Transfer Masuk ({{ $payments->total() }})</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 80px;">Bukti Foto</th>
                        <th>Kode Pesanan & Customer</th>
                        <th>Rekening Tujuan</th>
                        <th>Total Tagihan</th>
                        <th>Waktu Upload</th>
                        <th>Status</th>
                        <th>Verifikator</th>
                        <th class="text-center" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $pay)
                        <tr>
                            <td>
                                <a href="{{ $pay->proof_image_url }}" target="_blank">
                                    <img src="{{ $pay->proof_image_url }}" alt="Bukti" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                </a>
                            </td>
                            <td>
                                <div class="font-weight-bold text-primary">{{ $pay->order->order_code ?? '-' }}</div>
                                <small class="text-dark font-weight-bold">{{ $pay->order->user->name ?? '-' }}</small><br>
                                <small class="text-muted">{{ $pay->order->user->phone ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="badge badge-light border">{{ $pay->bankAccount->bank_name ?? '-' }}</span><br>
                                <small class="text-muted">{{ $pay->bankAccount->account_number ?? '-' }}</small>
                            </td>
                            <td class="font-weight-bold text-success">
                                {{ $pay->order ? $pay->order->formatted_total : '-' }}
                            </td>
                            <td>{{ $pay->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @php
                                    $pBadge = match($pay->status) {
                                        'approved' => 'badge-success',
                                        'pending' => 'badge-warning',
                                        'rejected' => 'badge-danger',
                                        default => 'badge-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $pBadge }} px-2 py-1 font-weight-bold">{{ $pay->status_label }}</span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $pay->verifier->name ?? 'Belum diverifikasi' }}
                                </small>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.payments.show', $pay->id) }}" class="btn btn-sm btn-info font-weight-bold">
                                    <i class="fas fa-search mr-1"></i> Periksa
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada bukti pembayaran yang diunggah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        {{ $payments->links() }}
    </div>
</div>
@endsection
