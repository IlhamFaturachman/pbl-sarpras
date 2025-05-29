<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FasumController;
use App\Http\Controllers\Admin\RuangController;
use App\Http\Controllers\Admin\GedungController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\LaporanAdminController;
use App\Http\Controllers\User\KerusakanController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\LaporanSarprasController;

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

// admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::prefix('data')->group(function () {
        // user
        Route::get('/user', [UserController::class, 'index'])->name('data.user');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{id}/show', [UserController::class, 'show'])->name('user.show');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        // gedung
        Route::get('/gedung', [GedungController::class, 'index'])->name('data.gedung');
        Route::post('/gedung', [GedungController::class, 'store'])->name('gedung.store');
        Route::get('/gedung/{id}/edit', [GedungController::class, 'edit'])->name('gedung.edit');
        Route::put('/gedung/{id}', [GedungController::class, 'update'])->name('gedung.update');
        Route::delete('/gedung/{id}', [GedungController::class, 'destroy'])->name('gedung.destroy');

        // fasilitas umum
        Route::get('/fasum', [FasumController::class, 'index'])->name('data.fasum');
        Route::post('/fasum', [FasumController::class, 'store'])->name('fasum.store');
        Route::get('/fasum/{id}/edit', [FasumController::class, 'edit'])->name('fasum.edit');
        Route::put('/fasum/{id}', [FasumController::class, 'update'])->name('fasum.update');
        Route::delete('/fasum/{id}', [FasumController::class, 'destroy'])->name('fasum.destroy');

        // ruang
        Route::get('/ruang', [RuangController::class, 'index'])->name('data.ruang');
        Route::post('/ruang', [RuangController::class, 'store'])->name('ruang.store');
        Route::get('/ruang/{id}/show', [RuangController::class, 'show'])->name('ruang.show');
        Route::get('/ruang/{id}/edit', [RuangController::class, 'edit'])->name('ruang.edit');
        Route::put('/ruang/{id}', [RuangController::class, 'update'])->name('ruang.update');
        Route::delete('/ruang/{id}', [RuangController::class, 'destroy'])->name('ruang.destroy');

        // periode
        Route::get('/periode', [PeriodeController::class, 'index'])->name('data.periode');
        Route::post('/periode', [PeriodeController::class, 'store'])->name('periode.store');
        Route::get('/periode/{id}/show', [PeriodeController::class, 'show'])->name('periode.show');
        Route::get('/periode/{id}/edit', [PeriodeController::class, 'edit'])->name('periode.edit');
        Route::put('/periode/{id}', [PeriodeController::class, 'update'])->name('periode.update');
        Route::delete('/periode/{id}', [PeriodeController::class, 'destroy'])->name('periode.destroy');

        // item
        Route::get('/item', [ItemController::class, 'index'])->name('data.item');
        Route::post('/item', [ItemController::class, 'store'])->name('item.store');
        Route::get('/item/{id}/edit', [ItemController::class, 'edit'])->name('item.edit');
        Route::put('/item/{id}', [ItemController::class, 'update'])->name('item.update');
        Route::delete('/item/{id}', [ItemController::class, 'destroy'])->name('item.destroy');
    });
    Route::get('/laporan', [LaporanAdminController::class, 'index'])->name('admin.data.laporan');
    Route::get('/laporan/{id}/show', [LaporanAdminController::class, 'show'])->name('admin.laporan.show');
});

Route::middleware(['auth', 'role:mahasiswa|dosen|tendik'])->prefix('users')->group(function () {
    Route::get('/dashboard', function () {
        return view('users.dashboard');
    })->name('users.dashboard');
    Route::prefix('users')->group(function () {

        // kerusakan
        Route::get('/kerusakan', [KerusakanController::class, 'index'])->name('users.kerusakan');
        Route::get('/kerusakan/create', [KerusakanController::class, 'create'])->name('kerusakan.create');
        Route::post('/kerusakan', [KerusakanController::class, 'store'])->name('kerusakan.store');
        Route::get('/kerusakan/ruang/{id}', [KerusakanController::class, 'getByGedung'])->name('kerusakan.getByGedung');
        Route::delete('/kerusakan/{id}', [KerusakanController::class, 'destroy'])->name('kerusakan.destroy');
    });
});





// sarpras
Route::middleware(['auth', 'role:sarpras'])->prefix('sarpras')->group(function () {
    Route::get('/dashboard', function () {
        return view('sarpras.dashboard');
    })->name('sarpras.dashboard');
    Route::prefix('laporan')->group(function () {
        // verifikasi
        Route::get('/verifikasi', [LaporanSarprasController::class, 'indexVerifikasi'])->name('laporan.verifikasi');
        Route::get('/verifikasi/{id}/show', [LaporanSarprasController::class, 'showVerifikasi'])->name('laporan.show');

        // penugasan
        Route::get('/penugasan', [LaporanSarprasController::class, 'indexPenugasan'])->name('laporan.penugasan');
        Route::get('/penugasan/{id}/assign', [LaporanSarprasController::class, 'getLaporan']);
        Route::post('/penugasan/{id}/assign', [LaporanSarprasController::class, 'assign'])->name('penugasan.assign');
        Route::get('/penugasan/{id}/confirm', [LaporanSarprasController::class, 'getLaporan']);
        Route::post('/penugasan/{id}/confirm', [LaporanSarprasController::class, 'confirm'])->name('penugasan.confirm');
        Route::get('/penugasan/{id}/show', [LaporanSarprasController::class, 'showPenugasan'])->name('penugasan.show');

        // riwayat
        Route::get('/riwayat', [LaporanSarprasController::class, 'index'])->name('laporan.riwayat');
        Route::get('/riwayat/{id}/show', [LaporanSarprasController::class, 'show'])->name('riwayat.show');
    });
});

// teknisi
Route::middleware(['auth', 'role:teknisi'])->prefix('teknisi')->group(function () {
    Route::get('/penugasan/dashboard', [PenugasanController::class, 'dashboard'])->name('teknisi.dashboard');
    Route::get('/penugasan', [PenugasanController::class, 'index'])->name('penugasan');
    Route::get('/penugasan/{id}', [PenugasanController::class, 'kerjakan'])->name('penugasan.kerjakan');
    Route::get('/penugasan/{id}/report', [PenugasanController::class, 'getPenugasan']);
    Route::post('/penugasan/{id}/report', [PenugasanController::class, 'report'])->name('penugasan.report');
    Route::get('/penugasan/{id}/show', [PenugasanController::class, 'show'])->name('penugasan.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
});

require __DIR__ . '/auth.php';