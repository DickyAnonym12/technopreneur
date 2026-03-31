<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\TambahMinuman;
use App\Models\User;
use Midtrans\Config;
use Midtrans\Snap;
use Exception;



class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function process(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'amount' => 'required|numeric|min:1'
            ]);

            // Konversi amount ke integer
            $amount = (int) $request->amount;

            $orderId = 'ORDER-' . time();

            // Ambil informasi pengguna
            $user = auth()->user();
            if (!$user) {
                throw new \Exception('User not authenticated.');
            }

            // Simpan informasi pembayaran
            $payment = Payment::create([
                'order_id' => $orderId,
                'amount' => $amount,
                'status' => 'pending',
                'user_id' => $user->id
            ]);

            $transactionDetails = [
                'order_id' => $orderId,
                'gross_amount' => $amount
            ];

            $payload = [
                'transaction_details' => $transactionDetails,
                'customer_details' => [
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ];

            // Get Snap Token
            $snapToken = Snap::getSnapToken($payload);

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken
            ]);
        } catch (\Exception $e) {
            \Log::error('Payment Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function callback(Request $request)
    {
        try {
            $serverKey = config('midtrans.server_key');
            $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

            if ($hashed == $request->signature_key) {
                $payment = Payment::where('order_id', $request->order_id)->first();

                if ($payment) {
                    if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                        $payment->update(['status' => 'paid']);
                    } elseif ($request->transaction_status == 'cancel' || $request->transaction_status == 'deny' || $request->transaction_status == 'expire') {
                        $payment->update(['status' => 'failed']);
                    } elseif ($request->transaction_status == 'pending') {
                        $payment->update(['status' => 'pending']);
                    }
                }
            }

            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function validateCart($cart)
    {
        foreach ($cart as $productId => $item) {
            if (!isset($item['id'])) {
                \Log::error('ID produk tidak ditemukan:', $item);
                throw new \Exception('Data produk tidak valid. ID produk tidak ditemukan.');
            }
            if (!isset($item['price']) || !isset($item['quantity']) || !isset($item['nama_minuman'])) {
                \Log::error('Invalid product data:', $item);
                throw new \Exception('Data produk tidak valid.');
            }
            if (!$item['price'] || !$item['nama_minuman'] || $item['quantity'] <= 0) {
                \Log::error('Invalid product values:', $item);
                throw new \Exception('Data produk tidak valid.');
            }
        }
    }

    private function getAuthenticatedUser()
    {
        $user = auth()->user();
        if (!$user) {
            throw new \Exception('Silakan login terlebih dahulu.');
        }
        return $user;
    }

    public function pay(Request $request)
    {
        try {
            $cart = session()->get('cart', []);

            if (empty($cart)) {
                throw new \Exception('Keranjang Anda kosong.');
            }

            $amount = 0;
            $itemDetails = [];
            $user = $this->getAuthenticatedUser();
            $orderId = 'ORDER-' . time();

            foreach ($cart as $productId => $item) {
                // Ensure 'id' is set correctly
                if (!isset($item['id'])) {
                    throw new \Exception('Data produk tidak valid. ID produk tidak ditemukan.');
                }

                $itemAmount = $item['quantity'] * $item['price'];
                $amount += $itemAmount;

                $itemDetails[] = [
                    'Id_minuman' => $item['id'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'nama_minuman' => $item['nama_minuman'],
                ];
            }

            if ($amount <= 0) {
                throw new \Exception('Total pembayaran tidak valid.');
            }

            $payment = Payment::create([
                'order_id' => $orderId,
                'amount' => $amount,
                'status' => 'pending',
                'user_id' => $user->id
            ]);

            $payload = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $amount,
                ],
                'customer_details' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'item_details' => $itemDetails,
            ];

            $snapToken = Snap::getSnapToken($payload);

            session()->forget('cart');

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSnapToken(Request $request)
    {
        // Set konfigurasi midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $orderId = 'ORDER-' . time();

        // Siapkan item details
        $items = [];
        foreach ($request->items as $item) {
            $items[] = [
                'Id_minuman' => $item['Id_minuman'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'nama_minuman' => $item['nama_minuman']
            ];
        }

        $params = array(
            'transaction_details' => array(
                'order_id' => $orderId,
                'gross_amount' => $request->total,
            ),
            'item_details' => $items,
            'customer_details' => array(
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                // Tambahkan detail customer lainnya jika ada
            ),
            'enabled_payments' => [
                'credit_card',
                'bca_va',
                'bni_va',
                'bri_va',
                'mandiri_clickpay',
                'gopay',
                'shopeepay'
            ],
        );

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan data pembayaran
            Payment::create([
                'id' => auth()->id(),
                'order_id' => $orderId,
                'amount' => $request->total,
                'status' => 'pending'
            ]);

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updatePaymentStatus(Request $request)
    {
        $payment = Payment::where('order_id', $request->order_id)->first();

        if ($payment) {
            $payment->update([
                'status' => $request->transaction_status,
                'payment_type' => $request->payment_type,
                'payment_code' => $request->payment_code ?? null,
                'pdf_url' => $request->pdf_url ?? null
            ]);
        }

        return response()->json(['success' => true]);
    }
}
