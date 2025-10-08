<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kas;
use App\Models\Setoran; // ✅ ditambahkan untuk hitung saldo dari setoran
use Illuminate\Support\Facades\Storage;

class KasController extends Controller
{
    public function create(Request $request)
    {
        $jenis = $request->query('jenis');
        if (!in_array($jenis, ['pemasukan', 'pengeluaran'])) {
            abort(400, 'Jenis kas tidak valid');
        }
        return view('admin.kas.form', compact('jenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:500',
            'dokumentasi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // ✅ wajib diisi
            'jenis' => 'required|in:pemasukan,pengeluaran', // ✅ validasi jenis juga
        ]);

        // ✅ Hitung total kas yang tersedia
        $totalPendapatanNasabah = Setoran::sum('total_harga');
        $totalPemasukanLuar = Kas::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Kas::where('jenis', 'pengeluaran')->sum('jumlah');
        $totalKas = $totalPendapatanNasabah + $totalPemasukanLuar - $totalPengeluaran;

        // 🔒 Cek jika pengeluaran melebihi total kas
        if ($request->jenis === 'pengeluaran' && $request->jumlah > $totalKas) {
            return back()->with('error', 'Jumlah pengeluaran tidak boleh melebihi total kas yang tersedia!')
                         ->withInput();
        }

        $data = $request->only(['jumlah', 'keterangan', 'jenis']);

        // karena sudah required, pasti ada file
        $data['dokumentasi'] = $request->file('dokumentasi')->store('kas', 'public');

        Kas::create($data);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Transaksi kas berhasil dicatat!');
    }
}
