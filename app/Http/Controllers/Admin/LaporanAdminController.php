<?php

namespace App\Http\Controllers\Admin;

use App\Models\LaporanModel;
use Illuminate\Http\Request;
use App\Models\KerusakanModel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

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
            'verifikator',
            'kerusakan.item.ruang.gedung', 
            'kerusakan.item.fasum',
            'kerusakan.pelapor',
            'penugasan.teknisi',
            'feedback'
        ])->find($id);

        if (!$laporan) {
            return redirect()->route('admin.data.laporan')->with('error', 'Laporan tidak ditemukan');
        }

        return response()->json([
            'laporan' => $laporan,
            'penugasan' => $laporan->penugasan,
        ]);
    }

    public function export_pdf()
    {
        ini_set('max_execution_time', 300);

        $laporan = LaporanModel::get(); 
        // dd($laporan);

        $imagePath = public_path('/assets/img/polinema.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/png;base64,' . $imageData;

        $pdf = Pdf::loadView('admin.laporan.export_pdf', [
            'laporan' => $laporan,
            'logoSrc' => $imageSrc
        ]);
    
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Laporan Kerusakan Fasilitas '.date('Y-m-d H:i:s').'.pdf');
    }  
}
