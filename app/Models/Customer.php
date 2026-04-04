<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'alamat',
        'telp',
        'email',
        'jenis_kelamin',
        'tanggal_estimasi',
    ];

    public function spks()
    {
        return $this->hasMany(Spk::class);
    }
}
