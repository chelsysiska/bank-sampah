<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
use HasApiTokens, Notifiable;


protected $fillable = [
    'name',
    'email',
    'nik',
    'password',
    'role',
    'saldo',
];


protected $hidden = [
'password', 'remember_token',
];


public function setoransAsNasabah()
{
return $this->hasMany(Setoran::class, 'nasabah_id');
}


public function setoransAsPetugas()
{
return $this->hasMany(Setoran::class, 'petugas_id');
}


public function isAdmin()
{
return $this->role === 'admin';
}


public function isPetugas()
{
return $this->role === 'petugas';
}


public function isNasabah()
{
return $this->role === 'nasabah';
}
}
