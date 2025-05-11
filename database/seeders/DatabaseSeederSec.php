<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeederSec extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Zidane Elfasya',
        //     'email' => 'zidane@gmail.com',
        //     "password" => bcrypt('saya1234'),
        // ]);
        $this->call([

            PembayaranSeeder::class,
            PengeluaranSeeder::class,
        ]);
    }
}
