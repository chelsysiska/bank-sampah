<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\Setoran;
use App\Models\Kas;
use App\Models\User;
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
        $nasabah = Auth::user();

        // Riwayat setoran pribadi
        $riwayatSetoran = $nasabah->setoransAsNasabah()
                                  ->with('jenisSampah', 'petugas')
                                  ->orderBy('tanggal_setoran', 'desc')
                                  ->paginate(5);

        // Total pendapatan pribadi
        $totalPendapatanPribadi = $nasabah->setoransAsNasabah()->sum('total_harga');

        // Total pendapatan semua nasabah (komunitas)
        $totalPendapatanSemuaNasabah = Setoran::sum('total_harga');

        /**
         * 💰 Total kas global (transparan untuk semua pengguna)
         * Rumus: pendapatan semua nasabah + pemasukan luar - pengeluaran
         */
        $totalPendapatanNasabah = Setoran::sum('total_harga');
        $totalPemasukanLuar = Kas::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Kas::where('jenis', 'pengeluaran')->sum('jumlah');
        $totalKas = $totalPendapatanNasabah + $totalPemasukanLuar - $totalPengeluaran;

        // Rekap setoran bulanan
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
            'totalKas' => $totalKas, // ✅ Sama dengan admin
            'bulanan' => $bulanan,
        ]);
    }

    /**
     * Menampilkan halaman riwayat setoran.
     */
    public function riwayat()
    {
        $riwayatSetoran = Auth::user()->setoransAsNasabah()
                                     ->with('jenisSampah', 'petugas')
                                     ->orderBy('tanggal_setoran', 'desc')
                                     ->paginate(10);

        return view('nasabah.riwayat', compact('riwayatSetoran'));
    }

    /**
     * Menampilkan riwayat kas (global, bukan pribadi).
     */
    public function riwayatKas()
    {
        $riwayatKas = Kas::latest()->paginate(10);
        return view('nasabah.kas.riwayat', compact('riwayatKas'));
    }
}
