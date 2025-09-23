<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
protected $table = 'setoran';
protected $fillable = [
    'nasabah_id',
    'jenis_sampah_id',
    'tanggal_setoran',
    'berat',
    'harga_per_kilo',
    'total_harga',
    'petugas_id', // <-- pastikan ini ada
];


public function nasabah()
{
return $this->belongsTo(User::class, 'nasabah_id');
}


public function petugas()
{
return $this->belongsTo(User::class, 'petugas_id');
}


public function jenisSampah()
{
return $this->belongsTo(JenisSampah::class, 'jenis_sampah_id');
}
}
