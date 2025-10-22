<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Authenticatable
{
    use HasFactory;

    protected $table = 'petugas';

    protected $fillable = [
        'nik',
        'nama_petugas',
        'email',
        'password',
        'alamat',
        'no_hp',
    ];

    protected $hidden = [
        'password',
    ];

    // ✅ Tambahkan relasi ke kas tanpa menghapus kode lain
    public function kas()
    {
        return $this->hasMany(\App\Models\Kas::class, 'petugas_id');
    }
}
