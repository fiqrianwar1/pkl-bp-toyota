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
        Schema::create('bodies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mekanik_id'); // relasi ke mekaniks
            $table->unsignedBigInteger('spk_id');     // relasi ke spks
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('status');
            $table->timestamps();

            // relasi foreign key
            $table->foreign('mekanik_id')->references('id')->on('mekaniks')->onDelete('cascade');
            $table->foreign('spk_id')->references('id')->on('spks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bodies');
    }
};
