<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use App\Models\PenugasanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanSarprasController extends Controller
{
    public function indexPenugasan() {
        $laporans = LaporanModel::with([
            'penugasan.teknisi',
            'kerusakan.item',
            'kerusakan.ruang.gedung',
            'kerusakan.fasum',
            'pelapor'
        ])
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->where('status_laporan', 'Disetujui')->whereDoesntHave('penugasan');
            })->orWhere(function ($q) {
                $q->where('status_laporan', 'Dikerjakan')->whereHas('penugasan');
            });
        })->paginate(10);

        $detailLaporan = null;
        $teknisis = UserModel::role('Teknisi')->get();

        // Ambil detail laporan jika ada session 'detailLaporanId'
        if (session()->has('detailLaporanId')) {
            $detailLaporan = LaporanModel::with([
                'kerusakan.item',
                'kerusakan.ruang.gedung',
                'kerusakan.fasum',
                'pelapor',
                'penugasan'
            ])->find(session('detailLaporanId'));
        }

        return view('sarpras.penugasan.index', [
            'laporans' => $laporans,
            'teknisis' => $teknisis,
            'detailLaporan' => $detailLaporan
        ]);
    }

    public function getLaporan($id) {
        $laporan = LaporanModel::findOrFail($id);
        $penugasan = PenugasanModel::with('teknisi')->where('laporan_id', $id)->latest()->first();

        return response()->json([
            'laporan' => $laporan,
            'penugasan' => $penugasan
        ]);
    }

    public function assign(Request $request, $id) {
        // Validasi input
        $request->validate([
            'teknisi' => 'required|exists:m_user,user_id'
        ]);

        try {
            DB::beginTransaction();

            // Simpan data penugasan
            PenugasanModel::create([
                'laporan_id' => $id,
                'teknisi_id' => $request->teknisi,
                'status_penugasan' => null,
                'tanggal_mulai' => null,
                'tanggal_selesai' => null,
                'catatan_perbaikan' => null
            ]);

            // Ubah status laporan menjadi "Dikerjakan"
            LaporanModel::where('laporan_id', $id)->update([
                'status_laporan' => 'Dikerjakan'
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Teknisi berhasil ditugaskan dan status laporan diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan penugasan: ' . $e->getMessage());
        }
    }

    public function confirm(Request $request, $id) {
        // Validasi input
        $request->validate([
            'konfirmasi' => 'required|in:Selesai,Revisi',
            'catatan_perbaikan' => $request->konfirmasi === 'Revisi' ? 'required|string|max:255' : 'nullable|string|max:255',
            'laporan_id' => 'required|exists:m_laporan,laporan_id'
        ]);

        try {
            DB::beginTransaction();

            // Ambil data penugasan berdasarkan laporan
            $penugasan = PenugasanModel::where('laporan_id', $id)->first();

            if (!$penugasan) {
                return redirect()->back()->with('error', 'Data penugasan tidak ditemukan.');
            }

            // Update penugasan
            $penugasan->update([
                'status_penugasan' => $request->konfirmasi,
                'catatan_perbaikan' => $request->catatan_perbaikan,
            ]);

            // Update status laporan jika konfirmasi selesai
            if ($request->konfirmasi === 'Selesai') {
                LaporanModel::where('laporan_id', $request->laporan_id)->update([
                    'status_laporan' => 'Selesai'
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Konfirmasi penugasan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput(['form_type' => 'confirm'])
                ->withErrors(['error' => 'Gagal menyimpan konfirmasi: ' . $e->getMessage()]);
        }
    }

    public function showPenugasan($id) {
        $laporan = LaporanModel::with([
            'kerusakan.item',
            'kerusakan.ruang.gedung',
            'kerusakan.fasum',
            'pelapor',
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
