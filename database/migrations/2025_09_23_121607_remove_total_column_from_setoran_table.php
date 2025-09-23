<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('setoran', function (Blueprint $table) {
            $table->dropColumn('total');
        });
    }

    public function down()
    {
        Schema::table('setoran', function (Blueprint $table) {
            $table->decimal('total', 15, 2)->nullable(); // Jika ingin kembalikan, buat nullable dulu
        });
    }
};