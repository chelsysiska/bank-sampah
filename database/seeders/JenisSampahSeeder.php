<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSampahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_sampahs')->insert([ // Perbaikan: Mengubah 'jenis_sampah' menjadi 'jenis_sampahs'
            ['nama' => 'Plastik Bening', 'harga_per_kilo' => 3500],
            ['nama' => 'Botol Plastik', 'harga_per_kilo' => 4000],
            ['nama' => 'Kertas', 'harga_per_kilo' => 2500],
            ['nama' => 'Kaleng', 'harga_per_kilo' => 6000],
            ['nama' => 'Kaca', 'harga_per_kilo' => 1500],
            ['nama' => 'Logam', 'harga_per_kilo' => 7500],
        ]);
    }
}
