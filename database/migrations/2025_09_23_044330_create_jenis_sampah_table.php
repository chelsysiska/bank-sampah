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
        // Mengubah nama tabel menjadi 'jenis_sampahs' (plural) sesuai konvensi Laravel
        Schema::create('jenis_sampahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique(); // Menambahkan batasan unik
            $table->decimal('harga_per_kilo', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_sampahs');
    }
};