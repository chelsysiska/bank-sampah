<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('bulan');
            $table->string('tahun');
            $table->integer('jumlah_setoran');
            $table->decimal('total_berat', 10, 2);
            $table->decimal('total_harga', 10, 2);
            $table->foreignId('petugas_id')->constrained('users');
             $table->string('bukti')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};