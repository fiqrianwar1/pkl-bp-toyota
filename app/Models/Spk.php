<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spk extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_spk',
        'customer_id',
        'model',
        'no_polisi',
        'tgl_masuk',
        'estimasi_selesai',
        'status',
        'catatan',
        'details', 
    ];

    protected $casts = [
        'details' => 'array',
    ];

    // Relasi ke Customer
    public function customer()
    {
        // 🔥 TAMBAHKAN 'customer_id'
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relasi One-to-Many ke Sparepart
    public function spareparts() 
    {
        return $this->hasMany(Sparepart::class, 'spk_id');
    }

    // Accessor untuk menghitung total biaya
    public function getTotalBiayaAttribute()
    {
        $total = 0;
        if (is_array($this->details)) {
            foreach ($this->details as $detail) {
                $total += (float)($detail['biaya'] ?? 0); 
            }
        }
        return $total;
    }
    
    // Static method untuk generate No SPK
    public static function generateNoSpk()
    {
        $today = date('Ymd');
        $prefix = "SPK-{$today}-";
        
        $lastSpk = self::where('no_spk', 'like', "{$prefix}%")
                       ->orderBy('no_spk', 'desc')
                       ->first();
                       
        $nextNumber = $lastSpk ? (int)substr($lastSpk->no_spk, -3) + 1 : 1;
        
        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    // Relasi ke body
    public function body()
    {
        // 🔥 TAMBAHKAN 'spk_id'
        return $this->hasOne(Body::class, 'spk_id');
    }

    // Relasi ke Preparation
    public function preparation()
    {
        // 🔥 TAMBAHKAN 'spk_id'
        return $this->hasOne(Preparation::class, 'spk_id');
    }

    // Relasi ke Paint
    public function paint()
    {
        // 🔥 TAMBAHKAN 'spk_id'
        return $this->hasOne(Paint::class, 'spk_id');
    }

    // Relasi ke Poles
    public function poles()
    {
        // 🔥 TAMBAHKAN 'spk_id'
        return $this->hasOne(Poles::class, 'spk_id');
    }

}
