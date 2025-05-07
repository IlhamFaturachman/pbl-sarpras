<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RuangController;
use App\Http\Controllers\Admin\GedungController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\FasilitasController;

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

        Route::get('/gedung', [GedungController::class, 'index'])->name('data.gedung');
        Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('data.fasilitas');
        Route::get('/ruang', [RuangController::class, 'index'])->name('data.ruang');
        Route::get('/periode', [PeriodeController::class, 'index'])->name('data.periode');
    });
});

// mahasiswa
Route::middleware(['auth', 'role:mahasiswa|dosen|tendik'])->prefix('users')->group(function () {
    Route::get('/dashboard', function () {
        return view('users.dashboard');
    })->name('users.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
