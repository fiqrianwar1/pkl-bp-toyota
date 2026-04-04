<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spk_details', function (Blueprint $table) {
            $table->id(); // Primary Key untuk tabel detail
            
            // Foreign Key yang menghubungkan ke tabel 'spks'
            $table->foreignId('spk_id')
                  ->constrained() // Asumsi nama tabel utama adalah 'spks'
                  ->onDelete('cascade'); // Jika SPK utama dihapus, detailnya ikut terhapus

            $table->string('nama_panel'); // Contoh: Bumper Depan, Pintu Kiri Depan
            $table->enum('jenis_pekerjaan', ['KC', 'GC', 'SC']); // KC=Ketok Cat, GC=Ganti Cat, SC=Spesial Cat
            $table->integer('biaya'); // Biaya untuk panel ini (gunakan integer karena nilainya besar)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spk_details');
    }
};