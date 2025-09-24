<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('setoran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nasabah_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('petugas_id')->constrained('users')->cascadeOnDelete();
            
            // Perbaikan: Ubah 'jenis_sampah' menjadi 'jenis_sampahs'
            // agar sesuai dengan nama tabel yang dibuat di migrasi JenisSampah.
            $table->foreignId('jenis_sampah_id')->constrained('jenis_sampahs')->cascadeOnDelete();
            
            $table->date('tanggal_setoran');
            $table->decimal('berat', 8, 2);
            $table->decimal('harga_per_kilo', 12, 2);
            
            // Perbaikan: Ubah nama kolom 'total' menjadi 'total_harga'
            // agar konsisten dengan model Setoran Anda.
            $table->decimal('total_harga', 14, 2);
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('setoran');
    }
};
