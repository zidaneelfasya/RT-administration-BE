<?php

namespace Database\Seeders;

use App\Models\Iuran;
use Illuminate\Database\Seeder;

class IuranSeeder extends Seeder
{
    public function run()
    {
        
        Iuran::create([
            'nama' => 'Satpam',
            'jumlah' => 100000
        ]);

        Iuran::create([
            'nama' => 'Kebersihan',
            'jumlah' => 15000
        ]);
    }
}