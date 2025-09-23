<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class NasabahAdminController extends Controller
{
    public function index()
    {
        $nasabahs = User::where('role', 'nasabah')->latest()->paginate(20);
        return view('admin.nasabah.index', compact('nasabahs'));
    }

    public function contribution(User $nasabah)
    {
        // Ambil data setoran bulanan untuk nasabah yang dipilih
        $monthlyData = $nasabah->setoransAsNasabah()
                               ->select(
                                   DB::raw('MONTH(tanggal_setoran) as bulan'),
                                   DB::raw('YEAR(tanggal_setoran) as tahun'),
                                   DB::raw('SUM(berat) as total_berat')
                               )
                               ->groupBy('bulan', 'tahun')
                               ->orderBy('tahun', 'asc')
                               ->orderBy('bulan', 'asc')
                               ->get();
        
        return view('admin.nasabah.contribution', [
            'nasabah' => $nasabah,
            'monthlyData' => $monthlyData,
        ]);
    }
}