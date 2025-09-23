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
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
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
        // Ganti rute yang salah
        Route::get('/dashboard', [NasabahController::class, 'index'])->name('dashboard');
        Route::get('/riwayat', [NasabahController::class, 'riwayat'])->name('riwayat');
    });

    // Rute untuk Petugas
    Route::prefix('petugas')->middleware('role:petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
        
        // Menggunakan Route::resource untuk mengelola rute setoran
        Route::resource('setoran', SetoranController::class)->only(['index', 'create', 'store']);

        // Rute lain yang tidak termasuk resource
        Route::get('/kelola-sampah', [KelolaSampahController::class, 'index'])->name('sampah.index');
        Route::post('/laporan/kirim', [PetugasController::class, 'kirimLaporan'])->name('laporan.kirim');
    });

    // Rute untuk Admin
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/setoran', [SetoranAdminController::class, 'index'])->name('setoran.index');
        Route::get('/nasabah', [NasabahAdminController::class, 'index'])->name('nasabah.index');
        
        // Perbaiki pemanggilan controller untuk rute kontribusi
        Route::get('/nasabah/{nasabah}/kontribusi', [NasabahAdminController::class, 'contribution'])->name('nasabah.contribution');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';