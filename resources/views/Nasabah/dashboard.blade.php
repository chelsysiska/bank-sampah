@extends('layouts.app')

@section('title', 'Dashboard Nasabah')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">👤 Dashboard Nasabah</h1>

    <p class="mb-4">Selamat datang, {{ auth()->user()->name }}!</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Total Setoran Anda</h2>
            <p class="text-3xl font-bold mt-2">{{ $count }}</p>
        </div>

        <div class="bg-purple-500 text-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Saldo Tabungan</h2>
            <p class="text-3xl font-bold mt-2">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Opsional: Tampilkan rekap bulanan/tahunan -->
    @if($bulanan->count() > 0)
    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">Rekap Bulanan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Bulan</th>
                        <th class="px-4 py-2">Berat (kg)</th>
                        <th class="px-4 py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bulanan as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ \Carbon\Carbon::create($item->tahun, $item->bulan)->format('F Y') }}</td>
                        <td class="px-4 py-2">{{ number_format($item->total_berat, 2) }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($item->total_hasil, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection