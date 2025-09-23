<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\Setoran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini

class NasabahController extends Controller
{
    public function index()
    {
        $nasabah = auth()->user();

        // Mengambil riwayat setoran
        $riwayatSetoran = $nasabah->setoransAsNasabah()
                                  ->with('jenisSampah')
                                  ->orderBy('tanggal_setoran', 'desc')
                                  ->get();

        // Menghitung total setoran
        $count = $riwayatSetoran->count();

        // Mengambil saldo total
        $saldo = $nasabah->saldo;

        // Mendapatkan rekapitulasi setoran bulanan
        $bulanan = $nasabah->setoransAsNasabah()
                           ->select(
                               DB::raw('MONTH(tanggal_setoran) as bulan'),
                               DB::raw('YEAR(tanggal_setoran) as tahun'),
                               DB::raw('SUM(berat) as total_berat'),
                               DB::raw('SUM(total_harga) as total_harga')
                           )
                           ->groupBy('bulan', 'tahun')
                           ->orderBy('tahun', 'desc')
                           ->orderBy('bulan', 'desc')
                           ->get();
                           
        return view('nasabah.dashboard', [
            'riwayatSetoran' => $riwayatSetoran,
            'saldo' => $saldo,
            'count' => $count,
            'bulanan' => $bulanan, // <-- Tambahkan baris ini
            // Anda bisa menambahkan data lain di sini
        ]);
    }
}