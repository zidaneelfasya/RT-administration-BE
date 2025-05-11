<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    //
    use HasFactory;
    protected $table = 'rumah';


    protected $fillable = [
        'nomor_rumah',
    ];

    // Relasi ke penghuni_rumah (histori penghuni)
    public function penghuniRumah()
    {
        return $this->hasMany(PenghuniRumah::class);
    }
    public function penghuniAktif()
    {
        return $this->hasMany(PenghuniRumah::class)
            ->where(function ($query) {
                $query->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>', now());
            });
    }

    public function isDihuni(): bool
    {
        return $this->penghuniAktif()->exists();
    }
}
