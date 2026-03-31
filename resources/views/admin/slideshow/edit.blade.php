@extends('admin.master')

@section('title', 'Edit Slideshow')

@section('content')
<div class="container mt-4">
    <h2>Edit Slideshow</h2>
    <form action="{{ route('slideshow.update', $slideshow->Id_slideshow) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="gambar_slideshow">Gambar Slideshow</label>
                    <input type="file" class="form-control" id="gambar_slideshow" name="gambar" value="{{ $slideshow->gambar }}" required>
                </div>
            </div>
            <div class="col-md-6">

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