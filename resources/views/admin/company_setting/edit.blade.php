@extends('layouts.admin')

@section('title', 'Kelola Kontak & Nomor Telepon Perusahaan - Admin Wirausahagoo')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Pengaturan Kontak & Nomor Telepon Perusahaan</h1>
</div>

<div class="row">
    <!-- Form Edit Kontak -->
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-phone-alt mr-1"></i> Form Kelola Nomor Telepon & Informasi Toko
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.company-setting.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Nomor Telepon Utama Perusahaan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $setting->phone) }}" required placeholder="Contoh: 0812-3456-7890">
                        </div>
                        <small class="text-muted">Ditampilkan pada bagian footer website dan informasi kontak toko.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Nomor WhatsApp Resmi Toko <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-success"><i class="fab fa-whatsapp"></i></span>
                            </div>
                            <input type="text" name="whatsapp_number" class="form-control" value="{{ old('whatsapp_number', $setting->whatsapp_number) }}" required placeholder="Contoh: 081234567890">
                        </div>
                        <small class="text-muted">Digunakan untuk seluruh tombol <strong>"Chat WhatsApp"</strong> (tombol melayang, konfirmasi pesanan, dan konsultasi produk). Boleh diawali 08... atau 62..., sistem akan otomatis menyesuaikan tautan resmi WhatsApp.</small>
                    </div>

                    <hr>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Nama Toko / Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $setting->company_name) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Alamat Email Resmi</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $setting->email) }}" placeholder="admin@wirausahagoo.com">
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Alamat Kantor / Rumah Produksi</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address', $setting->address) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2 shadow-sm">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan Nomor Telepon
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Live Preview Card -->
    <div class="col-lg-5">
        <div class="card shadow mb-4 border-left-success">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-eye mr-1"></i> Preview Tampilan Kontak di Website
                </h6>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-3">
                    Setiap kali Anda memperbarui nomor telepon di sebelah kiri, seluruh tampilan kontak pelanggan akan otomatis berubah ke nomor baru ini:
                </p>

                <div class="p-3 bg-light rounded border mb-3">
                    <span class="text-muted small d-block font-weight-bold">Nomor Telepon Toko:</span>
                    <h5 class="font-weight-bold text-dark mb-0">{{ $setting->phone }}</h5>
                </div>

                <div class="p-3 bg-light rounded border mb-3">
                    <span class="text-muted small d-block font-weight-bold">Nomor WhatsApp Aktif:</span>
                    <h5 class="font-weight-bold text-success mb-1">
                        <i class="fab fa-whatsapp"></i> {{ $setting->whatsapp_number }}
                    </h5>
                    <small class="text-muted">Target tautan otomatis: <code>https://wa.me/{{ $setting->clean_whatsapp }}</code></small>
                </div>

                <div class="p-3 bg-light rounded border mb-3">
                    <span class="text-muted small d-block font-weight-bold">Uji Coba Tombol WhatsApp:</span>
                    <a href="https://wa.me/{{ $setting->clean_whatsapp }}?text={{ urlencode('Halo Admin, ini pesan tes dari panel wirausaha.') }}" 
                       target="_blank" class="btn btn-success btn-sm font-weight-bold mt-2">
                        <i class="fab fa-whatsapp mr-1"></i> Klik untuk Tes Chat WhatsApp
                    </a>
                </div>

                <div class="alert alert-info small mb-0">
                    <i class="fas fa-check-circle mr-1"></i> <strong>Otomatis Terintegrasi:</strong> Tombol chat di katalog beranda, detail produk, tombol melayang, dan halaman pesanan customer akan langsung menggunakan nomor yang tersimpan di sini.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
