<?php

namespace App\Http\Controllers\Admin;

use App\Models\FasumModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FasumController extends Controller
{
    public function index() {
        $fasums = FasumModel::paginate(10); 
    
        return view('admin.fasum.index', [
            'fasums' => $fasums,
        ]);
    }

    public function store(Request $request) {
        $rules = [
            'nama' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Jika validasi gagal, kirim kembali error ke form
            return redirect()->route('data.fasum')
                ->withErrors($validator)
                ->withInput()
                ->with('adding', true);
        }

        try {
            $data = [
                'nama' => $request->nama,
            ];

            FasumModel::create($data);

            return redirect()->route('data.fasum')->with('success', 'Data Fasum berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->route('data.fasum')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput()
                ->with('adding', true);
        }
    }

    public function edit($id) {
        $fasum = FasumModel::findOrFail($id);
        
        return response()->json([
            'fasum' => $fasum,
        ]);
    }

        public function update(Request $request, $id) {
        $rules = [
            'nama' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Jika validasi gagal, kirim kembali error ke form
            return redirect()->route('data.fasum')
                ->withErrors($validator)
                ->withInput()
                ->with('editing', true);
        }

        try {
            $fasum = FasumModel::findOrFail($id);
            
            $fasum->nama = $request->nama;
            $fasum->save();

            return redirect()->route('data.fasum')->with('success', 'Data Fasum berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('data.fasum')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput()
                ->with('editing', true);
        }
    }

    public function destroy($id) {
        try {
            $fasum = fasumModel::findOrFail($id);
            $fasum->delete();
            
            return redirect()->route('data.fasum')->with('success', 'Data Fasum berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('data.fasum')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
