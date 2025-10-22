<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\Setoran;
use App\Models\Kas;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NasabahController extends Controller
{
    public function index()
    {
        $nasabah = Auth::user();

        $riwayatSetoran = $nasabah->setoransAsNasabah()
                                  ->with('jenisSampah', 'petugas')
                                  ->orderBy('tanggal_setoran', 'desc')
                                  ->paginate(5);

        // ✅ Tambahan perbaikan di bawah ini (tidak menghapus kodenya)
        // Pastikan data setoran yang disimpan oleh petugas langsung terbaca
        // tanpa menunggu laporan dikirim ke admin
        $nasabah->load(['setoransAsNasabah' => function ($q) {
            $q->latest();
        }]);

        // ✅ Hitung ulang total pendapatan pribadi langsung dari data terbaru
        $totalPendapatanPribadi = $nasabah->setoransAsNasabah()
                                          ->sum('total_harga');

        $totalPendapatanSemuaNasabah = Setoran::sum('total_harga');

        $totalPemasukanLuar = Kas::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Kas::where('jenis', 'pengeluaran')->sum('jumlah');

        $laporanTerkirim = Laporan::where('bulan', now()->month)
            ->where('tahun', now()->year)
            ->exists();

        if ($laporanTerkirim) {
            $totalKas = $totalPemasukanLuar - $totalPengeluaran;
        } else {
            $totalKas = 0;
        }

        if ($laporanTerkirim) {
            $totalKas = $totalPemasukanLuar - $totalPengeluaran;
        }

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
            'totalKas' => $totalKas,
            'laporanTerkirim' => $laporanTerkirim,
            'bulanan' => $bulanan,
        ]);
    }

    public function riwayat(Request $request)
    {
        $query = Auth::user()->setoransAsNasabah()
                             ->with('jenisSampah', 'petugas')
                             ->orderBy('tanggal_setoran', 'desc');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_setoran', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_setoran', $request->tahun);
        }

        $riwayatSetoran = $query->paginate(10);

        return view('nasabah.riwayat', [
            'riwayatSetoran' => $riwayatSetoran,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ]);
    }

    public function riwayatKas(Request $request)
{
    $query = Kas::query()->with('petugas'); // ✅ tambahkan relasi petugas agar langsung ikut diambil

    if ($request->filled('bulan')) {
        $query->whereMonth('created_at', $request->bulan);
    }

    if ($request->filled('tahun')) {
        $query->whereYear('created_at', $request->tahun);
    }

    $riwayatKas = $query->latest()->paginate(10);

    // ✅ Ambil laporan dan petugas secara aman
    $laporanPerBulan = \App\Models\Laporan::with('petugas')
        ->get()
        ->keyBy(function ($item) {
            return $item->bulan . '-' . $item->tahun;
        });

    foreach ($riwayatKas as $kas) {
        $bulan = date('n', strtotime($kas->created_at));
        $tahun = date('Y', strtotime($kas->created_at));
        $key = $bulan . '-' . $tahun;

        if (isset($laporanPerBulan[$key])) {
            // ✅ Pastikan petugas-nya memang ada
            $petugas = $laporanPerBulan[$key]->petugas;
            if ($petugas && isset($petugas->nama)) {
                $kas->petugas_nama = $petugas->nama;
            } else {
                $kas->petugas_nama = 'Petugas tidak terdaftar';
            }
        } 
        // ✅ Tambahan logika jika laporanPerBulan tidak ada tapi kas punya petugas langsung
        elseif ($kas->petugas) {
    // ✅ Tambahan pengecekan jika kolom yang ada di tabel user adalah "name" bukan "nama"
    $kas->petugas_nama = $kas->petugas->name 
        ?? $kas->petugas->nama 
        ?? $kas->petugas->nama_petugas 
        ?? 'Petugas tidak terdaftar';
}
        else {
            $kas->petugas_nama = '-';
        }
    }

    return view('nasabah.kas.riwayat', compact('riwayatKas'));
}

}
