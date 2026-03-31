<?php

namespace App\Http\Controllers;

use App\Models\TambahMinuman;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
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
