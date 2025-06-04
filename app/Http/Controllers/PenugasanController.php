<?php

namespace App\Http\Controllers;

use App\Models\PenugasanModel;
use App\Models\LaporanModel;
use App\Models\FeedbackModel;
use App\Models\PeriodeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class PenugasanController extends Controller
{
    public function dashboard(Request $request)
    {
        $teknisiId = Auth::id();

        // Ambil semua penugasan selesai untuk teknisi ini
        $penugasanSelesai = PenugasanModel::with('laporan.periode')
            ->where('teknisi_id', $teknisiId)
            ->where('status_penugasan', 'Selesai')
            ->get();

        // Kelompokkan berdasarkan nama_periode
        $perbaikanPerPeriode = $penugasanSelesai
            ->groupBy(function ($item) {
                return optional($item->laporan->periode)->nama_periode ?? 'Unknown';
            })
            ->map(function ($items) {
                return $items->count();
            });

        // Ambil label dan data chart
        $chartLabels = $perbaikanPerPeriode->keys()->toArray();
        $chartData = $perbaikanPerPeriode->values()->toArray();
        $totalPerbaikan = array_sum($chartData);

        // Perbaikan yang belum selesai
        $tanggunganPerbaikan = PenugasanModel::where('teknisi_id', $teknisiId)
            ->where('status_penugasan', '!=', 'Selesai')
            ->count();

        // Rata-rata rating feedback
        $averageRating = FeedbackModel::join('m_penugasan', 'm_feedback.laporan_id', '=', 'm_penugasan.laporan_id')
            ->where('m_penugasan.teknisi_id', $teknisiId)
            ->avg('rating') ?? 0;

        return view('teknisi.dashboard', compact(
            'chartLabels',
            'chartData',
            'totalPerbaikan',
            'tanggunganPerbaikan',
            'averageRating'
        ));
    }

    public function index() {
        $userId = Auth::id();
        $penugasans = PenugasanModel::with('laporan')->where('teknisi_id', $userId)->paginate(10);     

        $detailLaporan = null;  

        // Ambil detail laporan jika ada session 'detailLaporanId'
        if (session()->has('detailLaporanId')) {
            $detailLaporan = LaporanModel::with([
                'kerusakan.item',
                'kerusakan.item.ruang.gedung',
                'kerusakan.item.fasum',
                'pelapor',
                'feedback',
                'penugasan'
            ])->find(session('detailLaporanId'));
        }

        return view('teknisi.index', [
            'penugasans' => $penugasans,
            'detailLaporan' => $detailLaporan
        ]);
    }

    public function kerjakan($id) {
        $penugasan = PenugasanModel::findOrFail($id);

        $penugasan->status_penugasan = 'Progress';
        $penugasan->tanggal_mulai = Carbon::now();
        $penugasan->save();

        return redirect()->route('penugasan')->with('success', 'Penugasan dimulai');
    }

    public function getPenugasan($id) {
        $penugasan = PenugasanModel::findOrFail($id);
        return response()->json(['penugasan' => $penugasan]);
    }

    public function report(Request $request, $id) {
        // Validasi input
        $request->validate([
            'bukti_perbaikan' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cari data penugasan
        $penugasan = PenugasanModel::findOrFail($id);

        // Simpan file ke storage
        if ($request->hasFile('bukti_perbaikan')) {
            $file = $request->file('bukti_perbaikan');
            $path = $file->store('bukti_perbaikan', 'public');

            // Hapus bukti lama jika ada
            if ($penugasan->bukti_perbaikan) {
                Storage::disk('public')->delete($penugasan->bukti_perbaikan);
            }

            // Simpan ke database
            $penugasan->bukti_perbaikan = $path;
            $penugasan->status_penugasan = "Menunggu";
            $penugasan->tanggal_selesai = Carbon::now();
            $penugasan->save();
        }

        return redirect()->back()->with('success', 'Bukti perbaikan berhasil diunggah.');
    }

    public function show($id) {
        $laporan = LaporanModel::with([
            'kerusakan.item',
            'kerusakan.item.ruang.gedung',
            'kerusakan.item.fasum',
            'pelapor',
            'feedback',
            'penugasan.teknisi'
        ])->find($id);

        if (!$laporan) {
            return redirect()->route('penugasan')->with('error', 'Laporan tidak ditemukan');
        }

        return response()->json([
            'laporan' => $laporan,
            'penugasan' => $laporan->penugasan,
        ]);
    }
}