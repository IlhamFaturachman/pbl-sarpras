<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\FeedbackModel;
use App\Models\UserModel;
use App\Models\LaporanModel;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi input
            $validated = $request->validate([
                'laporan_id' => 'required|integer|exists:laporan,laporan_id',
                'user_id' => 'required|integer|exists:users,id',
                'rating' => 'required|integer|min:1|max:5',
                'komentar' => 'required|string|max:1000',
            ]);

            $feedback = new FeedbackModel();
            $feedback->laporan_id = $validated['laporan_id'];
            $feedback->user_id = $validated['user_id'];
            $feedback->rating = $validated['rating'];
            $feedback->komentar = $validated['komentar'];
            $feedback->tanggal_feedback = Carbon::now();

            $feedback->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Feedback berhasil dikirim.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal mengirim feedback: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
}