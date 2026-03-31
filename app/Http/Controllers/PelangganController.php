<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchableColumns=['first_name'];

        $pageData['data_pelanggan'] = Pelanggan::filter($request,$searchableColumns)->paginate(10);
        return view('admin.pelanggan.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageData['data_pelanggan'] = Pelanggan::all();
        return view('admin.pelanggan.create', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birthday' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'email' => 'required|email|unique:pelanggan,email',
        ]);

        Pelanggan::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'birthday' => $request->input('birthday'),
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);
        // dd($request->all());
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pelanggan.list')->with('success', 'Data pelanggan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $pelanggan = Pelanggan::findOrFail($id);
    return view('admin.pelanggan.edit', compact('pelanggan'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'birthday' => 'required|date',
        'gender' => 'required|string|max:10',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:15',
    ]);

    $pelanggan = Pelanggan::findOrFail($id);
    $pelanggan->update($request->all());

        return redirect()->route('pelanggan.list')->with('success', 'Data pelanggan berhasil diperbarui');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) : RedirectResponse
    {
        $pelanggan = Pelanggan::findOrFail($id);
        if ($pelanggan) {
            $pelanggan->delete();
            return redirect()->route('pelanggan.list')->with('success', 'Data pelanggan berhasil dihapus');
        } else {
            return redirect()->route('pelanggan.list')->with('error', 'Data pelanggan tidak ditemukan');
        }
    }
}
