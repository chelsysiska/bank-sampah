<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\JenisSampah; 
use Illuminate\Http\Request;

class KelolaSampahController extends Controller
{
    public function index()
    {
        $jenisSampah = JenisSampah::all();
        return view('petugas.kelola-sampah', compact('jenisSampah'));
    }

    public function create()
    {
        return view('petugas.form');
    }

    public function store(Request $request)
    {
        // ✅ tambahkan unique biar tidak duplikat
        $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_sampahs,nama',
            'harga_per_kilo' => 'required|numeric|min:0',
        ]);

        JenisSampah::create([
            'nama' => $request->nama,
            'harga_per_kilo' => $request->harga_per_kilo,
        ]);

        return redirect()->route('petugas.sampah.index')
                         ->with('success', 'Jenis sampah berhasil ditambahkan.');
    }

    public function edit(JenisSampah $sampah)
    {
        return view('petugas.form', ['jenisSampah' => $sampah]);
    }

    public function update(Request $request, JenisSampah $sampah)
    {
        // ✅ saat update, pengecekan unique dikecualikan untuk id yang sedang diedit
        $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_sampahs,nama,' . $sampah->id,
            'harga_per_kilo' => 'required|numeric|min:0',
        ]);

        $sampah->update([
            'nama' => $request->nama,
            'harga_per_kilo' => $request->harga_per_kilo,
        ]);

        return redirect()->route('petugas.sampah.index')
                         ->with('success', 'Jenis sampah berhasil diperbarui.');
    }

    public function destroy(JenisSampah $sampah)
    {
        $sampah->delete();
        return redirect()->route('petugas.sampah.index')
                         ->with('success', 'Jenis sampah berhasil dihapus.');
    }
}
