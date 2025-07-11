<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlipGaji extends Model
{
    use HasFactory;
    protected $table = 'slipgaji';

    protected $fillable = [
        'nomor_slip',
        'user_id',
        'metode_pembayaran',
        'nomor_rekening',
        'rincian_gaji',
        'potongan_pajak',
        'bulan',
        'tahun',
        'created_by',
    ];

    protected $casts = [
        'rincian_gaji' => 'array', // otomatis diconvert dari/ke JSON
        'potongan_pajak' => 'array',
    ];

    /**
     * Relasi ke model User (penerima slip gaji)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

        // SlipGaji.php
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
