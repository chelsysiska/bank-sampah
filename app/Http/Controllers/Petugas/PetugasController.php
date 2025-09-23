<?php


namespace App\Http\Controllers\Petugas;


use App\Http\Controllers\Controller;
use App\Models\Setoran;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Carbon\Carbon;


class PetugasController extends Controller
{
public function dashboard()
    {
        // Hitung total setoran
        $totalSetoran = Setoran::count();
        
        // Hitung total berat
        $totalBerat = Setoran::sum('berat');
        
        // Hitung total harga dari semua setoran
        // Mengubah dari total poin menjadi total harga
        $totalHarga = Setoran::sum('total_harga');

        return view('petugas.dashboard', [
            'totalSetoran' => $totalSetoran,
            'totalBerat' => $totalBerat,
            'totalHarga' => $totalHarga // Mengirimkan variabel baru
        ]);
    }


public function kirimLaporan(Request $request)
    {
        // Mendapatkan bulan dan tahun dari request (dari form)
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Cek apakah laporan untuk bulan dan tahun ini sudah dikirim
        $laporanSudahDikirim = Laporan::where('bulan', $bulan)
                                     ->where('tahun', $tahun)
                                     ->where('petugas_id', auth()->id())
                                     ->exists();
        
        if ($laporanSudahDikirim) {
            return redirect()->back()->with('error', 'Laporan bulan ini sudah dikirim sebelumnya!');
        }

        // Ambil data setoran untuk bulan dan tahun yang dipilih
        $setoranBulanIni = Setoran::whereYear('tanggal_setoran', $tahun)
                                  ->whereMonth('tanggal_setoran', $bulan)
                                  ->get();

        if ($setoranBulanIni->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data setoran untuk bulan ini.');
        }

        // Hitung total rekapitulasi
        $jumlahSetoran = $setoranBulanIni->count();
        $totalBerat = $setoranBulanIni->sum('berat');
        $totalHarga = $setoranBulanIni->sum('total_harga');

        // Simpan laporan ke tabel laporans
        Laporan::create([
            'bulan' => $bulan,
            'tahun' => $tahun,
            'jumlah_setoran' => $jumlahSetoran,
            'total_berat' => $totalBerat,
            'total_harga' => $totalHarga,
            'petugas_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Laporan bulanan berhasil dikirim ke Admin!');
    }
}