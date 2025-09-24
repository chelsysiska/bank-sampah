<?php

use App\Http\Controllers\Petugas\SetoranController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Controllers\Petugas\KelolaSampahController;
use App\Http\Controllers\Nasabah\NasabahController;
use App\Http\Controllers\Admin\SetoranAdminController;
use App\Http\Controllers\Admin\NasabahAdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Rute redirect dashboard sesuai role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) return redirect()->route('admin.dashboard');
        if ($user->isPetugas()) return redirect()->route('petugas.dashboard');
        return redirect()->route('nasabah.dashboard');
    })->name('dashboard');

    // Rute untuk Nasabah
    Route::prefix('nasabah')->middleware('role:nasabah')->name('nasabah.')->group(function () {
        Route::get('/dashboard', [NasabahController::class, 'index'])->name('dashboard');
        Route::get('/riwayat', [NasabahController::class, 'riwayat'])->name('riwayat');
    });

    // Rute untuk Petugas
    Route::prefix('petugas')->middleware('role:petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
        
        // Rute untuk setoran
        Route::get('/setoran', [PetugasController::class, 'indexSetoran'])->name('setoran.index');
        Route::get('/setoran/create', [PetugasController::class, 'createSetoran'])->name('setoran.create');
        Route::post('/setoran', [PetugasController::class, 'storeSetoran'])->name('setoran.store');

        // Rute untuk Kelola Sampah
        Route::get('/kelola-sampah', [KelolaSampahController::class, 'index'])->name('sampah.index');
        
        // Rute baru untuk mengirim laporan
        Route::post('/laporan/kirim', [PetugasController::class, 'kirimLaporan'])->name('laporan.kirim');
    });

    // Rute untuk Admin
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/setoran', [SetoranAdminController::class, 'index'])->name('setoran.index');
        Route::get('/nasabah', [NasabahAdminController::class, 'index'])->name('nasabah.index');
        Route::get('/nasabah/{nasabah}/kontribusi', [NasabahAdminController::class, 'contribution'])->name('nasabah.contribution');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';