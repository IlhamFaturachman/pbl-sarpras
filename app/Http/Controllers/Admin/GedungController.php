<?php

namespace App\Http\Controllers\Admin;

use App\Models\GedungModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GedungController extends Controller
{
    public function index() {
        $gedungs = GedungModel::paginate(10);

        return view('admin.gedung.index', [
            'gedungs' => $gedungs,
        ]);
    }

    public function store(Request $request) {
        $rules = [
            'kode' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('data.gedung')
                ->withErrors($validator)
                ->withInput()
                ->with('adding', true);
        }

        try {
            $data = [
                'kode' => $request->kode,
                'nama' => $request->nama,
            ];

            GedungModel::create($data);

            return redirect()->route('data.gedung')->with('success', 'Data Gedung berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->route('data.gedung')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput()
                ->with('adding', true);
        }
    }

    public function edit($id) {
        $gedung = GedungModel::findOrFail($id);

        return response()->json([
            'gedung' => $gedung,
        ]);
    }

    public function update(Request $request, $id) {
        $rules = [
            'kode' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('data.gedung')
                ->withErrors($validator)
                ->withInput()
                ->with('editing', true);
        }

        try {
            $gedung = GedungModel::findOrFail($id);
            $gedung->kode = $request->kode;
            $gedung->nama = $request->nama;
            $gedung->save();

            return redirect()->route('data.gedung')->with('success', 'Data Gedung berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('data.gedung')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput()
                ->with('editing', true);
        }
    }

    public function destroy($id) {
        try {
            $gedung = GedungModel::findOrFail($id);
            $gedung->delete();

            return redirect()->route('data.gedung')->with('success', 'Data Gedung berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('data.gedung')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
