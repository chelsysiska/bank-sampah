<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setoran;
use Carbon\Carbon; // Tambahkan import Carbon untuk memparsing tanggal

class SetoranAdminController extends Controller
{
    public function index()
    {
        // PENTING: Mengubah paginate(20) menjadi get() untuk mengambil semua data
        // agar dapat dikelompokkan (grouping) per bulan. Paginasi dihilangkan.
        $setorans = Setoran::with('nasabah', 'jenisSampah')
                           ->where('is_reported', true)
                           ->orderBy('tanggal_setoran', 'desc')
                           ->get();

        // Kelompokkan data setoran berdasarkan Tahun dan Bulan (e.g., 2023-10)
        $setoransGroupedByMonth = $setorans->groupBy(function($setoran) {
            return Carbon::parse($setoran->tanggal_setoran)->format('Y-m');
        });
        
        // Lewatkan data yang sudah dikelompokkan (setoransGroupedByMonth) ke view
        return view('admin.setoran.index', compact('setoransGroupedByMonth'));
    }
}
