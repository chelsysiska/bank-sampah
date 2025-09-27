<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Setoran;
use App\Models\Laporan;
use App\Models\User;
use App\Models\JenisSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PetugasController extends Controller
{
    public function dashboard()
    {
        // Hitung total setoran bulan ini untuk petugas yang login
        $totalSetoran = Setoran::where('petugas_id', Auth::id())->count();
        
        // Hitung total berat bulan ini
        $totalBerat = Setoran::where('petugas_id', Auth::id())->sum('berat');
        
        // Hitung total harga dari semua setoran bulan ini
        $totalHarga = Setoran::where('petugas_id', Auth::id())->sum('total_harga');

        return view('petugas.dashboard', [
            'totalSetoran' => $totalSetoran,
            'totalBerat' => $totalBerat,
            'totalHarga' => $totalHarga
        ]);
    }

    // Metode untuk menampilkan form input setoran
    public function createSetoran()
    {
        $nasabahs = User::where('role', 'nasabah')->get();
        $jenis = JenisSampah::all();

        return view('petugas.setoran.create', compact('nasabahs', 'jenis'));
    }

    // Metode untuk menyimpan data setoran
    public function storeSetoran(Request $request)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:users,id',
            'tanggal_setoran' => 'required|date',
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'berat' => 'required|numeric|min:0.01',
        ]);

        $jenis = JenisSampah::findOrFail($request->jenis_sampah_id);
        $total_harga = $jenis->harga_per_kilo * $request->berat;

        // Simpan data setoran ke database dengan status belum dilaporkan
        Setoran::create([
            'nasabah_id' => $request->nasabah_id,
            'petugas_id' => Auth::id(),
            'tanggal_setoran' => $request->tanggal_setoran,
            'jenis_sampah_id' => $request->jenis_sampah_id,
            'berat' => $request->berat,
            'harga_per_kilo' => $jenis->harga_per_kilo,
            'total_harga' => $total_harga,
            'is_reported' => false, // Set status awal ke false
        ]);

        // Update saldo nasabah
        $nasabah = User::find($request->nasabah_id);
        if ($nasabah) {
            $nasabah->saldo += $total_harga;
            $nasabah->save();
        }

        return redirect()->route('petugas.setoran.index')->with('success', 'Setoran berhasil disimpan! Saldo nasabah telah diperbarui.');
    }

    // Metode untuk menampilkan daftar setoran
    public function indexSetoran()
    {
        $setorans = Setoran::with(['nasabah', 'jenisSampah'])
                    ->where('petugas_id', Auth::id())
                    ->orderBy('tanggal_setoran', 'desc')
                    ->paginate(20);

        return view('petugas.setoran.index', compact('setorans'));
    }

    // Metode untuk mengirim laporan ke admin - PERBAIKAN BESAR
    public function kirimLaporan(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Ambil semua setoran yang belum dilaporkan oleh petugas yang login pada bulan BERJALAN
        $setoransBelumDilaporkan = Setoran::where('petugas_id', Auth::id())
            ->where('is_reported', false)
            ->whereMonth('tanggal_setoran', $currentMonth)
            ->whereYear('tanggal_setoran', $currentYear)
            ->get();
        
        // Jika tidak ada setoran bulan berjalan yang belum dilaporkan
        if ($setoransBelumDilaporkan->isEmpty()) {
            return back()->with('error', 
                'Tidak ada setoran bulan ' . Carbon::now()->translatedFormat('F Y') . ' yang belum dilaporkan.');
        }

        // Hitung total rekapitulasi dari setoran yang belum dilaporkan
        $jumlahSetoran = $setoransBelumDilaporkan->count();
        $totalBerat = $setoransBelumDilaporkan->sum('berat');
        $totalHarga = $setoransBelumDilaporkan->sum('total_harga');

        // Cek apakah laporan bulanan untuk bulan ini sudah ada
        $laporanSudahDikirim = Laporan::where('bulan', $currentMonth)
            ->where('tahun', $currentYear)
            ->where('petugas_id', Auth::id())
            ->exists();
        
        if ($laporanSudahDikirim) {
            // Jika sudah ada, update laporan yang ada
            Laporan::where('bulan', $currentMonth)
                ->where('tahun', $currentYear)
                ->where('petugas_id', Auth::id())
                ->update([
                    'jumlah_setoran' => $jumlahSetoran,
                    'total_berat' => $totalBerat,
                    'total_harga' => $totalHarga,
                ]);
        } else {
            // Jika belum ada, buat laporan baru
            Laporan::create([
                'bulan' => $currentMonth,
                'tahun' => $currentYear,
                'jumlah_setoran' => $jumlahSetoran,
                'total_berat' => $totalBerat,
                'total_harga' => $totalHarga,
                'petugas_id' => Auth::id(),
            ]);
        }
        
        // Tandai semua setoran bulan berjalan yang baru saja dilaporkan sebagai "sudah dilaporkan"
        Setoran::where('petugas_id', Auth::id())
            ->where('is_reported', false)
            ->whereMonth('tanggal_setoran', $currentMonth)
            ->whereYear('tanggal_setoran', $currentYear)
            ->update(['is_reported' => true]);

        return back()->with('success', 
            'Laporan bulan ' . Carbon::now()->translatedFormat('F Y') . ' berhasil dikirim ke Admin! ' . 
            $jumlahSetoran . ' setoran telah dilaporkan.');
    }
}