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
        Schema::table('kas', function (Blueprint $table) {
            // Tambahkan kolom petugas_id setelah kolom id
            $table->foreignId('petugas_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
       Schema::table('kas', function (Blueprint $table) {
            // Hapus relasi dan kolom petugas_id jika rollback
            $table->dropConstrainedForeignId('petugas_id');
        });
    }
};
