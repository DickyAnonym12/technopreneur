@extends('master1')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="cart-header">
                    <h2><i class="fa fa-shopping-cart"></i> Shopping Cart</h2>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="mb-3">Tambah Produk</h5>
                        <div class="row g-2 align-items-end">
                            <div class="col-md-7">
                                <label for="product-select" class="form-label">Pilih Produk</label>
                                <select id="product-select" class="form-control">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->Id_minuman }}">
                                            {{ $product->nama_minuman }} - Rp
                                            {{ number_format($product->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button id="add-product-button" class="btn btn-primary w-100">Tambah Produk</button>
                            </div>
                            <div class="col-md-2">
                                <button id="go-menu-button" class="btn btn-secondary w-100">Lihat Menu</button>
                            </div>
                        </div>
                        @if ($products->isEmpty())
                            <p class="text-muted mt-3 mb-0">Tidak ada produk tersedia untuk ditambahkan.</p>
                        @endif
                    </div>
                </div>

                @if (session('cart') && count(session('cart')) > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="40%">Product</th>
                                    <th width="15%">Price</th>
                                    <th width="15%">Quantity</th>
                                    <th width="20%">Subtotal</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0 @endphp
                                @foreach (session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <tr data-id="{{ $details['id'] }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('gambar/' . $details['gambar']) }}"
                                                    class="product-img mr-3" alt="{{ $details['nama_minuman'] }}">
                                                <h5 class="product-name">{{ $details['nama_minuman'] }}</h5>
                                            </div>
                                        </td>
                                        <td class="price" data-price="{{ $details['price'] }}">
                                            Rp {{ number_format($details['price'], 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <input type="number" value="{{ $details['quantity'] }}"
                                                class="form-control quantity-input update-cart" min="1">
                                        </td>
                                        <td class="subtotal">
                                            Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm btn-remove remove-from-cart">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mb-4">
                        <h5>Total: <strong class="total-price">Rp {{ number_format($total, 0, ',', '.') }}</strong></h5>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">Upload Bukti Pembayaran</h5>
                            <form method="POST" action="{{ route('cart.upload.proof') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-5">
                                        <label for="name" class="form-label">Nama</label>
                                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="payment_proof" class="form-label">Bukti Pembayaran</label>
                                        <input id="payment_proof" type="file" name="payment_proof" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fa fa-upload"></i> Upload Bukti
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <button class="btn btn-info whatsapp-button mt-3" onclick="openWhatsApp()">
                        <i class="fa fa-whatsapp"></i> Bayar via WhatsApp
                    </button>
                @else
                    <div class="empty-cart">
                        <h4>Keranjang Anda kosong.</h4>
                        <p>Tambahkan produk melalui pilihan di atas atau kembali ke menu untuk memilih minuman.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .cart-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .product-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .product-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 0;
        }

        .quantity-input {
            max-width: 80px;
            text-align: center;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .price {
            font-weight: 600;
            color: #28a745;
        }

        .subtotal {
            font-weight: 700;
            color: #28a745;
        }

        .cart-actions {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .empty-cart {
            text-align: center;
            padding: 40px 0;
            color: #666;
        }

        .alert {
            border-radius: 8px;
        }

        /* Mobile: keep select dropdown stable (avoid clipping/stacking issues) */
        #product-select {
            position: relative;
            z-index: 2;
        }
    </style>

    @push('page-scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript">
            function formatRupiah(angka) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
            }

            function updateSubtotal(row) {
                const quantity = parseInt(row.find('.quantity-input').val());
                const price = parseInt(row.find('.price').data('price'));
                const subtotal = quantity * price;
                row.find('.subtotal').text(formatRupiah(subtotal));

                let total = 0;
                $('.subtotal').each(function() {
                    const subtotalText = $(this).text().replace('Rp ', '').replace(/\./g, '');
                    total += parseInt(subtotalText);
                });
                $('.total-price').text(formatRupiah(total));
            }

            $(document).on('change', '.update-cart', function(e) {
                e.preventDefault();
                var ele = $(this);
                var row = ele.closest('tr');

                updateSubtotal(row);

                $.ajax({
                    url: '{{ route('update.cart') }}',
                    method: 'patch',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: row.attr('data-id'),
                        quantity: ele.val()
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.alert-success').remove();
                            $('.cart-header').after(
                                '<div class="alert alert-success alert-dismissible fade show">Cart updated successfully<button type="button" class="close" data-dismiss="alert">&times;</button></div>'
                            );
                        }
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr.responseText);
                    }
                });
            });

            $(document).on('click', '.remove-from-cart', function(e) {
                e.preventDefault();
                var ele = $(this);
                if (confirm('Are you sure want to remove?')) {
                    $.ajax({
                        url: '{{ route('remove.from.cart') }}',
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: ele.parents('tr').attr('data-id')
                        },
                        success: function(response) {
                            window.location.reload();
                        }
                    });
                }
            });

            $('#add-product-button').on('click', function(e) {
                e.preventDefault();
                var productId = $('#product-select').val();
                if (productId) {
                    window.location.href = '{{ url('add-to-cart') }}/' + productId;
                }
            });

            $('#go-menu-button').on('click', function(e) {
                e.preventDefault();
                window.location.href = '{{ route('home') }}#menu';
            });

            function openWhatsApp() {
                const total = $('.total-price').text().replace(/[^0-9]/g, '');
                let message = `Halo, saya ingin melakukan pembayaran untuk pesanan saya dengan total: Rp ${total}.

Rincian Pembelian:
`;

                $('tbody tr').each(function() {
                    const productName = $(this).find('.product-name').text();
                    const quantity = $(this).find('.quantity-input').val();
                    const price = $(this).find('.price').data('price');
                    const subtotal = price * quantity;
                    message += `${productName} - Jumlah: ${quantity}, Harga: Rp ${price}, Subtotal: Rp ${subtotal}
`;
                });

                message += `
Total Harga: Rp ${total}`;
                const phoneNumber = '6288270899874';
                const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
                window.open(url, '_blank');
            }
        </script>
    @endpush
@endsection
