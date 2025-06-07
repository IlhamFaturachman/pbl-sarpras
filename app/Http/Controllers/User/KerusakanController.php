<?php

namespace App\Http\Controllers\User;

use App\Models\KerusakanModel;
use App\Models\RuangModel;
use App\Models\GedungModel;
use App\Models\FasumModel;
use App\Models\ItemModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use App\Models\PeriodeModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf; 

class KerusakanController extends Controller
{
    public function index()
    {
        $laporans = LaporanModel::join('m_kerusakan', 'm_laporan.kerusakan_id', '=', 'm_kerusakan.kerusakan_id')
            ->where('m_kerusakan.pelapor_id', auth()->id())
            ->select('m_laporan.*') 
            ->paginate(10);

        return view('users.kerusakan.index', compact('laporans'));
    }

    public function create()
    {
        $items = ItemModel::all();
        $gedungs = GedungModel::all();
        $fasums = FasumModel::all();

        return response()->json([
            'items' => $items,
            'gedungs' => $gedungs,
            'fasums' => $fasums,
        ]);
    }

    public function getByGedung($gedung_id)
    {
        $ruangs = RuangModel::where('gedung_id', $gedung_id)->get();

        return response()->json(['ruangs' => $ruangs]);
    }

    public function getItemByRuang($ruang_id)
    {
        $items = ItemModel::where('ruang_id', $ruang_id)->get();

        return response()->json(['items' => $items]);
    }

    public function getItemByFasum($fasum_id)
    {
        $items = ItemModel::where('fasum_id', $fasum_id)->get();

        return response()->json(['items' => $items]);
    }

    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'fasilitas_type' => 'required|in:ruang,fasum',
            'item_id' => 'required|exists:m_item,item_id',
            'deskripsi_kerusakan' => 'required|string',
            'foto_kerusakan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'fasum_id' => 'nullable|required_if:fasilitas_type,fasum|exists:m_fasum,fasum_id'
        ]);

        try {
            DB::beginTransaction();

            // 1. Simpan ke tabel m_kerusakan
            $kerusakan = new KerusakanModel();
            $kerusakan->pelapor_id = auth()->id(); // Ambil ID user yang login
            $kerusakan->item_id = $request->item_id;
            $kerusakan->deskripsi_kerusakan = $request->deskripsi_kerusakan;

            // Simpan file foto kerusakan
            if ($request->hasFile('foto_kerusakan')) {
                $file = $request->file('foto_kerusakan');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('kerusakan_foto', $filename, 'public');
                $kerusakan->foto_kerusakan = $path;
            }

            $kerusakan->save();

            // 2. Simpan ke tabel m_laporan
            $periode = PeriodeModel::where('nama_periode', now()->year)->first();

            if (!$periode) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Periode untuk tahun ini belum tersedia.',
                ], 500);
            }

            $laporan = new LaporanModel();
            $laporan->laporan_id = 'LAP' . mt_rand(100000, 999999); // Generate random ID dengan prefix LAP
            $laporan->kerusakan_id = $kerusakan->kerusakan_id;
            $laporan->verifikator_id = null;
            $laporan->status_laporan = 'Diajukan';
            $laporan->tanggal_laporan = now()->toDateString(); // Hanya tanggal tanpa waktu
            $laporan->periode_id = $periode->periode_id;
            $laporan->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Laporan kerusakan berhasil ditambahkan',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan laporan kerusakan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id){
        try {
            $kerusakan = KerusakanModel::findOrFail($id);
            $kerusakan->delete();

            return response()->json([
                'success' => true,
                'message' => 'laporan kerusakan berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal menghapus laporan kerusakan: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function show($id) {
        $laporan = LaporanModel::with([
            'verifikator',
            'kerusakan.item.ruang.gedung', 
            'kerusakan.item.fasum',
            'kerusakan.pelapor',
            'penugasan.teknisi'
        ])->find($id);

        if (!$laporan) {
            return redirect()->route('users.kerusakan')->with('error', 'Laporan tidak ditemukan');
        }

        return response()->json([
            'laporan' => $laporan,
            'penugasan' => $laporan->penugasan,
        ]);
    }
    
    public function exportPdf()
    {
        $kerusakans = KerusakanModel::with(['item', 'ruang.gedung', 'fasum'])->where('pelapor_id', auth()->id())->get();

        $imagePath = public_path('/assets/img/polinema.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/png;base64,' . $imageData;

        $pdf = Pdf::loadView('users.kerusakan.pdf', compact('kerusakans', 'imageSrc'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Kerusakan Fasilitas '.date('Y-m-d H:i:s').'.pdf');        
    }
}
