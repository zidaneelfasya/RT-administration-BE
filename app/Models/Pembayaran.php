<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayaran';

    protected $fillable = [
        'penghuni_rumah_id',
        'iuran_id',
        'periode_bulan',
        'tanggal_bayar',
        'jumlah_bulan',
        // 'status'
    ];

    protected $casts = [
        'periode_bulan' => 'date',
    ];

    // Relasi ke penghuni_rumah
    public function penghuniRumah()
    {
        return $this->belongsTo(PenghuniRumah::class);
    }

    // Relasi ke iuran
    public function iuran()
    {
        return $this->belongsTo(Iuran::class);
    }

    // Accessor untuk menghitung total pembayaran
    public function getTotalAttribute()
    {
        return $this->iuran->jumlah * $this->jumlah_bulan;
    }
    public static function getMonthlyTotal($tahun)
    {
        return self::selectRaw('
        MONTH(periode_bulan) as bulan,
        SUM(iuran.jumlah * pembayaran.jumlah_bulan) as total
    ')
            ->join('iuran', 'iuran.id', '=', 'pembayaran.iuran_id')
            ->whereYear('periode_bulan', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->pluck('total', 'bulan')
            ->toArray();
    }
    public function penghuni()
    {
        return $this->hasOneThrough(
            Penghuni::class,
            PenghuniRumah::class,
            'id',               // Foreign key di penghuni_rumah
            'id',               // Foreign key di penghuni
            'penghuni_rumah_id',
            'penghuni_id'
        );
    }
}
