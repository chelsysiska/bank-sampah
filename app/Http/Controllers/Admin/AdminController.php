<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setoran;
use App\Models\Laporan;
use App\Models\JenisSampah;
use App\Models\Kas;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Tetap: total pendapatan & berat semua nasabah dari tabel setoran
        $totalPendapatanSemuaNasabah = Setoran::sum('total_harga');
        $totalBeratSemuaNasabah = Setoran::sum('berat');

        // Rekap laporan bulanan
        $laporans = Laporan::with('petugas')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->paginate(10);

        // Ambil tahun unik dari setoran
        $tahunList = Setoran::select(DB::raw('YEAR(tanggal_setoran) as tahun'))
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Tahun aktif (default tahun sekarang)
        $tahunDipilih = $request->get('tahun', date('Y'));

        // Data grafik bulanan (total pendapatan semua jenis sampah per bulan, untuk tahun yang dipilih)
        $grafikBulananData = Setoran::select(
            DB::raw('MONTH(tanggal_setoran) as month'),
            DB::raw('SUM(total_harga) as total_pendapatan')
        )
        ->whereYear('tanggal_setoran', $tahunDipilih) // filter tahun dipilih
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();


        $jenisSampahData = JenisSampah::all();

        // Data grafik tahunan (total tiap tahun)
        $grafikTahunanData = Setoran::select(
            DB::raw('YEAR(tanggal_setoran) as year'),
            DB::raw('SUM(berat) as total_berat')
        )
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        // === LOGIKA BARU: Total Kas = Saldo Awal (dari pendapatan) + Transaksi Manual ===
        $saldoAwalKas = $totalPendapatanSemuaNasabah;
        $totalPemasukanManual = Kas::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaranManual = Kas::where('jenis', 'pengeluaran')->sum('jumlah');
        $totalKas = $saldoAwalKas + $totalPemasukanManual - $totalPengeluaranManual;

        // Riwayat kas
        $riwayatKas = Kas::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.dashboard', compact(
            'totalPendapatanSemuaNasabah',
            'totalBeratSemuaNasabah',
            'laporans',
            'grafikBulananData',
            'grafikTahunanData',
            'jenisSampahData',
            'tahunList',
            'tahunDipilih',
            'totalKas',
            'riwayatKas'
        ));
    }

    public function riwayatKas()
{
    // Saldo awal kas = total pendapatan semua setoran
    $saldoAwalKas = \App\Models\Setoran::sum('total_harga');

    // Pemasukan & pengeluaran manual dari tabel kas
    $totalPemasukanManual = \App\Models\Kas::where('jenis', 'pemasukan')->sum('jumlah');
    $totalPengeluaranManual = \App\Models\Kas::where('jenis', 'pengeluaran')->sum('jumlah');

    // Hitung total kas
    $totalKas = $saldoAwalKas + $totalPemasukanManual - $totalPengeluaranManual;

    // Ambil riwayat kas
    $riwayatKas = \App\Models\Kas::orderBy('created_at', 'desc')->paginate(10);

    return view('admin.kas.riwayat', compact('totalKas', 'riwayatKas'));
}

}
