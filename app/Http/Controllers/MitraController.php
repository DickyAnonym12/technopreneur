<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterableColumns = ['jenis_kemitraan'];
        $pageData['data_mitra'] = Mitra::filter($request, $filterableColumns)->paginate(10)->withQueryString();
        return view('admin.mitra.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageData['data_mitra'] = Mitra::all();
        return view('admin.mitra.create', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mitra' => ['required', 'max:200'],
            'alamat'  => ['nullable'],
            'email'   => ['required', 'email'],
            'nomor_telepon'     => ['required', 'numeric'],
            'jenis_kemitraan'   => ['required', 'in:Platinum,Gold,Silver'],
            'tanggal_bergabung' => ['required', 'date'],
            'validasi_data' => ['required'],
        ]);
        $data['nama_mitra'] = $request->nama_mitra;
        $data['alamat'] = $request->alamat;
        $data['email'] = $request->email;
        $data['nomor_telepon'] = $request->nomor_telepon;
        $data['jenis_kemitraan'] = $request->jenis_kemitraan;
        $data['tanggal_bergabung'] = $request->tanggal_bergabung;

        Mitra::create($data);

        return redirect()->route('mitra.list')->with('success', 'Penambahan Data Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $param1)
    {
        $pageData['data_mitra'] =   Mitra::findOrFail($param1);
        return view('admin.mitra.edit', $pageData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama_mitra' => ['required', 'max:200'],
            'alamat'  => ['nullable'],
            'email'   => ['required', 'email'],
            'nomor_telepon'     => ['required', 'numeric'],
            'jenis_kemitraan'   => ['required', 'in:Platinum,Gold,Silver'],
            'tanggal_bergabung' => ['required', 'date'],

        ]);
        $mitra_id = $request->mitra_id;
        $mitra = Mitra::findOrFail($mitra_id);

        $mitra->nama_mitra = $request->nama_mitra;
        $mitra->alamat = $request->alamat;
        $mitra->email = $request->email;
        $mitra->nomor_telepon = $request->nomor_telepon;
        $mitra->jenis_kemitraan = $request->jenis_kemitraan;
        $mitra->tanggal_bergabung = $request->tanggal_bergabung;


        $mitra->save();

        return redirect()->route('mitra.list')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $param1)
    {
        $mitra = Mitra::findOrFail($param1);
        $mitra->delete();
        return redirect()->route('mitra.list')->with('success', 'Data berhasil dihapus');
    }
}
