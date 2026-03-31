@extends('admin.master')

@section('title', 'Mitra')

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
				<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
				<li class="breadcrumb-item active" aria-current="page">Mitra</li>
			</ol>
		</nav>
		<h2 class="h4">Tabel Mitra</h2>
		<p class="mb-0">List Mitra</p>
	</div>
	<div class="btn-toolbar mb-2 mb-md-0">
		<a href="{{route('mitra.create')}}" class="btn btn-sm btn-success d-inline-flex align-items-center">
			<svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
			</svg>
			Tambah Data
		</a>
		
	</div>
</div>
@if(session('success'))
<div class="alert alert-success">
	{{ session('success') }}
</div>
@endif

<div class="mb-3">
	<form method="GET" action="{{ route('mitra.list') }}">
		<div class="row">
			<div class="col-md-2">
				<select name="jenis_kemitraan" onchange="this.form.submit()" class="form-select">
					<option value="">Jenis Kemitraan</option>
					<option value="Platinum" {{ request('jenis_kemitraan') == 'Platinum' ? 'selected' : '' }}>Platinum</option>
					<option value="Silver" {{ request('jenis_kemitraan') == 'Silver' ? 'selected' : '' }}>Silver</option>
					<option value="Gold" {{ request('jenis_kemitraan') == 'Gold' ? 'selected' : '' }}>Gold</option>

				</select>
			</div>
		</div>
	</form>
</div>

<div class="table-responsive">
	<table class="table table-striped table-hover">
		<thead class="table-dark">
			<tr>
				<th>Nama Mitra</th>
				<th>Alamat</th>
				<th>Email</th>
				<th>Nomor Telepon</th>
				<th>Jenis Kemitraan</th>
				<th>Tanggal Bergabung</th>
				<th>Aksi</th> <!-- Kolom untuk aksi -->
			</tr>
		</thead>
		<tbody>
			@foreach($data_mitra as $m)
			<tr>
				<td>{{ $m->nama_mitra }}</td>
				<td>{{ $m->alamat }}</td>
				<td>{{ $m->email }}</td>
				<td>{{ $m->nomor_telepon }}</td>
				<td>
					<span class="badge
								{{
									$m->jenis_kemitraan == 'Platinum' ? 'bg-info' :
									($m->jenis_kemitraan == 'Gold' ? 'bg-warning' :
									($m->jenis_kemitraan == 'Silver' ? 'bg-secondary' : ''))
								}}">
						{{ $m->jenis_kemitraan }}
					</span>
				</td>
				<td>{{ $m->tanggal_bergabung ? date('d-m-Y', strtotime($m->tanggal_bergabung)) : '' }}</td>
				<td>
					<div class="btn-group">
						<!-- Ikon Edit -->
						<a href="{{ route('mitra.edit', $m->mitra_id) }}" class="btn btn-warning btn-sm">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
								<path d="M12.146 0.146a1 1 0 0 1 1.415 0l2 2a1 1 0 0 1 0 1.415l-1.5 1.5-3.415-3.415 1.5-1.5a1 1 0 0 1 1.415 0zM11.5 2.5l-1.5 1.5-3.415-3.415 1.5-1.5a1 1 0 0 1 1.415 0l2 2a1 1 0 0 1 0 1.415zM0 13.5V16h2.5l8.5-8.5-2.5-2.5L0 13.5z" />
							</svg>
						</a>

						<!-- Ikon Delete -->
						<a href="{{ route('mitra.destroy', $m->mitra_id) }}" class="btn btn-danger btn-sm">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
								<path d="M5.5 0a.5.5 0 0 1 .5.5V1h5V.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v1a.5.5 0 0 1-.5.5H1A.5.5 0 0 1 .5 2V1a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 .5-.5zM1 4h14v11a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 1v10h10V5H3z" />
							</svg>
						</a>
					</div>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection