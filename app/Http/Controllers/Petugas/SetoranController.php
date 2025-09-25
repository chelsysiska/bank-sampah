<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setoran;
use App\Models\JenisSampah;
use App\Models\User;

class SetoranController extends Controller
{
    // Halaman untuk menampilkan daftar setoran
    public function index()
    {
        $setorans = Setoran::with(['nasabah', 'jenisSampah'])
                    ->orderBy('tanggal_setoran', 'desc')
                    ->get();

        return view('petugas.setoran.index', compact('setorans'));
    }

    // Halaman untuk menampilkan form input setoran
    public function create()
    {
        $nasabahs = User::where('role', 'nasabah')->get();
        $jenis = JenisSampah::all();

        return view('petugas.setoran.create', compact('nasabahs', 'jenis'));
    }

    // Proses menyimpan setoran baru
    public function store(Request $request)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:users,id',
            'jenis_sampah_id' => 'required|exists:jenis_sampah,id',
            'tanggal_setoran' => 'required|date',
            'berat' => 'required|numeric|min:0.01'
        ]);

        $jenis = JenisSampah::findOrFail($request->jenis_sampah_id);
        $total_harga = $jenis->harga_per_kilo * $request->berat;

        Setoran::create([
            'nasabah_id' => $request->nasabah_id,
            'jenis_sampah_id' => $request->jenis_sampah_id,
            'tanggal_setoran' => $request->tanggal_setoran,
            'berat' => $request->berat,
            'harga_per_kilo' => $jenis->harga_per_kilo,
            'total_harga' => $total_harga,
            'petugas_id' => auth()->id(),
        ]);
        
        // Perbarui total saldo nasabah setelah setoran
        $nasabah = User::find($request->nasabah_id);
        if ($nasabah) {
            $nasabah->saldo += $total_harga;
            $nasabah->save();
        }

        return redirect()->route('petugas.setoran.index')->with('success', 'Setoran berhasil disimpan!');
    }
}