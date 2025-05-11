<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    use HasFactory;
    
    protected $table = 'iuran';

    protected $fillable = [
        'nama',
        'jumlah'
    ];

    // Relasi ke pembayaran
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
