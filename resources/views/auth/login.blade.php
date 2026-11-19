@extends('layouts.customer')

@section('title', 'Masuk Akun - Wirausahagoo')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white text-center py-4 border-0">
                    <div class="mb-2">
                        <i class="fas fa-lock text-primary fa-3x" style="color: #2b7a78 !important;"></i>
                    </div>
                    <h4 class="font-weight-bold mb-1">Masuk ke Wirausahagoo</h4>
                    <p class="text-muted small">Silakan masuk untuk berbelanja produk kerajinan mahasiswa</p>
                </div>
                <div class="card-body px-4 py-3">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required placeholder="contoh@mahasiswa.ac.id">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-key text-muted"></i></span>
                                <input type="password" name="password" id="password" class="form-control" required placeholder="Masukkan password">
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label small text-muted" for="remember">Ingat Saya</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 font-weight-bold text-white" style="background-color: #2b7a78; border-color: #2b7a78;">
                            <i class="fas fa-sign-in-alt mr-1"></i> Masuk Sekarang
                        </button>
                    </form>

                    <!-- Quick Demo Credentials for Testing -->
                    <div class="mt-4 p-3 bg-light rounded border">
                        <h6 class="font-weight-bold text-muted small mb-2"><i class="fas fa-info-circle mr-1"></i> Akun Demo Pengujian:</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="fillLogin('admin@wirausahagoo.com', 'password')">
                                <i class="fas fa-user-shield"></i> Isi Akun Admin
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="fillLogin('budi@mahasiswa.ac.id', 'password')">
                                <i class="fas fa-user"></i> Isi Akun Customer
                            </button>
                        </div>
                        <small class="text-muted d-block text-center">(Password: <code>password</code>)</small>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-muted small mb-0">Belum memiliki akun? <a href="{{ route('register') }}" class="font-weight-bold text-primary" style="color: #2b7a78 !important;">Daftar di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function fillLogin(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endpush
@endsection
