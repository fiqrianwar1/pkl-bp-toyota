<?php
// database/seeders/CustomerSeeder.php
namespace Database\Seeders;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        Customer::create([
            'nama' => 'Bambang Sudiro',
            'alamat' => 'Jl. Kenangan No. 10',
            'telp' => '081234567890',
            'email' => 'bambang@example.com',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_estimasi' => now()->addDays(5)->format('Y-m-d'),
        ]);
        // Tambahkan customer lain di sini
    }
}