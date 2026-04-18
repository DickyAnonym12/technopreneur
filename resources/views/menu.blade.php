@extends('master1')

@section('title', 'Menu')

@section('content')
    <section class="section" id="menu">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h6>Our Menu</h6>
                        <h2>Explore Our Selection of Drinks</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6">
                        <div class="product-card">
                            <img src="{{ asset('gambar/' . $product->gambar) }}" alt="{{ $product->nama_minuman }}"
                                class="product-image">
                            <div class="product-info">
                                <h1 class="product-title">{{ $product->nama_minuman }}</h1>
                                <p class="product-description">{{ $product->deskripsi }}</p>
                                <h3 class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
                                <a href="{{ route('add.to.cart', ['id' => $product->Id_minuman]) }}"
                                    class="buy-button text-center">
                                    Beli Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
