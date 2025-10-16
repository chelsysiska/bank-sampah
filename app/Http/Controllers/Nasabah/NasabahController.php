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
    public function riwayat(Request $request)
{
    $query = Auth::user()->setoransAsNasabah()
                         ->with('jenisSampah', 'petugas')
                         ->orderBy('tanggal_setoran', 'desc');

    // ✅ Filter berdasarkan bulan dan tahun
    if ($request->filled('bulan')) {
        $query->whereMonth('tanggal_setoran', $request->bulan);
    }

    if ($request->filled('tahun')) {
        $query->whereYear('tanggal_setoran', $request->tahun);
    }

    $riwayatSetoran = $query->paginate(10);

    // Kirim data bulan dan tahun ke view
    return view('nasabah.riwayat', [
        'riwayatSetoran' => $riwayatSetoran,
        'bulan' => $request->bulan,
        'tahun' => $request->tahun,
    ]);
}

    /**
     * Menampilkan riwayat kas (global, bukan pribadi).
     */
    public function riwayatKas(Request $request)
{
    $query = Kas::query();

    // ✅ Filter berdasarkan bulan
    if ($request->filled('bulan')) {
        $query->whereMonth('created_at', $request->bulan);
    }

    // ✅ Filter berdasarkan tahun
    if ($request->filled('tahun')) {
        $query->whereYear('created_at', $request->tahun);
    }

    $riwayatKas = $query->latest()->paginate(10);

    return view('nasabah.kas.riwayat', compact('riwayatKas'));
}

}
