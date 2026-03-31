@extends('admin.master')

@section('title', 'Tambah Slideshow')

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
    <h2>Tambah Slideshow</h2>
    <form action="{{ route('slideshow.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">                                                                           
            <div class="col-md-6 mb-3">
                <label for="gambar_slideshow" class="form-label">Gambar Slideshow</label>
                <input type="file" class="form-control" id="gambar_slideshow" name="gambar_slideshow" placeholder="Masukkan gambar slideshow" required>
            </div>
        </div>
        <div class="text-left">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection