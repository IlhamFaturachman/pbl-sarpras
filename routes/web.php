<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FasumController;
use App\Http\Controllers\Admin\RuangController;
use App\Http\Controllers\Admin\GedungController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\User\DashboardUserController;
use App\Http\Controllers\Sarpras\DashboardSarprasController;
use App\Http\Controllers\LaporanSarprasController;
use App\Http\Controllers\User\FeedbackController;
use App\Http\Controllers\User\KerusakanController;
use App\Http\Controllers\Admin\LaporanAdminController;
use App\Models\NotifikasiModel;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// -------------------- ADMIN --------------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');

    Route::prefix('data')->group(function () {
        // User
        Route::resource('user', UserController::class)->except(['create'])->names([
            'index' => 'data.user',
            'store' => 'user.store',
            'show' => 'user.show',
            'edit' => 'user.edit',
            'update' => 'user.update',
            'destroy' => 'user.destroy'
        ]);

        // Gedung
        Route::resource('gedung', GedungController::class)->except(['create', 'show'])->names([
            'index' => 'data.gedung',
            'store' => 'gedung.store',
            'edit' => 'gedung.edit',
            'update' => 'gedung.update',
            'destroy' => 'gedung.destroy'
        ]);

        // Fasilitas Umum
        Route::resource('fasum', FasumController::class)->except(['create', 'show'])->names([
            'index' => 'data.fasum',
            'store' => 'fasum.store',
            'edit' => 'fasum.edit',
            'update' => 'fasum.update',
            'destroy' => 'fasum.destroy'
        ]);

        // Ruang
        Route::resource('ruang', RuangController::class)->except(['create'])->names([
            'index' => 'data.ruang',
            'store' => 'ruang.store',
            'show' => 'ruang.show',
            'edit' => 'ruang.edit',
            'update' => 'ruang.update',
            'destroy' => 'ruang.destroy'
        ]);

        // Periode
        Route::resource('periode', PeriodeController::class)->except(['create'])->names([
            'index' => 'data.periode',
            'store' => 'periode.store',
            'show' => 'periode.show',
            'edit' => 'periode.edit',
            'update' => 'periode.update',
            'destroy' => 'periode.destroy'
        ]);

        // Item
        Route::resource('item', ItemController::class)->except(['create', 'show'])->names([
            'index' => 'data.item',
            'store' => 'data.item.store',
            'edit' => 'data.item.edit',
            'update' => 'data.item.update',
            'destroy' => 'data.item.destroy'
        ]);

        Route::get('item/get-ruang/{gedung_id}', [ItemController::class, 'getRuangByGedung'])->name('item.get-ruang');
    });

    // Laporan
    Route::get('/laporan', [LaporanAdminController::class, 'index'])->name('admin.data.laporan');
    Route::get('/laporan/{id}/show', [LaporanAdminController::class, 'show'])->name('admin.laporan.show');
    Route::get('/laporan/export_pdf', [LaporanAdminController::class, 'export_pdf'])->name('admin.laporan.export_pdf');
});

