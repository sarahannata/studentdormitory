<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'tanggal',
        'tipe_kehadiran',
        'jam_buka',
        'jam_tutup',
        'tipe_jadwal',
        'is_aktif',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

}
