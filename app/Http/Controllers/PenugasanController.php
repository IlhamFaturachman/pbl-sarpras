<?php

namespace App\Http\Controllers;

use App\Models\PenugasanModel;
use App\Models\LaporanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class PenugasanController extends Controller
{
    public function index() {
        $userId = Auth::id();
        $penugasans = PenugasanModel::with('laporan')->where('teknisi_id', $userId)->paginate(10);
        
        $detailPenugasan = null;  

        // Ambil detail penugasan jika ada session 'detailPenugasanId'
        if (session('detailPenugasanId')) {
            $detailPenugasan = LaporanModel::with('penugasan')->find(session('detailPenugasanId'));
        }

        return view('teknisi.index', [
            'penugasans' => $penugasans,
            'detailPenugasan' => $detailPenugasan
        ]);
    }


    public function kerjakan($id) {
        $penugasan = PenugasanModel::findOrFail($id);

        $penugasan->status_penugasan = 'Progress';
        $penugasan->tanggal_mulai = Carbon::now();
        $penugasan->save();

        return redirect()->route('penugasan')->with('success', 'Penugasan dimulai');
    }

    public function getPenugasan($id)
    {
        $penugasan = PenugasanModel::findOrFail($id);
        return response()->json(['penugasan' => $penugasan]);
    }

    public function report(Request $request, $id)
    {
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
            $penugasan->save();
        }

        return redirect()->back()->with('success', 'Bukti perbaikan berhasil diunggah.');
    }
}