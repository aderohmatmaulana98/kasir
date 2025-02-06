<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function barang(){
        $title = 'Barang';        
        $barangs = Barang::all(); 
        return view('barang',  compact('title','barangs'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang',
            'nama_barang' => 'required',
            'harga' => 'required|numeric',
        ]);

        Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga,
        ]);
        session()->flash('success', 'Barang berhasil ditambahkan!');
        return redirect()->route('barang');
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['success' => false, 'message' => 'Barang tidak ditemukan!'], 404);
        }
    
        $barang->delete();
        return response()->json(['success' => true, 'message' => 'Barang berhasil dihapus!']);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $id,
            'nama_barang' => 'required',
            'harga' => 'required|numeric',
        ]);

        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['success' => false, 'message' => 'Barang tidak ditemukan!'], 404);
        }

        $barang->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga,
        ]);

        session()->flash('success', 'Barang berhasil diubah!');
        return redirect()->route('barang');
    }
}
