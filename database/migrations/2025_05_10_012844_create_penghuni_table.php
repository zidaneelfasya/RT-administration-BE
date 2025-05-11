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
        Schema::create('penghuni', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 100);
            $table->string('foto_ktp')->nullable();
            $table->enum('status_penghuni', ['tetap', 'kontrak']);
            $table->string('nomor_telepon', 20);
            $table->enum('status_pernikahan', ['menikah', 'belum_menikah']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghuni');
    }
};
