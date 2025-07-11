<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;

    protected $table = 'lembur';

    protected $fillable = [
        'user_id',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'keterangan_lembur',
        'status',
    ];

    /**
     * Relasi ke model User (pegawai yang mengajukan lembur).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
