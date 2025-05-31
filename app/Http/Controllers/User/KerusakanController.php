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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class KerusakanController extends Controller
{
    public function index()
    {
        $kerusakans = KerusakanModel::with(['item', 'ruang.gedung', 'fasum'])->paginate(10);

        return view('users.kerusakan.index', [
            'kerusakans' => $kerusakans,
        ]);
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:m_item,item_id',
            'deskripsi_kerusakan' => 'required|string|max:255',
            'foto_kerusakan' => 'required|file|image|max:2048',
            'fasilitas_type' => 'required|in:ruang,fasum',
            'fasum_id' => 'required_if:fasilitas_type,fasum|exists:m_fasum,fasum_id',
            'ruang_id' => 'required_if:fasilitas_type,ruang|exists:m_ruang,ruang_id',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->errors(),
                ],
                422,
            );
        }

        try {
            DB::beginTransaction();

            $kerusakan = new KerusakanModel();
            $kerusakan->item_id = $request->item_id;
            $kerusakan->deskripsi_kerusakan = $request->deskripsi_kerusakan;

            // Simpan file foto kerusakan
            if ($request->hasFile('foto_kerusakan')) {
                $file = $request->file('foto_kerusakan');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('kerusakan_foto', $filename, 'public');
                $kerusakan->foto_kerusakan = $path;
            }

            // Simpan tempat kerusakan dan fasilitas_id
            $kerusakan->tempat_kerusakan = $request->fasilitas_type;

            if ($request->fasilitas_type === 'fasum') {
                $kerusakan->fasilitas_id = $request->fasum_id;
            } else {
                $kerusakan->fasilitas_id = $request->ruang_id;
            }

            $kerusakan->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data kerusakan berhasil ditambahkan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal menambahkan data kerusakan: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
}
