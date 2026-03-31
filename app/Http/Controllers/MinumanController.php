<?php

namespace App\Http\Controllers;

use App\Models\TambahMinuman;
use Illuminate\Http\Request;

class MinumanController extends Controller
{
    // Method untuk menampilkan data produk
    public function index()
    {
        // Mengambil semua data dari tabel 'minuman'
        $Products = TambahMinuman::all();

        // Mengirim variabel $Products ke view 'home'
        return view('home', compact('Products')); // Kirim variabel ke view
    }
    public function show(Request $request)
    {
        // Mengambil semua data dari tabel 'minuman'
        $searchableColumns = ['nama_minuman'];
        $Products = TambahMinuman::filter($request, $searchableColumns)->paginate(10)->withQueryString();

        // Mengirim variabel $Products ke view 'home'
        return view('admin.minuman.index', compact('Products')); // Kirim variabel ke view
    }
    public function create()
    {
        return view('admin1.tambahProduk');
    }
    // Method untuk menyimpan produk baru
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama_minuman' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Membuat objek produk baru
        $Product = new TambahMinuman();
        $Product->nama_minuman = $request->nama_minuman;
        $Product->deskripsi = $request->deskripsi;
        $Product->harga = $request->harga;

        // Menyimpan gambar jika ada
        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('gambar'), $imageName);
            $Product->gambar = $imageName;
        }

        // Menyimpan produk ke database
        $Product->save();

        // Notifikasi sukses
        session()->flash('success', 'Produk berhasil ditambahkan!');

        // Redirect ke halaman home
        return redirect()->route('minuman.list');
    }
    public function edit($id)
    {
        $product = TambahMinuman::findOrFail($id);
        return view('admin.minuman.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = TambahMinuman::findOrFail($id);
        $product->update($request->all());
        return redirect()->route('minuman.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = TambahMinuman::findOrFail($id);
        $product->delete();
        return redirect()->route('minuman.index')->with('success', 'Product deleted successfully');
    }
}
