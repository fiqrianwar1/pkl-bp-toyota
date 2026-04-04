<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $fillable = [
        'spk_id',
        'nama_sparepart',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'tgl_estimasi_datang',
        'lokasi',
    ];

    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }
    
    // Accessor untuk format harga satuan ke Rupiah
    public function getHargaSatuanRupiahAttribute()
    {
        // Pastikan harga adalah numerik sebelum format
        return 'Rp ' . number_format($this->harga_satuan ?? 0, 0, ',', '.');
    }

    // Accessor untuk format total harga ke Rupiah
    public function getTotalHargaRupiahAttribute()
    {
        return 'Rp ' . number_format($this->total_harga ?? 0, 0, ',', '.');
    }
}