@extends('admin.master')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    {{-- Statistics Cards --}}
    <div class="col-12 col-md-8 mb-4">
        <div class="row">
            {{-- Total Mitra Card --}}
            <div class="col-12 col-sm-6 col-xl-4 mb-4">
                <div class="card border-0 shadow h-100 text-center">
                    <div class="card-body">
                        <div class="icon-shape icon-shape-primary rounded mb-3">
                            <i class="fas fa-handshake fa-2x"></i>
                        </div>
                        <h2 class="h5">Total Mitra</h2>
                        <h3 class="fw-extrabold mb-2">{{ $totalMitra ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            {{-- Total Minuman Card --}}
            <div class="col-12 col-sm-6 col-xl-4 mb-4">
                <div class="card border-0 shadow h-100 text-center">
                    <div class="card-body">
                        <div class="icon-shape icon-shape-secondary rounded mb-3">
                            <i class="fas fa-coffee fa-2x"></i>
                        </div>
                        <h2 class="h5">Total Minuman</h2>
                        <h3 class="fw-extrabold mb-2" id="produk-count">{{ $totalMinuman ?? 0 }}</h3>
                    </div>
                </div>
            </div>


        </div>
    </div>

    {{-- User Profile --}}
    <div class="col-12 col-md-4 mb-4" style="height: 100%;">
        <div class="card border-0 shadow h-100 text-center">
            <div class="card-body">
                <h2 class="fs-5 fw-bold mb-1">Admin Profile</h2>
                <img src="{{ Auth::user()->foto_profile_url }}" class="avatar rounded-circle mb-3" style="width: 100px; height: 100px;">
                <h4 class="h3">{{ Auth::user()->name }}</h4>
                <p class="text-muted">{{ Auth::user()->role }}</p>
                <a href="#" class="btn btn-sm btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Recent Customers --}}
    <div class="col-12 col-md-6 mb-4">
        <div class="card border-0 shadow" style="background-color: #FFFFFF; border-radius: 15px; height: 100%;">
            <div class="card-body">
                <h6 class="text-warning">Pelanggan Terbaru</h6>
                @if ($pelangganTerbaru->isEmpty())
                    <p class="text-muted">Belum ada pelanggan terbaru.</p>
                @else
                    <ul class="list-group">
                        @foreach ($pelangganTerbaru as $dataPelanggan)
                            <li class="list-group-item d-flex justify-content-between align-items-center" style="border: none; background-color: #f9f9f9;">
                                <div>
                                    <strong>{{ $dataPelanggan->first_name }}</strong>
                                    <p class="mb-0 text-muted" style="font-size: 0.9em;">{{ $dataPelanggan->email }}</p>
                                </div>
                                <span class="badge bg-primary" style="font-size: 0.8em;">
                                    {{ \Carbon\Carbon::parse($dataPelanggan->created_at)->format('d M Y') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    {{-- Recent Activities --}}
    <div class="col-12 col-md-6 mb-4">
        <div class="card border-0 shadow" style="height: 100%;">
            <div class="card-header">
                <h2 class="fs-5 fw-bold mb-0">Recent Activities</h2>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($recentActivities as $activity)
                        <li class="list-group-item">
                            <strong>{{ $activity->description }}</strong>
                            <p class="mb-0 text-muted" style="font-size: 0.9em;">{{ \Carbon\Carbon::parse($activity->created_at)->format('d M Y H:i') }}</p>
                        </li>
                    @endforeach
                    @if ($recentActivities->isEmpty())
                        <p class="text-muted">Belum ada aktivitas terbaru.</p>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
