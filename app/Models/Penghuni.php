<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    use HasFactory;
    protected $table = 'penghuni';

    protected $fillable = [
        'nama_lengkap',
        'foto_ktp', //path
        'status_penghuni',
        'nomor_telepon',
        'status_pernikahan'
    ];

    // Relasi ke rumah yang pernah/sedang dihuni
    public function rumah()
    {
        return $this->hasManyThrough(
            Rumah::class,
            PenghuniRumah::class,
            'penghuni_id', // Foreign key di penghuni_rumah
            'id', // Foreign key di rumah
            'id', // Local key di penghuni
            'rumah_id' // Local key di penghuni_rumah
        );
    }

    // Relasi langsung ke penghuni_rumah
    public function penghuniRumah()
    {
        return $this->hasMany(PenghuniRumah::class);
    }
}
