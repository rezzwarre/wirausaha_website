@extends('layouts.customer')

@section('title', 'Profil Saya - Wirausahagoo')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="font-weight-bold"><i class="fas fa-user-circle text-primary mr-2" style="color: #2b7a78 !important;"></i> Profil Akun Saya</h2>
        <p class="text-muted">Kelola data profil dan alamat pengiriman Anda.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 p-4">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Alamat Email (Akun)</label>
                            <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
                            <small class="text-muted">Email tidak dapat diubah.</small>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required placeholder="Contoh: 081234567890">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Status Akun</label>
                            <input type="text" class="form-control bg-light" value="Customer Mahasiswa" readonly>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-weight-bold">Alamat Pengiriman Utama <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control" rows="3" required>{{ old('address', $user->address) }}</textarea>
                        <small class="text-muted">Alamat ini akan otomatis digunakan sebagai alamat pengiriman saat checkout.</small>
                    </div>

                    <hr>

                    <h5 class="font-weight-bold mb-3 text-muted">Ganti Password (Opsional)</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small font-weight-bold">Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin ganti">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small font-weight-bold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold text-white shadow-sm" style="background-color: #2b7a78; border-color: #2b7a78;">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
