@extends('layouts.admin')

@section('title', 'Rekening Bank Tujuan - Admin Wirausahagoo')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Kelola Rekening Bank Tujuan Transfer</h1>
    <button type="button" class="btn btn-primary shadow-sm font-weight-bold" data-toggle="modal" data-target="#addBankModal">
        <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Rekening Baru
    </button>
</div>

<!-- Bank Accounts Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Rekening Bank & E-Wallet Resmi</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Nama Bank / Provider</th>
                        <th>Nomor Rekening / No. HP</th>
                        <th>Atas Nama Rekening</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bankAccounts as $index => $bank)
                        <tr>
                            <td>{{ $bankAccounts->firstItem() + $index }}</td>
                            <td>
                                <strong class="text-dark">{{ $bank->bank_name }}</strong>
                            </td>
                            <td>
                                <span class="font-monospace font-weight-bold text-primary" style="font-size: 15px;">{{ $bank->account_number }}</span>
                            </td>
                            <td>{{ $bank->account_name }}</td>
                            <td class="text-center">
                                @if($bank->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal{{ $bank->id }}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.bank-accounts.destroy', $bank->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data rekening ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $bank->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title font-weight-bold">Edit Rekening Bank</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.bank-accounts.update', $bank->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group mb-3">
                                                <label class="font-weight-bold">Nama Bank / E-Wallet</label>
                                                <input type="text" name="bank_name" class="form-control" value="{{ $bank->bank_name }}" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="font-weight-bold">Nomor Rekening / Akun</label>
                                                <input type="text" name="account_number" class="form-control" value="{{ $bank->account_number }}" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="font-weight-bold">Atas Nama Rekening</label>
                                                <input type="text" name="account_name" class="form-control" value="{{ $bank->account_name }}" required>
                                            </div>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="is_active_{{ $bank->id }}" {{ $bank->is_active ? 'checked' : '' }}>
                                                <label class="custom-control-label font-weight-bold" for="is_active_{{ $bank->id }}">Aktifkan untuk Pembayaran Customer</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary font-weight-bold">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data rekening bank tujuan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        {{ $bankAccounts->links() }}
    </div>
</div>

<!-- Add Bank Modal -->
<div class="modal fade" id="addBankModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Tambah Rekening Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.bank-accounts.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Nama Bank / E-Wallet <span class="text-danger">*</span></label>
                        <input type="text" name="bank_name" class="form-control" placeholder="Contoh: BCA / Mandiri / QRIS" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Nomor Rekening / Akun <span class="text-danger">*</span></label>
                        <input type="text" name="account_number" class="form-control" placeholder="Contoh: 1234567890" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Atas Nama Rekening <span class="text-danger">*</span></label>
                        <input type="text" name="account_name" class="form-control" placeholder="Contoh: Wirausaha Mahasiswa Pouch" required>
                    </div>
                    <div class="custom-control custom-checkbox mt-2">
                        <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="is_active_new" checked>
                        <label class="custom-control-label font-weight-bold" for="is_active_new">Aktifkan untuk Pembayaran Customer</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Tambah Rekening</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
