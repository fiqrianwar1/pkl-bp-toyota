<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Body extends Model
{
    use HasFactory;

    protected $fillable = [
        'spk_id',
        'mekanik_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
        'bahan',
    ];

    // cast bahan ke array otomatis
    protected $casts = [
        'bahan' => 'array',
        'tanggal' => 'date',
    ];

    // relasi ke SPK
    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }

    // relasi ke Mekanik
    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class);
    }
}

