<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function laporan(){
        $title = 'Laporan';        
        $laporan = DB::table('detail_transaksis')
        ->join('transaksis', 'transaksis.id', '=', 'detail_transaksis.transaksi_id')
        ->join('barangs', 'barangs.id', '=', 'detail_transaksis.barang_id')
        ->get();
        return view('laporan',  compact('title', 'laporan'));
    }
}
