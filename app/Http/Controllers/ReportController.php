<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function apiMonthlyReport($tahun)
    {
        // Ambil data pemasukan
        $pemasukan = DB::table('pembayaran')
            ->join('iuran', 'iuran.id', '=', 'pembayaran.iuran_id')
            ->selectRaw('MONTH(periode_bulan) as bulan, SUM(iuran.jumlah * pembayaran.jumlah_bulan) as total')
            ->whereYear('periode_bulan', $tahun)
            ->groupByRaw('MONTH(periode_bulan)')
            ->pluck('total', 'bulan');
        // Ambil data pengeluaran

        $pengeluaran = DB::table('pengeluaran')
            // ->join('iuran', 'iuran.id', '=', 'pembayaran.iuran_id')
            ->selectRaw('
            MONTH(tanggal) as bulan,
            SUM(jumlah) as total
        ')
            ->whereYear('tanggal', $tahun)
            ->groupByRaw('MONTH(tanggal)')
            ->pluck('total', 'bulan');

        // Bentuk array 12 bulan
        $data = [];
        $saldoSebelumnya = 0;

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $masuk = $pemasukan[$bulan] ?? 0;
            $keluar = $pengeluaran[$bulan] ?? 0;
            $saldo = $saldoSebelumnya + $masuk - $keluar;
            $saldoSebelumnya = $saldo;

            $data[] = [
                'bulan' => $bulan,
                'pemasukan' => $masuk,
                'pengeluaran' => $keluar,
                'saldo' => $saldo
            ];
        }

        return response()->json([
            'tahun' => (int) $tahun,
            'data' => $data
        ]);
    }
}
