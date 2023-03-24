<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Operasi\DaftarTugasController;
use App\Http\Controllers\Operasi\KalenderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', [HomeController::class, 'root'])->name('root');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Auth::routes();
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::group(['prefix' => 'administrator', 'middleware' => ['auth']], function () {

    // Dashboard Admin
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    });

    // Profil
    Route::prefix('profil')->middleware('role:admin,mahasiswa,kepala')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('admin.profil');
        Route::get('/edit', [ProfilController::class, 'edit'])->name('admin.profil.edit');
        Route::post('/edit', [ProfilController::class, 'editProses'])->name('admin.profil.edit.proses');
        Route::get('/upload', [ProfilController::class, 'upload'])->name('admin.profil.upload');
        Route::post('/crop', [ProfilController::class, 'crop'])->name('admin.profil.crop');
    });
});

Route::group(['middleware' => ['auth']], function () {
    Route::prefix('operasi')->group(function () {
        // admin
        Route::prefix('daftar-tugas')->group(function () {
            Route::get('/', [DaftarTugasController::class, 'show'])->name('operasi.daftarTugas.show');
            Route::post('/tambah', [DaftarTugasController::class, 'tambah'])->name('operasi.daftarTugas.tambah');
            Route::post('/edit', [DaftarTugasController::class, 'edit'])->name('operasi.daftarTugas.edit');
            Route::get('/jumlah-halaman', [DaftarTugasController::class, 'jumlahHalaman'])->name('operasi.daftarTugas.jumlahHalaman');
            Route::get('/{offset}', [DaftarTugasController::class, 'daftarTugas'])->name('operasi.daftarTugas');
            Route::get('/{id}/edit/{status}', [DaftarTugasController::class, 'check'])->name('operasi.daftarTugas.check');
            Route::post('/{id}/hapus', [DaftarTugasController::class, 'hapus'])->name('operasi.daftarTugas.hapus');
        });

        Route::prefix('kalender')->group(function () {
            Route::get('/', [KalenderController::class, 'show'])->name('operasi.kalender');
            Route::post('/tambah', [KalenderController::class, 'tambah'])->name('operasi.kalender.tambah');
            Route::post('/{id}/edit', [KalenderController::class, 'edit'])->name('operasi.kalender.edit');
            Route::delete('/{id}/hapus', [KalenderController::class, 'hapus'])->name('operasi.kalender.hapus');
        });
    });
});
