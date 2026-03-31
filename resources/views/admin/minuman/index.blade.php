@extends('admin.master')

@section('title', 'Minuman')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Minuman</li>
            </ol>
        </nav>
        <h2 class="h4">Tabel Minuman</h2>
        <p class="mb-0">List Minuman</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{route('home.create')}}" class="btn btn-sm btn-success d-inline-flex align-items-center">
            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Data Minuman
        </a>

    </div>
</div>
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<form method="GET" action="{{ route('minuman.list') }}">
    <div class="col-md-4">
        <div class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" id="exampleInputIconRight" placeholder="Search" aria-label="Search">
                <button type="submit" class="btn btn-outline-secondary" id="button-addon2">
                    <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px;">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</form>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Minuman</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Aksi</th> <!-- Kolom untuk aksi -->
            </tr>
        </thead>
        <tbody>
            @php
            $no = 0;
            @endphp
            @foreach ($Products as $product)
            <tr>
                <td>{{++$no}}</td>
                <td>{{ $product->nama_minuman }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->deskripsi }}</td>
                <td>
                    @if($product->gambar)
                    <img src="{{ asset('gambar/' . $product->gambar) }}" width="100px" alt="Gambar Product">
                    @else
                    Tidak Ada Foto
                    @endif
                </td>
                <td class="td-actions text-right">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ route('minuman.edit', $product->Id_minuman) }}" class="btn btn-sm btn-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146 0.146a1 1 0 0 1 1.415 0l2 2a1 1 0 0 1 0 1.415l-1.5 1.5-3.415-3.415 1.5-1.5a1 1 0 0 1 1.415 0zM11.5 2.5l-1.5 1.5-3.415-3.415 1.5-1.5a1 1 0 0 1 1.415 0l2 2a1 1 0 0 1 0 1.415zM0 13.5V16h2.5l8.5-8.5-2.5-2.5L0 13.5z" />
                            </svg>
                        </a>
                        <form action="{{ route('minuman.destroy', $product->Id_minuman) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('POST') <!-- Use POST method for deleting -->
                            <button type="button" class="btn btn-sm btn-danger delete-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 0a.5.5 0 0 1 .5.5V1h5V.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v1a.5.5 0 0 1-.5.5H1A.5.5 0 0 1 .5 2V1a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 .5-.5zM1 4h14v11a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 1v10h10V5H3z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3">
        {{ $Products->links('pagination::bootstrap-5') }}
    </div>
</div>
<!-- Include SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Apakah anda yakin untuk menghapus produk ini?',
                text: "Anda tidak akan bisa mengembalikannya",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Iya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection