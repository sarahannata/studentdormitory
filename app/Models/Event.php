<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'event';
    protected $fillable = [
        'nama',
        'tanggal',
        'venue',
        'kategori',
        'jumlah_tamu',
        'mulai',
        'selesai',
        'catatan',
    ];
}
