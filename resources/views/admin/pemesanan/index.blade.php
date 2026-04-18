@extends('admin.master')

@section('title', 'Pemesanan')

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Daftar Pemesanan</h3>
                    <span class="badge bg-primary">{{ $payments->count() }} Pesanan</span>
                </div>
                <div class="card-body">
                    @if ($payments->isEmpty())
                        <p class="text-muted">Tidak ada pemesanan dengan bukti pembayaran saat ini.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Produk</th>
                                        <th>Bukti Pembayaran</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->customer_name ?? ($payment->user->name ?? 'Guest') }}</td>
                                            <td>{{ $payment->product_name ?? '-' }}</td>
                                            <td>
                                                @if ($payment->payment_proof)
                                                    <a href="{{ asset('storage/' . $payment->payment_proof) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary">
                                                        Lihat Bukti
                                                    </a>
                                                @else
                                                    <span class="text-muted">Belum ada bukti</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $status = $payment->verification_status ?? 'pending';
                                                    $badge = 'secondary';
                                                    if ($status === 'accepted') {
                                                        $badge = 'success';
                                                    }
                                                    if ($status === 'rejected') {
                                                        $badge = 'danger';
                                                    }
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $badge }} text-capitalize">{{ $status }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="button"
                                                        class="btn btn-success btn-sm order-action-button"
                                                        data-bs-toggle="modal" data-bs-target="#orderConfirmModal"
                                                        data-action="accept"
                                                        data-url="{{ route('pemesanan.accept', ['action_id' => $payment->action_id]) }}"
                                                        data-customer="{{ e($payment->customer_name ?? ($payment->user->name ?? 'Guest')) }}"
                                                        data-product="{{ e($payment->product_name ?? '-') }}"
                                                        {{ $payment->verification_status === 'accepted' ? 'disabled' : '' }}>
                                                        Terima
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm order-action-button"
                                                        data-bs-toggle="modal" data-bs-target="#orderConfirmModal"
                                                        data-action="reject"
                                                        data-url="{{ route('pemesanan.reject', ['action_id' => $payment->action_id]) }}"
                                                        data-customer="{{ e($payment->customer_name ?? ($payment->user->name ?? 'Guest')) }}"
                                                        data-product="{{ e($payment->product_name ?? '-') }}"
                                                        {{ $payment->verification_status === 'rejected' ? 'disabled' : '' }}>
                                                        Tolak
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="orderConfirmModal" tabindex="-1" aria-labelledby="orderConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderConfirmModalLabel">Konfirmasi Pemesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="orderConfirmMessage">Apakah Anda yakin ingin memproses pesanan ini?</p>
                    <p class="mb-0"><strong>Nama:</strong> <span id="orderConfirmCustomer"></span></p>
                    <p class="mb-0"><strong>Produk:</strong> <span id="orderConfirmProduct"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="orderConfirmForm" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" id="orderConfirmSubmit" class="btn btn-success">Ya, Lanjutkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('orderConfirmModal');
            const message = document.getElementById('orderConfirmMessage');
            const customer = document.getElementById('orderConfirmCustomer');
            const product = document.getElementById('orderConfirmProduct');
            const form = document.getElementById('orderConfirmForm');
            const submitButton = document.getElementById('orderConfirmSubmit');
            document.querySelectorAll('.order-action-button').forEach(button => {
                button.addEventListener('click', function() {
                    const action = this.dataset.action;
                    const url = this.dataset.url;
                    const customerName = this.dataset.customer;
                    const productName = this.dataset.product;

                    form.action = url;
                    customer.textContent = customerName;
                    product.textContent = productName;

                    if (action === 'accept') {
                        message.textContent = 'Apakah Anda yakin ingin menerima pesanan ini?';
                        submitButton.textContent = 'Terima';
                        submitButton.className = 'btn btn-success';
                    } else {
                        message.textContent = 'Apakah Anda yakin ingin menolak pesanan ini?';
                        submitButton.textContent = 'Tolak';
                        submitButton.className = 'btn btn-danger';
                    }
                });
            });
        });
    </script>
@endsection
