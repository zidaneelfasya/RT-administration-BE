<?php

namespace Database\Seeders;

use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PengeluaranSeeder extends Seeder
{
    public function run()
    {
        $kategori = ['Perbaikan', 'Operasional', 'Lain-lain'];
        $deskripsi = [
            'Perbaikan' => ['Perbaikan jalan', 'Perbaikan selokan', 'Cat pagar'],
            'Operasional' => ['Gaji satpam', 'Token listrik pos satpam', 'Alat kebersihan'],
            'Lain-lain' => ['Acara RT', 'Sumbangan', 'Dana darurat']
        ];

        $currentYear = date('Y');
        
        for ($month = 1; $month <= 12; $month++) {
            $count = rand(1,3); // 3-8 pengeluaran per bulan
            for ($i = 0; $i < $count; $i++) {
                $kategoriRandom = $kategori[array_rand($kategori)];
                $deskripsiRandom = $deskripsi[$kategoriRandom][array_rand($deskripsi[$kategoriRandom])];
                
                Pengeluaran::create([
                    'deskripsi' => $deskripsiRandom,
                    'jumlah' => $kategoriRandom == 'Operasional' ? 
                                ($deskripsiRandom == 'Gaji satpam' ? 1000000 : rand(100000, 500000)) : 
                                rand(300000, 1000000),
                    'tanggal' => Carbon::create($currentYear, $month, rand(1, 28)),
                    'kategori' => $kategoriRandom
                ]);
            }
        }
    }
}