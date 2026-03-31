@extends('admin.master')

@section('title', 'Edit Mitra')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Volt</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Mitra</li>
                </ol>
            </nav>
            <h2 class="h4">Edit Mitra</h2>
            <p class="mb-0">Form pengeditan mitra </p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('mitra.list') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                Kembali
            </a>
        </div>
    </div>

    <div class="card card-body border-0 shadow mb-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mitra.update') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div>
                        <label for="nama_mitra">Nama Mitra</label>
                        <input class="form-control" id="nama_mitra" type="text" name="nama_mitra"
                            placeholder="Masukkan nama mitra" maxlength="200" value="{{ $data_mitra->nama_mitra }}"required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div>
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" placeholder="Masukkan alamat"  value="{{ $data_mitra->alamat }}"></textarea>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="email"  value="{{ $data_mitra->email }}" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="nomor_telepon">Nomor Telepon</label>
                        <input class="form-control" id="nomor_telepon" name="nomor_telepon" type="number"  value="{{ $data_mitra->nomor_telepon }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jenis_kemitraan">Jenis Kemitraan</label>
                    <select class="form-select mb-0" id="jenis_kemitraan" name="jenis_kemitraan"
                        aria-label="Jenis Kemitraan select" required>
                        <option selected disabled>Jenis Kemitraan</option>
                        <option value="Platinum" {{ $data_mitra->jenis_kemitraan == 'Platinum' ? 'selected' : '' }}>Platinum</option>
                        <option value="Gold" {{ $data_mitra->jenis_kemitraan == 'Gold' ? 'selected' : '' }}>Gold</option>
                        <option value="Silver" {{ $data_mitra->jenis_kemitraan == 'Silver' ? 'selected' : '' }}>Silver</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Badge Jenis Kemitraan</label>
                    <span class="badge {{ $data_mitra->jenis_kemitraan == 'Platinum' ? 'bg-info' : ($data_mitra->jenis_kemitraan == 'Gold' ? 'bg-warning' : 'bg-secondary') }}">
                        {{ $data_mitra->jenis_kemitraan }}
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_bergabung">Tanggal Bergabung</label>
                    <input data-datepicker="" name="tanggal_bergabung" class="form-control" id="tanggal_bergabung"
                        type="date" value="{{ $data_mitra->tanggal_bergabung }}" required>
                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-success" type="submit">Simpan Mitra</button>
            </div>
           
        </form>
    </div>
@endsection
