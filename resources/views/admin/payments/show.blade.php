@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran - Admin Wirausahagoo')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Verifikasi Bukti Transfer: Pesanan {{ $payment->order->order_code }}</h1>
    <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali ke Daftar Pembayaran
    </a>
</div>

<div class="row">
    <!-- Left Column: Large Image of Transfer Proof -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Foto Bukti Transfer Customer</h6>
            </div>
            <div class="card-body text-center p-3">
                <div class="p-2 border rounded bg-light mb-3">
                    <a href="{{ $payment->proof_image_url }}" target="_blank" title="Klik untuk membuka gambar ukuran asli di tab baru">
                        <img src="{{ $payment->proof_image_url }}" alt="Bukti Transfer" class="img-fluid rounded" style="max-height: 480px; width: 100%; object-fit: contain;">
                    </a>
                </div>
                <small class="text-muted"><i class="fas fa-search-plus mr-1"></i> Klik gambar di atas untuk membuka tampilan resolusi penuh di tab baru.</small>

                <div class="mt-3 p-3 bg-white rounded border text-left">
                    <div class="row small">
                        <div class="col-6 mb-2">
                            <span class="text-muted d-block">Bank Tujuan Transfer:</span>
                            <strong class="text-dark">{{ $payment->bankAccount->bank_name ?? '-' }}</strong>
                        </div>
                        <div class="col-6 mb-2">
                            <span class="text-muted d-block">Nomor Rekening:</span>
                            <strong>{{ $payment->bankAccount->account_number ?? '-' }}</strong>
                        </div>
                        <div class="col-6">
                            <span class="text-muted d-block">Atas Nama:</span>
                            <span>{{ $payment->bankAccount->account_name ?? '-' }}</span>
                        </div>
                        <div class="col-6">
                            <span class="text-muted d-block">Waktu Upload:</span>
                            <span>{{ $payment->created_at->format('d/m/Y H:i') }} WIB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Verification Form & Order Info -->
    <div class="col-lg-6 mb-4">
        <!-- Verification Decision Card -->
        <div class="card shadow mb-4 border-left-primary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-check-double mr-1"></i> Keputusan Konfirmasi Pembayaran
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info small mb-3">
                    <i class="fas fa-info-circle mr-1"></i> <strong>Sistem Otomatis:</strong> Apabila pembayaran disetujui (Approved), status pesanan otomatis berubah menjadi <strong>Dikonfirmasi (Lunas)</strong> dan sistem akan <strong>memicu perubahan pengurangan stok</strong> untuk setiap barang yang dipesan.
                </div>

                <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Tentukan Status Pembayaran:</label>
                        <div class="p-3 border rounded bg-light">
                            <div class="custom-control custom-radio mb-2">
                                <input type="radio" id="statusApproved" name="status" value="approved" class="custom-control-input" 
                                       {{ old('status', $payment->status) === 'approved' ? 'checked' : '' }} required>
                                <label class="custom-control-label font-weight-bold text-success" for="statusApproved">
                                    <i class="fas fa-check-circle"></i> Setujui Pembayaran (Valid & Lunas)
                                </label>
                                <small class="d-block text-muted pl-4">Pesanan dikonfirmasi & stok barang otomatis berkurang.</small>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="statusRejected" name="status" value="rejected" class="custom-control-input" 
                                       {{ old('status', $payment->status) === 'rejected' ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-danger" for="statusRejected">
                                    <i class="fas fa-times-circle"></i> Tolak Pembayaran (Tidak Valid / Buram)
                                </label>
                                <small class="d-block text-muted pl-4">Pesanan ditolak dan customer diminta mengunggah ulang bukti yang sesuai.</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Catatan Admin untuk Customer:</label>
                        <textarea name="admin_note" class="form-control" rows="3" placeholder="Contoh: Pembayaran telah diterima via BCA. Pesanan segera disiapkan!">{{ old('admin_note', $payment->admin_note) }}</textarea>
                        <small class="text-muted">Catatan ini dapat dibaca oleh customer pada halaman detail pesanannya.</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block py-2 font-weight-bold shadow-sm" onclick="return confirm('Apakah Anda yakin dengan keputusan konfirmasi ini?')">
                        <i class="fas fa-save mr-1"></i> Simpan & Eksekusi Konfirmasi
                    </button>
                </form>

                @if($payment->verified_by)
                    <div class="mt-3 pt-3 border-top small text-muted">
                        Terakhir diverifikasi oleh <strong>{{ $payment->verifier->name ?? 'Admin' }}</strong> pada {{ $payment->verified_at ? $payment->verified_at->format('d M Y, H:i') : '-' }} WIB.
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Breakdown Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rincian Pesanan #{{ $payment->order->order_code }}</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Nama Customer:</span>
                    <strong>{{ $payment->order->user->name }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Nomor WhatsApp:</span>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $payment->order->user->phone) }}" target="_blank" class="text-success font-weight-bold">
                        <i class="fab fa-whatsapp"></i> {{ $payment->order->user->phone ?? '-' }}
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Status Pesanan Saat Ini:</span>
                    <span class="badge {{ $payment->order->status_badge }}">{{ $payment->order->status_label }}</span>
                </div>

                <div class="table-responsive border rounded mb-3">
                    <table class="table table-sm mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Item Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payment->order->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->product->name ?? 'Item' }}</strong><br>
                                        <small class="text-muted">Stok saat ini: {{ $item->product->stock ?? 0 }} pcs</small>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }} pcs</td>
                                    <td class="text-right text-success font-weight-bold">{{ $item->formatted_subtotal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-light font-weight-bold">
                                <td colspan="2">Total Yang Harus Dibayar:</td>
                                <td class="text-right text-success" style="font-size: 16px;">{{ $payment->order->formatted_total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div>
                    <span class="text-muted small d-block">Alamat Pengiriman:</span>
                    <small class="text-dark">{{ $payment->order->shipping_address }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
