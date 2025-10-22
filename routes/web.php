<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Controllers\Petugas\KelolaSampahController; 
use App\Http\Controllers\Nasabah\NasabahController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SetoranAdminController;
use App\Http\Controllers\Admin\AdminPetugasController;
use App\Http\Controllers\ProfileController;

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
        Route::get('/kas/riwayat', [NasabahController::class, 'riwayatKas'])->name('kas.riwayat'); // Ditambahkan
    });

    // Rute untuk Petugas
    Route::prefix('petugas')->middleware('role:petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
        
        // Rute untuk setoran
        Route::get('/setoran', [PetugasController::class, 'indexSetoran'])->name('setoran.index');
        Route::get('/setoran/create', [PetugasController::class, 'createSetoran'])->name('setoran.create');
        Route::post('/setoran', [PetugasController::class, 'storeSetoran'])->name('setoran.store');
        Route::delete('/setoran/{id}', [PetugasController::class, 'destroySetoran'])->name('setoran.destroy'); 

        // Rute untuk Kelola Sampah (CRUD) menggunakan Route::resource
        Route::resource('sampah', KelolaSampahController::class)->except(['show']);
        
        // Rute baru untuk mengirim laporan
        Route::post('/laporan/kirim', [PetugasController::class, 'kirimLaporan'])->name('laporan.kirim');

        Route::get('/kas/riwayat', [PetugasController::class, 'riwayatKas'])->name('kas.riwayat');
    });

    // Rute untuk Admin
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/setoran', [SetoranAdminController::class, 'index'])->name('setoran.index');
        Route::get('/nasabah', [NasabahAdminController::class, 'index'])->name('nasabah.index');
        Route::get('/nasabah/{nasabah}/kontribusi', [NasabahAdminController::class, 'contribution'])->name('nasabah.contribution');

        // Rute Kas
        Route::get('/kas/create', [App\Http\Controllers\Admin\KasController::class, 'create'])->name('kas.create');
        Route::post('/kas', [App\Http\Controllers\Admin\KasController::class, 'store'])->name('kas.store');

        Route::get('/kas/riwayat', [AdminController::class, 'riwayatKas'])->name('kas.riwayat');

       Route::resource('petugas', App\Http\Controllers\Admin\AdminPetugasController::class);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';