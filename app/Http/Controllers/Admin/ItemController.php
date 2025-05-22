<?php

namespace App\Http\Controllers\Admin;

use App\Models\ItemModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index() {
        $items = ItemModel::paginate(10); 
    
        return view('admin.item.index', [
            'items' => $items,
        ]);
    }

    public function store(Request $request) {
        $rules = [
            'nama' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Jika validasi gagal, kirim kembali error ke form
            return redirect()->route('data.item')
                ->withErrors($validator)
                ->withInput()
                ->with('adding', true);
        }

        try {
            $data = [
                'nama' => $request->nama,
            ];

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
        $item = ItemModel::findOrFail($id);
        
        return response()->json([
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id) {
        $rules = [
            'nama' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Jika validasi gagal, kirim kembali error ke form
            return redirect()->route('data.item')
                ->withErrors($validator)
                ->withInput()
                ->with('editing', true);
        }

        try {
            $item = ItemModel::findOrFail($id);
            
            $item->nama = $request->nama;
            $item->save();

            return redirect()->route('data.item')->with('success', 'Data item berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('data.item')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput()
                ->with('editing', true);
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
