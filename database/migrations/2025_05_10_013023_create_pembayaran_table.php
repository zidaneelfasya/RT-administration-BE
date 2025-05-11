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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penghuni_rumah_id')->constrained('penghuni_rumah');
            $table->foreignId('iuran_id')->constrained('iuran');
            $table->date('periode_bulan'); // Format YYYY-MM-01
            $table->date('tanggal_bayar')->nullable(); 
            $table->integer('jumlah_bulan')->default(1); // 1 = bulanan, 12 = tahunan
            // $table->enum('status', ['lunas', 'belum_lunas'])->default('belum_lunas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
