<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KerusakanModel;

class DashboardUserController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Mendapatkan ID user yang sedang login

        // Hitung statistik laporan untuk user yang sedang login
        $totalLaporan = LaporanModel::whereHas('kerusakan', function($query) use ($userId) {
            $query->where('pelapor_id', $userId);
        })->count();

        $laporanDiajukan = LaporanModel::whereHas('kerusakan', function($query) use ($userId) {
            $query->where('pelapor_id', $userId);
        })->where('status_laporan', 'Diajukan')->count();

        $laporanDisetujui = LaporanModel::whereHas('kerusakan', function($query) use ($userId) {
            $query->where('pelapor_id', $userId);
        })->where('status_laporan', 'Disetujui')->count();

        $laporanDitolak = LaporanModel::whereHas('kerusakan', function($query) use ($userId) {
            $query->where('pelapor_id', $userId);
        })->where('status_laporan', 'Ditolak')->count();

        $laporanDikerjakan = LaporanModel::whereHas('kerusakan', function($query) use ($userId) {
            $query->where('pelapor_id', $userId);
        })->where('status_laporan', 'Dikerjakan')->count();

        $laporanSelesai = LaporanModel::whereHas('kerusakan', function($query) use ($userId) {
            $query->where('pelapor_id', $userId);
        })->where('status_laporan', 'Selesai')->count();

        // Laporan Menunggu = Diajukan + Disetujui + Dikerjakan
        $laporanMenunggu = $laporanDiajukan + $laporanDisetujui + $laporanDikerjakan;

        // Ambil 5 laporan terbaru untuk user yang sedang login
        $laporanTerbaru = LaporanModel::with(['kerusakan.item.ruang.gedung', 'kerusakan.item.fasum'])
            ->whereHas('kerusakan', function($query) use ($userId) {
                $query->where('pelapor_id', $userId);
            })
            ->orderBy('tanggal_laporan', 'desc')
            ->limit(5)
            ->get();

        return view('users.dashboard', compact(
            'totalLaporan',
            'laporanDiajukan',
            'laporanDisetujui', 
            'laporanDitolak',
            'laporanDikerjakan',
            'laporanSelesai',
            'laporanMenunggu',
            'laporanTerbaru'
        ));
    }
}
