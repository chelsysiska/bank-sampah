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
        // PERBAIKAN: Menghitung total pendapatan dan total berat DARI SEMUA SETORAN (ALL-TIME/GRAND TOTAL).
        // Ini memastikan data di kartu dashboard adalah akumulasi dari semua transaksi granular 
        // yang dicatat di tabel 'Setoran', bukan hanya dari laporan bulanan yang mungkin belum lengkap.
        $totalPendapatanSemuaNasabah = Setoran::sum('total_harga');
        $totalBeratSemuaNasabah = Setoran::sum('berat'); // Menggunakan kolom 'berat' dari tabel setoran

        // Ambil data untuk rekap laporan bulanan dari tabel laporans (data bulanan yang sudah dikonsolidasi)
        $laporans = Laporan::with('petugas')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->paginate(10);
            
        // Data untuk grafik bulanan per jenis sampah
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
