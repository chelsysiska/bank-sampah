<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
public function up()
{
Schema::table('users', function (Blueprint $table) {
$table->string('role')->default('nasabah')->after('email'); // admin, petugas, nasabah
$table->string('nik')->nullable()->unique()->after('name');
});
}


public function down()
{
Schema::table('users', function (Blueprint $table) {
$table->dropColumn(['role', 'nik']);
});
}
};