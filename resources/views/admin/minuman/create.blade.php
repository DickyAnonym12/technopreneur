@extends('admin.master')

@section('title', 'Tambah Produk')

@section('content')

@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="container mt-5">
    <h2>Tambah Minuman</h2>
    <form action="{{ route('home.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_minuman" class="form-label">Nama Minuman</label>
                <input type="text" class="form-control" id="nama_minuman" name="nama_minuman" placeholder="Masukkan nama minuman" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="gambar_minuman" class="form-label">Gambar Minuman</label>
                <input type="file" class="form-control" id="gambar_minuman" name="gambar" placeholder="Masukkan gambar minuman" required>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi minuman" rows="3" required></textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="price" placeholder="Masukkan harga minuman" required>
            </div>
        </div>

        <div class="text-left">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection