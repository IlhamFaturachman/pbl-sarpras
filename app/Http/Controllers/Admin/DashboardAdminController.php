<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use App\Models\GedungModel;
use App\Models\RuangModel;
use App\Models\FasumModel;
use App\Models\PeriodeModel;
use App\Models\UserModel;
use Carbon\Carbon;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Data untuk chart total perbaikan
        $currentYear = Carbon::now()->year;
        $monthlyReports = LaporanModel::selectRaw('MONTH(tanggal_laporan) as month, COUNT(*) as total')
            ->whereYear('tanggal_laporan', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $periode = PeriodeModel::get('nama_periode');
        // dd($periode);

        // Isi bulan yang tidak ada data dengan 0
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[$i] = $monthlyReports[$i] ?? 0;
        }

        // Data untuk card growth
        $totalGedung = GedungModel::count();
        $totalRuang = RuangModel::count();
        $totalFasum = FasumModel::count();

        // Data laporan berdasarkan status
        $statusCounts = LaporanModel::selectRaw('status_laporan, COUNT(*) as total')
            ->groupBy('status_laporan')
            ->pluck('total', 'status_laporan')
            ->toArray();

        // Data teknisi
        $teknisi = UserModel::role('teknisi')->get();

        // Data laporan terbaru
        $recentReportsQuery = LaporanModel::with(['kerusakan', 'kerusakan.item.ruang', 'kerusakan.item.ruang.gedung'])
            ->orderBy('tanggal_laporan', 'desc');

        $recentReports = $recentReportsQuery->limit(5)->get();
        $totalRecentReports = $recentReportsQuery->count();

        $getStatusColor = function ($status) {
            return match ($status) {
                'Diajukan' => 'warning',
                'Disetujui' => 'info',
                'Dikerjakan' => 'warning',
                'Selesai' => 'success',
                'Ditolak' => 'danger',
                default => 'secondary',
            };
        };

        return view('admin.dashboard', [
            'monthlyData' => $monthlyData,
            'totalGedung' => $totalGedung,
            'totalRuang' => $totalRuang,
            'totalFasum' => $totalFasum,
            'statusCounts' => $statusCounts,
            'teknisi' => $teknisi,
            'recentReports' => $recentReports,
            'totalRecentReports' => $totalRecentReports,
            'getStatusColor' => $getStatusColor,
            'currentYear' => $currentYear,
            'periode' => $periode
        ]);
    }

}
