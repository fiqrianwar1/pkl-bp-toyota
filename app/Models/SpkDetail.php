<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpkDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'spk_id', 'nama_panel', 'jenis_pekerjaan', 'biaya',
    ];

    // Relasi Balik ke SPK
    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }
}