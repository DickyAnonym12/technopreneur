@extends('admin.master')

@section('title', 'Edit Minuman')

@section('content')
<div class="container mt-4">
    <h2>Edit Minuman</h2>
    <form action="{{ route('minuman.update', $product->Id_minuman) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="nama_minuman">Nama Minuman</label>
                    <input type="text" class="form-control" id="nama_minuman" name="nama_minuman" value="{{ $product->nama_minuman }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" id="harga" name="price" value="{{ $product->price }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stock" value="{{ $product->stock }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" required>{{ $product->deskripsi }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="gambar">Gambar</label>
                    <input type="file" class="form-control" id="gambar" name="gambar">
                    @if($product->gambar)
                    <img src="{{ asset('gambar/' . $product->gambar) }}" width="100px" alt="Gambar Product" class="mt-2">
                    @endif
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection