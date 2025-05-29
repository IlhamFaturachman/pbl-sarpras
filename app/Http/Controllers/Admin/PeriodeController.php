<?php

namespace App\Http\Controllers\Admin;

use App\Models\PeriodeModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = PeriodeModel::paginate(10);

        return view('admin.periode.index', [
            'periodes' => $periodes,
        ]);
    }
    public function store(Request $request)
    {
        //  dd($request->all());
        $rules = [
            'nama_periode' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('data.periode')->withErrors($validator)->withInput()->with('adding', true);
        }

        try {
            $data = [
                'nama_periode' => $request->nama_periode,
            ];

            PeriodeModel::create($data);

            return redirect()->route('data.periode')->with('success', 'Data Periode berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()
                ->route('data.periode')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput()
                ->with('adding', true);
        }
    }

    public function show($id) {
        $periode = PeriodeModel::find($id);

        if (!$periode) {
            return redirect()->route('data.periode')->with('error', 'Periode tidak ditemukan');
        }

        return response()->json([
            'periode' => $periode,
        ]);
    }

    public function edit($id)
    {
        $periode = PeriodeModel::findOrFail($id);

        return response()->json([
            'periode' => $periode,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nama_periode' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('data.periode')->withErrors($validator)->withInput()->with('editing', true);
        }

        try {
            $periode = PeriodeModel::findOrFail($id);
            $periode->nama_periode = $request->nama_periode;
            $periode->save();

            return redirect()->route('data.periode')->with('success', 'Data Periode berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->route('data.periode')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput()
                ->with('editing', true);
        }
    }

    public function destroy($id)
    {
        try {
            $periode = PeriodeModel::findOrFail($id);
            $periode->delete();

            return redirect()->route('data.periode')->with('success', 'Data Periode berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('data.periode')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
