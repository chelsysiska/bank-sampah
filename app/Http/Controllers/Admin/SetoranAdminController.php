<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setoran;

class SetoranAdminController extends Controller
{
    public function index()
    {
        // HANYA tampilkan setoran yang SUDAH dilaporkan (is_reported = true)
        $setorans = Setoran::with('nasabah', 'jenisSampah')
                           ->where('is_reported', true)
                           ->orderBy('tanggal_setoran', 'desc')
                           ->paginate(20);

        return view('admin.setoran.index', compact('setorans'));
    }
}