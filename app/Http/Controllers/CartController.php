<?php

namespace App\Http\Controllers;

use App\Models\TambahMinuman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function cart()
    {
        $cart = session()->get('cart', []);
        $products = TambahMinuman::all();
        return view('cart', compact('cart', 'products'));
    }

    public function uploadProof(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong. Tambahkan produk terlebih dahulu.');
        }

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $amount = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $productNames = collect($cart)->pluck('nama_minuman')->filter()->values()->all();

        \App\Models\Payment::create([
            'order_id' => 'ORDER-' . Str::uuid()->toString(),
            'action_id' => (string) Str::uuid(),
            'amount' => $amount,
            'status' => 'pending',
            'user_id' => auth()->id(),
            'customer_name' => $request->input('name'),
            'product_name' => implode(', ', $productNames),
            'payment_proof' => $path,
            'verification_status' => 'pending',
        ]);

        session()->flash('success', 'Bukti pembayaran berhasil diunggah. Terima kasih!');
        session()->flash('payment_name', $request->input('name'));
        session()->flash('payment_proof_path', $path);

        return redirect()->route('cart');
    }

    public function addToCart($id)
    {
        $product = TambahMinuman::findOrFail($id);
        if (!$product->price || !$product->nama_minuman) {
            return redirect()->back()->withErrors('Data produk tidak valid.');
        }

        $cart = session()->get('cart', []);
        $cart[$product->Id_minuman] = [
            "id" => $product->Id_minuman,
            "nama_minuman" => $product->nama_minuman,
            "quantity" => isset($cart[$product->Id_minuman]) ? $cart[$product->Id_minuman]['quantity'] + 1 : 1,
            "price" => $product->price,
            "gambar" => $product->gambar
        ];
        session()->put('cart', $cart);

        return redirect()->route('cart')->with('success', 'Product berhasil ditambahkan ke keranjang');
    }

    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                $cart[$request->id]["quantity"] = $request->quantity;
                session()->put('cart', $cart);
            }

            return response()->json([
                'success' => true,
                'item' => $cart[$request->id]
            ]);
        }
    }

    public function removeFromCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json(['success' => true]);
        }
    }
}
