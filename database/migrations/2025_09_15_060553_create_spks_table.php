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
        Schema::create('spks', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('no_spk')->unique();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('model');
            $table->string('no_polisi');
            $table->date('tgl_masuk');
            $table->date('estimasi_selesai')->nullable();
            $table->enum('status', ['proses', 'selesai', 'batal'])->default('proses');
            
            // Kolom ini akan menyimpan semua data panel (nama, jenis pekerjaan, biaya) dalam format JSON
            $table->json('details')->nullable(); 
            
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spks');
    }
};