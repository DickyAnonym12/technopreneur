@extends('master1')

@section('title', 'Keranjang Belanja')

@section('content')
<!DOCTYPE html>
<html>

<head>
    <title>Cart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        .total-row {
            font-size: 1.2em;
            background-color: #f8f9fa;
        }

        .btn-remove {
            padding: 5px 10px;
            border-radius: 4px;
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
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="cart-header">
                    <h2><i class="fa fa-shopping-cart"></i> Shopping Cart</h2>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                @endif

                @if(session('cart') && count(session('cart')) > 0)
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
                            @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr data-id="{{ $details['id'] }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('gambar/' . $details['gambar']) }}"
                                            class="product-img mr-3">
                                        <h5 class="product-name">{{ $details['nama_minuman'] }}</h5>
                                    </div>
                                </td>
                                <td class="price" data-price="{{ $details['price'] }}">
                                    Rp {{ number_format($details['price'], 0, ',', '.') }}
                                </td>
                                <td>
                                    <input type="number"
                                        value="{{ $details['quantity'] }}"
                                        class="form-control quantity-input update-cart"
                                        min="1">
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

                <button class="btn btn-success pay-button mt-3"
                    data-total="{{ array_sum(array_map(function($item) {
                            return $item['price'] * $item['quantity'];
                        }, session('cart', [])) ) }}">
                    <i class="fa fa-credit-card"></i> Bayar
                </button>
                <button class="btn btn-info whatsapp-button mt-3"
                    onclick="openWhatsApp()">
                    <i class="fa fa-whatsapp"></i> Bayar via WhatsApp
                </button>
                @else
                <div class="empty-cart">
                    <h4>Your cart is empty.</h4>
                </div>
                @endif
            </div>
        </div>

        <script type="text/javascript">
            function formatRupiah(angka) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
            }

            function updateSubtotal(row) {
                const quantity = parseInt(row.find('.quantity-input').val());
                const price = parseInt(row.find('.price').data('price'));
                const subtotal = quantity * price;
                row.find('.subtotal').text(formatRupiah(subtotal));

                // Update total
                let total = 0;
                $('.subtotal').each(function() {
                    const subtotalText = $(this).text().replace('Rp ', '').replace(/\./g, '');
                    total += parseInt(subtotalText);
                });
                $('.total-price strong').text(formatRupiah(total));
            }

            $(".update-cart").change(function(e) {
                e.preventDefault();
                var ele = $(this);
                var row = ele.closest('tr');

                // Update subtotal immediately for better UX
                updateSubtotal(row);

                $.ajax({
                    url: '{{ route('update.cart') }}', // Ensure this matches the defined route
                    method: "patch",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: row.attr("data-id"),
                        quantity: ele.val()
                    },
                    success: function(response) {
                        console.log(response); // Log the response for debugging
                        if (response.success) {
                            // Optional: show success message without page reload
                            $('.alert-success').remove();
                            $('.cart-header').after(
                                '<div class="alert alert-success alert-dismissible fade show">' +
                                'Cart updated successfully' +
                                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                '</div>'
                            );
                        } else {
                            // Handle error if 'price' is not defined
                            console.error('Error: ', response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr.responseText);
                    }
                });
            });

            $(".remove-from-cart").click(function(e) {
                e.preventDefault();
                var ele = $(this);
                if (confirm("Are you sure want to remove?")) {
                    $.ajax({
                        url: '{{ route('remove.from.cart') }}', // Ensure this matches the defined route
                        method: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: ele.parents("tr").attr("data-id")
                        },
                        success: function(response) {
                            window.location.reload();
                        }
                    });
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                $('.pay-button').on('click', function(e) {
                    e.preventDefault();
                    var total = $(this).data('total');
                    console.log('Total amount:', total);

                    // Tampilkan loading
                    Swal.fire({
                        title: 'Memproses pembayaran...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ route('payment.pay') }}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            amount: total,
                            price: total,
                        },
                        success: function(response) {
                            console.log('Response from server:', response);
                            Swal.close();

                            // Pastikan Token ada
                            if (!response.token) {
                                Swal.fire("Gagal!", "Token pembayaran tidak valid.", "error");
                                return;
                            }

                            // Trigger Snap popup
                            snap.pay(response.token, {
                                onSuccess: function(result) {
                                    Swal.fire({
                                        title: "Berhasil!",
                                        text: "Pembayaran berhasil dilakukan.",
                                        icon: "success"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                },
                                onPending: function(result) {
                                    Swal.fire("Menunggu!", "Pembayaran sedang menunggu konfirmasi.", "info");
                                },
                                onError: function(result) {
                                    Swal.fire("Gagal!", "Terjadi kesalahan saat melakukan pembayaran.", "error");
                                },
                                onClose: function() {
                                    Swal.fire("Info!", "Pembayaran dibatalkan.", "info");
                                }
                            });
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseText);
                        }
                    });
                });
            });
        </script>
        <script type="text/javascript">
            function openWhatsApp() {
                const total = $('.pay-button').data('total');
                let message = `Halo, saya ingin melakukan pembayaran untuk pesanan saya dengan total: Rp ${total}.\n\nRincian Pembelian:\n`;

                // Loop through each item in the cart to create the purchase details
                $('tbody tr').each(function() {
                    const productName = $(this).find('.product-name').text();
                    const quantity = $(this).find('.quantity-input').val();
                    const price = $(this).find('.price').data('price');
                    const subtotal = price * quantity;
                    message += `${productName} - Jumlah: ${quantity}, Harga: Rp ${price}, Subtotal: Rp ${subtotal}\n`;
                });

                // Add total price to the message
                message += `\nTotal Harga: Rp ${total}`;

                const phoneNumber = '6288270899874'; // Ganti dengan nomor WhatsApp Anda
                const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
                window.open(url, '_blank');
            }
        </script>
</body>

</html>
@endsection