// -------------------- USER --------------------
Route::middleware(['auth', 'role:mahasiswa|dosen|tendik'])->prefix('users')->group(function () {
    Route::get('/dashboard', [DashboardUserController::class, 'index'])->name('users.dashboard');

    // Kerusakan
    Route::get('/kerusakan', [KerusakanController::class, 'index'])->name('users.kerusakan');
    Route::get('/kerusakan/create', [KerusakanController::class, 'create'])->name('kerusakan.create');
    Route::post('/kerusakan', [KerusakanController::class, 'store'])->name('kerusakan.store');
    Route::get('/kerusakan/{id}/show', [KerusakanController::class, 'show'])->name('kerusakan.show');
    Route::delete('/kerusakan/{id}', [KerusakanController::class, 'destroy'])->name('kerusakan.destroy');
    Route::get('/kerusakan/export_pdf', [KerusakanController::class, 'exportPdf'])->name('kerusakan.export_pdf');

    // Dynamic Select
    Route::get('/kerusakan/ruang/{id}', [KerusakanController::class, 'getByGedung'])->name('kerusakan.getByGedung');
    Route::get('/kerusakan/item-by-ruang/{ruang_id}', [KerusakanController::class, 'getItemByRuang']);
    Route::get('/kerusakan/item-by-fasum/{fasum_id}', [KerusakanController::class, 'getItemByFasum']);
    // feedback
    Route::post('/kerusakan/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

});

// -------------------- SARPRAS --------------------
Route::middleware(['auth', 'role:sarpras'])->prefix('sarpras')->group(function () {
    Route::get('/dashboard', [DashboardSarprasController::class, 'index'])->name('sarpras.dashboard');

    Route::prefix('sarpras')->group(function () {
        Route::resource('item', ItemController::class)->except(['create', 'show'])->names([
            'index' => 'sarpras.item',
            'store' => 'sarpras.item.store',
            'edit' => 'sarpras.item.edit',
            'update' => 'sarpras.item.update',
            'destroy' => 'sarpras.item.destroy'
        ]);

        Route::get('/item/get-ruang/{gedung_id}', [ItemController::class, 'getRuangByGedung'])->name('item.get-ruang');
    });

    Route::prefix('laporan')->group(function () {
        // Verifikasi
        Route::get('/verifikasi', [LaporanSarprasController::class, 'indexVerifikasi'])->name('laporan.verifikasi');
        Route::get('/verifikasi/{id}/show', [LaporanSarprasController::class, 'showVerifikasi'])->name('laporan.show');
        Route::get('/verifikasi/{id}', [LaporanSarprasController::class, 'tolak'])->name('laporan.tolak');
        Route::post('/verifikasi/{id}/prioritas', [LaporanSarprasController::class, 'simpanPrioritas'])->name('laporan.simpanPrioritas');

        // Penugasan
        Route::get('/penugasan', [LaporanSarprasController::class, 'indexPenugasan'])->name('laporan.penugasan');
        Route::get('/penugasan/{id}/assign', [LaporanSarprasController::class, 'getLaporan']);
        Route::post('/penugasan/{id}/assign', [LaporanSarprasController::class, 'assign'])->name('penugasan.assign');
        Route::get('/penugasan/{id}/confirm', [LaporanSarprasController::class, 'getLaporan']);
        Route::post('/penugasan/{id}/confirm', [LaporanSarprasController::class, 'confirm'])->name('penugasan.confirm');
        Route::get('/penugasan/{id}/show', [LaporanSarprasController::class, 'showPenugasan'])->name('penugasan.show');

        // Riwayat
        Route::get('/riwayat', [LaporanSarprasController::class, 'index'])->name('laporan.riwayat');
        Route::get('/riwayat/{id}/show', [LaporanSarprasController::class, 'show'])->name('riwayat.show');
        Route::get('/riwayat/export_pdf', [LaporanSarprasController::class, 'export_pdf'])->name('riwayat.export_pdf');
    });
});

// -------------------- TEKNISI --------------------
Route::middleware(['auth', 'role:teknisi'])->prefix('teknisi')->group(function () {
    Route::get('/penugasan/dashboard', [PenugasanController::class, 'dashboard'])->name('teknisi.dashboard');
    Route::get('/penugasan', [PenugasanController::class, 'index'])->name('penugasan');
    Route::get('/penugasan/{id}', [PenugasanController::class, 'kerjakan'])->name('penugasan.kerjakan');
    Route::get('/penugasan/{id}/report', [PenugasanController::class, 'getPenugasan']);
    Route::post('/penugasan/{id}/report', [PenugasanController::class, 'report'])->name('penugasan.report');
    Route::get('/penugasan/{id}/show', [PenugasanController::class, 'show'])->name('penugasan.show');
});

// -------------------- PROFILE (UMUM) --------------------
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
});

// Menandai notifikasi sebagai sudah dibaca dan redirect ke laporan (atau kehalaman umum)
Route::get('/notifikasi/baca/{id}', function ($id) {
    $notif = NotifikasiModel::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $notif->is_read = true;
    $notif->save();

    // Cek role user dan redirect ke halaman sesuai role
    $role = Auth::user()->getRoleNames()->first(); // Ambil role pertama user

    switch ($role) {
        case 'mahasiswa':
            return redirect('/users/kerusakan');
        case 'sarpras':
            return redirect('/sarpras/laporan/verifikasi');
        case 'admin':
            return redirect('/admin/dashboard');
        case 'teknisi':
            return redirect('/teknisi/penugasan');
        case 'dosen':
            return redirect('/users/kerusakan');
        case 'tendik':
            return redirect('/users/kerusakan');
        default:
            return redirect('/dashboard'); // fallback jika role tidak dikenali
    }
})->name('notifikasi.baca');

// Auth Routes
require __DIR__ . '/auth.php';
