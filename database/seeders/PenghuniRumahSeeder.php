<?php

namespace Database\Seeders;

use App\Models\PenghuniRumah;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PenghuniRumahSeeder extends Seeder
{
    public function run()
    {
        // Penghuni tetap (15 rumah pertama)
        for ($i = 1; $i <= 15; $i++) {
            PenghuniRumah::create([
                'rumah_id' => $i,
                'penghuni_id' => $i,
                'tanggal_mulai' => Carbon::now()->subMonths(rand(6, 24)),
                'tanggal_selesai' => null
            ]);
        }

        // Penghuni kontrak (5 rumah terakhir)
        for ($i = 16; $i <= 20; $i++) {
            $startDate = Carbon::now()->subMonths(rand(1, 5));
            PenghuniRumah::create([
                'rumah_id' => $i,
                'penghuni_id' => $i,
                'tanggal_mulai' => $startDate,
                'tanggal_selesai' => rand(0, 1) ? $startDate->copy()->addMonths(rand(1, 3)) : null
            ]);
        }
    }
}