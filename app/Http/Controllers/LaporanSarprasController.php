<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use App\Models\PenugasanModel;
use App\Models\PrioritasModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanSarprasController extends Controller
{
    public function indexPenugasan(Request $request)
    {
        $laporans = LaporanModel::with([
            'kerusakan.item',
            'kerusakan.item.ruang.gedung',
            'kerusakan.item.fasum',
            'prioritas',
            'penugasan.teknisi'
        ])
        ->where(function ($query) {
            $query->where('status_laporan', 'Disetujui')->whereDoesntHave('penugasan')
                ->orWhere(function ($q) {
                    $q->where('status_laporan', 'Dikerjakan')->whereHas('penugasan');
                });
        });

        if ($request->filled('status_penugasan')) {
            $laporans->whereHas('penugasan', function ($q) use ($request) {
                $q->where('status_penugasan', $request->status_penugasan);
            });
        }

        if ($request->filled('skor_laporan')) {
            $laporans->whereHas('penugasan', function ($q) use ($request) {
                $q->where('skor_laporan', $request->skor_laporan);
            });
        }

        $laporans = $laporans->paginate(10)->withQueryString(); // withQueryString agar filter tetap saat paginate

        $teknisis = UserModel::role('Teknisi')->get();

        return view('sarpras.penugasan.index', [
            'laporans' => $laporans,
            'teknisis' => $teknisis
        ]);
    }

    public function getLaporan($id)
    {
        $laporan = LaporanModel::findOrFail($id);
        $penugasan = PenugasanModel::with('teknisi')->where('laporan_id', $id)->latest()->first();

        return response()->json([
            'laporan' => $laporan,
            'penugasan' => $penugasan
        ]);
    }

    public function assign(Request $request, $id)
    {
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
                'status_laporan' => 'Dikerjakan',
                'tanggal_update_status' => Carbon::now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Teknisi berhasil ditugaskan dan status laporan diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan penugasan: ' . $e->getMessage());
        }
    }

    public function confirm(Request $request, $id)
    {
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
                'tanggal_update_status' => Carbon::now(),
            ]);

            // Update status laporan jika konfirmasi selesai
            if ($request->konfirmasi === 'Selesai') {
                LaporanModel::where('laporan_id', $request->laporan_id)->update([
                    'status_laporan' => 'Selesai',
                    'tanggal_update_status' => Carbon::now(),
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

    public function showPenugasan($id)
    {
        $laporan = LaporanModel::with([
            'kerusakan.item',
            'kerusakan.item.ruang.gedung',
            'kerusakan.item.fasum',
            'kerusakan.pelapor',
            'prioritas',
            'penugasan.teknisi'
        ])->find($id);

        if (!$laporan) {
            return redirect()->route('laporan.penugasan')->with('error', 'Laporan tidak ditemukan');
        }

        return response()->json([
            'laporan' => $laporan,
            'penugasan' => $laporan->penugasan,
        ]);
    }

    public function indexVerifikasi()
    {
        $laporans = LaporanModel::with([
            'kerusakan.item.ruang.gedung',
            'kerusakan.item.fasum'
        ])
        ->where('status_laporan', 'Diajukan')
        ->paginate(10);

        return view('sarpras.verifikasi.index', [
            'laporans' => $laporans
        ]);
    }

    public function showVerifikasi($id)
    {
        $laporan = LaporanModel::with([
            'verifikator',
            'kerusakan.item',
            'kerusakan.item.ruang.gedung',
            'kerusakan.item.fasum',
            'kerusakan.pelapor',
            'penugasan.teknisi'
        ])->find($id);

        if (!$laporan) {
            return redirect()->route('laporan.verifikasi')->with('error', 'Laporan tidak ditemukan');
        }

        return response()->json([
            'laporan' => $laporan,
            'penugasan' => $laporan->penugasan,
        ]);
    }

    public function tolak($id, Request $request) {
        $laporan = LaporanModel::findOrFail($id);

        $laporan->verifikator_id = auth()->user()->user_id;
        $laporan->status_laporan = 'Ditolak';
        $laporan->tanggal_update_status = Carbon::now();
        $laporan->save();

        return redirect()->route('laporan.verifikasi')->with('success', 'Laporan ditolak');
    }

    public function simpanPrioritas(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tingkat_kerusakan' => 'required|integer',
            'dampak' => 'required|integer',
            'jumlah_terdampak' => 'required|integer',
            'alternatif' => 'required|integer',
            'ancaman' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            // Data input untuk fuzzy
            $data = [
                'tingkat_kerusakan' => $request->tingkat_kerusakan,
                'dampak' => $request->dampak,
                'jumlah_terdampak' => $request->jumlah_terdampak,
                'alternatif' => $request->alternatif,
                'ancaman' => $request->ancaman,
            ];

            // Hitung skor dengan Fuzzy Tsukamoto
            $skor_laporan = $this->hitungSkorFuzzyTsukamoto($data);

            // Simpan atau update prioritas termasuk skor_laporan
            $prioritas = PrioritasModel::updateOrCreate(
                ['laporan_id' => $id],
                [
                    'tingkat_kerusakan' => $data['tingkat_kerusakan'],
                    'dampak' => $data['dampak'],
                    'jumlah_terdampak' => $data['jumlah_terdampak'],
                    'alternatif' => $data['alternatif'],
                    'ancaman' => $data['ancaman'],
                    'skor_laporan' => $skor_laporan, // disimpan ke kolom skor_laporan
                ]
            );

            // dd(auth()->user()->user_id);

            // Update status laporan
            LaporanModel::where('laporan_id', $id)->update([
                'verifikator_id' => auth()->user()->user_id,
                'status_laporan' => 'Disetujui',
                'tanggal_update_status' => Carbon::now(),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Prioritas berhasil disimpan.',
                'data' => $prioritas,
                'skor_laporan' => $skor_laporan
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menyimpan prioritas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function fuzzySegitiga($x, $a, $b, $c)
    {
        if ($x <= $a || $x >= $c) return 0;
        elseif ($x == $b) return 1;
        elseif ($x > $a && $x < $b) return ($x - $a) / ($b - $a);
        else return ($c - $x) / ($c - $b);
    }

    private function hitungSkorFuzzyTsukamoto($input)
    {
        // Nilai input
        $tk = $input['tingkat_kerusakan'];
        $td = $input['dampak'];
        $jo = $input['jumlah_terdampak'];
        $ka = $input['alternatif']; // 0 atau 1
        $tkt = $input['ancaman'];

        // Fuzzy membership
        $tk_rendah = $this->fuzzySegitiga($tk, 0, 30, 60);
        $tk_tinggi = $this->fuzzySegitiga($tk, 40, 70, 100);

        $td_rendah = $this->fuzzySegitiga($td, 0, 30, 60);
        $td_tinggi = $this->fuzzySegitiga($td, 40, 70, 100);

        $jo_rendah = $this->fuzzySegitiga($jo, 0, 30, 60);
        $jo_tinggi = $this->fuzzySegitiga($jo, 40, 70, 100);

        $ka_ada = $ka == 1 ? 1 : 0;
        $ka_tidak = $ka == 0 ? 1 : 0;

        $tkt_rendah = $this->fuzzySegitiga($tkt, 0, 30, 60);
        $tkt_tinggi = $this->fuzzySegitiga($tkt, 40, 70, 100);

        $rules = [];

        // 32 rule base kombinasi 2^5 (2 kondisi tiap variabel)
        foreach ([['rendah', $tk_rendah], ['tinggi', $tk_tinggi]] as [$tk_l, $μ_tk]) {
            foreach ([['rendah', $td_rendah], ['tinggi', $td_tinggi]] as [$td_l, $μ_td]) {
                foreach ([['rendah', $jo_rendah], ['tinggi', $jo_tinggi]] as [$jo_l, $μ_jo]) {
                    foreach ([['tidak', $ka_tidak], ['ada', $ka_ada]] as [$ka_l, $μ_ka]) {
                        foreach ([['rendah', $tkt_rendah], ['tinggi', $tkt_tinggi]] as [$tkt_l, $μ_tkt]) {
                            $α = min($μ_tk, $μ_td, $μ_jo, $μ_ka, $μ_tkt);

                            if ($α > 0) {
                                // Penentuan z (output prioritas: 0–100)
                                // Rendah = turun (nilai rendah jika kondisi buruk sedikit)
                                // Tinggi = naik (nilai tinggi jika kondisi buruk banyak)
                                $z = match ([$tk_l, $td_l, $jo_l, $ka_l, $tkt_l]) {
                                    ['rendah','rendah','rendah','ada','rendah'] => 20,
                                    ['tinggi','tinggi','tinggi','tidak','tinggi'] => 90,
                                    default => $this->nilaiOutput($tk_l, $td_l, $jo_l, $ka_l, $tkt_l),
                                };

                                $rules[] = ['α' => $α, 'z' => $z];
                            }
                        }
                    }
                }
            }
        }

        // Defuzzifikasi
        $z_total = array_sum(array_map(fn($r) => $r['α'] * $r['z'], $rules));
        $α_total = array_sum(array_column($rules, 'α'));

        // Fallback jika semua α = 0, ambil rule berdasarkan nilai tertinggi dari masing-masing variabel
        if ($α_total == 0) {
            // Ambil nilai maksimal dari fuzzy untuk tiap variabel (selain alternatif)
            $μs = [
                'tk' => max($tk_rendah, $tk_tinggi),
                'td' => max($td_rendah, $td_tinggi),
                'jo' => max($jo_rendah, $jo_tinggi),
                'ka' => max($ka_tidak, $ka_ada),
                'tkt' => max($tkt_rendah, $tkt_tinggi),
            ];

            // Ambil label kondisi dominan
            $conds = [
                'tk' => $tk_rendah >= $tk_tinggi ? 'rendah' : 'tinggi',
                'td' => $td_rendah >= $td_tinggi ? 'rendah' : 'tinggi',
                'jo' => $jo_rendah >= $jo_tinggi ? 'rendah' : 'tinggi',
                'ka' => $ka_tidak >= $ka_ada ? 'tidak' : 'ada',
                'tkt' => $tkt_rendah >= $tkt_tinggi ? 'rendah' : 'tinggi',
            ];

            // Estimasi satu rule default
            $z = $this->nilaiOutput($conds['tk'], $conds['td'], $conds['jo'], $conds['ka'], $conds['tkt']);
            return round($z, 2);
        }

        return round($z_total / $α_total, 2);
    }

    private function nilaiOutput($tk, $td, $jo, $ka, $tkt)
    {
        // Sederhana: hitung berapa banyak "tinggi" / "tidak"
        $nilai = 0;
        foreach ([$tk, $td, $jo, $tkt] as $val)
            $nilai += $val === 'tinggi' ? 1 : 0;
        $nilai += $ka === 'tidak' ? 1 : 0;

        // Konversi ke nilai z (prioritas)
        return match ($nilai) {
            0 => 20,
            1 => 30,
            2 => 45,
            3 => 60,
            4 => 75,
            5 => 90,
        };
    }

    public function index()
    {
        $laporans = LaporanModel::with([
            'kerusakan.item',
            'kerusakan.ruang.gedung',
            'kerusakan.fasum'
        ])
        ->whereIn('status_laporan', ['Selesai', 'Ditolak'])
        ->paginate(10);

        return view('sarpras.riwayat.index', [
            'laporans' => $laporans
        ]);
    }

    public function show($id)
    {
        $laporan = LaporanModel::with([
            'kerusakan.item',
            'kerusakan.item.ruang.gedung',
            'kerusakan.item.fasum',
            'kerusakan.pelapor',
            'penugasan.teknisi',
            'prioritas',
            'feedback'
        ])->find($id);

        if (!$laporan) {
            return redirect()->route('laporan.riwayat')->with('error', 'Laporan tidak ditemukan');
        }

        return response()->json([
            'laporan' => $laporan,
            'penugasan' => $laporan->penugasan,
        ]);
    }

    public function export_pdf()
    {
        ini_set('max_execution_time', 300);

        $laporan = LaporanModel::get()->whereIn('status_laporan', ['Selesai', 'Ditolak']); 

        $imagePath = public_path('/assets/img/polinema.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/png;base64,' . $imageData;

        $pdf = Pdf::loadView('sarpras.riwayat.export_pdf', [
            'laporan' => $laporan,
            'logoSrc' => $imageSrc
        ]);
    
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Laporan Kerusakan Fasilitas '.date('Y-m-d H:i:s').'.pdf');
    }  
}
