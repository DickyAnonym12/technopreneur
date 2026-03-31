@extends('admin.master')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <h2 class="h4">Edit Pelanggan</h2>
        <p class="mb-0">Form edit pelanggan</p>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('pelanggan.list') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                Kembali
            </a>
           
        </div>
    </div>

    <div class="card card-body border-0 shadow mb-4">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('pelanggan.update', $pelanggan->pelanggan_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="first_name" class="form-label">Nama Depan</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $pelanggan->first_name }}" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Nama Belakang</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $pelanggan->last_name }}" required>
            </div>

            <div class="mb-3">
                <label for="birthday" class="form-label">Ulang Tahun</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="{{ $pelanggan->birthday }}" required>
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="Male" {{ $pelanggan->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $pelanggan->gender == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $pelanggan->email }}" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Nomor Hp</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $pelanggan->phone }}" required>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('pelanggan.list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection