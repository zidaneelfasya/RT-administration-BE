<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = 'pengeluaran';

    protected $fillable = [
        'deskripsi',
        'jumlah',
        'tanggal',
        'kategori'
    ];

    protected $dates = ['tanggal'];

    public static function getMonthlyTotal($tahun)
    {
        return self::selectRaw('
            MONTH(tanggal) as bulan,
            SUM(jumlah) as total
        ')
            ->whereYear('tanggal', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->pluck('total', 'bulan')
            ->toArray();
    }

    public static function totalPengeluaran()
    {
        return self::sum('jumlah');
    }
}
