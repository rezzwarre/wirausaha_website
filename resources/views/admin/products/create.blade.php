@extends('layouts.admin')

@section('title', 'Tambah Produk Baru - Admin Wirausahagoo')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Tambah Produk Baru</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali ke Daftar Produk
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Formulir Data Produk Kerajinan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label font-weight-bold">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Pouch Pensil Kanvas Modifikasi Batik">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label font-weight-bold">Kategori Produk <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Harga Produk (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" value="{{ old('price') }}" required min="0" step="500" placeholder="Contoh: 25000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold">Jumlah Stok Awal <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', 10) }}" required min="0" placeholder="Contoh: 20">
                            <small class="text-muted">Akan otomatis dicatat sebagai stok masuk (Stock In) pertama kali.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Deskripsi Produk</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan keunikan bahan kerajinan, fungsi kompartemen, dan modifikasi mahasiswa...">{{ old('description') }}</textarea>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-md-8">
                            <label class="form-label font-weight-bold">Foto Produk (Opsional)</label>
                            <input type="file" name="image" class="form-control-file border p-1 rounded w-100" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, WEBP (Maksimal 3MB). Jika dikosongkan, gambar template default akan digunakan.</small>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mt-3">
                                <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-dark" for="is_active">Aktifkan untuk Dijual</label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mr-2">Batal</a>
                        <button type="submit" class="btn btn-primary font-weight-bold">
                            <i class="fas fa-save mr-1"></i> Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
