<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paint extends Model
{
    use HasFactory;

    protected $fillable = [
        'mekanik_id',
        'spk_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
        'bahan', // Ini sudah ada dari migrasi
    ];

    /**
     * Memberitahu Laravel bahwa 'bahan' adalah array/json
     * dan 'tanggal' adalah objek Carbon date.
     */
    protected $casts = [
        'bahan' => 'array',
        'tanggal' => 'date', // 🔥 DISAMAKAN DENGAN MODEL BODY
    ];

    // Relasi ke Mekanik
    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class, 'mekanik_id');
    }

    // Relasi ke SPK
    public function spk()
    {
        return $this->belongsTo(Spk::class, 'spk_id');
    }
}