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
        // TAMBAHKAN LOG DI AWAL UNTUK CEK APAKAH METHOD INI DIPANGGIL
        \Log::info('=== STORE METHOD DIPANGGIL ===');
        \Log::info('Request Data Lengkap:', $request->all());
        // \Log::info('Location Type:', $request->location_type);
        
        // Validasi dasar
        $rules = [
            'nama' => 'required|string|max:255',
            'location_type' => 'required|in:gedung,fasum',
        ];

        // Tambahkan validasi conditional
        if ($request->location_type == 'gedung') {
            \Log::info('Validasi untuk GEDUNG');
            $rules['gedung_id'] = 'required|exists:m_gedung,gedung_id';
            $rules['ruang_id'] = 'required|exists:m_ruang,ruang_id';
        } else {
            \Log::info('Validasi untuk FASUM');
            $rules['fasum_id'] = 'required|exists:m_fasum,fasum_id';
        }

        \Log::info('Rules validasi:', $rules);

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
            \Log::error('VALIDASI GAGAL:', $validator->errors()->toArray());
            return redirect()->route('data.item')
                ->withErrors($validator)
                ->withInput()
                ->with('adding', true);
        }

        \Log::info('VALIDASI BERHASIL');

        try {
            $data = [
                'nama' => $request->nama,
            ];

            // Set data berdasarkan jenis lokasi
            if ($request->location_type == 'gedung') {
                $data['ruang_id'] = $request->ruang_id;
                $data['fasum_id'] = null; 
                \Log::info('Data untuk GEDUNG:', $data);
            } else {
                $data['fasum_id'] = $request->fasum_id;
                $data['ruang_id'] = null; 
                \Log::info('Data untuk FASUM:', $data);
            }

            \Log::info('Data yang akan disimpan:', $data);

            ItemModel::create($data);

            \Log::info('DATA BERHASIL DISIMPAN');

            return redirect()->route('data.item')->with('success', 'Data item berhasil disimpan');
        } catch (\Exception $e) {
            \Log::error('Error saat menyimpan item:', [
                'error' => $e->getMessage(), 
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'data' => $request->all()
            ]);
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
        // Validasi dasar
        $rules = [
            'nama' => 'required|string|max:255',
            'location_type' => 'required|in:gedung,fasum',
        ];

        // Tambahkan validasi conditional - KONSISTEN dengan store()
        if ($request->location_type == 'gedung') {
            $rules['gedung_id'] = 'required|exists:m_gedung,gedung_id';
            $rules['ruang_id'] = 'required|exists:m_ruang,ruang_id';
        } else {
            $rules['fasum_id'] = 'required|exists:m_fasum,fasum_id';
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
                ->with('editing', true);
        }

        try {
            $item = ItemModel::findOrFail($id);
            
            // Update data berdasarkan jenis lokasi
            $item->nama = $request->nama;
            
            if ($request->location_type == 'gedung') {
                $item->ruang_id = $request->ruang_id;
                $item->fasum_id = null;
            } else {
                $item->fasum_id = $request->fasum_id;
                $item->ruang_id = null;
            }
            
            $item->save();

            return redirect()->route('data.item')->with('success', 'Data item berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Error saat update item:', ['error' => $e->getMessage(), 'data' => $request->all()]);
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