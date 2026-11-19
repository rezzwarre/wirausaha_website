@extends('layouts.customer')

@section('title', 'Daftar Akun Baru - Wirausahagoo')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white text-center py-4 border-0">
                    <div class="mb-2">
                        <i class="fas fa-user-plus text-primary fa-3x" style="color: #2b7a78 !important;"></i>
                    </div>
                    <h4 class="font-weight-bold mb-1">Daftar Akun Customer</h4>
                    <p class="text-muted small">Buat akun untuk memesan produk pouch pensil & kerajinan kreatif</p>
                </div>
                <div class="card-body px-4 py-3">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap Anda">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="nama@email.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Nomor WhatsApp / HP</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required placeholder="Contoh: 081234567890">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Alamat Pengiriman (Kampus / Kost / Rumah)</label>
                            <textarea name="address" class="form-control" rows="2" required placeholder="Tuliskan alamat lengkap pengiriman pesanan">{{ old('address') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Password</label>
                                <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 font-weight-bold text-white mt-2" style="background-color: #2b7a78; border-color: #2b7a78;">
                            <i class="fas fa-check-circle mr-1"></i> Selesaikan Pendaftaran
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted small mb-0">Sudah memiliki akun? <a href="{{ route('login') }}" class="font-weight-bold text-primary" style="color: #2b7a78 !important;">Masuk di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
