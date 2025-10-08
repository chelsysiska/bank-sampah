<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Setoran;
use App\Models\Laporan;
use App\Models\Kas;
use App\Models\User;
use App\Models\JenisSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PetugasController extends Controller
{
    public function dashboard()
    {
        // Hitung total setoran, berat, harga (khusus petugas ini)
        $totalSetoran = Setoran::where('petugas_id', Auth::id())->count();
        $totalBerat = Setoran::where('petugas_id', Auth::id())->sum('berat');
        $totalHarga = Setoran::where('petugas_id', Auth::id())->sum('total_harga');

        // 💰 Hitung total kas global (sama dengan admin & nasabah)
        $totalPendapatanNasabah = Setoran::sum('total_harga');
        $totalPemasukanLuar = Kas::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Kas::where('jenis', 'pengeluaran')->sum('jumlah');
        $totalKas = $totalPendapatanNasabah + $totalPemasukanLuar - $totalPengeluaran;

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
            'totalKas' => $totalKas, // ✅ tampilkan kas global
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

        // ✅ Validasi tambahan: tanggal tidak boleh di masa depan
        $tanggalSetoran = Carbon::parse($request->tanggal_setoran);
        if ($tanggalSetoran->isAfter(Carbon::today())) {
            return back()->with('error', 'Tanggal setoran tidak boleh lebih dari hari ini!')
                         ->withInput();
        }

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

    // Hapus setoran
public function destroySetoran($id)
{
    $setoran = Setoran::where('id', $id)
        ->where('petugas_id', Auth::id()) // hanya boleh hapus setoran miliknya
        ->firstOrFail();

    // Cegah hapus jika sudah dilaporkan
    if ($setoran->is_reported) {
        return back()->with('error', 'Setoran yang sudah dilaporkan tidak bisa dihapus.');
    }

    // Kembalikan saldo nasabah
    $nasabah = $setoran->nasabah;
    if ($nasabah) {
        $nasabah->saldo -= $setoran->total_harga;
        if ($nasabah->saldo < 0) $nasabah->saldo = 0; // jaga-jaga biar tidak minus
        $nasabah->save();
    }

    $setoran->delete();

    return back()->with('success', 'Setoran berhasil dihapus.');
}


    // Kirim laporan ke admin (semua setoran belum dilaporkan)
    public function kirimLaporan(Request $request)
    {
        $setoransBelumDilaporkan = Setoran::where('petugas_id', Auth::id())
            ->where('is_reported', false)
            ->get();

        if ($setoransBelumDilaporkan->isEmpty()) {
            return back()->with('error', 'Tidak ada setoran yang belum dilaporkan.');
        }

        $jumlahSetoran = $setoransBelumDilaporkan->count();
        $totalBerat = $setoransBelumDilaporkan->sum('berat');
        $totalHarga = $setoransBelumDilaporkan->sum('total_harga');

        // Simpan laporan dengan timestamp sekarang
        $laporan = Laporan::create([
            'bulan' => now()->month,
            'tahun' => now()->year,
            'jumlah_setoran' => $jumlahSetoran,
            'total_berat' => $totalBerat,
            'total_harga' => $totalHarga,
            'petugas_id' => Auth::id(),
        ]);

        // ✅ Tambahkan otomatis pemasukan kas bank sampah
        Kas::create([
            'jenis' => 'pemasukan',
            'jumlah' => $totalHarga,
            'keterangan' => 'Dari Bank Sampah',
            'dokumentasi' => null, // bisa diisi kalau mau upload bukti
        ]);

        // Update semua setoran yang baru dilaporkan → is_reported = true
        Setoran::where('petugas_id', Auth::id())
            ->where('is_reported', false)
            ->update(['is_reported' => true]);

        return back()->with('success',
            'Laporan berhasil dikirim ke Admin! ' . $jumlahSetoran . ' setoran sudah dilaporkan dan tercatat sebagai pemasukan kas bank sampah.'
        );
    }

    public function riwayatKas()
    {
        $riwayatKas = Kas::latest()->paginate(10);

        // 💰 Tambahkan juga total kas global di halaman kas petugas
        $totalPendapatanNasabah = Setoran::sum('total_harga');
        $totalPemasukanLuar = Kas::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Kas::where('jenis', 'pengeluaran')->sum('jumlah');
        $totalKas = $totalPendapatanNasabah + $totalPemasukanLuar - $totalPengeluaran;

        return view('petugas.kas.riwayat', [
            'riwayatKas' => $riwayatKas,
            'totalKas' => $totalKas, // ✅ tampilkan kas global di halaman kas
        ]);
    }
}
