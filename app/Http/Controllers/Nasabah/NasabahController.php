<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\Setoran;
use App\Models\User; // Ditambahkan untuk memastikan model User tersedia
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NasabahController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk nasabah.
     */
    public function index()
    {
        // Ambil objek user yang sedang login
        $nasabah = Auth::user();

        // Mengambil riwayat setoran pribadi dengan paginasi
        $riwayatSetoran = $nasabah->setoransAsNasabah()
                                  ->with('jenisSampah', 'petugas')
                                  ->orderBy('tanggal_setoran', 'desc')
                                  ->paginate(5); // Menggunakan paginasi untuk efisiensi

        // Menghitung total pendapatan pribadi nasabah
        $totalPendapatanPribadi = $nasabah->setoransAsNasabah()->sum('total_harga');

        // Menghitung total pendapatan dari semua nasabah (untuk perbandingan)
        $totalPendapatanSemuaNasabah = Setoran::sum('total_harga');

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
            'saldo' => $nasabah->saldo,
            'totalPendapatanPribadi' => $totalPendapatanPribadi,
            'totalPendapatanSemuaNasabah' => $totalPendapatanSemuaNasabah,
            'bulanan' => $bulanan,
        ]);
    }

    /**
     * Menampilkan halaman riwayat setoran nasabah secara terpisah.
     */
    public function riwayat()
    {
        $riwayatSetoran = Auth::user()->setoransAsNasabah()
                                     ->with('jenisSampah', 'petugas')
                                     ->orderBy('tanggal_setoran', 'desc')
                                     ->paginate(10); // Menampilkan 10 item per halaman

        return view('nasabah.riwayat', compact('riwayatSetoran'));
    }
}
