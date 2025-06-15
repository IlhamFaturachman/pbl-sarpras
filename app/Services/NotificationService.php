<?php

namespace App\Services;

use App\Models\NotifikasiModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public static function send(array $userIds, $laporanId, $isi, $context = null)
    {
        foreach ($userIds as $userId) {

            $user = UserModel::find($userId);

            // Tentukan URL berdasarkan context dan role
            $url = self::resolveUrl($user, $context, $laporanId);

            // Simpan ke database
            NotifikasiModel::create([
                'user_id' => $userId,
                'laporan_id' => $laporanId,
                'isi_notifikasi' => $isi,
                'is_read' => false,
            ]);

            // Kirim ke OneSignal
            self::sendToOneSignal($userId, $isi, $url);
        }
    }

    protected static function sendToOneSignal($userId, $message, $url)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . config('services.onesignal.rest_api_key'),
            'Content-Type' => 'application/json',
        ])->post('https://onesignal.com/api/v1/notifications', [
            'app_id' => config('services.onesignal.app_id'),
            'include_external_user_ids' => [(string) $userId],
            'contents' => ['en' => $message],
            'url' => $url,
        ]);

        if ($response->failed()) {
            Log::error('❌ Gagal kirim notifikasi ke OneSignal', [
                'user_id' => $userId,
                'response' => $response->json(),
            ]);
        } else {
            Log::info('✅ Notifikasi berhasil dikirim ke OneSignal', [
                'user_id' => $userId,
                'response' => $response->json(),
            ]);
        }
    }

    protected static function resolveUrl($user, $context, $laporanId)
    {
        if ($user->hasRole('sarpras')) {
            if ($context === 'dari_mahasiswa') {
                return url("/sarpras/laporan/verifikasi");
            } elseif ($context === 'dari_teknisi') {
                return url("/sarpras/laporan/penugasan");
            }
        }

        if ($user->hasRole('teknisi')) {
            return url("/teknisi/penugasan");
        }

        if ($user->hasRole('mahasiswa')) {
            return url("/users/kerusakan");
        }

        return url('/dashboard');
    }
}
