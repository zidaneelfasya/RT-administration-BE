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
        Schema::create('penghuni_rumah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rumah_id')->constrained('rumah');
            $table->foreignId('penghuni_id')->constrained('penghuni');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable(); // NULL jika masih aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghuni_rumah');
    }
};
