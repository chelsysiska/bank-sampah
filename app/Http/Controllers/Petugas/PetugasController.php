<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Setoran;
use App\Models\Laporan;
use App\Models\User; // Gunakan model User, karena data nasabah tersimpan di tabel users
use App\Models\JenisSampah; // Asumsi model JenisSampah ada
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
        // Ubah dari Nasabah::all() menjadi User::where('role', 'nasabah')->get()
        // Ini memastikan kita hanya mengambil pengguna dengan peran 'nasabah' dari tabel 'users'
        $nasabahs = User::where('role', 'nasabah')->get();
        $jenis = JenisSampah::all();

        return view('petugas.setoran.create', compact('nasabahs', 'jenis'));
    }

    // Metode untuk menyimpan data setoran
    public function storeSetoran(Request $request)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:users,id', // Ubah validasi agar merujuk ke tabel 'users'
            'tanggal_setoran' => 'required|date',
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'berat' => 'required|numeric|min:0.01',
            'total_harga' => 'required|numeric|min:0',
        ]);

        // Simpan data setoran ke database dengan status belum dilaporkan
        Setoran::create([
            'nasabah_id' => $request->nasabah_id,
            'petugas_id' => Auth::id(),
            'tanggal_setoran' => $request->tanggal_setoran,
            'jenis_sampah_id' => $request->jenis_sampah_id,
            'berat' => $request->berat,
            'harga_per_kilo' => JenisSampah::find($request->jenis_sampah_id)->harga_per_kilo,
            'total_harga' => $request->total_harga,
            'is_reported' => false, // Set status awal ke false
        ]);

        return redirect()->route('petugas.setoran.index')->with('success', 'Setoran berhasil disimpan dan menunggu dikirim ke Admin.');
    }

    // Metode untuk menampilkan daftar setoran
    public function indexSetoran()
    {
        $setorans = Setoran::where('petugas_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('petugas.setoran.index', compact('setorans'));
    }

    // Metode untuk mengirim laporan ke admin
    public function kirimLaporan(Request $request)
    {
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');

        // Ambil semua setoran yang belum dilaporkan oleh petugas yang login pada bulan ini
        $setoransBelumDilaporkan = Setoran::where('petugas_id', Auth::id())
            ->where('is_reported', false)
            ->whereMonth('tanggal_setoran', $bulan)
            ->whereYear('tanggal_setoran', $tahun)
            ->get();
        
        // Jika tidak ada setoran, kembalikan dengan pesan error
        if ($setoransBelumDilaporkan->isEmpty()) {
            return back()->with('error', 'Tidak ada setoran baru yang perlu dilaporkan untuk bulan ini.');
        }

        // Cek apakah laporan bulanan untuk bulan ini sudah ada
        $laporanSudahDikirim = Laporan::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('petugas_id', Auth::id())
            ->exists();
        
        if ($laporanSudahDikirim) {
            return back()->with('error', 'Laporan bulan ini sudah dikirim sebelumnya!');
        }

        // Hitung total rekapitulasi dari setoran yang belum dilaporkan
        $jumlahSetoran = $setoransBelumDilaporkan->count();
        $totalBerat = $setoransBelumDilaporkan->sum('berat');
        $totalHarga = $setoransBelumDilaporkan->sum('total_harga');

        // Simpan laporan ke tabel laporans
        Laporan::create([
            'bulan' => $bulan,
            'tahun' => $tahun,
            'jumlah_setoran' => $jumlahSetoran,
            'total_berat' => $totalBerat,
            'total_harga' => $totalHarga,
            'petugas_id' => Auth::id(),
        ]);
        
        // Tandai semua setoran yang baru saja dilaporkan sebagai "sudah dilaporkan"
        Setoran::whereIn('id', $setoransBelumDilaporkan->pluck('id'))
            ->update(['is_reported' => true]);

        return back()->with('success', 'Laporan bulanan berhasil dikirim ke Admin!');
    }
}
