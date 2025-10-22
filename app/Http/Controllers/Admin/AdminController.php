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
        ->whereYear('tanggal_setoran', $tahunDipilih)
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

        // === CEK APAKAH LAPORAN BULAN INI SUDAH DIKIRIM ===
        $laporanTerkirim = Laporan::where('bulan', now()->month)
            ->where('tahun', now()->year)
            ->exists();

        // === PERHITUNGAN TOTAL KAS HANYA AKTIF JIKA LAPORAN SUDAH DIKIRIM ===
        if ($laporanTerkirim) {
            // Hanya ambil setoran dan kas untuk bulan & tahun laporan yang sudah dikirim
            $totalPendapatanBulanIni = Setoran::whereMonth('tanggal_setoran', now()->month)
                ->whereYear('tanggal_setoran', now()->year)
                ->sum('total_harga');

            $totalPemasukanManual = Kas::where('jenis', 'pemasukan')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('jumlah');

            $totalPengeluaranManual = Kas::where('jenis', 'pengeluaran')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('jumlah');

            // ✅ Kas hanya dihitung dari kas manual, tidak ditambah pendapatan setoran
            $totalKas = $totalPemasukanManual - $totalPengeluaranManual;

            // Card “Total Pendapatan Semua Nasabah” hanya menampilkan data bulan laporan
            $totalPendapatanSemuaNasabah = $totalPendapatanBulanIni;
        } else {
            // jika laporan belum dikirim → nol semua
            $totalKas = 0;
            $totalPendapatanSemuaNasabah = 0;
        }

        /**
         * 🔄 TAMBAHAN: total pendapatan semua nasabah akumulatif dari semua laporan yang sudah dikirim
         * totalKas tetap dari kas manual saja, tidak dijumlahkan dengan pendapatan.
         */
        $laporanSelesai = Laporan::whereNotNull('bulan')
            ->whereNotNull('tahun')
            ->get();

        if ($laporanSelesai->count() > 0) {
            // Total pendapatan semua nasabah = semua setoran dari laporan yang pernah dikirim
            $totalPendapatanSemuaNasabah = Setoran::where(function ($query) use ($laporanSelesai) {
                foreach ($laporanSelesai as $laporan) {
                    $query->orWhere(function ($q) use ($laporan) {
                        $q->whereMonth('tanggal_setoran', $laporan->bulan)
                          ->whereYear('tanggal_setoran', $laporan->tahun);
                    });
                }
            })->sum('total_harga');

            // ✅ Kas tetap dari tabel Kas (pemasukan - pengeluaran)
            $totalPemasukanManual = Kas::where('jenis', 'pemasukan')->sum('jumlah');
            $totalPengeluaranManual = Kas::where('jenis', 'pengeluaran')->sum('jumlah');
            $totalKas = $totalPemasukanManual - $totalPengeluaranManual;
        }

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
            'riwayatKas',
            'laporanTerkirim'
        ));
    }

    public function riwayatKas(Request $request)
    {
        // Ambil input filter TANPA default otomatis
        $bulanDipilih = $request->get('bulan');
        $tahunDipilih = $request->get('tahun');

        // ✅ saldo kas dihitung dari tabel Kas saja (tidak ditambah pendapatan setoran)
        $totalPemasukanManual = \App\Models\Kas::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaranManual = \App\Models\Kas::where('jenis', 'pengeluaran')->sum('jumlah');

        // Hitung total kas bersih
        $totalKas = $totalPemasukanManual - $totalPengeluaranManual;

        // Ambil daftar tahun unik dari tabel kas
        $tahunList = \App\Models\Kas::selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Ambil data riwayat kas sesuai filter bulan & tahun
        $riwayatKas = \App\Models\Kas::when($bulanDipilih, function ($query) use ($bulanDipilih) {
                $query->whereMonth('created_at', $bulanDipilih);
            })
            ->when($tahunDipilih, function ($query) use ($tahunDipilih) {
                $query->whereYear('created_at', $tahunDipilih);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.kas.riwayat', compact(
            'totalKas',
            'riwayatKas',
            'bulanDipilih',
            'tahunDipilih',
            'tahunList'
        ));
    }
}
