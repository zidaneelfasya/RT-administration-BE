<?php

namespace Database\Seeders;

use App\Models\Pembayaran;
use App\Models\PenghuniRumah;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    public function run()
    {
        $currentYear = date('Y');
        
        // Pembayaran untuk penghuni tetap (15 rumah pertama)
        for ($i = 1; $i <= 15; $i++) {
            for ($month = 1; $month <= 12; $month++) {
                // Pembayaran Satpam
                Pembayaran::create([
                    'penghuni_rumah_id' => $i,
                    'iuran_id' => 1, // Satpam
                    'periode_bulan' => Carbon::create($currentYear, $month, 1),
                    'tanggal_bayar' => Carbon::create($currentYear, $month, rand(1, 28)),
                    'jumlah_bulan' => 1,
                    // 'status' => 'lunas'
                ]);

                // Pembayaran Kebersihan (kadang bayar setahun sekaligus)
                if ($month == 1 || rand(0, 1)) {
                    Pembayaran::create([
                        'penghuni_rumah_id' => $i,
                        'iuran_id' => 2, // Kebersihan
                        'periode_bulan' => Carbon::create($currentYear, $month, 1),
                        'tanggal_bayar' => Carbon::create($currentYear, $month, rand(1, 28)),
                        'jumlah_bulan' => $month == 1 ? 12 : 1,
                        // 'status' => 'lunas'
                    ]);
                }
            }
        }

        // Pembayaran untuk penghuni kontrak (5 rumah terakhir)
        // for ($i = 16; $i <= 20; $i++) {
        //     $penghuniRumah = PenghuniRumah::find($i);
            
        //     // Pastikan data ada dan tanggal_mulai tidak null
        //     if ($penghuniRumah && $penghuniRumah->tanggal_mulai) {
        //         $startMonth = $penghuniRumah->tanggal_mulai->month;
                
        //         for ($month = $startMonth; $month <= 12; $month++) {
        //             if (rand(0, 1)) { // 50% kemungkinan bayar
        //                 Pembayaran::create([
        //                     'penghuni_rumah_id' => $i,
        //                     'iuran_id' => 1, // Satpam
        //                     'periode_bulan' => Carbon::create($currentYear, $month, 1),
        //                     'jumlah_bulan' => 1,
        //                     'status' => rand(0, 1) ? 'lunas' : 'belum_lunas'
        //                 ]);

        //                 if (rand(0, 1)) {
        //                     Pembayaran::create([
        //                         'penghuni_rumah_id' => $i,
        //                         'iuran_id' => 2, // Kebersihan
        //                         'periode_bulan' => Carbon::create($currentYear, $month, 1),
        //                         'jumlah_bulan' => 1,
        //                         'status' => rand(0, 1) ? 'lunas' : 'belum_lunas'
        //                     ]);
        //                 }
        //             }
        //         }
        //     }
        // }
    }
}