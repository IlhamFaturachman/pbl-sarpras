<?php

namespace App\Listeners;

use App\Events\LaporanDibuat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\UserModel;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class KirimNotifKeSarpras
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LaporanDibuat $event)
    {
        $laporan = $event->laporan;

    // Ambil semua user dengan role 'sarpras'
        $sarprasUserIds = UserModel::role('sarpras')->pluck('user_id')->toArray();

        $message = "👷‍♂️ Hai Tim Sarpras! 📢 Laporan kerusakan baru telah dikirim oleh {$laporan->kerusakan->pelapor->nama_lengkap}. "
        . "📝 Deskripsi: \"{$laporan->kerusakan->deskripsi_kerusakan}\". "
        . "📦 Barang: {$laporan->kerusakan->item->nama}. "
        . "Mohon segera verifikasi dan tindak lanjuti demi kelancaran fasilitas.";

        Log::info('Listener KirimNotifKeSarpras dijalankan', [
            'laporan_id' => $event->laporan->laporan_id,
        ]);

        NotificationService::send($sarprasUserIds, $laporan->laporan_id, $message, 'dari_mahasiswa');
    }
}
