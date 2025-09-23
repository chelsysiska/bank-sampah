<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setoran;

class SetoranAdminController extends Controller
{
    public function index()
    {
        // Menggunakan with() untuk memuat relasi nasabah dan jenisSampah.
        // Ini memastikan data terkait diambil dalam satu kueri, bukan untuk setiap baris.
        $setorans = Setoran::with('nasabah', 'jenisSampah')
                           ->latest()
                           ->paginate(20);

        return view('admin.setoran.index', compact('setorans'));
    }
}