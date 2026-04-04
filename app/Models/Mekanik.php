<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mekanik extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'teknisi',
        'telp',
    ];

    // 🔥 TAMBAHKAN RELASI INI
    // Satu mekanik bisa mengerjakan banyak pengerjaan Body
    public function bodies()
    {
        return $this->hasMany(Body::class, 'mekanik_id');
    }

    public function preparations()
    {
        return $this->hasMany(Preparation::class, 'mekanik_id');
    }

    public function paints()
    {
        return $this->hasMany(Paint::class, 'mekanik_id');
    }

    public function poles()
    {
        return $this->hasMany(Poles::class, 'mekanik_id');
    }
}
