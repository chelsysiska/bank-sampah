<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setoran;
use Carbon\Carbon;

class SetoranAdminController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter dari request
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Query dasar
        $query = Setoran::with(['nasabah', 'jenisSampah'])
            ->where('is_reported', true)
            ->orderBy('tanggal_setoran', 'desc');

        // Jika ada filter bulan
        if ($bulan) {
            $query->whereMonth('tanggal_setoran', $bulan);
        }

        // Jika ada filter tahun
        if ($tahun) {
            $query->whereYear('tanggal_setoran', $tahun);
        }

        // Ambil hasil query
        $setorans = $query->get();

        // Grouping per bulan-tahun (Y-m)
        $setoransGroupedByMonth = $setorans->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_setoran)->format('Y-m');
        });

        // Ambil semua tahun unik untuk dropdown filter
        $availableYears = Setoran::selectRaw('YEAR(tanggal_setoran) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Kirim semua variabel ke view
        return view('admin.setoran.index', compact(
            'setoransGroupedByMonth',
            'bulan',
            'tahun',
            'availableYears'
        ));
    }
}
