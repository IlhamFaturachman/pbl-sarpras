<?php

namespace App\Http\Controllers\Admin;

use Log;
use App\Models\ItemModel;
use App\Models\FasumModel;
use App\Models\RuangModel;
use App\Models\GedungModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index() {
        $items = ItemModel::with('ruang.gedung', 'fasum')->paginate(10); 
        $gedungs = GedungModel::all();
        $fasums = FasumModel::all();
    
        return view('admin.item.index', [
            'items' => $items,
            'gedungs' => $gedungs,
            'fasums' => $fasums
        ]);
    }

    public function getRuangByGedung($gedung_id) {
        try {
            $ruangs = RuangModel::where('gedung_id', $gedung_id)->get();
            return response()->json($ruangs);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

    public function store(Request $request) {
        
        if (request()->location_type == 'gedung') {
            $rules = [
                'ruang_id' => 'required|exists:m_ruang,ruang_id',
                'nama_item_ruang' => 'required|string|max:255',
            ];
        } else {
            $rules = [
                'fasum_id' => 'required|exists:m_fasum,fasum_id',
                'nama_item_fasum' => 'required|string|max:255',
            ];
        }

        $messages = [
            'location_type.required' => 'Jenis lokasi harus dipilih',
            'location_type.in' => 'Jenis lokasi tidak valid',
            'gedung_id.required' => 'Gedung harus dipilih',
            'gedung_id.exists' => 'Gedung yang dipilih tidak valid',
            'ruang_id.required' => 'Ruang harus dipilih',
            'ruang_id.exists' => 'Ruang yang dipilih tidak valid',
            'fasum_id.required' => 'Fasilitas umum harus dipilih',
            'fasum_id.exists' => 'Fasilitas umum yang dipilih tidak valid',
            'nama.required' => 'Nama item harus diisi',
            'nama.max' => 'Nama item maksimal 255 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('data.item')
                ->withErrors($validator)
                ->withInput()
                ->with('adding', true);
        }

        // dd($request->all());

        try {
            // Set data berdasarkan jenis lokasi
            if ($request->location_type == 'gedung') {
                $data['nama'] = $request->nama_item_ruang;
                $data['ruang_id'] = $request->ruang_id;
                $data['fasum_id'] = null; 
            } else {
                $data['nama'] = $request->nama_item_fasum;
                $data['fasum_id'] = $request->fasum_id;
                $data['ruang_id'] = null; 
            }
            
            ItemModel::create($data);

            return redirect()->route('data.item')->with('success', 'Data item berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->route('data.item')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput()
                ->with('adding', true);
        }
    }

    public function edit($id) {
        $item = ItemModel::with('ruang.gedung', 'fasum')->findOrFail($id);
        $gedungs = GedungModel::all();
        $fasums = FasumModel::all();
        
        $ruangs = [];
        if ($item->ruang_id && $item->ruang) {
            $ruangs = RuangModel::where('gedung_id', $item->ruang->gedung_id)->get();
        }
        
        return response()->json([
            'item' => $item,
            'gedungs' => $gedungs,
            'fasums' => $fasums,
            'ruangs' => $ruangs,
        ]);
    }

    public function update(Request $request, $id) {
        if (request()->location_type == 'gedung') {
            $rules = [
                'ruang_id' => 'required|exists:m_ruang,ruang_id',
                'nama_item_ruang' => 'required|string|max:255',
            ];
        } else {
            $rules = [
                'fasum_id' => 'required|exists:m_fasum,fasum_id',
                'nama_item_fasum' => 'required|string|max:255',
            ];
        }

        $messages = [
            'location_type.required' => 'Jenis lokasi harus dipilih',
            'location_type.in' => 'Jenis lokasi tidak valid',
            'gedung_id.required' => 'Gedung harus dipilih',
            'gedung_id.exists' => 'Gedung yang dipilih tidak valid',
            'ruang_id.required' => 'Ruang harus dipilih',
            'ruang_id.exists' => 'Ruang yang dipilih tidak valid',
            'fasum_id.required' => 'Fasilitas umum harus dipilih',
            'fasum_id.exists' => 'Fasilitas umum yang dipilih tidak valid',
            'nama_item_ruang.required' => 'Nama item harus diisi',
            'nama_item_ruang.max' => 'Nama item maksimal 255 karakter',
            'nama_item_fasum.required' => 'Nama item harus diisi',
            'nama_item_fasum.max' => 'Nama item maksimal 255 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->route('data.item')
                ->withErrors($validator)
                ->withInput()
                ->with('editing', true)
                ->with('editing_item_id', $id);
        }

        try {
            $item = ItemModel::findOrFail($id);
            
            if ($request->location_type == 'gedung') {
                $item->nama = $request->nama_item_ruang;
                $item->ruang_id = $request->ruang_id;
                $item->fasum_id = null;
            } else {
                $item->nama = $request->nama_item_fasum;
                $item->fasum_id = $request->fasum_id;
                $item->ruang_id = null;
            }
            
            $item->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data item berhasil diperbarui'
                ]);
            }

            return redirect()->route('data.item')->with('success', 'Data item berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('data.item')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput()
                ->with('editing', true)
                ->with('editing_item_id', $id);
        }
    }

    public function destroy($id) {
        try {
            $item = ItemModel::findOrFail($id);
            $item->delete();
            
            return redirect()->route('data.item')->with('success', 'Data item berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('data.item')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}