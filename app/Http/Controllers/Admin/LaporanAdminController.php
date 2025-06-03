<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KerusakanModel;
use App\Models\LaporanModel;
use Illuminate\Http\Request;

class LaporanAdminController extends Controller
{
    public function index() {
        $laporan = LaporanModel::paginate(10); 
    
        return view('admin.laporan.index', [
            'laporans' => $laporan,
        ]);
    }

    public function show($id) {
        $laporan = LaporanModel::with([
            'kerusakan.item',
            'kerusakan.ruang.gedung',
            'kerusakan.fasum',
            'pelapor',
            'penugasan.teknisi'
        ])->find($id);

        if (!$laporan) {
            return redirect()->route('laporan.penugasan')->with('error', 'Laporan tidak ditemukan');
        }

        return response()->json([
            'laporan' => $laporan,
            'penugasan' => $laporan->penugasan,
        ]);
    }
}
