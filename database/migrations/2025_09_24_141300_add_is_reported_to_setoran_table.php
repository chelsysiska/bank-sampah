<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('setoran', function (Blueprint $table) {
            // Tambahkan kolom is_reported dengan nilai default false
            $table->boolean('is_reported')->default(false)->after('total_harga'); 
        });
    }

    public function down(): void
    {
        Schema::table('setoran', function (Blueprint $table) {
            $table->dropColumn('is_reported');
        });
    }
};