<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi tabel sparepart.
     */
    public function up(): void
    {
        Schema::create('spareparts', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel SPK
            $table->foreignId('spk_id')->constrained('spks')->onDelete('cascade');

            // Data utama sparepart
            $table->string('nama_sparepart');
            $table->integer('jumlah');
            
            // Menggunakan integer atau bigInteger untuk harga agar tidak ada masalah rounding, 
            // asalkan di aplikasi Anda selalu memasukkan harga dalam Rupiah (tanpa sen)
            $table->bigInteger('harga_satuan'); 
            $table->bigInteger('total_harga')->nullable();

            // Info tambahan
            $table->date('tgl_estimasi_datang')->nullable();
            $table->string('lokasi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Hapus tabel sparepart jika dibatalkan.
     */
    public function down(): void
    {
        Schema::dropIfExists('spareparts');
    }
};