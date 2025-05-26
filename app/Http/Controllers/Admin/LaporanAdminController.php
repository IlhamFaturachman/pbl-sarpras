<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function show() {
        $laporan = LaporanModel::paginate(10); 
    
        return view('admin.laporan.show', [
            'laporans' => $laporan,
        ]);
    }
}
