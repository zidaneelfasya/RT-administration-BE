<?php

namespace Database\Seeders;

use App\Models\Penghuni;
use Illuminate\Database\Seeder;

class PenghuniSeeder extends Seeder
{
    public function run()
    {
        $namaPenghuni = [
            'Andi Saputra', 'Siti Aminah', 'Budi Hartono', 'Rina Marlina', 'Agus Pratama',
            'Dewi Sartika', 'Rizky Ramadhan', 'Lestari Ayu', 'Dedi Santoso', 'Maya Fitriani',
            'Fajar Nugroho', 'Intan Permata', 'Joko Widodo', 'Yuni Kartika', 'Bayu Hidayat',
            'Citra Lestari', 'Arifin Syah', 'Melati Kusuma', 'Hendra Gunawan', 'Nina Rahmawati'
        ];

        $statusPenghuni = ['tetap', 'kontrak'];
        $statusPernikahan = ['menikah', 'belum_menikah'];

        foreach ($namaPenghuni as $index => $nama) {
            Penghuni::create([
                'nama_lengkap' => $nama,
                'foto_ktp' => 'ktp/penghuni_' . ($index + 1) . '.jpg',
                'status_penghuni' => $index < 15 ? $statusPenghuni[0] : $statusPenghuni[1],
                'nomor_telepon' => '08' . rand(1110000000, 9999999999),
                'status_pernikahan' => $statusPernikahan[array_rand($statusPernikahan)]
            ]);
        }
    }
}
