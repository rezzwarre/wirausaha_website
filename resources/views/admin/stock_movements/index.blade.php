@extends('layouts.admin')

@section('title', 'Riwayat Stok Masuk & Keluar - Admin Wirausahagoo')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Riwayat Stok Barang (Masuk & Keluar)</h1>
    <button type="button" class="btn btn-primary shadow-sm font-weight-bold" data-toggle="modal" data-target="#addStockModal">
        <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Catat Stok Masuk / Keluar Manual
    </button>
</div>

<!-- Filters -->
<div class="card shadow mb-4">
    <div class="card-body py-3">
        <form action="{{ route('admin.stock-movements.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4 mb-2 mb-md-0">
                <select name="product_id" class="form-control form-control-sm">
                    <option value="">-- Semua Produk --</option>
                    @foreach($products as $prod)
                        <option value="{{ $prod->id }}" {{ request('product_id') == $prod->id ? 'selected' : '' }}>
                            {{ $prod->name }} (Stok saat ini: {{ $prod->stock }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <select name="type" class="form-control form-control-sm">
                    <option value="">-- Semua Tipe Gerak --</option>
                    <option value="in" {{ request('type') === 'in' ? 'selected' : '' }}>Stok Masuk (+)</option>
                    <option value="out" {{ request('type') === 'out' ? 'selected' : '' }}>Stok Keluar (-)</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                @if(request('type') || request('product_id'))
                    <a href="{{ route('admin.stock-movements.index') }}" class="btn btn-sm btn-outline-secondary ml-1">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Stock Movements Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Log Riwayat Pergerakan Stok ({{ $movements->total() }} Catatan)</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Waktu Catat</th>
                        <th>Nama Produk</th>
                        <th class="text-center">Tipe Pergerakan</th>
                        <th class="text-center">Jumlah</th>
                        <th>Pesanan Terkait</th>
                        <th>Keterangan / Catatan</th>
                        <th>Dicatat Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movements as $mov)
                        <tr>
                            <td>{{ $mov->created_at->format('d/m/Y H:i') }} WIB</td>
                            <td>
                                <strong class="text-dark">{{ $mov->product->name ?? 'Produk dihapus' }}</strong>
                            </td>
                            <td class="text-center">
                                @if($mov->type === 'in')
                                    <span class="badge badge-success px-2 py-1"><i class="fas fa-arrow-down mr-1"></i> Masuk (+)</span>
                                @else
                                    <span class="badge badge-danger px-2 py-1"><i class="fas fa-arrow-up mr-1"></i> Keluar (-)</span>
                                @endif
                            </td>
                            <td class="text-center font-weight-bold" style="font-size: 15px;">
                                {{ $mov->quantity }} pcs
                            </td>
                            <td>
                                @if($mov->order)
                                    <a href="{{ route('admin.orders.show', $mov->order_id) }}" class="font-weight-bold text-primary">
                                        {{ $mov->order->order_code }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $mov->note }}</td>
                            <td>
                                <small class="text-muted font-weight-bold">{{ $mov->creator->name ?? 'Sistem' }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada riwayat pergerakan stok barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        {{ $movements->links() }}
    </div>
</div>

<!-- Modal Catat Stok Manual -->
<div class="modal fade" id="addStockModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Catat Stok Masuk / Keluar Manual</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.stock-movements.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Pilih Produk <span class="text-danger">*</span></label>
                        <select name="product_id" class="form-control" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $prod)
                                <option value="{{ $prod->id }}">
                                    {{ $prod->name }} (Stok Saat Ini: {{ $prod->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Tipe Pergerakan Stok <span class="text-danger">*</span></label>
                        <select name="type" class="form-control" required>
                            <option value="in">Stok Masuk (+) - Restock / Tambah Produksi Baru</option>
                            <option value="out">Stok Keluar (-) - Kerusakan / Penyesuaian Barang</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Jumlah Barang (pcs) <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" class="form-control" min="1" placeholder="Contoh: 20" required>
                    </div>

                    <div class="form-group mb-2">
                        <label class="font-weight-bold">Keterangan / Catatan <span class="text-danger">*</span></label>
                        <textarea name="note" class="form-control" rows="3" placeholder="Contoh: Selesai jahit batch kedua pouch pensil batik mahasiswa" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Simpan Perubahan Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
