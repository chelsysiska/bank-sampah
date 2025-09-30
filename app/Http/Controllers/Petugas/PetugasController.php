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
        // Hitung total setoran, berat, harga
        $totalSetoran = Setoran::where('petugas_id', Auth::id())->count();
        $totalBerat = Setoran::where('petugas_id', Auth::id())->sum('berat');
        $totalHarga = Setoran::where('petugas_id', Auth::id())->sum('total_harga');

        // Ambil 3 aktivitas terbaru (setoran terakhir)
        $aktivitas = Setoran::with(['nasabah', 'jenisSampah'])
            ->where('petugas_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('petugas.dashboard', [
            'totalSetoran' => $totalSetoran,
            'totalBerat' => $totalBerat,
            'totalHarga' => $totalHarga,
            'aktivitas' => $aktivitas,
        ]);
    }

    // Form input setoran
    public function createSetoran()
    {
        $nasabahs = User::where('role', 'nasabah')->get();
        $jenis = JenisSampah::all();

        return view('petugas.setoran.create', compact('nasabahs', 'jenis'));
    }

    // Simpan data setoran
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

        // Simpan data setoran
        Setoran::create([
            'nasabah_id' => $request->nasabah_id,
            'petugas_id' => Auth::id(),
            'tanggal_setoran' => $request->tanggal_setoran,
            'jenis_sampah_id' => $request->jenis_sampah_id,
            'berat' => $request->berat,
            'harga_per_kilo' => $jenis->harga_per_kilo,
            'total_harga' => $total_harga,
            'is_reported' => false,
        ]);

        // Update saldo nasabah
        $nasabah = User::find($request->nasabah_id);
        if ($nasabah) {
            $nasabah->saldo += $total_harga;
            $nasabah->save();
        }

        return redirect()->route('petugas.dashboard')
            ->with('success', 'Setoran berhasil disimpan! Aktivitas terbaru sudah tercatat.');
    }

    // Daftar setoran
    public function indexSetoran()
    {
        $setorans = Setoran::with(['nasabah', 'jenisSampah'])
            ->where('petugas_id', Auth::id())
            ->orderBy('tanggal_setoran', 'desc')
            ->paginate(20);

        return view('petugas.setoran.index', compact('setorans'));
    }

    // Kirim laporan bulanan ke admin
    public function kirimLaporan(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $setoransBelumDilaporkan = Setoran::where('petugas_id', Auth::id())
            ->where('is_reported', false)
            ->whereMonth('tanggal_setoran', $currentMonth)
            ->whereYear('tanggal_setoran', $currentYear)
            ->get();

        if ($setoransBelumDilaporkan->isEmpty()) {
            return back()->with('error',
                'Tidak ada setoran bulan ' . Carbon::now()->translatedFormat('F Y') . ' yang belum dilaporkan.'
            );
        }

        $jumlahSetoran = $setoransBelumDilaporkan->count();
        $totalBerat = $setoransBelumDilaporkan->sum('berat');
        $totalHarga = $setoransBelumDilaporkan->sum('total_harga');

        $laporanSudahDikirim = Laporan::where('bulan', $currentMonth)
            ->where('tahun', $currentYear)
            ->where('petugas_id', Auth::id())
            ->exists();

        if ($laporanSudahDikirim) {
            Laporan::where('bulan', $currentMonth)
                ->where('tahun', $currentYear)
                ->where('petugas_id', Auth::id())
                ->update([
                    'jumlah_setoran' => $jumlahSetoran,
                    'total_berat' => $totalBerat,
                    'total_harga' => $totalHarga,
                ]);
        } else {
            Laporan::create([
                'bulan' => $currentMonth,
                'tahun' => $currentYear,
                'jumlah_setoran' => $jumlahSetoran,
                'total_berat' => $totalBerat,
                'total_harga' => $totalHarga,
                'petugas_id' => Auth::id(),
            ]);
        }

        Setoran::where('petugas_id', Auth::id())
            ->where('is_reported', false)
            ->whereMonth('tanggal_setoran', $currentMonth)
            ->whereYear('tanggal_setoran', $currentYear)
            ->update(['is_reported' => true]);

        return back()->with('success',
            'Laporan bulan ' . Carbon::now()->translatedFormat('F Y') . ' berhasil dikirim ke Admin! ' .
            $jumlahSetoran . ' setoran telah dilaporkan.'
        );
    }
}
