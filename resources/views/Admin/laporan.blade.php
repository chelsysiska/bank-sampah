@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">📑 Laporan Setoran</h1>

    <form method="GET" class="mb-4">
        <select name="bulan" class="border rounded">
            <option value="">--Bulan--</option>
            @for($m=1;$m<=12;$m++)
                <option value="{{ $m }}" {{ request('bulan')==$m?'selected':'' }}>{{ $m }}</option>
            @endfor
        </select>
        <select name="tahun" class="border rounded">
            <option value="">--Tahun--</option>
            @for($y=date('Y');$y>=2020;$y--)
                <option value="{{ $y }}" {{ request('tahun')==$y?'selected':'' }}>{{ $y }}</option>
            @endfor
        </select>
        <button class="bg-blue-500 text-white px-3 py-1 rounded">Filter</button>
    </form>

    <p>Total: <b>Rp{{ number_format($total) }}</b></p>

    <table class="w-full border mt-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-2 py-1">Tanggal</th>
                <th class="px-2 py-1">Nasabah</th>
                <th class="px-2 py-1">Jenis</th>
                <th class="px-2 py-1">Berat</th>
                <th class="px-2 py-1">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($setoran as $s)
            <tr>
                <td class="border px-2 py-1">{{ $s->tanggal_setoran }}</td>
                <td class="border px-2 py-1">{{ $s->nasabah->name }}</td>
                <td class="border px-2 py-1">{{ $s->jenisSampah->nama }}</td>
                <td class="border px-2 py-1">{{ $s->berat }}</td>
                <td class="border px-2 py-1">Rp{{ number_format($s->total) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
