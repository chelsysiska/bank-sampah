<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'jenis',        // 'pemasukan' atau 'pengeluaran'
        'jumlah',       // jumlah uang (dalam Rupiah, integer)
        'keterangan',   // catatan transaksi
        'dokumentasi',  // path file bukti (opsional)
        'petugas_id', 
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'jumlah' => 'integer',
    ];

    // ✅ Tambahkan relasi ke Petugas tanpa mengubah kode lama
    public function petugas()
{
    return $this->belongsTo(User::class, 'petugas_id');
}
}
