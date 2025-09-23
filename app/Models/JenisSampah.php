<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
protected $table = 'jenis_sampah';
protected $fillable = ['nama_sampah', 'harga_per_kilo'];


// ...
public function setoran()
{
    return $this->hasMany(Setoran::class, 'jenis_sampah_id');
}
}
