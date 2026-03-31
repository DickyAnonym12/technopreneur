<?php

namespace App\Http\Controllers;

use App\Models\Slideshow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideshowController extends Controller
{
    // Method untuk menampilkan data produk
    public function index(Request $request)
    {
        $Slideshow = Slideshow::paginate(10)->withQueryString();

        return view('admin.slideshow.index', compact('Slideshow')); // Kirim variabel ke view
    }

    public function create()
    {
        return view('admin.slideshow.create');
    }
    // Method untuk menyimpan produk baru
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'gambar_slideshow' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Membuat objek produk baru
        $Slideshow = new Slideshow();
        $Slideshow->gambar_slideshow = $request->gambar_slideshow;

        // Menyimpan gambar jika ada
        if ($request->hasFile('gambar_slideshow')) {
            $imageName = time() . '.' . $request->gambar_slideshow->extension();
            $request->gambar_slideshow->move(public_path('gambar'), $imageName);
            $Slideshow->gambar_slideshow = $imageName;
        }

        // Menyimpan produk ke database
        $Slideshow->save();

        // Notifikasi sukses
        session()->flash('success', 'Slideshow berhasil ditambahkan!');

        // Redirect ke halaman home
        return redirect()->route('slideshow.list');
    }
    public function edit($id)
    {
        $slideshow = Slideshow::findOrFail($id);
        return view('admin.slideshow.edit', compact('slideshow'));
    }


    public function update(Request $request, $id)
    {
        $slideshow = Slideshow::findOrFail($id);

        // Validasi data input
        $request->validate([
            'gambar_slideshow' => 'required|image|mimes:jpeg,png,jpg,gif', // Validasi gambar
        ]);

        // Data yang akan diupdate
        $data = $request->only(['gambar_slideshow']);

        // Handle image upload jika ada file baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($slideshow->gambar_slideshow) {
                Storage::delete('public/gambar/' . $slideshow->gambar_slideshow);
            }

            // Simpan gambar baru dan ambil namanya
            $imageName = time() . '.' . $request->gambar_slideshow->extension(); // Menggunakan nama unik
            $request->gambar_slideshow->move(public_path('gambar'), $imageName); // Pindahkan gambar ke direktori
            $data['gambar_slideshow'] = $imageName; // Mengambil nama file baru
        }


        // Perbarui data produk di database
        $slideshow->update($data);
        
        // Redirect dengan pesan sukses
        return redirect()->route('slideshow.list')->with('success', 'Data berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $slideshow = Slideshow::findOrFail($id);
        if ($slideshow->gambar_slideshow) {
            Storage::delete('public/gambar/' . $slideshow->gambar_slideshow);
        }
        $slideshow->delete();
        return redirect()->route('slideshow.list')->with('success', 'Slideshow deleted successfully');
    }
    public function showMenu()
    {
        $slideshow = Slideshow::all(); // Fetch all products
        return view('menu', compact('slideshow'));
    }
}
