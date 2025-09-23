<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisSampah;

class JenisSampahSeeder extends Seeder
{
    public function run()
    {
        JenisSampah::insert([
            ['nama' => 'Plastik Bening', 'harga_per_kilo' => 3500],
            ['nama' => 'Botol Plastik', 'harga_per_kilo' => 4000],
            ['nama' => 'Kertas', 'harga_per_kilo' => 2500],
            ['nama' => 'Kaleng', 'harga_per_kilo' => 6000],
            ['nama' => 'Kaca', 'harga_per_kilo' => 1500],
            ['nama' => 'Logam', 'harga_per_kilo' => 7500],
        ]);
    }
}
