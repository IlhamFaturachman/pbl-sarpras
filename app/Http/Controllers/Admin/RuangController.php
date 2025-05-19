<?php

namespace App\Http\Controllers\Admin;

use App\Models\RuangModel;
use App\Models\GedungModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RuangController extends Controller
{
    public function index() {
        $ruangs = RuangModel::paginate(10); 
        $gedungs = DB::table('m_gedung')->select('gedung_id', 'nama')->get();
        
        // Default empty ruang for edit (to avoid errors when no ruang is being edited)
        $editRuang = new RuangModel();
        $detailRuang = null;
        
        // Check if we're in edit mode with validation errors
        if (session('editRuangId')) {
            $editRuang = RuangModel::find(session('editRuangId'));
        }

        // Detail Ruang
        if (session('detailRuangId')) {
            $detailRuang = RuangModel::with('gedung')->find(session('detailRuangId'));
        }
    
        return view('admin.ruang.index', [
            'ruangs' => $ruangs,
            'gedungs' => $gedungs,
            'editRuang' => $editRuang,
            'detailRuang' => $detailRuang,
            'adding' => session('adding')
        ]);
    }

    public function store(Request $request) {
        $rules = [
            'kode' => 'required|string|max:10',
            'nama' => 'required|string|max:255',
            'gedung' => 'required|exists:m_gedung,gedung_id',
            'lantai' => 'required|integer|min:1|max:10'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('data.ruang')
                ->withErrors($validator)
                ->withInput()
                ->with('adding', true);
        }

        try {
            DB::beginTransaction();

            // Simpan langsung dengan gedung_id
            $data = [
                'kode' => $request->kode,
                'nama' => $request->nama,
                'lantai' => $request->lantai,
                'gedung_id' => $request->gedung
            ];

            RuangModel::create($data);

            DB::commit();
            return redirect()->route('data.ruang')->with('success', 'Data Ruang berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('data.ruang')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput()
                ->with('adding', true);
        }
    }
    
    public function show($id) {
        $ruang = RuangModel::with('gedung')->find($id);

        if (!$ruang) {
            return redirect()->route('data.ruang')->with('error', 'Ruang tidak ditemukan');
        }

        return response()->json([
            'ruang' => $ruang,
            'gedung' => $ruang->gedung
        ]);
    }

    public function edit($id) {
        $ruang = RuangModel::findOrFail($id);
        $gedung = DB::table('m_gedung')->select('gedung_id', 'nama')->get();
        
        return response()->json([
            'ruang' => $ruang,
            'gedung' => $gedung
        ]);
    }
    
    public function update(Request $request, $id) {
        $ruang = RuangModel::findOrFail($id);
        
        // Validasi input
        $rules = [
            'kode' => 'required|string|max:10',
            'nama' => 'required|string|max:255',
            'gedung' => 'required|exists:m_gedung,gedung_id',
            'lantai' => 'required|integer|min:1|max:10'
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if($validator->fails()){
            return redirect()->route('data.ruang')
                ->withErrors($validator)
                ->withInput()
                ->with('editing', true)
                ->with('editRuangId', $id);
        }
    
        try {
            DB::beginTransaction();
    
            $data = [
                'kode' => $request->kode,
                'nama' => $request->nama,
                'lantai' => $request->lantai,
                'gedung_id' => $request->gedung
            ];

            // Update ruang
            $ruang->update($data);
            
            DB::commit();
    
            return redirect()->route('data.ruang')->with('success', 'Data Ruang berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('data.ruang')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput()
                ->with('editing', true)
                ->with('editRuangId', $id);
        }
    }
    
    public function destroy($id) {
        try {
            $ruang = RuangModel::findOrFail($id);

            // Hapus ruang
            $ruang->delete();
            
            return redirect()->route('data.ruang')->with('success', 'Data Ruang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('data.ruang')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}