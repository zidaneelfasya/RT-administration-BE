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
        Schema::create('iuran', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50)->unique(); // 'Satpam' atau 'Kebersihan'
            $table->decimal('jumlah', 10, 2); // 100000 atau 15000
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iuran');
    }
};
