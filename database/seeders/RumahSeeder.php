<?php

namespace Database\Seeders;

use App\Models\Rumah;
use Illuminate\Database\Seeder;

class RumahSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            Rumah::create([
                'nomor_rumah' => 'A' . str_pad($i, 2, '0', STR_PAD_LEFT),
                // 'status_penghuni' => $i <= 15 ? 'dihuni' : 'tidak_dihuni'
            ]);
        }
    }
}