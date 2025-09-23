<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        \DB::table('users')->delete();


        // Admin
        User::create([
            'name' => 'Admin Bank Sampah',
            'email' => 'admin@example.com',
            'nik' => '1234567890123456',
            'password' => Hash::make('admin123'), // default password
            'role' => 'admin',
        ]);

        // Petugas
        User::create([
            'name' => 'Petugas 1',
            'email' => 'petugas@example.com',
            'nik' => '6543210987654321',
            'password' => Hash::make('petugas123*'), // default password
            'role' => 'petugas',
        ]);

        // Nasabah
        User::create([
            'name' => 'Nasabah 1',
            'email' => 'nasabah@example.com',
            'nik' => '1111222233334444',
            'password' => Hash::make('nasabah123#'), // default password
            'role' => 'nasabah',
        ]);
    }
}
