<?php

namespace App\Listeners;

use App\Events\TeknisiDitugaskan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\UserModel;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class KirimNotifKeTeknisi
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
    public function handle(TeknisiDitugaskan $event)
    {
        // Load relasi yang dibutuhkan
        $penugasan = $event->penugasan->load('laporan.kerusakan.pelapor');
        
        // Siapa teknisi yang ditugaskan?
        $teknisiId = $penugasan->teknisi_id;

        // Siapkan pesan
        $namaPelapor = optional($penugasan->laporan->kerusakan->pelapor)->nama_lengkap;
        $message = "📌 Penugasan baru! 🛠️ Anda dipercaya untuk memperbaiki laporan kerusakan dari {$namaPelapor}. 
        🆔 ID Laporan: {$penugasan->laporan_id}. Segera cek dan ambil tindakan terbaik ya!";
        
        Log::info('Listener KirimNotifKeTeknisi dijalankan', [
            'penugasan_id' => $penugasan->penugasan_id,
            'teknisi_id'   => $teknisiId,
        ]);

        // Kirim notifikasi ke teknisi, context 'dari_sarpras'
        NotificationService::send(
            [$teknisiId],
            $penugasan->laporan_id,
            $message,
            'dari_sarpras'
        );
    }
}
