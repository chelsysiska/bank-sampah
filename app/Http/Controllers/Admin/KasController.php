<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kas;
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

        $data = $request->only(['jumlah', 'keterangan', 'jenis']);

        // karena sudah required, pasti ada file
        $data['dokumentasi'] = $request->file('dokumentasi')->store('kas', 'public');

        Kas::create($data);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Transaksi kas berhasil dicatat!');
    }
}
