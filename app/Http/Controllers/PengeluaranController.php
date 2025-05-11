<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index()
    {

        $pengeluaran = \App\Models\Pengeluaran::all();
        return response()->json($pengeluaran);
    }
    public function store(Request $request){
        $request->validate([
            'deskripsi' => 'required',
            'jumlah'=> 'required|numeric',
            'tanggal' => 'required|date',
            'kategori' => 'required',
        ]);

        $pengeluaran = new \App\Models\Pengeluaran();
        $pengeluaran->deskripsi = $request->deskripsi;
        $pengeluaran->jumlah = $request->jumlah;
        $pengeluaran->tanggal = $request->tanggal;
        $pengeluaran->kategori = $request->kategori;
        $pengeluaran->save();
        // Mengembalikan response JSON
        // dengan status 201 Created

        return response()->json($pengeluaran, 201);
    }
}
