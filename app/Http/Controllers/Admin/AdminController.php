<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setoran;
use App\Models\Laporan;
use App\Models\JenisSampah;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hitung total pendapatan dan total berat dari tabel laporan
        // Ini adalah data yang sudah dikonsolidasikan oleh petugas
        $totalPendapatanSemuaNasabah = Laporan::sum('total_harga');
        $totalBeratSemuaNasabah = Laporan::sum('total_berat');

        // Ambil data untuk rekap laporan bulanan dari tabel laporans
        // Data ini sudah otomatis terkelompokkan per bulan/tahun saat dikirim petugas
        $laporans = Laporan::with('petugas')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->paginate(10);
            
        // Data untuk grafik bulanan per jenis sampah
        // Query ini tetap pada tabel Setoran karena ini adalah data riwayat semua setoran
        $grafikBulananData = Setoran::select(
            DB::raw('MONTH(tanggal_setoran) as month'),
            'jenis_sampah_id',
            DB::raw('SUM(berat) as total_berat')
        )
        ->groupBy('month', 'jenis_sampah_id')
        ->orderBy('month', 'asc')
        ->get();

        $jenisSampahData = JenisSampah::all();

        return view('admin.dashboard', compact(
            'totalPendapatanSemuaNasabah', 
            'totalBeratSemuaNasabah', 
            'laporans', 
            'grafikBulananData',
            'jenisSampahData'
        ));
    }
}
