<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Menampilkan halaman transaksi
    public function transaksi()
    {
        $title = 'Transaksi';
        $barangs = Barang::all();
        $keranjang = Session::get('keranjang', []);

        return view('transaksi', compact('title', 'barangs', 'keranjang'));
    }

    // Menambahkan barang ke keranjang
    public function tambahKeKeranjang(Request $request)
    {
        $barang = Barang::find($request->barang);
        if (!$barang) {
            return response()->json(['success' => false, 'message' => 'Barang tidak ditemukan!']);
        }

        $keranjang = Session::get('keranjang', []);
        $id = $barang->id;

        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah'] += $request->jumlah;
            $keranjang[$id]['subtotal'] = $keranjang[$id]['jumlah'] * $barang->harga;
        } else {
            $keranjang[$id] = [
                'kode_barang' => $barang->kode_barang,
                'nama_barang' => $barang->nama_barang,
                'jumlah' => $request->jumlah,
                'harga' => $barang->harga,
                'subtotal' => $request->jumlah * $barang->harga,
            ];
        }

        Session::put('keranjang', $keranjang);
        Session::save();

        return response()->json(['success' => true, 'keranjang' => $keranjang]);
    }

    // Menghapus barang dari keranjang
    public function hapusDariKeranjang($id)
    {
        $keranjang = Session::get('keranjang', []);
        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            Session::put('keranjang', $keranjang);
            Session::save();
        }

        return response()->json(['success' => true, 'keranjang' => $keranjang]);
    }

    // Menghitung total harga belanjaan
    public function hitungTotal()
    {
        $keranjang = Session::get('keranjang', []);
        $total = array_sum(array_column($keranjang, 'subtotal'));

        return response()->json(['total' => $total]);
    }

    // Proses checkout
    public function checkout(Request $request)
    {
        $keranjang = Session::get('keranjang', []);
        if (empty($keranjang)) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong!']);
        }

        $total = array_sum(array_column($keranjang, 'subtotal'));
        $bayar = $request->bayar;
        $kembalian = $bayar - $total;

        if ($bayar < $total) {
            return response()->json(['success' => false, 'message' => 'Pembayaran kurang!']);
        }

        $transaksi = Transaksi::create([
            'total' => $total,
            'bayar' => $bayar,
            'kembalian' => $kembalian,
        ]);

        foreach ($keranjang as $id => $item) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $id,
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        Session::forget('keranjang');
        Session::save();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil!',
            'total' => $total,
            'bayar' => $bayar,
            'kembalian' => $kembalian,
            'transaksi_id' => $transaksi->id
        ]);
    }
}
