<?php

namespace App\Http\Controllers;

use App\Models\TambahMinuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TambahProdukController extends Controller
{
    // Method untuk menampilkan data produk
    public function index(Request $request)
    {
        $searchableColumns = ['nama_minuman'];
        $Products = TambahMinuman::filter($request, $searchableColumns)->paginate(5)->withQueryString();

        return view('admin.minuman.index', compact('Products')); // Kirim variabel ke view
    }

    public function create()
    {
        return view('admin.minuman.create');
    }
    // Method untuk menyimpan produk baru
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama_minuman' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'price' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Membuat objek produk baru
        $Product = new TambahMinuman();
        $Product->nama_minuman = $request->nama_minuman;
        $Product->deskripsi = $request->deskripsi;
        $Product->price = $request->price;

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

        // Validasi data input
        $request->validate([
            'nama_minuman' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'stock' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Validasi gambar
        ]);

        // Data yang akan diupdate
        $data = $request->only(['nama_minuman', 'price', 'deskripsi', 'stock']);

        // Handle image upload jika ada file baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($product->gambar) {
                Storage::delete('public/gambar/' . $product->gambar);
            }

            // Simpan gambar baru dan ambil namanya
            $imageName = time() . '.' . $request->gambar->extension(); // Menggunakan nama unik
            $request->gambar->move(public_path('gambar'), $imageName); // Pindahkan gambar ke direktori
            $data['gambar'] = $imageName; // Mengambil nama file baru
        }


        // Perbarui data produk di database
        $product->update($data);

        // Redirect dengan pesan sukses
        return redirect()->route('minuman.list')->with('success', 'Data berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $product = TambahMinuman::findOrFail($id);
        if ($product->gambar) {
            Storage::delete('public/gambar/' . $product->gambar);
        }
        $product->delete();
        return redirect()->route('minuman.list')->with('success', 'Product deleted successfully');
    }
    public function showMenu()
    {
        $products = TambahMinuman::all(); // Fetch all products
        return view('menu', compact('products'));
    }
}
