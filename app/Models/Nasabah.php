<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'nik',
        'saldo',
        'password',
    ];

    /**
     * Get the setorans for the nasabah.
     */
    public function setorans()
    {
        return $this->hasMany(Setoran::class, 'nasabah_id');
    }
}
