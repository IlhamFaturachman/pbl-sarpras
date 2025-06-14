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
        $verifikasiSudah = LaporanModel::where('status_laporan', 'Disetujui')->count();
        $verifikasiBelum = LaporanModel::where('status_laporan', 'Dikerjakan')->count();

        // Penugasan Teknisi
        $penugasanSudah = PenugasanModel::count();
        $penugasanBelum = LaporanModel::where('status_laporan', 'Disetujui')
            ->whereDoesntHave('penugasan') // relasi belum ada
            ->count();

        // Data teknisi
        $teknisi = UserModel::role('teknisi')->get();

        // Riwayat
        $riwayatSelesai = LaporanModel::where('status_laporan', 'selesai')->count();
        $riwayatBatal = LaporanModel::where('status_laporan', 'dibatalkan')->count();

        return view('sarpras.dashboard', [
            'verifikasiSudah' => $verifikasiSudah,
            'verifikasiBelum' => $verifikasiBelum,
            'penugasanSudah' => $penugasanSudah,
            'penugasanBelum' => $penugasanBelum,
            'riwayatSelesai' => $riwayatSelesai,
            'riwayatBatal' => $riwayatBatal,
            'teknisi' => $teknisi,

        ]);
    }
}
