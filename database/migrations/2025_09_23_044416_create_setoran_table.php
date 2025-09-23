<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
public function up()
{
Schema::create('setoran', function (Blueprint $table) {
$table->id();
$table->foreignId('nasabah_id')->constrained('users')->cascadeOnDelete();
$table->foreignId('petugas_id')->constrained('users')->cascadeOnDelete();
$table->foreignId('jenis_sampah_id')->constrained('jenis_sampah')->cascadeOnDelete();
$table->date('tanggal_setoran');
$table->decimal('berat', 8, 2);
$table->decimal('harga_per_kilo', 12, 2);
$table->decimal('total', 14, 2);
$table->timestamps();
});
}


public function down()
{
Schema::dropIfExists('setoran');
}
};