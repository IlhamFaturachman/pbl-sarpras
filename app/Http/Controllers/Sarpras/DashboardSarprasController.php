<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanModel;
use App\Models\PenugasanModel;
use App\Models\UserModel;


class DashboardSarprasController extends Controller
{
public function index()
{
    // Verifikasi Laporan
    $verifikasiBelum = LaporanModel::where('status_laporan', 'Diajukan')->count(); // Atau status awal laporan
    $verifikasiSudah = LaporanModel::where('status_laporan', 'Disetujui')->count();

    // Penugasan Teknisi
    $penugasanSudah = PenugasanModel::count();
    $penugasanBelum = LaporanModel::where('status_laporan', 'Disetujui')
        ->whereDoesntHave('penugasan')
        ->count();

    // Data teknisi
    $teknisi = UserModel::role('teknisi')->get();

    // Riwayat
    $riwayatSelesai = LaporanModel::where('status_laporan', 'Selesai')->count();
    $riwayatTolak = LaporanModel::where('status_laporan', 'Ditolak')->count();

    return view('sarpras.dashboard', [
        'verifikasiSudah' => $verifikasiSudah,
        'verifikasiBelum' => $verifikasiBelum,
        'penugasanSudah' => $penugasanSudah,
        'penugasanBelum' => $penugasanBelum,
        'riwayatSelesai' => $riwayatSelesai,
        'riwayatTolak' => $riwayatTolak,
        'teknisi' => $teknisi,
    ]);
}
}