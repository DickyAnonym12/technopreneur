@extends('admin.master')

@section('title', 'Edit Slideshow')

@section('content')
<div class="container mt-4">
    <h2>Edit Slideshow</h2>
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('slideshow.update', $slideshow->Id_slideshow) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="gambar_slideshow">Gambar Slideshow</label>
                    @if ($slideshow->gambar_slideshow)
                        <div class="mb-2">
                            <img src="{{ asset('gambar/' . $slideshow->gambar_slideshow) }}" alt="Slideshow saat ini"
                                class="img-fluid rounded border" style="max-height: 220px;">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="gambar_slideshow" name="gambar_slideshow"
                        accept="image/jpeg,image/png,image/jpg,image/gif">
                    <div class="form-text">Kosongkan jika tidak ingin mengganti gambar.</div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection