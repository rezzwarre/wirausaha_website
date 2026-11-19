@extends('layouts.admin')

@section('title', 'Data Produk - Admin Wirausahagoo')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Kelola Data Produk</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm font-weight-bold">
        <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Produk Baru
    </a>
</div>

<!-- Filter and Search -->
<div class="card shadow mb-4">
    <div class="card-body py-3">
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5 mb-2 mb-md-0">
                <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari nama produk..." value="{{ request('q') }}">
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <select name="category_id" class="form-control form-control-sm">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                @if(request('q') || request('category_id'))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary ml-1">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Produk Kerajinan Mahasiswa ({{ $products->total() }})</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 80px;">Gambar</th>
                        <th>Nama Produk & Slug</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                        <tr>
                            <td>
                                <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $p->name }}</div>
                                <small class="text-muted">{{ $p->slug }}</small>
                            </td>
                            <td>
                                <span class="badge badge-light border">{{ $p->category->name }}</span>
                            </td>
                            <td class="font-weight-bold text-success">{{ $p->formatted_price }}</td>
                            <td class="text-center">
                                @if($p->stock <= 0)
                                    <span class="badge badge-danger">Habis (0)</span>
                                @elseif($p->stock < 5)
                                    <span class="badge badge-warning text-dark">{{ $p->stock }} pcs</span>
                                @else
                                    <span class="badge badge-success">{{ $p->stock }} pcs</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($p->is_active)
                                    <span class="badge badge-primary">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini (soft delete)?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data produk yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        {{ $products->links() }}
    </div>
</div>
@endsection
