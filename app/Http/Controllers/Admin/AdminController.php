<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $laporans = Laporan::with('petugas')->latest()->paginate(20);

        // Ambil data agregat untuk grafik
        $grafikData = DB::table('setoran')
                        ->join('jenis_sampah', 'setoran.jenis_sampah_id', '=', 'jenis_sampah.id')
                        ->select(
                            'jenis_sampah.nama as jenis',
                            DB::raw('SUM(setoran.berat) as total_berat')
                        )
                        ->groupBy('jenis_sampah.nama')
                        ->orderBy('total_berat', 'desc')
                        ->get();
        
        // HENTIKAN EKSEKUSI DAN TAMPILKAN DATA
        dd($grafikData);

        return view('admin.dashboard', compact('laporans', 'grafikData'));
    }
}