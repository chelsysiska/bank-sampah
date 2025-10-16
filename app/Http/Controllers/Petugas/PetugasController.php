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
        $petugasId = Auth::id();
        $bulanSekarang = now()->month;
        $tahunSekarang = now()->year;

        // ✅ Total setoran bulan ini (hanya milik petugas ini)
        $totalSetoran = Setoran::where('petugas_id', $petugasId)
            ->whereMonth('tanggal_setoran', $bulanSekarang)
            ->whereYear('tanggal_setoran', $tahunSekarang)
            ->count();

        // ✅ Total berat & harga semua setoran petugas ini
        $totalBerat = Setoran::where('petugas_id', $petugasId)->sum('berat');
        $totalHarga = Setoran::where('petugas_id', $petugasId)->sum('total_harga');

        // ✅ Hitung kas global (hindari double-count)
        $totalPemasukan = Kas::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Kas::where('jenis', 'pengeluaran')->sum('jumlah');
        $totalKas = $totalPemasukan - $totalPengeluaran;

        // ✅ Aktivitas terbaru
        $aktivitas = Setoran::with(['nasabah', 'jenisSampah'])
            ->where('petugas_id', $petugasId)
            ->latest()
            ->take(3)
            ->get();

        return view('petugas.dashboard', compact(
            'totalSetoran', 'totalBerat', 'totalHarga', 'aktivitas', 'totalKas'
        ));
    }

    public function createSetoran()
    {
        $nasabahs = User::where('role', 'nasabah')->get();
        $jenis = JenisSampah::all();
        return view('petugas.setoran.create', compact('nasabahs', 'jenis'));
    }

    public function storeSetoran(Request $request)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:users,id',
            'tanggal_setoran' => 'required|date',
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'berat' => 'required|numeric|min:0.01',
        ]);

        $tanggalSetoran = Carbon::parse($request->tanggal_setoran);
        if ($tanggalSetoran->isAfter(Carbon::today())) {
            return back()->with('error', 'Tanggal setoran tidak boleh lebih dari hari ini!')->withInput();
        }

        $jenis = JenisSampah::findOrFail($request->jenis_sampah_id);
        $total_harga = $jenis->harga_per_kilo * $request->berat;

        $setoran = Setoran::create([
            'nasabah_id' => $request->nasabah_id,
            'petugas_id' => Auth::id(),
            'tanggal_setoran' => $request->tanggal_setoran,
            'jenis_sampah_id' => $request->jenis_sampah_id,
            'berat' => $request->berat,
            'harga_per_kilo' => $jenis->harga_per_kilo,
            'total_harga' => $total_harga,
            'is_reported' => false,
        ]);

        // ✅ Update saldo nasabah
        $nasabah = User::find($request->nasabah_id);
        if ($nasabah) {
            $nasabah->saldo += $total_harga;
            $nasabah->save();
        }

        return redirect()->route('petugas.dashboard')->with('success', 'Setoran berhasil disimpan!');
    }

    public function indexSetoran(Request $request)
    {
        $petugasId = Auth::id();

        $query = Setoran::with(['nasabah', 'jenisSampah'])
            ->where('petugas_id', $petugasId)
            ->orderBy('tanggal_setoran', 'desc');

        // ✅ Filter bulan & tahun
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_setoran', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_setoran', $request->tahun);
        }

        $setorans = $query->paginate(20)->withQueryString();

        // ✅ Laporan bulan ini & sebelumnya
        $bulan = now()->month;
        $tahun = now()->year;

        $laporanBulanIni = Laporan::where('petugas_id', $petugasId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        $laporanSebelumnya = Laporan::where('petugas_id', $petugasId)
            ->where(function ($q) use ($bulan, $tahun) {
                $q->where('tahun', '<', $tahun)
                    ->orWhere(function ($q2) use ($bulan, $tahun) {
                        $q2->where('tahun', $tahun)->where('bulan', '<', $bulan);
                    });
            })
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->take(6)
            ->get();

        return view('petugas.setoran.index', compact('setorans', 'laporanBulanIni', 'laporanSebelumnya'));
    }

    public function destroySetoran($id)
    {
        $setoran = Setoran::where('id', $id)
            ->where('petugas_id', Auth::id())
            ->firstOrFail();

        if ($setoran->is_reported) {
            return back()->with('error', 'Setoran yang sudah dilaporkan tidak bisa dihapus.');
        }

        $nasabah = $setoran->nasabah;
        if ($nasabah) {
            $nasabah->saldo = max(0, $nasabah->saldo - $setoran->total_harga);
            $nasabah->save();
        }

        $setoran->delete();
        return back()->with('success', 'Setoran berhasil dihapus.');
    }

    public function kirimLaporan(Request $request)
{
    // ✅ Wajib unggah bukti setiap kali kirim laporan
    $request->validate([
        'bukti' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ], [
        'bukti.required' => 'File bukti laporan wajib diunggah setiap kali mengirim laporan.',
        'bukti.mimes' => 'Bukti laporan harus berupa file JPG, JPEG, PNG, atau PDF.',
        'bukti.max' => 'Ukuran file bukti maksimal 2MB.',
    ]);

    $petugasId = Auth::id();

    // ✅ Ambil semua setoran belum dilaporkan
    $setoransBelumDilaporkan = Setoran::where('petugas_id', $petugasId)
        ->where('is_reported', false)
        ->orderBy('tanggal_setoran')
        ->get();

    if ($setoransBelumDilaporkan->isEmpty()) {
        return back()->with('error', 'Tidak ada setoran baru yang perlu dilaporkan.');
    }

    // ✅ Ambil bulan & tahun dari setoran pertama
    $firstSetoran = $setoransBelumDilaporkan->first();
    $bulanLaporan = Carbon::parse($firstSetoran->tanggal_setoran)->month;
    $tahunLaporan = Carbon::parse($firstSetoran->tanggal_setoran)->year;

    // ✅ Cek apakah laporan bulan itu sudah ada
    $laporan = Laporan::where('bulan', $bulanLaporan)
        ->where('tahun', $tahunLaporan)
        ->where('petugas_id', $petugasId)
        ->first();

    // ✅ Simpan file baru (selalu wajib upload)
    $buktiPath = $request->file('bukti')->store('bukti_laporan', 'public');

    // ✅ Hitung ulang jumlah total dari setoran baru
    $jumlahSetoran = $setoransBelumDilaporkan->count();
    $totalBerat = $setoransBelumDilaporkan->sum('berat');
    $totalHarga = $setoransBelumDilaporkan->sum('total_harga');

    if (!$laporan) {
        // Jika laporan belum ada → buat baru
        $laporan = Laporan::create([
            'bulan' => $bulanLaporan,
            'tahun' => $tahunLaporan,
            'jumlah_setoran' => $jumlahSetoran,
            'total_berat' => $totalBerat,
            'total_harga' => $totalHarga,
            'petugas_id' => $petugasId,
            'bukti' => $buktiPath,
        ]);
    } else {
        // Jika laporan sudah ada → update total & bukti baru
        $laporan->update([
            'jumlah_setoran' => $laporan->jumlah_setoran + $jumlahSetoran,
            'total_berat' => $laporan->total_berat + $totalBerat,
            'total_harga' => $laporan->total_harga + $totalHarga,
            'bukti' => $buktiPath, // ⚠️ selalu ganti dengan bukti baru
        ]);
    }

    // ✅ Catat ke tabel kas sesuai bulan laporan
    Kas::create([
        'jenis' => 'pemasukan',
        'jumlah' => $totalHarga,
        'keterangan' => 'Setoran bank sampah bulan ' . Carbon::create()->month($bulanLaporan)->translatedFormat('F') . ' ' . $tahunLaporan,
        'dokumentasi' => $buktiPath,
        'created_at' => Carbon::create($tahunLaporan, $bulanLaporan, 1),
    ]);

    // ✅ Tandai setoran sudah dilaporkan
    Setoran::where('petugas_id', $petugasId)
        ->where('is_reported', false)
        ->update(['is_reported' => true]);

    return back()->with('success', 'Laporan bulan ' . Carbon::create()->month($bulanLaporan)->translatedFormat('F') . ' berhasil dikirim dengan bukti baru!');
}

    public function riwayatKas(Request $request)
    {
        $query = Kas::query();

        // ✅ Filter bulan & tahun
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $riwayatKas = $query->latest()->paginate(10)->withQueryString();

        $totalPemasukan = Kas::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Kas::where('jenis', 'pengeluaran')->sum('jumlah');
        $totalKas = $totalPemasukan - $totalPengeluaran;

        return view('petugas.kas.riwayat', compact('riwayatKas', 'totalKas'));
    }
}
