<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiPerizinan extends Model
{
    use HasFactory;

    protected $table = 'cuti_izin';

    protected $fillable = [
        'user_id',
        'keterangan',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    

}
