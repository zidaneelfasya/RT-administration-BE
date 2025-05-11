<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\Pembayaran;
use App\Models\Penghuni;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\PenghuniRumah;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    public function rekapMonthly($id)
    {
        $tahun = Carbon::now()->year; // Bisa diganti jadi request atau parameter opsional
        $iuranList = Iuran::pluck('nama', 'id')->toArray();
        $bulanList = collect(range(1, 12))->map(function ($bulan) {
            return Carbon::create(null, $bulan, 1)->translatedFormat('M Y');
        });

        // Ambil semua pembayaran penghuni
        $pembayaran = Pembayaran::with('iuran')
            ->where('penghuni_rumah_id', $id)
            ->whereYear('periode_bulan', $tahun)
            ->get();

        $grouped = [];

        foreach ($bulanList as $i => $bulanTahun) {
            $grouped[$bulanTahun] = [];

            foreach ($iuranList as $iuranId => $namaIuran) {
                // Cek apakah pembayaran untuk iuran dan bulan ini ada
                $match = $pembayaran->first(function ($p) use ($iuranId, $i) {
                    return $p->iuran_id == $iuranId && Carbon::parse($p->periode_bulan)->month === $i + 1;
                });

                $grouped[$bulanTahun][$namaIuran] = $match && $match->tanggal_bayar
                    ? '✅ Lunas'
                    : '❌ Belum';
            }
        }

        return response()->json([
            'data' => $grouped
        ]);
    }

    public function index()
    {
        $pembayaran = Pembayaran::with([
            'iuran', // Relasi ke iuran (nama dan jumlah)
            'penghuniRumah.penghuni', // Relasi ke penghuni
            'penghuniRumah.rumah'     // Relasi ke rumah
        ])
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'data' => $pembayaran
        ]);
    }
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'penghuni_rumah_id' => 'required',
            'iuran_id' => 'required',
            'tanggal_bayar' => 'required',
            'periode_bulan' => 'required',
            'jumlah_bulan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $penghuniRumahId = $request->penghuni_rumah_id;
            $iuranId = $request->iuran_id;
            $tanggalBayar = $request->tanggal_bayar;
            $periodeBulan = $request->periode_bulan;
            $jumlahBulan = $request->jumlah_bulan;

            $createdPembayaran = [];

            // Create pembayaran records for each month
            for ($i = 0; $i < $jumlahBulan; $i++) {
                $currentPeriode = date('Y-m-d', strtotime("+$i months", strtotime($periodeBulan)));

                $pembayaran = Pembayaran::create([
                    'penghuni_rumah_id' => $penghuniRumahId,
                    'iuran_id' => $iuranId,
                    'tanggal_bayar' => $tanggalBayar,
                    'periode_bulan' => $currentPeriode,
                    'jumlah_bulan' => 1, // Each record represents 1 month
                ]);

                $createdPembayaran[] = $pembayaran;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil ditambahkan',
                'data' => $createdPembayaran,
                'total' => count($createdPembayaran) // Total records created
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan pembayaran',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
