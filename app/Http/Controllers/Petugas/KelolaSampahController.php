<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\JenisSampah;
use Illuminate\Http\Request;

class KelolaSampahController extends Controller
{
    public function index()
    {
        $jenis = JenisSampah::all(); // ambil semua jenis sampah dari database
        return view('petugas.kelola-sampah', compact('jenis'));
    }
}
